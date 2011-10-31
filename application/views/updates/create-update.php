<div class="main-content" id="update<?php echo $update['ID'] ?>">
<?php
    $names = anchor('user/view/'.$update['userid'],'<b>'.$update['firstname'].' '.$update['lastname'].'</b> ', array('class'=>'user_link'));

    echo '<div class="main-text"><span>'.$names.' '.$update['update'].'</span></div>';
    
    echo anchor('user/delete/'.$update['ID'], 'x', array('class' => 'delete', 'id' => 'deleteup'.$update['ID']));

    echo '<div class="caret-area"><div class="caret"></div></div>';

    echo '<div class="sub-area">';

        echo '<div id="comment_div'.$update['ID'].'"></div>';

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

        echo '<div id="comment_box'.$update['ID'].'">';

            echo form_open('user/comment/',array('id' => 'comment-form'.$update['ID'] ));

                echo form_textarea( $textarea );

                echo form_hidden("number", $update['ID'], false);

                echo form_submit($button);

            echo form_close();

        echo '</div>';

    echo '</div>';
?>
</div>