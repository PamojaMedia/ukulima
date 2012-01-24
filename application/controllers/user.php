<?php

/**
 * This area will contain all the areas that a logged in user will need starting with profile
 * updates, comments, messages, follow , unfollow, connect, disconnect, notification and settings
 *
 * Enough talk, the good stuff is below
 */
class user extends CI_Controller {

    /**
     * constructor
     */
    private $tpl;
    public $data = array();
    public $receivers = array();
    private $site_notifications = array();
    // indicate whether the browser is a mobile browser or not
    private $is_mobile = false;
    // set the prefix for the views. used when the browser is mobile. the views have an m- prefix. for browsers, there is no prefix
    private $view_prefix = '';

    function __construct() {
        parent::__construct();
        $this->load->model('redux_auth_model');
        $this->load->model('relation_model');

        /* change here */
        $this->load->config('notifications');
        $this->site_notifications = $this->config->item('site_notifications');

        $this->tpl = $this->redux_auth->template_choose();

        if ($this->agent->is_mobile()) {
            $this->is_mobile = true;
            $this->view_prefix = 'm-';
        }
    }

    /**
     * index
     *
     * @return void
     * @author Mathew
     * */
    function index() {
        $this->home();
    }

    function home($page = 0) {
        $this->data = $this->redux_auth->get_browser();
        $this->data['content'] = $this->load->view('user/' . $this->view_prefix . 'home', '', true);
        $this->load->view($this->tpl, $this->data);
    }

    function updates($page = 0) {
        $this->load->helper('date');
        $update = $this->input->post('update');
        if (!empty($update)) {
            $this->create_update();
        }

        $data['update_user'] = $this->update->all($page);
        $data += $this->common_functions();

        $this->data = $this->redux_auth->get_browser('updates');

        $this->data['content'] = $this->load->view('user/' . $this->view_prefix . 'content', $data, true);

        $this->load->view($this->tpl, $this->data);
    }

    function questions($page = 0) {

        $question = $this->input->post('question');
        if (!empty($question)) {
            $this->create_question();
        }

        $data['question_user'] = $this->questions->all($page);
        $data += $this->common_functions();

        $this->data = $this->redux_auth->get_browser('questions');

        $this->data['content'] = $this->load->view('user/' . $this->view_prefix . 'content', $data, true);

        $this->load->view($this->tpl, $this->data);
    }

    function profile($userid = 0) {

        if ($userid == 0) {
            $userid = $this->session->userdata['userid'];
        }

        $data['network'] = $this->profile->network($userid);

        $this->data['content'] = $this->load->view('profile/' . $this->view_prefix . 'content', $data, true);

        $this->load->view($this->tpl, $this->data);
    }
    
    function suggest(){
        $data['suggestconnects'] = $this->relation->suggest_connect_long();
        $data['suggesttracks'] = $this->relation->suggest_track_long();
        $this->data['content'] = $this->load->view('profile/' . $this->view_prefix . 'suggest', $data, true);
        $this->load->view($this->tpl, $this->data);
    }
    function coming_soon($choice = ''){
        if($choice == 1){
            $component = "My Farm";
        }elseif($choice == 2){
            $component = "Market Place";
        }elseif($choice == 3){
            $component = "Knowledge Area";
        }elseif($choice == 4){
            $component = "App Store";
        }elseif($choice == 5){
            $component = "Advertisements";
        }else{
            redirect('user/home');
        }
        
        $data['component'] = $component;
        
        $this->data['content'] = $this->load->view('auth_view/' . $this->view_prefix . 'coming_soon', $data, true);

        $this->load->view($this->tpl, $this->data);
    }

    function view_update($updateid = 0) {

        $num = $this->input->post('number');
        if (!empty($num)) {
            $this->comment();
        }

        $data['update_user'] = $this->update->view($updateid, $this->session->userdata['userid']);
        $data += $this->common_functions();

        $this->data['content'] = $this->load->view('user/' . $this->view_prefix . 'content', $data, true);
        $this->load->view($this->tpl, $this->data);
    }

    /**
     * View a selected user's profile
     * @param <int> the selected user's id
     */
    function view($userid = 0, $page = 0) {

        $update = $this->input->post('update');
        if (!empty($update)) {
            $this->create_update($userid);
        }

        $data['update_user'] = $this->update->selected($userid, $page);
        $data += $this->common_functions($userid);

        $this->data['content'] = $this->load->view('user/' . $this->view_prefix . 'content', $data, true);
        $this->load->view($this->tpl, $this->data);
    }

