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
        $clientDetails = $this->ClientLoan->ClientDetails->find('list', ['limit' => 200]);
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
        if ($this->request->is(['patch', 'post', 'put'])) {
            $clientLoan = $this->ClientLoan->patchEntity($clientLoan, $this->request->data);
            if ($this->ClientLoan->save($clientLoan)) {
                $this->Flash->success(__('The client loan has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The client loan could not be saved. Please, try again.'));
        }
        $clientDetails = $this->ClientLoan->ClientDetails->find('list', ['limit' => 200]);
        $this->set(compact('clientLoan', 'clientDetails'));
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
