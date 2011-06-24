<?php

/*
 * ----------------------------------------------------------------------------
 * "THE BEER-WARE LICENSE" :
 * <thepixeldeveloper@googlemail.com> wrote this file. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy me a beer in return Mathew Davies
 * ----------------------------------------------------------------------------
 */

class Auth extends CI_Controller {

    /**
     * constructor
     */
    private $tpl;
    public $data = array();
    // set the prefix for the views. used when the browser is mobile. the views have an m- prefix. for browsers, there is no prefix
    private $view_prefix = '';
    // indicate whether the browser is a mobile browser or not
    private $is_mobile = false;

    function __construct() {
        parent::__construct();
        $this->load->model('redux_auth_model');
        $this->load->model('relation_model');
        $this->tpl = $this->redux_auth->template_choose();
        $this->data = $this->redux_auth->get_browser('updates');

        if ($this->agent->is_mobile()) {
            $this->view_prefix = 'm-';
            $this->is_mobile = true;
        }
    }

    /**
     * index
     *
     * @return void
     * @author Mathew
     * */
    function index() {
        if ($this->redux_auth->logged_in()) {
            redirect('user/home');
        } else {
            redirect('auth/login');
        }
    }

    /**
     * activate
     * doesn't currently work
     *
     * @return void
     * @author Mathew
     * */
    function activate($username = '', $code = '') {

        if ($username != '' && $code != '') {
            $activate = $this->redux_auth->activate($username, $code);

            if ($activate) {
                $this->session->set_flashdata('message', '<p class="success">Your Account is now activated, please login.</p>');
                redirect('auth/activate');
            } else {
                $this->session->set_flashdata('message', '<p class="error">Your account is already activated or doesn\'t need activating.</p>');
                redirect('auth/activate');
            }
        }

        return false;
    }

    /**
     * settings
     *
     * this is for user to add bio data and change it if they see fit
     *
     *
     */
    function settings() {
        if ($this->redux_auth->logged_in()) {
            $data['profile'] = $this->redux_auth->profile();

            if ($this->form_validation->run('register') == false) {
                $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
                $this->data['content'] = $this->load->view('auth_view/' . $this->view_prefix . 'settings', $data, true);
                $this->load->view($this->tpl, $this->data);
            }
        }
    }

    /**
     * register
     *
     * @return void
     * @author Mathew
     * */
    function register() {

        //concatenate the country code and the number
        if (isset($_POST['phonenumber']) && isset($_POST['code'])) {
            $_POST['phonenumber'] = $_POST['code'] . $_POST['phonenumber'];
        }

        if ($this->form_validation->run($this->view_prefix . 'register') == false) {
            $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
            $this->data['content'] = $this->load->view('auth_view/' . $this->view_prefix . 'register', null, true);
            $this->load->view($this->tpl, $this->data);
        } else {
            $username = $this->input->post('username');
            $firstname = $this->input->post('firstname');
            $lastname = $this->input->post('lastname');
            $email = $this->input->post('email');
            if ($this->is_mobile) {
                if (empty($email)) {
                    $email = '';
                }
            }
            $password = $this->input->post('password1');
            $phonenumber = $this->input->post('phonenumber');
            $confirm = $this->input->post('confirm');

            $register = $this->redux_auth->register($username, $firstname, $lastname, $password, $email, $phonenumber, $confirm);

            if ($register) {
                /* Testing if response to j2me app will work */
                if ($this->is_mobile) {
                    if ($confirm == 'phone') {
                        if ($this->agent->is_mobile('j2me', 'midp')) {
                            echo 'registered';
                        } else {
                            $this->session->set_flashdata('message', '<p class="success">One final step. Please check your SMS to activate your account.</p>');
                            redirect('auth/mobile_activate');
                        }
                    } elseif ($confirm == 'mail') {
                        if ($this->agent->is_mobile('j2me', 'midp')) {
                            echo 'registered';
                        } else {
                            $this->session->set_flashdata('message', '<p class="success">One final step. Please check your email to activate your account.</p>');
                            redirect('auth/login');
                        }
                    }
                } else {
                    $this->session->set_flashdata('message', '<p class="success">One final step. Please check your email to activate your account.</p>');
                    redirect('auth/login');
                }
            } else {
                /* Testing if response to j2me app will work */
                if ($this->is_mobile) {
                    if ($this->agent->is_mobile('j2me', 'midp')) {
                        echo 'not registered';
                    } else {
                        $this->session->set_flashdata('message', '<p class="error">Something went wrong, please try again or contact the helpdesk.</p>');
                        redirect('auth/register');
                    }
                } else {
                    $this->session->set_flashdata('message', '<p class="error">Something went wrong, please try again or contact the helpdesk.</p>');
                    redirect('auth/register');
                }
            }
        }
    }

