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

        $this->set(compact('clientLoanPayments'));
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
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $clientLoanPayment = $this->ClientLoanPayments->newEntity();
        if ($this->request->is('post')) {
            $clientLoanPayment = $this->ClientLoanPayments->patchEntity($clientLoanPayment, $this->request->data);
            if ($this->ClientLoanPayments->save($clientLoanPayment)) {
                $this->Flash->success(__('The client loan payment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The client loan payment could not be saved. Please, try again.'));
        }
        $clientLoan = $this->ClientLoanPayments->ClientLoan->find('list', ['limit' => 200]);
        $this->set(compact('clientLoanPayment', 'clientLoan'));
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
        $clientLoan = $this->ClientLoanPayments->ClientLoan->find('list', ['limit' => 200]);
        $this->set(compact('clientLoanPayment', 'clientLoan'));
        $this->set('_serialize', ['clientLoanPayment']);
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
