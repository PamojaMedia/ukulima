<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * ----------------------------------------------------------------------------
 * "THE BEER-WARE LICENSE" :
 * <thepixeldeveloper@googlemail.com> wrote this file. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy me a beer in return Mathew Davies
 * ----------------------------------------------------------------------------
 */

/**
 * Redux Authentication Library
 */
class redux_auth {

    /**
     * CodeIgniter global
     *
     * @var string
     * */
    protected $ci;
    /**
     * account status ('not_activated', etc ...)
     *
     * @var string
     * */
    protected $status;

    public $data = array();

    // indicate whether the browser is a mobile browser or not
    private $is_mobile = false;

    /**
     * __construct
     *
     * @return void
     * @author Mathew
     * */
    public function __construct() {
        $this->ci = & get_instance();
        $email = $this->ci->config->item('email');
        $this->ci->load->library('email', $email);
        $this->ci->load->library('user_agent');

        if($this->ci->agent->is_mobile()) {
            $this->is_mobile = true;
        }
    }

    /**
     * Activate user.
     *
     * @return void
     * @author Mathew
     * */
    public function activate($username, $code) {
        
        if($username != '' && $code != '') {
            return $this->ci->redux_auth_model->activate($username, $code);
        }
        else {
            return false;
        }
        
    }

    /**
     * Deactivate user.
     *
     * @return void
     * @author Mathew
     * */
    public function deactivate($identity) {
        return $this->ci->redux_auth_model->deactivate($code);
    }

    /**
     * Change password.
     *
     * @return void
     * @author Mathew
     * */
    public function change_password($identity, $old, $new) {
        return $this->ci->redux_auth_model->change_password($identity, $old, $new);
    }

    /**
     * forgotten password feature
     *
     * @return void
     * @author Mathew
     * */
    public function forgotten_password($email) {
        $forgotten_password = $this->ci->redux_auth_model->forgotten_password($email);

        if ($forgotten_password) {
            // Get user information.
            $profile = $this->ci->redux_auth_model->profile($email);

            $data = array('identity' => $profile->{$this->ci->config->item('identity')},
                'forgotten_password_code' => $this->ci->redux_auth_model->forgotten_password_code);

            $message = $this->ci->load->view($this->ci->config->item('email_templates') . 'forgotten_password', $data, true);

            $this->ci->email->clear();
            $this->ci->email->set_newline("\r\n");
            $this->ci->email->from('', '');
            $this->ci->email->to($profile->email);
            $this->ci->email->subject('Email Verification (Forgotten Password)');
            $this->ci->email->message($message);
            return $this->ci->email->send();
        } else {
            return false;
        }
    }


    public function mobile_forgotten_password($phonenumber) {
        $forgotten_password = $this->ci->redux_auth_model->mobile_forgotten_password($phonenumber);

        if ($forgotten_password) {
            return $this->send_sms($phonenumber, 'forgotpassword');
        } else {
            return false;
        }
    }

    /**
     * undocumented function
     *
     * @return void
     * @author Mathew
     * */
    public function forgotten_password_complete($code) {
        $identity = $this->ci->config->item('identity');
        $profile = $this->ci->redux_auth_model->profile($code);
        $forgotten_password_complete = $this->ci->redux_auth_model->forgotten_password_complete($code);

        if ($forgotten_password_complete) {
            $data = array('identity' => $profile->{$identity},
                'new_password' => $this->ci->redux_auth_model->new_password);

            $message = $this->ci->load->view($this->ci->config->item('email_templates') . 'new_password', $data, true);

            $this->ci->email->clear();
            $this->ci->email->set_newline("\r\n");
            $this->ci->email->from('', '');
            $this->ci->email->to($profile->email);
            $this->ci->email->subject('New Password');
            $this->ci->email->message($message);
            return $this->ci->email->send();
        } else {
            return false;
        }
    }

    public function mobile_forgotten_password_complete($username, $code) {
        $forgotten_password_complete = $this->ci->redux_auth_model->mobile_forgotten_password_complete($username, $code);

        return $forgotten_password_complete;
    }

    /**
     * register
     *
     * @return void
     * @author Mathew
     * */
    public function register($username, $firstname, $lastname, $password, $email, $phonenumber, $confirm = '') {
        $email_activation = $this->ci->config->item('email_activation');
        $email_folder = $this->ci->config->item('email_templates');

        $register = $this->ci->redux_auth_model->register($username, $firstname, $lastname, $password, $email, $phonenumber);
        if($confirm=='phone') {
            $this->ci->redux_auth_model->deactivate($username);
            return $this->send_sms($phonenumber, 'activation');
        }
        elseif($email_activation || $confirm=='email') {
            $register = $this->ci->redux_auth_model->register($username, $firstname, $lastname, $password, $email, $phonenumber);

            if (!$register) {
                return false;
            }

            $deactivate = $this->ci->redux_auth_model->deactivate($username);

            if (!$deactivate) {
                return false;
            }

            $activation_code = $this->ci->redux_auth_model->activation_code;

            $site_url = site_url();

            $data = array('username' => 'Username: ' . $username . '<br />',
                'password' => 'Password: ' . $password . '<br />',
                'email' => 'Email address: ' . $email . '<br />',
                'activation' => 'Activation link: ' . $site_url . 'auth/activate_new_user/' . $username . '/' . $password . '/' . $activation_code . '<br />',
                'cancel' => 'If you wish to cancel the registration: ' . $site_url . 'auth/cancel_link/' . $username . '/' . $password
            );

            $message = $this->ci->load->view($email_folder . 'activation', $data, true);

            $this->ci->email->clear();
            $this->ci->email->set_newline("\r\n");
            $this->ci->email->from('Admin', 'admin@ukulima.net');
            $this->ci->email->to($email);
            $this->ci->email->subject('Email Activation (Registration)');
            $this->ci->email->message($message);

            return $this->ci->email->send();
        }

        return $register;
        
    }

