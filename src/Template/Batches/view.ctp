<?php
/**
  * @var \App\View\AppView $this
  */
?>

    <div class="batchUser index large-9 medium-8 columns content">
        <h1 style="text-align: center; text-decoration: underline"><?= __('Batch Users Detail') ?></h1>
        <input type="button" class="btn btn-info btn-lg" id="paymentButton" onclick="onMakePayment(this);" data-toggle="modal" data-target="#myBatchModal" value="Make Payments""/>
        <table id="batchUserTable" class="table table-striped table-bordered table-condensed dt-responsive nowrap" cellspacing="0"  width="100%">
            <thead>
            <tr>
                <th>S.No.</th>
                <th>Batch Name</th>
                <th>Client Name</th>
                <th>RD Amount</th>
                <th>Loan Amount</th>
                <th>FD Amount</th>
                <th>Created Date</th>
<!--                <th>modified_date</th>-->
<!--                <th>Actions</th>-->
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
                    <td><?= h($batchUser->batch->batch_name) ?></td>
                    <td>
                        <img src="<?= h($batchUser->client_detail->client_photo) ?>" width="80" height="80"><br>
                        <?= $batchUser->has('client_detail') ? $this->Html->link($batchUser->client_detail->client_name, ['controller' => 'ClientDetails', 'action' => 'view', $batchUser->client_detail->id]) : '' ?></td>
                    <td><?= $this->Number->currency($totalRdAmountRequired[$batchUser->client_detail->id]); ?></td>
                    <td><?= $this->Number->currency($totalLoanAmountRequired[$batchUser->client_detail->id]); ?></td>
                    <td><?= $this->Number->currency($totalFdAmountRequired[$batchUser->client_detail->id]); ?></td>
                    <td><?= $batchUser->created_date->format("d-M-Y"); ?></td>
<!--                    <td>--><?php ////echo h($batchUser->modified_date) ?><!--</td>-->
<!--                    <td class="actions">-->
                        <?php //echo $this->Html->link(__('View'), ['action' => 'view', $batchUser->id]) ?>
                        <?php //echo $this->Html->link(__('Edit'), ['action' => 'edit', $batchUser->id]) ?>
                        <?php //echo $this->Form->postLink(__('Delete'), ['action' => 'delete', $batchUser->id], ['confirm' => __('Are you sure you want to delete # {0}?', $batchUser->id)]) ?>
<!--                    </td>-->
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
                <h4 class="modal-title">Enter information for batch payments:</h4>
            </div>
            <div class="modal-body">
                <?= $this->Form->create(null,['method' => 'POST','id' => 'clientBatchPaymentFormId','name' => 'clientBatchPaymentName','class'=>'form']) ?>
                <?php
                //echo $this->Form->input('clientIdArray',['id' => 'clientIdValues','type' => 'hidden']);
//                echo '<input type="hidden" name="clientId" id="clientIdValues" />';
                echo '<input type="hidden" name="clientId" id="clientIdValues" value=""/>';
                echo '<input type="hidden" name="formSubmit" id="formSubmitValues" />';
                echo $this->Form->input('total_amount',['required' => 'required','id' => 'totalAmount','label' => 'Total amount *','type' => 'number']);
                echo $this->Form->input('penalty',['type' => 'number','id' => 'penaltyValue']);
                echo $this->Form->input('loan_installment_received',['type' => 'number','id' => 'loanInstallemntValue']);
//                echo $this->Form->input('old_loan',['type' => 'checkbox','id'=>'oldLoanCheck','label' => 'Old Loan','onclick' => 'showDatePicker(this);']);
                echo $this->Form->input('created_date',['value' => date("Y-m-d H:i:s"),'type' => 'hidden']);
                echo '<div class="form-group hide input-group date" id="loanDiv">'.
                    '<label for="datetimepicker">Select Date</label>'.
                    '<input type="text" class="form-control" id="datetimepicker" />'.
                    '</div>';
                ?>
                <?= $this->Form->button('Submit',['onclick' => 'callMe();']) ?>
                <?= $this->Form->end() ?>
            </div>
            <div class="modal-footer">
                <p style="font-size: small; color: red; float: left; width: auto;">Field marked * are mandatory.</p>
                <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<script src="/js/jsCookie.js"></script>
<script>
    function onMakePayment(reference) {
        var webURL = location.protocol + "//" + location.host;
        var csrfToken = Cookies.get('csrfToken');
        document.getElementById(reference.id).setAttribute("data-target","");
        $.ajax({
            url: webURL + '/batches/view/<?= $id ?>',
            type: "POST",
            beforeSend: function(xhr){
                xhr.setRequestHeader('X-CSRF-Token', csrfToken);
            },
            data: {
//                clientId: userIdArray[0]
            },
            success: function (data)
            {
                if(data.indexOf(",") != -1)
                {
                    var dataValues = data.split(',');
                    var classList = document.getElementById("myBatchModal").classList;
                    document.getElementById("myBatchModal").classList.remove("hide");
                    document.getElementById(reference.id).setAttribute("data-target","#myBatchModal");
                    $('#myBatchModal').modal();
                    document.getElementById('penaltyValue').value = dataValues[0];
                    document.getElementById('totalAmount').value = dataValues[1];
                    if(dataValues[2] == 0)
                    {
                        document.getElementById('loanInstallemntValue').setAttribute('disabled','disabled');
                        document.getElementById('loanInstallemntValue').setAttribute('title','Loan payment received or loan doesn\'t exist.');
                    }
                    document.getElementById(reference.id).setAttribute("data-target","");
                }
                else if(data == "<?php echo NO_DATA; ?>")
                {
                    alert(data);
                    document.getElementById(reference.id).setAttribute("data-target","");
//                        document.getElementById("myBatchModal").classList.add("hide");
                }
                else if(data == "<?php echo PAYMENT_DONE; ?>")
                {
                    document.getElementById(reference.id).setAttribute("data-target","");
                    document.getElementById("myBatchModal").classList.add("hide");
                    alert(data);
                }
            }
        });

    }
</script>
<script>
    function showDatePicker() {
        if(document.getElementById('oldLoanCheck').checked)
            document.getElementById('loanDiv').classList.remove('hide');
        else
            document.getElementById('loanDiv').classList.add('hide');
    }

    $('#datetimepicker').datetimepicker({
        locale: 'en-in',
        maxDate: moment(),
        sideBySide : false,
//        calendarWeeks: true,
        format: 'YYYY-MM-DD HH:mm:ss',
        stepping: 1
    });

</script>

<script>
    function callMe() {
        document.getElementById('formSubmitValues').value = 1;
    }
    $(document).ready(function() {
        $.fn.dataTable.moment('D-MMM-YYYY');
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
                style: 'os',
                selector: 'td:first-child'
            },
            order: [[1, 'asc']]
        });
    });
    </script>
