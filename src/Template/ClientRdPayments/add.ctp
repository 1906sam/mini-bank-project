<?php
/**
  * @var \App\View\AppView $this
  */
?>

<link href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.css" rel="stylesheet"/>
<link href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.css" rel="stylesheet"/>

<div class="clientRdPayments form large-9 medium-8 columns content">
    <?= $this->Form->create($clientRdPaymentEntity) ?>
    <fieldset>
        <legend><?= __('Add Client\'s RD Payment') ?></legend>
        <?php
            echo $this->Form->input('client_rd_id', ['options' => $clientRdInfo]);
            echo $this->Form->input('installment_received',['label' => 'Installment amount in Rs.']);
//            echo $this->Form->input('final_rd_amount',['value' => ]);
            echo $this->Form->input('penalty',['label' => 'Penalty amount in Rs.']);
            echo $this->Form->input('created_date',['value' => date("Y-m-d H:i:s"),'type' => 'hidden']);

            if(!(isset($rd_amount) && isset($penalty)))
            {
                echo $this->Form->input('status',['options' => ['0' => 'Old Payment', '1' => 'New Payment'],'value' => 0]);
                echo $this->Form->input('old_rd',['type' => 'checkbox','id'=>'oldRdCheck','checked' => 'checked','label' => 'Old RD','onclick' => 'showDatePicker(this);']);
                echo '<div class="form-group input-group date" id="rdDiv">'.
                '<label for="datetimepicker">Select Date</label>'.
                '<input type="text" required="required" name="select_date" class="form-control" id="datetimepicker" />'.
                '</div>';
            }
            else
            {
                echo $this->Form->input('status',['options' => ['0' => 'Old Payment', '1' => 'New Payment'],'value' => 1]);
                echo $this->Form->input('old_rd',['type' => 'checkbox','id'=>'oldRdCheck','label' => 'Old RD','onclick' => 'showDatePicker(this);']);
                echo '<div class="form-group hide input-group date" id="rdDiv">'.
                    '<label for="datetimepicker">Select Date</label>'.
                    '<input type="text" required="required"  name="select_date"  class="form-control" id="datetimepicker" />'.
                    '</div>';
            }
//            echo $this->Form->input('modified_date', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/locale/pt-br.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>

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

