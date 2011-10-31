<?php

if(count($messages) > 0) { ?>

<div class="message-border">

<?php

    //echo form_open('user/delete_message/'); ?>

        <div id="list-header">
        <?php /*    <div class="action">
                <input type="checkbox" id="select_all" />
            </div>
            <input type="submit" value="Delete" /> */ ?>
        </div>

        <?php
        foreach($messages as $message) {

        ?>

            <div class="message">
                <div class="action">
                <?php /*    <input type="checkbox" class="for_delete" name="for_delete[]" value="<?php $message['userid'] ?>" /> */ ?>
                </div>
                <div class="content">
                    <?php echo anchor('user/view_message/'.$message['ID'],
                            '<span>'.$message['firstname'].' '.$message['lastname'].
                            ':&nbsp;&nbsp;<b>'.$message['subject'].'</b><br />'.
                            ((strlen($message['content'])>80)?substr($message['content'],0,70).' ...':$message['content']).'</span>'
                            );
                    ?>
                </div>
            </div>

        <?php

        }

        echo '<div id="list-footer"></div>';

    //echo form_close();
?>
</div>
<?php
}

else {

    echo $error_message;

}

?>