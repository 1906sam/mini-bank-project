<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="clientFd form large-9 medium-8 columns content">
    <legend><?= __('Add Client Fd') ?></legend>
    <?= $this->Form->create($clientFd) ?>
    <fieldset>
    <?php
    echo $this->Form->input('client_id',['options' => $clientDataArray,'empty' => 'Select Client','label' => 'Select client for FD.','id' => 'combobox']);
    echo $this->Form->input('fd_amount',['label' => 'FD amount in Rs.']);
    echo $this->Form->input('time_duration',['label' => 'Time duration (years)','value' => 5]);
    echo $this->Form->input('rate_of_interest',['label' => 'Rate of Interest (%)','value' => 14.1]);
    echo $this->Form->input('status',['options' => ['0' => 'Running', '1' => 'Complete'],'value' => 0,'label' => 'Status of FD']);
    echo $this->Form->input('created_date',['value' => date("Y-m-d H:i:s"),'type' => 'hidden']);
    //            echo $this->Form->input('modified_date', ['empty' => true]);
    ?>
    </fieldset>
        <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
