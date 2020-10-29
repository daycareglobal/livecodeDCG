<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Special_education_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->table = 'tbl_special_education';
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

    function get_special_education_request() {
        $this->db->select('tbl_user_own_education.*');
        $this->db->select('tbl_user_service_detail.user_id');
        $this->db->select('tbl_users.name,tbl_users.last_name');
        $this->db->join('tbl_user_service_detail', 'tbl_user_service_detail.id = tbl_user_own_education.user_service_detail_id');
        $this->db->join('tbl_users', 'tbl_users.id = tbl_user_service_detail.user_id');
        $this->db->where('tbl_users.user_type', 'User');
        $records = $this->db->get('tbl_user_own_education');
        return $records->result();
    }

    function add_request($data) {        
        $this->db->insert('tbl_user_special_education', $data);
        return $this->db->insert_id();
    }

    function delete_request($id) {        
        $this->db->where('id', $id);
        $this->db->delete('tbl_user_own_education');
    }
}