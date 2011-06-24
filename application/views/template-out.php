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

        <?php echo $libraries; ?>

        <?php  if(isset($scripts)) echo $scripts; ?>

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
							 <li><?php echo anchor('', 'Home'); ?></li>
							<li><?php echo anchor('auth/register', 'Register'); ?></li>
							<li><?php echo anchor('auth/login', 'Login'); ?></li>
					
					
						</ul>
				</div>	
			</div>
		</div>
		<div id="splice">
		</div>
        <div id="wrapper">
            <div id="head">

            </div>
         

            <ul id="navigation-user">

            </ul>
            <div id="content">
                <?php echo $content."\n" ?>
            </div>
            <div id="foot">

            </div>
        </div>
    </body>
</html>