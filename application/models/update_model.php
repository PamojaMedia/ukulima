<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
/**
 * This class was made by Moses Mutuku
 *
 * 1. View All Updates
 *      This method is for viewing all updates
 *
 * 2. View an Update
 *      This method is for viewing a particular update (mainly accessed when a user views notifications or read more comments)
 *      and displays the form for making a comment
 *
 * 3. Create Update
 *      This method is for validating and creating an update or comment
 *
 * 4. Comment on Update
 *      This method is for validating and creating a comment for an update
 *
 * 5. Delete Update
 *      This method is for deleting an update or a comment.
 *
 * 6. User Status
 *      This method is for checking if a user is registered and active. It wont stay here for too long
 *
 * 7. Content Owner
 *      This method is for getting the owner of a comment or update
 *
 */
class Update_model extends CI_Model
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
        $this->db->select('ID,update,parentid')
                ->from('updates')
                ->where('parentid = ',0)
                ->where('deleted = ',0)
                ->where('(userid = '.$userid.' OR ownersid = '.$userid.
                        ' OR userid IN (select userid_2 from connect where userid_1 = '.$userid.' and connectstatus = 1)'.
                        ' OR userid IN (select userid_1 from connect where userid_2 = '.$userid.' and connectstatus = 1)'.
                        ' OR userid IN (select userid_2 from follow where userid_1 = '.$userid.' and followstatus = 1))')
                ->limit(20)
                ->order_by("date","desc");
        $updates = $this->db->get()->result_array();

        // array to hold all updates and comments to be displayed
        $final_result = array();

        // loop through the updates and get the comments
        foreach($updates as $update) {
            $this->db->select('ID,update,parentid')
                    ->from('updates')
                    ->where('deleted = ',0)
                    ->where('parentid = ',$update['ID'])
                    ->limit(3)
                    ->order_by("parentid","desc")
                    ->order_by("date","asc");
            $comments = $this->db->get();
            // push the current update into the final result array
            array_push($final_result,$update);

            // if the update has comments
            if($comments->num_rows() > 0) {
                // add these comments to the final result array
                $final_result = array_merge_recursive($final_result,$comments->result_array());
            }
        }

        // return the final result
        return $final_result;
    }

    /**
     * Method to view a specific update and it's comments
     * @param <int> $updateid the id of the update to to display
     * @return <array> the array containing the update and the comments
     */
    public function view($updateid = 0)
    {
        // select the id, update, parentd of the updates and comments and ensure it's not been deleted
        $this->db->select('ID,update,parentid')
                ->from('updates')
                ->where('deleted = ',0)
                ->where('ID = ',$updateid)
                ->or_where('parentid =',$updateid)
                ->order_by("ID");
        // get the array of results
        $updates = $this->db->get()->result_array();

        // return the result
        return $updates;
    }

    /**
     * The method for insterting an update into the db
     * @param <string> $text the update to post
     * @param <int> $id the ownersid  if a user is updating on someone else's wall
     * @return <bool> return success or fail
     */
    public function create($text = '', $id = 0)
    {
        // if the update is not empty
        if($text != '') {
            // setup the data to be input
            $data = array(
                   'update' => $text ,
                   'userid' =>  $this->session->userdata['userid'],
                   'ownersid' => $id,
                   'date' => time()
                );
            // insert the data
            $this->db->insert('updates', $data);
            // return the effect (will return 0 (false) if insert failed)
            return $this->db->affected_rows();
        }
        else {
            // if update is empty, just return false
            return false;
        }
    }

    /**
     * The method for insterting an update into the db
     * @param <int> $updateid the id of the update that the comment is written for
     * @param <string> $text the comment to post
     * @return <bool> return success or fail
     */
    public function comment($updateid = 0, $text = '')
    {
        // if the update is not empty and there is an update specified
        if($updateid!=0 && $text != '') {
            // setup the data to be input
            $data = array(
                   'update' => $text ,
                   'userid' =>  $this->session->userdata['userid'],
                   'parentid' => $updateid,
                   'date' => time()
                );
            // insert the data
            $this->db->insert('updates', $data);
            // return the effect (will return 0 (false) if insert failed)
            return $this->db->affected_rows();
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
        // if the update/comment has been specified
        if($id!=0) {
            // check if the update exists and get it's details
            $this->db->select('parentid')
                ->from('updates')
                ->where('ID = ',$id);
            $update = $this->db->get()->row_array();

            // setup the data to be set
            $data = array(
                   'deleted' => 1
                );

            // set the data if the logged in userid is in the update/comments userid or ownersid values
            $this->db->where('ID = ', $id)
                ->where('(userid = '.$this->session->userdata['userid'].' or ownersid = '.$this->session->userdata['userid'].')',NULL,false)
                ->update('updates',$data);

            // if that did not work, and it's a comment that is being deleted (only go through this part if comment, not update, is being deleted)
            if(!$this->db->affected_rows() && $update['parentid'] > 0) {
                // get the userid and ownersid of the update the comment is for if the userid or ownersid of the update are the logged in user
                $this->db->select('userid,ownersid')
                    ->from('updates')
                    ->where('ID = ',$update['parentid'])
                    ->where('(userid = '.$this->session->userdata['userid'].' or ownersid = '.$this->session->userdata['userid'].')',NULL,false);
                $up_parent = $this->db->get();

                // if the row is found then delete the comment
                if($up_parent->num_rows()) {
                    $this->db->where('ID = ', $id)
                        ->update('updates',$data);
                }
            }

            // create an array indicating whether it was a comment/update and whether the process was successful
            return array(
                    'type' => $update['parentid'],
                    'success' => $this->db->affected_rows()
                );
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

    public function content_owner($contentid = 0) {

        if($contentid > 0) {
            
            $this->db->select('userid,ownersid')
                ->from('updates')
                ->where('ID = ',$contentid)
                ->where('deleted = ',0);
            $updates = $this->db->get();

            if($updates->num_rows()) {
                $result = $updates->row_array();
                if($result['ownersid'] > 0) {
                    return $result['ownersid'];
                }
                else {
                    return $result['userid'];
                }
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