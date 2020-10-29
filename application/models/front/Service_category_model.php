<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Service_category_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->table = 'tbl_service_category';
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
}