    /**
     * Method to update the login users bio
     *
     */

    /**
     * Setup bio information
     *
     * @return void
     *
     */
    public function bio() {

        if ($this->redux_auth->logged_in()) {
            if ($this->form_validation->run('bio') == false) {
                $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
                $bio_details = $this->redux_auth->profile($this->session->userdata['userid']);
                $this->data['content'] = $this->load->view('auth_view/' . $this->view_prefix . 'bio', $bio_details, true);
                $this->load->view($this->tpl, $this->data);
            } else {
                $activity = $this->input->post('activity');
                $interest = $this->input->post('interest');
                $location = $this->input->post('location');
                $country = $this->input->post('country');

                $bio = $this->redux_auth->bio($activity, $interest, $location, $country);

                if ($bio) {
                    /* response for mobile app and .mobi site */
                    if ($this->agent->is_mobile()) {
                        if ($this->agent->is_mobile('j2me', 'midp')) {
                            echo 'Updated';
                        } else {
                            $this->session->set_flashdata('message', '<p class="success">Your Bio has been updated.</p>');
                            redirect('user/profile');
                        }
                    } else {
                        $this->session->set_flashdata('message', '<p class="success">Your Bio has been updated. How about your picture?</p>');
                        redirect('auth/avatar');
                    }
                } else {

                    /* response for mobile app and .mobi site */
                    if ($this->agent->is_mobile()) {
                        if ($this->agent->is_mobile('j2me', 'midp')) {
                            echo 'Not Updated';
                        } else {
                            $this->session->set_flashdata('message', '<p class="error">Something went wrong, please try again or contact the helpdesk.</p>');
                            redirect('auth/bio');
                        }
                    } else {
                        $this->session->set_flashdata('message', '<p class="error">Something went wrong, please try again or contact the helpdesk.</p>');
                        redirect('auth/bio');
                    }
                }
            }
        } else {
            redirect('user/home');
        }
    }

    /**
     * Create your avatar
     *
     * @return void
     */
      public function avatar()
      {
      if($this->redux_auth->logged_in())
      {



      if ($this->agent->is_browser() && !$this->agent->is_mobile()) {
      $this->data['crop_script1'] = '<script src="' . base_url() . 'javascript/jquery.Jcrop.pack.js" type="text/javascript"></script>' .link_tag('assets/css/jquery.Jcrop.css');
      $this->data['crop_script2'] = '<script src="' . base_url() . 'javascript/cropImg.js" type="text/javascript"></script>';

      }
      $this->data['content'] = $this->load->view('auth_view/'.$this->view_prefix.'avatar', null, true);
      $this->load->view($this->tpl,  $this->data);



      }

      else
      {

      redirect('user/home');


      }
      }

