<div class="content">

<?php if(isset($profile)): ?>
<div>
<?php
    echo '<b>Name: '.$profile['firstname'].' '.$profile['lastname'].'</b><br>';
    echo 'Location: '.$profile['country'].' '.$profile['location'].'<br>';
    echo 'Activity: '.$profile['activity'].'<br>';
    echo 'Interest: '.$profile['interest'].'<br><br>';
?>
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

</div>