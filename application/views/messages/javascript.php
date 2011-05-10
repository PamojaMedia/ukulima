<script type="text/javascript">
 var k = jQuery.noConflict();
k(document).ready(function(){

    k('#send').click(function() {

        k('#send').attr('disabled','disabled');

        var the_url = k('#form_submit').attr('action');
        var form_data = {
            receiver: k('#tokenize').val().substring(0, (k('#tokenize').val().length -1) ),
            subject: k('#subject').val(),
            message: k('#message').val(),
            ajax: '1'
        };

        k.ajax({
                url: the_url,
                type: 'POST',
                data: form_data,
                success: function(result) {
                        var response = JSON.parse(result);
                        var the_title = (response['success'])?'Success':'Failure';
                        k.gritter.add({
                            // (string | mandatory) the heading of the notification
                            title: the_title,
                            // class for the title to indicate whether it's an error or not'
                            title_class: (response['success'])?'success':'fail',
                            // (string | mandatory) the text inside the notification
                            text: response['msg']
                        });
                        if(response['success']) {
                           /* k('#message_div'+index).append('<div class="message">'+k('#message').val()+'</div>');
                            k('#message').val("");*/
                        }
                        k('#send').removeAttr('disabled');
                },
                error: function(data,msg) {
                    k.gritter.add({
                        // (string | mandatory) the heading of the notification
                        title: 'ERROR',
                        // class for the title to indicate whether it's an error or not'
                        title_class: 'fail',
                        // (string | mandatory) the text inside the notification
                        text: msg
                    });
                    k('#send').removeAttr('disabled')
                }
        });

        return false;
    });

    k('#reply').click(function() {

        k('#reply').attr('disabled','disabled');

        var the_url = k('#form_submit').attr('action');
        var form_data = {
            message: k('#message').val(),
            ajax: '1'
        };

        k.ajax({
                url: the_url,
                type: 'POST',
                data: form_data,
                success: function(result) {
                        var response = JSON.parse(result);
                        var the_title = (response['success'])?'Success':'Failure';
                        k.gritter.add({
                            // (string | mandatory) the heading of the notification
                            title: the_title,
                            // class for the title to indicate whether it's an error or not'
                            title_class: (response['success'])?'success':'fail',
                            // (string | mandatory) the text inside the notification
                            text: response['msg']
                        });
                        if(response['success']) {
                           k('#view_messages').append('<div class="message_text">'+k('#message').val()+'</div>');
                            k('#message').val("");
                        }
                        k('#reply').removeAttr('disabled');
                },
                error: function(data,msg) {
                    k.gritter.add({
                        // (string | mandatory) the heading of the notification
                        title: 'ERROR',
                        // class for the title to indicate whether it's an error or not'
                        title_class: 'fail',
                        // (string | mandatory) the text inside the notification
                        text: msg
                    });
                    k('#reply').removeAttr('disabled')
                }
        });

        return false;
    });

    k.extend(k.gritter.options, {
	fade_in_speed: 'medium', // how fast notifications fade in (string or int)
	fade_out_speed: 2000, // how fast the notices fade out
	time: 6000 // hang on the screen for...
    });

    k('.delete').click(function() {

        if(confirm('Are you sure you want to delete this message?')) {
            var the_url = "<?php echo site_url('user/delete_message/'); ?>";

            var id = this.id;
            var form_data = {
                    number: id,
                    ajax: '1'
            };
            k.ajax({
                    url: the_url,
                    type: 'POST',
                    data: form_data,
                    success: function(result) {
                        var response = JSON.parse(result);
                        var the_title = (response['success'])?'Success':'Failure';
                        k.gritter.add({
                            // (string | mandatory) the heading of the notification
                            title: the_title,
                            // class for the title to indicate whether it's an error or not'
                            title_class: (response['success'])?'success':'fail',
                            // (string | mandatory) the text inside the notification
                            text: response['msg']
                        });
                        if(response['success']) {
                            k('#message_text'+id).hide('slow');
                            k('#message_text'+id).html('');
                        }
                    }
            });
        }
        else {
            return false;
        }

        return false;

    });

    k("#tokenize").tokenInput("<?php echo $url ?>", {
        classes: {
            tokenList: "token-input-list",
            token: "token-input-token",
            tokenDelete: "token-input-delete-token",
            selectedToken: "token-input-selected-token",
            highlightedToken: "token-input-highlighted-token",
            dropdown: "token-input-dropdown",
            dropdownItem: "token-input-dropdown-item",
            dropdownItem2: "token-input-dropdown-item2",
            selectedDropdownItem: "token-input-selected-dropdown-item",
            inputToken: "token-input-input-token"
        }
    });
});
</script>