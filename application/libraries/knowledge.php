<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* 
 * This library is meant to house the Knowledge Area also known as the user pages
 * The logged in user can create content using a WYSIWIG Editore and edit them
 * 
 */

class knowledge {

    /*
     * @var string
     **/
    protected $ci;

    public $data = array();

    public $content_data = array();
     // set the prefix for the views. used when the browser is mobile. the views have an m- prefix. for browsers, there is no prefix
    private $view_prefix = '';

    /**
     * __construct
     *
     * @return void
     * @author Comark
     **/
    public function __construct() {
          $this->ci =& get_instance();
          $this->ci->load->helper('ckeditor');



          //Ckeditor's configuration
		$this->data ['ckeditor'] = array(

			//ID of the textarea that will be replaced
			'id' 	=> 	'content_edit',
			'path'	=>	'assets/ckeditor',

			//Optionnal values
			'config' => array(
				'toolbar' 	=> 	"Full", 	//Using the Full toolbar
				'width' 	=> 	"550px",	//Setting a custom width
				'height' 	=> 	'100px',	//Setting a custom height

			),

			//Replacing styles from the "Styles tool"
			'styles' => array(

				//Creating a new style named "style 1"
				'style 1' => array (
					'name' 		=> 	'Blue Title',
					'element' 	=> 	'h2',
					'styles' => array(
						'color' 	=> 	'Blue',
						'font-weight' 	=> 	'bold'
					)
				),

				//Creating a new style named "style 2"
				'style 2' => array (
					'name' 	=> 	'Red Title',
					'element' 	=> 	'h2',
					'styles' => array(
						'color' 		=> 	'Red',
						'font-weight' 		=> 	'bold',
						'text-decoration'	=> 	'underline'
					)
				)
			)
		);

		$this->data ['ckeditor_2'] = array(

			//ID of the textarea that will be replaced
			'id' 	=> 	'content_edit2',
			'path'	=>	'assets/ckeditor',

			//Optionnal values
			'config' => array(
				'width' 	=> 	"550px",	//Setting a custom width
				'height' 	=> 	'100px',	//Setting a custom height
				'toolbar' 	=> 	array(	//Setting a custom toolbar
					array('Bold', 'Italic'),
					array('Underline', 'Strike', 'FontSize'),
					array('Smiley'),
					'/'
				)
			),

			//Replacing styles from the "Styles tool"
			'styles' => array(

				//Creating a new style named "style 1"
				'style 3' => array (
					'name' 		=> 	'Green Title',
					'element' 	=> 	'h3',
					'styles' => array(
						'color' 	=> 	'Green',
						'font-weight' 	=> 	'bold'
					)
				)

			)
		);
    }
    
    
     public function editor()
    {
         $result = $this->data ;
         $this->content_data['content'] = $this->ci->load->view('knowledge/'.$this->view_prefix.'view',$result,true);
        return $this->content_data;
    }



}

?>
