<p class="title">
<?php
// if user is viewing someone's tracks
if(isset($profile)) {
    echo 'Viewing <b>'.$profile['firstname'].' '.$profile['lastname'].'\'s</b> Network';
}
elseif(isset($view_update)) {
    echo 'Your Network';
}

?>
</p>


<div>
<?php

if (count($network) > 0) {

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
