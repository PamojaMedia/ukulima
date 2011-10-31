<p class="title">
<?php
// if user is viewing someone's tracks
if(isset($profile)) {
    echo 'Viewing <b>'.$profile['firstname'].' '.$profile['lastname'].'\'s</b> Tracks';
}
elseif(isset($view_update)) {
    echo 'Viewing your Trackbacks';
}

?>
</p>

<div>

    <?php

    if ($trackback) {
        foreach($trackback as $track) {
            echo anchor('user/view/'.$track['userid'],'<b>'.$track['firstname'].' '.$track['lastname']).'</b> ';
            echo ($track['track_back']?'You Track':'You are not tracking').'<br />';
        }
        echo '<br>';
        echo '<p>'.anchor('user/trackback/'.$userid.'/'.$page,'View More').' Trackbacks.</p><br />';
    } else {

        echo $error_message;
    }
    ?>

</div>