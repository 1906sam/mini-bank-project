<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

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

        // Rd payments code starts from here:

        $clientRdId = $clientRdModel->find('list',[
            'fields' => ['id'],
            'conditions' => ['status' => 0],
            'limit' => 10
        ])->toArray();

            $clientRdPayments = $clientRdPaymentsModel->find('all',[
                'fields' => ['client_rd_id','installment_received','created_date' => 'MAX(created_date)'],
                'conditions' => ['client_rd_id in' => $clientRdId,'status' => 1],
                'group' => ['client_rd_id','installment_received'],
                'order' => ['MAX(created_date)' => 'asc']
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
        foreach ($clientRdDataValue as $data)
        {
            $clientRdInfo[array_search($data,$clientRdDataValue)] = $clientData[$data];
        }
        // Rd payments code ends here: /////////////////////////////////////////

        /////////////////////////Loan payment code starts from here:
        $clientLoanId = $clientLoanModel->find('list',[
            'fields' => ['id'],
            'conditions' => ['status' => 0],
            'limit' => 10
        ])->toArray();

            $clientLoanPayments = $clientLoanPaymentsModel->find('all',[
                'fields' => ['client_loan_id','final_loan_amount' => 'MIN(final_loan_amount)','created_date' => 'MAX(created_date)'],
                'conditions' => ['client_loan_id in' => $clientLoanId,'status' => 1],
                'group' => ['client_loan_id'],
                'order' => ['MAX(created_date)' => 'asc']
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
        foreach ($clientLoanDataValue as $data)
        {
            $clientLoanInfo[array_search($data,$clientLoanDataValue)] = $clientData[$data];
        }


        $this->set(compact(
            'clientCount','clientLoanCount','clientFdCount','clientRdData','clientFdData','clientLoanData','clientRd',
            'clientRdPayments','clientRdInfo','clientRdDataValue','clientLoanPayments','clientLoanInfo','clientLoanDataValue'
        ));
    }

}