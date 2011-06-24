<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class was made by Moses Mutuku
 *
 * This is a library for managing updates. The following methods are in the class
 *
 * 1. View All Updates
 *      This method is for viewing all updates
 *
 * 2. View Selected Updates
 *      This method is for viewing the user's updates
 *
 * 3. View an Update
 *      This method is for viewing a particular update (mainly accessed when a user views notifications or read more comments)
 *      and displays the form for making a comment
 *
 * 4. Create Update
 *      This method is for validating and creating an update or comment
 *
 * 5. Comment on Update
 *      This method is for validating and creating a comment for an update
 *
 * 6. Delete Update
 *      This method is for deleting an update or a comment.
 *
 * 7. Remap
 *      This method changes the flow of the controller. It is first called to ensure the user is logged in and if so, it redirects to the callled method
 */


class update {

    /**
     * CodeIgniter global
     *
     * @var string
     **/
    protected $ci;

    public $data = array();

    private $site_notifications = array();

    // limit to the number of updates to be viewed. This is the limit for browser
    private $up_count = 20;

    // set the prefix for the views. used when the browser is mobile. the views have an m- prefix. for browsers, there is no prefix
    private $view_prefix = '';

    /**
     * __construct
     *
     * @return void
     * @author Mathew
     **/
    public function __construct() {
        $this->ci =& get_instance();
        // Load the updating model for the required db activity for updating and commenting
        $this->ci->load->model('update_model');

        /*change here also! variable to hold the user notifications config */
        $this->ci->load->config('notifications');
        $this->site_notifications = $this->ci->config->item('site_notifications');

        // Load the relation model for checking connection and follow status.
        $this->ci->load->model('relation_model');

        $this->data = $this->ci->redux_auth->get_browser('updates');

        if($this->ci->agent->is_mobile()) {
            $this->up_count = 10;
            $this->view_prefix = 'm-';
        }
    }

    /**
     * Method for displaying all the relevant updates when a user views thier profile page
     */
    public function all($page = 0) {
        // index from which to start the query
        $start = $page * $this->up_count;

        // get all the updates of the logged in user from the model
        $result['updates'] = $this->ci->update_model->all($this->ci->session->userdata['userid'], $this->up_count, $start);

        // set the error message in case the user has no updates
        $result['error_message'] = 'You have not made any update yet. Type your update above.';

        // load the view for creating the form for posting updates and save the result in the $form variable
        $form = $this->ci->load->view('updates/'.$this->view_prefix.'form','',true);

        // load the view for displaying the updates and comments and save the result in $updates variable
        $updates = $this->ci->load->view('updates/'.$this->view_prefix.'view',$result,true);

        // put the form and updates as the page contents
        $this->data['content'] = $form.$updates;

        return $this->data;

    }


    /**
     * Method to create a new comment
     */

    public function comment() {
        $create = false; // variable to indicate whether the creation was successful

        // perform the validation
        if($this->ci->form_validation->run('create_comment') == false) {
            $message = array (
                    'msg' => validation_errors('', '') // if validation fails, set the error message
            );
        }
        else {
            // get the owner of the update
            $contentownerid = $this->ci->update_model->content_owner($this->ci->input->post('number'));

            // if the owner is found
            if($contentownerid) {
                $can_comment = false; // variable to indicate if the user can comment

                // if the content owner is not the logged in user
                if($contentownerid != $this->ci->session->userdata['userid']) {
                    // check if the user can comment
                    $can_comment = $this->ci->relation_model->check_connect($contentownerid);
                }
                else {
                    // the user can comment
                    $can_comment = true;
                }

                // if the user can comment
                if($can_comment) {
                    // pass the data to the model function to create the update
                    $commentid = $this->ci->update_model->comment($this->ci->input->post('number'), $this->ci->input->post('comment'));

                    // depending on success of creation, set the message to be displayed
                    if($commentid) {

                        $this->ci->load->model('notification_model','notifications');
                        $this->ci->notifications->set_notification($this->site_notifications['comment'],$commentid,$contentownerid);

                        $create = true;
                        $message = array (
                                'id' => $commentid,
                                'user' => anchor('user/view/'.$this->ci->session->userdata['userid'],
                                        '<b>'.$this->ci->session->userdata['firstname'].' '.$this->ci->session->userdata['lastname'].'</b> '),
                                'del_url' => anchor('user/update_delete/'.$commentid, 'Delete', array('class' => 'delete', 'id' => 'deletecm'.$commentid)),
                                'msg' => 'Your comment has been posted successfully.'
                        );
                    }
                    else {
                        $message = array (
                                'msg' => 'Failure: The Comment was not posted.'
                        );
                    }
                }
                else { // if user can't comment
                    $create = false;
                    // set the failure message
                    $message = array (
                            'msg' => 'Failure: You are not allowed to comment on this update.'
                    );
                }
            }
            else { // if the owner of the content can't be found
                $create = false;
                // set the failure message
                $message = array (
                        'msg' => 'Failure: The Update was not found.'
                );
            }

        }

        // load the function to set the response with respect to whether the update was posted by ajax or html post
        $this->set_response(intval($this->ci->input->post('ajax')), $create, $message);

    }



