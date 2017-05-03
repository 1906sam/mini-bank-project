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
                ['action' => 'delete', $batchUser->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $batchUser->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Batch User'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Batches'), ['controller' => 'Batches', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Batch'), ['controller' => 'Batches', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Client Details'), ['controller' => 'ClientDetails', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Client Detail'), ['controller' => 'ClientDetails', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="batchUser form large-9 medium-8 columns content">
    <?= $this->Form->create($batchUser) ?>
    <fieldset>
        <legend><?= __('Edit Batch User') ?></legend>
        <?php
            echo $this->Form->input('batch_id', ['options' => $batches]);
            echo $this->Form->input('client_id', ['options' => $clientDetails]);
            echo $this->Form->input('created_date');
            echo $this->Form->input('modified_date', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
