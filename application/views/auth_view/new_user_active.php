<div id="login-form">
<div style="margin:15px auto; width:300px; display:block;"><img  src="<?php echo base_url();?>/assets/images/Logo_Ukulima_normal_.png"> </div>
<?php
    if(isset($message))
    {
        echo $message;
    }
    echo anchor('auth/login', 'Login', array('class'=>'join-link'));
?>
</div>