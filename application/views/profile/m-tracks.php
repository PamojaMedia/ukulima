<p class="title">
<?php
// if user is viewing someone's tracks
if(isset($profile)) {
    echo 'Viewing <b>'.$profile['firstname'].' '.$profile['lastname'].'\'s</b> Tracks';
}
elseif(isset($view_update)) {
    echo 'Viewing your Tracks';
}

?>    
</p>

<div>

    <?php
    
    if ($tracks) {
        foreach($tracks as $track) {
            echo anchor('user/view/'.$track['userid'],'<b>'.$track['firstname'].' '.$track['lastname']).'</b> ';
            echo ($track['track_back']?'Tracks back':'Is not tracking back').'<br />';
        }
        echo '<br>';
        echo '<p>'.anchor('user/track/'.$userid.'/'.$page,'View More').' Trackbacks.</p><br />';
    } else {

        echo $error_message;
    }
    ?>

</div>