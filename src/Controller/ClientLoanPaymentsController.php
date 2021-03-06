<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ClientLoanPayments Controller
 *
 * @property \App\Model\Table\ClientLoanPaymentsTable $ClientLoanPayments
 */
class ClientLoanPaymentsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ClientLoan']
        ];
        $clientLoanPayments = $this->paginate($this->ClientLoanPayments);
        $clientLoan = $this->loadModel('ClientLoan');
        $clientDetails = $this->loadModel('ClientDetails');
        //$clientData = $clientDetails->get($id);
        $clientLoanData = $clientLoan->find('list',[
            'keyField' => 'id',
            'valueField' => 'client_id'
        ])->toArray();

        if(!empty($clientLoanData))
        {
            $clientData = $clientDetails->find('list',[
                'keyField' => 'id',
                'valueField' => 'client_name',
                'conditions' => ['id in' => $clientLoanData]
            ])->toArray();

            $clientLoanInfo = null;
            foreach ($clientLoanData as $data)
            {
                $clientLoanInfo[array_search($data,$clientLoanData)] = $clientData[$data];
            }
        }

        $this->set(compact('clientLoanPayments','clientLoanInfo','clientLoanData'));
        $this->set('_serialize', ['clientLoanPayments']);
    }

    /**
     * View method
     *
     * @param string|null $id Client Loan Payment id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $clientLoanPayment = $this->ClientLoanPayments->get($id, [
            'contain' => ['ClientLoan']
        ]);

        $this->set('clientLoanPayment', $clientLoanPayment);
        $this->set('_serialize', ['clientLoanPayment']);
    }

    /**
     * Add method
     *
     * @param null $id
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($id=null)
    {
        $clientLoanPayment = $this->ClientLoanPayments->newEntity();
        $clientLoan = $this->loadModel('ClientLoan');
        $clientLoanPaymentInstance = $this->loadModel('ClientLoanPayments');
        $clientDetails = $this->loadModel('ClientDetails');

        $loanDataOriginal = $clientLoan->get($id);
        $clientData = $clientDetails->get($loanDataOriginal['client_id']);
        $loanAfterwards = $clientLoanPaymentInstance->find('all',[
            'conditions' => ['client_loan_id' => $loanDataOriginal['id']],
            'order' => ['created_date' => 'desc']
        ])->toArray();
        
        if ($this->request->is('post')) {
            if(isset($_POST['select_date']) && $_POST['select_date'] != '')
                $this->request->data['created_date'] = $_POST['select_date'];

            if(empty($loanAfterwards))
                $this->request->data['final_loan_amount'] = ($loanDataOriginal['loan_amount'] - $_POST['installment_received']);  // - $_POST['interest_received']);
            else
                $this->request->data['final_loan_amount'] = ($loanAfterwards[0]['final_loan_amount'] - $_POST['installment_received']); // - $_POST['interest_received']);

            $clientLoanPayment = $this->ClientLoanPayments->patchEntity($clientLoanPayment, $this->request->data);
            if ($this->ClientLoanPayments->save($clientLoanPayment)) {
                $this->Flash->success(__('The client loan payment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The client loan payment could not be saved. Please, try again.'));
        }
        $clientLoanInfo = array(
            $id => $clientData['client_name']
        );

        $this->set('loanDataOriginal',$loanDataOriginal);
        $this->set(compact('clientLoanPayment', 'clientLoanInfo','loanAfterwards'));
        $this->set('_serialize', ['clientLoanPayment']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Client Loan Payment id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $clientLoanPayment = $this->ClientLoanPayments->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $clientLoanPayment = $this->ClientLoanPayments->patchEntity($clientLoanPayment, $this->request->data);
            if ($this->ClientLoanPayments->save($clientLoanPayment)) {
                $this->Flash->success(__('The client loan payment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The client loan payment could not be saved. Please, try again.'));
        }
        $clientLoan = $this->loadModel('ClientLoan');
        $clientLoanData = $clientLoan->get($clientLoanPayment['client_loan_id']);
        $clientDetails = $this->loadModel('ClientDetails');
        $clientData = $clientDetails->get($clientLoanData['client_id']);

        $clientLoanInfo[$clientData['id']] = $clientData['client_name'];

        $this->set(compact('clientLoanPayment', 'clientLoanInfo'));
        $this->set('_serialize', ['clientLoanPayment','clientLoanInfo']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Client Loan Payment id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $clientLoanPayment = $this->ClientLoanPayments->get($id);
        if ($this->ClientLoanPayments->delete($clientLoanPayment)) {
            $this->Flash->success(__('The client loan payment has been deleted.'));
        } else {
            $this->Flash->error(__('The client loan payment could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
