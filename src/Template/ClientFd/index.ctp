<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Client Fd'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Client Details'), ['controller' => 'ClientDetails', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Client Detail'), ['controller' => 'ClientDetails', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="clientFd index large-9 medium-8 columns content">
    <h3><?= __('Client Fd') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('client_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('fd_amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('time_duration') ?></th>
                <th scope="col"><?= $this->Paginator->sort('rate_of_interest') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified_date') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clientFd as $clientFd): ?>
            <tr>
                <td><?= $this->Number->format($clientFd->id) ?></td>
                <td><?= $clientFd->has('client_detail') ? $this->Html->link($clientFd->client_detail->id, ['controller' => 'ClientDetails', 'action' => 'view', $clientFd->client_detail->id]) : '' ?></td>
                <td><?= $this->Number->format($clientFd->fd_amount) ?></td>
                <td><?= $this->Number->format($clientFd->time_duration) ?></td>
                <td><?= $this->Number->format($clientFd->rate_of_interest) ?></td>
                <td><?= $this->Number->format($clientFd->status) ?></td>
                <td><?= h($clientFd->created_date) ?></td>
                <td><?= h($clientFd->modified_date) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $clientFd->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $clientFd->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $clientFd->id], ['confirm' => __('Are you sure you want to delete # {0}?', $clientFd->id)]) ?>
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
