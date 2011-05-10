<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 *
 * class made by Moses Mutuku
 *
 * 1. All - function for viewing all notifications for the user
 *
 * 2. Noted - function to mark notifications as having been displayed
 *
 * 3. Set_notification - function to set a notification for a user
 *
*/

class Notification_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }


    /**
     * This method is to get all notifications for the user
     *
     * @return array with all the notifications for the user
     */

    public function all() {
        $this->db->select('causeid,contentid')
                ->from('notifications')
                ->where('userid', $this->session->userdata['userid'])
                ->where('status',0)
                ->order_by('causeid','desc')
                ->order_by('ID','desc');
        $result = $this->db->get()->result_array();

        if (count($result)) {
            $this->load->config('notifications');
            $notifications = $this->config->item('site_notifications');
            $msgs = array();
            $updates = array();
            $comments = array();
            foreach($result as $note) {
                if($notifications[$note['causeid']] == 'update') {
                    $updates[] = $note['contentid'];
                }
                elseif($notifications[$note['causeid']] == 'message') {
                    $msgs[] = $note['contentid'];
                }
                elseif($notifications[$note['causeid']] == 'comment') {
                    $comments[] = $note['contentid'];
                }
            }

            if(count($updates)) {
                $this->db->select('firstname,lastname,people.userid,ID')
                        ->from('people,updates')
                        ->where_in('ID',$updates)
                        ->where('people.userid = updates.userid')
                        ->order_by('ID','desc');
                $result = $this->db->get()->result_array();
                if(count($result)) {
                    foreach($result as $note) {
                        $note['type'] = $notifications['update'];
                        $site_notifications[] = $note;
                    }
                }
            }

            if(count($comments)) {
                $this->db->distinct()
                        ->select('firstname,lastname,people.userid,parentid as ID')
                        ->from('people,updates')
                        ->where_in('ID',$comments)
                        ->where('people.userid = updates.userid')
                        ->order_by('parentid');
                $result = $this->db->get()->result_array();
                if(count($result)) {
                    foreach($result as $note) {
                        $note['type'] = $notifications['comment'];
                        $site_notifications[] = $note;
                    }
                }
            }

            if(count($msgs)) {
                $this->db->select('firstname,lastname,people.userid,ID,parentid')
                        ->from('people,messages')
                        ->where_in('ID',$msgs)
                        ->where('people.userid = messages.userid');
                $result = $this->db->get()->result_array();
                if(count($result)) {
                    foreach($result as $note) {
                        $note['type'] = $notifications['message'];
                        $note['ID'] = $note['parentid'] ? $note['parentid'] : $note['ID'];
                        $site_notifications[] = $note;
                    }
                }
            }

            if(count($site_notifications)) {
                return $site_notifications;
            }
            else {
                return false;
            }
        }

        return false;

    }

    /**
     * Function to set the user notifications as having been viewed
     * @return <bool> indicate whether the process was successful
     */

    public function noted($contentid = 0, $causeid = 0) {

        if($contentid > 0 && $causeid > 0) {

            $notifications = $this->config->item('site_notifications');

            if($notifications['update'] == $causeid) {
                $this->db->select('notifications.ID')
                        ->from('notifications,updates')
                        ->where('(updates.parentid = '.$contentid.' or updates.ID = '.$contentid.')','',false)
                        ->where('notifications.contentid = updates.ID','',false)
                        ->where('notifications.userid',$this->session->userdata['userid']);
                $results = $this->db->get();
            }

            if($notifications['message'] == $causeid) {
                $this->db->select('notifications.ID')
                        ->from('notifications,messages')
                        ->where('messages.parentid',$contentid)
                        ->where('notifications.contentid = messages.ID','',false)
                        ->where('notifications.userid',$this->session->userdata['userid']);
                $results = $this->db->get();
            }

            if($results->num_rows()) {
                foreach($results->result_array() as $result) {
                    $ids[] = $result['ID'];
                }

                $data = array (
                    'status' => 1
                );
                $this->db->where_in('id',$ids)
                    ->update('notifications',$data);

                return $this->db->affected_rows();

            }

            return true;

        }
    }

    /**
     * Function to set a notification for a user
     * @param <int> $causeid variable to indicate the type of content
     * @param <int> $contentid variable to indicate the id of the content the user is to be notified about
     * @param <int> $userid variable to indicate the id of the user to be notified
     * @return <bool> value to indicate if the process was successful
     */
    public function set_notification($causeid = 0 , $contentid = 0, $userid = 0) {

        if($causeid != 0 && $contentid != 0 && $userid != 0) {

            $notifications = $this->config->item('site_notifications');

            if($notifications['comment'] == $causeid) {
                $this->db->select('userid,ownersid')
                        ->from('updates')
                        ->where('(id = (select parentid from updates where ID = '.$contentid.') or parentid = (select parentid from updates where ID = '.$contentid.') )')
                        ->where('userid !=',$this->session->userdata['userid'])
                        ->where('deleted',0);
                $result = $this->db->get();

                $values = '';

                if($result->num_rows()) {

                    $users = $result->result_array();

                    if($users[0]['ownersid'] > 0) {
                        $values .= '('.$causeid.','.$contentid.','.$users[0]['ownersid'].'),';
                    }
                    foreach($users as $user) {
                        $values .= '('.$causeid.','.$contentid.','.$user['userid'].'),';

                    }
                    $values = substr($values,0,-1);

                    $this->db->query('INSERT INTO notifications (causeid, contentid,userid) VALUES '.$values);

                    return $this->db->affected_rows();
                }
                else {

                    if($userid == $this->session->userdata['userid']) {
                        return true;
                    }

                    else {

                        $data = array (
                                'causeid' => $causeid,
                                'contentid' => $contentid,
                                'userid' => $userid
                        );

                        $this->db->insert('notifications',$data);

                        return $this->db->affected_rows();

                    }

                }

            }

            elseif($notifications['message'] == $causeid) {

                $values = '';

                foreach($userid as $user) {

                    if($user != $this->session->userdata['userid']) {

                        $values .= '('.$causeid.','.$contentid.','.$user.'),';

                    }

                }

                if(strlen($values)) {

                    $values = substr($values,0,-1);

                    $this->db->query('INSERT INTO notifications (causeid, contentid,userid) VALUES '.$values);

                    return $this->db->affected_rows();

                }

                else {

                    return true;

                }

            }

            else {

                $data = array (
                        'causeid' => $causeid,
                        'contentid' => $contentid,
                        'userid' => $userid
                );

                $this->db->insert('notifications',$data);

                return $this->db->affected_rows();

            }


        }

        return false;

    }


}

/* End of file realtion_model.php */
/* Location: ./system/application/model/relation_model.php */