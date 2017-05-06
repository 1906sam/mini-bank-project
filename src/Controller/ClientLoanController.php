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
        $clientLoan = $this->paginate($this->ClientLoan);

        $this->set(compact('clientLoan'));
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
        if ($this->request->is('post')) {
            $clientLoan = $this->ClientLoan->patchEntity($clientLoan, $this->request->data);
            if ($this->ClientLoan->save($clientLoan)) {
                $this->Flash->success(__('The client loan has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The client loan could not be saved. Please, try again.'));
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
            if($clientLoan['status'] == 1 && $_POST['status'] == 0)
                $this->request->data['created_date'] = date("Y-m-d H:i:s");

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
