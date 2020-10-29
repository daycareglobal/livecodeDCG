<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Content_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->table = 'tbl_static_contents';
	}

	function getRecordBySlug($slug)
	{
		$this->db->select('description, image, title');
		$record = $this->db->get_where($this->table,array('slug' => $slug ));
		$data = $record->row();
		return $data;
	}

	function getAboutUsTeam()
	{
		$this->db->where('status', 'Active');
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get('tbl_about_us_team');
		$record = $query->result();
		return $record;
	}

	function getFaqQuestion()
	{
		$this->db->where('status', 'Active');
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get('tbl_faq');
		$record = $query->result();
		return $record;
	}

	function insert_contact_record($data)
	{
		$this->db->insert('tbl_contact_us', $data);
        return $this->db->insert_id();
	}
	
}