    function create_update($id=0) {

        if ($id === 0) {
            $this->update->create();
        } else {
            $this->update->create($id);
        }
    }

    /**
     *  Comment on an update
     *
     */
    function comment() {
        $this->update->comment();
    }

    /**
     * Deleting an update
     */
    function delete($content_id=0) {
        if ($content_id === 0) {
            $this->update->delete();
        } else {
            $this->update->delete($content_id);
        }

        if ($this->is_mobile) {
            $refer = $this->agent->referrer();
            if (isset($this->session->userdata['referrer']) && preg_match('/delete/', $refer)) {
                $refer = $this->session->userdata['referrer'];
            }
            $this->session->set_userdata('referrer', $refer);
            if (preg_match('/view_update/', $refer)) {
                $updateid = substr($refer, strripos($refer, '/') + 1, -5);
                $this->view_update($updateid);
            } elseif (preg_match('/home/', $refer)) {
                $this->home();
            } elseif (preg_match('/view/', $refer)) {
                // extract the userid from the referral url
                $userid = substr($refer, strripos($refer, '/') + 1, -5);
                $this->view($userid);
            }
        }
    }

    function view_question($questionid = 0) {

        $num = $this->input->post('number');
        if (!empty($num)) {
            $this->answer();
        }

        $data['question_user'] = $this->questions->view2($questionid, $this->session->userdata['userid']);
        $data += $this->common_functions();

        $this->data['content'] = $this->load->view('user/' . $this->view_prefix . 'content', $data, true);
        $this->load->view($this->tpl, $this->data);
    }

    function create_question($id=0) {

        if ($id === 0) {
            $this->questions->create();
        } else {
            $this->questions->create($id);
        }
    }

    /**
     *  Answer a question
     *
     */
    function answer() {

        $this->questions->answer();
    }

    /**
     * Deleting a question
     */
    function delete_question($content_id=0) {
        if ($content_id === 0) {
            $this->questions->delete_question();
        } else {
            $this->questions->delete_question($content_id);
        }

        if ($this->is_mobile) {
            $this->questions();
        }
    }
    
    /**
     * Deleting an answer
     */
    function delete_answer($content_id=0) {
        if ($content_id === 0) {
            $this->questions->delete_question();
        } else {
            $this->questions->delete_question($content_id);
        }

        if ($this->is_mobile) {
            $refer = $this->agent->referrer();
            if (preg_match('/view_question/', $refer)) {
                $questionid = substr($refer, strripos($refer, '/') + 1, -5);
                $this->view_question($questionid);
            } elseif (preg_match('/questions/', $refer)) {
                $this->questions();
            }
        }
    }

    /**
     * Retrieves all the messages from a user and a form to create mesages
     */
    function messages($page = 0) {

        $msg = $this->input->post('message');
        if (!empty($msg)) {
            $this->create_message();
        }

        $data['message_user'] = $this->messaging->all($page);
        $data += $this->common_functions();

        $this->data['content'] = $this->load->view('user/' . $this->view_prefix . 'content', $data, true);
        $this->load->view($this->tpl, $this->data);
    }

    /**
     * Method to view a particular message and its replies
     *
     * @param <int> message id tp pass to the library function
     */
    function view_message($msgid = 0) {

        $msg = $this->input->post('message');
        if (!empty($msg)) {
            $this->reply($msgid);
        }

        $data['message_view'] = $this->messaging->view($msgid);
        $data += $this->common_functions();

        $this->data = $this->redux_auth->get_browser('messages');

        $this->data['content'] = $this->load->view('user/' . $this->view_prefix . 'content', $data, true);
        $this->load->view($this->tpl, $this->data);
    }

    /**
     * Function to place the compose form at any place of the site, just the compose
     * form
     *
     */
    function compose_message() {

        $data['message_compose'] = $this->messaging->compose();
        $data += $this->common_functions();

        $this->data = $this->redux_auth->get_browser('messages');

        $this->data['content'] = $this->load->view('user/' . $this->view_prefix . 'content', $data, true);
        $this->load->view($this->tpl, $this->data);
    }

