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
 * redux_auth_model
 */
class Redux_auth_model extends CI_Model {

    /**
     * Holds an array of tables used in
     * redux.
     *
     * @var string
     * */
    public $tables = array();
    /**
     * activation code
     *
     * @var string
     * */
    public $activation_code;
    /**
     * forgotten password key
     *
     * @var string
     * */
    public $forgotten_password_code;
    /**
     * new password
     *
     * @var string
     * */
    public $new_password;
    /**
     * Identity
     *
     * @var string
     * */
    public $identity;

    public function __construct() {
        parent::__construct();
        $this->load->config('redux_auth');
        $this->tables = $this->config->item('tables');
        $this->columns = $this->config->item('columns');
    }

    /**
     * Misc functions
     *
     * Hash password : Hashes the password to be stored in the database.
     * Hash password db : This function takes a password and validates it
     * against an entry in the users table.
     * Salt : Generates a random salt value.
     *
     * @author Mathew
     */

    /**
     * Hashes the password to be stored in the database.
     *
     * @return void
     * @author Mathew
     * */
    public function hash_password($password = false) {
        $salt_length = $this->config->item('salt_length');

        if ($password === false) {
            return false;
        }

        $salt = $this->salt();

        $password = $salt . substr(sha1($salt . $password), 0, -$salt_length);

        return $password;
    }

    /**
     * This function takes a password and validates it
     * against an entry in the users table.
     *
     * @return void
     * @author Mathew
     * */
    public function hash_password_db($identity = false, $password = false) {
        $identity_column = $this->config->item('identity');
        $users_table = $this->tables['people'];
        $salt_length = $this->config->item('salt_length');

        if ($identity === false || $password === false) {
            return false;
        }

        $query = $this->db->select('password')
                        ->where($identity_column, $identity)
                        ->limit(1)
                        ->get($users_table);

        $result = $query->row();

        if ($query->num_rows() !== 1) {
            return false;
        }

        $salt = substr($result->password, 0, $salt_length);

        $password = $salt . substr(sha1($salt . $password), 0, -$salt_length);

        return $password;
    }

    /**
     * Generates a random salt value.
     *
     * @return void
     * @author Mathew
     * */
    public function salt() {
        return substr(md5(uniqid(rand(), true)), 0, $this->config->item('salt_length'));
    }

    /**
     * Activation functions
     *
     * Activate : Validates and removes activation code.
     * Deactivae : Updates a users row with an activation code.
     *
     * @author Mathew
     */

    /**
     * activate
     *
     * @return void
     * @author Mathew
     * */
    public function activate($username = '', $code = false) {
        $identity_column = $this->config->item('identity');
        $users_table = $this->tables['people'];

        if ($code === false || $username == '') {
            return false;
        }

        $query = $this->db->select($identity_column)
                        ->where('activation_code', $code)
                        ->where($identity_column,$username)
                        ->limit(1)
                        ->get($users_table);

        $result = $query->row();

        if ($query->num_rows() !== 1) {
            return false;
        }

        $identity = $result->{$identity_column};

        $data = array('activation_code' => '');

        $this->db->update($users_table, $data, array($identity_column => $identity));

        return ($this->db->affected_rows() == 1) ? true : false;
    }

    /**
     * Deactivate
     *
     * @return void
     * @author Mathew
     * */
    public function deactivate($username = false) {
        $users_table = $this->tables['people'];

        if ($username === false) {
            return false;
        }

        if($this->agent->is_mobile()) {
            $activation_code = rand(1001,9999);
        }
        else {
            $activation_code = sha1(md5(microtime()));
        }
        
        $this->activation_code = $activation_code;

        $data = array('activation_code' => $activation_code);

        $this->db->update($users_table, $data, array('username' => $username));

        return ($this->db->affected_rows() == 1) ? true : false;
    }

