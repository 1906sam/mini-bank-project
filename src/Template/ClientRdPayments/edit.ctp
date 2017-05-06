<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="clientRdPayments form large-9 medium-8 columns content">
    <?= $this->Form->create($clientRdPayment) ?>
    <fieldset>
        <legend><?= __('Edit Client Rd Payment') ?></legend>
        <?php
            echo $this->Form->input('client_rd_id', ['options' => $clientRdInfo]);
            echo $this->Form->input('installment_received',['label' => 'Installment amount in Rs.']);
            //            echo $this->Form->input('final_rd_amount');
            echo $this->Form->input('penalty',['label' => 'Penalty amount in Rs.']);
//            echo $this->Form->input('created_date',['value' => date("Y-m-d H:i:s"),'type' => 'hidden']);
            echo $this->Form->input('modified_date',['value' => date("Y-m-d H:i:s"),'type' => 'hidden']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
