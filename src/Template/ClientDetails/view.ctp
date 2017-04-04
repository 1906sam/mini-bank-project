<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Client Detail'), ['action' => 'edit', $clientDetail->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Client Detail'), ['action' => 'delete', $clientDetail->id], ['confirm' => __('Are you sure you want to delete # {0}?', $clientDetail->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Client Details'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Client Detail'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="clientDetails view large-9 medium-8 columns content">
    <h3><?= h($clientDetail->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Client Name') ?></th>
            <td><?= h($clientDetail->client_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Introducer Person') ?></th>
            <td><?= h($clientDetail->introducer_person) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Client Photo') ?></th>
            <td><?= h($clientDetail->client_photo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Client Sign Photo') ?></th>
            <td><?= h($clientDetail->client_sign_photo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($clientDetail->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Mobile') ?></th>
            <td><?= $this->Number->format($clientDetail->mobile) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= $this->Number->format($clientDetail->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created Date') ?></th>
            <td><?= h($clientDetail->created_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified Date') ?></th>
            <td><?= h($clientDetail->modified_date) ?></td>
        </tr>
    </table>
</div>
