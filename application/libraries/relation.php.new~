<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Library to handle the realtion between users
 *
 */

class relation
{

    /**
	 * CodeIgniter global
	 *
	 * @var string
	 **/
	protected $ci;

	/**
	 * account status ('not_activated', etc ...)
	 *
	 * @var string
	 **/
	protected $status;

	/**
	 * __construct
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function __construct()
	{
		$this->ci =& get_instance();
                // Load the relation model for checking connection and follow status.
        $this->ci->load->model('relation_model');

	}
        /**
         * retrieve users connected to logged in users
         * @param the userid as an integer
         * @return an array containing all the users associated to the user
         */
        public function users_connections()
        {
            $this->ci->relation_model->profile_users_connect();
            $data = $this->ci->relation_model->connection_1;
            
            return $data;
        }

        public function users_follows()
        {
            $this->ci->relation_model->profile_users_follow();
            $data = $this->ci->relation_model->follow_1;

            return $data;
        }

        /*
         * retrieve users the logged in can connect to
         *
         */

        public function suggest_connect()
        {
            $this->ci->relation_model->user_suggest_connect();
            $data = $this->ci->relation_model->suggest_connect;
            return $data;
        }

        /*
         * retireve users that the user is mutually following but is not connected to
         *
         */

        public function suggest_connect_mutual()
        {
            $this->ci->relation_model->suggestconnect_mutualfollows();
            $data = $this->ci->relation_model->suggest_connect_mutual_follow;

            return $data;

        }

        /**
         *  retreive users the logged in user can follow
         *
         */
        public function suggest_follow()
        {
            $this->ci->relation_model->user_suggest_follow();
            $data = $this->ci->relation_model->suggest_follow;
            return $data;
        }

       

        public function follow($followid)
        {
            $userid = $this->ci->session->userdata('userid');
            return $this->ci->relation_model->follow_user($userid,$followid);
        }

}

?>
