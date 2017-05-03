<?php
/**
  * @var \App\View\AppView $this
  */
?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs-3.3.7/jq-2.2.4/pdfmake-0.1.18/dt-1.10.13/af-2.1.3/b-1.2.4/b-colvis-1.2.4/b-flash-1.2.4/b-html5-1.2.4/b-print-1.2.4/kt-2.2.0/r-2.1.1/se-1.2.0/datatables.min.css"/>

<script type="text/javascript" src="https://cdn.datatables.net/v/bs-3.3.7/jq-2.2.4/pdfmake-0.1.18/dt-1.10.13/af-2.1.3/b-1.2.4/b-colvis-1.2.4/b-flash-1.2.4/b-html5-1.2.4/b-print-1.2.4/kt-2.2.0/r-2.1.1/se-1.2.0/datatables.min.js"></script>

    <div class="batchUser index large-9 medium-8 columns content">
        <h1 style="text-align: center; text-decoration: underline"><?= __('Batch User Details') ?></h1>
        <input type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myBatchModal" value="Make Payments" onclick="createBatch();"/>
        <table id="batchUserTable" class="table table-striped table-bordered table-condensed dt-responsive nowrap" cellspacing="0"  width="100%">
            <thead>
            <tr>
                <th>S.No.</th>
                <th>Batch Name</th>
                <th>Client Name</th>
                <th>RD Amount</th>
                <th>Created Date</th>
<!--                <th>modified_date</th>-->
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php  $count = 0; $class = "";
            foreach ($batchUser as $batchUser): $count++;
                if($count %2 == 0)
                    $class = "";
                else
                    //$class = "success";
                    ?>
                <tr>
                    <td><?= $count ?></td>
                    <td><?= $batchUser->has('batch') ? $this->Html->link($batchUser->batch->batch_name, ['controller' => 'Batches', 'action' => 'view', $batchUser->batch->id]) : '' ?></td>
                    <td>
                        <img src="<?= h($batchUser->client_detail->client_photo) ?>" width="80" height="80"><br>
                        <?= $batchUser->has('client_detail') ? $this->Html->link($batchUser->client_detail->client_name, ['controller' => 'ClientDetails', 'action' => 'view', $batchUser->client_detail->id]) : '' ?></td>
                    <td><?= $totalAmountRequired[$batchUser->client_detail->id] ?></td>
                    <td><?= $batchUser->created_date->nice(); ?></td>
<!--                    <td>--><?php ////echo h($batchUser->modified_date) ?><!--</td>-->
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $batchUser->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $batchUser->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $batchUser->id], ['confirm' => __('Are you sure you want to delete # {0}?', $batchUser->id)]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<div id="myBatchModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">You can only make RD payments through batch.</h4>
            </div>
            <div class="modal-body">
                <?= $this->Form->create($clientRdPaymentEntity,['method' => 'POST','id' => 'clientRdPaymentFormId','name' => 'clientRdPaymentName','class'=>'form']) ?>
                <?php
                //echo $this->Form->input('clientIdArray',['id' => 'clientIdValues','type' => 'hidden']);
//                echo '<input type="hidden" name="clientId" id="clientIdValues" />';
                echo $this->Form->input('total_amount',['required' => 'required','type' => 'number']);
                echo $this->Form->input('created_date',['value' => date("Y-m-d H:i:s"),'type' => 'hidden']);
                ?>
                <?= $this->Form->button(__('Submit')) ?>
                <?= $this->Form->end() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

    <script>
        $('#batchUserTable').DataTable({
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
            "pagingType": "first_last_numbers",
            /** columnDefs: [ {
            orderable: false,
            targets:   0,
            render: function(data, type, full, meta) {
                return '<input type="checkbox" id="<?php //echo  $clientDetail->id; ?>" class="checkbox_check">';
            }
        } ], **/
            select: {
                style:    'os',
                selector: 'td:first-child'
            },
            order: [[ 1, 'asc' ]]
        });
    </script>