    /**
     * change password
     *
     * @return void
     * @author Mathew
     * */
    public function change_password($identity = false, $old = false, $new = false) {
        $identity_column = $this->config->item('identity');
        $users_table = $this->tables['people'];

        if ($identity === false || $old === false || $new === false) {
            return false;
        }

        $query = $this->db->select('password')
                        ->where($identity_column, $identity)
                        ->limit(1)
                        ->get($users_table);

        $result = $query->row();

        $db_password = $result->password;
        $old = $this->hash_password_db($identity, $old);
        $new = $this->hash_password($new);

        if ($db_password === $old) {
            $data = array('password' => $new);

            $this->db->update($users_table, $data, array($identity_column => $identity));

            return ($this->db->affected_rows() == 1) ? true : false;
        }

        return false;
    }

    /**
     * Checks username.
     *
     * @return void
     * @author Mathew
     * */
    public function username_check($username = false) {
        $users_table = $this->tables['people'];

        if ($username === false) {
            return false;
        }

        $query = $this->db->select('userid')
                        ->where('username', $username)
                        ->limit(1)
                        ->get($users_table);

        if ($query->num_rows() == 1) {
            return true;
        }

        return false;
    }

    /**
     * Checks email.
     *
     * @return void
     * @author Mathew
     * */
    public function email_check($email = false) {
        $users_table = $this->tables['people'];

        if ($email === false) {
            return false;
        }

        $query = $this->db->select('userid')
                        ->where('email', $email)
                        ->limit(1)
                        ->get($users_table);

        if ($query->num_rows() == 1) {
            return true;
        }

        return false;
    }

    /**
     * Phone Number Check
     *
     * @return viod
     * @author Comark
     */
    public function phone_check($phonenumber=false) {
        if ($phonenumber === false) {
            return false;
        }

        $users_table = $this->tables['people'];

        $query = $this->db->select('userid')
                        ->where('phonenum', $phonenumber)
                        ->limit(1)
                        ->get($users_table);

        if ($query->num_rows() == 1) {
            return true;
        }

        return false;
    }

    /**
     * Identity check
     *
     * @return void
     * @author Mathew
     * */
    protected function identity_check($identity = false) {
        $identity_column = $this->config->item('identity');
        $users_table = $this->tables['people'];

        if ($identity === false) {
            return false;
        }

        $query = $this->db->select('userid')
                        ->where($identity_column, $identity)
                        ->limit(1)
                        ->get($users_table);

        if ($query->num_rows() == 1) {
            return true;
        }

        return false;
    }

    /**
     * Insert a forgotten password key.
     *
     * @return void
     * @author Mathew
     * */
    public function forgotten_password($email = false) {
        $users_table = $this->tables['people'];

        if ($email === false) {
            return false;
        }

        $query = $this->db->select('forgotten_password_code')
                        ->where('email', $email)
                        ->limit(1)
                        ->get($users_table);

        $result = $query->row();

        $code = $result->forgotten_password_code;

        if (empty($code)) {
            $key = $this->hash_password(microtime() . $email);

            $this->forgotten_password_code = $key;

            $data = array('forgotten_password_code' => $key);

            $this->db->update($users_table, $data, array('email' => $email));

            return ($this->db->affected_rows() == 1) ? true : false;
        } else {
            
            $this->forgotten_password_code = $code;
            
            return true;
        }
    }

    /**
     * Insert a forgotten password key.
     *
     * @return void
     * @author Mathew
     * */
    public function mobile_forgotten_password($phonenumber = false) {
        $users_table = $this->tables['people'];

        if ($phonenumber === false) {
            return false;
        }
        
        $key = rand(1001,9999);

        $this->forgotten_password_code = $key;

        $data = array('forgotten_password_code' => $key);

        $this->db->update($users_table, $data, array('phonenum' => $phonenumber));

        return ($this->db->affected_rows() == 1) ? $key : false;
       
    }

