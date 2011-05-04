<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
/**
* Access Denied Library
*/
class Accessdenied
{
	/**
	 * CodeIgniter global
	 *
	 * @var string
	 **/
	protected $ci;

	/**
	 * __construct
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function __construct()
	{
            $this->ci =& get_instance();
	}
	
	/**
         * Display the access denied page specific to what the viewer wanted to do.
         * @param <int> $action to indicate the action the user was about to do
         */
	public function display_message($action)
	{
            if ($this->ci->agent->is_browser())
            {
                $data['libraries'] =
                    '<script src="//ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js" type="text/javascript"></script>';
                    //.'<script src="//ajax.googleapis.com/ajax/libs/prototype/1.7.0.0/prototype.js" type="text/javascript"></script>'
                    //.'<script src="//ajax.googleapis.com/ajax/libs/scriptaculous/1.8.3/scriptaculous.js" type="text/javascript"></script>';

            }

            $data['denied_message'] = $this->actions($action);
            $data['content'] = $this->ci->load->view('access_denied',$data,true);
            $this->ci->load->view('template',$data);
	}

        /**
         * Returns the access denied message based on the action
         * @param <int> $action
         * @return <string> the access denied message
         */
        private function actions($action) {
            $denied_msg = array (
                'update_all' => 'You are not allowed to view updates',
                'update_selected' => 'You are not allowed this user\'s updates',
                'update_view' => 'You are not allowed to view this update',
                'update_create' => 'You are not allowed to create an update',
                'update_comment' => 'You are not allowed to comment on this update',
                'update_delete' => 'You are not allowed to delete this content',

                'message_all' => 'You are not allowed to view messages',
                'message_compose' => 'You are not allowed to compose a message',
                'message_view' => 'You are not allowed to view this message',
                'message_create' => 'You are not allowed to create a message',
                'message_reply' => 'You are not allowed to comment on this message',
                'message_delete' => 'You are not allowed to delete this message'
                
                );
            return $denied_msg[$action];
        }
		
}
/* End of file Accessdenied.php */
/* Location: ./system/application/libraries/Accessdenied.php */