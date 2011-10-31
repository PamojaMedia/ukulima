<h1>Avatar</h1>



<?php echo form_open_multipart('auth/do_crop'); ?>

<table>
    <thead>
        <tr>
            <th colspan="2">Crop your profile picture</th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <td>Avatar</td>
            <td>     <input type="hidden" name="x" id="x" value="" />
     <input type="hidden" name="y" id="y" value="" />
     <input type="hidden" name="x2" id="x2" value="" />
     <input type="hidden" name="y2" id="y2" value="" />
     <input type="hidden" name="w" id="w" value="" />
     <input type="hidden" name="h" id="h" value="" />
     <input type="hidden" name="ext" value="<?php echo $file_extension; ?>">
     <input type="hidden" name="path" value="<?php echo $success;?>">
     <input type="hidden" name="file_name" value="<?php echo $file_crop_name;?>">
     <!-- You will probably want to store the id or path to the image you are altering -->
     <img id="cropthis" src="<?php echo $success; ?>" alt="Image to crop" />
</td>
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
