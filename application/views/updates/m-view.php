<p class="title">
<?php
// if user is viewing someone's profile
if(isset($profile)) {
    echo 'Viewing <b>'.$profile['firstname'].' '.$profile['lastname'].'\'s</b> Profile';
    $view_more_link = anchor('user/view/'.$profile['userid'].'/'.$page,'View More Updates');
}
elseif(isset($view_update)) {
    echo 'Viewing an Update';
}
else {
    echo 'Recent Updates';
    $view_more_link = anchor('user/home/'.$page,'View More Updates');
}
?>    
</p>

<div id="rec_updates">

    <?php
    
    if (count($updates) > 0) {
        // variable for tracking the current update
        $cur_update = $updates[0]['ID'];
        // variable to keep the userid of the update
        $up_userid = $updates[0]['userid'];
        // variable to keep the ownerid of the update...if any
        $up_ownerid = 0;
        if(isset($updates[0]['rec_id'])) {
            $up_owner_id = $updates[0]['rec_id'];
        }

        foreach ($updates as $update) {

            if ($update['ID'] != $cur_update && $update['parentid'] != $cur_update) {

                echo '</div></div>'; // close the comment-area div and the update div
                // get the current update
                $cur_update = $update['ID'];

                // get the current userid
                $up_userid = $update['userid'];

                // get the current receiver id...if none, reset the value
                $up_ownerid = 0;
                if(isset($update['rec_id'])) {
                    $up_ownerid = $update['rec_id'];
                }
            }

            if ($update['parentid'] == 0) {

                echo '<div class="update" >';

                $names = anchor('user/view/' . $update['userid'], '<b>' . $update['firstname'] . ' ' . $update['lastname'] . '</b> ', array('class' => 'user-link')) .
                        (isset($update['rec_first']) ? 'to <b>' . $update['rec_first'] . ' ' . $update['rec_last'] . '</b> ' : '');

                echo '<p class=update-text>' . $names . '<span class="p-content">' . $update['update'] . '</span>';
                echo '<span class="update-time-mobile">updated '.timespan($update['date'], now()).'</span>';
                if( $up_userid==$this->session->userdata['userid'] || $up_ownerid==$this->session->userdata['userid'] ) {
                    echo anchor('user/delete/' . $update['ID'], '<b> X </b>', array('class' => 'delete', 'id' => 'deleteup' . $update['ID']));
                }
                
                echo '</p>';
                
                echo '<div class="comment-area">';

                if(isset($update['count']) && $update['count'] > 3) {
                    echo $update['count'].' comments | '. anchor('user/view_update/'.$update['ID'],'View All') .' | ';
                }

                if($up_userid == $this->session->userdata['userid'] ||
                        $up_ownerid == $this->session->userdata['userid'] ||
                        $update['connectstatus'] == 1) {
                    echo anchor('user/view_update/'.$update['ID'],'Comment');
                }

            } else {

                echo '<p class="comment-text">'.anchor('user/view/' . $update['userid'], '<b>' . $update['firstname'] . ' ' . $update['lastname'] . '</b> ') . $update['update'];
                if( $update['userid']==$this->session->userdata['userid'] ||
                        $up_userid==$this->session->userdata['userid'] ||
                        $up_ownerid==$this->session->userdata['userid'] ) {
                    echo anchor('user/delete/' . $update['ID'], '<b> X </b>', array('class' => 'delete'));
                }
                echo '</p>';



            }
        }
        
        if(isset($view_update)) {
            
            if($update['userid'] == $this->session->userdata['userid'] ||
                    (isset($update['rec_id']) && $update['rec_id'] == $this->session->userdata['userid'] ) ||
                    $update['connectstatus'] == 1) {
                
                $textarea = array(
                      'name' => 'comment',
                      'cols' => '20',
                      'rows' => '4',
                );

                $button = array(
                    'name' => 'button',
                    'value' => 'Comment'
                );

                $form =

                    '<div>'.

                        form_open('user/view_update/'.$updates[0]['ID']).

                            '<p class="comment_submit">'.form_textarea( $textarea ).'</p>'.

                            form_hidden("number", $updates[0]['ID'], false).

                            '<p class="comment_submit">'.form_submit($button).'</p>'.

                        form_close().

                    '</div>';

                echo $form;
                
            }
            
        }
        echo '</div>';

        if(!isset($view_update)) {
            echo '<p><br />'.$view_more_link.'<br /></p>';
        }

    } else {
        echo $error_message;
    }
    ?>

</div>