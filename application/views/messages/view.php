<?php

if(is_array($messages)) {
    
    echo '<h2 class="user_action">'.$messages[0]['subject'].'</h2>';
    
    $class = 'gray';

    foreach($messages as $message) {

        echo '<div id="message_text'.$message['msgid'].'" class=" single-message '.$class.'">';

        echo anchor('user/view/' . $message['userid'], '<b>' . $message['firstname'] . ' ' . $message['lastname'] . '</b> ');
        
        echo $message['content'];

        echo anchor('user/delete_message/'.$message['msgid'], 'x', array('class' => 'delete', 'id' => $message['msgid']));
        
        
        $class = ($class=='gray')?'white':'gray';

        echo '<br></div>';

    }


}

else {

    echo $error_message;

}

?>