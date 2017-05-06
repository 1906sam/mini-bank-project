<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ClientFd Controller
 *
 * @property \App\Model\Table\ClientFdTable $ClientFd
 */
class ClientFdController extends AppController
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
        $clientFd = $this->paginate($this->ClientFd);

        $this->set(compact('clientFd'));
        $this->set('_serialize', ['clientFd']);
    }

    /**
     * View method
     *
     * @param string|null $id Client Fd id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $clientFd = $this->ClientFd->get($id, [
            'contain' => ['ClientDetails']
        ]);

        $this->set('clientFd', $clientFd);
        $this->set('_serialize', ['clientFd']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
//    public function add()
//    {
//        $clientFd = $this->ClientFd->newEntity();
//        if ($this->request->is('post')) {
//            $clientFd = $this->ClientFd->patchEntity($clientFd, $this->request->data);
//            if ($this->ClientFd->save($clientFd)) {
//                $this->Flash->success(__('The client fd has been saved.'));
//
//                return $this->redirect(['action' => 'index']);
//            }
//            $this->Flash->error(__('The client fd could not be saved. Please, try again.'));
//        }
//        $clientDetails = $this->ClientFd->ClientDetails->find('list', ['limit' => 200]);
//        $this->set(compact('clientFd', 'clientDetails'));
//        $this->set('_serialize', ['clientFd']);
//    }
    public function add()
    {
        $clientFd = $this->ClientFd->newEntity();
        if ($this->request->is('post')) {
                $clientFd = $this->ClientFd->patchEntity($clientFd, $this->request->data);
                if ($this->ClientFd->save($clientFd)) {
                    $this->Flash->success(__('Client\'s FD has been saved.'));

                    return $this->redirect('/viewFdInformation');
                }
                $this->Flash->error(__('Client\'s FD could not be saved. Please, try again.'));
        }
        $clientDetails = $this->ClientFd->ClientDetails->find('all', [
            'conditions' => ['status' => 1]
        ])->toArray();

        foreach ($clientDetails as $data)
        {
            $clientDataArray[$data['id']] = $data['client_name'].'('.$data['mobile'].')';
        }

        $this->set('clientDataArray',$clientDataArray);
        $this->set('clientFd',$clientFd);
        $this->set('_serialize', ['clientFd','clientDetails']);
    }


    /**
     * Edit method
     *
     * @param string|null $id Client Fd id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $clientFd = $this->ClientFd->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $clientFd = $this->ClientFd->patchEntity($clientFd, $this->request->data);
            if ($this->ClientFd->save($clientFd)) {
                $this->Flash->success(__('Client\'s FD has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Client\'s FD could not be saved. Please, try again.'));
        }
        $clientDetails = $this->ClientFd->ClientDetails->find('all', [
            'conditions' => ['status' => 1,'id' => $clientFd['client_id']]
        ])->toArray();

        foreach ($clientDetails as $data)
        {
            $clientDataArray[$data['id']] = $data['client_name'].'('.$data['mobile'].')';
        }

        $this->set('clientDataArray',$clientDataArray);
        $this->set(compact('clientFd', 'clientDetails'));
        $this->set('_serialize', ['clientFd']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Client Fd id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $clientFd = $this->ClientFd->get($id);
        if ($this->ClientFd->delete($clientFd)) {
            $this->Flash->success(__('The client fd has been deleted.'));
        } else {
            $this->Flash->error(__('The client fd could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
