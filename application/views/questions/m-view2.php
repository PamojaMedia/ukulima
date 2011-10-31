<p class="title">
<?php
// if user is viewing someone's profile
if(isset($profile)) {
    echo 'Viewing <b>'.$profile['firstname'].' '.$profile['lastname'].'\'s</b> Profile';
    $view_more_link = anchor('user/view/'.$profile['userid'].'/'.$page,'View More Questions');
}
elseif(isset($view_question)) {
    echo 'Viewing a Question';
}
else {
    echo 'Recent Questions';
    $view_more_link = anchor('user/questions/'.$page,'View More Questions');
}
?>    
</p>

<div id="rec_questions">

    <?php
    
    if (count($questions) > 0) {
        // variable for tracking the current question
        $cur_question = $questions[0]['ID'];
        // variable to keep the userid of the question
        $qn_userid = $questions[0]['userid'];
        
        foreach ($questions as $question) {
            
            if ($question['ID'] != $cur_question && $question['parentid'] != $cur_question) {

                echo '</div></div>'; // close the comment-area div and the update div
                // get the current update
               $cur_question = $question['ID'];

                // get the current userid
               $qn_userid = $question['userid'];

            }

            if ($question['parentid'] == 0) {

                echo '<div class="update" >';

                $names = anchor('user/view/' . $question['userid'], '<b>' . $question['firstname'] . ' ' . $question['lastname'] . '</b> ', array('class' => 'user-link')) .
                        (isset($question['rec_first']) ? 'to <b>' . $question['rec_first'] . ' ' . $question['rec_last'] . '</b> ' : '');

                echo '<p class=update-text>' . $names . '<span class="p-content">' . $question['question'] . '</span>';
                
                if( $qn_userid==$this->session->userdata['userid'] ) {
                    echo anchor('user/delete_question/' . $question['ID'], '<b> X </b>', array('class' => 'delete', 'id' => 'deleteup' . $question['ID']));
                }
                
                echo '</p>';
                
                echo '<div class="comment-area">';

                if(isset($question['count']) && $question['count'] > 3) {
                    echo $question['count'].' answers | '. anchor('user/view_question/'.$question['ID'],'View All') .' | ';
                }

                echo anchor('user/view_question/'.$question['ID'],'Answer');

            } else {

                echo '<p class="comment-text">'.anchor('user/view/' . $question['userid'], '<b>' . $question['firstname'] . ' ' . $question['lastname'] . '</b> ') . $question['question'];
                if( $question['userid']==$this->session->userdata['userid'] ||
                        $qn_userid==$this->session->userdata['userid'] ) {
                    echo anchor('user/delete_answer/' . $question['ID'], '<b> X </b>', array('class' => 'delete'));
                }
                echo '</p>';



            }
        }
        
        if(isset($view_question)) {

            $textarea = array(
                  'name' => 'answer',
                  'cols' => '20',
                  'rows' => '4',
            );

            $button = array(
                'name' => 'button',
                'value' => 'Answer'
            );

            $form =

                '<div>'.

                    form_open('user/view_question/'.$questions[0]['ID']).

                        '<p class="comment_submit">'.form_textarea( $textarea ).'</p>'.

                        form_hidden("number", $questions[0]['ID'], false).

                        '<p class="comment_submit">'.form_submit($button).'</p>'.

                    form_close().

                '</div>';

            echo $form;
            
        }
        echo '</div>';

        if(!isset($view_question)) {
            echo '<p><br />'.$view_more_link.'<br /></p>';
        }

    } else {
        echo $error_message;
    }
    ?>

</div>