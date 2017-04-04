<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ClientDetails Controller
 *
 * @property \App\Model\Table\ClientDetailsTable $ClientDetails
 */
class ClientDetailsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $clientDetails = $this->paginate($this->ClientDetails);

        $this->set(compact('clientDetails'));
        $this->set('_serialize', ['clientDetails']);
    }

    /**
     * View method
     *
     * @param string|null $id Client Detail id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $clientDetail = $this->ClientDetails->get($id, [
            'contain' => []
        ]);

        $this->set('clientDetail', $clientDetail);
        $this->set('_serialize', ['clientDetail']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $clientDetail = $this->ClientDetails->newEntity();
        if ($this->request->is('post')) {
            $clientDetail = $this->ClientDetails->patchEntity($clientDetail, $this->request->data);
            if ($this->ClientDetails->save($clientDetail)) {
                $this->Flash->success(__('The client detail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The client detail could not be saved. Please, try again.'));
        }
        $this->set(compact('clientDetail'));
        $this->set('_serialize', ['clientDetail']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Client Detail id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $clientDetail = $this->ClientDetails->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $clientDetail = $this->ClientDetails->patchEntity($clientDetail, $this->request->data);
            if ($this->ClientDetails->save($clientDetail)) {
                $this->Flash->success(__('The client detail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The client detail could not be saved. Please, try again.'));
        }
        $this->set(compact('clientDetail'));
        $this->set('_serialize', ['clientDetail']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Client Detail id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $clientDetail = $this->ClientDetails->get($id);
        if ($this->ClientDetails->delete($clientDetail)) {
            $this->Flash->success(__('The client detail has been deleted.'));
        } else {
            $this->Flash->error(__('The client detail could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
