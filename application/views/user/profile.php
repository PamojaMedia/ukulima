<div style="width:500px; float:left; height:auto; overflow:hidden;">
    <div style="width:300px; float:left; margin:0 auto; height:auto; overflow:hidden;">
    <h1>Your Profile</h1>

<pre class="notice"><?php
 echo $profile['username'].'&nbsp;'.$profile['firstname'].'-'.$profile['lastname'].'<br/>';

echo $profile['email'].'<br/>';


?> </pre>

     <h2>People you are connected</h2>
     <pre class="notice">
<?php

foreach($users_connections as $user)
{
    foreach($user as $u)
    {
        ?>

<?php echo $u['username'].' - '.$u['firstname'].' '.$u['lastname'] ;?>
  

   <?php }

}
?>
</pre>
     

     <h2>People you track</h2>
     <pre class="notice">
<?php
 foreach($users_follows as $follow)
 {
     foreach($follow as $f)
     {
         ?>
<?php echo $f['username'].' -  '.$f['firstname'].'  '.$f['lastname'] ;?>

    <?php }

 }
?>
     </pre>

     <h2>People you could track</h2>
     <pre class="notice">
<?php
 foreach($suggest_follow as $s_follow)
 {
     foreach($s_follow as $sf)
     {
         ?>
<?php echo $sf['username'].' -  '.$sf['firstname'].'  '.$sf['lastname'].' <a href="'. site_url("user/follow_user/".$sf['userid']).'"> Track User</a>' ;?>

    <?php }

 }
?>
     </pre>

     <h2>People highly recommended to connect (because you follow each other)</h2>
     <pre class="notice">
<?php
 foreach($priority_suggest_connect as $p_sugg_conn)
 {
     foreach($p_sugg_conn as $psc)
     {
         ?>

<?php echo $psc['username'].' -  '.$psc['firstname'].'  '.$psc['lastname'] ;?>
     <?php

     }

 }

?>

      </pre>


     <h2>People you could connect</h2>
     <pre class="notice">
<?php
 foreach($suggest_connect as $s_connect)
 {
     foreach($s_connect as $sc)
     {
         ?>
<?php echo $sc['username'].' -  '.$sc['firstname'].'  '.$sc['lastname'] ;?>

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
<?php echo $message_view; ?>
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