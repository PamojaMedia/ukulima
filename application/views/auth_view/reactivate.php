<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<h1>Re-activate</h1>

<p><?php echo $username; ?>, In order to access areas of you're account please use this link  <?php echo anchor('auth/reactivate_link/'.$username.'/'.$userid, 'here'); ?> </p>