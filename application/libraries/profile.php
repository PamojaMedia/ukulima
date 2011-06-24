<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class profile {

    /**
     * CodeIgniter global
     *
     * @var string
     **/
    protected $ci;

    public $data = array();

    // limit to the number of query results to be retreived. This is the limit for browser
    private $count = 20;

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
        $this->ci->load->model('redux_auth_model');
        $this->ci->load->model('relation_model');

        $this->data = $this->ci->redux_auth->get_browser('profile');

        if($this->ci->agent->is_mobile()) {
            $this->view_prefix = 'm-';
            $this->count = 10;
        }
    }

    public function network($userid = 0) {
        // set the userid to the logged in user if it's not set
        if($userid == 0) {
            $userid = $this->ci->session->userdata['userid'];
        }

        // get the people that are being tracked
        $result['network'] = $this->ci->relation_model->user_network($userid);

        // set the error message in case the user has no messages
        $result['error_message'] = 'You are not connected to or tracking anyone';

        if($userid != $this->ci->session->userdata['userid']) {
            $result['profile'] = $this->ci->redux_auth->get_userdata($userid);
            $result['userid'] = $userid;
        }
        else {
            $result['userid'] = $this->ci->session->userdata['userid'];
        }

        // load the view for displaying the user's network
        $network = $this->ci->load->view('profile/'.$this->view_prefix.'network',$result,true);

        $this->data['content'] = $network;

        return $this->data;


    }

    public function network_search($network = '', $userid = 0, $page = 0) {
        // index from which to start the query
        $start = $page * $this->count;

        // set the userid to the logged in user if it's not set
        if($userid == 0) {
            $userid = $this->ci->session->userdata['userid'];
        }

        if($network == 'tracks' || $network == 'trackback' || $network == 'connections') {

            if($this->ci->form_validation->run('network_search') == false) {
                $this->data['content'] = 'Invalid search terms';
            }

            else {

                $search = $this->ci->input->post('search');

                // perform the search
                $result[$network] = $this->ci->relation_model->network_search($search, $network, $userid, $this->count, $start);
                $result['page'] = $page + 1;
                
                // set the error message in case the user has no messages
                $result['error_message'] = 'No users were found';
                if($page > 0) {
                    $result['error_message'] = 'You\'ve already seen Everyone! BUMMER!!!';
                }

                if($userid != $this->ci->session->userdata['userid']) {
                    $result['profile'] = $this->ci->redux_auth->get_userdata($userid);
                    $data['userid'] = $result['userid'] = $userid;
                }
                else {
                    $data['userid'] = $result['userid'] = $this->ci->session->userdata['userid'];
                }

                $data['search_query'] = $search;
                $data['search_for'] = $network;
                // load the view for creating the form for searching for follows
                $form = $this->ci->load->view('profile/'.$this->view_prefix.'form',$data,true);

                // load the view for displaying the users being followed
                $search_results = $this->ci->load->view('profile/'.$this->view_prefix.$network,$result,true);

                // put the form and messages as the page contents
                $this->data['content'] = $form.$search_results;

            }

        }
        else {
            $this->data['content'] = 'The search could not be performed!';
        }

        return $this->data;
    }

    public function network_suggest($page = 0) {
        // index from which to start the query
        $start = $page * $this->count;

        // set the userid to the logged in user
        $userid = $this->ci->session->userdata['userid'];

        // retreive the suggestions
        $result['suggestions'] = $this->ci->relation_model->network_suggest($userid, $this->count, $start);
        $result['page'] = $page + 1;
        
        // set the error message in case the user has no messages
        $result['error_message'] = 'Hello Adam! The rest of humanity isn\'t here yet!';
        if($page > 0) {
            $result['error_message'] = 'You\'ve already seen Everyone! BUMMER!!!';
        }

        // load the view for displaying the users on the site
        $suggestions = $this->ci->load->view('profile/'.$this->view_prefix.'suggest',$result,true);

        // put the form and messages as the page contents
        $this->data['content'] = $suggestions;


        return $this->data;
    }

    public function tracks($userid = 0, $page = 0) {
        // index from which to start the query
        $start = $page * $this->count;

        // set the userid to the logged in user if it's not set
        if($userid == 0) {
            $userid = $this->ci->session->userdata['userid'];
        }
        
        // get the people that are being tracked
        $result['tracks'] = $this->ci->relation_model->tracks($userid, $this->count, $start);
        $result['page'] = $page + 1;
        
        if($userid != $this->ci->session->userdata['userid']) {
            $data['profile'] = $result['profile'] = $this->ci->redux_auth->get_userdata($userid);
            $data['userid'] = $result['userid'] = $userid;
            // set the error message in case the user has no messages
            $result['error_message'] = $data['profile']['firstname'].' is not tracking anyone at the moment';
        }
        else {
            $data['userid'] = $result['userid'] = $this->ci->session->userdata['userid'];
            // set the error message in case the user has no messages
            $result['error_message'] = 'You are not tracking anyone at the moment';
        }
        if($page > 0) {
            $result['error_message'] = 'You\'ve already seen Everyone! BUMMER!!!';
        }

        $form = '';
        if(count($result['tracks'])) {
            $data['search_for'] = 'tracks';
            // load the view for creating the form for searching for follows
            $form = $this->ci->load->view('profile/'.$this->view_prefix.'form',$data,true);
        }

        // load the view for displaying the users being followed
        $follows = $this->ci->load->view('profile/'.$this->view_prefix.'tracks',$result,true);

        // put the form and messages as the page contents
        $this->data['content'] = $form.$follows;

        return $this->data;
    }

    public function trackback($userid = 0, $page = 0) {
        // index from which to start the query
        $start = $page * $this->count;

        // set the userid to the logged in user if it's not set
        if($userid == 0) {
            $userid = $this->ci->session->userdata['userid'];
        }

        // get the people that are being tracked
        $result['trackback'] = $this->ci->relation_model->trackback($userid, $this->count, $start);
        $result['page'] = $page + 1;

        if($userid != $this->ci->session->userdata['userid']) {
            $data['profile'] = $result['profile'] = $this->ci->redux_auth->get_userdata($userid);
            $data['userid'] = $result['userid'] = $userid;
            $result['error_message'] = $data['profile']['firstname'].' is not being tracked at the moment';
        }
        else {
            $data['userid'] = $result['userid'] = $this->ci->session->userdata['userid'];
            // set the error message in case the user has no messages
            $result['error_message'] = 'You are not being tracked at the moment';
        }
        if($page > 0) {
            $result['error_message'] = 'You\'ve already seen Everyone! BUMMER!!!';
        }

        $form = '';
        if(count($result['trackback'])) {
            $data['search_for'] = 'trackback';
            // load the view for creating the form for searching for follows
            $form = $this->ci->load->view('profile/'.$this->view_prefix.'form',$data,true);
        }

        // load the view for displaying the users being followed
        $follows = $this->ci->load->view('profile/'.$this->view_prefix.'trackback',$result,true);

        // put the form and messages as the page contents
        $this->data['content'] = $form.$follows;

        return $this->data;
    }

    public function connections($userid = 0, $page = 0) {
        // index from which to start the query
        $start = $page * $this->count;

        // set the userid to the logged in user if it's not set
        if($userid == 0) {
            $userid = $this->ci->session->userdata['userid'];
        }

        // get the people that are being tracked
        $result['connections'] = $this->ci->relation_model->user_connections($userid, $this->count, $start);
        $result['page'] = $page + 1;

        if($userid != $this->ci->session->userdata['userid']) {
            $data['profile'] = $result['profile'] = $this->ci->redux_auth->get_userdata($userid);
            $data['userid'] = $result['userid'] = $userid;
            // set the error message in case the user has no messages
            $result['error_message'] = $data['profile']['firstname'].' is not connected to anyone at the moment';
        }
        else {
            $data['userid'] = $result['userid'] = $this->ci->session->userdata['userid'];
            // set the error message in case the user has no messages
            $result['error_message'] = 'You are not connected to anyone at the moment';
        }
        if($page > 0) {
            $result['error_message'] = 'You\'ve already seen Everyone! BUMMER!!!';
        }

        $form = '';
        if(count($result['connections'])) {
            $data['search_for'] = 'connections';
            // load the view for creating the form for searching for follows
            $form = $this->ci->load->view('profile/'.$this->view_prefix.'form',$data,true);
        }

        // load the view for displaying the users being followed
        $follows = $this->ci->load->view('profile/'.$this->view_prefix.'connections',$result,true);

        // put the form and messages as the page contents
        $this->data['content'] = $form.$follows;

        return $this->data;
    }

}