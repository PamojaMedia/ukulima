<h1>Forgotten Password</h1>

<p>Please enter your email address to reset your password.</p>

<?php echo $this->session->flashdata('message'); ?>
<?php echo validation_errors(); ?>

<?php echo form_open('auth/forgotten_password'); ?>

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
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2"><?php echo form_submit('submit', 'Reset Password'); ?></td>
        </tr>
    </tfoot>
</table>

<?php echo form_close(''); ?>

<?php echo form_open('auth/forgotten_password_complete'); ?>

<table>
    <thead>
        <tr>
            <th colspan="2">Required Fields</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Verification Code</td>
            <td><?php echo form_input('code', set_value('code')); ?></td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2"><?php echo form_submit('submit', 'Send New Password'); ?></td>
        </tr>
    </tfoot>
</table>

<?php echo form_close(''); ?>