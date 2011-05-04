<div style="width:500px; float:left; height:auto; overflow:hidden;"><h1>Your Profile</h1>

<pre class="notice"><?php 
 echo $profile['username'].'&nbsp;'.$profile['firstname'].'-'.$profile['lastname'].'<br/>';

echo $profile['email'].'<br/>';



?> </pre>
<h1>Users on the site</h1>
<pre class="notice"><?php

foreach ($users as $user_obj)
{
echo $user_obj['username'].'&nbsp;'.$user_obj['firstname'].'-'.$user_obj['lastname'].' <a href=""> Follow user</a><br/>';
}
?></pre>

</div>



<?php if($update_user): ?>
<div style="width:500px; float:left; height:auto; overflow:hidden;">
<?php echo $update_user; ?>
</div>
<?php endif; ?>

<?php if($messaging) : ?>
<div style="width:500px; float:left; height:auto; overflow:hidden;">
<?php echo $messaging; ?>
</div>
<?php endif; ?>