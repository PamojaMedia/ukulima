<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <title>Ukulima.net</title>
        
        <?php echo link_tag('assets/css/style.css'); ?>

        <?php if(isset( $libraries)) echo $libraries; ?>

        <?php  if(isset($scripts)) echo $scripts; ?>

        <?php  if(isset($styles)) echo $styles; ?>

        <?php if(isset($crop_script1)) echo $crop_script1.$crop_script2; ?>
    </head>
    <body>
        <div id="head-wrapper">
            <div id="head-area">
                <div id="logo">
                    <?php echo anchor('user/home','<img src="'.base_url().'/assets/images/logo-white.png" alt="ukulima.net" width="121px" height="17px" />'); ?>
                </div>

                <div id="search">
                    <?php echo form_open('user/network_search'); ?>
                        <input type="text" class="search" value="Search" name="search"
                               onclick="if(this.value=='Search'){this.value=''}"
                               onblur="if(this.value==''){this.value='Search'}" />
                        <input type="submit" class="search_submit" value=""/>
                    <?php echo form_close(); ?>
                </div>

                <div id="links">
                    <ul id="menu">
                        <li><?php echo anchor('user/home', 'Home'); ?> <div class="drop-arrow"></div>
                            <ul class="submenu">
                                <li><?php echo anchor('user/profile', 'My Farm'); ?></li>
                                <li><?php echo anchor('user/profile', 'Market place'); ?></li>
                                <li><?php echo anchor('user/profile', 'Knowledge Area'); ?></li>
                                <li><?php echo anchor('user/profile', 'App Store'); ?></li>
                                <li><?php echo anchor('user/profile', 'Advertisement'); ?></li>
                            </ul>
                        </li>
                        <li><?php echo anchor('user/profile', 'Profile'); ?> <div class="drop-arrow"></div>
                            <ul class="submenu">
                                <li><?php echo anchor('user/updates', 'Updates'); ?></li>
                                <li><?php echo anchor('user/messages', 'Messages'); ?></li>
                                <li><?php echo anchor('user/questions', 'Questions'); ?></li>
                            </ul>
                        </li>
                        <li><?php echo anchor('auth/logout', 'Logout'); ?></li>
                    </ul>


                </div>

            </div>


        </div>
        <div id="wrapper">

            <div id="content">
                <?php echo $content."\n" ?>
            </div>

        </div>
        
        <div id="foot">
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