    /**
     * Function to setup the user bio
     * @return true
     */

   public function bio($activity, $interest, $location, $country)
   {
         $bio = $this->ci->redux_auth_model->bio($activity, $interest, $location, $country);

         return $bio;
   }
    /**
     * login
     *
     * @return void
     * @author Mathew
     * */
    public function login($identity, $password) {
        return $this->ci->redux_auth_model->login($identity, $password);
    }

    /**
     * logout
     *
     * @return void
     * @author Mathew
     * */
    public function logout() {
        // $identity = $this->ci->config->item('identity');
        //$identity = $this->ci->session->userdata('');
        $this->ci->session->unset_userdata('userid');
        $this->ci->session->sess_destroy();
    }

    /**
     * logged_in
     *
     * @return void
     * @author Mathew
     * */
    public function logged_in() {
        //$identity = $this->ci->config->item('identity');
        // $identity = $this->ci->session->userdata('userid');
        return ($this->ci->session->userdata('userid')) ? true : false;
    }

    /**
     * Profile
     *
     * @return void
     * @author Mathew
     * */
    public function profile($identity = 0) {

        if($identity == 0) {
            $identity = $this->ci->session->userdata['userid'];
        }
        
        return $this->ci->redux_auth_model->profile($identity);
    }

    /**
     * Deactivate
     *
     * @return void
     * @author Comark
     */
    public function deactivate_link($identity, $userid, $username) {

        return $this->ci->redux_auth_model->deactivate_link($identity, $userid, $username);
    }

    /**
     * Cancel function
     *
     * @return void
     * @author Comark
     */
    public function cancel($username, $password) {
        return $this->ci->redux_auth_model->cancel_user($username, $password);
    }

    /**
     * reactivate link
     *
     * @return void
     * @author Comark
     */
    public function reactivate_link($identity, $userid, $username) {

        return $this->ci->redux_auth_model->reactivate_link($identity, $userid, $username);
    }

    /**
     * Template chooser file
     *
     * Choose the template for logged in user or not logged in
     */
    public function template_choose() {
        $log = $this->logged_in();

        if ($this->ci->agent->is_mobile()) {
            if ($log) {
                $tpl = 'm-template';
            } else {
                $tpl = 'm-template-out';
            }
        }
        elseif ($this->ci->agent->is_browser()) {
            if ($log) {
                $tpl = 'template';
            } else {
                $tpl = 'template-out';
            }
        }

        return $tpl;
    }

    /**
     * Loading the js for users accessing through a site
     * @return array of strings to output to the browser
     */
    public function get_browser($method) {
        if ($this->ci->agent->is_browser() && !$this->ci->agent->is_mobile()) {
            $this->data['libraries'] =
                    // jquery library
                    '<script src="//ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js" type="text/javascript"></script>' .
                    // gritter library for showing notifications
                    '<script src="' . base_url() . 'javascript/jquery.gritter.min.js" type="text/javascript"></script>' .
                    '<script type="text/javascript" charset="ISO-8859-1" src="' . base_url() . 'javascript/jquery.tokeninput.min.js" type="text/javascript"></script>';


            $this->data['styles'] = link_tag('assets/css/token-input.css');

            // load the js script for ajaxifying the updating and commenting process
            $data['url'] = site_url('user/message_receiver/1');
            $this->data['scripts'] = $this->ci->load->view($method . '/javascript', $data, true);

            //$this->data['relationscript'] =$this->ci->load->view('relation/javascript','',true);
        }

        return $this->data;
    }

    public function get_userdata($userid) {
        return $this->ci->redux_auth_model->profile($userid);
    }

    public function send_sms($phonenumber = '', $type = 'activation') {
         $num_length = strlen($phonenumber);
        if($phonenumber!='' && $num_length>=10 && $num_length<=12) {
            if($type=='activation') {
                $code = $this->ci->redux_auth_model->activation_code;
            }
            elseif($type=='forgotpassword') {
                $code = $this->ci->redux_auth_model->forgotten_password_code;
            }
            $source = 'ukulima.net';
            $url = "http://smpp3.routesms.com:8080/bulksms/bulksms?".
                "username=wk-test&".
                "password=test123&".
                "type=0&".
                "dlr=0&".
                "destination=$phonenumber&".
                "source=$source&".
                "message=$code";
            $ch = curl_init();    // initialize curl handle
            curl_setopt($ch, CURLOPT_URL,$url); // set url
            curl_setopt($ch, CURLOPT_FAILONERROR, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 3); // times out after 4s
            $result = curl_exec($ch); // run the whole process
            curl_close($ch);

            return true;

        }
        return false;
    }

}
