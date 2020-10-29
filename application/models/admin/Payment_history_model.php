<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Payment_history_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->table = 'tbl_user_membership_plan';
	}

  
    function get_payment_history() {
        $this->db->select('tbl_user_membership_plan.*');
        $this->db->select('tbl_users.name,tbl_users.last_name');

        $this->db->select('tbl_membership_plan.plan_name, tbl_membership_plan.plan_type as membership_plan_type, tbl_membership_plan.month');

        $this->db->join('tbl_users','tbl_users.id = tbl_user_membership_plan.user_id');
        $this->db->join('tbl_membership_plan','tbl_membership_plan.id = tbl_user_membership_plan.membership_plan_id');
        $this->db->order_by('tbl_user_membership_plan.add_date', 'DESC');
        $records = $this->db->get('tbl_user_membership_plan');
        return $records->result();
    }

    function get_payment_history_by_id($id) {
        $this->db->select('tbl_user_membership_plan.*');
        $this->db->select('tbl_users.name,tbl_users.last_name');

        $this->db->select('tbl_membership_plan.plan_name, tbl_membership_plan.plan_type as membership_plan_type, tbl_membership_plan.month');

        $this->db->join('tbl_users','tbl_users.id = tbl_user_membership_plan.user_id');
        $this->db->join('tbl_membership_plan','tbl_membership_plan.id = tbl_user_membership_plan.membership_plan_id');
        $this->db->where('tbl_user_membership_plan.id', $id);
        $row = $this->db->get('tbl_user_membership_plan');
        return $row->row();
    }
}