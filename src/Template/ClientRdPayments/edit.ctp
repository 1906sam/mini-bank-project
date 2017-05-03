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
                ['action' => 'delete', $clientRdPayment->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $clientRdPayment->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Client Rd Payments'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Client Rd'), ['controller' => 'ClientRd', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Client Rd'), ['controller' => 'ClientRd', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="clientRdPayments form large-9 medium-8 columns content">
    <?= $this->Form->create($clientRdPayment) ?>
    <fieldset>
        <legend><?= __('Edit Client Rd Payment') ?></legend>
        <?php
            echo $this->Form->input('client_rd_id', ['options' => $clientRd]);
            echo $this->Form->input('installment_received');
            echo $this->Form->input('final_rd_amount');
            echo $this->Form->input('penalty');
            echo $this->Form->input('created_date');
            echo $this->Form->input('modified_date', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
