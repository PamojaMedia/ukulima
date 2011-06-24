<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <title>Ukulima.net</title>
        <?php echo link_tag('assets/css/reset.css')."\n"; ?>
        <?php echo link_tag('assets/css/jquery.gritter.css')."\n"; ?>
        <?php echo link_tag('assets/css/screen.css')."\n"; ?>
        <!--[if IE]>
            <?php echo link_tag('assets/css/ie.css')."\n"; ?>
        <![endif]-->
        <?php echo link_tag('assets/css/style.css')."\n"; ?>
        <?php echo link_tag('assets/css/typography.css')."\n"; ?>
		<?php echo link_tag('assets/css/menu.css')."\n"; ?>
        <?php if(isset($styles)) echo $styles; ?>

        <?php if(isset( $libraries)) echo $libraries; ?>

        <?php  if(isset($scripts)) echo $scripts; ?>

        <?php if(isset($crop_script1)) echo $crop_script1.$crop_script2; ?>
    </head>
    <body>
		<div id="head-wrapper">
			<div id="head-area">
				<div id="logo">
				
				</div>
				
				<div id="search">
				</div>
			
				<div id="links">
					<ul id="menu">
							 <li><?php echo anchor('user/home', 'Home'); ?></li>
							 <li><?php echo anchor('user/profile', 'Profile'); ?></li>
							<li ><?php echo anchor('', 'More',array('class'=>'drop')); ?>
							
							
							
        <div class="dropdown_3columns align_right"><!-- Begin 3 columns container -->
            
            <div class="col_3">
                <h2>Ukulima Dashboard</h2>
            </div>
            
            <div class="col_1">
    
                <h3>Account Settings</h3>
                <ul>
						
						<li><?php echo anchor('auth/status', 'Account Status'); ?></li>
						<li><?php echo anchor('auth/change_password', 'Change Password'); ?></li>
						<li><?php echo anchor('auth/deactivate', 'Deactivate'); ?></li>
						<li><?php echo anchor('auth/settings', 'Account Settings'); ?></li>
						<li><?php echo anchor('auth/logout', 'Logout'); ?></li>
                </ul>   
    
            </div>
            
            <div class="col_1">
    
             <h3>Account Actions</h3>
                <ul>
						<li><?php echo anchor('user/messages', 'Messages'); ?></li>
				
                </ul>   
    
            </div>
            
            <div class="col_1">
					<h3>More</h3>
					<ul>
					<li><?php echo anchor('', 'About Ukulima'); ?></li>
					<li><?php echo anchor('', 'How It Works'); ?></li>
					<li><?php echo anchor('', 'Privacy Policy'); ?></li>
					<li><?php echo anchor('', 'Terms and Conditions'); ?></li>
              </ul>
    
            </div>
            
          
        
        </div><!-- End 3 columns container -->
						</li>
							
						</ul>
						
				
				</div>
			
			</div>
			
	
		</div>
		<div id="splice">
		</div>
        <div id="wrapper">
            <div id="head">
                
            </div>
   

           
            <div id="content">
                <?php echo $content."\n" ?>
            </div>
            <div id="foot">
                
            </div>
        </div>
    </body>
</html>