<?php echo $this->session->flashdata('message'); ?>

<?php echo validation_errors(); ?>

<?php if(isset($msgid)) {

        echo form_open('user/reply/'.$msgid,array('id' => 'form_submit', 'class' => 'message-reply'));

    }

    else { 

        echo form_open('user/create_message',array('id' => 'form_submit'));

        // Create the text area for typing in the receipients

        $data = array(
              'name' => 'receiver',
              'id' => 'tokenize'
        );

        echo '<p><label for="receiver">Send To:</label>'.form_input( $data ).'</p>'; ?>


<?php

        // Create the text box for entering the message title

        $data = array(
            'name' => 'subject',
            'id' => 'subject',
            'maxlength' => '100',
            'size' => '50',
            'class' => 'with-border'
        );

        echo '<p><label for="receiver">Subject:</label>'.form_input( $data ).'</p>';

    }
?>



<?php

    // Create the text area for typing in the message

    $data = array(
          'name' => 'message',
          'id' => 'message',
          'cols' => '50',
          'rows' => '3',
    );

    echo '<p><label for="receiver">'.(isset($msgid)?'Reply':'Message').':</label>'.form_textarea( $data ).'</p>'; ?>

<?php

    if(isset($msgid)) {
        echo form_submit('submit','Reply', 'class="button" id="reply" ');
    }
    else {
        echo form_submit('submit','Send', 'class="button" id="send" ');
    }
?>

<?php echo form_close(''); ?>