<div class="sub-content" id="comment<?php echo $comment['ID'] ?>">
<?php
    echo '<span>'.anchor('user/view/'.$comment['userid'],'<b>'.$comment['firstname'].' '.$comment['lastname'].'</b> ').$comment['update'] .'</span>';

    echo anchor('user/update_delete/'.$comment['ID'], 'x', array('class' => 'delete', 'id' => 'deletecm'.$comment['ID']));
?>
</div>