      function do_upload()
      {
      $config['upload_path'] = './avatar/';
      $config['allowed_types'] = 'gif|jpg|png';
      $config['max_size']	= '500';
      $config['max_width']  = '1024';
      $config['max_height']  = '768';

      if($this->redux_auth->logged_in())
      {

      $this->load->library('upload', $config);
      if ($this->agent->is_browser() && !$this->agent->is_mobile()) {
      $this->data['crop_script1'] = '<script src="' . base_url() . 'javascript/jquery.Jcrop.pack.js" type="text/javascript"></script>' .link_tag('assets/css/jquery.Jcrop.css');
      $this->data['crop_script2'] = '<script src="' . base_url() . 'javascript/cropImg.js" type="text/javascript"></script>';

      }

      if ( ! $this->upload->do_upload('avatar'))
      {
      $data['error'] =  $this->upload->display_errors();


      $this->data['content'] = $this->load->view('auth_view/'.$this->view_prefix.'avatar', $data , true);
      $this->load->view($this->tpl,  $this->data);
      }
      else
      {
      $var = array();
      $var =  $this->upload->data();
      $data['success'] = base_url().'avatar/'.$var['file_name'];
      $data['file_crop_name'] = $var['file_name'];
      $ext1 = $var['file_ext'];
      $data['file_extension']= ltrim ($ext1,'.');
  
      $this->data['content'] = $this->load->view('auth_view/'.$this->view_prefix.'crop', $data , true);
      $this->load->view($this->tpl,  $this->data);
      }

      }
      else
      {
      redirect('user/home');
      }

      }

      /**
     * Method to crop the image for use as avatar
     * @param <type> $path
     *
     */

  
    function do_crop() {

        $this->load->helper('path');
        $new_path = 'avatar/new/';
        $path =  set_realpath($new_path, TRUE);

        if ($this->redux_auth->logged_in()) {

             $this->load->library('imagemanipulation');

            if ($this->imagemanipulation->crop_image( $this->input->post('path'),$this->input->post('ext')))
                    {
                $this->imagemanipulation->setJpegQuality('100');
                $this->imagemanipulation->setCrop($this->input->post('x'), $this->input->post('y'), $this->input->post('w'), $this->input->post('h'));
                $this->imagemanipulation->resize(100);
                $this->imagemanipulation->save($path . $this->input->post('file_name'));


                $this->session->set_flashdata('message', '<p class="success">Image Crop done!</p>');
                if ($this->agent->is_browser() && !$this->agent->is_mobile()) {
                    $this->data['crop_script1'] = '<script src="' . base_url() . 'javascript/jquery.Jcrop.pack.js" type="text/javascript"></script>' . link_tag('assets/css/jquery.Jcrop.css');
                    $this->data['crop_script2'] = '<script src="' . base_url() . 'javascript/cropImg.js" type="text/javascript"></script>';
                }
                $this->data['content'] = $this->load->view('auth_view/' . $this->view_prefix . 'avatar', null, true);
                $this->load->view($this->tpl, $this->data);
            }
            else {

                $this->session->set_flashdata('message', '<p class="success">Image Crop not done!</p>');
                if ($this->agent->is_browser() && !$this->agent->is_mobile()) {
                    $this->data['crop_script1'] = '<script src="' . base_url() . 'javascript/jquery.Jcrop.pack.js" type="text/javascript"></script>' . link_tag('assets/css/jquery.Jcrop.css');
                    $this->data['crop_script2'] = '<script src="' . base_url() . 'javascript/cropImg.js" type="text/javascript"></script>';
                }
                $this->data['content'] = $this->load->view('auth_view/' . $this->view_prefix . 'home', null, true);
                $this->load->view($this->tpl, $this->data);
            }
        } else {
            redirect('user/home');
        }
    }

    /**
     * Username check
     *
     * @return void
     * @author Mathew
     * */
    public function username_check($username) {
        $check = $this->redux_auth_model->username_check($username);

        if ($check) {
            $this->form_validation->set_message('username_check', 'The username "' . $username . '" already exists.');
            return false;
        } else {
            return true;
        }
    }

    /**
     * Email check
     *
     * @return void
     * @author Mathew
     * */
    public function email_check($email) {
        $check = $this->redux_auth_model->email_check($email);

        if ($check) {
            $this->form_validation->set_message('email_check', 'The email "' . $email . '" already exists.');
            return false;
        } else {
            return true;
        }
    }

