<h2 class="user_action">You and other members</h2>
<hr class="hr-line">
<div id="rec-content">

    <?php

    if(count($updates) > 0) {

        $cur_update = $updates[0]['ID'];

        foreach($updates as $update) {

            if($update['ID']!=$cur_update && $update['parentid']!=$cur_update) {

                echo $form;

                echo '</div>';

                $cur_update = $update['ID'];

            }

            if($update['parentid']==0) {

                echo '<div class="main-content" id="update'.$update['ID'].'">';

                $textarea = array(
                        'class' =>'sub',
                        'name' => 'comment',
                        'id' => 'comment'.$update['ID'],
                        'cols' => '50',
                        'rows' => '3',
                );

                $button = array(
                        'name' => 'button'.$update['ID'],
                        'id' => 'button'.$update['ID'],
                        'value' => 'Comment',
                        'class' => 'button'
                );

                if($update['userid'] == $this->session->userdata['userid'] ||
                        (isset($update['rec_id']) && $update['rec_id'] == $this->session->userdata['userid'] ) ||
                        $update['connectstatus'] == 1) {
                    $can_comment = true;
                }
                else {
                    $can_comment = false;
                }

                $form = '</div></div>';

                if($can_comment) {

                    $form =

                        '</div>'.

                        '<div id="comment_box'.$update['ID'].'">'. // first close the div with the comment id

                            form_open('user/comment/',array('id' => 'comment-form'.$update['ID'] )).

                            form_textarea( $textarea ).

                            form_hidden("number", $update['ID'], false).

                            form_submit($button).

                            form_close().

                        '</div>
			</div> <!-- This is for the whole comment area-->
			';

                }

                $names = anchor('user/view/'.$update['userid'],'<b>'.$update['firstname'].' '.$update['lastname'].'</b> ', array('class'=>'user_link')).
                        (isset($update['rec_first'])?' to <b>'.$update['rec_first'].' '.$update['rec_last'].'</b>':'');


                echo '<div class="main-text"><span>'.$names.' '.$update['update'].'</span>' ;
                echo '<span id="update-time">updated '.timespan($update['date'], now()).'</span>';
                    if(isset($update['count']) && $update['count']>3) {
                        echo ' <span class="comment-count">'.anchor('user/view_update/'.$update['ID'],'<b>'.$update['count'].' Comments </b> ').'</span>';
                    }
                echo '</div>';
                if( ( isset($update['rec_id']) &&
                        $update['rec_id'] == $this->session->userdata['userid'] )
                    || $update['userid'] == $this->session->userdata['userid'] ) {
                    echo anchor('user/delete/'.$update['ID'], 'x', array('class' => 'delete', 'id' => 'deleteup'.$update['ID']));
                }
                if($can_comment || (isset($update['count']) && $update['count']>0)) {
                        echo '<div class="caret-area"><div class="caret"></div></div>';
                    }
                echo '<div class="sub-area"><div  id="comment_div'.$update['ID'].'">';

            }

            else {

                echo '<div class="sub-content" id="comment'.$update['ID'].'"> ';

                    echo '<span>'.anchor('user/view/'.$update['userid'],'<b>'.$update['firstname'].' '.$update['lastname'].'</b> ').$update['update'] .'</span>';

                    if( ( isset($update['rec_id']) &&
                            $update['rec_id'] == $this->session->userdata['userid'] )
                        || $update['userid'] == $this->session->userdata['userid'] ) {

                        echo anchor('user/update_delete/'.$update['ID'], 'x', array('class' => 'delete', 'id' => 'deletecm'.$update['ID']));

                    }

                echo '</div>';

            }

        }

        echo $form.' '.'</div>';

    }

    else {

        echo $error_message;

    }

    ?>

</div>