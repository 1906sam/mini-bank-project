<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Batches Controller
 *
 * @property \App\Model\Table\BatchesTable $Batches
 */
class BatchesController extends AppController
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
        $batches = $this->paginate($this->Batches);

        $this->set(compact('batches'));
        $this->set('_serialize', ['batches']);
    }

    /**
     * View method
     *
     * @param string|null $id Batch id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $batch = $this->Batches->get($id, [
            'contain' => ['ClientDetails']
        ]);

        $this->set('batch', $batch);
        $this->set('_serialize', ['batch']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $batch = $this->Batches->newEntity();
        if ($this->request->is('post')) {
            $batch = $this->Batches->patchEntity($batch, $this->request->data);
            if ($this->Batches->save($batch)) {
                $this->Flash->success(__('The batch has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The batch could not be saved. Please, try again.'));
        }
        $clientDetails = $this->Batches->ClientDetails->find('list', ['limit' => 200]);
        $this->set(compact('batch', 'clientDetails'));
        $this->set('_serialize', ['batch']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Batch id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $batch = $this->Batches->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $batch = $this->Batches->patchEntity($batch, $this->request->data);
            if ($this->Batches->save($batch)) {
                $this->Flash->success(__('The batch has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The batch could not be saved. Please, try again.'));
        }
        $clientDetails = $this->Batches->ClientDetails->find('list', ['limit' => 200]);
        $this->set(compact('batch', 'clientDetails'));
        $this->set('_serialize', ['batch']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Batch id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $batch = $this->Batches->get($id);
        if ($this->Batches->delete($batch)) {
            $this->Flash->success(__('The batch has been deleted.'));
        } else {
            $this->Flash->error(__('The batch could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
