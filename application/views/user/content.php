<div id="content-left">
<?php 

    if(isset($user_pane)):

        foreach( $user_pane as $pane) {
            echo $pane;
        }
    endif;


    if(isset($update_user)):

            echo $update_user['content'];

    endif;


    if(isset($question_user)):

        echo $question_user['content'];
    
    endif;


    if(isset($message_user)) :

        echo $message_user['content'];

    endif;


    if(isset($message_view)):

        echo $message_view['content'];

    endif;

    if(isset($message_compose)):

        echo $message_compose['content'];

    endif; ?>
</div>

<div id="content-right">
    <h2 class="side-title">Profile Information</h2>
    <div class="caret-area"><div class="side-caret"></div></div>
    <div class="side-info">
        <?php
        echo '<span><b>'.$profile['firstname'].' '.$profile['lastname'].'</b></span><br />';

        echo '<span><b>Location:</b> '.$profile['location'].', '.$profile['country'].'</span><br/>';

        echo '<span><b>Activities:</b> '.$profile['activity'].'</span><br/>';

        echo '<span><b>Interests:</b> '.$profile['interest'].'</span><br/>';
        ?>
    </div>

    <?php if($profile['userid']!=$this->session->userdata['userid']) { ?>

    <h2 class="side-title">Interaction with You</h2>
    <div class="caret-area"><div class="side-caret"></div></div>
    <div class="side-info">
        <?php

        echo '<span id="track-status">You Track: '.($is_tracking
                ?'<b>Yes</b> | '.anchor('user/untrack_user/'.$profile['userid'].'/1','Untrack')
                :'<b>No</b> | '.anchor('user/track_user/'.$profile['userid'],'Track')).
            '</span><br />';
        echo '<span id="connect-status">Connected: '.($is_connected
                ?'<b>Yes</b> | '.anchor('user/disconnect_user/'.$profile['userid'].'/1','Disconnect')
                :'<b>No</b> | '.anchor('user/connect_user/'.$profile['userid'],'Connect')).
            '</span><br />';
        echo '<span>Tracks You: '.($is_trackingback
                ?'<b>Yes</b>'
                :'<b>No</b>').
            '</span>';
        ?>
    </div>

    <?php } ?>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            jQuery('.note-drop').click(function() {
                    jQuery('.note-categories').toggle();
            });
        });
    </script>
    <h2 class="side-title">Notifications <div class="note-drop"></div></h2>
    <div class="caret-area">
        <div class="side-caret"></div>
        <div class="note-categories">
            <span class="single-cat" id="note-connect">Connection</span>
            <span class="single-cat" id="note-track">Track</span>
            <span class="single-cat" id="note-update">Update</span>
            <span class="single-cat" id="note-comment">Comment</span>
        </div>
    </div>
    <div class="side-info">
        <?php
        if(isset($user_notifications)) {
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

            $current_note = $user_notifications[0]['type'];
            $current_id = $user_notifications[0]['ID'];
            $notification = '';
            foreach($user_notifications as $note) {
                if($current_note != $note['type']) {
                    ?>
                    <?php echo '<span>'.substr($notification,0,-2).$note_details.'</span><br />'; ?>
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
                    <?php echo '<span>'.substr($notification,0,-2).$note_details.'</span><br />'; ?>
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
            <?php echo '<span>'.substr($notification,0,-2).$note_details.'</span>'; ?>

            <?php

        }
        else {
            echo 'No New Notifications';
        }
        ?>
    </div>

    <h2 class="side-title">People you are connected</h2>
    <div class="caret-area"><div class="side-caret"></div></div>
    <div class="side-info">
<?php

        if($users_connections) {
            foreach($users_connections as $user) {
                echo '<span>'.anchor('user/profile/'.$user['userid'],$user['firstname'].'  '.$user['lastname']).'</span><br />' ;
            }
        }
        else {
            echo 'You are not connected to anyone.';
        }
        ?>
    </div>

    <h2 class="side-title">People you track</h2>
    <div class="caret-area"><div class="side-caret"></div></div>
    <div class="side-info">
        <?php
        if($users_follows) {
            foreach($users_follows as $follow) {
                echo '<span>'.anchor('user/profile/'.$follow['userid'],$follow['firstname'].'  '.$follow['lastname']).'</span><br />' ;
            }
        }
        else {
            echo 'You are not tracking anyone.';
        }
        ?>
    </div>

    <h2 class="side-title">People you could track</h2>
    <div class="caret-area"><div class="side-caret"></div></div>
    <div class="side-info">
        <?php
        if($suggest_follow) {
            foreach($suggest_follow as $sf) {
                echo '<span>'.anchor('user/profile/'.$sf['userid'],$sf['firstname'].' '.$sf['lastname']).' | '.anchor("user/track_user/".$sf['userid'],'Track').'</span><br />' ;

            }
        }
        else {
            echo 'Cool Beans. You are a super user. First to register on the site.';
        }
        ?>
    </div>

    <h2 class="side-title">Connection Recommendations</h2>
    <div class="caret-area"><div class="side-caret"></div></div>
    <div class="side-info">
        <?php
        if($priority_suggest_connect) {
            foreach($priority_suggest_connect as $psc) {
                echo '<span>'.anchor('user/profile/'.$psc['userid'],$psc['firstname'].' '.$psc['lastname']).' | '.anchor("user/connect_user/".$psc['userid'],'Connect').'</span><br />' ;
                echo '<span>'.$psc['username'].' -  '.$psc['firstname'].'  '.$psc['lastname'].'</span>' ;
            }
        }
        else {
            echo 'You are not tracking anyone.';
        }

        ?>
    </div>

    <h2 class="side-title">People you could connect</h2>
    <div class="caret-area"><div class="side-caret"></div></div>
    <div class="side-info">
        <?php
        if($suggest_connect) {
            foreach($suggest_connect as $sc) {
                echo '<span>'.anchor('user/profile/'.$sc['userid'],$sc['firstname'].' '.$sc['lastname']).' | '.anchor("user/connect_user/".$sc['userid'],'Connect').'</span><br />' ;
            }
        }
        else {
            echo 'Cool Beans. You are a super user. First to register on the site.';
        }
        ?>
    </div>
</div>