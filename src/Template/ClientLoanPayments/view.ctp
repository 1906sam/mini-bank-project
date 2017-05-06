<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Client Loan Payment'), ['action' => 'edit', $clientLoanPayment->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Client Loan Payment'), ['action' => 'delete', $clientLoanPayment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $clientLoanPayment->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Client Loan Payments'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Client Loan Payment'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Client Loan'), ['controller' => 'ClientLoan', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Client Loan'), ['controller' => 'ClientLoan', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="clientLoanPayments view large-9 medium-8 columns content">
    <h3><?= h($clientLoanPayment->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Client Loan') ?></th>
            <td><?= $clientLoanPayment->has('client_loan') ? $this->Html->link($clientLoanPayment->client_loan->id, ['controller' => 'ClientLoan', 'action' => 'view', $clientLoanPayment->client_loan->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($clientLoanPayment->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Interest Received') ?></th>
            <td><?= $this->Number->format($clientLoanPayment->interest_received) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Installment Received') ?></th>
            <td><?= $this->Number->format($clientLoanPayment->installment_received) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Final Loan Amount') ?></th>
            <td><?= $this->Number->format($clientLoanPayment->final_loan_amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created Date') ?></th>
            <td><?= h($clientLoanPayment->created_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified Date') ?></th>
            <td><?= h($clientLoanPayment->modified_date) ?></td>
        </tr>
    </table>
</div>
