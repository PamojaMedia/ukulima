<p class="title">Login to Ukulima.net</p><br /><br />
<?php echo validation_errors(); ?>
<?php echo $this->session->flashdata('message').'<br />'; ?>
<?php echo form_open('auth/login'); ?>
<p><label for="email">Username:</label> <br /><?php echo form_input(array('name' => 'username', 'class' => 'text-input')); ?></p><br />
<p><label for="password">Password:</label> <br /><?php echo form_password(array('name' => 'password', 'class' => 'text-input')); ?></p><br />
<p><?php echo form_submit('submit', 'Login'); ?></p><br />
<?php echo form_close(''); ?>
<p><?php echo anchor('auth/forgotten_password', 'Forgotten Password'); ?></p><br />
<p><?php echo anchor('auth/mobile_activate', 'Activate Account'); ?></p>
