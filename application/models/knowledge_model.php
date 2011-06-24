<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


class Knowledge_model extends CI_Model{
    /**
     * Holds an array of tables used in Ukulima
     *
     *
     * @var string
     * */
    public $tables = array();

     public function __construct() {
        parent::__construct();

        $this->load->config('redux_auth');
        $this->tables = $this->config->item('tables');
        $this->columns = $this->config->item('columns');
    }

}
?>
