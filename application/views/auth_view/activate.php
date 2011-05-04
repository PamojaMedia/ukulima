<h1>Account Activation.</h1>

<p>Please enter your activation code from the registration email.</p>

<?php echo $this->session->flashdata('message'); ?>
<?php echo validation_errors(); ?>

<?php echo form_open('welcome/activate'); ?>

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
            <td colspan="2"><?php echo form_submit('submit', 'Activate'); ?></td>
        </tr>
    </tfoot>
</table>

<?php echo form_close(''); ?>