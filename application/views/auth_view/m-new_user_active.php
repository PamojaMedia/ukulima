<div class="content">
<p class="title">Activation</p>
<br /><br />
<?php
    if(isset($message))
    {
        echo $message;
    }
    if($active) {
        if($login) {
            echo '<br /><p>'.anchor('auth/bio','Click Here').' to setup your profile details</p><br />';
        }
        else {
            echo '<br /><p>'.anchor('auth/login','Click Here').' to login to your account</p><br />';
        }
    }
?>
</div>