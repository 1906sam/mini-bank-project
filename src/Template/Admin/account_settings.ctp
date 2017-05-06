<div class="clientDetails col-md-6 col-md-offset-3">
    <?= $this->Form->create($userData,['method' => 'POST','url' => '/users/users/change-password','name' => 'changePasswordForm','class'=>'form']) ?>
    <fieldset>
        <legend><?= __('Change Password') ?></legend>
        <div class="row">
            <div class="col-md-12 col-sm-12"><br/>
                <label for="current-password" class="labelHeading">CURRENT PASSWORD</label>
                <input type="password" name="current_password" id="current-password"
                       placeholder="**********" class="form-control" required>
            </div>
        </div><!-- #end -->
        <div class="row">
            <div class="col-md-12 col-sm-12"><br/>
                <label for="password" class="labelHeading">NEW PASSWORD</label>
                <input type="password" name="password" id="password"
                       placeholder="**********" class="form-control" required>
            </div>
        </div><!-- #end -->
        <div class="row">
            <div class="col-md-12 col-sm-12"><br/>
                <label for="password-confirm" class="labelHeading">NEW PASSWORD</label>
                <input type="password" id="password-confirm" name="password_confirm"
                       placeholder="**********" class="form-control" required>
            </div>
        </div><!-- #end -->
    </fieldset>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <br/>
                <?= $this->Form->button(__('Submit')) ?>
            </div>
        </div><!-- #end -->
    <?= $this->Form->end() ?>
</div>