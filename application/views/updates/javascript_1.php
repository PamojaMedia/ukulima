<script type="text/javascript">
$(document).ready(function(){

    $('.button').click(function() {

        var id = this.id;
        $('#'+id).attr('disabled','disabled');

        if(id=='submit') {
            var the_url = $('#form_submit').attr('action');
            var form_data = {
                    update: $('#update').val(),
                    ajax: '1'
            };
        }

        else {
            var index = id.substring(id.lastIndexOf('n') + 1 , id.length);
            var the_url = "<?php echo site_url('update/comment/'); ?>";
            var form_data = {
                    comment: $('#comment'+index).val(),
                    number: index,
                    ajax: '1'
            };
        }

        $.ajax({
                url: the_url,
                type: 'POST',
                data: form_data,
                success: function(result) {
                        var response = JSON.parse(result);
                        var the_title = (response['success'])?'Success':'Failure';
                        $.gritter.add({
                            // (string | mandatory) the heading of the notification
                            title: the_title,
                            // class for the title to indicate whether it's an error or not'
                            title_class: (response['success'])?'success':'fail',
                            // (string | mandatory) the text inside the notification
                            text: response['msg']
                        });
                        if(response['success']) {
                            if(id=='submit') {
                                $('#rec_updates').prepend('<div class="update">'+$('#update').val()+'</div>');
                                $('#update').val("");
                            }
                            else {
                                $('#comment_div'+index).append('<div class="comment">'+$('#comment'+index).val()+'</div>');
                                $('#comment'+index).val("");
                            }
                        }
                        $('#'+id).removeAttr('disabled','disabled');
                },
                error: function(data,msg) {
                    $.gritter.add({
                        // (string | mandatory) the heading of the notification
                        title: 'ERROR',
                        // class for the title to indicate whether it's an error or not'
                        title_class: 'fail',
                        // (string | mandatory) the text inside the notification
                        text: msg
                    });
                    $('#'+id).removeAttr('disabled','disabled')
                }
        });

        return false;
    });

    $.extend($.gritter.options, {
	fade_in_speed: 'medium', // how fast notifications fade in (string or int)
	fade_out_speed: 2000, // how fast the notices fade out
	time: 6000 // hang on the screen for...
    });

    $('.delete').click(function() {

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
            var the_url = "<?php echo site_url('update/delete/'); ?>";
            var form_data = {
                    number: index,
                    ajax: '1'
            };
            $.ajax({
                    url: the_url,
                    type: 'POST',
                    data: form_data,
                    success: function(result) {
                        var response = JSON.parse(result);
                        var the_title = (response['success'])?'Success':'Failure';
                        $.gritter.add({
                            // (string | mandatory) the heading of the notification
                            title: the_title,
                            // class for the title to indicate whether it's an error or not'
                            title_class: (response['success'])?'success':'fail',
                            // (string | mandatory) the text inside the notification
                            text: response['msg']
                        });
                        if(response['success']) {
                            if(isupdate) {
                                $('#update'+index).hide('slow');
                                $('#update'+index).html('');
                            }
                            else if(!isupdate) {
                                $('#comment'+index).hide('slow');
                                $('#comment'+index).html('');
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