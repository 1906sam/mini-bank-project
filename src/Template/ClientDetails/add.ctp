<?php
/**
  * @var \App\View\AppView $this
  */
?>
<link href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.css" rel="stylesheet"/>
<link href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.css" rel="stylesheet"/>

<div class="clientDetails form large-9 medium-8 columns content">
    <?= $this->Form->create($clientDetail,['method' => 'POST','name' => 'clientDetailsForm','type' => 'file','class'=>'form']) ?>
    <fieldset>
        <legend><?= __('Add Client\'s Personal  Detail') ?></legend>
        <?php
            echo $this->Form->input('client_name',['class' => 'input-control']);
            echo $this->Form->input('mobile',['type' => 'number']);
            echo $this->Form->input('introducer_person');
            echo $this->Form->input('client_photo',['type' => 'file','required' => 'required','accept' => '.png, .jpg, .jpeg']);
            echo $this->Form->input('client_sign_photo',['type' => 'file','required' => 'required','accept' => '.png, .jpg, .jpeg']);
            echo $this->Form->input('client_address');
            echo $this->Form->input('status',['options' => ['0' => 'Not Active', '1' => 'Active'],'value' => 1]);
            echo $this->Form->input('old_client',['type' => 'checkbox','id'=>'oldClientCheck','label' => 'Old Client','onclick' => 'showDatePicker(this);']);
            echo $this->Form->input('created_date',['value' => date("Y-m-d H:i:s"),'type' => 'hidden']);
            echo '<div class="form-group hide input-group date" id="clientStartDiv">'.
                '<label for="datetimepicker">Select Date</label>'.
                '<input type="text" name="select_date" class="form-control" id="datetimepickerstart" />'.
                '</div>';
//            echo $this->Form->input('modified_date', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/locale/pt-br.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>

<script>
    function showDatePicker() {
        if(document.getElementById('oldClientCheck').checked)
        {
            document.getElementById('datetimepickerstart').setAttribute('required','required');
            document.getElementById('clientStartDiv').classList.remove('hide');
        }
        else
        {
            document.getElementById('datetimepickerstart').value = '';
            document.getElementById('datetimepickerstart').removeAttribute('required');
            document.getElementById('clientStartDiv').classList.add('hide');
        }
    }

    $('#datetimepickerstart').datetimepicker({
        locale: 'en-in',
        maxDate: moment(),
        sideBySide : false,
//        calendarWeeks: true,
        format: 'YYYY-MM-DD HH:mm:ss',
        stepping: 1
    });

</script>
