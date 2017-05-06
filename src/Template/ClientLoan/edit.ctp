<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="clientLoan form large-9 medium-8 columns content">
    <?= $this->Form->create($clientLoan) ?>
    <fieldset>
        <legend><?= __('Edit Client Loan') ?></legend>
        <?php
            echo $this->Form->input('client_id', ['options' => $clientDataArray,'label' => 'Select Client','id' => 'combobox']);
            echo $this->Form->input('loan_amount',['label' => 'Loan amount in Rs.']);
            echo $this->Form->input('rate_of_interest',['label' => 'Rate of Interest (%)']);
            echo $this->Form->input('status',['options' => ['0' => 'Running', '1' => 'Complete']]);
//            echo $this->Form->input('created_date',['value' => date("Y-m-d H:i:s"),'type' => 'hidden']);
            echo $this->Form->input('modified_date',['value' => date("Y-m-d H:i:s"),'type' => 'hidden']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
