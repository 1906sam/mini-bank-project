<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $clientLoanPayment->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $clientLoanPayment->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Client Loan Payments'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Client Loan'), ['controller' => 'ClientLoan', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Client Loan'), ['controller' => 'ClientLoan', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="clientLoanPayments form large-9 medium-8 columns content">
    <?= $this->Form->create($clientLoanPayment) ?>
    <fieldset>
        <legend><?= __('Edit Client Loan Payment') ?></legend>
        <?php
            echo $this->Form->input('client_loan_id', ['options' => $clientLoan]);
            echo $this->Form->input('interest_received');
            echo $this->Form->input('installment_received');
            echo $this->Form->input('final_loan_amount');
            echo $this->Form->input('created_date');
            echo $this->Form->input('modified_date', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
