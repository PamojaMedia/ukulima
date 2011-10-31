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
class Details_model extends CI_Model {
    
    public function __construct() {
        
        parent::__construct();
        
    }
    
    public function get_all() {
        
        $result = $this->db->select('firstname,lastname,email,phonenum')
                                ->from('people')
                                ->get();
        
        if($result->num_rows()) {
            return $result->result_array();
        }
        
        return false;
        
    }
    
}
/* End of file send_model.php */
/* Location: ./system/application/model/update_model.php */