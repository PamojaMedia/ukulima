<?php
class Content_m extends CI_Model
{
    private $content='user_content';
    private $reports;
    private $pk='id';
    private $content_area;
    
    function __construct()
    {
        parent::__construct();
        $this->reports='report_areas';
        $this->content_area='contentarea';        
    }
    
    function get_all()
    {
        $q=$this->db->get($this->content);
        if($q):
            return $q->result();
        else:
            return FALSE;
        endif;
    }
    
    function insert($data=array())
    {
        $q=$this->db->insert($this->content,$data);
        if($q):
            return $this->db->insert_id();
        else:
            return FALSE;
        endif;
    }
    
    function update($id,$data=array())
    {
        $this->db->where($this->pk,$id);
        $q=$this->db->update($this->content,$data);
        if($q):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function delete($id)
    {
        $this->db->delete($this->content,array($this->pk=>$id));
    }
    
    /**
     * Check if Reporting is enabled
     * @param InsertID
     */
    function check_report($id='')
    {
        if($id):
            $row=$this->db->get_where($this->content,array($this->pk=>$id))->row();
            $type=$row->type;
            
            $reportx=$this->db->get_where($this->reports,array($this->content_area=>$type))->row();
            $report_status=$reportx->enabled;
            
            if($report_status==1):
                return TRUE;
            else:
                return FALSE;
            endif;
        endif;       
    }
}
?>