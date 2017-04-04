<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Client Loan'), ['action' => 'edit', $clientLoan->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Client Loan'), ['action' => 'delete', $clientLoan->id], ['confirm' => __('Are you sure you want to delete # {0}?', $clientLoan->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Client Loan'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Client Loan'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Client Details'), ['controller' => 'ClientDetails', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Client Detail'), ['controller' => 'ClientDetails', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Client Loan Payments'), ['controller' => 'ClientLoanPayments', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Client Loan Payment'), ['controller' => 'ClientLoanPayments', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="clientLoan view large-9 medium-8 columns content">
    <h3><?= h($clientLoan->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Client Detail') ?></th>
            <td><?= $clientLoan->has('client_detail') ? $this->Html->link($clientLoan->client_detail->id, ['controller' => 'ClientDetails', 'action' => 'view', $clientLoan->client_detail->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($clientLoan->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Rate Of Interest') ?></th>
            <td><?= $this->Number->format($clientLoan->rate_of_interest) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Loan Amount') ?></th>
            <td><?= $this->Number->format($clientLoan->loan_amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= $this->Number->format($clientLoan->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created Date') ?></th>
            <td><?= h($clientLoan->created_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified Date') ?></th>
            <td><?= h($clientLoan->modified_date) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Client Loan Payments') ?></h4>
        <?php if (!empty($clientLoan->client_loan_payments)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Client Loan Id') ?></th>
                <th scope="col"><?= __('Interest Received') ?></th>
                <th scope="col"><?= __('Installment Received') ?></th>
                <th scope="col"><?= __('Final Loan Amount') ?></th>
                <th scope="col"><?= __('Created Date') ?></th>
                <th scope="col"><?= __('Modified Date') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($clientLoan->client_loan_payments as $clientLoanPayments): ?>
            <tr>
                <td><?= h($clientLoanPayments->id) ?></td>
                <td><?= h($clientLoanPayments->client_loan_id) ?></td>
                <td><?= h($clientLoanPayments->interest_received) ?></td>
                <td><?= h($clientLoanPayments->installment_received) ?></td>
                <td><?= h($clientLoanPayments->final_loan_amount) ?></td>
                <td><?= h($clientLoanPayments->created_date) ?></td>
                <td><?= h($clientLoanPayments->modified_date) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'ClientLoanPayments', 'action' => 'view', $clientLoanPayments->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'ClientLoanPayments', 'action' => 'edit', $clientLoanPayments->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'ClientLoanPayments', 'action' => 'delete', $clientLoanPayments->id], ['confirm' => __('Are you sure you want to delete # {0}?', $clientLoanPayments->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
