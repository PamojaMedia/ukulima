<h2 class="user_action">You and other members</h2>
<hr class="hr-line">
<div id="rec-content">

<?php

if(count($questions) > 0) {

$cur_question = $questions[0]['ID'];

foreach($questions as $question) {

    if($question['ID']!=$cur_question && $question['parentid']!=$cur_question) {

        echo $form;

        echo '</div>';

        $cur_question = $question['ID'];

    }

    if($question['parentid']==0) {

        echo '<div class="main-content" id="question'.$question['ID'].'">';

        $textarea = array(
              'class' =>'sub',
              'name' => 'answer',
              'id' => 'answer'.$question['ID'],
              'cols' => '50',
              'rows' => '3',
        );

        $button = array(
            'name' => 'button'.$question['ID'],
            'id' => 'button'.$question['ID'],
            'value' => 'Answer',
            'class' => 'button'
        );

        $form =

            '</div>'.

            '<div id="answer_box'.$question['ID'].'">'.

                form_open('user/answer/', array('id' => 'answer-form'.$question['ID'] )).

                    form_textarea( $textarea ).

                    form_hidden("number", $question['ID'], false).

                    form_submit($button).

                form_close().

            '</div>'.
            
            '</div>'; // This is for the whole comment area

        $names = anchor('user/view/'.$question['userid'],'<b>'.$question['firstname'].' '.$question['lastname'].'</b> ', array('class'=>'user_link'));
       // $names = anchor('user/view2/'.$question['userid'],'<b>'.$question['firstname'].' '.$question['lastname'].'</b> ', array('class'=>'user_link')).
         //       (isset($question['rec_first'])?'<div style="float:left;">to <b>'.$question['rec_first'].' '.$question['rec_last'].'</b> </div>':'');

        echo '<div class="main-text"><span>'.$names.' '.$question['question'].'</span>' ;
            if(isset($question['count']) && $question['count']>3) {
                echo ' <span class="comment-count">'.anchor('user/view_question/'.$question['ID'],'<b>'.$question['count'].' Answers </b> ').'</span>';
            }
        echo '</div>';
        
        if($question['userid']==$this->session->userdata['userid']) {
		echo anchor('user/delete_question/'.$question['ID'], 'x', array('class' => 'delete', 'id' => 'deleteup'.$question['ID']));
        }

        echo '<div class="caret-area"><div class="caret"></div></div>';
        echo '<div class="sub-area">
		<div id="answer_div'.$question['ID'].'">';

    }

    else {

	
	
	
        echo '<div class="sub-content" id="answer'.$question['ID'].'"> ';
		
            echo '<span>'.anchor('user/view/'.$question['userid'],'<b>'.$question['firstname'].' '.$question['lastname'].'</b> ').$question['question'] .'</span>';

                if($question['userid']==$this->session->userdata['userid']) {

                    echo anchor('user/question_delete/'.$question['ID'], 'x', array('class' => 'delete', 'id' => 'deletecm'.$question['ID']));

                }

            echo '</div>';
	   
         //echo '<div style="float:left; display:block;">'.anchor('user/view/'.$question['userid'],'<b>'.$question['firstname'].' '.$question['lastname'].'</b> ').$question['question'] .'</div>'. anchor('user/question_delete/'.$question['ID'], 'x', array('class' => 'delete', 'id' => 'deletecm'.$question['ID']));
		
        //echo '</div>';

    }

}

echo $form.' '.'</div>';

}

else {

    echo $error_message;

}

?>

</div>