<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| NOTIFICATIONS
| -------------------------------------------------------------------
| This file contains an array of content types that can cause a user notification.
|
| Please see user guide for more info:
| http://codeigniter.com/user_guide/helpers/smiley_helper.html
|
*/

$config['site_notifications'] = array(

//	content type			value

	'update'    =>	1,
        'comment'   =>  2,
	'message'   =>	3,
        'content'   =>  4,

	'follow'    =>	5,
	'connect'   =>	6,

        'report_update'     => 7,
        'report_comment'    => 8,
        'report_message'    => 9,
        'report_content'    => 10,
        'question'    => 11,
        'answer'    =>	12,

//      index
        1   => 'update',
        2   => 'comment',
        3   => 'message',
        4   => 'content',

        5   => 'follow',
        6   => 'connect',

        7   =>  'report_update',
        8   =>  'report_comment',
        9   =>  'report_message',
        10   =>  'report_content',
        11   => 'question',
        12   => 'answer'

    );

/* End of file smileys.php */
/* Location: ./application/config/smileys.php */