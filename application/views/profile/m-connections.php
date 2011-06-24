<p class="title">
<?php
// if user is viewing someone's tracks
if(isset($profile)) {
    echo 'Viewing <b>'.$profile['firstname'].' '.$profile['lastname'].'\'s</b> Tracks';
}
elseif(isset($view_update)) {
    echo 'Viewing your Connections';
}

?>
</p>

<div>

    <?php

    if ($connections) {
        foreach($connections as $connect) {
            echo anchor('user/view/'.$connect['userid'],'<b>'.$connect['firstname'].' '.$connect['lastname']).'</b> ';
            echo '<br>';
        }
        echo '<br>';
        echo '<p>'.anchor('user/connections/'.$userid.'/'.$page,'View More').' Trackbacks.</p><br />';
    } else {

        echo $error_message;
    }
    ?>

</div>