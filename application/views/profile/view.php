<h1 class="share_update">You and other members</h1>
<hr class="hr-line">
<div class="splices"> </div>
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
			  'class' =>'user_comment',	
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

        $form =

            '</div>'.

            '<div id="comment_box'.$update['ID'].'">'.

            form_open('user/comment/').

            '<p class="comment_submit">'.form_textarea( $textarea ).'</p>'.

            form_hidden("number", $update['ID'], false).

            '<p class="comment_submit">'.form_submit($button).'</p>'.

            form_close().

            '</div>
			</div> <!-- This is for the whole comment area-->
			';

        $names = anchor('user/view/'.$update['userid'],'<b>'.$update['firstname'].' '.$update['lastname'].'</b> ', array('class'=>'user_link')).
                (isset($update['rec_first'])?'<div style="float:left;">to <b>'.$update['rec_first'].' '.$update['rec_last'].'</b> </div>':'');

		
        echo '<div style="display:block; overflow:hidden; width:100%;">'.$names.'<span class="p-content">'.$update['update'].'</span>' ;
					if(isset($update['count']) && $update['count']>3) {
           echo ' <div style="float:left; display:block;">'.anchor('user/view_update/'.$update['ID'],'<b>'.$update['count'].' Comments </b> ').'</div>';
       }
		echo anchor('user/delete/'.$update['ID'], 'x', array('class' => 'delete', 'id' => 'deleteup'.$update['ID'])).'</div>';
		echo '<div class="caret-area"><div class="caret"></div></div>';
        echo '<div class="comment-area">
		<div id="comment_div'.$update['ID'].'">';

    }

    else {

	
	
	
        echo '<div class="comment" id="comment'.$update['ID'].'"> ';
		
	
	   
         echo '<div style="float:left; display:block;">'.anchor('user/view/'.$update['userid'],'<b>'.$update['firstname'].' '.$update['lastname'].'</b> ').$update['update'] .'</div>'. anchor('user/update_delete/'.$update['ID'], 'x', array('class' => 'delete', 'id' => 'deletecm'.$update['ID']));
		
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