<p class="title">Users on the site that you can add to your Network.</p>

<div>

    <?php
    
    if ($suggestions) {
        foreach($suggestions as $suggest) {
            echo anchor('user/profile/'.$suggest['userid'],'<b>'.$suggest['firstname'].' '.$suggest['lastname']).'</b><br />';
            echo anchor('user/track_user/'.$suggest['userid'],'Track').' | '.anchor('user/connect_user/'.$suggest['userid'],'Connect').'<br /><br />';
        }
        echo '<br>';
        echo '<p>'.anchor('user/network_suggestions/'.$page,'View More').' Network Suggestions. </p><br />';
    } else {

        echo $error_message;
    }
    ?>

</div>