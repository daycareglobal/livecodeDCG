<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Session_type_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->table = 'tbl_session_type';
	}

    function get_session_types() {
        $this->db->where('status', 'Active');
        $this->db->order_by('id', 'ACS');
        $records = $this->db->get($this->table);
        return $records->result();
    }

    function add_session_type($data) {        
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    function update_session_type($data, $id) {
        $this->db->where('id', $id);

        if ($this->db->update($this->table, $data)) {
            return true;

        } else {
            return false;
        }   
    }

    function get_session_request() {
        $this->db->select('tbl_business_session_type.id,tbl_business_session_type.business_id,tbl_business_session_type.session_type_id,tbl_business_session_type.own_session,tbl_business_session_type.add_date');
        $this->db->select('tbl_user_business_detail.user_id,tbl_user_business_detail.trading_name');
        $this->db->select('tbl_users.name,tbl_users.last_name');
        $this->db->join('tbl_user_business_detail', 'tbl_user_business_detail.id = tbl_business_session_type.business_id');
        $this->db->join('tbl_users', 'tbl_users.id = tbl_user_business_detail.user_id');
        $this->db->where('tbl_business_session_type.session_type_id', 'own_session');
        $this->db->where('tbl_business_session_type.is_approved', 'No');
        $this->db->where('tbl_users.user_type', 'User');
        $records = $this->db->get('tbl_business_session_type');
        return $records->result();
    }

    function doesNameExist($name = '', $id = '') {
        $record = $this->db->get_where($this->table, array('session_name' => $name, 'id !=' => $id));
        $status = $record->row();

        if( $status )
            return TRUE;
        return FALSE;
    }

    function get_session_type_by_id($id) {        
        $this->db->where('id', $id);
        $query = $this->db->get($this->table);      
        return $query->row();
    }

    function changeSessionStatusById($id, $session_type_id, $is_approved) {
        $this->db->where('id', $id);
        $this->db->update('tbl_business_session_type', array('session_type_id' => $session_type_id,'is_approved' => $is_approved));
    }

    function changeMonthlyStatusById($id, $session_type_id) {
        $this->db->where('business_session_type_id', $id);
        $this->db->update('tbl_business_monthly_fees', array('session_type_id' => $session_type_id));
    }
}