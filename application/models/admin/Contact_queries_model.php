<?php

if(!defined('BASEPATH')) exit('No direct script access allowed');

class Contact_queries_model extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->table = 'tbl_contact_us';
		$this->table1 = 'tbl_user_query_reply';
	}
	function getAllContactQueries()
	{
		$this->db->select('*');
		$query = $this->db->get($this->table);
		$result = $query->result();
		return $result;
	}
	function updateContactQuery($id,$data)
	{
		$this->db->where('id',$id);
		$result = $this->db->update($this->table,$data);
		return $result;
	}
	function getSignleRecordById($id)
	{
		$this->db->select($this->table.'.*');
		$this->db->select('tbl_user_query_reply.reply_message');
		$this->db->where($this->table.'.id',$id);
		$this->db->join('tbl_user_query_reply','tbl_user_query_reply.contact_us_id = tbl_contact_us.id', 'left');
		$query = $this->db->get($this->table);
		$result = $query->row();
		return $result;
	}

	function deleteContactById($id)
	{
		$this->db->where('id',$id);
		$this->db->delete($this->table);
	}

	function deleteContactReplyByContactId($id)
	{
		$this->db->where('contact_us_id', $id);
		$this->db->delete('tbl_user_query_reply');
	}

	function changeStatusById($id)
	{
		$this->db->where('id',$id);
		$this->db->update($this->table);
	}

	function replyContactQuery($data,$id){

		$this->db->where('id',$id);
		$this->db->insert($this->table1, $data);
        return $this->db->insert_id();

	}

}