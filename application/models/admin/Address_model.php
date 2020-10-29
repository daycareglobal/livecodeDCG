<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Address_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->table = 'countries';
	}

    function getCountryRecords()
    {
        $records = $this->db->get($this->table);
        return $records->result();
    }

    function get_record_by_id($id)
    {        
        $this->db->where('id', $id);
        $query = $this->db->get($this->table);      
        return $query->row();
    }

    function get_record_by_state_id($id)
    {        
        $this->db->where('id', $id);
        $query = $this->db->get('states');      
        return $query->row();
    }

    function get_record_by_city_id($id)
    {        
        $this->db->where('id', $id);
        $query = $this->db->get('cities');      
        return $query->row();
    }

    function getStateRecordsByCountry($country_id)
    {        
        $this->db->where('country_id', $country_id);
        $query = $this->db->get('states');      
        return $query->result();
    }

    function getCityRecordsByState($state_id)
    {        
        $this->db->where('state_id', $state_id);
        $query = $this->db->get('cities');      
        return $query->result();
    }
}