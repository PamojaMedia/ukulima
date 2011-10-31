<div id="message-area">

    <div id="message-menu">

        <?php echo anchor('user/compose_message/','Compose',array('class' => 'button')); ?>
        <?php // echo anchor('user/messages/','Inbox'); ?>
        <?php echo anchor('user/messages/','Messages'); ?>

    </div>

    <div id="messages-middle">

        <?php

        echo $content;

        ?>

    </div>

</div>