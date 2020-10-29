<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Terms_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->table = 'tbl_terms';
	}

    function get_terms() {
        $records = $this->db->get($this->table);
        return $records->result();
    }

    function add_term($data) {        
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    function get_term_by_id($id) {        
        $this->db->where('id', $id);
        $query = $this->db->get($this->table);      
        return $query->row();
    }

    function update_term_by_id($data, $id) {
        $this->db->where('id', $id);

        if ($this->db->update($this->table, $data)) {
            return true;

        } else {
            return false;
        }   
    }

    function change_status_by_id($id, $status) {
        $this->db->where('id', $id);
        $this->db->update($this->table, array('status' => $status));
    }

    function delete_term_by_id($id) {        
        $this->db->where('id', $id);
        $this->db->delete($this->table);
    }
}