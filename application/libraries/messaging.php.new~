<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * This class was made by Moses Mutuku
 *
 * This is a controller class for managing messages. The following methods are in the class
 *
 * 1. View All Messages
 *      This method is for viewing all messages
 *
 * 2. View a Message
 *      This method is for viewing a particular message together with all it's replies
 *
 * 3. Compose a Message
 *      This method displays the form for composing a message
 *
 * 4. Create a Message
 *      This method is for validating and creating a message
 *
 * 5. Reply to a Message
 *      This method is for validating and creating a reply to a message
 *
 * 6. Delete Message
 *      This method is for deleting a message and it deletes only for the specific user
 *
 * 7. Remap
 *      This method changes the flow of the controller. It is first called to ensure the user is logged in and if so, it redirects to the callled method
 */

class messaging
{

    /**
	 * CodeIgniter global
	 *
	 * @var string
	 **/
	protected $ci;




        public $data = array();


        public  $receivers = array();
	/**
	 * __construct
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function __construct()
	{
	$this->ci =& get_instance();


                 // Load the updating model for the required db activity for updating and commenting
        $this->ci->load->model('messaging_model');

        // Load the relation model for checking connection and follow status.
        $this->ci->load->model('relation_model');
        $this->data = $this->ci->redux_auth->get_browser('messages');


	}
        
    /**
     * Method for displaying all the relevant messages when a user views thier profile page
     */
    public function all()
    {
        // get all the messages of the logged in user from the model
        $result['messages'] = $this->ci->messaging_model->all($this->ci->session->userdata['userid']);
        
        // set the error message in case the user has no messages
        $result['error_message'] = 'You have not sent or received any updates yet';

        $form = '';
        if(!count($result['messages'])) {
            // load the view for creating the form for posting messages and save the result in the $form variable
            $form = $this->ci->load->view('messages/form','',true);
        }

        // load the view for displaying the messages and comments and save the result in messages $variable
        $messages = $this->ci->load->view('messages/view_all',$result,true);

        // put the form and messages as the page contents
        $this->data['content'] = $form.$messages;

        return $this->data;
        // load the page template with the content data.
        ///$this->ci->load->view('template',$this->data);

    }

    /**
     * Method for displaying a particular message and it's replies
     * @param <int> $msgid variable to indicate which update to display
     */
    public function view($msgid = 0)
    {
        // Load the update and it's comments from the model
        $result['messages'] = $this->ci->messaging_model->view($msgid, $this->ci->session->userdata['userid']);

        // set the error message in case the message is not found
        $result['error_message'] = 'The message was not found';

        // load the view for displaying the message and it's replies and save the result in messages $variable
        $messages = $this->ci->load->view('messages/view',$result,true);

        $form = '';
        if($result['messages']) {
            $data['msgid'] = $msgid;
            // load the view for creating the form for posting messages and save the result in the $form variable
            $form = $this->ci->load->view('messages/form',$data,true);
        }

        // put the update as the page contents
        $this->data['content'] = $messages.$form;

        // load the page template with the content data.
       // $this->load->view('template',$this->data);

        return $this->data;
    }

     /**
     *
     */
    public function compose()
    {
        $form = $this->ci->load->view('messages/form','',true);

        // put the form and messages as the page contents
        $this->data['content'] = $form;

        // load the page template with the content data.
       // $this->load->view('template',$this->data);
        return $this->data;
    }

       /**
     * Method to create a new update.
     */
    public function create()
    {
        $send = false; // variable to indicate whether the message was sent successfully
        $message = ''; // the message to indicate success or failure

        if($this->ci->form_validation->run('send_message') == false) {
            // if validation failed, then get the error to display
            $message = validation_errors('', '');
        }
        else {
            // pass the data to the model function to create the update
            $send = $this->ci->messaging_model->create(
                    $this->receivers,
                    $this->ci->input->post('subject'),
                    $this->ci->input->post('message'),
                    0); // the message id
            // successfully created
            if($send) {
                // set the success message
                $message = 'Your Message has been sent successfully.';
            }
            else {

             $comma = implode(",", $this->receivers);
                // else set the failure message
                $message = $comma.'Failure: The Message was not sent.';
            }
        }

        // load the function to set the response with respect to whether the update was posted by ajax or html post
        $this->set_response(intval($this->ci->input->post('ajax')), $send, $message);

    }


