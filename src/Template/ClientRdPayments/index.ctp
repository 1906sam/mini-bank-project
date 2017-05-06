<?php
/**
  * @var \App\View\AppView $this
  */
?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs-3.3.7/jq-2.2.4/pdfmake-0.1.18/dt-1.10.13/af-2.1.3/b-1.2.4/b-colvis-1.2.4/b-flash-1.2.4/b-html5-1.2.4/b-print-1.2.4/kt-2.2.0/r-2.1.1/se-1.2.0/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs-3.3.7/jq-2.2.4/pdfmake-0.1.18/dt-1.10.13/af-2.1.3/b-1.2.4/b-colvis-1.2.4/b-flash-1.2.4/b-html5-1.2.4/b-print-1.2.4/kt-2.2.0/r-2.1.1/se-1.2.0/datatables.min.js"></script>

<div class="clientRdPayments index large-9 medium-8 columns content">
    <h1 style="text-align: center; text-decoration: underline"><?= __('Client RD Payments') ?></h1>
    <table id="clientRdPaymentTable" class="table table-striped table-bordered table-hover table-condensed dt-responsive nowrap" cellspacing="0"  width="100%">
        <thead>
            <tr>
                <th>S.No.</th>
<!--                <th>Client Rd Information</th>-->
                <th>Client Name</th>
                <th>Installment Received</th>
<!--                <th>final_rd_amount</th>-->
                <th>Status</th>
                <th>Penalty</th>
                <th>Created Date</th>
<!--                <th>modified_date</th>-->
                <th class="actions">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php  $count = 0; $class = "";
            foreach ($clientRdPayments as $clientRdPayment):  $count++;
                if($count %2 == 0)
                    $class = "";
                else
                    //$class = "success";
                    ?>
            <tr>
                <td><?= $count; ?></td>
<!--                <td>--><?php //echo $clientRdPayment->has('client_rd') ? $this->Html->link("More Information", ['controller' => 'ClientRd', 'action' => 'view', $clientRdPayment->client_rd->id]) : '' ?><!--</td>-->
                <td><?= $this->Html->link($clientRdInfo[$clientRdPayment->client_rd_id], ['controller' => 'ClientDetails', 'action' => 'view', $clientRdData[$clientRdPayment->client_rd_id]],['target' => '_blank']); ?></td>
                <td><?= $this->Number->currency($clientRdPayment->installment_received) ?></td>
<!--                <td>--><?php //$this->Number->format($clientRdPayment->final_rd_amount) ?><!--</td>-->
                <td><?php
                        if($clientRdPayment->status == 1)
                            echo "New";
                        else
                            echo "Old";
                    ?>
                </td>
                <td><?= $this->Number->format($clientRdPayment->penalty) ?></td>
                <td><?= h($clientRdPayment->created_date->nice()) ?></td>
<!--                <td>--><?php //h($clientRdPayment->modified_date) ?><!--</td>-->
                <td class="actions">
                    <?php //echo $this->Html->link(__('View'), ['action' => 'view', $clientRdPayment->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $clientRdPayment->id]) ?>
                    <?php //echo $this->Form->postLink(__('Delete'), ['action' => 'delete', $clientRdPayment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $clientRdPayment->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>
    $('#clientRdPaymentTable').DataTable({
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
