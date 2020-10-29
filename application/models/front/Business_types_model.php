<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Business_types_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->table = 'tbl_business_type';
	}

    function get_records()
    {
        $records = $this->db->get($this->table);
        return $records->result();
    }

    function getActiveRecords()
    {
        $this->db->where('status', 'Active');
        $this->db->where('is_delete', 'No');
        $records = $this->db->get($this->table);
        return $records->result();
    }

   

    function getRecords()
    {
        $records = $this->db->get($this->table);
        return $records->result();
    }

    function get_record_by_id($id)
    {        
        $this->db->where('id', $id);
        $query = $this->db->get($this->table);      
        return $query->row();
    }

    function getBusinessTypeBySlug($slug)
    {        
        $this->db->where('slug', $slug);
        $query = $this->db->get($this->table);      
        return $query->row();
    }
}