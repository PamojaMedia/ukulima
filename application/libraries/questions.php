<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class was made by Virginia Waiti and Moses Mutuku
 *
 * This is a library for managing updates. The following methods are in the class
 *
 * 1. View All Questions
 *      This method is for viewing all questions
 *
 * 2. View Selected Questions
 *      This method is for viewing the user's questions
 *
 * 3. View a Question
 *      This method is for viewing a particular question (mainly accessed when a user views notifications or read more answers)
 *      and displays the form for making a comment
 *
 * 4. Create Question
 *      This method is for validating and creating a question or answer
 *
 * 5. Answer Question
 *      This method is for validating and creating a question for a question
 *
 * 6. Delete Question
 *      This method is for deleting a question or a answer.
 *
 * 7. Remap
 *      This method changes the flow of the controller. It is first called to ensure the user is logged in and if so, it redirects to the callled method
 */


class questions {

    /**
     * CodeIgniter global
     *
     * @var string
     **/
    protected $ci;

    public $data = array();

    private $site_notifications = array();

    // limit to the number of questions to be viewed. This is the limit for browser
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
        // Load the question model for the required db activity for questioning and answering
        $this->ci->load->model('question_model');

        /*change here also! variable to hold the user notifications config */
        $this->ci->load->config('notifications');
        $this->site_notifications = $this->ci->config->item('site_notifications');

        // Load the relation model for checking connection and follow status.
        $this->ci->load->model('relation_model');

