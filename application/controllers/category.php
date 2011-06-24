<?php

class Category extends CI_Controller
{
    /**
     * Class Constructor
     */
    function __construct()
    {
        parent::__construct();
        $this->load->model('category_m');
        
        
    }
    
    /**
     * List all Categories
     */
    function index()
    {
        //$data['categories']=$this->category_m->get_all();
        $this->db->select('report_areas.enabled AS status,content_type.name as name , content_type.id as id');
        $this->db->join('report_areas','report_areas.contentarea=content_type.id');
        $q=$this->db->get('content_type')->result();
        
        $data['categories']=$q;
        
        $this->load->view('index',$data);
    }
    
    
    /**
     * Add A Category
     */
    function create()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Name', 'required');
        
        $data=array('name'=>$this->input->post('name'));
        
        
        if($this->form_validation->run()):
            $q=$this->category_m->insert($data);
            if($q):
            
                //Insert Report dis/enabled Status
                $arr=array('contentarea'=>$q);
                $this->category_m->add_report($arr);
                
                $this->session->set_flashdata('success', sprintf( "Success Adding Content Category '%s'", $this->input->post('name')) );
            else:
                $this->session->set_flashdata(array('error'=> "Error Adding Content Category. Please Try Again."));
            endif;
            redirect('category/index');       
        endif;
        
        $this->load->view('form');
        
    }
    
    /**
     * Edit a Category
     */
    function edit($id)
    {
        $cat=$this->db->get_where('content_type',array('id'=>$id))->row();
        if(empty($id)||!$cat):
            redirect('category/index');
        endif;
        
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Name', 'required');
        
        $categ=array('name'=>$this->input->post('name'));
        $enabled=$this->input->post('enable');
        
        if($this->form_validation->run()):
            $q=$this->category_m->update($id,$categ);
            if($q):
                //Insert Report dis/enabled Status
                
                $arr=array('contentarea'=>$id);
                
                $this->category_m->edit_report($id,$arr);
                
                $this->session->set_flashdata('success', sprintf( "Success Editing Content Category '%s'", $this->input->post('name')) );
            else:
                $this->session->set_flashdata(array('error'=> "Error Adding Content Category. Please Try Again."));
            endif;
            redirect('category/index');       
        endif;
        $data['category']=$cat;
        $this->load->view('form',$data);
    }
    
    /**
     * Delete a Category
     *To whoever it may concern: find a way to use javascript to prompt for user to delete a category if necessary
     */
    function delete($id)
    {
        if(empty($id)):
            redirect('category/index');
        else:
            if($this->category_m->delete($id)):
                $this->session->set_flashdata('success',  "Success Deleting Content Category '%s'" );
            else:
                 $this->session->set_flashdata(array('error'=> "Error Deleting Content Category. Please Try Again."));
            endif;
            redirect('category/index');
        endif;
        
    }
    
    
    //Disable
    function disable($id='')
    {
        if(!empty($id)):
            $this->category_m->disable($id);
        endif;
        redirect('category/index');
    }
    //Enabled
    function enable($id='')
    {
        if(!empty($id)):
            $this->category_m->enable($id);
        endif;
        redirect('category/index');
    }
    
    
    
    
    
    
    
}

?>