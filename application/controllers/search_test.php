<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

 class Search_test extends CI_Controller{

     function __construct() {
        parent::__construct();

        $this->load->library('search');
        
     }

     function index(){
     $result = $this->search->query('eva');
     if($result){
         $result = json_decode($result);
         echo $result->id;
     }
     }

 }
?>
