<div class="content">
<p class="title">Bio Page</p>
<br />
<?php echo $this->session->flashdata('message').'<br />'; ?>

<?php echo validation_errors().'<br />'; ?>

<?php echo form_open('auth/bio'); ?>

<p>Activities you are involved in: </p>
<?php
    $data = array(
          'name' => 'activity',
          'cols' => '20',
          'rows' => '4',
          'value' => set_value('activity',$activity)
    );

    echo '<p>'.form_textarea( $data ).'</p>'; ?>

<br />
<p>What are your interests: </p>
<?php
    $data = array(
          'name' => 'interest',
          'cols' => '20',
          'rows' => '4',
          'value' => set_value('interest',$interest)
    );

    echo '<p>'.form_textarea( $data ).'</p>'; ?>

<br />
<p>Which Country do you reside in?</p>
<p>
    <?php

    $countries = array(
        array(
            'value' => 'Kenya',
            'text' => 'Kenya'
        ),
        array(
            'value' => 'Uganda',
            'text' => 'Uganda'
        ),
        array(
            'value' => 'Tanzania, United Republic of',
            'text' => 'Tanzania'
        ),
        array(
            'value' => 'Rwanda',
            'text' => 'rwanda'
        ),
        array(
            'value' => 'Burundi',
            'text' => 'Burundi'
        ),
        array(
            'value' => 'Ethiopia',
            'text' => 'Ethiopia'
        )

    )

    ?>
    <select name="country">
        <option value="none" selected="selected">Select Country</option>
        <?php
        foreach($countries as $ctry) {
            echo '<option value="'.$ctry['value'].'" '.set_select('country',$ctry['value'],($ctry['value']==$country?true:false)).'>'.$ctry['text'].'</option>';
        }
        ?>
    </select>
</p>
<br />
<p>What is your current location (Town or City): </p>
<p><?php echo form_input('location', set_value('location', $location)); ?></p>
<br />
<?php echo form_submit('submit', 'Submit'); ?>

<?php echo form_close(''); ?>
<br />
</div>