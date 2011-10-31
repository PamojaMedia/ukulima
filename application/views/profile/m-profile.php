<div class="content">

<?php if(isset($profile)): ?>
<div>
<?php
    echo '<b>Name: '.$profile['firstname'].' '.$profile['lastname'].'</b><br>';
    echo 'Location: '.$profile['country'].' '.$profile['location'].'<br>';
    echo 'Activity: '.$profile['activity'].'<br>';
    echo 'Interest: '.$profile['interest'].'<br><br>';

    if($profile['userid']==$this->session->userdata['userid']) {
        echo '<p>'.anchor('auth/bio','Click here').' to edit your information</p>';
    }
    else {
        echo '<p>'.($is_tracking ? 'You are tracking ' : anchor('user/track_user/'.$profile['userid'],'Click here').' to track ').$profile['firstname'].'</p>' ;
        echo '<p>'.($is_connected ? 'You are connected to ' : anchor('user/connect_user/'.$profile['userid'],'Click here').' to connect to ').$profile['firstname'].'</p>' ;
        echo '<p>'.$profile['firstname'].($is_trackingback ? ' is tracking you.' : ' is not tracking you.').'</p>' ;
    }
    
?>
<br />
</div>
<?php endif; ?>

<?php if(isset($network)): ?>
<div>
<?php
    if(is_array($network)) {
        foreach($network as $net) {
            echo $net;
        }
    }
    else {
        echo $error_message;
    }

?>
</div>
<?php endif; ?>

<?php if(isset($tracks)): ?>
<div>
<?php
    foreach($tracks as $track) {
        echo $track;
    }
?>
</div>
<?php endif; ?>

<?php if(isset($trackback)): ?>
<div>
<?php
    foreach($trackback as $track) {
        echo $track;
    }
?>
</div>
<?php endif; ?>

<?php if(isset($connections)): ?>
<div>
<?php
    foreach($connections as $connect) {
        echo $connect;
    }
?>
</div>
<?php endif; ?>

<?php if(isset($suggestions)): ?>
<div>
<?php
    foreach($suggestions as $suggest) {
        echo $suggest;
    }
?>
</div>
<?php elseif($profile['userid']==$this->session->userdata['userid']):
    echo '<br /><p>'.anchor('user/network_suggestions','Click here').' for suggestions of people to add to your network.</p>';
?>
<?php endif; ?>
<br />
</div>