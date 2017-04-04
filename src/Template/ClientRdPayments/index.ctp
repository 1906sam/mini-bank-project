<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Client Rd Payment'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Client Rd'), ['controller' => 'ClientRd', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Client Rd'), ['controller' => 'ClientRd', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="clientRdPayments index large-9 medium-8 columns content">
    <h3><?= __('Client Rd Payments') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('client_rd_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('installment_received') ?></th>
                <th scope="col"><?= $this->Paginator->sort('final_rd_amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('penalty') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified_date') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clientRdPayments as $clientRdPayment): ?>
            <tr>
                <td><?= $this->Number->format($clientRdPayment->id) ?></td>
                <td><?= $clientRdPayment->has('client_rd') ? $this->Html->link($clientRdPayment->client_rd->id, ['controller' => 'ClientRd', 'action' => 'view', $clientRdPayment->client_rd->id]) : '' ?></td>
                <td><?= $this->Number->format($clientRdPayment->installment_received) ?></td>
                <td><?= $this->Number->format($clientRdPayment->final_rd_amount) ?></td>
                <td><?= $this->Number->format($clientRdPayment->penalty) ?></td>
                <td><?= h($clientRdPayment->created_date) ?></td>
                <td><?= h($clientRdPayment->modified_date) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $clientRdPayment->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $clientRdPayment->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $clientRdPayment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $clientRdPayment->id)]) ?>
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
