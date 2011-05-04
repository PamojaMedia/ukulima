<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
/**
 * This class was made by Moses Mutuku
 *
 * 1. View All Messages
 *      This method is for viewing all messages. Has pagination already built in
 *
 * 2. View a Message
 *      This method is for viewing a particular message and displays the form for replying to the message
 *
 * 3. Create a Message
 *      This method is for validating and creating a message
 *
 * 4. Reply to Message
 *      This method is for validating and creating a reply to a message
 *
 * 5. Delete Message
 *      This method is for deleting a message. It only removes for the particular user who is deleting it.
 *
 * 6. User Status
 *      This method is for checking if a user is registered and active. It wont stay here for too long
 *
 */
class Messaging_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Method for recent updates and comments from specific user
     * @param <int> $userid the userid of the user to get updates and comments from
     * @return <array> an array containing the updates and comments
     */
    public function all($userid = 0)
    {
        // select id, update & parentid of updates from selected user. the updates should not be deleted.
        // either the user wrote the update or it was written on his wall.
        // limit them to 20

        $this->db->distinct()
                ->select('messages.ID as ID,message_receivers.ID as msgid,subject,content,parentid')
                ->from('messages, message_receivers')
                ->where('parentid = ',0)
                ->where('message_receivers.msgid = messages.ID','',false)
                ->where('message_receivers.userid = ',$userid)
                ->where('message_receivers.deleted = ',0)
                ->limit(20)
                ->order_by("date","desc");
        $result = $this->db->get();
        if($result->num_rows()) {
            return $result->result_array();
        }
        else {
            return array();
        }
    }

    /**
     * Method to view a specific update and it's comments
     * @param <int> $updateid the id of the update to to display
     * @return <array> the array containing the update and the comments
     */
    public function view($msgid = 0,$userid = 0)
    {
        $this->db->select('message_receivers.deleted,parentid')
                ->from('message_receivers,messages')
                ->where('messages.ID = ',$msgid)
                ->where('msgid = messages.ID','',false)
                ->where('message_receivers.userid = ',$userid);
        $result = $this->db->get();

        $msg = $result->row_array();

        if($result->num_rows() && !$msg['deleted'] && !$msg['parentid']) {

            // select the id, update, parentid of the messages and replies and ensure it's not been deleted
            $this->db->select('messages.ID as ID,message_receivers.ID as msgid,subject,content,parentid')
                    ->from('messages, message_receivers')
                    ->where('(messages.ID = '.$msgid.' OR messages.parentid = '.$msgid.')','',false)
                    ->where('message_receivers.msgid = messages.ID','',false)
                    ->where('message_receivers.userid = ',$userid)
                    ->where('message_receivers.deleted = ',0);
            // get the array of results
            $updates = $this->db->get()->result_array();

            // return the result
            return $updates;

        }
        else {
            return false;
        }
    }

    /**
     * This method is for creating a message and setting it's receivers
     * @param <int[]> $receivers array of the ids of the receivers
     * @param <string> $subject string for the subject of the message
     * @param <string> $content string for the content of the message
     * @return <bool> boolean value indicating if message was successfuly created
     */
    public function create($receivers = array(), $subject = '', $content = '', $msgid = 0)
    {
        // if the update is not empty
        if(count($receivers) && $content != '') {
            // setup the data to be input
            $data = array(
                   'subject' => $subject,
                   'content' => $content,
                   'userid' =>  $this->session->userdata['userid'],
                   'parentid' => $msgid,
                   'date' => time()
                );
            // insert the data
            $this->db->insert('messages', $data);
            
            // get the ID of the message that was created
            $this->db->select('ID')
                ->from('messages')
                ->where('userid = ',$this->session->userdata['userid'])
                ->order_by("ID",'desc')
                ->limit(1);
            // get the array of results
            $msg = $this->db->get()->row_array();

            // if the message is found, create the receivers
            if($msg['ID']) {

                foreach($receivers as $receiver) {

                    $data = array(
                           'msgid' => $msg['ID'],
                           'userid' =>  $receiver
                        );
                    // insert the data
                    $this->db->insert('message_receivers', $data);

                }

            }
            // return the effect (will return 0 (false) if insert failed)
            return $this->db->affected_rows();
        }
        else {
            // if parameters are empty, return false
            
            return false;
        }
    }

    /**
     * The method for insterting an update into the db
     * @param <int> $updateid the id of the update that the comment is written for
     * @param <string> $text the comment to post
     * @return <bool> return success or fail
     */
    public function reply_receivers($msgid = 0)
    {
        // if the update is not empty and there is an update specified
        if($msgid!=0) {
            // get the ID of the message that was created
            $this->db->select('userid')
                ->from('message_receivers')
                ->where('deleted = ',0)
                ->where('msgid = ',$msgid);
            // get the array of results
            $receivers = $this->db->get();

            if($receivers->num_rows()) {
                foreach($receivers->result_array() as $receiver) {
                    $result[] = $receiver['userid'];
                }
                return $result;
            }
            else {
                return false;
            }
        }
        else {
            // if comment is empty or update is not specified, just return false
            return false;
        }
    }

    /**
     * Method to delete an update or comment
     * @param <type> $id the id of the update or comment
     * @return <type> success or failure indication
     */
    public function delete($id = 0)
    {
        // if the message has been specified
        if($id!=0) {
            // setup the data to be set
            $data = array(
                   'deleted' => 1
                );

            // set the data if the logged in userid is in the update/comments userid or ownersid values
            $this->db->where('ID = ', $id)
                ->where('userid = '.$this->session->userdata['userid'])
                ->update('message_receivers',$data);

            return $this->db->affected_rows();
        }
        else { // if no update/comment is specified, return false
            return false;
        }
    }

    public function user_status($id = 0) {
        $this->db->select('userstatus')
                ->from('people')
                ->where('userid = ',$id);
        $updates = $this->db->get();

        if($updates->num_rows()) {
            $result = $updates->row_array();
            return ($result['userstatus']==0)?true:false;
        }
        else {
            return false;
        }
    }

    public function friends($query = '') {
        if($query != '') {
            $this->db->select('userid,firstname,lastname')
                    ->from('people')
                    ->where('(firstname like "%'.$query.'%" or lastname like "%'.$query.'%" )','',false)
                    ->where('(userid in (select userid_1 from connect where userid_2 = '.$this->session->userdata['userid'].' and connectstatus = 1)'.
                            'or userid in (select userid_2 from connect where userid_1 = '.$this->session->userdata['userid'].' and connectstatus = 1))','',false);
            $updates = $this->db->get();

            if($updates->num_rows()) {
                return $updates->result_array();
            }
            else {
                return false;
            }
        }
        else {
            return false;
        }
    }

    public function can_reply($msgid) {

        if($msgid > 0) {
            
            $this->db->select('messages.ID')
                ->from('messages,message_receivers')
                ->where('((messages.ID = '.$msgid.' and messages.userid = '.$this->session->userdata['userid'].')'.
                        ' OR (message_receivers.userid = '.$this->session->userdata['userid'].' and message_receivers.msgid = '.$msgid.
                        ' and message_receivers.deleted = 0 and messages.ID = message_receivers.msgid))','',false);
            $msgs = $this->db->get();

            if($msgs->num_rows()) {
                return true;
            }
            else {
                return false;
            }
        }
        else {
            return false;
        }
    }
} 
/* End of file update_model.php */
/* Location: ./system/application/model/update_model.php */