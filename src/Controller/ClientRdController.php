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
        $batchModel = $this->loadModel('Batches');
        $clientRd = $this->paginate($this->ClientRd);
        $batchData = $batchModel->newEntity();
        
        $this->set(compact('clientRd','batchData'));
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
            try
            {
                if ($this->ClientRd->save($clientRd)) {

                    $this->Flash->success(__('Client\'s RD details has been saved.'));

                    return $this->redirect('/viewRdInformation');
                }
            } catch(\PDOException $e)
            {
                if($e->errorInfo[1] == 1062)
                    $this->Flash->error(__('RD already present for the selected user.'));
            }
            $this->Flash->error(__('Client\'s RD could not be saved. Please, try again.'));
        }
        $clientDetails = $this->ClientRd->ClientDetails->find('all', [
            'conditions' => ['status' => 1]
        ])->toArray();

        foreach ($clientDetails as $data)
        {
            $clientDataArray[$data['id']] = $data['client_name'].'('.$data['mobile'].')';
        }

        $this->set(compact('clientRd', 'clientDataArray'));
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

        $initialStatus = $clientRd['status'];

        if ($this->request->is(['patch', 'post', 'put'])) {
            if($clientRd['status'] == 1 && $_POST['status'] == 0)
                $this->request->data['created_date'] = date("Y-m-d H:i:s");

            $clientRdPaymentsModel = $this->loadModel('ClientRdPayments');

            $clientRdPatched = $this->ClientRd->patchEntity($clientRd, $this->request->data);

            if ($this->ClientRd->save($clientRdPatched)) {
                if($initialStatus == 0 && $_POST['status'] == 1)
                {
                    $clientRdPaymentsData = $clientRdPaymentsModel->updateAll(['status' => 0],['client_rd_id' => $id]);
                }
                else if($initialStatus == 1 && $_POST['status'] == 0)
                {
                    $clientRdPaymentsData = $clientRdPaymentsModel->updateAll(['status' => 1],['client_rd_id' => $id]);
                }
                $this->Flash->success(__('Client\'s RD has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Client\'s RD could not be saved. Please, try again.'));
        }
        $clientDetails = $this->ClientRd->ClientDetails->find('list', [
            'limit' => 200,
            'keyField' => 'id',
            'valueField' => 'client_name',
            'conditions' => ['id' => $clientRd->client_id]
        ]);
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
