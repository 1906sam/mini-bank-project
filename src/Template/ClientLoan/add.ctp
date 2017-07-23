<?php
/**
  * @var \App\View\AppView $this
  */
?>

<link href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.css" rel="stylesheet"/>
<link href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.css" rel="stylesheet"/>

<div class="clientLoan form large-9 medium-8 columns content">
    <?= $this->Form->create($clientLoan) ?>
    <fieldset>
        <legend><?= __('Add Client Loan') ?></legend>
        <?php
            echo $this->Form->input('client_id', ['options' => $clientDataArray,'empty' => 'Select Client','label' => 'Select Client','id' => 'combobox']);
            echo $this->Form->input('loan_amount',['label' => 'Loan amount in Rs.']);
            echo $this->Form->input('rate_of_interest',['label' => 'Rate of Interest (%)','value' => 2]);
            echo $this->Form->input('status',['options' => ['0' => 'Running', '1' => 'Complete'],'onchange' => 'onStatusChange(this)','value' => 0]);
            echo $this->Form->input('old_loan',['type' => 'checkbox','id'=>'oldLoanCheck','label' => 'Old Loan','onclick' => 'showDatePicker(this);']);
            echo $this->Form->input('created_date',['value' => date("Y-m-d H:i:s"),'type' => 'hidden']);
            echo '<div class="form-group hide input-group date" id="loanStartDiv">'.
            '<label for="datetimepickerselect">Select Date</label>'.
            '<input type="text" name="select_date" class="form-control" id="datetimepickerstart" />'.
            '</div>';
            echo '<div class="form-group hide input-group date" id="loanCloseDiv">'.
            '<label for="datetimepickerclose">Closing Date</label>'.
            '<input type="text" name="closing_date" class="form-control" id="datetimepickerclose" />'.
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
        var index = document.getElementById('status').value;
        if(index == 1 && document.getElementById('oldLoanCheck').checked)
        {
            document.getElementById('datetimepickerclose').setAttribute('required','required');
            document.getElementById('loanCloseDiv').classList.remove('hide');
        }
        else if(index == 0)
        {
            document.getElementById('datetimepickerclose').value = '';
            document.getElementById('datetimepickerclose').removeAttribute('required');
            document.getElementById('loanCloseDiv').classList.add('hide');
        }
    }
    function showDatePicker() {
        if(document.getElementById('oldLoanCheck').checked)
        {
            var index = document.getElementById('status').value;
            if(index == 1)
            {
                document.getElementById('datetimepickerclose').setAttribute('required','required');
                document.getElementById('loanCloseDiv').classList.remove('hide');
            }
            else if(index == 0)
            {
                document.getElementById('datetimepickerclose').removeAttribute('required');
                document.getElementById('loanCloseDiv').classList.add('hide');
            }

            document.getElementById('datetimepickerstart').setAttribute('required','required');
            document.getElementById('loanStartDiv').classList.remove('hide');
        }
        else
        {
            document.getElementById('datetimepickerstart').value = '';
            document.getElementById('datetimepickerclose').value = '';
            document.getElementById('datetimepickerstart').removeAttribute('required');
            document.getElementById('datetimepickerclose').removeAttribute('required');
            document.getElementById('loanStartDiv').classList.add('hide');
            document.getElementById('loanCloseDiv').classList.add('hide');
        }
    }

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
