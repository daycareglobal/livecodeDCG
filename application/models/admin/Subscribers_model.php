<?php
/**
*  user model for admin
*/
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Subscribers_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = 'tbl_newsletter_subscribers';
	}

	function get_all_subscriber() {
		$query 		= $this->db->get($this->table);
		$result 	= $query->result();
		return $result;
	}
	function get_all_subscriber_email() {
		$this->db->select('email');
		$query 		= $this->db->get($this->table);
		$result 	= $query->result();
		return $result;
	}

	function delete_subscriber($id){
		$this->db->where('id', $id);
		$this->db->delete($this->table);
	}

	function change_status_by_id($id, $status) 
	{
		$this->db->where('id',$id);
		$this->db->update($this->table, array('status' => $status));
	}

}