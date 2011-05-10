<h3>VIEW REPORT</h3><br/>
This item has been reported on the basis of : <?php echo $report->causeid;?><br/>

Causer : <?php echo $causer->firstname.' '. $causer->lastname;?><br/>
Reported by : <?php echo $reporter->firstname.' '.$reporter->lastname;?><br/>
Title of Content : <?php echo anchor('content/view/'.$article->ID,$article->title);?>  Click to view the content <br/>

<ul>
<li><?php echo anchor('reports/unread/'.$report->ID,"Mark Report as Unread");?></li><br/>
<li><?php echo anchor('reports/index',"Go Back to Reports List");?></li></br>
<li><?php echo anchor ('',"Content Management Home");?></li></br>

</ul>