<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Services_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->table = 'tbl_service_category';
	}

    function getBusinesUsers()
    {
        $this->db->where('user_type', 'Business');
        $records = $this->db->get('tbl_users');
        return $records->result();
    }

    function getServices()
    {
        $this->db->select('tbl_user_services.*, tbl_users.name, tbl_users.last_name');
        $this->db->join('tbl_users', 'tbl_users.id = tbl_user_services.user_id');
        $records = $this->db->get('tbl_user_services');
        return $records->result();
    }

    function getBusinesActiveRecords()
    {
        $this->db->where('status', 'Active');
        $this->db->where('is_delete', 'No');
        $records = $this->db->get('tbl_business_type');
        return $records->result();
    }

    function getActiveServiceCategory()
    {
        $this->db->where('status', 'Active');
        $this->db->where('is_delete', 'No');
        $records = $this->db->get('tbl_service_category');
        return $records->result();
    }

    function insertBusinessDetails($data){
        $this->db->insert('tbl_user_services', $data);
        return $this->db->insert_id();
    }

    function insertBusinessServiceImages($data) {
        $this->db->insert_batch('tbl_user_services_images', $data);
        return $this->db->insert_id();
    }

    function insertBusinessServiceDays($data) {
        $this->db->insert_batch('tbl_user_services_days', $data);
        return $this->db->insert_id();
    }

    function insertBusinessServiceTypes($data) {
        $this->db->insert_batch('tbl_user_service_types', $data);
        return $this->db->insert_id();
    }

    //end
}