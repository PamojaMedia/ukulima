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

        private $site_notifications = array();

	public function __construct()
	{
            $this->ci =& get_instance();
            // Load the relation model for checking connection and follow status.
            $this->ci->load->model('relation_model');
            /*change here also! variable to hold the user notifications config */
            $this->ci->load->config('notifications');
            $this->site_notifications = $this->ci->config->item('site_notifications');

	}
        /**
         * retrieve users connected to logged in users
         * @param the userid as an integer
         * @return an array containing all the users associated to the user
         */
        public function users_connections()
        {
            $data = $this->ci->relation_model->user_connections($this->ci->session->userdata['userid'],20,0);
            
            return $data;
        }

        public function users_tracks()
        {
            $data = $this->ci->relation_model->tracks($this->ci->session->userdata['userid'],20,0);

            return $data;
        }

        /*
         * retrieve users the logged in can connect to
         *
         */

        public function suggest_connect()
        {
            $data = $this->ci->relation_model->user_suggest_connect();
            
            return $data;
        }
        
         public function suggest_connect_long()
        {
            $data = $this->ci->relation_model->user_suggest_connect_long();
            
            return $data;
        }

        /*
         * retireve users that the user is mutually following but is not connected to
         *
         */

        public function suggest_connect_mutual()
        {
            $data =  $this->ci->relation_model->suggest_connect_mutual_tracks();

            return $data;

        }

        /**
         *  retreive users the logged in user can follow
         *
         */
        public function suggest_track()
        {
            $data = $this->ci->relation_model->user_suggest_track();
            
            return $data;
        }
        
        public function suggest_track_long()
        {
            $data = $this->ci->relation_model->user_suggest_track_long();
            
            return $data;
        }


       

        public function track($trackid, $ajax = false)
        {
            // load notifictation model
             $this->ci->load->model('notification_model','notifications');

            //user id to be passed to the relation model for follow action
            $userid = $this->ci->session->userdata('userid');

            // retrieve the ID of the follow event
            $notify = $this->ci->relation_model->track_user($userid,$trackid);

            if($notify)
            {
                $this->ci->notifications->set_notification($this->site_notifications['follow'],$notify,$trackid);
            }
            return $notify;


         
        }
        
        /**
         * Function to untrack a user that the logged in user is tracking
         * @param int $disconnectid id of the user to untrack
         * @return boolean 
         */
        public function disconnect($disconnectid, $ajax = false)
        {
            $userid = $this->ci->session->userdata('userid');
            
            if($disconnectid > 0 && $disconnectid != $userid) {
                
                // retrieve the ID of the follow event            
                $success = $this->ci->relation_model->disconnect_users($userid,$disconnectid);

                return $success;

            }
            
            return false;
         
        }
        
        /**
         * Function to untrack a user that the logged in user is tracking
         * @param int $untrackid id of the user to untrack
         * @return boolean 
         */
        public function untrack($untrackid, $ajax = false)
        {
            $userid = $this->ci->session->userdata('userid');
            
            if($untrackid > 0 && $untrackid != $userid) {
                
                // retrieve the ID of the follow event            
                $success = $this->ci->relation_model->untrack_user($userid,$untrackid);

                return $success;

            }
            
            return false;
         
        }

        /**
         *  Method to view a follow that has been notified to the user
         *
         */
        public function view_track($id)
        {
            //the id being passed is of the person following the logged in user

        $this->ci->load->model('notification_model','notifications');
        $this->ci->notifications->noted($id,$this->site_notifications['follow']);
     
        }

        /**
         *
         *  Method to do a connect
         *  @param $connectid the id of the user the logged in user intends to connect to
         */
        public function connect($connectid, $ajax = false)
        {
            // load notification model
             $this->ci->load->model('notification_model','notifications');
            // retrieve the ID of the follow event

            $notify = $this->ci->relation_model->connect_user($connectid);
            if($notify)
            {
                if($notify['set_notification']) {
                    $this->ci->notifications->set_notification($this->site_notifications['connect'],$notify['event_id'],$connectid);
                }
                else {
                    $this->ci->notifications->noted($connectid,$this->site_notifications['connect']);                    
                }
                return true;
            }

            return false;

        }

        function check_connection($userid = 0) {
            if($userid > 0) {
                return $this->ci->relation_model->check_connect($userid);
            }
            return false;
        }

        function check_track($userid = 0) {
            if($userid > 0) {
                return $this->ci->relation_model->check_track($userid);
            }
            return false;
        }

        function check_trackback($userid = 0) {
            if($userid > 0) {
                return $this->ci->relation_model->check_user_trackback($userid);
            }
            return false;
        }

}

?>
