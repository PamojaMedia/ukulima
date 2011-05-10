<h1>Recent Updates</h1>

<div id="rec_updates">

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

        echo '<div class="update" id="update'.$update['ID'].'">';

        $textarea = array(
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

        $hidden = array(
            'number' => $update['ID']
        );

        $form =

            '</div>'.

            '<div id="comment_box'.$update['ID'].'">'.

            form_open('user/comment/').

            '<p>'.form_textarea( $textarea ).'</p>'.

            form_hidden("number", $update['ID'], false).

            '<p>'.form_submit($button).'</p>'.

            form_close().

            '</div>';

        $names = anchor('user/view/'.$update['userid'],'<b>'.$update['firstname'].' '.$update['lastname'].'</b> ').
                (isset($update['rec_first'])?'to <b>'.$update['rec_first'].' '.$update['rec_last'].'</b> ':'');

        echo $names.$update['update'] . anchor('user/delete/'.$update['ID'], 'Delete', array('class' => 'delete', 'id' => 'deleteup'.$update['ID']));

        echo '<div id="comment_div'.$update['ID'].'">';

    }

    else {

        echo '<div class="comment" id="comment'.$update['ID'].'"> ------';

         echo anchor('user/view/'.$update['userid'],'<b>'.$update['firstname'].' '.$update['lastname'].'</b> ').$update['update'] . anchor('user/update_delete/'.$update['ID'], 'Delete', array('class' => 'delete', 'id' => 'deletecm'.$update['ID']));

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