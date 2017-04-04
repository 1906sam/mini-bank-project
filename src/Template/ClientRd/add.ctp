<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Client Rd'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Client Details'), ['controller' => 'ClientDetails', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Client Detail'), ['controller' => 'ClientDetails', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Client Rd Payments'), ['controller' => 'ClientRdPayments', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Client Rd Payment'), ['controller' => 'ClientRdPayments', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="clientRd form large-9 medium-8 columns content">
    <?= $this->Form->create($clientRd) ?>
    <fieldset>
        <legend><?= __('Add Client Rd') ?></legend>
        <?php
            echo $this->Form->input('client_id', ['options' => $clientDetails]);
            echo $this->Form->input('rd_amount');
            echo $this->Form->input('rate_of_interest');
            echo $this->Form->input('time_duration');
            echo $this->Form->input('status');
            echo $this->Form->input('created_date');
            echo $this->Form->input('modified_date');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
