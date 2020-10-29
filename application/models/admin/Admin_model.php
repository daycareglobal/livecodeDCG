<?php

if(!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function getUsers(){
		$query = $this->db->get('tbl_users');
		return $query->result();
	}
	function countSearch($searchData = NULL)
	{
		$id = $this->session->userdata('admin_id');
		if(isset($searchData['status']) && $searchData['status'])
			$this->db->where('status',$searchData['status']);
		if(isset($searchData['is_email_verified']) && $searchData['is_email_verified'])
			$this->db->where('is_email_verified',$searchData['is_email_verified']);
		if(isset($searchData['is_employer']) && $searchData['is_employer'])
			$this->db->where('is_employer',$searchData['is_employer']);
		if(isset($searchData['keyword']) && $searchData['keyword'])
		{
			$this->db->group_start();
				$this->db->like('username',$searchData['keyword']);
				$this->db->or_like('email',$searchData['keyword']);
				$this->db->or_like('first_name',$searchData['keyword']);
				$this->db->or_like('last_name',$searchData['keyword']);
				if(isset($searchData['is_employer']) && $searchData['is_employer']=='Yes')
				{
					$this->db->or_like('business_name',$searchData['keyword']);
				}
			$this->db->group_end();
		}
		if(isset($searchData['alpha']) && $searchData['alpha'])
		{
			$alpha = $searchData['alpha'];
			$where = "`username` LIKE '$alpha%'";
			$this->db->where($where);
		}
		$this->db->where('id !=',$id);
		$this->db->where('is_admin','No');
		$query = $this->db->get($this->table);
		//echo $this->db->last_query(); die(' countSearch');
		$result = $query->num_rows();
		return $result;
	}
}