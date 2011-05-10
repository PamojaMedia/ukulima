<p><?php
echo form_open_multipart($this->uri->uri_string());?></p><br/>
<p>Title <?php echo form_input('title');?></p><br/>
<?php $data = array(
              'name'        => 'content',
              
             
              'rows'   => '5',
              'cols'        => '50',
              
            );?>
<p>Content <?php echo form_textarea($data);?></p><br/>
<p>File <?php echo form_upload('userfile');?></p><br/>
<p>Content Type<?php echo form_dropdown('type',$categs);?></p><br/>
 <?php $status=array('1'=>'Live','0'=>'Draft');?>
<p>Status<?php echo form_dropdown('status',$status);?></p><br/>
<?php echo form_submit('submit','Submit');?>

</form>
<?php echo anchor ('',"Cancel and Go Back");?>