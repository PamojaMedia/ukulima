<?php

//@author Amasy

class Category_m extends CI_Model
{
    private $category='content_type';
    private $report_cats='report_areas';
    private $pk='id';
    
    /**
     * Get All Categories
     */
    
    function get_all()
    {
        $q=$this->db->get($this->category);
        if($q):
            return $q->result();
        else:
            return FALSE;
        endif;
    }
    
    /**
     * Insert Category
     */
    function insert($data=array())
    {
        $q=$this->db->insert($this->category,$data);
        if($q):
            return $this->db->insert_id();
        else:
            return FALSE;
        endif;
    }
    
    /**
     * Edit a Category
     */
    function update($id,$data=array())
    {
        $this->db->where($this->pk,$id);
        $q=$this->db->update($this->category,$data);
        if($q):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    /**
     * Delete a Category
     */
    function delete($id)
    {
        $this->db->delete($this->report_cats,array('contentarea'=>$id));
        $this->db->delete($this->category,array($this->pk=>$id));
    }
    
    /**
     * Enable/Disable Report Module on Content Type
     */
    function add_report($data=array())
    {
        $q=$this->db->insert($this->report_cats,$data);
        if($q):
            
            return TRUE;
        else:            
            return FALSE;
        endif;
    }
    
    function edit_report($id,$data=array())
    {
        $this->db->where('contentarea',$id);
        $q=$this->db->update($this->report_cats,$data);
        if($q):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    //Unread
    function disable($catID)
    {
        $this->db->where('contentarea',$catID);
        $this->db->update('report_areas',array('enabled'=>'0'));
    }
    
    //Unread
    function enable($catID)
    {
        $this->db->where('contentarea',$catID);
        $this->db->update('report_areas',array('enabled'=>'1'));
    }
    //reported category
    function reported($cat)
    {
        $this->db->where('contentarea',$catID);
        $this->db->update('reports',array('reported'=>'1'));
        if($q):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    
}
?>