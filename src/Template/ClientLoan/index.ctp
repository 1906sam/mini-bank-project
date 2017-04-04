<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Client Loan'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Client Details'), ['controller' => 'ClientDetails', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Client Detail'), ['controller' => 'ClientDetails', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Client Loan Payments'), ['controller' => 'ClientLoanPayments', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Client Loan Payment'), ['controller' => 'ClientLoanPayments', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="clientLoan index large-9 medium-8 columns content">
    <h3><?= __('Client Loan') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('client_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('rate_of_interest') ?></th>
                <th scope="col"><?= $this->Paginator->sort('loan_amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified_date') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clientLoan as $clientLoan): ?>
            <tr>
                <td><?= $this->Number->format($clientLoan->id) ?></td>
                <td><?= $clientLoan->has('client_detail') ? $this->Html->link($clientLoan->client_detail->id, ['controller' => 'ClientDetails', 'action' => 'view', $clientLoan->client_detail->id]) : '' ?></td>
                <td><?= $this->Number->format($clientLoan->rate_of_interest) ?></td>
                <td><?= $this->Number->format($clientLoan->loan_amount) ?></td>
                <td><?= $this->Number->format($clientLoan->status) ?></td>
                <td><?= h($clientLoan->created_date) ?></td>
                <td><?= h($clientLoan->modified_date) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $clientLoan->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $clientLoan->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $clientLoan->id], ['confirm' => __('Are you sure you want to delete # {0}?', $clientLoan->id)]) ?>
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
