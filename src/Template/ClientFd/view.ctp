<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Client Fd'), ['action' => 'edit', $clientFd->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Client Fd'), ['action' => 'delete', $clientFd->id], ['confirm' => __('Are you sure you want to delete # {0}?', $clientFd->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Client Fd'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Client Fd'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Client Details'), ['controller' => 'ClientDetails', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Client Detail'), ['controller' => 'ClientDetails', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="clientFd view large-9 medium-8 columns content">
    <h3><?= h($clientFd->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Client Detail') ?></th>
            <td><?= $clientFd->has('client_detail') ? $this->Html->link($clientFd->client_detail->id, ['controller' => 'ClientDetails', 'action' => 'view', $clientFd->client_detail->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($clientFd->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Fd Amount') ?></th>
            <td><?= $this->Number->format($clientFd->fd_amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Time Duration') ?></th>
            <td><?= $this->Number->format($clientFd->time_duration) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Rate Of Interest') ?></th>
            <td><?= $this->Number->format($clientFd->rate_of_interest) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= $this->Number->format($clientFd->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created Date') ?></th>
            <td><?= h($clientFd->created_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified Date') ?></th>
            <td><?= h($clientFd->modified_date) ?></td>
        </tr>
    </table>
</div>
