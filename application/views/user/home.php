<?php if(isset($update_user)): ?>
<div style="width:700px; float:left; height:auto; overflow:hidden;">
<?php foreach( $update_user as $update)
{
    echo $update;
}
    ?>
</div>
<?php endif; ?>

<?php if(isset($message_user)) : ?>
<div style="width:700px; float:left; height:auto; overflow:hidden;">
<?php //echo $message_user
    foreach($message_user as $message)
{
    echo $message.'<br />';
}
; ?>
</div>
<?php endif; ?>


<?php if(isset($message_view)): ?>
<div style="width:700px; float:left; height:auto; overflow:hidden;">
<?php //echo $message_user
    foreach($message_view as $message)
{
    echo $message.'<br />';
}
; ?>
</div>
<?php endif; ?>



<?php if(isset($message_compose)): ?>
<div style="width:700px; float:left; height:auto; overflow:hidden;">
<?php foreach( $message_compose as $compose)
{
    echo $compose;
}
    ; ?>
</div>
<?php endif; ?>
<div style="width:300px; float:left; height:auto; overflow:hidden;">
    <div style="width:300px; float:left; margin:0 auto; height:auto; overflow:hidden;">
    <h1 class="share_update">Your Profile</h1>
    <div class="greencaret-area"><div class="greencaret"></div></div>
<pre class="notice"><?php
 echo $profile['username'].'&nbsp;'.$profile['firstname'].'-'.$profile['lastname'].'<br/>';

echo $profile['email'].'<br/>';


?> </pre>
    <h1 class="share_update">Notifications</h1>
    <div class="greencaret-area"><div class="greencaret"></div></div>
    <pre class="notice">
<?php
    if(isset($user_notifications))
    {
        $current_note = $user_notifications[0]['type'];
        $current_id = $user_notifications[0]['ID'];
        $notification = '';
        foreach($user_notifications as $note)
        {
            if($current_note != $note['type']) {
                ?>
<?php echo substr($notification,0,-2).$note_details; ?>
<?php
                $note_details = '';
                $notification = '';

                echo '<br><br>';
            }

            if($current_id == $note['ID']) {
                $notification .= anchor('user/view/'.$note['userid'],$note['firstname'].' '.$note['lastname']).', ';
                $note_details = ' - '.$site_notifications[$note['type']].' - '.
                        anchor('user/view_'.($site_notifications[$note['type']]=='comment'?'update':$site_notifications[$note['type']]).
                        '/'.$note['ID'],'view');
            }
            else {

        ?>
<?php echo substr($notification,0,-2).$note_details.'<br>'; ?>
<?php

                $notification = anchor('user/view/'.$note['userid'],$note['firstname'].' '.$note['lastname']).', ';
                $note_details = ' - '.$site_notifications[$note['type']].' - '.
                        anchor('user/view_'.($site_notifications[$note['type']]=='comment'?'update':$site_notifications[$note['type']]).
                        '/'.$note['ID'],'view');

            }

            $current_note = $note['type'];
            $current_id = $note['ID'];
        }

        ?>
<?php echo substr($notification,0,-2).$note_details; ?>

    <?php

    }
    ?>
    </pre>

     <h1 class="share_update">People you are connected</h1>
      <div class="greencaret-area"><div class="greencaret"></div></div>
     <pre class="notice">
<?php

foreach($users_connections as $user)
{
?>

<?php echo $user['username'].' - '.$user['firstname'].' '.$user['lastname'] ;?>
  
<?php
}
?>
</pre>
     

     <h1 class="share_update">People you track</h1>
      <div class="greencaret-area"><div class="greencaret"></div></div>
     <pre class="notice">
<?php
 foreach($users_follows as $follow)
 {
         ?>
<?php echo $follow['username'].' -  '.$follow['firstname'].'  '.$follow['lastname'] ;?>

    <?php

 }
?>
     </pre>

     <h1 class="share_update">People you could track</h1>
      <div class="greencaret-area"><div class="greencaret"></div></div>
     <pre class="notice">
<?php
 foreach($suggest_follow as $sf)
 {
         ?>
<?php echo $sf['username'].' -  '.$sf['firstname'].'  '.$sf['lastname'].' <a href="'. site_url("user/track_user/".$sf['userid']).'"> Track User</a>' ;?>

    <?php

 }
?>
     </pre>

     <h1 class="share_update">People highly recommended to connect (because you follow each other)</h1>
      <div class="greencaret-area"><div class="greencaret"></div></div>
     <pre class="notice">
<?php
 foreach($priority_suggest_connect as $psc)
 {
         ?>

<?php echo $psc['username'].' -  '.$psc['firstname'].'  '.$psc['lastname'] ;?>

<?php

 }

?>

      </pre>


     <h1 class="share_update">People you could connect</h1>
      <div class="greencaret-area"><div class="greencaret"></div></div>
     <pre class="notice">
<?php
 foreach($suggest_connect as $sc)
 {
 ?>
<?php echo $sc['username'].' -  '.$sc['firstname'].'  '.$sc['lastname'].' <a href="'. site_url("user/connect_user/".$sc['userid']).'"> Connect</a>'  ;?>

<?php
 }
?>
     </pre>




    </div>
</div>