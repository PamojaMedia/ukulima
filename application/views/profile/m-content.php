<?php if(isset($network)): ?>

    <?php echo $network['content']; ?>

<?php endif; ?>

<?php if(isset($tracks)): ?>

<?php
    foreach($tracks as $track) {
        echo $track;
    }
?>

<?php endif; ?>

<?php if(isset($trackback)): ?>

<?php
    foreach($trackback as $track) {
        echo $track;
    }
?>

<?php endif; ?>

<?php if(isset($search)): ?>

<?php
    echo $search['content'];
?>

<?php endif; ?>

<?php if(isset($connections)): ?>

<?php
    foreach($connections as $connect) {
        echo $connect;
    }
?>

<?php endif; ?>

<?php if(isset($suggestions)): ?>

<?php
    foreach($suggestions as $suggest) {
        echo $suggest;
    }
?>

<?php endif; ?>