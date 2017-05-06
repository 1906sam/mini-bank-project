<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="clientLoan form large-9 medium-8 columns content">
    <?= $this->Form->create($clientLoan) ?>
    <fieldset>
        <legend><?= __('Add Client Loan') ?></legend>
        <?php
            echo $this->Form->input('client_id', ['options' => $clientDataArray,'empty' => 'Select Client','label' => 'Select Client','id' => 'combobox']);
            echo $this->Form->input('loan_amount',['label' => 'Loan amount in Rs.']);
            echo $this->Form->input('rate_of_interest',['label' => 'Rate of Interest (%)']);
            echo $this->Form->input('status',['options' => ['0' => 'Running', '1' => 'Complete'],'value' => 0]);
            echo $this->Form->input('created_date',['value' => date("Y-m-d H:i:s"),'type' => 'hidden']);
//            echo $this->Form->input('modified_date', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
