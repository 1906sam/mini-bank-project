<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Client Detail'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="clientDetails index large-9 medium-8 columns content">
    <h3><?= __('Client Details') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('client_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('mobile') ?></th>
                <th scope="col"><?= $this->Paginator->sort('introducer_person') ?></th>
                <th scope="col"><?= $this->Paginator->sort('client_photo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('client_sign_photo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified_date') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clientDetails as $clientDetail): ?>
            <tr>
                <td><?= $this->Number->format($clientDetail->id) ?></td>
                <td><?= h($clientDetail->client_name) ?></td>
                <td><?= $this->Number->format($clientDetail->mobile) ?></td>
                <td><?= h($clientDetail->introducer_person) ?></td>
                <td><?= h($clientDetail->client_photo) ?></td>
                <td><?= h($clientDetail->client_sign_photo) ?></td>
                <td><?= $this->Number->format($clientDetail->status) ?></td>
                <td><?= h($clientDetail->created_date) ?></td>
                <td><?= h($clientDetail->modified_date) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $clientDetail->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $clientDetail->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $clientDetail->id], ['confirm' => __('Are you sure you want to delete # {0}?', $clientDetail->id)]) ?>
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