    /**
     * Function to delete user messages
     *
     */
    function delete_message($msgid = 0) {
        if ($msgid === 0) {
            $this->messaging->delete();
        } else {
            $this->messaging->delete($msgid);
        }
        if ($this->is_mobile) {
            $refer = $this->agent->referrer();
            if (isset($this->session->userdata['referrer']) && preg_match('/delete_message/', $refer)) {
                $refer = $this->session->userdata['referrer'];
            }
            $this->session->set_userdata('referrer', $refer);
            if (preg_match('/messages/', $refer)) {
                $this->messages();
                echo 'Messages';
            } elseif (preg_match('/view_message/', $refer)) {
                // extract the userid from the referral url
                $parentid = substr($refer, strripos($refer, '/') + 1, -5);
                $this->view_message($parentid);
                echo 'Viewing';
            }
        }
    }

    function create_message() {
        $this->messaging->create();
    }

    /**
     * When composing message this function lists the users friends, FACEBOOK STYLE!!!!
     *
     */
    function message_receiver($ajax = 0) {
        $receivers = $this->input->post('receivers');
        if ($receivers) {
            $this->data['content'] = $this->messaging->add_receivers();
        } else {
            $this->data['content'] = $this->messaging->friends($ajax);
        }
        if (!$ajax) {
            $this->load->view($this->tpl, $this->data);
        }
    }

    function remove_receiver($recid) {
        if ($recid) {
            $this->messaging->remove_receiver($recid);
        }
        $this->message_receiver(0);
    }

    function reply($msgid) {
        $this->messaging->reply($msgid);
    }

    function track_user($id, $ajax = false) {
        $return = $this->relation->track($id,$ajax);
        if ($this->is_mobile) {
            $refer = $this->agent->referrer();
            if (preg_match('/network_suggestions/', $refer)) {
                $this->network_suggestions();
            } elseif (preg_match('/home/', $refer)) {
                $this->home();
            } elseif (preg_match('/messages/', $refer)) {
                $this->messages();
            } elseif (preg_match('/connect_user/', $refer)) {
                $this->network_suggestions();
            } elseif (preg_match('/track_user/', $refer)) {
                $this->network_suggestions();
            }
        } else {
            $this->updates();
        }
    }

    function connect_user($id, $ajax = false) {
        $return = $this->relation->connect($id,$ajax);
        if ($this->is_mobile) {
            $refer = $this->agent->referrer();
            if (preg_match('/network_suggestions/', $refer)) {
                $this->network_suggestions();
            } elseif (preg_match('/home/', $refer)) {
                $this->home();
            } elseif (preg_match('/messages/', $refer)) {
                $this->messages();
            } elseif (preg_match('/connect_user/', $refer)) {
                $this->network_suggestions();
            } elseif (preg_match('/track_user/', $refer)) {
                $this->network_suggestions();
            }
        } else {
            $this->updates();
        }
    }

    function untrack_user($id, $ajax = false) {
        $this->relation->untrack($id,$ajax);
        if ($this->is_mobile) {
            $refer = $this->agent->referrer();
            if (preg_match('/track/', $refer)) {
                $this->track();
            }
        } else {
            $this->track();
        }
    }

    function disconnect_user($id, $ajax = false) {
        $this->relation->disconnect($id,$ajax);
        if ($this->is_mobile) {
            $refer = $this->agent->referrer();
            if (preg_match('/connections/', $refer)) {
                $this->connections();
            }
        } else {
            $this->connections();
        }
    }

    /**
     * This section is for functions that call the profile library
     */
    function track($userid = 0, $page = 0) {

        if ($userid == 0) {
            $userid = $this->session->userdata['userid'];
        }

        $data['tracks'] = $this->profile->tracks($userid, $page);
        $data += $this->common_functions($userid);

        $this->data['content'] = $this->load->view('profile/' . $this->view_prefix . 'content', $data, true);
        $this->load->view($this->tpl, $this->data);
    }

    function trackback($userid = 0, $page = 0) {

        if ($userid == 0) {
            $userid = $this->session->userdata['userid'];
        }

        $data['trackback'] = $this->profile->trackback($userid, $page);
        $data += $this->common_functions($userid);

        $this->data['content'] = $this->load->view('profile/' . $this->view_prefix . 'content', $data, true);
        $this->load->view($this->tpl, $this->data);
    }

