<?php
/*echo '<? xml version="1.0" encoding="utf-8" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';*/
?>
<html>
    <head>
        <title>Ukulima.net</title>
        <?php echo link_tag('assets/css/m.style.css'); ?>
    </head>
    <body>
        <div id="head">
            <div id="logo">
            </div>
            <div class="nav">
                <span><?php echo anchor('user/home', 'Home'); ?></span>
                <span> <?php echo anchor('user/profile', 'Profile'); ?></span>
                <span><?php echo anchor('user/updates', 'Updates'); ?></span>
                <span> <?php echo anchor('user/messages', 'Messages'); ?></span>
            </div>
        </div>
        <?php echo $content; ?>
        <div id="foot">
            <div class="nav">
                <span><?php echo anchor('user/home', 'Home'); ?></span>
                <span> <?php echo anchor('user/profile', 'Profile'); ?></span>
                <span><?php echo anchor('user/updates', 'Updates'); ?></span>
                <span> <?php echo anchor('user/messages', 'Messages'); ?></span>
                <span><?php echo anchor('auth/logout', 'Logout'); ?></span>
            </div>
            <div id="search">
            </div>
        </div>
		<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-19908404-7']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
    </body>
</html>