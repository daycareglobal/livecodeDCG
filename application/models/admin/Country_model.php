<?php

if(!defined('BASEPATH')) exit('No direct script access allowed');

class Country_model extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->table = 'countries';
	}

	function getAllCountries() {
		$this->db->select('*');
		$this->db->order_by('add_date', 'asc');
		$query = $this->db->get($this->table);
		$result = $query->result();
		return $result;
	}	

	function changeStatusByID($id, $status) {
		$this->db->where('id',$id);
		$this->db->update($this->table, array('status' => $status));
	}

	function deleteCountryRecordByID($id) {
		$this->db->where('id', $id);
		$this->db->delete($this->table);
	}

	function addNewCountry($data) {
		$this->db->insert($this->table,$data);
		return $this->db->insert_id();
	}

	function updateCountryRecordById($id, $data) {
		$this->db->where('id',$id);
		$this->db->set($data);
		$this->db->update($this->table);
	}

	function getCountryRecordById($id) {
		$this->db->select('*');
		$this->db->where('id',$id);
		$query = $this->db->get($this->table);
		$result = $query->row();
		return $result;
	}

	function getCountryNameById($id) {
		$this->db->select('name');
		$this->db->where('id',$id);
		$query = $this->db->get($this->table);
		$result = $query->row();
		if($result)
			return $result->name;
	}

	function checkCountryUnique($name, $id)
	{
		$this->db->where('id !=',$id);
		$this->db->where('name',$name);
		$query = $this->db->get($this->table);
		$result = $query->row();
		return $result;		
	}

	function countAllCountryOnSite()
	{
		$this->db->select('id');		
		$query = $this->db->get($this->table);
		$result = $query->num_rows();
		return $result;
	}

	function getAllActiveCountries() {
		$this->db->select('id, name');
		$this->db->where('status','Active');
		$this->db->order_by('name', 'asc');
		$query = $this->db->get($this->table);
		$result = $query->result();
		return $result;
	}

	
	function getCountryName()
	{
		$this->db->select('*');
		$query = $this->db->get($this->table);
		$result = $query->result();
		return $result;
	}
	
    function getCountryNameByCountryId($id)
	{
		$this->db->select('*');
		$this->db->where('id',$id);
		$query = $this->db->get($this->table);
		$result = $query->result();
		return $result;
	}



}