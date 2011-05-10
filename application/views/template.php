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
        <?php if(isset($styles)) echo $styles; ?>

        <?php if(isset( $libraries)) echo $libraries; ?>

        <?php  if(isset($scripts)) echo $scripts; ?>
        
    </head>
    <body>
        <div id="wrapper">
            <div id="head">
                
            </div>
            <ul id="navigation">
                <li><?php echo anchor('', 'Home'); ?></li>
                <li><?php echo anchor('auth/logout', 'Logout'); ?></li>
                <li><?php echo anchor('auth/status', 'Account Status'); ?></li>
                <li><?php echo anchor('auth/change_password', 'Change Password'); ?></li>
                <li><?php echo anchor('auth/deactivate', 'Deactivate'); ?></li>
                 <li><?php echo anchor('auth/settings', 'Account Settings'); ?></li>
            </ul>

            <ul id="navigation-user">
                <li><?php echo anchor('user/profile', 'User Home'); ?></li>
                 <li><?php echo anchor('user/messages', 'Messages'); ?></li>
                 
            </ul>
            <div id="content">
                <?php echo $content."\n" ?>
            </div>
            <div id="foot">
                
            </div>
        </div>
    </body>
</html>