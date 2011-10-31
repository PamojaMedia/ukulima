<div class="content">
    <p class="title">Register</p>
    <br />
    <?php echo $this->session->flashdata('message').'<br />'; ?>

    <?php echo validation_errors().'<br />'; ?>

    <?php echo form_open('auth/register'); ?>

    <p>Username: </p>
    <p><?php
        $data = array(
            'name' => 'username',
            'maxlength' => 14,
            'value' => set_value('username')
        );
        echo form_input($data);
    ?></p>
    <br />

    <p>First Name: </p>
    <p><?php echo form_input('firstname', set_value('firstname')); ?></p>
    <br />

    <p>Last Name: </p>
    <p><?php echo form_input('lastname', set_value('lastname')); ?></p>
    <br />

    <p>Phone Number: e.g. 254722000000</p>
    <p>
    <?php
        $data_country = array('250' => '+250','251' => '+251','257' => '+257','254' => '+254',  '255' => '+255', '256' => '+256');

        echo form_dropdown('code', $data_country, '254');
    ?>
        &nbsp;
    <?php
        if(isset($_POST['phonenumber'])) {
            $phonenumber = substr($_POST['phonenumber'],  strlen($_POST['code']), strlen($_POST['phonenumber']));
        }
        else {
            $phonenumber = set_value('phonenumber');
        }
        $data = array(
            'name' => 'phonenumber',
            'maxlength' => 9,
            'value' => $phonenumber
        );
        echo form_input($data); ?></p>
    <br />

    <p>Email Address: </p>
    <p><?php echo form_input('email', set_value('email')); ?></p>
    <br />
    
    <p>Password: </p>
    <p><?php echo form_password('password1'); ?></p>
    <br />

    <p>Confirm Password: </p>
    <p><?php echo form_password('password2'); ?></p>
    <br />

    <p>Send confirmation details to: </p>
    <p>Phone:&nbsp;
    <?php
    $data = array(
        'name'      => 'confirm',
        'value'     => 'phone',
        'checked'   => 'true'
    );

    echo form_radio($data);
    ?>
    &nbsp; &nbsp;
    Email:&nbsp;
    <?php
    $data = array(
        'name'  => 'confirm',
        'value' => 'email'
    );

    echo form_radio($data);
    ?>
    </p>
    <br />

    <p><?php echo form_submit('submit', 'Register'); ?></p>

    <?php echo form_close(''); ?>
    <br />
</div>