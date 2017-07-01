<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ClientLoan Controller
 *
 * @property \App\Model\Table\ClientLoanTable $ClientLoan
 */
class ClientLoanController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ClientDetails']
        ];
        $clientLoanPaymentModel = $this->loadModel('ClientLoanPayments');
        $clientLoanModel = $this->loadModel('ClientLoan');
        $clientLoanData = $clientLoanModel->find('all')->toArray();
        
        foreach ($clientLoanData as $data)
        {
            $clientLoanPaymentData = $clientLoanPaymentModel->find('all',[
                'conditions' => ['client_loan_id' => $data['id']],
                'order' => ['created_date' => 'desc']
            ])->first();

            $clientLoanLastPayment[$data['id']] = $clientLoanPaymentData['created_date'];
        }
        $clientLoan = $this->paginate($this->ClientLoan);

        $this->set(compact('clientLoan','clientLoanLastPayment'));
        $this->set('_serialize', ['clientLoan']);
    }

    /**
     * View method
     *
     * @param string|null $id Client Loan id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $clientLoan = $this->ClientLoan->get($id, [
            'contain' => ['ClientDetails', 'ClientLoanPayments']
        ]);

        $this->set('clientLoan', $clientLoan);
        $this->set('_serialize', ['clientLoan']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $clientLoan = $this->ClientLoan->newEntity();
        $clientRdModel = $this->loadModel('ClientRd');
        if ($this->request->is('post')) {
            $clientRdData = $clientRdModel->find('all',[
                'conditions' => ['client_id' => $_POST['client_id'],'status' => 0]
            ])->toArray();

            if(empty($clientRdData))
            {
                $this->Flash->error(__('Loan cannot be given without RD.'));
                return $this->redirect(['action' => 'add']);
            }

            if(isset($_POST['select_date']) && $_POST['select_date'] != '')
                $this->request->data['created_date'] = $_POST['select_date'];
            if(isset($_POST['closing_date']) && $_POST['closing_date'] != '')
                $this->request->data['modified_date'] = $_POST['closing_date'];

            $clientLoan = $this->ClientLoan->patchEntity($clientLoan, $this->request->data);
            try
            {
                if ($this->ClientLoan->save($clientLoan)) {
                    $this->Flash->success(__('The client loan has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
                else
                    $this->Flash->error(__('The client loan could not be saved. Please, try again.'));
                
            }catch (\PDOException $e)
            {
                if ($e->errorInfo[1] == 1062)
                    $this->Flash->error(__('Loan already present for the selected Client.'));
            }
        }
        $clientDetails = $this->ClientLoan->ClientDetails->find('all', [
            'conditions' => ['status' => 1]
        ])->toArray();

        foreach ($clientDetails as $data)
        {
            $clientDataArray[$data['id']] = $data['client_name'].'('.$data['mobile'].')';
        }

        $this->set('clientDataArray',$clientDataArray);
        $this->set(compact('clientLoan', 'clientDetails'));
        $this->set('_serialize', ['clientLoan']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Client Loan id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $clientLoan = $this->ClientLoan->get($id, [
            'contain' => []
        ]);

        $initialStatus = $clientLoan['status'];

        if ($this->request->is(['patch', 'post', 'put'])) {
            if(isset($_POST['select_date']) && $_POST['select_date'] != '')
                $this->request->data['created_date'] = $_POST['select_date'];
            if(isset($_POST['closing_date']) && $_POST['closing_date'] != '')
                $this->request->data['modified_date'] = $_POST['closing_date'];

            $clientLoanPaymentsModel = $this->loadModel('ClientLoanPayments');
            $clientLoanPatched = $this->ClientLoan->patchEntity($clientLoan, $this->request->data);

            if ($this->ClientLoan->save($clientLoanPatched)) {
                if($initialStatus == 0 && $_POST['status'] == 1)
                {
                    $clientLoanPaymentsData = $clientLoanPaymentsModel->updateAll(['status' => 0],['client_loan_id' => $id]);
                }
                else if($initialStatus == 1 && $_POST['status'] == 0)
                {
                    $clientLoanPaymentsData = $clientLoanPaymentsModel->updateAll(['status' => 1],['client_loan_id' => $id]);
                }
                $this->Flash->success(__('Client\'s loan has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Client\'s loan could not be saved. Please, try again.'));
        }
        $clientDetails = $this->ClientLoan->ClientDetails->find('all', [
            'conditions' => ['status' => 1,'id' => $clientLoan['client_id']]
        ])->toArray();

        foreach ($clientDetails as $data)
        {
            $clientDataArray[$data['id']] = $data['client_name'].'('.$data['mobile'].')';
        }

        $this->set(compact('clientLoan', 'clientDataArray'));
        $this->set('_serialize', ['clientLoan']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Client Loan id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $clientLoan = $this->ClientLoan->get($id);
        if ($this->ClientLoan->delete($clientLoan)) {
            $this->Flash->success(__('The client loan has been deleted.'));
        } else {
            $this->Flash->error(__('The client loan could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
