<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;

/**
 * Batches Controller
 *
 * @property \App\Model\Table\BatchesTable $Batches
 * @property bool|object Common
 */
class BatchesController extends AppController
{

    public $components = array('Common');
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
        $clientLoan = $this->loadModel('ClientLoan');
        $clientFdModel = $this->loadModel('ClientFd');

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
                'conditions' => ['client_id in' => $clientId,'status' => 0]
            ])->sumOf('rd_amount');

            $clientLoanData = $clientLoan->find('all',[
                'conditions' => ['client_id in' => $clientId,'status' => 0]
            ])->sumOf('loan_amount');

            $clientFdData = $clientFdModel->find('all',[
                'conditions' => ['client_id in' => $clientId,'status' => 0]
            ])->sumOf('fd_amount');

            if(!empty($clientRdData) && $clientRdData != '')
                $batchRdData[$data] = $clientRdData;
            if(!empty($clientLoanData) && $clientLoanData != '')
                $batchLoanData[$data] = $clientLoanData;
            if(!empty($clientFdData) && $clientFdData != '')
                $batchFdData[$data] = $clientFdData;
        }
        $this->set(compact('batches','batchClientData','batchRdData','batchLoanData','batchFdData'));
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

        $clientFdModel = $this->loadModel('ClientFd');
        $clientFdPaymentModel = $this->loadModel('ClientFdPayments');
        $clientLoan = $this->loadModel('ClientLoan');
        $clientLoanPaymentModel = $this->loadModel('ClientLoanPayments');
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
            //this is used for fetching combined RD amount plus loan interest.
            if (!(isset($_POST['formSubmit']) && $_POST['formSubmit'] != ''))
            {
                $totalPenalty = $countOfNegative =  $countOfRd = $interestValueTemp = $interestValue = $total_amount = 0;

                foreach ($clientIdArray as $id)
                {
                    $clientRdData = $clientRdModel->find('all', [
                        'conditions' => ['client_id' => $id, 'status' => 0]
                    ])->toArray();

                    $totalRdamount = 0;
                    //iterating through each RD for every client.
                    foreach ($clientRdData as $rdData)
                    {
                        $clientRdPaymentData = $clientRdPaymentModel->find('all', [
                            'conditions' => ['client_rd_id' => $rdData['id'], 'status' => 1],
                            'order' => ['created_date' => 'desc']
                        ])->first();

                        if (empty($clientRdPaymentData)) {
                            $totalRdamount += $rdData['rd_amount'];
                            $penalty = 0;
                        } else {
                            $today = date_create(date("Y-m-d H:i:s"));//->modify('-1 year');
                            $dateDiff = date_diff($today, $clientRdPaymentData['created_date']);

                            if ($dateDiff->y >= 1)
                                $diffMonth = $dateDiff->y * 12 + $dateDiff->m;
                            else
                                $diffMonth = $dateDiff->m;

                            //                            debug($diffMonth);
                            //                            $today = date("Y-m-d");
                            //                            $lastPaymentDate = date_parse_from_format("d-m-Y",$clientRdPaymentData['created_date']);
                            //                            $todayDate = date_parse_from_format("Y-m-d",$today);
                            //                            $diffMonth = $todayDate['month'] - $lastPaymentDate['month'];
                            //                            debug($todayDate);
                            //                            debug($lastPaymentDate);
                            //                            die();
                            $totalRdamount += $diffMonth * $rdData['rd_amount'];
                            //                            debug($totalRdamount);

                            $penalty = $this->Common->calculatePenalty($rdData, $clientRdPaymentData);
                            //                            debug($penalty);
                            if ($penalty < 0)
                                $countOfNegative++;
                        }

                        if ($penalty >= 0)
                            $totalPenalty += $penalty;
                        //                        debug($totalRdamount);

                    }
                    $loanDataOriginal = $clientLoan->find('all', [
                        'conditions' => ['client_id' => $id, 'status' => 0]
                    ])->toArray();

                    if (!empty($loanDataOriginal)) {
                        $loanAfterwards = $clientLoanPaymentModel->find('all', [
                            'conditions' => ['client_loan_id' => $loanDataOriginal[0]['id'], 'status' => 1],
                            'order' => ['created_date' => 'desc']
                        ])->first();

                        $today = date_create(date("Y-m-d H:i:s"));//->modify('-1 year');

                        if (empty($loanAfterwards)) {
                            $dateDiff = date_diff($today, $loanDataOriginal[0]['created_date']);

                            if ($dateDiff->y >= 1)
                                $diffMonth = $dateDiff->y * 12 + $dateDiff->m;
                            else
                                $diffMonth = $dateDiff->m;

                            $interestValueTemp = $diffMonth * $loanDataOriginal[0]['loan_amount'] * ($loanDataOriginal[0]['rate_of_interest'] / 100);
                        } else {
                            $dateDiff = date_diff($today, $loanAfterwards['created_date']);

                            if ($dateDiff->y >= 1)
                                $diffMonth = $dateDiff->y * 12 + $dateDiff->m;
                            else if ($dateDiff->m > 0)
                                $diffMonth = $dateDiff->m;
                            else if ($dateDiff->y == 0 && $dateDiff->m == 0) {
                                $todayDate = date("Y-m-d");
                                $lastPaymentDate = date_parse_from_format("Y-m-d", $loanAfterwards['created_date']->format("Y-m-d"));
                                $todayDate = date_parse_from_format("Y-m-d", $todayDate);
                                $diffMonth = $todayDate['month'] - $lastPaymentDate['month'];
                            }

                            $interestValueTemp = $diffMonth * $loanAfterwards['final_loan_amount'] * ($loanDataOriginal[0]['rate_of_interest'] / 100);
                        }
//                        debug($totalRdamount);
//                        debug($interestValue);
//                        debug($id);

                        $interestValue += $interestValueTemp;
                        $total_amount += $totalRdamount + $interestValueTemp;
                    }
                    else {
                        $total_amount += $totalRdamount;
                    }

                    $countOfRd += count($clientRdData);
                }
                if ($countOfNegative == $countOfRd && $interestValue == 0) {
                    echo "Payment already received for this month.";
                    die();
                } else {
                    echo $totalPenalty . "," . $total_amount . "," . $interestValue;
                    die();
                }
            }

            else if (isset($_POST['formSubmit']) && $_POST['formSubmit'] != '')
            {
                $totalRdamount = $countOfRd = $interestValueTemp = $interestValue = $total_amount = 0;
                foreach ($clientIdArray as $id) {
                    $clientRdData = $clientRdModel->find('all', [
                        'conditions' => ['client_id' => $id, 'status' => 0]
                    ])->toArray();

                    //iterating through each RD for every client.
                    foreach ($clientRdData as $rdData)
                    {
                        $clientRdPaymentData = $clientRdPaymentModel->find('all', [
                            'conditions' => ['client_rd_id' => $rdData['id'], 'status' => 1],
                            'order' => ['created_date' => 'desc']
                        ])->first();

                        if (empty($clientRdPaymentData)) {
                            $total_rd_amount = $rdData['rd_amount'];
                            $final_rd_amount = $total_rd_amount + ($rdData['rd_amount'] * $rdData['rate_of_interest']) / 100;
                            $interest_on_rd = ($rdData['rd_amount'] * $rdData['rate_of_interest']) / 100;
                            $penalty = 0;
                        }
                        else
                        {
                            $today = date_create(date("Y-m-d H:i:s"));//->modify('-1 year');
                            $dateDiff = date_diff($today, $clientRdPaymentData['created_date']);

                            if($dateDiff->y == 0 && $dateDiff->m == 0)
                            {
                                $todayDate = date("Y-m-d");
                                $lastPaymentDate = date_parse_from_format("Y-m-d",$clientRdPaymentData['created_date']->format("Y-m-d"));
                                $todayDate = date_parse_from_format("Y-m-d",$todayDate);
                                $diffMonth = $todayDate['month'] - $lastPaymentDate['month'];

                                if($diffMonth == 0)
                                    continue;
                            }
                            else if ($dateDiff->y >= 1)
                                $diffMonth = $dateDiff->y * 12 + $dateDiff->m;
                            else
                                $diffMonth = $dateDiff->m;

                            $totalRdamount += $diffMonth * $rdData['rd_amount'];

                            $final_rd_amount = $totalRdamount + ($clientRdPaymentData['final_rd_amount']*pow((1+($rdData['rate_of_interest']/100)),$diffMonth));
                            $interest_on_rd = $final_rd_amount - $totalRdamount - $clientRdPaymentData['final_rd_amount'];

                            $penalty = $this->Common->calculatePenalty($rdData, $clientRdPaymentData);
                        }

                        $clientRdPaymentEntity = $clientRdPaymentModel->newEntity();
                        $clientRdPaymentArray = array(
                            'client_rd_id' => $rdData['id'],
                            'installment_received' => $totalRdamount,
                            'penalty' => (int)$penalty,
                            'created_date' => $_POST['created_date'],
                            'interest_on_rd' => $interest_on_rd,
                            'final_rd_amount' => (int)$final_rd_amount
                        );

                        $clientRdPayment = $clientRdPaymentModel->patchEntity($clientRdPaymentEntity, $clientRdPaymentArray);
                        $_POST['total_amount'] -= ((isset($diffMonth) && $diffMonth !='')? $diffMonth : 1)*$rdData['rd_amount'];
                        $_POST['penalty'] -= $penalty;
                        try {
                            $saveData = $clientRdPaymentModel->save($clientRdPayment);
                        } catch (\Exception $e) {
                            print_r($e->getMessage());
                            die();
                        }
                        if (!$saveData) {
                            $this->Flash->error(__('Client\'s payment could not be saved. Please, try again.'));
                            return $this->redirect(['controller' => 'clientDetails','action' => 'index']);
                        }
                        else
                            $this->Flash->success(__('Client\'s payment has been saved.'));
                    }

                    $loanDataOriginal = $clientLoan->find('all', [
                        'conditions' => ['client_id' => $id, 'status' => 0]
                    ])->toArray();

                    if (!empty($loanDataOriginal))
                    {
                        $loanAfterwards = $clientLoanPaymentModel->find('all', [
                            'conditions' => ['client_loan_id' => $loanDataOriginal[0]['id'], 'status' => 1],
                            'order' => ['created_date' => 'desc']
                        ])->first();

                        $clientLoanPaymentEntity = $clientLoanPaymentModel->newEntity();
                        $today = date_create(date("Y-m-d H:i:s"));//->modify('-1 year');
                        $dateDiff = date_diff($today, $loanAfterwards['created_date']);

//                            debug($dateDiff);
                        if ($dateDiff->y >= 1)
                            $diffMonth = $dateDiff->y * 12 + $dateDiff->m;
                        else if ($dateDiff->m > 0)
                            $diffMonth = $dateDiff->m;
                        else if ($dateDiff->y == 0 && $dateDiff->m == 0) {
                            $todayDate = date("Y-m-d");
                            $lastPaymentDate = date_parse_from_format("Y-m-d", $loanAfterwards['created_date']->format("Y-m-d"));
                            $todayDate = date_parse_from_format("Y-m-d", $todayDate);
                            $diffMonth = $todayDate['month'] - $lastPaymentDate['month'];
                        }

                        if ($diffMonth > 0)
                        {
                            if (empty($loanAfterwards)) {
                                $clientLoanPaymentArray = array(
                                    'client_loan_id' => $loanDataOriginal[0]['id'],
                                    'interest_received' => $_POST['total_amount'],
                                    'installment_received' => (isset($_POST['loan_installment_received']) && $_POST['loan_installment_received'] != '') ? $_POST['loan_installment_received'] : 0,
                                    'final_loan_amount' => (isset($_POST['loan_installment_received']) && $_POST['loan_installment_received'] != '') ? ($loanDataOriginal[0]['loan_amount'] - $_POST['loan_installment_received']) : $loanDataOriginal[0]['loan_amount'],
                                    'created_date' => $_POST['created_date']
                                );
                            } else {
                                $today = date_create(date("Y-m-d H:i:s"));//->modify('-1 year');

                                $clientLoanPaymentArray = array(
                                    'client_loan_id' => $loanDataOriginal[0]['id'],
                                    'interest_received' => $_POST['total_amount'],
                                    'installment_received' => (isset($_POST['loan_installment_received']) && $_POST['loan_installment_received'] != '') ? $_POST['loan_installment_received'] : 0,
                                    'final_loan_amount' => (isset($_POST['loan_installment_received']) && $_POST['loan_installment_received'] != '') ? ($loanAfterwards['final_loan_amount'] - $_POST['loan_installment_received']) : $loanAfterwards['final_loan_amount'],
                                    'created_date' => $_POST['created_date']
                                );
                            }

                            $clientLoanPayment = $clientLoanPaymentModel->patchEntity($clientLoanPaymentEntity, $clientLoanPaymentArray);
                            try {
                                $saveData = $clientLoanPaymentModel->save($clientLoanPayment);
                            } catch (\Exception $e) {
                                print_r($e->getMessage());
                                die();
                            }
                            if (!$saveData)
                            {
                                $this->Flash->error(__('Client\'s payment could not be saved. Please try again.'));
                                return $this->redirect(['controller' => 'clientDetails', 'action' => 'index']);
                            }
                            else
                                $this->Flash->success(__('Client\'s payment has been saved.'));
                        }
//                        debug($totalRdamount);
//                        debug($interestValue);
//                        debug($id);
                    }
                }
            }
        }

        $totalRdAmountRequired = $totalLoanAmountRequired = $totalFdAmountRequired = null;
        
        foreach ($clientIdArray as $data)
        {
            $clientRdData = $clientRdModel->find('all',[
                'conditions' => ['client_id' => $data,'status' => 0]
            ])->sumOf('rd_amount');

            $clientLoanData = $clientLoan->find('all',[
                'conditions' => ['client_id' => $data,'status' => 0]
            ])->sumOf('loan_amount');

            $clientFdData = $clientFdModel->find('all',[
                'conditions' => ['client_id' => $data,'status' => 0]
            ])->sumOf('fd_amount');

            $totalRdAmountRequired[$data] = $clientRdData;
            $totalLoanAmountRequired[$data] = $clientLoanData;
            $totalFdAmountRequired[$data] = $clientFdData;
        }

        $this->set(compact('batchUser','clientRdPaymentEntity','totalLoanAmountRequired','totalRdAmountRequired','id','totalFdAmountRequired'));
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
