<?php
/**
  * @var \App\View\AppView $this
  */
?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs-3.3.7/jq-2.2.4/pdfmake-0.1.18/dt-1.10.13/af-2.1.3/b-1.2.4/b-colvis-1.2.4/b-flash-1.2.4/b-html5-1.2.4/b-print-1.2.4/kt-2.2.0/r-2.1.1/se-1.2.0/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs-3.3.7/jq-2.2.4/pdfmake-0.1.18/dt-1.10.13/af-2.1.3/b-1.2.4/b-colvis-1.2.4/b-flash-1.2.4/b-html5-1.2.4/b-print-1.2.4/kt-2.2.0/r-2.1.1/se-1.2.0/datatables.min.js"></script>

<div class="clientRd index large-9 medium-8 columns content">
    <h1 style="text-align: center; text-decoration: underline"><?= __('Client\'s RD') ?></h1>
    <input type="button" id="batchButton" class="btn btn-info btn-lg" data-toggle="modal" data-target="" value="Create Batch" onclick="createBatch(this);"/>
    <table id="clientRdTable" class="table table-striped table-bordered table-hover table-condensed dt-responsive nowrap" cellspacing="0"  width="100%">
        <thead>
            <tr>
                <th></th>
                <th>S.No.</th>
                <th>Client Information</th>
                <th>RD Amount</th>
                <th>Rate Of Interest</th>
                <th>Time Duration</th>
                <th>Status</th>
                <th>Payment Date</th>
<!--                <th>Modified Date</th>-->
                <th class="actions">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $count = 0; $class = "";
            foreach ($clientRd as $clientRd): 
                $count++;
                if($count %2 == 0)
                    $class = "";
                else
                    //$class = "success";
                    ?>
            <tr>
                <td><input type="checkbox" id="<?=  $clientRd->client_detail->id; ?>" class="checkbox_check"></td>
                <td><?= $this->Number->format($count) ?></td>
                <td>
                    <img src="<?= h($clientRd->client_detail->client_photo) ?>" width="80" height="80"><br>
                    <?= $clientRd->has('client_detail') ? $this->Html->link($clientRd->client_detail->client_name, ['controller' => 'ClientDetails', 'action' => 'view', $clientRd->client_detail->id],['target' => '_blank']) : '' ?>
                </td>
                <td><?= $this->Number->currency($clientRd->rd_amount) ?></td>
                <td><?= $this->Number->toPercentage($clientRd->rate_of_interest) ?></td>
                <td><?= $this->Number->format($clientRd->time_duration) ?></td>
                <td><?= $status = ($clientRd->status == 0) ? 'Running' : 'Complete'; ?></td>
                <td><?= h($clientRd->created_date->nice()) ?></td>
<!--                <td>--><?php //$this->Number->format($clientRd->modified_date) ?><!--</td>-->
                <td class="actions">
<!--                    --><?php //$this->Html->link(__('View'), ['action' => 'view', $clientRd->id]) ?>
                    <?= $this->Html->link(__('Add payment'), ['controller' => 'ClientRdPayments','action' => 'add', $clientRd->client_detail->id],['target' => '_blank']) ?> |
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $clientRd->id]) ?> | 
                    <?php echo $this->Form->postLink(__('Delete'), ['action' => 'delete', $clientRd->id], ['confirm' => __('Are you sure you want to delete # {0}?', $clientRd->id)]) ?>
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
                <h4 class="modal-title">Enter Batch name</h4>
            </div>
            <div class="modal-body">
                <?= $this->Form->create($batchData,['method' => 'POST','id' => 'batchFormId','name' => 'batchNameForm','url' => '/batches/add','class'=>'form']) ?>
                <?php
                //echo $this->Form->input('clientIdArray',['id' => 'clientIdValues','type' => 'hidden']);
                echo '<input type="hidden" name="clientId" id="clientIdValues" />';
                echo $this->Form->input('batch_name',['required' => 'required']);
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
    $('#clientRdTable').DataTable({
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
<script>
    function createBatch(reference) {
        var checkboxes = document.getElementsByClassName('checkbox_check');
        var formSubmit = false;
        var countOfCheckbox = 0;
        var userIdArray = [];
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked == true)
            {
                countOfCheckbox++;
                formSubmit = true;
                userIdArray.push(checkboxes[i].id);
            }
        }

        if(formSubmit && countOfCheckbox > 1)
        {
            document.getElementById(reference.id).setAttribute("data-target","#myBatchModal");
            document.getElementById('clientIdValues').value = userIdArray;
//            alert(JSON.stringify(userIdArray));
        }
        else
        {
            alert("Select at least two clients");
        }
    }
</script>