    /**
     * undocumented function
     *
     * @return userid of the user or false
     * @author Mathew
     * */
    public function forgotten_password_complete($code = false) {
        $users_table = $this->tables['people'];
        $identity_column = $this->config->item('identity');

        if ($code === false) {
            return false;
        }

        $query = $this->db->select('userid')
                        ->where('forgotten_password_code', $code)
                        ->limit(1)
                        ->get($users_table);

        $result = $query->row();

        if ($query->num_rows() > 0) {
            $salt = $this->salt();
            $password = $this->hash_password($salt);

            $this->new_password = $salt;

            $data = array('password' => $password,
                'forgotten_password_code' => '');

            $this->db->update($users_table, $data, array('forgotten_password_code' => $code));

            return $result->userid;
        }

        return false;
    }

    public function mobile_forgotten_password_complete($username = false, $code = false) {
        $users_table = $this->tables['people'];
        $identity_column = $this->config->item('identity');

        if ($code == false || $username == false) {
            return false;
        }

        $query = $this->db->select('userid')
                        ->where('forgotten_password_code', $code)
                        ->where('username', $username)
                        ->limit(1)
                        ->get($users_table);

        $result = $query->row();

        if ($query->num_rows() > 0) {
            $salt = rand(1001,9999);
            $password = $this->hash_password($salt);

            $this->new_password = $salt;

            $data = array('password' => $password,
                'forgotten_password_code' => '0');

            $this->db->update($users_table, $data, array('username' => $username));

            return $this->new_password;
        }

        return false;
    }

    /**
     * profile
     *
     * @return void
     * @author Mathew
     * */
    public function profile($identity = false) {

        $users_table = $this->tables['people'];
        // $identity_column = $this->config->item('identity');
        $identity_column = 'userid';
        if ($identity === false) {
            return false;
        }

        $this->db->select('userid,username,firstname,lastname,email,country,location,activity,interest');


        $this->db->from($users_table);
        $this->db->where($users_table . '.' . $identity_column, $identity);

        $this->db->limit(1);
        $i = $this->db->get();

        if ($i) {

            if ($i->num_rows() > 0) {
                $row = $i->row_array();
                return $row;
            }
            return $i;
        } else {
            return false;
        }
    }

    /**
     * Basic functionality
     *
     * Register
     * Login
     *
     * @author Mathew
     */

    /**
     * register
     *
     * @return void
     * @author Mathew
     * */
    public function register($username = false, $password = false, $email = false) {
        $users_table = $this->tables['people'];
        // $groups_table       = $this->tables['groups'];


        if ($username === false || $password === false || $email === false ) {
            return false;
        }

        // Group ID
        //$query    = $this->db->select('id')->where('name', $this->config->item('default_group'))->get($groups_table);
        //$result   = $query->row();
        //$group_id = $result->id;
        // IP Address
        $ip_address = $this->input->ip_address();

        //encrypt the password
        $password = $this->hash_password($password);

        // Users table.
        $data = array('username' => $username,
            
            'password' => $password,
            'email' => $email,
            
            'ip_address' => $ip_address);

        $this->db->insert($users_table, $data);

        return ($this->db->affected_rows() > 0) ? true : false;
    }

    /**
     * Method to update the user bio
     *
     */
    public function bio($activity='', $interest='', $location='', $country='') {
        $userid = $this->session->userdata['userid'];

        $data = array('activity' => $activity, 'interest' => $interest, 'location' => $location, 'country' => $country);
        $this->db->update('people', $data, array('userid' => $userid));
        return ($this->db->affected_rows() == 1) ? true : false;
    }

