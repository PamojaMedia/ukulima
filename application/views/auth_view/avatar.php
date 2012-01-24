<h1>Avatar</h1>

<?php echo $this->session->flashdata('message'); ?>

<?php if(isset($error)) echo $error; ?>

<?php if(isset($success))
{?>

    <?php foreach ($success as $item => $value):?>
<li><?php echo $item;?>: <?php echo $value;?></li>
<?php endforeach; ?>

<?php

}
    ?>

<?php echo form_open_multipart('auth/do_upload'); ?>
<br>
<table>
    <thead>
        <tr>
            <th colspan="2">Complete your profile by adding a picture</th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <td>Avatar</td>
            <td><input type="file" name="avatar" size="20" /></td>
        </tr>



    </tbody>
</table>

<table>
    <thead>
        <tr>

        </tr>
    </thead>
    <tbody>

    </tbody>
    <tfoot>
        <tr>
            <td colspan="2"><?php echo form_submit('submit', 'Submit'); ?></td>
        </tr>
    </tfoot>
</table>

<?php echo form_close(''); ?><?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
