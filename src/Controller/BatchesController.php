<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;

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
        $batches = $this->paginate($this->Batches);
        $batchUserModel = $this->loadModel('BatchUser');
        $clientRdModel = $this->loadModel('ClientRd');

        $batchData = $this->Batches->find('all')->toArray();
        $batchId = Hash::extract($batchData,'{n}.id');

        foreach ($batchId as $data)
        {
            $batchUserData = $batchUserModel->find('all',[
                'conditions' => ['batch_id' => $data]
            ])->toArray();

            $batchClientData[$data] = sizeof($batchUserData);

            $clientId = Hash::extract($batchUserData,'{n}.client_id');

            $clientRdData = $clientRdModel->find('all',[
                'conditions' => ['client_id in' => $clientId]
            ])->sumOf('rd_amount');

            $batchRdData[$data] = $clientRdData;
        }
        $this->set(compact('batches','batchClientData','batchRdData'));
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
//        $batch = $this->Batches->get($id, [
//            'contain' => ['BatchUser']
//        ]);
//
//        $this->set('batch', $batch);
//        $this->set('_serialize', ['batch']);

        $total_amount = null;
        $batchUserModel = $this->loadModel('BatchUser');
        $clientRdModel = $this->loadModel('ClientRd');
        $clientRdPaymentModel = TableRegistry::get('ClientRdPayments');
        $batchUserData = $batchUserModel->find('all',[
            'contain' => ['Batches', 'ClientDetails'],
            'conditions' => ['batch_id' => $id]
        ]);
        $batchUser = $this->paginate($batchUserData);

        $clientIdArray = Hash::extract($batchUserData->toArray(),'{n}.client_id');

        if($this->request->is('post'))
        {
            $total_amount = $_POST['total_amount'];
            $clientRdData = $clientRdModel->find('all',[
                'conditions' => ['client_id in' => $clientIdArray]
            ])->toList();

            $totalAmountRequired = array_sum(Hash::extract($clientRdData,'{n}.rd_amount'));

            if($totalAmountRequired == $total_amount)
            {
                foreach ($clientRdData as $data) {
                    $clientRdPaymentEntity = $clientRdPaymentModel->newEntity();

                    $total_amount -= $data['rd_amount'];
                    $clientRdPaymentData = array(
                        'client_rd_id' => $data['id'],
                        'installment_received' => $data['rd_amount'],
                        'created_date' => $_POST['created_date'],
                        'penalty' => 0
                    );

                    $clientRdPaymentSave[] = $clientRdPaymentModel->patchEntity($clientRdPaymentEntity,$clientRdPaymentData);
                }
                if($clientRdPaymentModel->saveMany($clientRdPaymentSave))
                {
                        $this->Flash->success(__('Payment has been added successfully.'));
                        return $this->redirect(['controller' => 'ClientRdPayments','action' => 'index']);
                }
                $this->Flash->success(__('Error in submitting payment. Try again!!'));
            }
            else if($totalAmountRequired > $total_amount)
                $this->Flash->error(__('Rs. '.abs($totalAmountRequired-$total_amount).' more required to make payment. Try again!!'));
            else if($totalAmountRequired < $total_amount)
                $this->Flash->error(__('Rs. '.abs($totalAmountRequired-$total_amount).' extra has been provided. Try again!!'));

        }
        $clientRdData = $clientRdModel->find('all',[
            'conditions' => ['client_id in' => $clientIdArray]
        ])->toList();

        $totalAmountRequired = null;
        
        foreach ($clientRdData as $data)
        {
            $totalAmountRequired[$data['client_id']] = $data['rd_amount'];
        }
//        $this->paginate = [
//            'contain' => ['Batches', 'ClientDetails'],
//            'conditions' => ['batch_id' => $id]
//        ];

        $this->set(compact('batchUser','clientRdPaymentEntity','totalAmountRequired'));
        $this->set('_serialize', ['batchUser']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $batch = $this->Batches->newEntity();
        $batchUserModel = TableRegistry::get('BatchUser');
        if ($this->request->is('post')) {
            $batchArray = array(
                'batch_name' => $_POST['batch_name'],
                'created_date' => $_POST['created_date']
            );
            $batch = $this->Batches->patchEntity($batch, $batchArray);
            try
            {
                $batchSave = $this->Batches->save($batch);
                $clientArray = explode(",",$_POST['clientId']);

                foreach ($clientArray as $data)
                {
                    $batchUser = $batchUserModel->newEntity();
                    $batchUserArray = array(
                        'batch_id' => $batchSave->id,
                        'client_id' => $data,
                        'created_date' => $_POST['created_date']
                    );
                    $batchUserPatch[] = $batchUserModel->patchEntity($batchUser,$batchUserArray);
                }
                $batUserSave = $batchUserModel->saveMany($batchUserPatch);
                if($batUserSave)
                {
                    $this->Flash->success(__('The batch has been saved.'));

                    return $this->redirect(['controller' => 'clientRd','action' => 'index']);
                }
            } catch (\Exception $e)
            {
                print_r($e->getMessage());
                $this->Flash->error(__('The batch could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('batch'));
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
        $this->set(compact('batch'));
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
