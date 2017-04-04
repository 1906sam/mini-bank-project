<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ClientRd Controller
 *
 * @property \App\Model\Table\ClientRdTable $ClientRd
 */
class ClientRdController extends AppController
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
        $clientRd = $this->paginate($this->ClientRd);

        $this->set(compact('clientRd'));
        $this->set('_serialize', ['clientRd']);
    }

    /**
     * View method
     *
     * @param string|null $id Client Rd id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $clientRd = $this->ClientRd->get($id, [
            'contain' => ['ClientDetails', 'ClientRdPayments']
        ]);

        $this->set('clientRd', $clientRd);
        $this->set('_serialize', ['clientRd']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $clientRd = $this->ClientRd->newEntity();
        if ($this->request->is('post')) {
            $clientRd = $this->ClientRd->patchEntity($clientRd, $this->request->data);
            if ($this->ClientRd->save($clientRd)) {
                $this->Flash->success(__('The client rd has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The client rd could not be saved. Please, try again.'));
        }
        $clientDetails = $this->ClientRd->ClientDetails->find('list', ['limit' => 200]);
        $this->set(compact('clientRd', 'clientDetails'));
        $this->set('_serialize', ['clientRd']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Client Rd id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $clientRd = $this->ClientRd->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $clientRd = $this->ClientRd->patchEntity($clientRd, $this->request->data);
            if ($this->ClientRd->save($clientRd)) {
                $this->Flash->success(__('The client rd has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The client rd could not be saved. Please, try again.'));
        }
        $clientDetails = $this->ClientRd->ClientDetails->find('list', ['limit' => 200]);
        $this->set(compact('clientRd', 'clientDetails'));
        $this->set('_serialize', ['clientRd']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Client Rd id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $clientRd = $this->ClientRd->get($id);
        if ($this->ClientRd->delete($clientRd)) {
            $this->Flash->success(__('The client rd has been deleted.'));
        } else {
            $this->Flash->error(__('The client rd could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
