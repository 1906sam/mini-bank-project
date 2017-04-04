<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Client Rd'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Client Details'), ['controller' => 'ClientDetails', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Client Detail'), ['controller' => 'ClientDetails', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Client Rd Payments'), ['controller' => 'ClientRdPayments', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Client Rd Payment'), ['controller' => 'ClientRdPayments', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="clientRd index large-9 medium-8 columns content">
    <h3><?= __('Client Rd') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('client_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('rd_amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('rate_of_interest') ?></th>
                <th scope="col"><?= $this->Paginator->sort('time_duration') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified_date') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clientRd as $clientRd): ?>
            <tr>
                <td><?= $this->Number->format($clientRd->id) ?></td>
                <td><?= $clientRd->has('client_detail') ? $this->Html->link($clientRd->client_detail->id, ['controller' => 'ClientDetails', 'action' => 'view', $clientRd->client_detail->id]) : '' ?></td>
                <td><?= $this->Number->format($clientRd->rd_amount) ?></td>
                <td><?= $this->Number->format($clientRd->rate_of_interest) ?></td>
                <td><?= $this->Number->format($clientRd->time_duration) ?></td>
                <td><?= $this->Number->format($clientRd->status) ?></td>
                <td><?= h($clientRd->created_date) ?></td>
                <td><?= $this->Number->format($clientRd->modified_date) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $clientRd->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $clientRd->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $clientRd->id], ['confirm' => __('Are you sure you want to delete # {0}?', $clientRd->id)]) ?>
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
