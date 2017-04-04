<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Client Rd'), ['action' => 'edit', $clientRd->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Client Rd'), ['action' => 'delete', $clientRd->id], ['confirm' => __('Are you sure you want to delete # {0}?', $clientRd->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Client Rd'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Client Rd'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Client Details'), ['controller' => 'ClientDetails', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Client Detail'), ['controller' => 'ClientDetails', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Client Rd Payments'), ['controller' => 'ClientRdPayments', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Client Rd Payment'), ['controller' => 'ClientRdPayments', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="clientRd view large-9 medium-8 columns content">
    <h3><?= h($clientRd->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Client Detail') ?></th>
            <td><?= $clientRd->has('client_detail') ? $this->Html->link($clientRd->client_detail->id, ['controller' => 'ClientDetails', 'action' => 'view', $clientRd->client_detail->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($clientRd->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Rd Amount') ?></th>
            <td><?= $this->Number->format($clientRd->rd_amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Rate Of Interest') ?></th>
            <td><?= $this->Number->format($clientRd->rate_of_interest) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Time Duration') ?></th>
            <td><?= $this->Number->format($clientRd->time_duration) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= $this->Number->format($clientRd->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified Date') ?></th>
            <td><?= $this->Number->format($clientRd->modified_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created Date') ?></th>
            <td><?= h($clientRd->created_date) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Client Rd Payments') ?></h4>
        <?php if (!empty($clientRd->client_rd_payments)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Client Rd Id') ?></th>
                <th scope="col"><?= __('Installment Received') ?></th>
                <th scope="col"><?= __('Final Rd Amount') ?></th>
                <th scope="col"><?= __('Penalty') ?></th>
                <th scope="col"><?= __('Created Date') ?></th>
                <th scope="col"><?= __('Modified Date') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($clientRd->client_rd_payments as $clientRdPayments): ?>
            <tr>
                <td><?= h($clientRdPayments->id) ?></td>
                <td><?= h($clientRdPayments->client_rd_id) ?></td>
                <td><?= h($clientRdPayments->installment_received) ?></td>
                <td><?= h($clientRdPayments->final_rd_amount) ?></td>
                <td><?= h($clientRdPayments->penalty) ?></td>
                <td><?= h($clientRdPayments->created_date) ?></td>
                <td><?= h($clientRdPayments->modified_date) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'ClientRdPayments', 'action' => 'view', $clientRdPayments->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'ClientRdPayments', 'action' => 'edit', $clientRdPayments->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'ClientRdPayments', 'action' => 'delete', $clientRdPayments->id], ['confirm' => __('Are you sure you want to delete # {0}?', $clientRdPayments->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
