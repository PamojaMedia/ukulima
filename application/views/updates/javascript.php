<script type="text/javascript">
var j = jQuery.noConflict();
j(document).ready(function(){

    j('.button').live('click',function() {

        var id = this.id;
        j('#'+id).attr('disabled','disabled');

        if(id=='submit') {
            var the_url = j('#form_submit').attr('action');
            var form_data = j('#form_submit').serialize()+'&ajax=1';
        }

        else {
            var index = parseInt(id.replace('button', ''));
            var the_url = "<?php echo site_url('user/comment/'); ?>";
            var form_data = j('#comment-form'+index).serialize()+'&ajax=1';
        }

        j.ajax({
                url: the_url,
                type: 'POST',
                data: form_data,
                success: function(result) {
                        var response = JSON.parse(result);
                        var the_title = (response['success'])?'Success':'Failure';
                        j.gritter.add({
                            // (string | mandatory) the heading of the notification
                            title: the_title,
                            // class for the title to indicate whether it's an error or not'
                            title_class: (response['success'])?'success':'fail',
                            // (string | mandatory) the text inside the notification
                            text: response['result']['msg']
                        });
                        if(response['success']) {
                            if(id=='submit') {
                                j('#rec-content').prepend(
                                    response['result']['content']
                                );
                                j('#update').val("");
                            }
                            else {
                                j('#comment_div'+index).append(
                                    response['result']['content']
                                );
                                j('#comment'+index).val("");
                            }
                        }
                        j('#'+id).removeAttr('disabled','disabled');
                },
                error: function(data,msg) {
                    j.gritter.add({
                        // (string | mandatory) the heading of the notification
                        title: 'ERROR',
                        // class for the title to indicate whether it's an error or not'
                        title_class: 'fail',
                        // (string | mandatory) the text inside the notification
                        text: msg
                    });
                    j('#'+id).removeAttr('disabled','disabled')
                }
        });

        return false;
    });

    j.extend(j.gritter.options, {
	fade_in_speed: 'medium', // how fast notifications fade in (string or int)
	fade_out_speed: 2000, // how fast the notices fade out
	time: 6000 // hang on the screen for...
    });

    j('.delete').live('click',function() {

        var id = this.id;

        if(id.search(/up/i) == 6) {
            var index = id.substring(id.lastIndexOf('p') + 1 , id.length);
            var isupdate = true;
        }
        else if(id.search(/cm/i) == 6) {
            var index = id.substring(id.lastIndexOf('m') + 1 , id.length);
            var isupdate = false;
        }
        else {

        }

        var content_type = (isupdate)?'Update':'Comment';
        if(confirm('Are you sure you want to delete this '+content_type)) {
            var the_url = "<?php echo site_url('user/delete/'); ?>";
            var form_data = {
                    number: index,
                    ajax: '1'
            };
            j.ajax({
                    url: the_url,
                    type: 'POST',
                    data: form_data,
                    success: function(result) {
                        var response = JSON.parse(result);
                        var the_title = (response['success'])?'Success':'Failure';
                        j.gritter.add({
                            // (string | mandatory) the heading of the notification
                            title: the_title,
                            // class for the title to indicate whether it's an error or not'
                            title_class: (response['success'])?'success':'fail',
                            // (string | mandatory) the text inside the notification
                            text: response['result']['msg']
                        });
                        if(response['success']) {
                            if(isupdate) {
                                j('#update'+index).hide('slow');
                                j('#update'+index).html('');
                            }
                            else if(!isupdate) {
                                j('#comment'+index).hide('slow');
                                j('#comment'+index).html('');
                            }
                        }
                    }
            });
        }
        else {
            return false;
        }

        return false;

    });
});
</script>