<div id="out-form">
    
    <h1 class="login-title">Join Ukulima</h1>

    <?php echo $this->session->flashdata('message'); ?>

    <?php echo validation_errors(); ?>

    <?php echo form_open('auth/register'); ?>

        <p class="required"> All the fields are required </p>
        <p class="registerp">
            <label>Username</label>
            <?php
            $data_username = array('name' => 'username', 'value' => set_value('username'), 'class' => 'login-input');
            echo form_input($data_username); ?>
        </p>

        <p class="registerp">
            <label>Email Address</label>
            <?php
            $data_email = array('name' => 'email', 'value' => set_value('email'), 'class' => 'login-input');
            echo form_input($data_email); ?>
        </p>

        <p class="registerp">
            <label>Password</label>
            <?php
            $data_password1 = array('name' => 'password1', 'class' => 'login-input');
            echo form_password($data_password1); ?>
        </p>

        <p class="registerp">
            <label>Confirm Password</label>
            <?php
            $data_password2 = array('name' => 'password2', 'class' => 'login-input');
            echo form_password($data_password2); ?>
        </p>

        <p class="registerp">
            <?php
            $data_submitbtn = array('name' => 'submit', 'value' => 'Sign Up', 'class' => 'login-submit');
            echo form_submit($data_submitbtn); ?>
        </p>

    <?php echo form_close(''); ?>

</div>