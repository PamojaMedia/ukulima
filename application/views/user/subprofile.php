<div style="width:500px; float:left; height:auto; overflow:hidden;">
    <div style="width:300px; float:left; margin:0 auto; height:auto; overflow:hidden;">

  









     <h2>People you could connect</h2>
     <pre class="notice">
<?php
 foreach($suggest_connect as $s_connect)
 {
     foreach($s_connect as $sc)
     {
         ?>
<?php echo $sc['username'].' -  '.$sc['firstname'].'  '.$sc['lastname'].' <a href="'. site_url("user/connect_user/".$sc['userid']).'"> Connect</a>'  ;?>

    <?php }

 }
?>
     </pre>
<h1>Users on the site</h1>



    </div>
</div>



<?php if(isset($update_user)): ?>
<div style="width:500px; float:left; height:auto; overflow:hidden;">
<?php foreach( $update_user as $update)
{
    echo $update;
}
    ?>
</div>
<?php endif; ?>

<?php if(isset($message_user)) : ?>
<div style="width:500px; float:left; height:auto; overflow:hidden;">
<?php //echo $message_user
    foreach($message_user as $message)
{
    echo $message.'<br />';
}
; ?>
</div>
<?php endif; ?>


<?php if(isset($message_view)): ?>
<div style="width:500px; float:left; height:auto; overflow:hidden;">
<?php //echo $message_user
    foreach($message_view as $message)
{
    echo $message.'<br />';
}
; ?>
</div>
<?php endif; ?>



<?php if(isset($message_compose)): ?>
<div style="width:500px; float:left; height:auto; overflow:hidden;">
<?php foreach( $message_compose as $compose)
{
    echo $compose;
}
    ; ?>
</div>
<?php endif; ?>
