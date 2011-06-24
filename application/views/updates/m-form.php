<p class="share_update">Share an update</p>

<?php $this->session->flashdata('message'); ?>

<?php echo validation_errors(); ?>

<?php if(isset($userid)) {

        echo form_open('user/view/'.$userid,array('id' => 'form_submit'));

    }

    else {

        echo form_open('user/home/',array('id' => 'form_submit'));

    }
?>

<?php 
    $data = array(
          'name' => 'update',
          'id' => 'update',
          'cols' => '20',
          'rows' => '4',
          'class' =>'share_textarea'
    );

    echo '<p>'.form_textarea( $data ).'</p>'; ?>

<?php echo '<p>'.form_submit('submit','Update', 'class="button" id="submit" ').'</p>'; ?>

<?php echo form_close(''); ?>
<br />