    /**
     * Method to create a new update.
     * @param <int> $id indicate whether a user is writing on their wall or someone else's
     */
    public function create($id = 0) {
        $create = false; // variable to indicate whether the creation was successful

        $can_update = false; // variable to check if user can post the update

        // if the user is writing on someone else's wall
        if($id>0 && $id != $this->ci->session->userdata['userid']) {
            // check if the user is connected to the owner of the wall
            $can_update = $this->ci->relation_model->check_connect($id);
        }
        else { // if user is writing on their wall
            $id = 0; // no need to set the user as the owner of the update also
            $can_update = true;
        }

        // if the user can post the update
        if($can_update) {
            // perform the form data validation
            if($this->ci->form_validation->run('create_update') == false) {
                // if validation failed, then get the error to display
                $message = array(
                        'msg' => validation_errors('', '')
                );
            }
            else { // if validation is successful
                // pass the data to the model function to create the update
                $updateid = $this->ci->update_model->create($this->ci->input->post('update'),$id);
                // successfully created
                if($updateid) {
                    if($id != $this->ci->session->userdata['userid']) {
                        $this->ci->load->model('notification_model','notifications');
                        $this->ci->notifications->set_notification($this->site_notifications['update'],$updateid,$id);
                    }

                    $create = true;
                    // set the success message

                    $message = array(
                            'id' => $updateid,
                            'user' => anchor('user/view/'.$this->ci->session->userdata['userid'],
                                        '<b>'.$this->ci->session->userdata['firstname'].' '.$this->ci->session->userdata['lastname'].'</b> '),
                            'del_url' => anchor('user/update_delete/'.$updateid, 'Delete', array('class' => 'delete', 'id' => 'deleteup'.$updateid)),
                            'msg' => 'Your update has been posted successfully.'
                    );
                }
                else {
                    // else set the failure message
                    $message = array(
                            'id' => null,
                            'msg' => 'Failure: The Update was not posted.'
                    );
                }
            }
        }
        else { // if they cannot update
            // set the creation was a failure
            $create = false;
            // set the failure message
            $message = array(
                    'id' => null,
                    'msg' => 'Failure: You are not allowed to comment on this wall'
            );
        }

        // load the function to set the response with respect to whether the update was posted by ajax or html post
        $this->set_response(intval($this->ci->input->post('ajax')), $create, $message);

    }


