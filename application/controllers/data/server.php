<?php
/* 
 *Ukulima.net API will serve its data through a rest API
 * This
 */
require APPPATH.'/libraries/REST_Controller.php';

 class Server extends REST_Controller{

    function userprofile_get()
    {
        if(!$this->get('id'))
        {
        	$this->response(array('error' => 'User ID is not specified!'), 400);
        }
         $this->load->model('api_relation_model');
         $users = $this->api_relation_model->profile($this->get('id')); // frofile parameter is supposed to be passed

         if($users)
        {
            $this->response($users, 200); // 200 being the HTTP response code
        }

        else
        {
            $this->response(array('error' => 'Couldn\'t find any users!'), 404);
        }

    }

    function userfollows_get(){
        if(!$this->get('id')){
            $this->response(array('error' => 'User ID not specified!'), 400);
        }
        $this->load->model('api_relation_model');
        $this->api_relation_model->profile_users_follow($this->get('id')); // frofile parameter is supposed to be passed
        $users = $this->api_relation_model->follow_1;

         if($users)
        {
            $this->response($users, 200); // 200 being the HTTP response code
        }

        else
        {
            $this->response(array('error' => 'Couldn\'t find any users!'), 404);
        }
    }

    function userconnected_get(){
        if(!$this->get('id')){
            $this->response(array('error' => 'User ID not specified!!'),400);
        }
        $this->load->model('api_relation_model');
        $this->api_relation_model->profile_users_connect($this->get('id')); // frofile parameter is supposed to be passed
        $users = $this->api_relation_model->connection_1;

         if($users)
        {
            $this->response($users, 200); // 200 being the HTTP response code
        }

        else
        {
            $this->response(array('error' => 'Couldn\'t find any users!'), 404);
        }

    }

    function usermessages_get(){
        if(!$this->get('id')){
            $this->response(array('error' => 'User ID not specified!!'),400);
        }

        $this->load->model('api_messaging_model');
        
        $messages = $this->api_messaging_model->get(0, 10, $this->get('id')); // frofile parameter is supposed to be passed

         if($messages)
        {
            $this->response($messages, 200); // 200 being the HTTP response code
        }

        else
        {
            $this->response(array('error' => 'No messages!'), 404);
        }

    }

    function userupdates_get(){
        if(!$this->get('id')){
            $this->response(array('error' => 'User ID not specified!!'), 400);
        }
        $this->load->model('api_update_model');

        $updates = $this->api_update_model->all($this->get('id')); // frofile parameter is supposed to be passed

         if($updates)
        {
            $this->response($updates, 200); // 200 being the HTTP response code
        }

        else
        {
            $this->response(array('error' => 'No messages!'), 404);
        }
    }

    function followuser_post(){
        if(!$this->get('id')){
            $this->response(array('error' => 'User ID not specified!!'), 400);
        }

        if(!$this->post('followid')){
            $this->response(array('error' => 'follow ID not specified!!'), 400);
        }

        $this->load->model('api_relation_model');

        $follow = $this->api_relation_model->follow_user($this->get('id'), $this->post('followid')); // frofile parameter is supposed to be passed

         if($follow)
        {
            $this->response(array('Success' => 'User '.$this->get('id').' is now tracking user '.$this->post('followid')), 200); // 200 being the HTTP response code
        }

        else
        {
            $this->response(array('error' => 'Tracking unsuccessful.'), 404);
        }
    }

    function sendmessage_post(){
        if(!$this->get('id')){
            $this->response(array('error' => 'User ID not specified!! '));
        }

        if($this->post('receivers') == '' || $this->post('content') == '' ){
            $this->post(array('error' => 'Missing receivers and(or) content!'));
        }
         
        $receivers = array();
        $receivers[0] = $this->post('receivers');
        
          $this->load->model('api_messaging_model');

        $send = $this->api_messaging_model->create($this->post('receivers'), $this->post('subject'), $this->post('content'), 0, $this->get('id')); // frofile parameter is supposed to be passed

         if($send)
        {
            $this->response(array('Success' => 'Message Sent!'), 200); // 200 being the HTTP response code
        }

        else
        {
            $this->response(array('error' => 'Message not sent.'), 404);
        }


    }

    function update_post(){
        //@variable
        $ownerid = 0;

        if(!$this->get('id')){
            $this->response(array('error' => 'User ID not specified!!'), 400);
        }
        if(!$this->post('text')){
            $this->response(array('error' => 'Update text not specified!!'), 400);
        }

        if(!$this->post('ownerid')){
            $ownerid = 0;
        }else {
            $ownerid = $this->post('ownerid');
        }


          $this->load->model('api_update_model');

        $update = $this->api_update_model->create($this->post('text'), $this->get('id'), $ownerid); // frofile parameter is supposed to be passed

         if($update)
        {
            $this->response(array('Success' => 'Update posted!'), 200); // 200 being the HTTP response code
        }

        else
        {
            $this->response(array('error' => 'Update not posted.'), 404);
        }
    }

 }
?>
