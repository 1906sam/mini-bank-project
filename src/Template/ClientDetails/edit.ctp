<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="clientDetails form large-9 medium-8 columns content">
    <?= $this->Form->create($clientDetail,['method' => 'POST','name' => 'clientDetailsForm','type' => 'file','class'=>'form']) ?>
    <fieldset>
        <legend><?= __('Edit Client Detail') ?></legend>
        <?php
            echo $this->Form->input('client_name',['class' => 'input-control']);
            echo $this->Form->input('mobile');
            echo $this->Form->input('introducer_person');
            echo $this->Form->input('client_photo',['type' => 'file','required' => 'required','accept' => '.png, .jpg, .jpeg']);
            echo $this->Form->input('client_sign_photo',['type' => 'file','required' => 'required','accept' => '.png, .jpg, .jpeg']);
            echo $this->Form->input('status',['options' => ['0' => 'Not Active', '1' => 'Active'],'value' => 1]);
            echo $this->Form->input('modified_date',['value' => date("Y-m-d H:i:s"),'type' => 'hidden']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
