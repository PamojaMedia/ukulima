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

<div class="content">

    <?php
    
    if (count($tracks) > 0) {
        foreach($tracks as $track) {
            echo $track['firstname'].' '.$track['lastname'].' '.$track['userid'].'<br />';
        }
    } else {

        echo $error_message;
    }
    ?>

</div>