    /**
     * Phone Number check
     *
     * @return void
     * @author Comark
     */
    public function phone_number_check($phonenumber) {

        $check = $this->redux_auth_model->phone_check($phonenumber);

        if ($check) {
            $this->form_validation->set_message('phone_number_check', 'The phone number "' . $phonenumber . '" already exists.');
            return false;
        } else {
            return true;
        }
    }

    /**
     * login
     *
     * @return void
     * @author Mathew
     * */
    function login() {

        if ($this->form_validation->run('login') == false) {
            $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
            $this->data['content'] = $this->load->view('auth_view/' . $this->view_prefix . 'login', null, true);
            $this->load->view($this->tpl, $this->data);
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $login = $this->redux_auth->login($username, $password);

            if ($login) {
                if ($this->session->userdata('deactive_but_logged_in')) {
                    redirect('auth/reactivate');
                } else {
                    redirect('user/home');
                }
            } else {
                redirect('auth/login');
            }
        }
    }

    /**
     * logout
     *
     * @return void
     * @author Mathew
     * */
    function logout() {
        $this->redux_auth->logout();
        redirect('auth/login');
    }

    /**
     * status
     *
     * @return void
     * @author Mathew
     * */
    function status() {
        $data['status'] = $this->redux_auth->logged_in();
        $this->data['content'] = $this->load->view('auth_view/' . $this->view_prefix . 'status', $data, true);
        $this->load->view($this->tpl, $this->data);
    }

    /**
     * change password
     *
     * @return void
     * @author Mathew
     * */
    function change_password() {

        if ($this->form_validation->run('change_password') == false) {
            $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
            $this->data['content'] = $this->load->view('auth_view/change_password', null, true);
            $this->load->view($this->tpl, $this->data);
        } else {
            $old = $this->input->post('old');
            $new = $this->input->post('new');

            $identity = $this->session->userdata($this->config->item('identity'));

            $change = $this->redux_auth->change_password($identity, $old, $new);

            if ($change) {
                $this->logout();
            } else {
                echo "Password Change Failed";
            }
        }
    }

    /**
     * forgotten password
     *
     * @return void
     * @author Mathew
     * */
    function forgotten_password() {
        //concatenate the country code and the number
        if (isset($_POST['phonenumber']) && isset($_POST['code'])) {
            $_POST['phonenumber'] = $_POST['code'] . $_POST['phonenumber'];
        }
        
        if ($this->form_validation->run($this->view_prefix.'forgot_password') == false) {
            $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
            $this->data['content'] = $this->load->view('auth_view/'.$this->view_prefix.'forgotten_password', null, true);
            $this->load->view($this->tpl, $this->data);
        } else {
            if($this->is_mobile) {
                $phonenumber = $this->input->post('phonenumber');
                $forgotten = $this->redux_auth->mobile_forgotten_password($phonenumber);

                if ($forgotten) {
                    $this->session->set_flashdata('message', '<p class="success">An sms has been sent to your phone number.</p>');
                    redirect('auth/forgotten_password');
                } else {
                    $this->session->set_flashdata('message', '<p class="error">Could not send the sms, please enter your details again.</p>');
                    redirect('auth/forgotten_password');
                }
            }
            else {
                $email = $this->input->post('email');
                $forgotten = $this->redux_auth->forgotten_password($email);

                if ($forgotten) {
                    $this->session->set_flashdata('message', '<p class="success">An email has been sent, please check your inbox.</p>');
                    redirect('auth/forgotten_password');
                } else {
                    $this->session->set_flashdata('message', '<p class="error">The email failed to send, try again.</p>');
                    redirect('auth/forgotten_password');
                }
            }
        }
    }

