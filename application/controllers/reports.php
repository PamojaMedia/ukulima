<?php
class Reports extends CI_Controller
{
    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
        $this->load->model('reports_m');
    }
    /**
     * Load Report Form
     */
    function index()
    {
        $reports=$this->db->get('reports')->result_array();
        $this->data['reports']=$this->db->get('reports')->result();
        $this->load->view('report_list',$this->data);
    }
    
    function report($userID='',$reporterID='',$contentID='',$status=0)
    {
        $data=array(
                    'causeid'=>$this->input->post('cause'),
                    'causerID'=>$userID,
                    'contentid'=>$contentID,
                    'userid'=>$reporterID,
                    'status'=>$status,
                    );
        if($userID && $reporterID && $contentID):
            $this->db->insert('reports',$data);
        endif;
        redirect('reports/success');
    }
    function view($id='')
    {
        $report=$this->db->get_where('reports',array('id'=>$id))->row();
        $causer=$this->db->get_where('people',array('userid'=>$report->causerID))->row();
        $reporter=$this->db->get_where('people',array('userid'=>$report->userid))->row();
        $article=$this->db->get_where('user_content',array('ID'=>$report->contentid))->row();
        
        if (!$id || !$report || !$causer) redirect(reports/index);
        
        $this->reports_m->markread($id);
        
        $this->data['causer']=$causer;
        $this->data['reporter']=$reporter;
        $this->data['report']=$report;
        $this->data['article']=$article;
        
        $this->load->view('report_view',$this->data);
        
    }
    
    
    function success()
    {
        $this->data['message']="Your report has been received. Thank you";
        $this->load->view('success',$this->data);
    }
    
    function unread($id='')
    {
        if(!empty($id)):
        $this->reports_m->markunread($id);
        endif;
        redirect('reports/index');
    }
}
?>