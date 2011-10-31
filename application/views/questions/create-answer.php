<div class="sub-content" id="comment<?php echo $answer['ID'] ?>">
<?php
    echo '<span>'.anchor('user/view/'.$answer['userid'],'<b>'.$answer['firstname'].' '.$answer['lastname'].'</b> ').$answer['update'] .'</span>';

    echo anchor('user/delete_question/'.$answer['ID'], 'x', array('class' => 'delete', 'id' => 'deletecm'.$answer['ID']));
?>
</div>