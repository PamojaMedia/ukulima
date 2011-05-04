<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* 
 * 
 * class made by Comark Onani
 *
 * 1. view users in the site (will change with time)
 *
 * 2. choose to follow users on the site
 *
 * 3. choose to unfollow users on the site
 *
 * 4. choose to connect with a user
 *
 * 5. choose to disconnect with a user
 *
 */

class Relation_model extends CI_Model
{

    /**
     * Holds an array of tables used in
     * redux.
     *
     * @var string
     **/

   public $tables = array();

        /**
	 * Identity
	 *
	 * @var string
	 **/
	public $identity;

        public $connection_1 = array();

        public $suggest_connect = array();

        public $follow_1 = array();

        public $suggest_follow = array();

        public $suggest_connect_mutual_follow = array();


   public function __construct()
    {
        parent::__construct();

	$this->load->config('redux_auth');
	$this->tables  = $this->config->item('tables');
	$this->columns = $this->config->item('columns');
    }


    /**
     * This method is to list all the uses on the site
     * - eventually it will only consist members with a particular relation
     * - that i still don't know how it will work, let me just quit commenting now
     * - before i get ideas and not do anything
     *
     * @param user id of the logged in user
     * @return array with all the users on the site
     */

    public function all($userid = 0)
    {

        if ($userid === 0)
        {
            return false;
        }
    
         $users_table     = $this->tables['people'];
        // first check if user is in the system


         $this->db->select('*')
                  ->where('userid', $userid);
         $query = $this->db->get($users_table);

         if ($query->num_rows() > 0)
         {
            // $userid = intval($userid);
             //get all the user that are not this user
             $this->db->select('*')
                     ->from($users_table)
                     ->where('userid !=',$userid);
             
             $user_query=$this->db->get()->result_array();
             return $user_query;
  
         }


    }

    /**
     * Method to check all the users that the user is not following or connected to ask to add
     * @return array of users the user is not following
     *
     */

    public function profile_users_connect()
    {
           $this->db->select('userid_2')
                    ->from('connect')
                    ->where('userid_1 = ',$this->session->userdata['userid'])
                     ->where('connectstatus',1);
                    
           $result_1 = $this->db->get();

           if($result_1->num_rows() >0 )
           {
               foreach($result_1->result_array() as $rows)
               {
                    $this->db->select('*')
                            ->from('people')
                            ->where('userid',$rows['userid_2']);

                    $userdata = $this->db->get();

                    if($userdata->num_rows() > 0)
                    {
                       $this->connection_1[] = $userdata->result_array();
                    }
               }
            
           }

            $this->db->select('userid_1')
                    ->from('connect')
                    ->where('userid_2 = ',$this->session->userdata['userid'])
                     ->where('connectstatus',1);

           $result_2 = $this->db->get();

           if($result_2->num_rows() >0 )
           {
               foreach($result_2->result_array() as $rows)
               {
                    $this->db->select('*')
                            ->from('people')
                            ->where('userid',$rows['userid_1']);

                    $userdatas = $this->db->get();

                    if($userdatas->num_rows() > 0)
                    {
                       $this->connection_1[] = $userdatas->result_array();
                    }
               }

           }

    }


   
/**
 *  Method to get users that the user logged  into the site is following
 * 
 */
    public function profile_users_follow()
    {
        $this->db->select('userid_2')
               ->from('follow')
               ->where('userid_1',$this->session->userdata['userid'])
               ->where('followstatus',1);

        $query = $this->db->get();

        if($query->num_rows() > 0)
        {
            foreach($query->result_array() as $row)
            {
                $userid = $row['userid_2'];

                $this->db->select('*')
                        ->from('people')
                        ->where('userid',$userid);

                    $new_query = $this->db->get();

                    if($new_query->num_rows() > 0)
                    {
                         $this->follow_1[] = $new_query->result_array();
                    }

            }
         
        }

      
    }
    /**
     *  Method to show proposed connections
     *
     */

