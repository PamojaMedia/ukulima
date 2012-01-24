<p class="title"><?php if($this->session->flashdata('message')){ echo $this->session->flashdata('message'); }else{?>Users on the site that you can add to your Network.<?php }?></p>

<div> 

    <?php
    
    if ($suggestconnects) {
        ?>
        <div id="suggestconnect-area">
            <h2 id="profile-title">People to Connect</h2>
            <p>When you are connected to another user, you have more channels of interaction i.e Write on their wall, comment on their updates and send a message.</p>
        <?php
        foreach($suggestconnects as $suggestconnect) {
            
            echo anchor('user/profile/'.$suggestconnect['userid'],'<b>'.$suggestconnect['firstname'].' '.$suggestconnect['lastname']).'</b><br />';
            echo anchor('user/connect_user/'.$suggestconnect['userid'],'Connect').'<br /><br />';
        }
        echo '<br>';
        //echo '<p>'.anchor('user/network_suggestions/'.$page,'View More').' Network Suggestions. </p><br />';
        ?>
        </div>
        <?php
        
    } 
    if ($suggesttracks) {
        ?>
    <div id="suggesttrack-area">
        <h2 id="profile-title">People to Track</h2>
        <p>When you are tracking a user, you can only see their updates on your wall.</p>
        <?php
         foreach($suggesttracks as $suggesttrack) {
            
            echo anchor('user/profile/'.$suggesttrack['userid'],'<b>'.$suggesttrack['firstname'].' '.$suggesttrack['lastname']).'</b><br />';
            echo anchor('user/track_user/'.$suggesttrack['userid'],'Track').'<br /><br />';
        }
        ?>
        </div>
        <?php
    }
    
    else {

        echo $error_message;
    }
    ?>

</div>