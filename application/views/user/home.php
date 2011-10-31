<div id="content-home">
    <script type="text/javascript">
        jQuery(document).ready(function() {
            jQuery('.item').mouseover(function() {
                var position = jQuery(this).position();
                jQuery('#the-background').show();
                jQuery('#the-background').animate({left:position.left, top:position.top}, 100);
            });
        });
    </script>
    <div id="the-background"></div>
    <div class="item">
        <?php echo anchor('user/profile','<img src="'.base_url().'/assets/images/profile.png" alt="Profile" /><span>Profile</span>'); ?>
    </div>
    <div class="item">
        <?php echo anchor('','<img src="'.base_url().'/assets/images/my.png" alt="My Farm" /><span>My Farm</span>'); ?>
    </div>
    <div class="item">
        <?php echo anchor('','<img src="'.base_url().'/assets/images/market.png" alt="Market Place" /><span>Market Place</span>'); ?>
    </div>
    <div class="item">
        <?php echo anchor('','<img src="'.base_url().'/assets/images/knowledge.png" alt="Knowledge Area" /><span>Knowledge Area</span>'); ?>
    </div>
    <div class="item">
        <?php echo anchor('','<img src="'.base_url().'/assets/images/apps.png" alt="App Store" /><span>App Store</span>'); ?>
    </div>
    <div class="item">
        <?php echo anchor('','<img src="'.base_url().'/assets/images/ads.png" alt="Advertisement" /><span>Advertisement</span>'); ?>
    </div>
</div>