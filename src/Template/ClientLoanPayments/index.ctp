<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Client Loan Payment'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Client Loan'), ['controller' => 'ClientLoan', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Client Loan'), ['controller' => 'ClientLoan', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="clientLoanPayments index large-9 medium-8 columns content">
    <h3><?= __('Client Loan Payments') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('client_loan_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('interest_received') ?></th>
                <th scope="col"><?= $this->Paginator->sort('installment_received') ?></th>
                <th scope="col"><?= $this->Paginator->sort('final_loan_amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified_date') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clientLoanPayments as $clientLoanPayment): ?>
            <tr>
                <td><?= $this->Number->format($clientLoanPayment->id) ?></td>
                <td><?= $clientLoanPayment->has('client_loan') ? $this->Html->link($clientLoanPayment->client_loan->id, ['controller' => 'ClientLoan', 'action' => 'view', $clientLoanPayment->client_loan->id]) : '' ?></td>
                <td><?= $this->Number->format($clientLoanPayment->interest_received) ?></td>
                <td><?= $this->Number->format($clientLoanPayment->installment_received) ?></td>
                <td><?= $this->Number->format($clientLoanPayment->final_loan_amount) ?></td>
                <td><?= h($clientLoanPayment->created_date) ?></td>
                <td><?= h($clientLoanPayment->modified_date) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $clientLoanPayment->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $clientLoanPayment->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $clientLoanPayment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $clientLoanPayment->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
