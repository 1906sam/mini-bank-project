<?php
/**
  * @var \App\View\AppView $this
  */
?>

<div class="clientLoan index large-9 medium-8 columns content">
    <h1 style="text-align: center; text-decoration: underline"><?= __('Client\'s Loan') ?></h1>
    <table id="clientLoanTable" class="table table-striped table-bordered table-hover table-condensed dt-responsive nowrap" cellspacing="0"  width="100%">
        <thead>
            <tr>
                <th>S.No.</th>
                <th>Client Information</th>
                <th>Rate Of Interest</th>
                <th>Loan Amount</th>
                <th>Status</th>
                <th>Created Date</th>
<!--                <th>modified_date</th>-->
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $count = 0; $class = "";
            foreach ($clientLoan as $clientLoan):
                $count++;
                if($count %2 == 0)
                    $class = "";
                else
                    //$class = "success";
                    ?>

              <tr>
                <td><?= $this->Number->format($count) ?></td>
                <td>
                    <img src="<?= h($clientLoan->client_detail->client_photo) ?>" width="80" height="80"><br>
                    <?= $clientLoan->has('client_detail') ? $this->Html->link($clientLoan->client_detail->client_name, ['controller' => 'ClientDetails', 'action' => 'view', $clientLoan->client_detail->id],['target' => '_blank']) : '' ?>
                </td>
                <td><?= $this->Number->toPercentage($clientLoan->rate_of_interest) ?></td>
                <td><?= $this->Number->currency($clientLoan->loan_amount) ?></td>
                <td><?= $status = ($clientLoan->status == 0) ? 'Running' : 'Complete'; ?></td>
                <td><?= h($clientLoan->created_date->format("d-M-Y")) ?></td>
<!--                <td>--><?php //h($clientLoan->modified_date) ?><!--</td>-->
                <td class="actions">
                    <?php
                    $today = date_create(date("Y-m-d H:i:s"));
                    if(isset($clientLoanLastPayment[$clientLoan->id]))
                    {
                        $dateDiff = date_diff($today, $clientLoanLastPayment[$clientLoan->id]);
                        if($dateDiff->y >= 1)
                            echo '<a href="#" onclick="openUserInputModal(this)" data-toggle="modal" id="'.$clientLoan->id.'" >Add Payment</a>'.' | ';
                        else if($dateDiff->y < 1 && $dateDiff->m > 1)
                            echo '<a href="#" onclick="openUserInputModal(this)" data-toggle="modal" id="'.$clientLoan->id.'" >Add Payment</a>'.' | ';
                    }
                    ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $clientLoan->id]) ?> |
                    <?php echo $this->Form->postLink(__('Delete'), ['action' => 'delete', $clientLoan->id], ['confirm' => __('Are you sure you want to delete # {0}?', $clientLoan->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div id="userInputModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Click on the appropriate button.</h4>
            </div>
            <div class="row modal-body">
                <div class="col-md-6" style="border-right: 1px solid black; padding: 5px;">
                    <p style="font-size: large;margin-left: 15px;">If this is newly created Loan, click this button.</p>
                    <input type="button" id="haveNoData" style=" float: right;" class="btn btn-warning" onclick="paymentRedirect(this)" value="I don't have data." /></div>
                <div class="col-md-6" style=" padding: 5px;">
                    <p style="font-size: large; margin-left: 15px;">If this is an old Loan, click this<br> button.</p>
                    <input type="button" id="haveData" style=" float: right;" class="btn btn-warning" onclick="paymentRedirect(this)" value="I have data." /></div>
                <?php
                //echo $this->Form->input('clientIdArray',['id' => 'clientIdValues','type' => 'hidden']);
                //                echo '<input type="hidden" name="clientId" id="clientIdValues" />';
                //                echo $this->Form->input('batch_name',['required' => 'required']);
                //                echo $this->Form->input('created_date',['value' => date("Y-m-d H:i:s"),'type' => 'hidden']);
                ?>
                <!--                --><?php //echo $this->Form->button(__('Submit')) ?>
                <!--                --><?php //echo $this->Form->end() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<script>
    function paymentRedirect(reference,id) {
        if(reference.id == "haveNoData")
            location.href = "/clientDetails/index";
        else if(reference.id == "haveData")
            location.href = "/ClientLoanPayments/add/"+id;
    }
    function openUserInputModal(ref) {
        $("#userInputModal").modal("show");
        document.getElementById('haveData').setAttribute("onclick","paymentRedirect(this,"+ref.id+")");
    }
</script>
<script>
    $(document).ready(function() {
        $.fn.dataTable.moment('D-MMM-YYYY');
        $('#clientLoanTable').DataTable({
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
    });
</script>

