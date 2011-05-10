<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class was made by Moses Mutuku
 *
 * 1. Get Messages
 *      This method is for retreiving messages.
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
 * 7. User Message Details
 *      This method is used to get details of the users messages
 *
 *
 */
class Messaging_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    /**
     * Method for recent updates and comments from specific user
     * @param <int> $start the index from where to start getting messages
     * @param <int> $count the number of messages to be retreived
     * @return <array> an array containing the updates and comments
     */
    public function get($start = 0, $count = 10) {
        // select id, update & parentid of updates from selected user. the updates should not be deleted.
        // either the user wrote the update or it was written on his wall.
        // limit them to the number passed in the parameters

        $this->db->distinct()
                ->select('messages.ID as ID,message_receivers.ID as msgid,subject,content,parentid,firstname,lastname,people.userid')
                ->from('messages, message_receivers, people')
                ->where('parentid = ',0)
                ->where('message_receivers.msgid = messages.ID','',false)
                ->where('message_receivers.deleted = ',0)
                ->where('message_receivers.userid = ',$this->session->userdata['userid'])
                ->where('people.userid = messages.userid','',false)
                ->limit($count,$start)
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
     * Method to view a specific message and it's replies
     * @param <int> $updateid the id of the update to to display
     * @return <array> the array containing the update and the comments
     */
    public function view($msgid = 0,$userid = 0) {
        $this->db->select('message_receivers.deleted,parentid')
                ->from('message_receivers,messages')
                ->where('messages.ID = ',$msgid)
                ->where('msgid = messages.ID','',false)
                ->where('message_receivers.userid = ',$userid)
                ->where('message_receivers.deleted',0);
        $result = $this->db->get();

        $msg = $result->row_array();

        if($result->num_rows() && !$msg['parentid']) {

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
    public function create($receivers = array(), $subject = '', $content = '', $msgid = 0) {
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
            $this->db->select_max('ID')
                    ->from('messages')
                    ->where('userid = ',$this->session->userdata['userid'])
                    ->order_by("ID",'desc')
                    ->limit(1);
            // get the array of results
            $msg = $this->db->get()->row_array();

            // if the message is found, create the receivers
            if($msg['ID']) {

                $values = '';

                foreach($receivers as $receiver) {
                    $values .= '('.$msg['ID'].','.$receiver.'),';

                }
                $values = substr($values,0,-1);

                $this->db->query('INSERT INTO message_receivers (msgid,userid) VALUES '.$values);

            }
            // return the effect (will return 0 (false) if insert failed)
            if($this->db->affected_rows()) {
                return $msg['ID'];
            }
        }
        else {
            // if parameters are empty, return false

            return false;
        }
    }

    /**
     * The method for getting the receivers of a reply to a message
     * @param <int> $msgid the id of the update that the comment is written for
     * @param <string> $text the comment to post
     * @return <bool> return success or fail
     */
    public function reply_receivers($msgid = 0) {
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
    public function delete($id = 0) {
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

    /**
     *
     * @param <type> $id the
     * @return <type>
     */
    public function user_status($id = 0) {
        $this->db->select('userstatus')
                ->from('people')
                ->where('userid = ',$id);
        $msgs = $this->db->get();

        if($msgs->num_rows()) {
            $result = $msgs->row_array();
            return ($result['userstatus']==0)?true:false;
        }
        else {
            return false;
        }
    }


    /**
     * Function used to get the users that the logged in user is connected to
     * @param <type> $query a string indicating either the first or last name of the user
     * @return <type> an array of the user's details or false if the user is not connected to anyone
     */
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

    /**
     * Function to check if a user can reply to a message
     * @param <type> $msgid the id of the message that the logged in user is trying to reply to
     * @return <type> true/false indicating whether the user can reply
     */
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

    /**
     * Function to get the user's msg details. This shall grow with time.
     * Right now it just get's the number of messages for the sake of pagination.
     * @return <type> false if there's no result, otherwise it will return an array of msg details
     */
    public function user_msg_details() {

        $this->db->select('count(userid) as num')
                ->from('message_receivers')
                ->where('userid = '.$this->session->userdata['userid'])
                ->where('deleted',0);

        $result = $this->db->get();

        if($msg_details->num_rows()) {
            $msg_details = $result->result_array();
            return $msg_details['num'];
        }
        else {
            return false;
        }

    }
}
/* End of file update_model.php */
/* Location: ./system/application/model/update_model.php */