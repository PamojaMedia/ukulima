<h4>User Content</h4>
<ul><?php
if($articles):
foreach($articles as $article):
?>
<li><?php echo $article->title;?> | <?php echo anchor('content/view/'.$article->ID,'View');?>| <?php echo $this->content_m->check_report($article->ID) ? '<b>Report is enabled for this item</b>' : '<b>Report is disabled for this item</b>';?></li>
<?php endforeach;
else: "<p>There is no user content Currently Available</p>";
endif;
?></ul>
<?php
echo anchor('content/create','Add New Conten   t');
?></br>
<?php echo anchor('',"Go back to Content Management Home");?>