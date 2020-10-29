<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Client_feedback_model extends CI_Model {
	function __construct() {
		parent::__construct();
        $this->table = 'tbl_client_feedback';
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

	function insertRecord($data)
    {        
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    function changeStatusById($id,$status)
    {
        $this->db->where('id',$id);
        $this->db->update($this->table, array('status' => $status));
    }

    function delete($id)
    {        
        $this->db->where('id', $id);
        $this->db->delete($this->table);
    }

    function update_record($data, $id)
    {
        $this->db->where('id', $id);

        if ($this->db->update($this->table, $data)) {
            return true;

        } else {
            return false;
        }   
    }
}