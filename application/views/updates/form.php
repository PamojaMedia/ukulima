<h2 class="user_action">Share an update</h2>

<?php echo $this->session->flashdata('message'); ?>

<?php echo validation_errors(); ?>

<?php if(isset($userid)) {

        echo form_open('user/create_update/'.$userid,array('id' => 'form_submit'));

    }

    else {

        echo form_open('user/create_update/',array('id' => 'form_submit'));

    }
?>

<?php 
    $data = array(
          'name' => 'update',
          'id' => 'update',
          'cols' => '80',
          'rows' => '4',
          'class' =>'main'
    );

    echo '<p>'.form_textarea( $data ).'</p>'; ?>

<?php echo '<p>'.form_submit('submit','Update', 'class="button" id="submit" ').'</p>'; ?>

<?php echo form_close(''); ?>