<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
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

class Relation_model extends CI_Model {

    /**
     * Holds an array of tables used in
     * redux.
     *
     * @var string
     * */
    public $tables = array();
    /**
     * Identity
     *
     * @var string
     * */

    public function __construct() {
        parent::__construct();

        $this->load->config('redux_auth');
        $this->tables = $this->config->item('tables');
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
    public function all($userid = 0) {

        if ($userid === 0) {
            return false;
        }

        $users_table = $this->tables['people'];
        // first check if user is in the system

        $this->db->select('*')
                ->where('userid', $userid);
        $query = $this->db->get($users_table);

        if ($query->num_rows() > 0) {
            // $userid = intval($userid);
            //get all the user that are not this user
            $this->db->select('*')
                    ->from($users_table)
                    ->where('userid !=', $userid);

            $user_query = $this->db->get()->result_array();
            return $user_query;
        }
    }

    /**
     * Method to check all the users that the user is not following or connected to ask to add
     * @return array of users the user is not following
     *
     */
    public function user_connections($userid = 0, $count = 20, $start = 0) {
        $this->db->select('userid,username,firstname,lastname')
                ->from('people')
                ->where('userid in (select if(userid_1!='.$userid.',userid_1,userid_2) as userid from connect where (userid_1 = '.$this->db->escape($userid).' or userid_2 = '.$this->db->escape($userid).') and connectstatus = 1)
                           ','',false)
                ->limit($count,$start);
        $result = $this->db->get();
        if($result->num_rows()) {
            return $result->result_array();
        }

        return false;
        
    }

    public function user_network($userid = 0) {
        if($userid > 0) {
            $userid = $this->db->escape($userid);
            $this->db->select('connections,tracks,trackbacks')
                    ->from('(select count(userid_2) as tracks from follow where userid_1 = '.$userid.' and followstatus = 1) as follows,
                            (select count(userid_1) as trackbacks from follow where userid_2 = '.$userid.' and followstatus = 1) as followers,
                            (select count(userid_2) as connections from connect where (userid_1 = '.$userid.' or userid_2 = '.$userid.') and connectstatus = 1) as connects');
            $result = $this->db->get();
            if($result->num_rows()) {
                return $result->result_array();
            }

        }

        return false;

    }

    public function network_search($query = '', $network = 'search', $userid = 0, $count = 20,  $start = 0) {

        if($userid > 0 && $query != '') {

            if($network == 'tracks') {
                $this->db->select('follow.userid_2 as userid,username,firstname,lastname,track_back')
                    ->from('follow,people')
                    ->join('(select userid_1,followstatus as track_back from follow where userid_2 = '.$this->db->escape($userid).' and followstatus = 1 ) as temp','temp.userid_1 = follow.userid_2','left')
                    ->where('follow.userid_1', $userid)
                    ->where('follow.followstatus', 1)
                    ->where('people.userid = follow.userid_2','',false)
                    ->where('(firstname like "%'.$query.'%" or lastname like "%'.$query.'%" )','',false)
                    ->limit($count,$start);
            }
            elseif($network == 'trackback') {
                $this->db->select('follow.userid_1 as userid,username,firstname,lastname,track_back')
                    ->from('follow,people')
                    ->join('(select userid_2,followstatus as track_back from follow where userid_1 = '.$this->db->escape($userid).' and followstatus = 1 ) as temp','temp.userid_2 = follow.userid_1','left')
                    ->where('follow.userid_2', $userid)
                    ->where('follow.followstatus', 1)
                    ->where('people.userid = follow.userid_1','',false)
                    ->where('(firstname like "%'.$query.'%" or lastname like "%'.$query.'%" )','',false)
                    ->limit($count,$start);
            }
            elseif($network == 'connections') {
                $this->db->select('userid,username,firstname,lastname')
                    ->from('people')
                    ->where('(firstname like "%'.$query.'%" or lastname like "%'.$query.'%" )','',false)
                    ->where('( userid in (select if(userid_1!='.$userid.',userid_1,userid_2) as userid from connect where (userid_1 = '.$this->db->escape($userid).' or userid_2 = '.$this->db->escape($userid).') and connectstatus = 1))
                               ','',false)
                    ->limit($count,$start);
            }
            elseif($network == 'search') {
                $this->db->select('userid,username,firstname,lastname')
                    ->from('people')
                    ->where('(firstname like "%'.$query.'%" or lastname like "%'.$query.'%" )','',false)
                    ->limit($count,$start);
            }

            $result = $this->db->get();

            if($result->num_rows()) {
                return $result->result_array();
            }
            else {
                return false;
            }

        }

        return false;

    }

    public function network_suggest($userid = 0, $count = 20, $start = 0) {
        if($userid > 0) {
            $this->db->select('userid,username,firstname,lastname')
                    ->from('people')
                    ->where('userid not in (select userid_2 from follow where userid_1 = '.$this->db->escape($userid).' and followstatus = 1 )')
                    ->where('userid not in (select if(userid_1!='.$this->db->escape($userid).',userid_1,userid_2) as userid from connect where (userid_1 = '.$this->db->escape($userid).' or userid_2 = '.$this->db->escape($userid).') and connectstatus < 2)
                               ','',false)
                    ->where('userid !=',$userid)
                    ->limit($count,$start);

            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                return $query->result_array();
            }
        }

        return false;
    }

    /**
     *  Method to get users that the user logged into the site is following
     *
     */
    public function tracks($userid = 0, $count = 20, $start = 0) {
        if($userid > 0) {
            $this->db->select('follow.userid_2 as userid,username,firstname,lastname,track_back')
                    ->from('follow,people')
                    ->join('(select userid_1,followstatus as track_back from follow where userid_2 = '.$this->db->escape($userid).' and followstatus = 1 ) as temp','temp.userid_1 = follow.userid_2','left')
                    ->where('follow.userid_1', $userid)
                    ->where('follow.followstatus', 1)
                    ->where('people.userid = follow.userid_2','',false)
                    ->limit($count,$start);

            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                return $query->result_array();
            }
        }
        
        return false;
        
    }
    
    /**
     *  Method to get users that the user logged into the site is following
     * 
     */
    public function trackback($userid = 0, $count = 20, $start = 0) {
        if($userid > 0) {
            $this->db->select('follow.userid_1 as userid,username,firstname,lastname,track_back')
                    ->from('follow,people')
                    ->join('(select userid_2,followstatus as track_back from follow where userid_1 = '.$this->db->escape($userid).' and followstatus = 1 ) as temp','temp.userid_2 = follow.userid_1','left')
                    ->where('follow.userid_2', $userid)
                    ->where('follow.followstatus', 1)
                    ->where('people.userid = follow.userid_1','',false)
                    ->limit($count,$start);

            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                return $query->result_array();
            }
        }
        
        return false;
        
    }

    /**
     *  Method to show proposed connections
     *
     */
    public function user_suggest_connect() {

        //this area checks users that you are not connected to.
        $userid = $this->db->escape($this->session->userdata['userid']);
        
        $this->db->select('people.userid, firstname, lastname, username')
            ->from('people')
            ->where('userid not in (SELECT if(userid_1!='.$userid.',userid_1,userid_2) as userid from connect where (userid_1 = '.$userid.' or userid_2 = '.$userid.') and connectstatus < 2)','',false)
            ->where('userid !=', $this->session->userdata['userid'])
            ->where('userstatus',0)
            ->where('activation_code','')
            ->limit(5)
            ->order_by('rand()');
        $result = $this->db->get();
        
        if($result->num_rows()) {
            return $result->result_array();
        }
        
        return false;
        
    }

    public function suggest_connect_mutual_tracks() {
        
        $userid = $this->db->escape($this->session->userdata['userid']);

        $this->db->select('userid, firstname, lastname, username')
            ->from('people')
            ->where('userid in (select userid_1 from follow where 
                        userid_1 in (select userid_2 from follow where userid_1 = '.$userid.' and followstatus = 1) 
                        and userid_2 = '.$userid.' and followstatus = 1)','',false)
            ->where('userid not in (SELECT if(userid_1!='.$userid.',userid_1,userid_2) as userid from connect where (userid_1 = '.$userid.' or userid_2 = '.$userid.') and connectstatus < 2)','',false)
            ->where('userstatus',0)
            ->where('activation_code','')
            ->limit(5)
            ->order_by('rand()');
                
        $result = $this->db->get();
        
        if($result->num_rows()) {
            return $result->result_array();
        }
        
        return false;
    }

    /**
     * Function to display suggested follows
     *
     */
    public function user_suggest_track() {

        $userid = $this->db->escape($this->session->userdata['userid']);

        $this->db->select('userid, firstname, lastname, username')
            ->from('people')
            ->where('userid not in (select userid_2 from follow where userid_1 = '.$userid.' and followstatus = 1)','',false)
            ->where('userid not in (SELECT if(userid_1!='.$userid.',userid_1,userid_2) as userid from connect where (userid_1 = '.$userid.' or userid_2 = '.$userid.') and connectstatus < 2)','',false)
            ->where('userid != ',$this->session->userdata['userid'])
            ->where('userstatus',0)
            ->where('activation_code','')
            ->limit(5)
            ->order_by('rand()');
                
        $result = $this->db->get();
        
        if($result->num_rows()) {
            return $result->result_array();
        }
        
        return false;
        
    }

    public function track_user($userid, $trackid=0) {
        if ($trackid === 0) {
            return false;
        }

        $track_table = $this->tables['follow'];
        $user_table = $this->tables['people'];

        //check if the logged in user is following the intended target
        $this->db->select('ID,followstatus')
                ->from('follow')
                ->where('userid_1 = ', $this->session->userdata['userid'])
                ->where('userid_2 = ', $trackid);
        $result = $this->db->get();
        if ($result->num_rows()) {
            $row_arr = $result->row();
            if ($row_arr->followstatus == 1) {
                return false;
            }
        }
        //first we check if user 2 is not deleted or deactivated
        $this->db->select('userid,username,firstname,lastname')
                ->where('userid', $trackid)
                ->where('flagstatus', 0)
                ->where('userstatus', 0);
        $query_del = $this->db->get($user_table);
        if ($query_del->num_rows() > 0) {

            $this->db->select('*')
                   ->where('userid_1',$userid)
                   ->where('userid_2',$trackid)
                   ->where('followstatus',2)
                   ->limit(1);

            $query_user_refollow = $this->db->get($track_table);

            if($query_user_refollow->num_rows() > 0 )
            {
                $qur = $query_user_refollow->row();
                $data = array('followstatus' => 1);
                $this->db->update($track_table, $data, array('userid_1' => $userid,'userid_2' => $trackid));

                //refollow
                return $qur->ID;
                //return 1;
                exit;
            }

            //check if user 2 is following user so that the user is prompted to choose whether to connect
            $this->db->select('*')
                    ->where('userid_1', $trackid)
                    ->where('userid_2', $userid)
                    ->where('followstatus', 1)
                    ->limit(1);
            $query_user2_track = $this->db->get($track_table);
            if ($query_user2_track->num_rows() > 0) {
                $data = array('followstatus' => 1, 'userid_1' => $userid, 'userid_2' => $trackid);

                $this->db->insert($track_table, $data);
                //follow and ask to connect

                return $this->db->insert_id();

                exit;
            }

            //if neither the two are following each other then create a good ol' dandy follow

            $this->db->select('*')
                    ->where('(userid_1=' . $userid . ' AND userid_2=' . $trackid . ')')
                    ->or_where('(userid_2=' . $userid . ' AND userid_1=' . $trackid . ')');
            $query_track = $this->db->get($track_table);

            if ($query_track->num_rows() == 0) {
                $data = array('followstatus' => 1, 'userid_1' => $userid, 'userid_2' => $trackid);
                $this->db->insert($track_table, $data);

                //new follow
                // return 3;

                return $this->db->insert_id();
                exit;
            }
        }
    }
    
    public function untrack_user($userid = 0, $untrackid=0) {
        if ($untrackid === 0 || $userid === 0 || $untrackid == $userid) {
            return false;
        }
        
        $this->db->where('userid_1',$userid)
                ->where('userid_2',$untrackid)
                ->update('follow',array('followstatus' => 2));
        
        return $this->db->affected_rows();
        
    }
    
    public function disconnect_users($userid = 0, $disconnectid=0) {
        if ($disconnectid === 0 || $userid === 0 || $disconnectid == $userid) {
            return false;
        }
        
        $result = $this->db->select('ID')
        	    ->from('connect')
                    ->where('(userid_1 = ' . $userid . ' and userid_2 = ' . $disconnectid . ' )', NULL, false)
                    ->or_where('(userid_2 = ' . $userid . ' and userid_1 = ' . $disconnectid . ' )', NULL, false)
                    ->where('connectstatus',1)
                    ->get();
        if($result->num_rows()) {
            $id = $result->row_array();
            $this->db->where('ID',$id['ID'])
                ->update('connect',array('connectstatus' => 2));
            return $this->db->affected_rows();
        }
        else {
            return false;
        }                
        
    }
    

    /**
     * Method to connect to a user. First check if the user you are connecting sent a request to connect
     * else send a request to the user.
     *
     */
    public function connect_user($userid = 0) {
        if ($userid === 0) {
            return false;
        }

        //check if there is any relation
        $this->db->select('*')
                ->from('connect')
                ->where('(userid_1 = ' . $userid . ' and userid_2 = ' . $this->session->userdata['userid'] . ' )', NULL, false)
                ->or_where('(userid_2 = ' . $userid . ' and userid_1 = ' . $this->session->userdata['userid'] . ' )', NULL, false);

        $result = $this->db->get();
        $return = array();

        // there is a connection
        if ($result->num_rows() > 0) {
            $row = $result->row();

            if ($row->connectstatus == 1) {
                return false;
            } else {

                $data = array(
                    'connectstatus' => 1
                );
                $this->db->where('connectstatus',0)
                        ->where('userid_1',$userid)
                        ->where('userid_2',$this->session->userdata['userid'])
                        ->update('connect', $data);

                // set notification for request connection
                //return the ID of the event
                $return['set_notification'] = false;
                $return['event_id'] = $row->ID;
                // $return['contentid'] = $row->contentid;

                return $return;
            }
        } else {

            //there is no connection so  create a relation then set a notificaton
            // to request connection
            $data = array('connectstatus' => 0, 'userid_1' => $this->session->userdata['userid'], 'userid_2' => $userid);
            $this->db->insert('connect', $data);

            $return['set_notification'] = true;
            $return['event_id'] = $this->db->insert_id();
            //$return['contentid'] = $row->contentid;
            return $return;
        }
    }

    /**
     * Method to check if the logged in user is following a specific user
     * @param <int> $userid the userid to check if the logged in user is following
     * @return <bool> return true or false depending on the follow status
     */
    public function check_track($userid = 0) {
        if ($userid > 0) {
            $this->db->select('followstatus')
                    ->from('follow')
                    ->where('userid_1 = ', $this->session->userdata['userid'])
                    ->where('userid_2 = ', $userid);
            $result = $this->db->get();
            if ($result->num_rows()) {
                $values = $result->row_array();
                return $this->connect_track_status($values['followstatus']);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Method to check if a user id passed is following the logged in user so that a mutual connection can be asserted and then
     * set it up as a high priority to request connection if not doing so
     *
     *
     */
    public function check_user_trackback($userid = 0) {

        if ($userid > 0) {
            $this->db->select('followstatus')
                    ->from('follow')
                    ->where('userid_1 = ', $userid)
                    ->where('userid_2 = ', $this->session->userdata['userid']);
            $result = $this->db->get();
            if ($result->num_rows()) {
                $values = $result->row_array();
                return $this->connect_track_status($values['followstatus']);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Method to check if the logged in user is connected to a specific user
     * @param <int> $userid the userid to check if the logged in user is following
     * @return <bool> return true or false depending on the follow status
     */
    public function check_connect($userid = 0) {
        if ($userid > 0) {
            $userid = $this->db->escape($userid);
            $this->db->select('connectstatus')
                    ->from('connect')
                    ->where('(userid_1 = ' . $userid . ' and userid_2 = ' . $this->session->userdata['userid'] . ' and connectstatus = 1)', NULL, false)
                    ->or_where('(userid_2 = ' . $userid . ' and userid_1 = ' . $this->session->userdata['userid'] . ' and connectstatus = 1)', NULL, false);
            $result = $this->db->get();
            if ($result->num_rows()) {
                $values = $result->row_array();
                return $this->connect_track_status($values['connectstatus']);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Method to check whether the logged in user is either connected to or following a certain user
     * @param <int> $userid the userid to check if the logged in user is following
     * @return <bool> Indicate that the logged in user is either following or connected to a certain user
     */
    public function check_track_connect($userid = 0) {
        return ($this->check_track($userid) || $this->check_connect($userid));
    }

    /**
     * Function to ensure a true/false value is returned when checking for a connect or follow status
     * @param <int> $status value to indicate whether user is following or connected to another user
     * @return <bool> return true or false depending on the connect or follow status
     */
    function connect_track_status($status = null) {
        if (isset($status)) {
            return $status;
        } else {
            return false;
        }
    }

    public function get_userdetails($userid = 0) {
        if ($userid) {
            if (is_array($userid)) {
                $this->db->select('firstname,lastname,userid')
                        ->from('people')
                        ->where_in('userid', $userid);
            } else {
                $this->db->select('firstname,lastname,userid')
                        ->from('people')
                        ->where('userid', $userid);
            }
            $result = $this->db->get();
            if ($result->num_rows()) {
                return $result->result_array();
            }
        }
        return false;
    }

}

/* End of file realtion_model.php */
/* Location: ./system/application/model/relation_model.php */