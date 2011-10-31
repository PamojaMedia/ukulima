<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <title>Ukulima.net</title>

        <?php echo link_tag('assets/css/style.css'); ?>

        <?php echo $libraries; ?>

        <?php  if(isset($scripts)) echo $scripts; ?>

    </head>
    <body class="logged_out">

        <div id="head-wrapper">
            <div id="head-area">
                <div id="logo">
                    <?php echo anchor('auth/login','<img src="'.base_url().'/assets/images/logo-white.png" alt="ukulima.net" width="121px" height="17px" />'); ?>
                </div>

                <div id="links">
                    <ul id="menu">
                        <li><?php echo anchor('auth/login', 'Login'); ?></li>
                        <li><?php echo anchor('auth/register', 'Register'); ?></li>
                    </ul>
                </div>
            </div>
        </div>

        <div id="splice">
        </div>

        <div id="wrapper">

                <a id="home-banner" href=""></a>

                <div id="home-links">
                    <ul id="home-ul-links">
                        <li><a href="http://ukulima.net/dev/about/">About</a></li>
                        <li><a href="http://ukulima.net/developer/">Developers</a></li>
                        <li><a href="http://www.ukulima.net/dev/contact-us/">Contact Us</a></li>
                    </ul>
                </div>
                <?php echo $content."\n" ?>
        </div>

        <div id="foot" class="fixed_bottom">
            <div id="footer-splice"></div>
            <ul id="footul">
                <li><a href="http://ukulima.net/dev/about/">About</a></li>|
                <li><a href="http://ukulima.net/developer/">Developers</a></li>|
                <li><?php echo  anchor('','Terms')?></li>|
                <li><?php echo  anchor('','Privacy Policy')?></li>|
                <li><?php echo  anchor('','Help')?></li>
            </ul>
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