<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="clientRd form large-9 medium-8 columns content">
    <?= $this->Form->create($clientRd) ?>
    <fieldset>
        <legend><?= __('Add Client\'s RD Details') ?></legend>
        <?php
            echo $this->Form->input('client_id', ['options' => $clientDataArray,'empty' => 'Select Client','label' => 'Select Client:','id' => 'combobox']);
            echo $this->Form->input('rd_amount',['label' => 'RD amount in Rs.']);
            echo $this->Form->input('rate_of_interest',['label' => 'Rate of Interest (%)']);
            echo $this->Form->input('time_duration',['label' => 'Time duration in years']);
            echo $this->Form->input('status',['options' => ['0' => 'Running', '1' => 'Complete'],'value' => 0]);
            echo $this->Form->input('created_date',['value' => date("Y-m-d H:i:s"),'type' => 'hidden']);
//            echo $this->Form->input('modified_date');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
