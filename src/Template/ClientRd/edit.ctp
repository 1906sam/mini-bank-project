<?php
/**
  * @var \App\View\AppView $this
  */
?>
<link href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.css" rel="stylesheet"/>
<link href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.css" rel="stylesheet"/>

<div class="clientRd form large-9 medium-8 columns content">
    <?= $this->Form->create($clientRd) ?>
    <fieldset>
        <legend><?= __('Edit Client Rd') ?></legend>
        <?php
            echo $this->Form->input('client_id', ['options' => $clientDetails]);
            echo $this->Form->input('rd_amount',['label' => 'RD amount in Rs.']);
            echo $this->Form->input('rate_of_interest',['label' => 'Rate of Interest (%)']);
            echo $this->Form->input('time_duration',['label' => 'Time duration in years']);
            echo $this->Form->input('status',['options' => ['0' => 'Running', '1' => 'Complete'],'onchange' => 'onStatusChange(this)']);
            echo $this->Form->input('modified_date',['value' => date("Y-m-d H:i:s"),'type' => 'hidden']);
            echo $this->Form->input('old_rd',['type' => 'checkbox','id'=>'oldRdCheck','label' => 'Old RD','onclick' => 'showDatePicker(this);']);
            echo '<div class="form-group hide input-group date" id="rdStartDiv">'.
                '<label for="datetimepickerstart">Select Date</label>'.
                '<input type="text" name="select_date" value="'.$clientRd['created_date']->format("Y-m-d H:i:s").'"  class="form-control" id="datetimepickerstart" />'.
                '</div>';
            $modifiedDate = (($clientRd['status'] == 1) && isset($clientRd['modified_date']) && $clientRd['modified_date'] != '')? $clientRd['modified_date']->format("Y-m-d H:i:s") : "";
            echo '<div class="form-group hide input-group date" id="rdCloseDiv">'.
                '<label for="datetimepickerclose">Closing Date</label>'.
                '<input type="text" name="closing_date" value="'.$modifiedDate.'"  class="form-control" id="datetimepickerclose" />'.
                '</div>';
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/locale/pt-br.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>

<script>
    function onStatusChange(reference) {
        if(document.getElementById('oldRdCheck').checked)
        {
            var index = document.getElementById('status').value;
            if (index == 1) {
//                document.getElementById('datetimepickerclose').setAttribute('required', 'required');
                document.getElementById('rdCloseDiv').classList.remove('hide');
            }
            else if (index == 0)
            {
                document.getElementById('datetimepickerclose').value = '';
//                document.getElementById('datetimepickerclose').removeAttribute('required');
                document.getElementById('rdCloseDiv').classList.add('hide');
            }
        }
    }
    function showDatePicker() {
        if(document.getElementById('oldRdCheck').checked)
        {
            var index = document.getElementById('status').value;
            if(index == 1)
            {
//                document.getElementById('datetimepickerclose').setAttribute('required','required');
                document.getElementById('rdCloseDiv').classList.remove('hide');
            }
            else if(index == 0)
            {
//                document.getElementById('datetimepickerclose').removeAttribute('required');
                document.getElementById('rdCloseDiv').classList.add('hide');
            }

//            document.getElementById('datetimepickerstart').setAttribute('required','required');
            document.getElementById('rdStartDiv').classList.remove('hide');
        }
        else
        {
            document.getElementById('datetimepickerstart').value = '';
            document.getElementById('datetimepickerclose').value = '';
//            document.getElementById('datetimepickerstart').removeAttribute('required');
//            document.getElementById('datetimepickerclose').removeAttribute('required');
            document.getElementById('rdStartDiv').classList.add('hide');
            document.getElementById('rdCloseDiv').classList.add('hide');
        }
    }

    $(document).ready(function () {
        if(document.getElementById('oldRdCheck').checked && document.getElementById('status').value == 1)
        {
            document.getElementById('rdStartDiv').classList.remove('hide');
            document.getElementById('rdCloseDiv').classList.remove('hide');
        }
        else
            document.getElementById('rdStartDiv').classList.remove('hide');
    });
    $('#datetimepickerstart').datetimepicker({
        locale: 'en-in',
        maxDate: moment(),
        sideBySide : false,
//        calendarWeeks: true,
        format: 'YYYY-MM-DD HH:mm:ss',
        stepping: 1
    });

    $('#datetimepickerclose').datetimepicker({
        locale: 'en-in',
        maxDate: moment(),
        sideBySide : false,
//        calendarWeeks: true,
        format: 'YYYY-MM-DD HH:mm:ss',
        stepping: 1
    });

</script>
