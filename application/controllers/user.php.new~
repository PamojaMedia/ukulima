<?php
/**
 * This area will contain all the areas that a logged in user will need starting with profile
 * updates, comments, messages, follow , unfollow, connect, disconnect, notification and settings
 *
 * Enough talk, the good stuff is below
 */

class user extends CI_Controller{
       /**
     * constructor
     */
private $tpl;

public $data = array();

public $receivers = array();

    function __construct()
	{
		parent::__construct();
                $this->load->model('redux_auth_model');
                $this->load->model('relation_model');
                $this->tpl = $this->redux_auth->template_choose();
                
	}
	/**
	 * index
	 *
	 * @return void
	 * @author Mathew
	 **/
	function index()
	{
            if($this->redux_auth->logged_in())
            {
                redirect('user/profile');
            }
            else{
		redirect('auth/login');
            }
	}


        function profile()
        {

           
            if ($this->redux_auth->logged_in())
	    {
	         $data['profile'] = $this->redux_auth->profile();

                 /**
                  *  I have put all the connections, follows, and proposed follows
                  * and proposed connections
                  *
                  * But we can separate them in different functions is there is a need for them
                  *
                  */
                 $data['users_connections'] =$this->relation->users_connections();
                 $data['users_follows'] = $this->relation->users_follows();
                 $data['suggest_connect'] = $this->relation->suggest_connect();
                 $data['suggest_follow'] = $this->relation->suggest_follow();
                 $data['priority_suggest_connect'] = $this->relation->suggest_connect_mutual();

                 $data['update_user'] = $this->update->all();
                 $this->data['content'] = $this->load->view('user/profile', $data, true);
	        $this->load->view($this->tpl,  $this->data);
	    }
	    else
	    {
	        redirect('auth/login');
	    }
        }

        function update_create($id=0)
        {

        if($id===0)
            {
                $this->update->create();
                
            }
        else
            {
             $this->update->create($id);
            }

        }

         /**
         *  Comment on an update
         *
         */

        function update_comment()
        {
            $this->update->comment();
        }

        /**
         * Deleting an update
         */

        function update_delete($content_id=0)
        {
            if($content_id===0)
            {
                $this->update->delete();
            }

            else
            {
                $this->update->delete($content_id);
            }
        }

        /**
         * Retrieve a selected users update
         *@param <int> the selected users id
         */

        function update_selected($userid)
        {
            return $this->update->selected($userid);

        }
        /**
         * Retrieves all the messages from a user and a form to create mesages
         */

        function messaging_all()
        {

          
             if ($this->redux_auth->logged_in())
	    {
	         $data['profile'] = $this->redux_auth->profile();
                 $data['users_connections'] =$this->relation->users_connections();
                 $data['users_follows'] = $this->relation->users_follows();
                 $data['suggest_connect'] = $this->relation->suggest_connect();
                 $data['suggest_follow'] = $this->relation->suggest_follow();

                 $data['message_user'] = $this->messaging->all();
                 $this->data['content'] = $this->load->view('user/profile', $data, true);
	        $this->load->view($this->tpl,  $this->data);
            }
              else
	    {
	        redirect('auth/login');
	    }
         
        }

        /**
         * Method to view a particular message and its replies
         *
         * @param <int> message id tp pass to the library function
         */

        function message_view($msgid = 0)
        {
             
             if ($this->redux_auth->logged_in())
	    {
	         $data['profile'] = $this->redux_auth->profile();
                 $data['users_connections'] =$this->relation->users_connections();
                 $data['users_follows'] = $this->relation->users_follows();
                 $data['suggest_connect'] = $this->relation->suggest_connect();
                 $data['suggest_follow'] = $this->relation->suggest_follow();

                 $data['message_view'] = $this->messaging->view($msgid);
                 $this->data['content'] = $this->load->view('user/profile', $data, true);
	        $this->load->view($this->tpl,  $this->data);
            }
              else
	    {
	        redirect('auth/login');
	    }

        }

        /**
         * Function to place the compose form at any place of the site, just the compose
         * form
         *
         */
        function message_compose()
        {
             
             if ($this->redux_auth->logged_in())
	    {
	         $data['profile'] = $this->redux_auth->profile();
                 $data['users_connections'] =$this->relation->users_connections();
                 $data['users_follows'] = $this->relation->users_follows();
                 $data['suggest_connect'] = $this->relation->suggest_connect();
                 $data['suggest_follow'] = $this->relation->suggest_follow();
                 
                 $data['message_compose'] = $this->messaging->compose();
                 $this->data['content'] = $this->load->view('user/profile', $data, true);
	        $this->load->view($this->tpl,  $this->data);
            }
              else
	    {
	        redirect('auth/login');
	    }
        }

        /**
         * Function to delete user messages
         *
         */

        function messaage_delete($msgid = 0)
        {
            if($msgid===0)
            {
                $this->messaging->delete();

            }
            else
            {
                $this->messaging->delete($msgid);
            }
        }

        function message_create()
        {
            $this->messaging->create();
        }

        /**
         * When composing message this function lists the users friends, FACEBOOK STYLE!!!!
         *
         */
        function message_friend()
        {
            $this->messaging->friends();
        }

        function message_reply($msgid)

        {
            $this->messaging->reply($msgid);
        }


        function follow_user($id)
        {
            $return =  $this->relation->follow($id);
            $this->profile();
        }

    /*
     * This function was put here due to very bad programming paradigms so kids 
     * DONT TRY THIS
     * The reason the message validate receivers was put here instead of the library
     * is because the callback function cannot be placed outside of its usage controller
     * 
     * so just imagine it being there, IMAGINE!!!
     * alright the rest works so be happy
     * 
     */

        public function validate_receivers($receivers)
    {
        $the_receivers = explode(',',$receivers);
        foreach($the_receivers as $receiver) {
            $receiver = trim($receiver);
            if(!preg_match('/[0-9]/',$receiver) || !$this->relation_model->check_connect($receiver)) {

                $this->form_validation->set_message('validate_receivers','Cannot send your message to some of your receiver(s)');
                return false;
            }
            $this->messaging->receivers[] = $receiver;
        }
        $this->messaging->receivers[] = $this->session->userdata['userid'];
        return true;
    }



}


/* End of file auth.php */
/* Location: ./system/application/controllers/auth.php */