<h2>Report This Item </h2>
<?php
$userID=12;
$reporter=5;
$contentID=6;
echo form_open('reports/report/'.$userID.'/'.$reporter.'/'.$contentID);?>


<?php
$causes=array('1'=>'Prohibited Language',
              '2'=>'Vulgarity',
              '3'=>'Derogative Photo',
              '4'=>'Targets a certain community',
              '5'=>'Racist');
echo form_label('Cause').'&nbsp;';
echo form_dropdown('cause',$causes,'1').'<br/><br/>';
echo form_submit('submit',"Submit");
echo form_close();
?>