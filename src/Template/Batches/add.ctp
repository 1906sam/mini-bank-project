<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Batches'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Batch User'), ['controller' => 'BatchUser', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Batch User'), ['controller' => 'BatchUser', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="batches form large-9 medium-8 columns content">
    <?= $this->Form->create($batch) ?>
    <fieldset>
        <legend><?= __('Add Batch') ?></legend>
        <?php
            echo $this->Form->input('batch_name');
            echo $this->Form->input('status');
            echo $this->Form->input('created_date');
            echo $this->Form->input('modified_date', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
