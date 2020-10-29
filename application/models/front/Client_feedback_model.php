<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Client_feedback_model extends CI_Model {
	function __construct() {
		parent::__construct();
        $this->table = 'tbl_client_feedback';
	}

    function getRecords($limit = null)
    {
        if ($limit) {
            $this->db->limit($limit);
        }
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