    public function user_suggest_connect()
    {


        //this area checks users that you are not connected to.
        $this->profile_users_connect();

        $data = $this->connection_1;

        $userids = array();
        foreach($data as $s_connect)
             {
                 foreach($s_connect as $sc)
                 {

                    $userids[] = $sc['userid'];

                }

             }


         
             if(!empty($userids))
             {

                 $this->db->select('*')
                            ->from('people')
                            ->where_not_in('userid',$userids)
                                      ->where('userid !=', $this->session->userdata['userid']);
                              $userdata = $this->db->get();

                    if($userdata->num_rows() > 0)
                    {
                       $this->suggest_connect[] = $userdata->result_array();
                    }
                         

             }
             else
             {

                 $this->db->select('*')
                            ->from('people')
                             ->where('userid !=', $this->session->userdata['userid']);
                              $userdata = $this->db->get();

                    if($userdata->num_rows() > 0)
                    {
                       $this->suggest_connect[] = $userdata->result_array();
                    }
             }

            

    }

    public function suggestconnect_mutualfollows()
    {

         //also do check for all the users that the user is mutually tracking but is not connecting

                    //check all the users this user is following
                    $this->profile_users_follow();
                    $follows = $this->follow_1;
                     $suggest_mutual_follow_not = array();
                    
                    // get the id of the users the logged in user is following
                    foreach($follows as $f){
                        
                      
                       foreach($f as $s)
                       {
                           
                         $f_id = $s['userid'];
                        //use the id to check if this user is following back our logged in user
                        $return_follow = $this->check_user_followback($f_id);
                     

                        if($return_follow == '1')
                        {
                           // now check for those users the logged user is not connected to
                            $c_id = $this->check_connect($f_id);
                           
                            if($c_id == '0' || $c_id == null)
                            {
                                // retrieve all the users data with this id and set it in array
                                $suggest_mutual_follow_not[] = $s['userid'];
                                 
                            }

                         
                        }
                       

                        }
                        

                      }

                    //array holding this data of mutual followers but not connected
if(!empty($suggest_mutual_follow_not))
{
                            $this->db->select('*')
                            ->from('people')
                            ->where_in('userid',$suggest_mutual_follow_not)
                             ->where('userid !=',$this->session->userdata['userid']);
                              $userdata_1 = $this->db->get();

                    if($userdata_1->num_rows() > 0)
                    {
                       $this->suggest_connect_mutual_follow[] = $userdata_1->result_array();
                    }
}
    }

    /**
     * Function to display suggested follows
     *
     *
     *
     */

    public function user_suggest_follow()
    {

      $this->profile_users_follow();
      $data = $this->follow_1;

       $userids = array();
        foreach($data as $s_connect)
             {
                 foreach($s_connect as $sc)
                 {

                    $userids[] = $sc['userid'];

                }

             }

             if(count($userids)) {
                             $this->db->select('*')
                            ->from('people')
                            ->where_not_in('userid',$userids)
                             ->where('userid !=',$this->session->userdata['userid']);
                              $userdata = $this->db->get();
             }
             else {
                 $this->db->select('*')
                            ->from('people')
                             ->where('userid !=',$this->session->userdata['userid']);
                              $userdata = $this->db->get();
             }

                    if($userdata->num_rows() > 0)
                    {
                       $this->suggest_follow[] = $userdata->result_array();
                    }


    }


    public function follow_user($userid,$followid=0)
    {
        if($followid === 0)
        {
            return false;
        }

          $follow_table     = $this->tables['follow'];
          $user_table      =  $this->tables['people'];

          //first we check if user 2 is not deleted or deactivated
                     $this->db->select('*')
                              
                            ->where('userid', $followid)
                            ->where('flagstatus',0)
                            ->where('userstatus',0) ;
                         $query_del = $this->db->get($user_table);
           if ($query_del->num_rows() > 0)
           {
               //check if user1 was following user 2 and did an unfollow so as to just follow back

                $this->db->select('*')
                            ->where('userid_1',$userid)
                            ->where('userid_2',$followid)
                            ->where('followstatus',0)
                            ->limit(1);
               $query_user_refollow = $this->db->get($follow_table);

               if($query_user_refollow->num_rows() > 0 )
               {
                $data = array('followstatus' => 1);
                $this->db->update($follow_table, $data, array('userid_1' => $userid,'userid_2' => $followid));
                
                //refollow
                return 1;
               }


               //check if user 2 is following user so that the user is prompted to choose whether to connect
              $this->db->select('*')
                            ->where('userid_1',$followid)
                            ->where('userid_2',$userid)
                            ->where('followstatus',1)
                            ->limit(1);
                $query_user2_follow = $this->db->get($follow_table);
               if($query_user2_follow->num_rows() > 0)
               {
                $data = array('followstatus' => 1,'userid_1' => $userid,'userid_2' => $followid);
               
               $this->db->insert($follow_table,$data);
                //follow and ask to connect
                return 2;
               }

               //if neither the two are following each other then create a good ol' dandy follow

               $this->db->select('*')
                            ->where('(userid_1='.$userid.' AND userid_2='.$followid.')')
                            ->or_where('(userid_2='.$userid.' AND userid_1='.$followid.')');
               $query_follow = $this->db->get($follow_table);

               if($query_follow->num_rows() == 0)
               {
                   $data = array('followstatus' => 1,'userid_1' => $userid,'userid_2' => $followid);
                $this->db->insert($follow_table, $data);

                //new follow
                return 3;
               }

           }


    }

