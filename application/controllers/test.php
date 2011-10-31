<?php

/*
 * ----------------------------------------------------------------------------
 * "THE BEER-WARE LICENSE" :
 * <thepixeldeveloper@googlemail.com> wrote this file. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy me a beer in return Mathew Davies
 * ----------------------------------------------------------------------------
 */

class Test extends CI_Controller {

    

    function __construct() {
        parent::__construct();
        
    }

    function index() {
        var_dump($this->email);
        
        $from = 'virginia@pamojamedia.com';
        $message = 'TEXT';
        $subject = 'TEXT';
        $to = 'moses@pamojamedia.com';
        
        $this->email->clear();
        $this->email->set_newline("\r\n");
        $this->email->from($from, '');
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);
        echo $success = $this->email->send();
    }

}

/* End of file auth.php */
/* Location: ./system/application/controllers/auth.php */