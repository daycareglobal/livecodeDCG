<?php

if(!defined('BASEPATH')) exit('No direct script access allowed');

class Auth_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}
	
	function checkValidUser($user){
		// $this->db->select('id');
		$this->db->from('tbl_users');
		$this->db->where($user);
		$query = $this->db->get();
		return $query->row();
	}

	function getPassword(){
		$this->db->select('password');
		$this->db->from('tbl_users');
		$this->db->where(array('username' => $this->session->userdata('username')));
		$query = $this->db->get();
		return $query->row();
	}

	function checkUserExistByOldPassword($password,$userId)
	{
		$this->db->where('id',$userId);
		$this->db->where('password',$password);
		$query = $this->db->get('tbl_users');
		$result = $query->row();
		return $result;
	}

	function updateAdminPassword($id, $data) 
	{
		$this->db->where('id',$id);
		$this->db->update('tbl_users',$data);
	}

	function getUserByLoginId($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('tbl_users');
		$result = $query->row();
		return $result;
	}

	function getUserByEmailId($emailId)
	{
		$this->db->select('*');
		$this->db->where('email',$emailId);
		$query = $this->db->get('tbl_users');
		$result = $query->row();
		return $result;
	}

	function updateUserForgotKeyByEmailid($id,$data)
	{
		$this->db->where('id',$id);
		$this->db->update('tbl_users',$data);
	}

	function updateSubAdminPasswordKeyByEmailid($id,$data)
	{
		$this->db->where('id',$id);
		$this->db->update('tbl_users',$data);
	}

	function getUserByForgotPasswordKey($key)
	{
		$this->db->where('forgot_password_key',$key);
		$query = $this->db->get('tbl_users');
		$result = $query->row();
		return $result;
	}

	function getUserBysetPasswordKey($key)
	{
		$this->db->where('set_password_key',$key);
		$query = $this->db->get('tbl_users');
		$result = $query->row();
		return $result;
	}

	function checkExpireTime($email,$key)
	{
		$time = date('Y-m-d H:i:s');
		$this->db->where('expire_time >',$time);
		$this->db->where('email',$email);
		$this->db->where('forgot_password_key',$key);
		$query = $this->db->get('tbl_users');
		$result = $query->row();
		return $result;
	}

	function updateUserPassword($data,$id)
	{
		$this->db->where('id',$id);
		$this->db->update('tbl_users',$data);
	}

	function setSubAdminPassword($data,$id)
	{
		$this->db->where('id',$id);
		$this->db->update('tbl_users',$data);
	}
}