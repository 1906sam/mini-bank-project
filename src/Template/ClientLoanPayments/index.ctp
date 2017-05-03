<?php
/**
  * @var \App\View\AppView $this
  */
?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs-3.3.7/jq-2.2.4/pdfmake-0.1.18/dt-1.10.13/af-2.1.3/b-1.2.4/b-colvis-1.2.4/b-flash-1.2.4/b-html5-1.2.4/b-print-1.2.4/kt-2.2.0/r-2.1.1/se-1.2.0/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs-3.3.7/jq-2.2.4/pdfmake-0.1.18/dt-1.10.13/af-2.1.3/b-1.2.4/b-colvis-1.2.4/b-flash-1.2.4/b-html5-1.2.4/b-print-1.2.4/kt-2.2.0/r-2.1.1/se-1.2.0/datatables.min.js"></script>

<div class="clientLoanPayments index large-9 medium-8 columns content">
    <h1 style="text-align: center; text-decoration: underline"><?= __('Client\'s Loan Payments') ?></h1>
    <table id="clientLoanPaymentTable" class="table table-striped table-bordered table-hover table-condensed dt-responsive nowrap" cellspacing="0"  width="100%">
        <thead>
            <tr>
                <th>S.No.</th>
                <th>Client Loan Info</th>
                <th>Client Info</th>
                <th>Interest Received</th>
                <th>Installment Received</th>
                <th>Loan Pending</th>
                <th>Payment Date</th>
<!--                <th>modified_date</th>-->
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $count = 0; $class = "";
                foreach ($clientLoanPayments as $clientLoanPayment):
                $count++;
                if($count %2 == 0)
                    $class = "";
                else
                    //$class = "success";
            ?>

              <tr>
                <td><?= $this->Number->format($count) ?></td>
                <td><?= $clientLoanPayment->has('client_loan') ? $this->Html->link("More Information", ['controller' => 'ClientLoan', 'action' => 'view', $clientLoanPayment->client_loan->id]) : '' ?></td>
                <td><?php echo $this->Html->link($clientLoanInfo[$clientLoanPayment->client_loan_id], ['controller' => 'ClientDetails', 'action' => 'view', $clientLoanData[$clientLoanPayment->client_loan_id]]); ?></td>
                <td><?= $this->Number->currency($clientLoanPayment->interest_received) ?></td>
                <td><?= $this->Number->currency($clientLoanPayment->installment_received) ?></td>
                <td><?php echo $this->Number->currency($clientLoanPayment->final_loan_amount) ?></td>
                <td><?= h($clientLoanPayment->created_date->nice()) ?></td>
<!--                <td>--><?php //h($clientLoanPayment->modified_date) ?><!--</td>-->
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $clientLoanPayment->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $clientLoanPayment->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $clientLoanPayment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $clientLoanPayment->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>
    $('#clientLoanPaymentTable').DataTable({
        dom: 'Bfrtip',
        buttons: [
//            'copy',
//            'csv',
            'excel',
            'pdf',
            'print',
            'colvis'
        ],
        responsive: true,
        //keys: true,
        //autoFill: true,
        "pagingType": "first_last_numbers"
//        columnDefs: [ {
//            orderable: false,
//            className: 'select-checkbox',
//            targets:   0
//        } ],
//        select: {
//            style:    'os',
//            selector: 'td:first-child'
//        },
//        order: [[ 1, 'asc' ]]
    });
</script>
