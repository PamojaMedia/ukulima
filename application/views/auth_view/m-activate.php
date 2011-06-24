<div class="login">
<p class="title">Activate Ukulima.net Account</p><br /><br />
<?php echo validation_errors(); ?>
<?php echo $this->session->flashdata('message').'<br />'; ?>
<?php echo form_open('auth/mobile_activate'); ?>
<p><label for="username">Username:</label> <br /><?php echo form_input(array('name' => 'username')); ?></p><br />
<p><label for="code">Verification Code:</label> <br /><?php echo form_input(array('name' => 'code')); ?></p><br />
<p><label for="password">Password:</label> <br /><?php echo form_password(array('name' => 'password')); ?></p><br />
<p><?php echo form_submit('submit', 'Login'); ?></p><br />
<?php echo form_close(''); ?>
</div>
