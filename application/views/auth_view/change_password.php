<h2 class="title">Change Password</h2>

<?php echo validation_errors(); ?>

<?php echo $success_message; ?>

<?php echo form_open('auth/change_password'); ?>

<div id="profile_action">
    <div class="form_field">
        <label for="password">Old Password</label>
        <?php echo form_password(array('name' => 'password','class' => 'password')) ?>
    </div>
    <div class="form_field">
        <label for="password1">New Password</label>
        <?php echo form_password(array('name' => 'password1','class' => 'password')) ?>
    </div>
    <div class="form_field">
        <label for="password2">Repeat New Password</label>
        <?php echo form_password(array('name' => 'password2','class' => 'password')) ?>
    </div>
    <div class="form_field">
        <?php echo form_submit(array('name' => 'submit','value'=> 'Change Password', 'class' => 'login-submit submit')); ?>
    </div>
</div>
<?php echo form_close(); ?>