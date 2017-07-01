<?php
/**
  * @var \App\View\AppView $this
  */
?>

<div class="clientDetails index large-9 medium-8 columns content">
    <h1><p  style="text-align: center; text-decoration: underline;">Client Details</p></h1>
    <input type="button" id="paymentButton" class="btn btn-info btn-lg" data-toggle="modal" data-target="" value="Make Payment" onclick="createBatch(this);"/>
    <table id="clientDetailsTable" class="table table-striped table-bordered table-condensed" cellspacing="0"  width="100%">
        <thead>
            <tr>
                <th>#</th>
                <th>S.No.</th>
                <th>Client Name</th>
                <th>Mobile</th>
                <th>Introducer Person</th>
                <th>Client photo</th>
                <th>Client Sign photo</th>
                <th>Address</th>
                <th>Status</th>
                <th>Created Date</th>
<!--                <th >--><?php //$this->Paginator->sort('modified_date') ?><!--</th>-->
                <th class="actions">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $count = 0; $class = "";
            foreach ($clientDetails as $clientDetail): $count++;
                if($count %2 == 0)
                    $class = "";
                else
                    //$class = "success";
                ?>
            <tr class="<?= $class; ?>">
                <td>
                    <?php
                    $clientRdModel = \Cake\ORM\TableRegistry::get('ClientRd');
                    $clientRdData = $clientRdModel->find('all', [
                        'conditions' => ['client_id' => $clientDetail->id,'status' => 0]
                    ])->toArray();

                    if(!empty($clientRdData)) {
                ?>
                <input type="checkbox" id="<?=  $clientDetail->id; ?>" class="radio_check">
                <?php } else {
                        echo '<input type="checkbox" disabled="disabled" title="Payment Can\'t be made from here." id="<?=  $clientDetail->id; ?> " class="radio_check">';
                    }
                ?>
                </td>
                <td><?= $this->Number->format($count) ?></td>
                <td><?= h($clientDetail->client_name) ?></td>
                <td><?= $clientDetail->mobile ?></td>
                <td><?= h($clientDetail->introducer_person) ?></td>
                <td><img src="<?= h($clientDetail->client_photo) ?>" width="80" height="80"></td>
                <td><img src="<?= h($clientDetail->client_sign_photo) ?>" width="80" height="80"></td>
                <td><?= h($clientDetail->client_address) ?></td>
                <td><?php
                    echo $status = ($clientDetail->status == 1)? "Active" : "Not active";
                    ?></td>
                <td><?= h($clientDetail->created_date->format("d-M-Y")) ?></td>
<!--                <td>--><?php // h($clientDetail->modified_date) ?><!--</td>-->
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $clientDetail->id],['target' => '_blank']) ?> |
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $clientDetail->id]) ?>
                    <?php //echo $this->Form->postLink(__('Delete'), ['action' => 'delete', $clientDetail->id], ['confirm' => __('Are you sure you want to delete # {0}?', $clientDetail->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div id="myPaymentModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Enter Information.</h4>
            </div>
            <div class="modal-body">
                <?= $this->Form->create(null,['method' => 'POST','id' => 'paymentFormId','name' => 'paymentNameForm','url' => '/clientDetails/payments','class'=>'form']) ?>
                <?php
                    //echo $this->Form->input('clientIdArray',['id' => 'clientIdValues','type' => 'hidden']);
                    echo '<input type="hidden" name="clientId" id="clientIdValues" value=""/>';
                    echo '<input type="hidden" name="formSubmit" id="formSubmitValues" />';
                    echo $this->Form->input('total_amount',['required' => 'required','id' => 'totalAmount','label' => 'Total amount *','type' => 'number']);
                    echo $this->Form->input('penalty',['type' => 'number','id' => 'penaltyValue']);
                    echo $this->Form->input('loan_installment_received',['type' => 'number','id' => 'loanInstallemntValue']);
//                    echo $this->Form->input('old_rd',['type' => 'checkbox','id'=>'oldRdCheck','label' => 'Old RD','onclick' => 'showDatePicker(this);']);
                    echo $this->Form->input('created_date',['value' => date("Y-m-d H:i:s"),'type' => 'hidden']);
                    echo '<div class="form-group hide input-group date" id="rdDiv">'.
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

<script>
    function showDatePicker() {
        if(document.getElementById('oldRdCheck').checked)
            document.getElementById('rdDiv').classList.remove('hide');
        else
            document.getElementById('rdDiv').classList.add('hide');
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
        $('#clientDetailsTable').DataTable({
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
            /**columnDefs: [
             { type: 'de_datetime', targets: 0 },
             { type: 'de_date', targets: 1 }
             ],**/
//        select: {
//            style:    'os',
//            selector: 'td:first-child'
//        },
            order: [[1, 'asc']]
        });
    });
</script>
<script src="/js/jsCookie.js"></script><script>
    function createBatch(reference) {
        var checkboxes = document.getElementsByClassName('radio_check');
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

        if(formSubmit && countOfCheckbox == 1)
        {
            var webURL = location.protocol + "//" + location.host;
            var csrfToken = Cookies.get('csrfToken');
            document.getElementById('clientIdValues').value = userIdArray[0];
            document.getElementById(reference.id).setAttribute("data-target","");
            $.ajax({
                url: webURL + '/clientDetails/payments',
                type: "POST",
                beforeSend: function(xhr){
                    xhr.setRequestHeader('X-CSRF-Token', csrfToken);
                },
                data: {
                    clientId: userIdArray[0]
                },
                success: function (data)
                {
                    if(data.indexOf(",") != -1)
                    {
                        var dataValues = data.split(',');
                        var classList = document.getElementById("myPaymentModal").classList;
                        document.getElementById("myPaymentModal").classList.remove("hide");
                        document.getElementById(reference.id).setAttribute("data-target","#myPaymentModal");
                        $('#myPaymentModal').modal();
                        document.getElementById('penaltyValue').value = dataValues[0];
                        document.getElementById('totalAmount').value = dataValues[1];
                        if(dataValues[2] == 0)
                        {
                            document.getElementById('loanInstallemntValue').setAttribute('disabled','disabled');
                            document.getElementById('loanInstallemntValue').setAttribute('title','Loan doesn\'t exist.');
                        }
                        document.getElementById(reference.id).setAttribute("data-target","");
                    }
                    else if(data == "<?php echo NO_DATA; ?>")
                    {
                        alert(data);
                        document.getElementById(reference.id).setAttribute("data-target","");
//                        document.getElementById("myPaymentModal").classList.add("hide");
                    }
                    else if(data == "<?php echo PAYMENT_DONE; ?>")
                    {
                        document.getElementById(reference.id).setAttribute("data-target","");
                        document.getElementById("myPaymentModal").classList.add("hide");
                        alert(data);
                    }
                }
            });

//            alert(JSON.stringify(userIdArray));
        }
        else if(formSubmit && countOfCheckbox > 1)
        {
            alert("Payment can be made for one client at a time.");
            document.getElementById(reference.id).setAttribute("data-target","");
        }
    }
</script>