    /**
     * forgotten_password_complete
     *
     * @return void
     * @author Mathew
     * */
    public function forgotten_password_complete() {
        if ($this->form_validation->run($this->view_prefix.'activation') == false) {
            $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
            redirect('auth/forgotten_password');
        } else {
            if($this->is_mobile) {
                $username = $this->input->post('username');
                $code = $this->input->post('code');
                $forgotten = $this->redux_auth->mobile_forgotten_password_complete($username, $code);
                if ($forgotten) {
                    $this->data['content'] = $this->load->view('auth_view/'.$this->view_prefix.'new_password', array('password'=>$forgotten), true);
                    $this->load->view($this->tpl, $this->data);
                } else {
                    $this->session->set_flashdata('message', '<p class="error">Could not send the sms, please enter your details again.</p>');
                    redirect('auth/forgotten_password');
                }
            }
            else {
                $code = $this->input->post('code');
                $forgotten = $this->redux_auth->forgotten_password_complete($code);

                if ($forgotten) {
                    $this->session->set_flashdata('message', '<p class="success">An email has been sent, please check your inbox.</p>');
                    redirect('auth/forgotten_password');
                } else {
                    $this->session->set_flashdata('message', '<p class="error">The email failed to send, try again.</p>');
                    redirect('auth/forgotten_password');
                }
            }
        }
    }

    /**
     * Activate
     *
     * @return void
     * @author Comark
     */
    public function activate_new_user($username, $password, $activate_code) {
        $activate = $this->redux_auth->activate($username, $activate_code);

        if ($activate) {
            $login = $this->redux_auth->login($username, $password);

            if ($login) {
                $data['message'] = '<p class="success">Your account has been successfully activated.</p>';
                //$this->session->set_flashdata('message', '<p class="success">Your account has been successfully activated.</p>');
                $this->data['content'] = $this->load->view('auth_view/new_user_active', $data, true);
                $this->load->view($this->tpl, $this->data);
            } else {
                $data['message'] = '<p class="success">Your account has been successfully activated. But you will have to login to access your account</p>';
                //$this->session->set_flashdata('message', '<p class="success">Your account has been successfully activated. But you will have to login to access your account</p>');
                $this->data['content'] = $this->load->view('auth_view/new_user_active', $data, true);
                $this->load->view($this->tpl, $this->data);
            }
        } else {
            $this->session->set_flashdata('message', '<p class="success">There was a problem activating your account. Please contact the Help Desk</p>');
            redirect('auth/new_user_active');
        }
    }

    /**
     * Activate
     *
     * @return void
     * @author Comark
     */
    public function mobile_activate() {
        if ($this->form_validation->run('mobile-activate') == false) {
            $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
            $this->data['content'] = $this->load->view('auth_view/m-activate', null, true);
            $this->load->view($this->tpl, $this->data);
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $code = $this->input->post('code');

            $activate = $this->redux_auth->activate($username, $code);
            if ($activate) {
                $data['active'] = true;
                $login = $this->redux_auth->login($username, $password);
                if ($login) {
                    $data['login'] = true;
                    $data['message'] = '<p class="success">Your account has been successfully activated.</p>';
                    $this->data['content'] = $this->load->view('auth_view/m-new_user_active', $data, true);
                    $this->load->view($this->tpl, $this->data);
                } else {
                    $data['login'] = false;
                    $data['message'] = '<p class="success">Your account has been successfully activated. But you will have to login to access your account</p>';
                    $this->data['content'] = $this->load->view('auth_view/m-new_user_active', $data, true);
                    $this->load->view($this->tpl, $this->data);
                }
            } else {
                $data['active'] = false;
                $data['message'] = '<p class="success">There was a problem activating your account. Please contact the Help Desk</p>';
                $this->data['content'] = $this->load->view('auth_view/m-new_user_active', $data, true);
                $this->load->view($this->tpl, $this->data);
            }
        }
    }

    /**
     * Deactivate
     *
     * @return void
     * @author Comark
     */
    public function deactivate() {
        if ($this->redux_auth->logged_in()) {
            $data['username'] = $this->session->userdata('username');
            $data['userid'] = $this->session->userdata('userid');
            $this->data['content'] = $this->load->view('auth_view/deactivate', $data, true);
            $this->load->view($this->tpl, $this->data);
        } else {

            redirect('auth/login');
        }
    }

