<h3>Administrator Home</h3>
<h4>Reports Submitted by Users</h4>
<ul><?php
if($reports):
    foreach($reports as $report):?>
    <li><?php echo $report->ID;?> | <?php echo anchor('reports/view/'.$report->ID,"View");?> | <?php echo $report->status ? "READ" : "UNREAD";?> </li>
   <?php  endforeach;
else:?>

<?php
endif;
?></ul><br/>
<?php echo anchor ('',"Go Back to Content Management Home");?>