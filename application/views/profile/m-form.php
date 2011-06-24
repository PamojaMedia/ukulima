<p class="title">
    <?php
        if($search_for=='tracks') {
            if(isset($profile) && $profile) {
                echo 'Search for people '.$profile['firstname'].' tracks';
            }
            else {
                echo 'Search for people you track';
            }
        }
        elseif($search_for=='trackback') {
            if(isset($profile) && $profile) {
                echo 'Search for people tracking '.$profile['firstname'];
            }
            else {
                echo 'Search for people who track you';
            }
        }
        elseif($search_for=='connections') {
            if(isset($profile) && $profile) {
                echo 'Search for people connected to '.$profile['firstname'];
            }
            else {
                echo 'Search for people you are connected to';
            }
        }
    ?>
</p>

<?php $this->session->flashdata('message'); ?>

<?php echo validation_errors(); ?>

<?php 
    echo form_open('user/network_search/'.$search_for.'/'.$userid);
?>

<?php 
    $value = '';
    if(isset($search_query)) {
        $value = $search_query;
    }
    $data = array(
        'name' => 'search',
        'maxlength' => '20',
        'value' => $value
    );

    echo '<p>'.form_input( $data ).'</p>'; ?>

<?php echo '<p>'.form_submit('submit','Search').'</p>'; ?>

<?php echo form_close(''); ?>
<br />