    public function delete($content_id = 0) {
        $delete = false; // variable to indicate whether the creation was successful

        // if there is content to be deleted
        if($content_id > 0 || $this->ci->input->post('number') > 0) {
            // put the value in the post array
            if($content_id > 0) {
                $_POST['number'] = $content_id;
            }

            // run validation
            if($this->ci->form_validation->run('delete_content') == false) {
                $message = array(
                        'msg' => validation_errors('', '') // if validation fails, then set the error message
                );
            }
            else { // if validation succeded
                // carry out the update. Method returns an array indicating the type of content and success/failure
                $result = $this->ci->update_model->delete($this->ci->input->post('number'));
                // get the content type . If true, it is a comment
                $content_type = ($result['type'])?'Comment':'Update';
                // get if process was successful
                $delete = $result['success'];
                // set the message to be displayed based on success or failure
                if($delete) {
                    $message = array(
                            'msg' => 'The '.$content_type.' was deleted successfully'
                    );
                }
                else {
                    $message = array(
                            'msg' => 'Failure: The '.$content_type.' was not deleted.'
                    );
                }
            }
        }
        else {
            // if no content was selected
            $message = array(
                    'msg' => 'Failure: No content was selected to delete.'
            );
        }

        // load the function to set the response with respect to whether the update was posted by ajax or html post
        $this->set_response(intval($this->ci->input->post('ajax')), $delete, $message);
    }


    /**
     * Method for displaying the selected user's updates
     * @param <int> $userid the userid of the user to display the updates
     */
    public function selected($userid = 0, $page = 0) {
        // check if the user is registered and active
        if($this->ci->update_model->user_status($userid)) {

            // put the userid in the data array
            $data['userid'] = $userid;

            // index from  which to start the query
            $start = $page * $this->up_count;

            // get all the updates for the selected user from the model
            $result['updates'] = $this->ci->update_model->all($userid, $this->up_count, $start);
            $result['profile'] = $this->ci->redux_auth->get_userdata($userid);

            // load the view for creating the form for posting updates and save the result in the $form variable
            $form = $this->ci->load->view('updates/'.$this->view_prefix.'form',$data,true);

            // set the error message in case the user has no updates
            $result['error_message'] = 'There are no updates to view from this user.';

            // load the view for displaying the updates and comments and save the result in updates $variable
            $updates = $this->ci->load->view('updates/'.$this->view_prefix.'view',$result,true);

            // put the form and updates as the page contents
            $this->data['content'] = $form.$updates;

        }
        else {
            // if the user is either not registered or not active
            $this->data['content'] = 'The selected user cannot be found.';
        }

        // load the page template with the content data.
        // return $this->ci->load->view('template',$this->data);
        return $this->data;
    }

    /**
     * Method for displaying the a particular update and it's comments
     * @param <int> $updateid variable to indicate which update to display
     */
    public function view($updateid = 0, $userid = 0)
    {
        // check if the user is registered and active
        if($this->ci->update_model->user_status($userid)) {

            // load the notification model and set any notice about the update as viewed.
            $this->ci->load->model('notification_model','notifications');
            $this->ci->notifications->noted($updateid,$this->site_notifications['update']);

            // Load the update and it's comments from the model
            $result['updates'] = $this->ci->update_model->view($updateid);
            $result['view_update'] = true;

            // set the error message in case the update is not found
            $result['error_message'] = 'The update was not found';

            // load the view for displaying the update and comments and save the result in updates $variable
            $updates = $this->ci->load->view('updates/'.$this->view_prefix.'view',$result,true);

            // put the update as the page contents
            $this->data['content'] = $updates;

        }
        else {
            // if the user is either not registered or not active
            $this->data['content'] = 'The selected update cannot be found.';
        }

        // load the page template with the content data.
        // return $this->ci->load->view('template',$this->data);
        return $this->data;
    }

    /**
     * The method to set the response after an update or comment has been posted
     * @param <bool> $ajax boolean value (1,0) to indicate whether the post was through ajax or html post
     * @param <bool> $success boolean value indicating whether the update or comment was posted successfully
     * @param <array> $message array value containing an id and the success message
     */
    private function set_response($ajax,$success,$message) {
        if($ajax) { // if post was through ajax
            // create the response array indicating success and the message to display
            $response = array(
                    'success' => $success,
                    'result' => $message
            );
            // encode the array and send it back
            echo json_encode($response);
        }
        else { // if through html post
            // check success and wrap message in required class of paragraph tag
            if($success) {
                $response = '<p class="success">'.$message['msg'].'</p>';
            }
            else {
                $response = '<p class="error">'.$message['msg'].'</p>';
            }
            // flash the message
            $this->ci->session->set_flashdata('message', $response);
            
        }
    }

}