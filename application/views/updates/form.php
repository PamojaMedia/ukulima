<h1>Enter your update</h1>

<?php echo $this->session->flashdata('message'); ?>

<?php echo validation_errors(); ?>

<?php if(isset($userid)) {

        echo form_open('user/update_create/'.$userid,array('id' => 'form_submit'));

    }

    else {

        echo form_open('user/update_create',array('id' => 'form_submit'));

    }
?>

<?php 
    $data = array(
          'name' => 'update',
          'id' => 'update',
          'cols' => '50',
          'rows' => '3',
    );

    echo '<p>'.form_textarea( $data ).'</p>'; ?>

<?php echo '<p>'.form_submit('submit','Update', 'class="button" id="submit" ').'</p>'; ?>

<?php echo form_close(''); ?>