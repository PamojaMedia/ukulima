<div id="out-form">
<h1 class="login-title">Forgotten Password</h1>

<p class="required">1. Please enter your email address to reset your password.</p>

<?php echo $this->session->flashdata('message'); ?>
<?php echo validation_errors(); ?>

<?php echo form_open('auth/forgotten_password'); ?>

<table>
   
    <tbody>
        <tr>
            <td><label>Email Address</label></td>
            <td><?php 
            $email_data = array('name' => 'email','value'=>set_value('email'), 'class' => 'login-input');
            echo form_input($email_data); 
            ?></td>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <td colspan="2"><?php
             $data_submitbtn2 = array('name'=>'submit', 'value'=>'Reset Password', 'class'=>'login-submit');
            echo form_submit($data_submitbtn2); 
            ?></td>
        </tr>
    </tbody>
    <tfoot>
        
    </tfoot>


<?php echo form_close(''); ?>

<?php echo form_open('auth/forgotten_password_complete'); ?>


       
    
    <tbody>
         <tr>
            <th colspan="2"><p class="required">2. Please enter your verification code to get a new password.</p></th>
        </tr>
        <tr>
            <td><label>Verification Code</label></td>
            <td><?php 
            $code_data = array('name' => 'code', 'value' => set_value('code'), 'class'=>'login-input');
            echo form_input($code_data); 
            ?></td>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <td colspan="2"><?php
             $data_submitbtn = array('name'=>'submit', 'value'=>'Send New Password', 'class'=>'login-submit');
            echo form_submit($data_submitbtn); 
            ?></td>
        </tr> 
    </tbody>
    <tfoot>
        
    </tfoot>
</table>

<?php echo form_close(''); ?>
</div>