<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Request_quote_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->table = 'tbl_user_membership_plan';
	}
  
    function get_request_quote() {
        $this->db->select('tbl_save_quote.id as save_quote_id, tbl_save_quote.reference_number, tbl_save_quote.fees');
        $this->db->select('tbl_user_quote.*');
        $this->db->select('tbl_user_business_detail.user_id, tbl_user_business_detail.trading_name');
        $this->db->select('tbl_users.name, tbl_users.last_name');
        $this->db->join('tbl_user_quote', 'tbl_save_quote.quote_id = tbl_user_quote.id');
        $this->db->join('tbl_user_business_detail', 'tbl_user_business_detail.id = tbl_save_quote.business_id');
        $this->db->join('tbl_users', 'tbl_users.id = tbl_user_business_detail.user_id');
        $this->db->where('tbl_save_quote.is_provider_added_quote', 'Yes');
        $query = $this->db->get('tbl_save_quote');
        $result = $query->result();
        return $result;
    }

    function get_quote_detail_by_id($id) {
        $this->db->select('tbl_user_quote.*');
        $this->db->where('tbl_user_quote.id', $id);
        $query = $this->db->get('tbl_user_quote');
        $result = $query->row();
        return $result;
    }
}