<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * ----------------------------------------------------------------------------
 * "THE BEER-WARE LICENSE" :
 * <thepixeldeveloper@googlemail.com> wrote this file. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy me a beer in return Mathew Davies
 * ----------------------------------------------------------------------------
 */

/**
 * These are the configs for the authentication module
 */
	/**
	 * Tables.
	 **/
	$config['tables']['groups'] = 'groups';
	$config['tables']['people'] = 'people';
        $config['tables']['follow'] = 'follow';
         $config['tables']['connect'] = 'connect';
	$config['tables']['meta'] = 'meta';
	
	/**
	 * Default group, use name
	 */
	$config['default_group'] = 'member';
	 
	/**
	 * Meta table column you want to join WITH.
	 * Joins from users.id
	 **/
	$config['join'] = 'user_id';
	
	/**
	 * Columns in your meta table,
	 * id not required.
	 **/
	$config['columns'] = array('firstname', 'lastname');
	
	/**
	 * A database column which is used to
	 * login with.
	 **/
	$config['identity'] = 'username';

	/**
	 * Email Activation for registration
	 **/
	$config['email_activation'] = true;
	$config['auth']['mail']['_smtp_auth'] = true; 
	/**
	 * Folder where email templates are stored.
     * Default : redux_auth/
	 **/
	$config['email_templates'] = 'redux_auth/';

	/**
	 * Salt Length
	 **/
	$config['salt_length'] = 10;
	
?>