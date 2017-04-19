<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Client Rd Payment'), ['action' => 'edit', $clientRdPayment->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Client Rd Payment'), ['action' => 'delete', $clientRdPayment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $clientRdPayment->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Client Rd Payments'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Client Rd Payment'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Client Rd'), ['controller' => 'ClientRd', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Client Rd'), ['controller' => 'ClientRd', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="clientRdPayments view large-9 medium-8 columns content">
    <h3><?= h($clientRdPayment->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Client Rd') ?></th>
            <td><?= $clientRdPayment->has('client_rd') ? $this->Html->link($clientRdPayment->client_rd->id, ['controller' => 'ClientRd', 'action' => 'view', $clientRdPayment->client_rd->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($clientRdPayment->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Installment Received') ?></th>
            <td><?= $this->Number->format($clientRdPayment->installment_received) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Final Rd Amount') ?></th>
            <td><?= $this->Number->format($clientRdPayment->final_rd_amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Penalty') ?></th>
            <td><?= $this->Number->format($clientRdPayment->penalty) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created Date') ?></th>
            <td><?= h($clientRdPayment->created_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified Date') ?></th>
            <td><?= h($clientRdPayment->modified_date) ?></td>
        </tr>
    </table>
</div>
