<p class="title">Users on the site that you can add to your Network.</p>

<div>

    <?php
    
    if ($suggestconnects) {
        $count = 0;
        ?>
        <p>People To Connect with</p>
        <?php
        foreach($suggestconnects as $suggestconnect) {
            echo anchor('user/profile/'.$suggestconnect['userid'],'<b>'.$suggestconnect['firstname'].' '.$suggestconnect['lastname']).'</b><br />';
            echo anchor('user/connect_user/'.$suggestconnect['userid'],'Connect').'<br /><br />';
            $count++;
            if($count>=5)
                break;
        }
        echo '<br>';
        
    } 
    if ($suggesttracks) {
        $count = 0;
        ?>
        <p>People To Track</p>
        <?php
        foreach($suggesttracks as $suggesttrack) {
            echo anchor('user/profile/'.$suggesttrack['userid'],'<b>'.$suggesttrack['firstname'].' '.$suggesttrack['lastname']).'</b><br />';
            echo anchor('user/track_user/'.$suggesttrack['userid'],'Track').'<br /><br />';
            $count++;
            if($count>=5)
                break;
        }
        echo '<br>';
        
    }
    ?>

</div>