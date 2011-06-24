<?php
class Content extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('content_m');
        $this->load->model('category_m');
        
        
    }
    
    function index()
    {
        $data['articles']=$this->content_m->get_all();
        $data['reports']=$this->content_m->check_report();
        $this->load->view('content',$data);
    }
    
    function view($id=0)
    {
	$q=$this->db->get_where('user_content',array('ID'=>$id))->row();
	($id && $q) || show_404();
    
	$data['article']=$q;
	$data['status']=$this->check_reporting($q->type);
	$this->load->view('article',$data);
    }
    
    function create()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('title', 'Title', 'trim|required');
        $this->form_validation->set_rules('content', 'Body', 'trim|required');
        $this->form_validation->set_rules('userfile', 'File', 'trim');
        $this->form_validation->set_rules('status', 'Status', 'trim|required');
        $this->form_validation->set_rules('type', 'Content Type', 'trim|required');
        
        
        $categs=array();
	$categories=$this->category_m->get_all();
        
        
	if($categories):
		foreach($categories as $category):
			$categs[$category->id]=$category->name;
		endforeach;
	endif;
        $data['categs']=$categs;
        /**
         * Should uncomment the fields once we integrate to the the other core system processes
         */
        $arr=array(
                    //'userid'=>$this->input->post('userid'),
                    'title'=>$this->input->post('title'),
                    'content'=>$this->input->post('content'),
                    //'tagsid'=>$this->input->post('tags'),
                    'file'=>$this->input->post('userfile'),
                    'status'=>$this->input->post('status'),
                    'type'=>$this->input->post('type')
                    );
        if($this->form_validation->run()):
            $q=$this->content_m->insert($arr);
            if($q):
                $this->session->set_flashdata('success', sprintf( "Success Adding Content '%s'", $this->input->post('title')) );
            else:
                $this->session->set_flashdata(array('error'=> "Error Adding Content. Please Try Again."));
            endif;
            redirect('content/index'); 
        endif;
        
        $this->load->view('content_form',$data);
    }
    
    
    
    
    /**
     * Edit Content
     */
    
    function edit($id)
    {
        
    }
    
    /**
     * Delete Content
     */
    function delete($id)
    {
        
    }
    
    private function check_reporting($typeID)
    {
	$query=$this->db->get_where('report_areas',array('contentarea'=>$typeID))->row();
	$status=($query->enabled) ? TRUE : FALSE;
	return $status;	    
    }
}
?>