<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Service_category_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->table = 'tbl_service_category';
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

	function insert_record($data)
    {        
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    function changeStatusById($id, $status)
    {
        $this->db->where('id', $id);
        $this->db->update($this->table, array('status' => $status));
    }

    function delete($id)
    {        
        $this->db->where('id', $id);
        $this->db->delete($this->table);
    }

    function doesNameExist($name = '', $id = '')
    {
        $record = $this->db->get_where($this->table, array('name' => $name, 'id !=' => $id));
        $status = $record->row();

        if( $status )
            return TRUE;
        return FALSE;
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