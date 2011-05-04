<h1>Messages</h1>

<div id="all_messages">
    
<?php

if(count($messages) > 0) {

foreach($messages as $message) {

?>

    <div id="list_messages">
        <div id="message_excerpt">
            <?php echo $message['subject'].'<br>'; ?>
            <?php echo (strlen($message['content']>200))?substr($message[''],200).' ...':$message['content'].'<br>'; ?>
            <?php echo 'view | forwared | delete <br><br>'; ?>
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