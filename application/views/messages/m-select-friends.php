<p class="title">Select Receivers</p>

<div class="content">

    <?php

    echo '<br />';

    if(isset($receiver_details)) {
        foreach($receiver_details as $receiver) {
            echo '<p><b>'.$receiver['firstname'].' '.$receiver['lastname'].'</b> '.anchor('user/remove_receiver/'.$receiver['userid'],'X',array('class' => 'delete')).'<p>';
        }
    }
    echo '<br />';
    echo '<p>Search for Friends</p>';

    echo form_open('user/message_receiver');

    $data = array(
            'name' => 'search',
            'maxlength' => '20'
        );

    echo form_input( $data );

    echo '<br />';
    if(isset($friends)) {
        if(is_array($friends)) {
            foreach($friends as $friend) {
                $data = array(
                    'name' => 'receivers[]',
                    'value' => $friend['userid']
                );
                echo '<p>'.form_checkbox($data).' '.$friend['firstname'].' '.$friend['lastname'].'</p>';
            }
        }
        else {
            echo '<p>No one was found by that name.</p>';
        }
        
    }

    echo '<br />';

    echo form_submit('submit','Send');

    echo form_close('');

    echo '<br /><br /><p><b>'.anchor('user/compose_message/','Finished Selecting Receivers').'</p></p>';

    ?>

</div>