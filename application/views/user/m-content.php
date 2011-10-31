<div class="notification">
<?php
$notification_description = array (
    'comment' => array(
           'text' => 'commented on your update',
           'method' => 'view_update',
           'action' => 'view update'
        ),
    'update' =>  array(
           'text' => 'wrote an update for you',
           'method' => 'view_update',
           'action' => 'view update'
        ),
    'answer' => array(
           'text' => 'answered your question',
           'method' => 'view_question',
           'action' => 'view question'
        ),
    'question' =>  array(
           'text' => 'wrote a question for you',
           'method' => 'view_question',
           'action' => 'view question'
        ),
    'follow' => array(
           'text' => 'is tracking you',
           'method' => 'view',
           'action' => 'view their updates'
        ),
    'connect' => array(
           'text' => 'has requested that you connect',
           'method' => 'connect_user',
           'action' => 'accept connection'
        ),
    'message' => array(
           'text' => 'sent you a message',
           'method' => 'view_message',
           'action' => 'view message'
        )
);

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
            }

            if($current_id == $note['ID']) {
                $notification .= anchor('user/view/'.$note['userid'],$note['firstname'].' '.$note['lastname']).', ';
                $note_details = ' '.$notification_description[$site_notifications[$note['type']]]['text'].' '.
                        anchor('user/'.$notification_description[$site_notifications[$note['type']]]['method'].
                        '/'.$note['ID'],$notification_description[$site_notifications[$note['type']]]['action']);
            }
            else {

        ?>
<?php echo substr($notification,0,-2).$note_details.'<br>'; ?>
<?php

                $notification = anchor('user/view/'.$note['userid'],$note['firstname'].' '.$note['lastname']).', ';
                $note_details = ' '.$notification_description[$site_notifications[$note['type']]]['text'].' '.
                        anchor('user/'.$notification_description[$site_notifications[$note['type']]]['method'].
                        '/'.$note['ID'],$notification_description[$site_notifications[$note['type']]]['action']);

            }

            $current_note = $note['type'];
            $current_id = $note['ID'];
        }

        ?>
<?php echo substr($notification,0,-2).$note_details; ?>

    <?php

    }
    ?>
</div>
<div class="content">
<?php if(isset($update_user)): ?>
<div>
<?php foreach( $update_user as $update)
{
    echo $update;
}
    ?>
</div>
<?php endif;

?>

 <?php if(isset($question_user)): ?>
<div>
<?php foreach( $question_user as $question)
{
    echo $question;
}
    ?>
</div>
<?php endif;

?>

<?php if(isset($message_user)) : ?>
<div>
<?php //echo $message_user
    foreach($message_user as $message)
{
    echo $message.'<br />';
}
; ?>
</div>
<?php endif; ?>


<?php if(isset($message_view)): ?>
<div>
<?php //echo $message_user
    foreach($message_view as $message)
{
    echo $message.'<br />';
}
; ?>
</div>
<?php endif; ?>



<?php if(isset($message_compose)): ?>
<div>
<?php foreach( $message_compose as $compose)
{
    echo $compose;
}
    ; ?>
</div>
<?php endif; ?>
</div>