    /**
     * Deactivate link
     *
     * @return void
     * @author Comark
     */
    public function deactivate_link($username, $userid) {
        if ($this->redux_auth->logged_in()) {
            $identity = $this->session->userdata('username');

            $deactivate = $this->redux_auth->deactivate_link($identity, $userid, $username);

            if ($deactivate) {


                // $this->session->sess_destroy();
                redirect('auth/reactivate');
            } else {
                redirect('user/home');
            }
        }
    }

    /**
     * Cancel link
     *
     * @return void
     * @author Comark
     */
    public function cancel_link($username, $password) {

        $cancel = $this->redux_auth->cancel($username, $password);

        if ($cancel) {
            $this->session->set_flashdata('message', '<p class="success">The registration has been cancelled.</p>');
            $this->data['content'] = $this->load->view('auth_view/new_user_cancel', null, true);
            $this->load->view($this->tpl, $this->data);
        } else {
            $this->session->set_flashdata('message', '<p class="success">There was a problem cancelling your subscription.</p>');
            $this->data['content'] = $this->load->view('auth_view/new_user_cancel', null, true);
            $this->load->view($this->tpl, $this->data);
        }
    }

    /**
     * reactivcate
     *
     * @return void
     * @author comark
     */
    public function reactivate() {
        $data['username'] = $this->session->userdata('username');
        $data['userid'] = $this->session->userdata('userid');
        $this->data['content'] = $this->load->view('auth_view/reactivate', $data, true);
        $this->load->view($this->tpl, $this->data);
    }

    /**
     * Reactivate link
     *
     * @return void
     * @author Comark
     */
    public function reactivate_link($username, $userid) {
        if ($this->redux_auth->logged_in()) {
            $identity = $this->session->userdata('email');

            $reactivate = $this->redux_auth->reactivate_link($identity, $userid, $username);

            if ($reactivate) {

                redirect('user/home');
            } else {
                redirect('auth/login');
            }
        }
    }

    function _remap($method, $params = array()) {

        // check if the user is logged in
        if ($this->redux_auth->logged_in()) {

            //check if the user is deactivated
            if ($this->session->userdata('deactive_but_logged_in')) {
                // if the user is trying to reactivate then unset the deactive_but_logged_in session then run the reactivate call
                if (method_exists($this, 'reactivate_link')) {
                    $this->session->unset_userdata('deactive_but_logged_in');
                    return call_user_func_array(array($this, $method), $params);
                }

                // if the user is deactivated and logged in and tries to do something send to the reactivate area.
                else {
                    $this->reactivate();
                }
            }

            // the user is active and logged in
            else {
                // we do not want them to see the login area or registration area again
                $other_methods = array('0' => 'login', '1' => 'register');
                $p = false;

                foreach ($other_methods as $k => $val) {
                    if ($method == $val) {
                        $p = true;
                        break;
                    }
                }

                // if its not either login or registration run the function call
                if (!$p) {
                    return call_user_func_array(array($this, $method), $params);
                }

                //otherwise return them to the status page
                else {
                    $this->index();
                }
            }
        }

        // Here the user is not logged in and should not be able to see various sections until they login
        else {
            $new_methods = array('0' => 'change_password', '1' => 'deactivate',
                '2' => 'deactivate_link', '3' => 'logout',
                '4' => 'home', '5' => 'status', '6' => 'index', '7' => 'profile'
            ); // array of methods that will lead logged out users to the login screen

            $j = false;

            foreach ($new_methods as $i => $value) {

                if ($method == $value) {
                    $j = true;
                    break;
                }
            }

            // if the function is not among the ones in the above array it will run it as usual
            if (!$j) {
                if (method_exists($this, $method)) {

                    return call_user_func_array(array($this, $method), $params);
                }
            } else {
                $this->login();
            }
        }
    }

}

/* End of file auth.php */
/* Location: ./system/application/controllers/auth.php */