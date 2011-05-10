<?php if ($this->session->flashdata('error')): ?>
<div class="message error">
	<h6>Error</h6>
	<p><?php echo $this->session->flashdata('error'); ?></p>
	<a class="close" title="Close this message" href="#"></a>
</div>
<?php endif; ?>

<?php if (!empty($this->form_validation->error_string)): ?>
<div class="message error">
	<h6>Required field missing</h6>
	<p><?php echo $this->form_validation->error_string; ?></p>
	<a class="close" title="Close this message" href="#"></a>
</div>
<?php endif; ?>

<?php if (validation_errors()): ?>
<div class="message error">
	<h6>Required field missing</h6>
	<p><?php echo validation_errors(); ?></p>
	<a class="close" title="Close this message" href="#"></a>
</div>
<?php endif; ?>

<!-----THE FORM STARTS HERE---------->
<?php

$qq=$this->uri->segment(2)=='edit';
echo form_open($this->uri->uri_string());
echo form_input('name',$qq ? $category->name: '');

echo form_submit('submit',$qq ? 'Update Category':'Create Category');
echo anchor('category/index','Cancel');

?>