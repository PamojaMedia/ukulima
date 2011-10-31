<p class="title">
<?php
// if user is viewing someone's tracks
if ($userid != $this->session->userdata['userid']) {
    echo 'Viewing <b>'.$profile['firstname'].' '.$profile['lastname'].'\'s</b> Network';
} else {
    echo 'Your Network';
}

?>
</p>


<div>    
<?php
    echo 'Location: '.$profile['country'].' '.$profile['location'].'<br>';
    echo 'Activity: '.$profile['activity'].'<br>';
    echo 'Interest: '.$profile['interest'].'<br><br>';

    if ($userid == $this->session->userdata['userid']) {
        echo '<p>'.anchor('auth/bio','Click here').' to edit your information</p>';
    }
    else {
        echo '<p>'.($is_tracking ? 'You are tracking ' : anchor('user/track_user/'.$profile['userid'],'Click here').' to track ').$profile['firstname'].'</p>' ;
        echo '<p>'.($is_connected ? 'You are connected to ' : anchor('user/connect_user/'.$profile['userid'],'Click here').' to connect to ').$profile['firstname'].'</p>' ;
        echo '<p>'.$profile['firstname'].($is_trackingback ? ' is tracking you.' : ' is not tracking you.').'</p>' ;
    }

if (count($network) > 0) {
    
    echo '<br><br>';

    foreach($network as $net) {

        echo anchor('user/track/'.$userid,'<b>'.$net['tracks'].'</b>  Tracks').'<br>';
        echo anchor('user/trackback/'.$userid,'<b>'.$net['trackbacks'].'</b>  Trackbacks').'<br>';
        echo anchor('user/connections/'.$userid,'<b>'.$net['connections'].'</b>  Connections').'<br>';

    }
}
else {

    echo $error_message;

}
?>

</div>
