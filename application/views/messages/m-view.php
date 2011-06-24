<p class="title">Recent Messages</p>

<div class="content">

    <?php

    $this->session->flashdata('message');

    if(is_array($messages)) {

        foreach($messages as $message) {

            echo '<div>';

            echo anchor('user/view/' . $message['userid'], '<b>' . $message['firstname'] . ' ' . $message['lastname'] . '</b> ') .$message['content'].' ';

            if($message['parentid']) {
                echo anchor('user/delete_message/'.$message['msgid'], 'X', array('class' => 'delete'));
            }

            echo '<br> ------- <br>';

            echo '<br></div>';

        }

    }

    else {

        echo $error_message;

    }

    ?>

</div>