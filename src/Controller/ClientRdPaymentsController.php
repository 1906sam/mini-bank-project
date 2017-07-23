<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Utility\Hash;

/**
 * ClientRdPayments Controller
 *
 * @property \App\Model\Table\ClientRdPaymentsTable $ClientRdPayments
 * @property bool|object Common
 */
class ClientRdPaymentsController extends AppController
 {
    public $components = array('Common');
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ClientRd']
        ];

        $clientRdPayments = $this->paginate($this->ClientRdPayments);
        $clientRd = $this->loadModel('ClientRd');
        $clientDetails = $this->loadModel('ClientDetails');
        //$clientData = $clientDetails->get($id);
        $clientRdValue = $clientRd->find('all')->toArray();
        $clientRdData = $clientRd->find('list',[
            'keyField' => 'id',
            'valueField' => 'client_id'
        ])->toArray();

        if(!empty($clientRdData))
        {
            $clientData = $clientDetails->find('list',[
                'keyField' => 'id',
                'valueField' => 'client_name',
                'conditions' => ['id in' => $clientRdData]
            ])->toArray();

            foreach ($clientRdValue as $rdValue)
                    $clientRdDateValues[$rdValue['id']] = $rdValue['created_date'];

            $clientRdInfo = null;
            foreach (array_keys($clientRdData) as $key)
            {
                $clientRdInfo[$key] = $clientData[$clientRdData[$key]];
            }

        }
        $this->set(compact(['clientRdPayments','clientRdInfo','clientRdData','clientRdDateValues']));
        $this->set('_serialize', ['clientRdPayments']);
    }

    /**
     * View method
     *
     * @param string|null $id Client Rd Payment id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $clientRdPayment = $this->ClientRdPayments->get($id, [
            'contain' => ['ClientRd']
        ]);

        $this->set('clientRdPayment', $clientRdPayment);
        $this->set('_serialize', ['clientRdPayment']);
    }

    /**
     * Add method
     *
     * @param null $id
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($id=null)
    {
        $clientRd = $this->loadModel('ClientRd');
        $clientDetails = $this->loadModel('ClientDetails');
        $clientRdData = $clientRd->get($id);
        $clientData = $clientDetails->get($clientRdData['client_id']);
//        debug($clientRdData);
//        die();
        $clientRdPaymentEntity = $this->ClientRdPayments->newEntity();
        $clientRdPaymentModel = $this->loadModel('ClientRdPayments');
        $clientRdPaymentData = $clientRdPaymentModel->find('all',[
            'conditions' => ['client_rd_id' => $clientRdData['id']],
            'order' => ['created_date' => 'desc']
        ])->first();

        if ($this->request->is('post')) {
            if(isset($_POST['select_date']) && $_POST['select_date'] != '')
            {
                $this->request->data['created_date'] = $_POST['select_date'];
//                $today = $_POST['select_date'];
            }
//            else
//            {
//                $today = date_create(date("Y-m-d H:i:s")); //->modify('-1 year');
//            }

            if(empty($clientRdPaymentData))
            {
                $this->request->data['final_rd_amount'] = (int)$clientRdData['rd_amount'];
                $this->request->data['interest_on_rd'] = (int)(($clientRdData['rd_amount'] * $clientRdData['rate_of_interest'])/100);
            }
            else
            {
                $today = date_create($_POST['select_date']);//->modify('-1 year');
                $dateDiff = date_diff($today, $clientRdPaymentData['created_date']);

                if($dateDiff->y == 0 && $dateDiff->m == 0)
                {
                    $todayDate = date("Y-m-d");
                    $lastPaymentDate = date_parse_from_format("Y-m-d",$clientRdPaymentData['created_date']->format("Y-m-d"));
                    $todayDate = date_parse_from_format("Y-m-d",$todayDate);
                    $diffMonth = $todayDate['month'] - $lastPaymentDate['month'];
                }
                else if($dateDiff->y >= 1)
                    $diffMonth = $dateDiff->y*12 + $dateDiff->m;
                else
                    $diffMonth = $dateDiff->m;

                $noOfPaymentReceived = $clientRdPaymentData['final_rd_amount']/$clientRdData['rd_amount'];
                $clientRdPaymentDataFirst = $clientRdPaymentModel->find('all', [
                    'conditions' => ['client_rd_id' => $id,'status' => 1],
                    'order' => ['created_date' => 'asc']
                ])->first();

                $firstTermOfInterest = $clientRdPaymentDataFirst['interest_on_rd'] + (($noOfPaymentReceived+1) -1)*$clientRdPaymentDataFirst['interest_on_rd'];
                $this->request->data['final_rd_amount'] = (int)($_POST['installment_received'] + $clientRdPaymentData['final_rd_amount']);
                $this->request->data['interest_on_rd'] = ($diffMonth*(2*$firstTermOfInterest + ($diffMonth-1)*$clientRdPaymentDataFirst['interest_on_rd']))/2;
            }

            $clientRdPayment = $this->ClientRdPayments->patchEntity($clientRdPaymentEntity, $this->request->data);
            try
            {
                $saveData = $this->ClientRdPayments->save($clientRdPayment);
            }
            catch (\Exception $e)
            {
                print_r($e->getMessage());
                die();
            }
            if ($saveData) {
                $this->Flash->success(__('The client rd payment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The client rd payment could not be saved. Please, try again.'));
        }

        $clientRdInfo = array(
            $clientRdData['id'] => $clientData['client_name']
        );

        if(!empty($clientRdPaymentData))
            $penalty = $this->Common->calculatePenalty($clientRdData,$clientRdPaymentData);
        if($penalty < 0)
        {
            $this->Flash->error(__('Payment already made for this month.'));

            return $this->redirect(['controller' => 'ClientRd','action' => 'index']);

        }

        $rd_amount = $clientRdData['rd_amount'];
        $lastPayment = $clientRdPaymentData['created_date'];
        if($clientRdData['status'] == 0)
            $this->set(compact('penalty','rd_amount'));

        $this->set(compact('clientRdPaymentEntity','clientRdInfo','lastPayment'));
        $this->set('_serialize', ['clientRdPayment']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Client Rd Payment id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $clientRdPayment = $this->ClientRdPayments->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $clientRdPayment = $this->ClientRdPayments->patchEntity($clientRdPayment, $this->request->data);
            if ($this->ClientRdPayments->save($clientRdPayment)) {
                $this->Flash->success(__('The client rd payment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The client rd payment could not be saved. Please, try again.'));
        }
        $clientRd = $this->loadModel('ClientRd');
        $clientRdData = $clientRd->get($clientRdPayment['client_rd_id']);
        $clientDetails = $this->loadModel('ClientDetails');
        $clientData = $clientDetails->get($clientRdData['client_id']);

        $clientRdInfo[$clientData['id']] = $clientData['client_name'];
        $this->set(compact('clientRdPayment', 'clientRdInfo'));
        $this->set('_serialize', ['clientRdPayment','clientRdInfo']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Client Rd Payment id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $clientRdPayment = $this->ClientRdPayments->get($id);
        if ($this->ClientRdPayments->delete($clientRdPayment)) {
            $this->Flash->success(__('The client rd payment has been deleted.'));
        } else {
            $this->Flash->error(__('The client rd payment could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
