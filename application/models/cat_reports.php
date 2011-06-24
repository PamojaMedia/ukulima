<?php
class Cat_reports extends CI_Model
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
        $this->tbl1='report_areas';
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
    
}
?>