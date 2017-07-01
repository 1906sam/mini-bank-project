<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Utility\Hash;

/**
 * ClientDetails Controller
 *
 * @property \App\Model\Table\ClientDetailsTable $ClientDetails
 */
class AdminController extends AppController
{
    public function testFile()
    {
        $this->viewBuilder()->layout(null);
    }
    public function accountSettings()
    {
        $userModel = $this->loadModel('Users');
        $userData = $userModel->newEntity();

        $this->set('userData',$userData);
    }
    public function dashboard()
    {
        $clientModel = $this->loadModel('ClientDetails');
        $clientLoanModel = $this->loadModel('ClientLoan');
        $clientFdModel = $this->loadModel('ClientFd');
        $clientRdModel = $this->loadModel('ClientRd');
        $clientRdPaymentsModel = $this->loadModel('ClientRdPayments');
        $clientLoanPaymentsModel = $this->loadModel('ClientLoanPayments');

        $clientCount = sizeof($clientModel->find('all',[
            'conditions' => ['status' => 1]
        ])->toArray());
        $clientLoanCount = sizeof($clientLoanModel->find('all',[
            'conditions' => ['status' => 0]
        ])->toArray());
        $clientFdCount = sizeof($clientFdModel->find('all',[
            'conditions' => ['status' => 0]
        ])->toArray());

        $clientRdData = $clientRdModel->find('all',[
            'conditions' => ['status' => 0]
        ])->sumOf('rd_amount');

        $clientFdData = $clientFdModel->find('all',[
            'conditions' => ['status' => 0]
        ])->sumOf('fd_amount');

        $clientLoanData = $clientLoanModel->find('all',[
            'conditions' => ['status' => 0]
        ])->sumOf('loan_amount');

    ///////// Code for tables having cumulative data starts from here /////////////////////

        /******  Code for FD ******/
        $clientRunFdData = $clientFdModel->find('all',[
            'conditions' => ['status' => 0]
        ])->sumOf('fd_amount');

        $clientComFdData = $clientFdModel->find('all',[
            'conditions' => ['status' => 1]
        ])->sumOf('terminating_amount');


        /******  Code for RD ******/
        $clientRdList = $clientRdModel->find('all')->toArray();

        $totalRunningRdInwardCash = $totalRunningRdOutwardCash = 0;
        foreach ($clientRdList as $rdItem)
        {
            if($rdItem['status'] == 0)
            {
                $rdInstallmentSum = $clientRdPaymentsModel->find('all',[
                    'conditions' => ['client_rd_id' => $rdItem['id']]
                ])->sumOf('installment_received');

                $rdPenaltySum = $clientRdPaymentsModel->find('all',[
                    'conditions' => ['client_rd_id' => $rdItem['id']]
                ])->sumOf('penalty');

                $totalRunningRdInwardCash += $rdInstallmentSum + $rdPenaltySum;
            }
            else
            {
                $rdInstallmentSum = $clientRdPaymentsModel->find('all',[
                    'conditions' => ['client_rd_id' => $rdItem['id']]
                ])->sumOf('installment_received');

                $rdInterestSum = $clientRdPaymentsModel->find('all',[
                    'conditions' => ['client_rd_id' => $rdItem['id']]
                ])->sumOf('interest_on_rd');

                $rdPenaltySum = $clientRdPaymentsModel->find('all',[
                    'conditions' => ['client_rd_id' => $rdItem['id']]
                ])->sumOf('penalty');

                $totalRunningRdOutwardCash += abs($rdPenaltySum - $rdInstallmentSum - $rdInterestSum);
            }
        }

        /******  Code for Loan ******/

        $clientLoanList = $clientLoanModel->find('all')->toArray();
        $totalRunningLoanInwardCash = $totalRunningLoanOutwardCash = 0;
        foreach ($clientLoanList as $loanItem)
        {
            if($loanItem['status'] == 0)
            {
                $loanInterestSum = $clientLoanPaymentsModel->find('all',[
                    'conditions' => ['client_loan_id' => $loanItem['id']]
                ])->sumOf('interest_received');

                $loanInstallmentSum = $clientLoanPaymentsModel->find('all',[
                    'conditions' => ['client_loan_id' => $loanItem['id']]
                ])->sumOf('installment_received');

                $totalRunningLoanInwardCash += $loanInterestSum + $loanInstallmentSum;
            }
            else
            {
                $loanInterestSum = $clientLoanPaymentsModel->find('all',[
                    'conditions' => ['client_loan_id' => $loanItem['id']]
                ])->sumOf('interest_received');

                $loanInstallmentSum = $clientLoanPaymentsModel->find('all',[
                    'conditions' => ['client_loan_id' => $loanItem['id']]
                ])->sumOf('installment_received');

                $totalRunningLoanInwardCash += $loanInterestSum + $loanInstallmentSum;
            }
        }



        ///////// Code for tables having cumulative data ends here /////////////////////
//Rd payments code starts from here:
        $clientRdId = $clientRdModel->find('list',[
            'fields' => ['id'],
            'conditions' => ['status' => 0],
            'limit' => 10
        ])->toArray();

        $clientRdPaymentsId = $clientRdPaymentsModel->find('all',[
            'fields' => ['client_rd_id','id' => 'MAX(id)'],
            'conditions' => ['client_rd_id in ' => $clientRdId,'status' => 1],
            'group' => ['client_rd_id']
        ])->toArray();

        $clientRdPaymentsId = Hash::extract($clientRdPaymentsId,"{n}.id");

        $clientRdPayments = $clientRdPaymentsModel->find('all',[
             'fields' => ['client_rd_id','installment_received','created_date' => 'MAX(created_date)'],
             'conditions' => ['id in' => $clientRdPaymentsId],
             'group' => ['client_rd_id','installment_received'],
             'order' => ['MAX(created_date)' => 'desc']
         ])->toArray();


        $clientRdDataValue = $clientRdModel->find('list',[
            'keyField' => 'id',
            'valueField' => 'client_id',
            'conditions' => ['status' => 0]
        ])->toArray();

        $clientData = $clientModel->find('list',[
            'keyField' => 'id',
            'valueField' => 'client_name',
            'conditions' => ['id in' => $clientRdDataValue]
        ])->toArray();

        $clientRdInfo = null;
        $clientRdDataValueKeys = array_keys($clientRdDataValue);
        foreach ($clientRdDataValueKeys as $key)
        {
            $clientRdInfo[$key] = $clientData[$clientRdDataValue[$key]];
        }
        // Rd payments code ends here: /////////////////////////////////////////

/////////////////////////Loan payment code starts from here:
        $clientLoanId = $clientLoanModel->find('list',[
            'fields' => ['id'],
            'conditions' => ['status' => 0],
            'limit' => 10
        ])->toArray();

        $clientLoanPaymentsId = $clientLoanPaymentsModel->find('all',[
            'fields' => ['client_loan_id','id' => 'MAX(id)'],
            'conditions' => ['client_loan_id in ' => $clientLoanId,'status' => 1],
            'group' => ['client_loan_id']
        ])->toArray();

        $clientLoanPaymentsId = Hash::extract($clientLoanPaymentsId,"{n}.id");

            $clientLoanPayments = $clientLoanPaymentsModel->find('all',[
                'fields' => ['client_loan_id','final_loan_amount' => 'MIN(final_loan_amount)','created_date' => 'MAX(created_date)'],
                'conditions' => ['id in' => $clientLoanPaymentsId],
                'group' => ['client_loan_id'],
                'order' => ['MAX(created_date)' => 'desc']
            ])->toArray();

        $clientLoanDataValue = $clientLoanModel->find('list',[
            'keyField' => 'id',
            'valueField' => 'client_id',
            'conditions' => ['status' => 0]
        ])->toArray();

        $clientData = $clientModel->find('list',[
            'keyField' => 'id',
            'valueField' => 'client_name',
            'conditions' => ['id in' => $clientLoanDataValue]
        ])->toArray();

        $clientLoanInfo = null;
        $clientLoanDataValueKeys = array_keys($clientLoanDataValue);
        foreach ($clientLoanDataValueKeys as $key)
        {
            $clientLoanInfo[$key] = $clientData[$clientLoanDataValue[$key]];
        }

        $this->set(compact('clientRunFdData','clientComFdData','totalRunningRdInwardCash','totalRunningRdOutwardCash',
            'totalRunningLoanInwardCash'));
        $this->set(compact(
            'clientCount','clientLoanCount','clientFdCount','clientRdData','clientFdData','clientLoanData','clientRd',
            'clientRdPayments','clientRdInfo','clientRdDataValue','clientLoanPayments','clientLoanInfo','clientLoanDataValue'
        ));
    }

}