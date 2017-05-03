<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Batch User'), ['action' => 'edit', $batchUser->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Batch User'), ['action' => 'delete', $batchUser->id], ['confirm' => __('Are you sure you want to delete # {0}?', $batchUser->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Batch User'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Batch User'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Batches'), ['controller' => 'Batches', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Batch'), ['controller' => 'Batches', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Client Details'), ['controller' => 'ClientDetails', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Client Detail'), ['controller' => 'ClientDetails', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="batchUser view large-9 medium-8 columns content">
    <h3><?= h($batchUser->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Batch') ?></th>
            <td><?= $batchUser->has('batch') ? $this->Html->link($batchUser->batch->id, ['controller' => 'Batches', 'action' => 'view', $batchUser->batch->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Client Detail') ?></th>
            <td><?= $batchUser->has('client_detail') ? $this->Html->link($batchUser->client_detail->id, ['controller' => 'ClientDetails', 'action' => 'view', $batchUser->client_detail->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($batchUser->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created Date') ?></th>
            <td><?= h($batchUser->created_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified Date') ?></th>
            <td><?= h($batchUser->modified_date) ?></td>
        </tr>
    </table>
</div>