    /**
     * Method to connect to a user. First check if the user you are connecting sent a request to connect
     * else send a request to the user.
     *
     */

    public function connect_user($userid = 0)
    {
        if($userid === 0)
        {
            return false;
        }

        //check if there is any relation
                $this->db->select('*')
                    ->from('connect')
                    ->where('(userid_1 = '.$userid.' and userid_2 = '.$this->session->userdata['userid'].' )',NULL,false)
                    ->or_where('(userid_2 = '.$userid.' and userid_1 = '.$this->session->userdata['userid'].' )',NULL,false);

                $result = $this->db->get();


                // there is a connection
                if($result->num_rows() > 0)
                {
                    $row = $result->row();

                    if($row->connectstatus == 1)
                    {
                        return false;
                    }

                    else
                    {
                        // request connection

                        
                    }

                }

                else
                {

                     
                }

    }



      /**
         * Method to check if the logged in user is following a specific user
         * @param <int> $userid the userid to check if the logged in user is following
         * @return <bool> return true or false depending on the follow status
         */

        public function check_follow($userid = 0) {
            if($userid>0)
            {
                $this->db->select('followstatus')
                    ->from('follow')
                    ->where('userid_1 = ',$this->session->userdata['userid'])
                    ->where('userid_2 = ',$userid);
                $result = $this->db->get();
                if($result->num_rows()) {
                    $values = $result->row_array();
                    return $this->connect_follow_status($values['followstatus']);
                }
                else {
                    return false;
                }

            }
            else
            {
                return false;
            }
        }

        /**
         * Method to check if a user id passed is following the logged in user so that a mutual connection can be asserted and then
         * set it up as a high priority to request connection if not doing so
         *
         *
         */
        public function check_user_followback($userid = 0)
        {

            if($userid>0)
            {
                $this->db->select('followstatus')
                    ->from('follow')
                    ->where('userid_1 = ', $userid)
                    ->where('userid_2 = ', $this->session->userdata['userid']);
                $result = $this->db->get();
                if($result->num_rows()) {
                    $values = $result->row_array();
                    return $this->connect_follow_status($values['followstatus']);
                }
                else {
                    return false;
                }

            }
            else
            {
                return false;
            }
        }

        /**
         * Method to check if the logged in user is connected to a specific user
         * @param <int> $userid the userid to check if the logged in user is following
         * @return <bool> return true or false depending on the follow status
         */

        public function check_connect($userid = 0) {
            if($userid>0)
            {
                $this->db->select('connectstatus')
                    ->from('connect')
                    ->where('(userid_1 = '.$userid.' and userid_2 = '.$this->session->userdata['userid'].' and connectstatus = 1)',NULL,false)
                    ->or_where('(userid_2 = '.$userid.' and userid_1 = '.$this->session->userdata['userid'].' and connectstatus = 1)',NULL,false);
                $result = $this->db->get();
                if($result->num_rows()) {
                    $values = $result->row_array();
                    return $this->connect_follow_status($values['connectstatus']);
                }
                else {
                    return false;
                }

            }
            else
            {
                return false;
            }
        }

        /**
         * Method to check whether the logged in user is either connected to or following a certain user
         * @param <int> $userid the userid to check if the logged in user is following
         * @return <bool> Indicate that the logged in user is either following or connected to a certain user
         */

        public function check_follow_connect($userid = 0) {
            return ($this->check_follow($userid) || $this->check_connect($userid));
        }

        /**
         * Function to ensure a true/false value is returned when checking for a connect or follow status
         * @param <int> $status value to indicate whether user is following or connected to another user
         * @return <bool> return true or false depending on the connect or follow status
         */

        function connect_follow_status($status = null) {
            if(isset($status)) {
                return $status;
            }
            else {
                return false;
            }
        }



}

/* End of file realtion_model.php */
/* Location: ./system/application/model/relation_model.php */