<div class="main-content" id="update<?php echo $question['ID'] ?>">
<?php
    $names = anchor('user/view/'.$question['userid'],'<b>'.$question['firstname'].' '.$question['lastname'].'</b> ', array('class'=>'user_link'));

    echo '<div class="main-text"><span>'.$names.' '.$question['update'].'</span></div>';
    
    echo anchor('user/delete_question/'.$question['ID'], 'x', array('class' => 'delete', 'id' => 'deleteup'.$question['ID']));

    echo '<div class="caret-area"><div class="caret"></div></div>';

    echo '<div class="sub-area">';

        echo '<div id="answer_div'.$question['ID'].'"></div>';

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
            'value' => 'Comment',
            'class' => 'button'
        );

        echo '<div id="answer_box'.$question['ID'].'">';

            echo form_open('user/answer/', array('id' => 'answer-form'.$question['ID'] ));

                echo form_textarea( $textarea );

                echo form_hidden("number", $question['ID'], false);

                echo form_submit($button);

            echo form_close();

        echo '</div>';

    echo '</div>';
?>
</div>