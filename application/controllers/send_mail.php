<?php

class Send_mail extends CI_Controller {
    
    
    function __construct() {
        
        parent::__construct();
        
        $email = $this->config->item('email');
        $this->load->library('email', $email);
        $this->load->model('details_model','details');
        $this->load->helper('email');
        
    }
    
    function reset_notice() {
        
        //$user_details = $this->details->get_all();
        $user_details = array (
            array (
                'firstname' => 'Musa',
                'lastname' => 'Mutuku',
                'email' => 'moses@pamojamedia.com',
                'phonenum' => '254724645986'
            )
        );
        if($user_details) {
            $logs = array();
            foreach($user_details as $detail) {
                $notice_sent = false;
                $sent_to = '';
                if(valid_email($detail['email'])) {
                    $message = $this->load->view('redux_auth/send_email', $detail, true);
                    $this->email->clear();
                    $this->email->set_newline("\r\n");
                    $this->email->from('admin@ukulima.net', 'Administrator');
                    $this->email->to($detail['email']);
                    $this->email->subject('Ukulima.net Reset');
                    $this->email->message($message);
                    $notice_sent = $this->email->send();
                    $sent_to = 'email';
                }
                if(!$notice_sent) {
                    if(strlen($detail['phonenum'])==12) {
                        $message = urlencode('Hi '.$detail['firstname'].'. We are resetting the ukulima.net database. Go to http://ukulima.net/ to register again. We regret any inconvenience.');
                        $source = 'ukulima.net';
                        $url = "http://smpp3.routesms.com:8080/bulksms/bulksms?".
                            "username=wk-pamojamed&".
                            'password=$pamoja@&'.
                            "type=0&".
                            "dlr=0&".
                            "destination=".$detail['phonenum']."&".
                            "source=$source&".
                            "message=$message";
                        $ch = curl_init();    // initialize curl handle
                        curl_setopt($ch, CURLOPT_URL,$url); // set url
                        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_TIMEOUT, 3); // times out after 4s
                        $result = curl_exec($ch); // run the whole process
                        curl_close($ch);
                        $notice_sent = true;
                        $sent_to = 'phone';
                    }
                }
                $logs[] = array(
                    'firstname' => $detail['firstname'],
                    'lastname' => $detail['lastname'],
                    'email' => $detail['email'],
                    'phonenumber' => $detail['phonenum'],
                    'sent' => ($notice_sent?'Yes':'No'),
                    'sent_to' => $sent_to
                );
            }
            $this->load->library('table');
            $this->table->set_heading('Firstname','Lastname', 'Email', 'Phone Number', 'Notice sent', 'Sent To');
            echo $this->table->generate($logs);
        }
        else {
            echo 'QUERY FAILURE';
        }
        
    }
    
}
?>
