<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * BatchUser Controller
 *
 * @property \App\Model\Table\BatchUserTable $BatchUser
 */
class BatchUserController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Batches', 'ClientDetails']
        ];
        $batchUser = $this->paginate($this->BatchUser);

        $this->set(compact('batchUser'));
        $this->set('_serialize', ['batchUser']);
    }

    /**
     * View method
     *
     * @param string|null $id Batch User id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $batchUser = $this->BatchUser->get($id, [
            'contain' => ['Batches', 'ClientDetails']
        ]);

        $this->set('batchUser', $batchUser);
        $this->set('_serialize', ['batchUser']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $batchUser = $this->BatchUser->newEntity();
        if ($this->request->is('post')) {
            $batchUser = $this->BatchUser->patchEntity($batchUser, $this->request->data);
            if ($this->BatchUser->save($batchUser)) {
                $this->Flash->success(__('The batch user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The batch user could not be saved. Please, try again.'));
        }
        $batches = $this->BatchUser->Batches->find('list', ['limit' => 200]);
        $clientDetails = $this->BatchUser->ClientDetails->find('list', ['limit' => 200]);
        $this->set(compact('batchUser', 'batches', 'clientDetails'));
        $this->set('_serialize', ['batchUser']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Batch User id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $batchUser = $this->BatchUser->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $batchUser = $this->BatchUser->patchEntity($batchUser, $this->request->data);
            if ($this->BatchUser->save($batchUser)) {
                $this->Flash->success(__('The batch user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The batch user could not be saved. Please, try again.'));
        }
        $batches = $this->BatchUser->Batches->find('list', ['limit' => 200]);
        $clientDetails = $this->BatchUser->ClientDetails->find('list', ['limit' => 200]);
        $this->set(compact('batchUser', 'batches', 'clientDetails'));
        $this->set('_serialize', ['batchUser']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Batch User id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $batchUser = $this->BatchUser->get($id);
        if ($this->BatchUser->delete($batchUser)) {
            $this->Flash->success(__('The batch user has been deleted.'));
        } else {
            $this->Flash->error(__('The batch user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
