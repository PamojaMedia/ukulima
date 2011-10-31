<div id="profile-top">
    <h2 id="profile-title">
        <?php
// if user is viewing someone's tracks
        if ($userid != $this->session->userdata['userid']) {
            echo 'Viewing ' . $profile['firstname'] . ' ' . $profile['lastname'] . '\'s Profile';
        } else {
            echo $profile['firstname'] . ' ' . $profile['lastname'] . '</b>';
        }
        ?>
    </h2>
    <div class="float-left">
        <?php
        if ($userid != $this->session->userdata['userid']) {
            echo '<span>' . ($is_tracking ? 'You are tracking ' : anchor('user/track_user/' . $profile['userid'], 'Click here') . ' to track ') . $profile['firstname'] . '| </span>';
            echo '<span>' . ($is_connected ? 'You are connected to ' : anchor('user/connect_user/' . $profile['userid'], 'Click here') . ' to connect to ') . $profile['firstname'] . '| </span>';
            echo '<span>' . $profile['firstname'] . ($is_trackingback ? ' is tracking you.' : ' is not tracking you') . '</span>';
        }
        ?>
    </div>
</div>

<div id="profile-left">
<?php
    echo '<span>Location: '.$profile['country'].' '.$profile['location'].'</span>';
    echo '<span>Activity:</span><div class="enclose-text">'.$profile['activity'].'</div>';
    echo '<span>Interest:</span><div class="enclose-text">'.$profile['interest'].'</div>';
    if($profile['userid']==$this->session->userdata['userid']) {
        echo '<p class="edit-link">'.anchor('auth/bio','Click here').' to edit your information</p>';
    }
?>
</div>

<div id="profile-right">
    <div class="float-left">
<?php        
        if (count($network) > 0) {

            foreach ($network as $net) {

                echo '<span>' . anchor('user/track/' . $userid, '<b>' . $net['tracks'] . '</b>  Tracks') . ' |</span>';
                echo '<span>' . anchor('user/trackback/' . $userid, '<b>' . $net['trackbacks'] . '</b>  Trackbacks') . ' |</span>';
                echo '<span>' . anchor('user/connections/' . $userid, '<b>' . $net['connections'] . '</b>  Connections') . '</span>';
            }
        } else {

            echo $error_message;
        }
?>
    </div>
    <span class="network-type">Connections: </span>
    <?php echo '<span class="manage-network">'.anchor('user/connections/'.$userid,'Manage Connections').'</span>'; ?>
    <div class="enclose-text">
        <?php
        if(is_array($userconnects)) {
            foreach($userconnects as $connect) {
                echo '<span class="network-user"'.anchor('user/view/'.$connect['userid'],'<b>'.$connect['firstname'].' '.$connect['lastname']).'</b> | ';
                echo anchor('user/disconnect_user/'.$connect['userid'],'disconnect').'</span>';
            }
        }
        else {
            echo '<p>No connections at the moment.</p>';
        }
        ?>
    </div>
    <span class="network-type">Tracks: </span>
    <?php echo '<span class="manage-network">'.anchor('user/track/'.$userid,'Manage Tracks').'</span>'; ?>
    <div class="enclose-text">
        <?php
        if(is_array($usertracks)) {
            foreach($usertracks as $track) {
                echo '<span class="network-user"'.anchor('user/view/'.$track['userid'],'<b>'.$track['firstname'].' '.$track['lastname'].'</b>');
                echo ' | '.anchor('user/untrack_user/'.$track['userid'],'untrack').'</span>';
            }
        }
        else {
            echo '<p>No tracks at the moment.</p>';
        }
        ?>
    </div>
    <span class="network-type">Trackbacks: </span>
    <div class="enclose-text">
        <?php
        if(is_array($usertrackback)) {
            foreach($usertrackback as $track) {
                echo '<span class="network-user"'.anchor('user/view/'.$track['userid'],'<b>'.$track['firstname'].' '.$track['lastname']).'</span>';
            }
        }
        else {
            echo '<p>No trackback at the moment.</p>';
        }
        ?>
    </div>
</div>

