<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class search{
        
        /**
	 * CodeIgniter global
	 *
	 * @var string
	 **/
	protected $ci;

        public function __construct()
	{
		$this->ci =& get_instance();
                // Load the relation model for checking connection and follow status.
                $this->ci->load->model('search_model');
	}

        /**
         * Function: query
         */
        function query($q = '') {
        $people = $this->ci->search_model->query($q/*$this->ci->input->get('q')*/);

        foreach($people as $person) {
            $arr[] = array (
                    'id' => $person['userid'],
                    'name' => $person['firstname'].' '.$person['lastname']
            );
        }

        echo json_encode($arr);
    }

    
    }
?>
