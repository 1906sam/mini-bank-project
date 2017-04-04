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
                ['action' => 'delete', $clientLoan->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $clientLoan->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Client Loan'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Client Details'), ['controller' => 'ClientDetails', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Client Detail'), ['controller' => 'ClientDetails', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Client Loan Payments'), ['controller' => 'ClientLoanPayments', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Client Loan Payment'), ['controller' => 'ClientLoanPayments', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="clientLoan form large-9 medium-8 columns content">
    <?= $this->Form->create($clientLoan) ?>
    <fieldset>
        <legend><?= __('Edit Client Loan') ?></legend>
        <?php
            echo $this->Form->input('client_id', ['options' => $clientDetails]);
            echo $this->Form->input('rate_of_interest');
            echo $this->Form->input('loan_amount');
            echo $this->Form->input('status');
            echo $this->Form->input('created_date');
            echo $this->Form->input('modified_date', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
