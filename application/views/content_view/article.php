

Article ID:  <?php echo $article->ID; ?><br/>
Title Of Article:  <?php echo $article->title;?><br/>
Content: <?php echo $article->content;?><br/>



<?php if($status): $this->load->view('reports/form'); endif;?>