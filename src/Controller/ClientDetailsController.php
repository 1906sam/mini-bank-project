<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * ClientDetails Controller
 *
 * @property \App\Model\Table\ClientDetailsTable $ClientDetails
 * @property bool|object Common
 */
class ClientDetailsController extends AppController
{
    public $components = array('Common');

    public function payments()
    {
        $clientRdModel = $this->loadModel('ClientRd');
        $clientRdPaymentModel = $this->loadModel('ClientRdPayments');
        $clientFd = $this->loadModel('ClientFd');
        $clientLoan = $this->loadModel('ClientLoan');
        $clientLoanPaymentModel = $this->loadModel('ClientLoanPayments');

        if ($this->request->is('post')) {

            $clientRdData = $clientRdModel->find('all', [
                'conditions' => ['client_id' => $_POST['clientId'],'status' => 0]
            ])->toArray();

            //this is used for fetching combined RD amount plus loan interest.
            if (isset($_POST['clientId']) && $_POST['clientId'] != '' && !(isset($_POST['formSubmit']) && $_POST['formSubmit'] != ''))
            {
                if (empty($clientRdData))
                {
                    echo NO_DATA;
                    die();
                }
                else
                {
                    $totalPenalty = $countOfNegative = $totalRdamount = 0;

                    //iterating through each RD for every client.
                    foreach ($clientRdData as $rdData)
                    {
                        $clientRdPaymentData = $clientRdPaymentModel->find('all', [
                            'conditions' => ['client_rd_id' => $rdData['id'],'status' => 1],
                            'order' => ['created_date' => 'desc']
                        ])->first();

                        if (empty($clientRdPaymentData)) {
                            $totalRdamount += $rdData['rd_amount'];
                            $penalty = 0;
                        } else {
                            $today = date_create(date("Y-m-d H:i:s"));//->modify('-1 year');
                            $dateDiff = date_diff($today, $clientRdPaymentData['created_date']);

                            if($dateDiff->y >= 1)
                                $diffMonth = $dateDiff->y*12 + $dateDiff->m;
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
                            $totalRdamount += $diffMonth*$rdData['rd_amount'];
//                            debug($totalRdamount);

                            $penalty = $this->Common->calculatePenalty($rdData, $clientRdPaymentData);
//                            debug($penalty);
                            if($penalty < 0)
                                $countOfNegative++;
                        }

                        if($penalty >= 0)
                            $totalPenalty += $penalty;
//                        debug($totalRdamount);
                    }

                    $loanDataOriginal = $clientLoan->find('all', [
                        'conditions' => ['client_id' => $_POST['clientId'],'status' => 0]
                    ])->toArray();

                    $interestValue = 0;
                    if (!empty($loanDataOriginal))
                    {
                        $loanAfterwards = $clientLoanPaymentModel->find('all', [
                            'conditions' => ['client_loan_id' => $loanDataOriginal[0]['id'],'status' => 1],
                            'order' => ['created_date' => 'desc']
                        ])->first();

                        $today = date_create(date("Y-m-d H:i:s"));//->modify('-1 year');

                        if (empty($loanAfterwards)) {
                            $dateDiff = date_diff($today, $loanDataOriginal[0]['created_date']);

                            if($dateDiff->y >= 1)
                                $diffMonth = $dateDiff->y*12 + $dateDiff->m;
                            else
                                $diffMonth = $dateDiff->m;

                            $interestValue = $diffMonth*$loanDataOriginal[0]['loan_amount'] * ($loanDataOriginal[0]['rate_of_interest'] / 100);
                        }
                        else
                        {
                            $dateDiff = date_diff($today, $loanAfterwards['created_date']);

//                            debug($dateDiff);
                            if($dateDiff->y >= 1)
                                $diffMonth = $dateDiff->y*12 + $dateDiff->m;
                            else if($dateDiff->m > 0)
                                $diffMonth = $dateDiff->m;
                            else if($dateDiff->y == 0 && $dateDiff->m == 0)
                            {
                                $todayDate = date("Y-m-d");
                                $lastPaymentDate = date_parse_from_format("Y-m-d",$loanAfterwards['created_date']->format("Y-m-d"));
                                $todayDate = date_parse_from_format("Y-m-d",$todayDate);
                                $diffMonth = $todayDate['month'] - $lastPaymentDate['month'];
                            }

                            $interestValue = $diffMonth * $loanAfterwards['final_loan_amount'] * ($loanDataOriginal[0]['rate_of_interest'] / 100);
                        }

                        $total_amount = $totalRdamount + $interestValue;
                    }
                    else
                    {
                        $total_amount = $totalRdamount;
                    }

                    if($countOfNegative == count($clientRdData) && $interestValue == 0)
                    {
                        echo "Payment already received for this month.";
                        die();
                    }
                    else
                    {
                        echo $totalPenalty . "," . $total_amount.",".$interestValue;
                        die();
                    }
                }
            }
            // when payment form is submitted.
            else if (isset($_POST['formSubmit']) && $_POST['formSubmit'] != '')
            {
                foreach ($clientRdData as $rdData)
                {
                    $total_rd_amount = 0;
                    $clientRdPaymentData = $clientRdPaymentModel->find('all', [
                        'conditions' => ['client_rd_id' => $rdData['id'],'status' => 1],
                        'order' => ['created_date' => 'desc']
                    ])->first();

                    if (empty($clientRdPaymentData)) {
                        $total_rd_amount = $rdData['rd_amount'];
                        $final_rd_amount = $total_rd_amount + ($rdData['rd_amount'] * $rdData['rate_of_interest']) / 100;
                        $interest_on_rd = ($rdData['rd_amount'] * $rdData['rate_of_interest']) / 100;

                        $penalty = 0;
                    } else {
//                        $today = date("Y-m-d");
//                        $lastPaymentDate = date_parse_from_format("d-m-Y",$clientRdPaymentData['created_date']);
//                        $todayDate = date_parse_from_format("Y-m-d",$today);
//                        $diffMonth = $todayDate['month'] - $lastPaymentDate['month'];

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
                        else if($dateDiff->y >= 1)
                            $diffMonth = $dateDiff->y*12 + $dateDiff->m;
                        else
                            $diffMonth = $dateDiff->m;

                        $total_rd_amount = $diffMonth*$rdData['rd_amount'];

                        $final_rd_amount = $total_rd_amount + ($clientRdPaymentData['final_rd_amount']*pow((1+($rdData['rate_of_interest']/100)),$diffMonth));
                        $interest_on_rd = $final_rd_amount - $total_rd_amount - $clientRdPaymentData['final_rd_amount'];

                        $penalty = $this->Common->calculatePenalty($rdData, $clientRdPaymentData);
                    }

                    $clientRdPaymentEntity = $clientRdPaymentModel->newEntity();
                    $clientRdPaymentArray = array(
                        'client_rd_id' => $rdData['id'],
                        'installment_received' => $total_rd_amount,
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
//                        $this->Flash->success(__('Client\'s payment has been saved.'));
//
                        return $this->redirect(['controller' => 'clientDetails','action' => 'index']);
                    }
                    else
                        $this->Flash->success(__('Client\'s payment has been saved.'));
                }

                $loanDataOriginal = $clientLoan->find('all', [
                    'conditions' => ['client_id' => $_POST['clientId'],'status' => 0]
                ])->toArray();

                if (!empty($loanDataOriginal))
                {
                    $loanAfterwards = $clientLoanPaymentModel->find('all', [
                        'conditions' => ['client_loan_id' => $loanDataOriginal[0]['id'],'status' => 1],
                        'order' => ['created_date' => 'desc']
                    ])->first();

                    $today = date_create(date("Y-m-d H:i:s"));//->modify('-1 year');

                    if (empty($loanAfterwards)) {
                        $dateDiff = date_diff($today, $loanDataOriginal[0]['created_date']);

                        if($dateDiff->y >= 1)
                            $diffMonth = $dateDiff->y*12 + $dateDiff->m;
                        else
                            $diffMonth = $dateDiff->m;
                    }
                    else
                    {
                        $dateDiff = date_diff($today, $loanAfterwards['created_date']);

                        if($dateDiff->y >= 1)
                            $diffMonth = $dateDiff->y*12 + $dateDiff->m;
                        else if($dateDiff->m > 0)
                            $diffMonth = $dateDiff->m;
                        else if($dateDiff->y == 0 && $dateDiff->m == 0)
                        {
                            $todayDate = date("Y-m-d");
                            $lastPaymentDate = date_parse_from_format("Y-m-d",$loanAfterwards['created_date']->format("Y-m-d"));
                            $todayDate = date_parse_from_format("Y-m-d",$todayDate);
                            $diffMonth = $todayDate['month'] - $lastPaymentDate['month'];
                        }
                    }

                    $clientLoanPaymentEntity = $clientLoanPaymentModel->newEntity();

                    if($diffMonth > 0)
                    {
                        if (empty($loanAfterwards))
                        {
                            $clientLoanPaymentArray = array(
                                'client_loan_id' => $loanDataOriginal[0]['id'],
                                'interest_received' => $_POST['total_amount'],
                                'installment_received' => (isset($_POST['loan_installment_received']) && $_POST['loan_installment_received'] != '') ? $_POST['loan_installment_received'] : 0,
                                'final_loan_amount' => (isset($_POST['loan_installment_received']) && $_POST['loan_installment_received'] != '') ? ($loanDataOriginal[0]['loan_amount'] - $_POST['loan_installment_received']) : $loanDataOriginal[0]['loan_amount'],
                                'created_date' => $_POST['created_date']
                            );
                        }
                        else
                        {
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
                    if (!$saveData) {
                        $this->Flash->error(__('Client\'s payment could not be saved. Please try again.'));
//                        $this->Flash->success(__('Client\'s payment has been saved.'));
//
                        return $this->redirect(['controller' => 'clientDetails','action' => 'index']);
                    }
                    else
                        $this->Flash->success(__('Client\'s payment has been saved.'));
                    }
                }
            }
        }
        return $this->redirect(['controller' => 'clientDetails','action' => 'index']);
    }

    //file upload function
    public function upload($clientId,$uniVal,$data)
    {
//        $userId = $this->request->session()->read('Auth.User.id');
        define("UPLOAD_DIR", ROOT.DS.APP_DIR.DS."webroot/img/".$uniVal."/");
        $photoName = $signatureName = null;

        //for client photo
        if(!empty($data['client_photo']))
        {
                //// debug("hello"); die();
                $myFile = $data['client_photo'];

                if ($myFile["error"] !== UPLOAD_ERR_OK) {
                    echo "<p>An error occurred.</p>";
                    exit;
                }

                // ensure a safe filename
                $photoName = preg_replace("/[^A-Z0-9._-]/i", "_", $myFile["name"]);

                $i = 0;
                $parts = pathinfo($photoName);
                if(!file_exists(UPLOAD_DIR . $photoName))
                {
                    mkdir("./img/".$uniVal,0777,true);
                }

                // don't overwrite an existing file
//                while (file_exists(UPLOAD_DIR . $photoName)) {
//                    $i++;
//                    $photoName = $parts["filename"] . "-" . $i . "." . $parts["extension"];
//                }

                // preserve file from temporary directory
                $success = move_uploaded_file($myFile["tmp_name"],"./img/".$uniVal."/". $photoName);
                if (!$success) {
                    echo "47 <p>Unable to save file.</p>";
                    exit;
                }

                // set proper permissions on the new file
                chmod("./img/".$uniVal."/". $photoName, 0777);
        }

        //for client's signature photo
        if(!empty($data['client_sign_photo']))
        {
            $myFile = $data['client_sign_photo'];

                if ($myFile["error"] !== UPLOAD_ERR_OK) {
                    echo "<p>An error occurred.</p>";
                    exit;
                }

                // ensure a safe filename
                $signatureName = preg_replace("/[^A-Z0-9._-]/i", "_", $myFile["name"]);

                $i = 0;
                $parts = pathinfo($signatureName);
                if(!file_exists(UPLOAD_DIR . $signatureName))
                {
                    mkdir("./img/".$uniVal,0777,true);
                }
                // don't overwrite an existing file

//                while (file_exists(UPLOAD_DIR . $signatureName)) {
//                    $i++;
//                    $signatureName = $parts["filename"] . "-" . $i . "." . $parts["extension"];
//                }

                // preserve file from temporary directory
                $success = move_uploaded_file($myFile["tmp_name"], "./img/".$uniVal."/". $signatureName);
                if (!$success) {
                    echo "82 <p>Unable to save file.</p>";
                    exit;
                }

                // set proper permissions on the new file
                chmod("./img/".$uniVal."/". $signatureName, 0777);
        }

        if($this->request->is(['patch', 'post', 'put']))
        {
            try
            {
                $status = $this->ClientDetails->updateAll(
                    [
                        'client_photo' => "/img/".$uniVal."/".$photoName,
                        'client_sign_photo' => "/img/".$uniVal."/".$signatureName
                    ],
                    [
                        'id' => $clientId
                    ]
                );
                if($this->request->is('post'))
                    $this->redirect("/viewClients");
                //    $this->redirect("/addRd/".$clientId);
            }
            catch (\Exception $e)
            {
                $this->Flash->error($e->getMessage());
                //$this->redirect("/addClients");
            }
        }
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
            if(isset($_POST['select_date']) && $_POST['select_date'] != '')
                $this->request->data['created_date'] = $_POST['select_date'];

            $clientDetail = $this->ClientDetails->patchEntity($clientDetail, $this->request->data);

            try{
                $saveData = $this->ClientDetails->save($clientDetail);
                if ($saveData) {
                    $uniqueUserData = str_replace(" ","_",$_POST['client_name'].$saveData->id);
                    $clientId = $saveData->id;
                    $this->upload($clientId,$uniqueUserData,$_FILES);
                    $this->Flash->success(__('The client\'s personal detail has been saved.'));
                }
            }
            catch(\Exception $e)
            {
                $this->Flash->error($e->getMessage());
                $this->Flash->error(__('The client\'s personal detail could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('clientDetail'));
        $this->set('_serialize', ['clientDetail']);
    }


    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $clientDetails = $this->paginate($this->ClientDetails,[
            'order' => ['created_date' => 'desc']
        ]);

        $this->set(compact('clientDetails','batchData'));
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

        $clientRdModel = $this->loadModel('ClientRd');
        $clientRdPaymentModel = $this->loadModel('ClientRdPayments');
        $clientFd = $this->loadModel('ClientFd');
        $clientLoan = $this->loadModel('ClientLoan');
        $clientLoanPaymentModel = $this->loadModel('ClientLoanPayments');

        $clientRdData = $clientRdModel->find('all',[
            'conditions' => ['client_id' => $id]
        ])->toArray();

        if(!empty($clientRdData))
        {
            foreach ($clientRdData as $data)
            {
                $totalInterest[$data['id']] = $clientRdPaymentModel->find('all',[
                    'conditions' => ['client_rd_id' => $data['id']]
                ])->sumOf('interest_on_rd');

                $totalPenalty[$data['id']] = $clientRdPaymentModel->find('all',[
                    'conditions' => ['client_rd_id' => $data['id']]
                ])->sumOf('penalty');

                $finalRdAmount[$data['id']] = $clientRdPaymentModel->find('all',[
                    'conditions' => ['client_rd_id' => $data['id']],
                    'order' => ['created_date' => 'desc']
                ])->toArray();
            }
        }

        $clientFdData = $clientFd->find('all',[
            'conditions' => ['client_id' => $id]
        ])->toArray();

        $clientLoanData = $clientLoan->find('all',[
            'conditions' => ['client_id' => $id]
        ])->toArray();

        if(!empty($clientLoanData))
        {
            $clientLoanPaymentData = $clientLoanPaymentModel->find('all',[
                'conditions' => ['client_loan_id' => $clientLoanData[0]['id']]
            ])->toArray();
        }

        $this->set(compact('finalRdAmount','totalInterest','totalPenalty'));
        $this->set(compact('clientDetail','clientRdData','clientFdData','clientLoanData','clientLoanPaymentData'));
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
            if(isset($_POST['select_date']) && $_POST['select_date'] != '')
                $this->request->data['created_date'] = $_POST['select_date'];

            $clientDetail = $this->ClientDetails->patchEntity($clientDetail, $this->request->data);
            if ($this->ClientDetails->save($clientDetail)) {
                $uniqueUserData = str_replace(" ","_",$_POST['client_name'].$id);
                $this->upload($id,$uniqueUserData,$_FILES);
                $this->Flash->success(__('The client detail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The client detail could not be saved. Please, try again.'));
            }
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
