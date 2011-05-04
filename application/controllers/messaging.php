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

class Messaging extends CI_Controller {

    // the data array for holding the content to be output
    private $data = array();

    // the receivers of a message. This is only used when sending a message the first time
    private $receivers = array();

    /**
     * constructor to initialize the class.
     */
    public function __construct()
    {
        parent::__construct();
        // Load the updating model for the required db activity for updating and commenting
        $this->load->model('messaging_model','messages');

        // Load the redux auth model for checking connection and follow status.
        $this->load->model('redux_auth_model','redux');
        
        $this->data = $this->redux_auth->get_browser('messages');

    }

    /**
     * Method for displaying all the relevant messages when a user views thier profile page
     */
    public function all()
    {
        // get all the messages of the logged in user from the model
        $result['messages'] = $this->messages->all($this->session->userdata['userid']);
        
        // set the error message in case the user has no messages
        $result['error_message'] = 'You have not sent or received any updates yet';

        $form = '';
        if(!count($result['messages'])) {
            // load the view for creating the form for posting messages and save the result in the $form variable
            $form = $this->load->view('messages/form','',true);
        }

        // load the view for displaying the messages and comments and save the result in messages $variable
        $messages = $this->load->view('messages/view_all',$result,true);

        // put the form and messages as the page contents
        $this->data['content'] = $form.$messages;

        // load the page template with the content data.
        $this->load->view('template',$this->data);

    }

    /**
     * Method for displaying a particular message and it's replies
     * @param <int> $msgid variable to indicate which update to display
     */
    public function view($msgid = 0)
    {
        // Load the update and it's comments from the model
        $result['messages'] = $this->messages->view($msgid, $this->session->userdata['userid']);
        
        // set the error message in case the message is not found
        $result['error_message'] = 'The message was not found';

        // load the view for displaying the message and it's replies and save the result in messages $variable
        $messages = $this->load->view('messages/view',$result,true);

        $form = '';
        if($result['messages']) {
            $data['msgid'] = $msgid;
            // load the view for creating the form for posting messages and save the result in the $form variable
            $form = $this->load->view('messages/form',$data,true);
        }

        // put the update as the page contents
        $this->data['content'] = $messages.$form;

        // load the page template with the content data.
        $this->load->view('template',$this->data);
    }

    /**
     *
     */
    public function compose()
    {
        $form = $this->load->view('messages/form','',true);

        // put the form and messages as the page contents
        $this->data['content'] = $form;

        // load the page template with the content data.
        $this->load->view('template',$this->data);
    }

    /**
     * Method to create a new update.
     */
    public function create()
    {
        $send = false; // variable to indicate whether the message was sent successfully
        $message = ''; // the message to indicate success or failure

        if($this->form_validation->run('send_message') == false) {
            // if validation failed, then get the error to display
            $message = validation_errors('', '');
        }
        else {
            // pass the data to the model function to create the update
            $send = $this->messages->create(
                    $this->receivers,
                    $this->input->post('subject'),
                    $this->input->post('message'),
                    0); // the message id
            
            // successfully created
            if($send) {
                // set the success message
                $message = 'Your Message has been sent successfully.';
            }
            else {
                // else set the failure message
                $message = 'Failure: The Message was not sent.';
            }
        }

        // load the function to set the response with respect to whether the update was posted by ajax or html post
        $this->set_response(intval($this->input->post('ajax')), $send, $message);

    }

    public function validate_receivers($receivers)
    {
        $the_receivers = explode(',',$receivers);
        foreach($the_receivers as $receiver) {
            $receiver = trim($receiver);
            if(!preg_match('/[0-9]/',$receiver) || !$this->redux->check_connect($receiver)) {
                
                $this->form_validation->set_message('validate_receivers','Cannot send your message to some of your receiver(s)');
                return false;
            }
            $this->receivers[] = $receiver;
        }
        $this->receivers[] = $this->session->userdata['userid'];
        return true;
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
            if($this->form_validation->run('reply_message') == false) {
                $message = validation_errors('', ''); // if validation fails, set the error message
            }
            else {
                // get the owner of the message
                $can_reply = $this->messages->can_reply(intval($msgid));

                if($can_reply) {

                    // pass the data to the model function to create the reply
                    $receivers = $this->messages->reply_receivers(intval($msgid));

                    // pass the data to the model function to create the reply
                    $reply = $this->messages->create(
                            $receivers,
                            '', // the subject is blank when replying
                            $this->input->post('message'),
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
        $this->set_response(intval($this->input->post('ajax')), $reply, $message);

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
        if($msgid > 0 || $this->input->post('number') > 0) {
            // put the value in the post array
            if($msgid > 0) {
                $_POST['number'] = $content_id;
            }

            // run validation
            if($this->form_validation->run('delete_content') == false) {
                $message = validation_errors('', ''); // if validation fails, then set the error message
            }
            else { // if validation succeded
                // carry out the delete.
                
                $delete = $this->messages->delete($this->input->post('number'));
                
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
        $this->set_response(intval($this->input->post('ajax')), $delete, $message);
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
            $this->session->set_flashdata('message', $message);
            // load the required function
            $this->all();
        }
    }

    function friends() {
        $friends = $this->messages->friends($this->input->post('q'));
        
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
     * Remap method. Read the CI user manual to understand how it works
     * @param <type> $method
     * @param <type> $params
     * @return <type>
     *
     */
    function _remap($method, $params = array())
    {
        // check if the user is logged in
        if($this->redux_auth->logged_in()) {
            // redirect to the called function
            return call_user_func_array(array($this, $method), $params);
        }
        else {
            // set the error message to be displayed
            $error_message = 'message_'.$method;
            // load the library to indicate the user cannot do what they are trying to
            $this->accessdenied->display_message($error_message);
        }
    }

}

/* End of file update.php */
/* Location: ./application/controllers/update.php */