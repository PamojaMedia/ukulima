<h2 class="user_action">Share a Question</h2>

<?php echo $this->session->flashdata('message'); ?>

<?php echo validation_errors(); ?>

<?php echo form_open('user/create_question/',array('id' => 'form_submit')); ?>

<?php 
    $data = array(
          'name' => 'question',
          'id' => 'question',
          'cols' => '80',
          'rows' => '4',
          'class' =>'main'
    );

    echo '<p>'.form_textarea( $data ).'</p>'; ?>

<?php echo '<p>'.form_submit('submit','Question', 'class="button" id="submit" ').'</p>'; ?>

<?php echo form_close(''); ?>