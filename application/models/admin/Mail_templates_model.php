<?php

if(!defined('BASEPATH')) exit('No direct script access allowed');

class Mail_templates_model extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->table = 'tbl_emails';
	}

	function getAllTemplates()
	{
		$this->db->select('*');
		$this->db->where('status', 'Active');
		$query = $this->db->get($this->table);
		$result = $query->result();
		return $result;
	}

	function changeStatusById($id,$status)
	{
		$this->db->where('id',$id);
		$this->db->update($this->table,array('status' => $status));
	}

	function getSingleTemplateById($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get($this->table);
		$result = $query->row();
		return $result;
	}	

	function updateEmailTemplate($id, $data) 
	{
		$this->db->where('id',$id);
		$result = $this->db->update($this->table,$data);
		return $result;
	}	

}
