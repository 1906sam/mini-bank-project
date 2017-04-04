<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ClientRdPayments Controller
 *
 * @property \App\Model\Table\ClientRdPaymentsTable $ClientRdPayments
 */
class ClientRdPaymentsController extends AppController
{

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

        $this->set(compact('clientRdPayments'));
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
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $clientRdPayment = $this->ClientRdPayments->newEntity();
        if ($this->request->is('post')) {
            $clientRdPayment = $this->ClientRdPayments->patchEntity($clientRdPayment, $this->request->data);
            if ($this->ClientRdPayments->save($clientRdPayment)) {
                $this->Flash->success(__('The client rd payment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The client rd payment could not be saved. Please, try again.'));
        }
        $clientRd = $this->ClientRdPayments->ClientRd->find('list', ['limit' => 200]);
        $this->set(compact('clientRdPayment', 'clientRd'));
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
        $clientRd = $this->ClientRdPayments->ClientRd->find('list', ['limit' => 200]);
        $this->set(compact('clientRdPayment', 'clientRd'));
        $this->set('_serialize', ['clientRdPayment']);
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
