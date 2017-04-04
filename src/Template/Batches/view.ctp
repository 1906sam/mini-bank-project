<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Batch'), ['action' => 'edit', $batch->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Batch'), ['action' => 'delete', $batch->id], ['confirm' => __('Are you sure you want to delete # {0}?', $batch->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Batches'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Batch'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Client Details'), ['controller' => 'ClientDetails', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Client Detail'), ['controller' => 'ClientDetails', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="batches view large-9 medium-8 columns content">
    <h3><?= h($batch->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Client Detail') ?></th>
            <td><?= $batch->has('client_detail') ? $this->Html->link($batch->client_detail->id, ['controller' => 'ClientDetails', 'action' => 'view', $batch->client_detail->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($batch->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Batch Name') ?></th>
            <td><?= $this->Number->format($batch->batch_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= $this->Number->format($batch->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created Date') ?></th>
            <td><?= h($batch->created_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified Date') ?></th>
            <td><?= h($batch->modified_date) ?></td>
        </tr>
    </table>
</div>
