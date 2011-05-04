<h1>Register</h1>

<?php echo $this->session->flashdata('message'); ?>

<?php echo validation_errors(); ?>

<?php echo form_open('auth/settings'); ?>

<table>
    <thead>
        <tr>
            <th colspan="2">Required Fields</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Username</td>
            <td><?php echo form_input('username', set_value('username')); ?></td>
        </tr>

        <tr>
            <td>First Name</td>
            <td><?php echo form_input('firstname', set_value('firstname')); ?></td>
        </tr>

         <tr>
            <td>Last Name</td>
            <td><?php echo form_input('lastname', set_value('lastname')); ?></td>
        </tr>

        <tr>
            <td>Phone Number</td>
            <td><?php echo form_input('phonenumber', set_value('phonenumber')); ?></td>
        </tr>

        <tr>
            <td>Email Address</td>
            <td><?php echo form_input('email', set_value('email')); ?></td>
        </tr>
        <tr>
            <td>Password</td>
            <td><?php echo form_password('password1'); ?></td>
        </tr>

        <tr>
            <td>Confirm Password</td>
            <td><?php echo form_password('password2'); ?></td>
        </tr>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th colspan="2">Optional Fields</th>
        </tr>
    </thead>
    <tbody>

    </tbody>
    <tfoot>
        <tr>
            <td colspan="2"><?php echo form_submit('submit', 'Register'); ?></td>
        </tr>
    </tfoot>
</table>

<?php echo form_close(''); ?>
