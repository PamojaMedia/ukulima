<h1>Login</h1>

<?php echo validation_errors(); ?>

<?php echo form_open('auth/login'); ?>

<table>
    <thead>
        <tr>
            <th colspan="2">Required Fields</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Email Address</td>
            <td><?php echo form_input('email', set_value('email')); ?></td>
        </tr>
        <tr>
            <td>Password</td>
            <td><?php echo form_password('password'); ?></td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2"><?php echo form_submit('submit', 'Login'); ?></td> <td><?php echo anchor('auth/forgotten_password', 'Forgotten Password'); ?></td>
        </tr>
    </tfoot>
</table>

<?php echo form_close(''); ?>