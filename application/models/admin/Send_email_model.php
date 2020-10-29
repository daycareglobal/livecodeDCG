<?php

if(!defined('BASEPATH')) exit('No direct script access allowed');

class Send_email_model extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->table = 'tbl_send_emails_template';
	}

	function getAllTemplates($status = null)
	{
		$this->db->select('*');

		if ($status) {
			$this->db->where('status', $status);
		}
		$this->db->where('is_delete', 'No');
		$query = $this->db->get($this->table);
		$result = $query->result();
		return $result;
	}

	function changeStatusById($id,$status)
	{
		$this->db->where('id',$id);
		$this->db->update($this->table, array('status' => $status));
	}

	function getSingleTemplateById($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get($this->table);
		$result = $query->row();
		return $result;
	}

	function getSentTemplates()
	{
		$this->db->select('tbl_sent_emails.*');
		$this->db->select('tbl_send_emails_template.name as template_name, tbl_send_emails_template.subject, tbl_send_emails_template.content');
		$this->db->select('tbl_users.name, email');
		$this->db->join('tbl_send_emails_template', 'tbl_sent_emails.email_template_id = tbl_send_emails_template.id');
		$this->db->join('tbl_users', 'tbl_sent_emails.user_id = tbl_users.id');
		$query = $this->db->get('tbl_sent_emails');
		$result = $query->result();
		return $result;
	}

	function insert_record($data)
    {        
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    function insert_sent_email_record($data = array())
	{
		$this->db->insert_batch('tbl_sent_emails', $data);
	}

	function updateEmailTemplate($id, $data) 
	{
		$this->db->where('id',$id);
		$result = $this->db->update($this->table,$data);
		return $result;
	}
}