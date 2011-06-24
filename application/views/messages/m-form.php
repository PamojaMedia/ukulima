<?php echo $this->session->flashdata('message'); ?>

<?php echo validation_errors(); ?>

<?php if(isset($msgid)) {
        echo form_open('user/view_message/'.$msgid);
    }
    else { 
?>
        <p class="title">Create a New Message</p><br />

<?php

        echo form_open('user/messages');

        // Create the text area for typing in the receipients

        /*$data = array(
              'name' => 'receiver',
              'id' => 'tokenize'
        );*/

        // echo form_input( $data );
        echo '<p>'.anchor('user/message_receiver','Add Recepients').'</p>';

        echo '<br />';

        $receivers = '';
        
        if(isset($this->session->userdata['receiver_details']) && !empty($this->session->userdata['receiver_details'])) {
            echo '<p><b>Receivers: </b></p>';
            foreach($this->session->userdata['receiver_details'] as $receiver) {
                echo '<p><b>'.$receiver['firstname'].' '.$receiver['lastname'].'</b> '.anchor('user/remove_receiver/'.$receiver['userid'],'X',array('class' => 'delete')).'<p>';
                $receivers.= $receiver['userid'].',';
            }
            echo '<br />';
        }
        if(strlen($receivers) ) {
            $receivers = substr($receivers, 0, -1);
        }

        echo form_hidden('receiver', $receivers);

        // Create the text box for entering the message title

        $data = array(
            'name' => 'subject',
            'maxlength' => '100'
        );

        echo '<p>Subject</p>';
        echo form_input( $data );

    }
?>



<?php

    // Create the text area for typing in the message

    $data = array(
          'name' => 'message',
          'cols' => '20',
          'rows' => '3',
    );

    echo '<p>Message</p>';
    echo form_textarea( $data ); ?>

<br />

<?php

    if(isset($msgid)) {
        echo form_submit('submit','Reply');
    }
    else {
        echo form_submit('submit','Send');
    }
?>

<?php echo form_close(''); ?>