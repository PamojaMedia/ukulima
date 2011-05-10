<h1>Recent Messages</h1>

<div id="view_messages">

    <?php

    if(is_array($messages)) {

        foreach($messages as $message) {

            echo '<div id="message_text'.$message['msgid'].'">';

            echo $message['content'];

            echo '<br> --------------------------------- ';

            if($message['parentid']) {
                echo anchor('messaging/delete/'.$message['msgid'], 'Delete', array('class' => 'delete', 'id' => $message['msgid']));
            }

            echo '<br></div>';

        }


    }

    else {

        echo $error_message;

    }

    ?>

</div>