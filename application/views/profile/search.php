<div>

    <?php
    
    if ($search) {
        foreach($search as $s) {
            echo anchor('user/profile/'.$s['userid'],'<b>'.$s['firstname'].' '.$s['lastname'].'</b> <br />');
        }
    } else {

        echo $error_message;
    }
    ?>

</div>