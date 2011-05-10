<h1>Messages</h1>

<div id="all_messages">

<?php

if(count($messages) > 0) {

foreach($messages as $message) {

?>

    <div id="list_messages">
        <div id="message_excerpt">
            <?php echo anchor('user/view/'.$message['userid'],'<b>'.$message['firstname'].' '.$message['lastname'].'</b><br>'); ?>
            <?php echo $message['subject'].'<br>'; ?>
            <?php echo (strlen($message['content']>200))?substr($message[''],200).' ...':$message['content'].'<br>'; ?>
            <?php echo anchor('user/view_message/'.$message['ID'],'view').' | forward | '.anchor('user/message_delete/'.$message['ID'],'delete').' <br><br>'; ?>
        </div>
    </div>

<?php

}

}

else {

    echo $error_message;

}

?>

</div>