    /**
     * login
     *
     * @return void
     * @author Mathew
     * */
    public function login($identity = false, $password = false) {
        $identity_column = $this->config->item('identity');
        $users_table = $this->tables['people'];

        if ($identity === false || $password === false || $this->identity_check($identity) == false) {
            return false;
        }

        $query = $this->db->select($identity_column . ', password, activation_code, username, lastname, firstname, userid, phonenum, avatar, userstatus')
                        ->where($identity_column, $identity)
                        ->limit(1)
                        ->get($users_table);

        $result = $query->row();

        if ($query->num_rows() == 1) {
            $password = $this->hash_password_db($identity, $password);

            if (!empty($result->activation_code)) {
                return false;
            }

            if ($result->userstatus == '1') {

                $this->session->set_userdata('deactive_but_logged_in', TRUE);
            }

            if ($result->password === $password) {
                $user_data = array(
                    'username' => $result->username,
                    'lastname' => $result->lastname,
                    'firstname' => $result->firstname,
                    'userid' => $result->userid,
                    'phonenum' => $result->phonenum,
                    'avatar' => $result->avatar
                );

                $this->session->set_userdata($user_data);
                $this->session->set_userdata($identity_column, $result->{$identity_column});
                $this->session->set_userdata('user_logged_in', TRUE);
                return true;
            }
        }

        return false;
    }

    /**
     * Get the user info
     * @param <type> $username
     * @return <type>
     * @author Comark
     */
    public function get_user_email($username=false) {
        $users_table = $this->tables['people'];
        if ($username === false) {
            return false;
        }
        $query = $this->db->select('email')
                        ->where('username', $username)
                        ->limit(1)
                        ->get($users_table);

        $result = $query->row();

        if ($query->num_rows() == 1) {
            return $result->email;
        } else {
            return false;
        }
    }
    
    public function get_email_by_userid($userid = false) {
        $users_table = $this->tables['people'];
        if ($userid === false) {
            return false;
        }
        $query = $this->db->select('email')
                        ->where('userid', $userid)
                        ->limit(1)
                        ->get($users_table);

        $result = $query->row();

        if ($query->num_rows() == 1) {
            return $result->email;
        } else {
            return false;
        }
    }

    /**
     * Deactivate link
     *
     * @return void
     * @author Comark
     *
     */
    public function deactivate_link($identity=false, $userid=false, $username=false) {
        $users_table = $this->tables['people'];

        if ($identity === false || $userid === false || $username === false
                || $this->session->userdata('username') != $username 
                || $this->session->userdata('userid') != $userid ) {

            return false;
        }

        $query = $this->db->select('userstatus')
                        ->where('userid', $userid)
                        ->where('username', $username)
                        ->limit(1)
                        ->get($users_table);

        $result = $query->row();

        if ($query->num_rows() == 1) {
            if ($result->userstatus == 1) {

                return false;
            } else {

                $data = array('userstatus' => 1);
                $this->db->update($users_table, $data, array('userid' => $userid));
                $this->session->set_userdata('deactive_but_logged_in', TRUE);
                return true;
            }
        }
    }

    /**
     * reactivate link
     *
     * @return void
     * @author Comark
     *
     */
    public function reactivate_link($identity=false, $userid=false, $username=false) {
        $users_table = $this->tables['people'];

        if ($identity === false || $userid === false || $username === false 
                || $this->session->userdata('username') != $username 
                || $this->session->userdata('userid') != $userid ) {

            return false;
        }

        $query = $this->db->select('userstatus')
                        ->where('userid', $userid)
                        ->where('username', $username)
                        ->limit(1)
                        ->get($users_table);

        $result = $query->row();

        if ($query->num_rows() == 1) {
            if ($result->userstatus == 1) {
                $data = array('userstatus' => 0);
                $this->db->update($users_table, $data, array('userid' => $userid));
                $this->session->set_userdata('deactive_but_logged_in', FALSE);
                return true;
            } 
            else {
                return false;
            }
        }
    }

    /**
     * Cancel user registration
     *
     * @return void
     * @author Comark
     */
    public function cancel_user($username=false, $password=false) {
        $users_table = $this->tables['people'];

        if ($username === false || $password === false) {
            return false;
        }

        //encrypt the password
        $password = $this->hash_password($password);

        $this->db->delete($users_table, array('username' => $username, 'password' => $password));
        return true;
    }

}

/* End of file redux_auth_model.php */
/* Location: ./system/application/model/redux_auth_model.php */