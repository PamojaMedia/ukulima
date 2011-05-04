<script type="text/javascript">
     var l = jQuery.noConflict();

     l(document).ready(function(){
          l('.follow').click(function() {
 
              var the_url = "<?php echo site_url('user/follow_user/'); ?>";
               var the_id = this.id;



            l.ajax({
                     url: the_url,
                    type: 'POST',
                    data: the_id,
                    success: function(result){

                    }

            });

          });
     });
</script>
