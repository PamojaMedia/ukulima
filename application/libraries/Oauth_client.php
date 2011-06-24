<?php

/**
 * OAuth 2.0 client for use with the included auth server
 * *
 * @package             CodeIgniter
 * @author              Alex Bilbie | www.alexbilbie.com | alex@alexbilbie.com
 * @copyright   		Copyright (c) 2010, Alex Bilbie.
 * @license             http://codeigniter.com/user_guide/license.html
 * @link                http://alexbilbie.com
 * @version             Version 0.1
 */

class Oauth_client {

	protected $ci;
	public $error = '';
	
	function __construct()
	{
		$this->ci =& get_instance();
		$this->ci->load->config('oauth_client');
	}
	
	/**
	 * Redirects the user to the OAuth sign in page
	 */
	public function sign_in()
	{
		redirect($this->ci->config->item('oauth_signin_url'));
	}
	
	/**
	 * Redirects the user to the OAuth sign out page
	 */
	public function sign_out()
	{
		redirect($this->ci->config->item('oauth_signout_url'));
	}
	
	/**
	 * Exchanges an auth code for an access token
	 * 
	 * @access public
	 * @param string $code
	 * @return string|bool
	 */
	public function get_access_token($code = '')
	{
		$this->ci->load->library('curl');
		$this->ci->curl->option('returntransfer', TRUE);
		
		try
		{
			$url = $this->ci->config->item('oauth_access_token_uri').$code;
			$access = $this->ci->curl->simple_post($url);
			
			if($access)
			{
				$access = json_decode($access);
				
				if(isset($access->error))
				{
					throw new Exception('[OAuth error] '.$access->message);
				}
				
				else
				{				
					return $access->access_token;
				}
			}
			
			else
			{
				throw new Exception('[OAuth cURL error] ' . $this->ci->curl->error_string);
			}
		}
		
		catch (Exception $e)
		{
			$this->error = $e->getMessage();
			return FALSE;
		}
					
	}
}