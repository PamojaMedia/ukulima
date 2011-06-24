<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


    class Search_model extends CI_Model{
        public function __construct() {
        parent::__construct();
        }

         /**
     * Function used to query the db for users matching a query
     * @param <type> $query a string indicating either the first or last name of the user
     * @return <type> an array of the user's details or false if the user is not connected to anyone
     */
    public function query($query = '') {
        if($query != '') {
            $this->db->select('userid,firstname,lastname')
                    ->from('people')
                    ->where('(firstname like "%'.$query.'%" or lastname like "%'.$query.'%" )','',false);

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
    }
?>
