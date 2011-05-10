<?php
class Reports_m extends CI_Model
{
    /**
     * Table for report Areas
     */
    private $tbl1;
    private $pk;
    
    /**
     * Class Constructor
     */
    function __construct()
    {
        parent::__construct();
        $this->tbl1='reports';
        $this->pk='id';
    }
    
    /**
     * Get all Categories for Reports
     */
    function get_all()
    {
        $this->db->order_by($this->pk,'ASC');
        $rep_areas=$this->db->get($this->tbl1);
        if($rep_areas):
            return $rep_areas->result();
        else:
            return FALSE;
        endif;
    }
    
    /**
     * Allow Admin to delete report Area
     */
    function delete($id)
    {
        $data=array($this->pk=>$id);
        return $this->db->delete($this->tbl1,$data);
    }
    
    /**
     * Edit Report Area
     */
    function update($id,$data=array())
    {
        $query=$this->db->update($this->tbl1,$data);
        if($query):
            return TRUE;
        else:
            return FALSE;
        endif;        
    }
    /**
     * Add a report Area
     */
    function insert($data=array())
    {
        $query=$this->db->insert($this->tbl1,$data);
        if($query):
            return TRUE;
            return $this->db->insert_id();
        else:
            return FALSE;
        endif;
    }
    
        
    function markRead($id)
    {
        $status=array('status'=>'1');
        $this->db->where('id',$id);
        $this->db->update('reports',$status);
    }
    
    function markUnread($id)
    {
        $status=array('status'=>'0');
        $this->db->where('id',$id);
        $this->db->update('reports',$status);
    }
    
    
}
?>