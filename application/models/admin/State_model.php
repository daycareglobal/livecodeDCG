<?php

if(!defined('BASEPATH')) exit('No direct script access allowed');

class State_model extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->table = 'states';
	}

	function getAllStates() {
		$this->db->select('*');
		$this->db->order_by('add_date', 'asc');
		$query = $this->db->get($this->table);
		$result = $query->result();
		return $result;
	}

	function countRecord($searchData)
	{		
		if ( isset($searchData['keyword']) && $searchData['keyword'] ) {
			$this->db->like('states.name',$searchData['keyword']);
		}

		$this->db->select('states.*');
		$this->db->from($this->table);
		$query = $this->db->get();
		$result = $query->num_rows();
		return $result;
	}

	function getAllRecords($searchData) 
	{
		if (isset($searchData['keyword']) && $searchData['keyword']) {
			$this->db->like('name',$searchData['keyword']);
		}

		if (isset($searchData['limit']) && $searchData['limit'] ) {
            $this->db->limit($searchData['limit'], $searchData['search_index']);
		}

		$this->db->select('states.*');
		$this->db->from($this->table);
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}

	function changeStatusByID($id, $status) {
		$this->db->where('id',$id);
		$this->db->update($this->table, array('status' => $status));
	}

	function deleteStateRecordByID($id) {
		$this->db->where('id', $id);
		$this->db->delete($this->table);
	}

	function addNewState($data) {
		$this->db->insert($this->table,$data);
		return $this->db->insert_id();
	}

	function updateStateRecordById($id, $data) {
		$this->db->where('id',$id);
		$this->db->set($data);
		$this->db->update($this->table);
	}

	function getStateRecordById($id) {
		$this->db->select('*');
		$this->db->where('id',$id);
		$query = $this->db->get($this->table);
		$result = $query->row();
		return $result;
	}

	function getStateNameById($id) {
		$this->db->select('name');
		$this->db->where('id',$id);
		$query = $this->db->get($this->table);
		$result = $query->row();
		if($result)
			return $result->name;
	}

	function checkStateUnique($name, $id)
	{
		$this->db->where('id !=',$id);
		$this->db->where('name',$name);
		$query = $this->db->get($this->table);
		$result = $query->row();
		return $result;		
	}

	function countAllStateOnSite()
	{
		$this->db->select('id');		
		$query = $this->db->get($this->table);
		$result = $query->num_rows();
		return $result;
	}

	function getAllActiveState() {
		$this->db->select('id, name');
		$this->db->where('status','Active');
		$this->db->order_by('name', 'asc');
		$query = $this->db->get($this->table);
		$result = $query->result();
		return $result;
	}


	function getstateName()
	{
		$this->db->select('*');
		$query = $this->db->get('states');
		$result = $query->result();
		return $result;
	}

    function getstateNameByStateId($id)
	{
		$this->db->select('*');
		$this->db->where('id',$id);
		$query = $this->db->get('states');
		$result = $query->result();
		return $result;
	}

	function getCountryNameByCountryId()
	{
		$this->db->select('*');
		$query = $this->db->get('countries');
		$result = $query->result();
		return $result;
	}



}