    /**
     * Method to delete an update or comment
     * @param <int> $content_id the update/comment to delete
     */

    public function delete($msgid = 0)
    {
        $delete = false; // variable to indicate whether the creation was successful
        $message = ''; // the message to indicate success or failure

        // if there is content to be deleted
        if($msgid > 0 || $this->ci->input->post('number') > 0) {
            // put the value in the post array
            if($msgid > 0) {
                $_POST['number'] = $content_id;
            }

            // run validation
            if($this->ci->form_validation->run('delete_content') == false) {
                $message = validation_errors('', ''); // if validation fails, then set the error message
            }
            else { // if validation succeded
                // carry out the delete.

                $delete = $this->ci->messaging_model->delete($this->ci->input->post('number'));

                // set the error message to be displayed based on success
                if($delete) {
                    $message = 'The message was deleted successfully';
                }
                else {
                    $message = 'Failure: The message was not deleted.';
                }
            }
        }
        else {
            // if no content was selected
            $message = 'Failure: No content was selected to delete.';
        }

        // load the function to set the response with respect to whether the update was posted by ajax or html post
        $this->set_response(intval($this->ci->input->post('ajax')), $delete, $message);
    }


    function friends() {
        $friends = $this->ci->messaging_model->friends($this->ci->input->post('q'));

        foreach($friends as $friend)
        {
            $arr[] = array (
                'id' => $friend['userid'],
                'name' => $friend['firstname'].' '.$friend['lastname']
                );
        }

        echo json_encode($arr);
    }


    /**
     * Method to create a new comment
     */

    public function reply($msgid = 0)
    {
        $reply = false; // variable to indicate whether the creation was successful
        $message = ''; // the message to indicate success or failure

        if($msgid) {

            // perform the validation
            if($this->ci->form_validation->run('reply_message') == false) {
                $message = validation_errors('', ''); // if validation fails, set the error message
            }
            else {
                // get the owner of the message
                $can_reply = $this->ci->messaging_model->can_reply(intval($msgid));

                if($can_reply) {

                    // pass the data to the model function to create the reply
                    $receivers = $this->ci->messaging_model->reply_receivers(intval($msgid));

                    // pass the data to the model function to create the reply
                    $reply = $this->ci->messaging_model->create(
                            $receivers,
                            '', // the subject is blank when replying
                            $this->ci->input->post('message'),
                            intval($msgid)); // the message id

                    // depending on success of replying, set the message to be displayed
                    if($reply) {
                        $message = 'Your reply has been sent successfully.';
                    }
                    else {
                        $message = 'Failure: The reply was not sent.';
                    }
                }
                else { // if user can't reply
                    $reply = false;
                    // set the failure message
                    $message = 'Failure: You cannot reply to this message.';
                }
            }
        }
        else {
            $message = 'Failure: The message was not found.';
        }

        // load the function to set the response with respect to whether the reply was posted by ajax or html post
        $this->set_response(intval($this->ci->input->post('ajax')), $reply, $message);

    }

    /**
     * The method to set the response after an update or comment has been posted
     * @param <bool> $ajax boolean value (1,0) to indicate whether the post was through ajax or html post
     * @param <bool> $success boolean value indicating whether the update or comment was posted successfully
     * @param <string> $message string value containing the response message
     */
    private function set_response($ajax,$success,$message) {
        if($ajax) { // if post was through ajax
            // create the response array indicating success and the message to display
            $response = array(
                'success' => $success,
                'msg' => $message
            );
            // encode the array and send it back
            echo json_encode($response);
        }
        else { // if through html post
            // check success and wrap message in required class of paragraph tag
            if($success) {
                $response = '<p class="success">'.$message.'</p>';
            }
            else {
                $response = '<p class="error">'.$message.'</p>';
            }
            // flash the message
            $this->ci->session->set_flashdata('message', $message);
            // load the required function
            //$this->all();

            redirect('user/profile');
        }
    }







}
