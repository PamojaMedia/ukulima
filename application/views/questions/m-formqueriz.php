<p class="share_update">Share a Question</p>

<?php $this->session->flashdata('message'); ?>

<?php echo validation_errors(); ?>

<?php if(isset($userid)) {

        echo form_open('user/view2/'.$userid,array('id' => 'form_submit'));

    }

    else {

        echo form_open('user/questions/',array('id' => 'form_submit'));

    }
?>

<?php 
    $data = array(
          'name' => 'question',
          'id' => 'question',
          'cols' => '20',
          'rows' => '4',
          'class' =>'share_textarea'
    );

    echo '<p>'.form_textarea( $data ).'</p>'; ?>

<?php echo '<p>'.form_submit('submit','Question', 'class="button" id="submit" ').'</p>'; ?>

<?php echo form_close(''); ?>
<br />