        if($this->ci->agent->is_mobile()) {
            $this->up_count = 10;
            $this->view_prefix = 'm-';
        }
    }

    /**
     * Method for displaying all the relevant questions when a user views thier profile page
     */
    public function all($page = 0) {
        // index from which to start the query
        $start = $page * $this->up_count;

        // get all the questions of the logged in user from the model
        $result['questions'] = $this->ci->question_model->all($this->ci->session->userdata['userid'], $this->up_count, $start);

        // set the error message in case the user has no questions
        if($page==0) {
            $result['error_message'] = 'You have not made any questions yet. Type your question above.';
        }
        else {
            $result['error_message'] = 'There are no more questions to view.';
        }
        $result['page'] = $page + 1;

        // load the view for creating the form for posting questions and save the result in the $form variable
        $form = $this->ci->load->view('questions/'.$this->view_prefix.'formqueriz','',true);

        // load the view for displaying the questions and answers and save the result in $questions variable
        $questions = $this->ci->load->view('questions/'.$this->view_prefix.'view2',$result,true);

        // put the form and questions as the page contents
        $this->data['content'] = $form.$questions;

        return $this->data;

    }


    /**
     * Method to create a new answer
     */

    public function answer() {
        $create = false; // variable to indicate whether the creation was successful

        // perform the validation
        if($this->ci->form_validation->run('create_answer') == false) {
            $message = array (
                    'msg' => validation_errors('', '') // if validation fails, set the error message
            );
        }
        else {
            // get the owner of the question
            $contentownerid = $this->ci->question_model->content_owner($this->ci->input->post('number'));

            // if the owner is found
            if($contentownerid) {
                
                // pass the data to the model function to create the answer
                $answerid = $this->ci->question_model->answer($this->ci->input->post('number'), $this->ci->input->post('answer'));

                // depending on success of creation, set the message to be displayed
                if($answerid) {

                    if($contentownerid != $this->ci->session->userdata['userid']) {
                        $this->ci->load->model('notification_model','notifications');
                        $this->ci->notifications->set_notification($this->site_notifications['answer'],$answerid,$contentownerid);
                    }

                    $create = true;

                    $data['answer']['firstname'] = $this->ci->session->userdata['firstname'];
                    $data['answer']['lastname'] = $this->ci->session->userdata['lastname'];
                    $data['answer']['userid'] = $this->ci->session->userdata['userid'];
                    $data['answer']['ID'] = $answerid;
                    $data['answer']['update'] = auto_link($this->ci->input->post('answer'));

                    $content = $this->ci->load->view('questions/create-answer',$data,true);

                    $message = array(
                        'content' => $content,
                        'msg' => 'Your Answer has been posted successfully.'
                    );

                }
                else {
                    $message = array (
                            'msg' => 'Failure: The Answer was not posted.'
                    );
                }
                
            }
            else { // if the owner of the content can't be found
                $create = false;
                // set the failure message
                $message = array (
                        'msg' => 'Failure: The Question was not found.'
                );
            }

        }

        // load the function to set the response with respect to whether the update was posted by ajax or html post
        $this->set_response(intval($this->ci->input->post('ajax')), $create, $message);

    }



    /**
     * Method to create a new question.
     * @param <int> $id indicate whether a user is writing on their wall or someone else's
     */
    public function create($id = 0) {
        $create = false; // variable to indicate whether the creation was successful

        $can_question = true; // variable to check if user can post the question

        
      
        // if the user can post the question
        if($can_question) {
            // perform the form data validation
            if($this->ci->form_validation->run('create_question') == false) {
                // if validation failed, then get the error to display
                $message = array(
                        'msg' => validation_errors('', '')
                );
            }
            else { // if validation is successful
                // pass the data to the model function to create the question
                $questionid = $this->ci->question_model->create($this->ci->input->post('question'),$id);
                // successfully created
                if($questionid) {
                    if($id != $this->ci->session->userdata['userid']) {
                        $this->ci->load->model('notification_model','notifications');
                        $this->ci->notifications->set_notification($this->site_notifications['question'],$questionid,$id);
                    }

                    $create = true;
                    // set the success message

                    $data['question']['firstname'] = $this->ci->session->userdata['firstname'];
                    $data['question']['lastname'] = $this->ci->session->userdata['lastname'];
                    $data['question']['userid'] = $this->ci->session->userdata['userid'];
                    $data['question']['ID'] = $questionid;
                    $data['question']['update'] = auto_link($this->ci->input->post('question'));

                    $content = $this->ci->load->view('questions/create-question',$data,true);

                    $message = array(
                        'content' => $content,
                        'msg' => 'Your Question has been posted successfully.'
                    );
                }
                else {
                    // else set the failure message
                    $message = array(
                            'id' => null,
                            'msg' => 'Failure: The Question was not posted.'
                    );
                }
            }
        }
       

        // load the function to set the response with respect to whether the question was posted by ajax or html post
        $this->set_response(intval($this->ci->input->post('ajax')), $create, $message);

    }


    public function delete_question($content_id = 0) {
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
                // carry out the question. Method returns an array indicating the type of content and success/failure
                $result = $this->ci->question_model->delete_question($this->ci->input->post('number'));
                // get the content type . If true, it is an answer
                $content_type = ($result['type'])?'Answer':'Question';
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

        // load the function to set the response with respect to whether the question was posted by ajax or html post
        $this->set_response(intval($this->ci->input->post('ajax')), $delete, $message);
    }


    /**
     * Method for displaying the selected user's questions
     * @param <int> $userid the userid of the user to display the updates
     */
    public function selected($userid = 0, $page = 0) {
        // check if the user is registered and active
        if($this->ci->question_model->user_status($userid)) {

            // load the notification model and set any notice about the question as viewed.
            $this->ci->load->model('notification_model','notifications');
            $this->ci->notifications->noted($userid,$this->site_notifications['follow']);
            
            // put the userid in the data array
            $data['userid'] = $userid;

            // index from  which to start the query
            $start = $page * $this->up_count;

            // get all the question for the selected user from the model
            $result['questions'] = $this->ci->question_model->all($userid, $this->up_count, $start);
            $result['profile'] = $this->ci->redux_auth->get_userdata($userid);
            $result['page'] = $page + 1;

            // load the view for creating the form for posting questions and save the result in the $form variable
            $form = $this->ci->load->view2('questions/'.$this->view_prefix.'formqueriz',$data,true);

            // set the error message in case the user has no updates
            if($page==0) {
                $result['error_message'] = 'There are no questions to view from this user.';
            }
            else {
                $result['error_message'] = 'There are no more questions from this user.';
            }
            

            // load the view for displaying the questions and answers and save the result in questions $variable
            $questions = $this->ci->load->view2('questions/'.$this->view_prefix.'view2',$result,true);

            // put the form and questions as the page contents
            $this->data['content'] = $form.$questions;

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
     * Method for displaying a particular question and it's answers
     * @param <int> $questionid variable to indicate which question to display
     */
    public function view2($questionid = 0, $userid = 0)
    {
        // check if the user is registered and active
        if($this->ci->question_model->user_status($userid)) {

            // load the notification model and set any notice about the question as viewed.
            $this->ci->load->model('notification_model','notifications');
            $this->ci->notifications->noted($questionid,$this->site_notifications['question']);
            
            // Load the question and it's answers from the model
            $result['questions'] = $this->ci->question_model->view2($questionid);
            $result['view_question'] = true;

            // set the error message in case the answer is not found
            $result['error_message'] = 'The question was not found';

            // load the view for displaying the question and answers and save the result in questions $variable
            $questions = $this->ci->load->view('questions/'.$this->view_prefix.'view2',$result,true);

            // put the question as the page contents
            $this->data['content'] = $questions;

        }
        else {
            // if the user is either not registered or not active
            $this->data['content'] = 'The selected question cannot be found.';
        }

        // load the page template with the content data.
        // return $this->ci->load->view('template',$this->data);
        return $this->data;
    }

    /**
     * The method to set the response after a question or answer has been posted
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