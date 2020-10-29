<?php

if(!defined('BASEPATH')) exit('No direct script access allowed');

class City_model extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->table = 'cities';
	}

	function getAllCity() {
		$this->db->select('*');
		$this->db->order_by('add_date', 'asc');
		$query = $this->db->get($this->table);
		$result = $query->result();
		return $result;
	}

	function getCityRecordById($id) {
		$this->db->select('*');
		$this->db->where('id',$id);
		$query = $this->db->get($this->table);
		$result = $query->row();
		return $result;
	}

	function countRecord($searchData)
	{		
		if ( isset($searchData['keyword']) && $searchData['keyword'] ) {
			$this->db->like('cities.name',$searchData['keyword']);
		}

		$this->db->select('cities.*');
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
            $this->db->limit($searchData['limit'],$searchData['search_index']);
		}

		$this->db->select('cities.*');
		$this->db->from($this->table);
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}

	function changeStatusByID($id, $status) {
		$this->db->where('id',$id);
		$this->db->update($this->table, array('status' => $status));
	}

	function deleteCityRecordByID($id) {
		$this->db->where('id', $id);
		$this->db->delete($this->table);
	}

	function addNewCity($data) {
		$this->db->insert($this->table,$data);
		return $this->db->insert_id();
	}

	function updateCityRecordById($id, $data) {
		$this->db->where('id',$id);
		$this->db->set($data);
		$this->db->update($this->table);
	}


	/*function getStateNameById($id) {
		$this->db->select('name');
		$this->db->where('id',$id);
		$query = $this->db->get($this->table);
		$result = $query->row();
		if($result)
			return $result->name;
	}*/

	function checkCityUnique($name, $id)
	{
		$this->db->where('id !=',$id);
		$this->db->where('name',$name);
		$query = $this->db->get($this->table);
		$result = $query->row();
		return $result;		
	}

	/*function countAllStateOnSite()
	{
		$this->db->select('id');		
		$query = $this->db->get($this->table);
		$result = $query->num_rows();
		return $result;
	}*/

	/*function getAllActiveCountries() {
		$this->db->select('id, name');
		$this->db->where('status','Active');
		$this->db->order_by('name', 'asc');
		$query = $this->db->get($this->table);
		$result = $query->result();
		return $result;
	}*/




}