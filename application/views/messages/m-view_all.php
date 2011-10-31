<p class="title">Messages</p>

<div class="content">

    <?php
    $this->session->flashdata('message');

    if (count($messages) > 0) {

        echo '<br />' . anchor('user/compose_message/', 'Create New Message') . '<br /><br />';

        foreach ($messages as $message) {
    ?>

    <?php echo anchor('user/view/' . $message['userid'], '<b>' . $message['firstname'] . ' ' . $message['lastname'] . '</b><br>'); ?>
    <?php echo $message['subject'] . '<br>'; ?>
    <?php echo (strlen($message['content'] > 200)) ? substr($message[''], 200) . ' ...' : $message['content'] . '<br>'; ?>
    <?php echo anchor('user/view_message/' . $message['ID'], 'view') . ' | ' . anchor('user/delete_message/' . $message['msgid'], 'delete', array('class' => "delete")) . ' <br><br>'; ?>

    <?php
        }
    } else {

        echo $error_message;
    }
    ?>

</div>