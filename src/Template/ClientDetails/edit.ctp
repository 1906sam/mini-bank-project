<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $clientDetail->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $clientDetail->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Client Details'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="clientDetails form large-9 medium-8 columns content">
    <?= $this->Form->create($clientDetail) ?>
    <fieldset>
        <legend><?= __('Edit Client Detail') ?></legend>
        <?php
            echo $this->Form->input('client_name');
            echo $this->Form->input('mobile');
            echo $this->Form->input('introducer_person');
            echo $this->Form->input('client_photo');
            echo $this->Form->input('client_sign_photo');
            echo $this->Form->input('status');
            echo $this->Form->input('created_date');
            echo $this->Form->input('modified_date', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
