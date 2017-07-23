<?php
/**
  * @var \App\View\AppView $this
  */
?>
<link href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.css" rel="stylesheet"/>
<link href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.css" rel="stylesheet"/>

<div class="clientLoanPayments form large-9 medium-8 columns content">
    <?= $this->Form->create($clientLoanPayment) ?>
    <fieldset>
        <legend><?= __('Add Client Loan Payment') ?></legend>
        <?php
            $interestValue = null;
            echo $this->Form->input('client_loan_id', ['options' => $clientLoanInfo,'label' => 'Client name: ']);
//            if(empty($loanAfterwards))
//            {
//                $interestValue = $loanDataOriginal['loan_amount'] * ($loanDataOriginal['rate_of_interest']/100);
//            }
//            else
//            {
//                $interestValue = $loanAfterwards[0]['final_loan_amount'] * ($loanDataOriginal['rate_of_interest']/100);
//            }
            echo $this->Form->input('interest_received',['id' => 'interestReceived','label' => 'Interest Received (Rs.)']);
            echo $this->Form->input('installment_received',['id' => 'installmentReceived','label' => 'Installment Received (Rs.)']);
            echo $this->Form->input('status',['options' => ['0' => 'Old Payment', '1' => 'New Payment'],'value' => 1]);
            echo $this->Form->input('old_loan',['type' => 'checkbox','id'=>'oldLoanCheck','checked' => true,'label' => 'Old Loan','onclick' => 'showDatePicker(this);']);
//            echo $this->Form->label('final_loan_amount',['label' => 'Loan amount (Rs.): ','text' => $loan_amount]);
            echo $this->Form->input('created_date',['value' => date("Y-m-d H:i:s"),'type' => 'hidden']);
            echo '<div class="form-group input-group date" id="loanDiv">'.
                '<label for="datetimepicker">Select Date</label>'.
                '<input type="text" class="form-control" required="required" name="select_date" id="datetimepicker" />'.
                '</div>';
//            echo $this->Form->input('modified_date', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/locale/pt-br.js"></script>
<!--<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.js"></script>-->
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>

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

