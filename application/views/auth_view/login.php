<div id="out-form">
    <div class="ukulima-logo">
        <img src="<?php echo base_url();?>/assets/images/Logo_Ukulima_normal_.png" alt="ukulima.net" width="300px" height="41px" />
    </div>

    <?php
    if($this->session->flashdata('message') != '') :
        echo $this->session->flashdata('message');
        echo '</div>'; // close the div id="out-form"
    else : ?>
        <?php echo validation_errors(); ?>

        <?php echo form_open('auth/login'); ?>

            <p class="loginp">
                <label>Username</label>
                    <?php
                    $data_username = array('name'=>'username','value'=>set_value('username'), 'class'=>'login-input');
                    echo form_input($data_username); ?>
            </p>

            <p class="loginp">

                <label>Password</label>
                <?php
                $data_password = array('name'=>'password', 'class'=>'login-input');
                echo form_password($data_password);
                ?>
            </p>

            <p class="loginp">
                <?php
                $data_submitbtn = array('name'=>'submit', 'value'=>'Login', 'class'=>'login-submit');
                echo form_submit($data_submitbtn);
                ?>

                <?php echo anchor('auth/forgotten_password', 'Forgot your Password?'); ?>
            </p>

        <?php echo form_close(''); ?>

</div>

<?php echo anchor('auth/register', 'Join Us', array('class'=>'join-link'));

endif;

?>