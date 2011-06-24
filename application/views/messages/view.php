<h1>Recent Messages</h1>

<div id="view_messages">

    <?php

    if(is_array($messages)) {

        foreach($messages as $message) {

            echo '<div id="message_text'.$message['msgid'].'">';

            echo anchor('user/view/' . $message['userid'], '<b>' . $message['firstname'] . ' ' . $message['lastname'] . '</b> ') .$message['content'];

            echo '<br> --------------------------------- ';

            if($message['parentid']) {
                echo anchor('user/delete_message/'.$message['msgid'], 'Delete', array('class' => 'delete', 'id' => $message['msgid']));
            }

            echo '<br></div>';

        }


    }

    else {

        echo $error_message;

    }

    ?>

</div>