<?php if ($this->session->flashdata('success')): ?>
    <div class="message success">
		<h6>Success</h6>
		<p><?php echo $this->session->flashdata('success'); ?></p>
		<a class="close" title="Close" href="#"></a>
	</div>
<?php endif; ?>



<?php if($categories):?>
<ul>
<?php
foreach($categories as $category):
?>
<li><?php echo $category->name;?>   |  <?php echo anchor('category/edit/'.$category->id,'Edit');?> | <?php echo anchor('category/delete/'.$category->id,'Delete');?></li>
<?php endforeach;?>
</ul>
<?php
else:
?>
<p>There are currently No  Categories</p>
<?php endif;?>


<br/>
<p><?php echo anchor('category/create','Add Content Category');?></p>
<p><?php echo anchor('category/manage','Manage Report Permission');?></p>