    function connections($userid = 0, $page = 0) {

        if ($userid == 0) {
            $userid = $this->session->userdata['userid'];
        }

        $data['connections'] = $this->profile->connections($userid, $page);
        $data += $this->common_functions($userid);

        $this->data['content'] = $this->load->view('profile/' . $this->view_prefix . 'content', $data, true);
        $this->load->view($this->tpl, $this->data);
    }

    function network_search($network = 'search', $userid = 0, $page = 0) {

        if ($network == 'tracks' || $network == 'trackback' || $network == 'connections' || $network == 'search') {
            if ($userid == 0) {
                $userid = $this->session->userdata['userid'];
            }

            $data[$network] = $this->profile->network_search($network, $userid, $page);
            
            $data += $this->common_functions($userid);

            $this->data['content'] = $this->load->view('profile/' . $this->view_prefix . 'content', $data, true);
            $this->load->view($this->tpl, $this->data);
        } else {
            $this->data['content'] = 'The search could not be performed!';
            $this->load->view($this->tpl, $this->data);
        }
    }

    function network_suggestions($page = 0) {

        $data['suggestions'] = $this->profile->network_suggest($page);
        $data += $this->common_functions();

        $this->data['content'] = $this->load->view('profile/' . $this->view_prefix . 'content', $data, true);
        $this->load->view($this->tpl, $this->data);
    }

    /* ------------------------------------------------------------------ */

    /**
     * Function that calls the search library
     */
    public function search() {
        
    }

    /**
     * This method shows the CKeditor for users to create user-pages/ Knowledge Content
     *
     */
    public function knowledge() {
        // load
        $this->load->library('knowledge');


        $data['user_pane'] = $this->knowledge->editor();
        $data += $this->common_functions();
        $this->data['content'] = $this->load->view('user/' . $this->view_prefix . 'content', $data, true);
        $this->load->view($this->tpl, $this->data);
    }

    /* ------------------------------------------------------------------ */

    /**
     * Function to perfom common functions in this controller
     */
    private function common_functions($userid = 0) {
        if ($userid == 0) {
            $userid = $this->session->userdata['userid'];
        } else {
            $data['is_tracking'] = $this->relation->check_track($userid);
            $data['is_connected'] = $this->relation->check_connection($userid);
            $data['is_trackingback'] = $this->relation->check_trackback($userid);
        }

        $data['profile'] = $this->redux_auth->profile($userid);
        $data['users_connections'] = $this->relation->users_connections();
        $data['users_follows'] = $this->relation->users_tracks();
        $data['suggest_connect'] = $this->relation->suggest_connect();
        $data['suggest_follow'] = $this->relation->suggest_track();
        $data['site_notifications'] = $this->site_notifications;
        $data['priority_suggest_connect'] = $this->relation->suggest_connect_mutual();

        $this->load->model('notification_model');
        $notifications = $this->notification_model->all();
        if ($notifications) {
            $data['user_notifications'] = $notifications;
        }

        return $data;
    }

    function _remap($method, $params = array()) {
        // check if the user is logged in
        if ($this->redux_auth->logged_in()) {

            //check if the user is deactivated
            if ($this->session->userdata('deactive_but_logged_in')) {
                redirect('auth/reactivate');
            } else {
                return call_user_func_array(array($this, $method), $params);
            }
        } else {
            redirect('auth/login');
        }
    }

    /*
     * This function was put here due to very bad programming paradigms so kids
     * DONT TRY THIS
     * The reason the message validate receivers was put here instead of the library
     * is because the callback function cannot be placed outside of its usage controller
     *
     * so just imagine it being there, IMAGINE!!!
     * alright the rest works so be happy
     *
     */

    public function validate_receivers($receivers) {
        $the_receivers = explode(',', $receivers);
        foreach ($the_receivers as $receiver) {
            $receiver = trim($receiver);
            if (!preg_match('/[0-9]/', $receiver) || !$this->relation_model->check_connect($receiver)) {
                $this->form_validation->set_message('validate_receivers', 'Cannot send your message to some of your receiver(s)');
                return false;
            }
            $this->messaging->receivers[] = $receiver;
        }
        $this->messaging->receivers[] = $this->session->userdata['userid'];
        return true;
    }

}

/* End of file user.php */
/* Location: ./system/application/controllers/user.php */