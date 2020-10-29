<?php

if(!defined('BASEPATH')) exit('No direct script access allowed');

class Member_model extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->table = 'tbl_users';
	}

	function countSearch($searchData = NULL)
	{
		$this->db->select('*');
		$this->db->where('is_admin','No');
		$query = $this->db->get($this->table);
		$result = $query->num_rows();
		return $result;
	}

	function get_all_admin() {
		$id = $this->session->userdata('admin_id');
		$this->db->select('*');
		$this->db->where('id !=',$id);
		$this->db->where('is_admin','Yes');
		$query = $this->db->get('tbl_users');
		$result = $query->result();
		return $result;
	}

	function getAllUsers() {
		$id = $this->session->userdata('admin_id');
		$this->db->select('*');
		$this->db->where('id !=',$id);
		$this->db->where('is_admin','No');
		$query = $this->db->get('tbl_users');
		$result = $query->result();
		return $result;
	}


	function getAllActiveUsers() {
		$this->db->select('id, first_name');
		$this->db->where('status','Active');
		$this->db->order_by('first_name', 'asc');
		$query = $this->db->get($this->table);
		$result = $query->result();
		return $result;
	}
	
	function changeStatusByID($id, $status) 
	{
		$this->db->where('id',$id);
		$this->db->update($this->table, array('status' => $status));
	}

	function getUser($id) {
		$this->db->select('*');
		$this->db->from('tbl_users');
		$this->db->where(array('id' => $id));
		$query = $this->db->get();
		return $query->row();
	}

	function insertUser($data) {
		$this->db->insert($this->table,$data);
		return $this->db->insert_id();
	}

	function update_user_by_id($id, $data){
        $this->db->where('id', $id);
        if($this->db->update($this->table, $data)){
            return true;    
        }
        else{
            return false;
        }   
    }

	function updateUser($id, $data) {

		if(isset($data['profile_image']) && $data['profile_image'])
		{
			$this->removeFileById($id);
		}
		if ( isset($data['image']) && $data['image'] ) {
			$this->remove_image_by_id($id);
		}
		$this->db->where('id',$id);
		$result = $this->db->update($this->table,$data);
		return $result;
	}

	function get_image_from_folder($image_id){
		
		$this->db->where('id',$image_id);
		$query = $this->db->get($this->table);
		return $query->row();
	}

	function remove_image_by_id($id) {

		$images = $this->get_image_from_folder($id);
		
		if ( $images->image ) {
			$path = './assets/uploads/members/';
			unlink($path . $images->image);
		}
	}

	function removeFileById($id)
	{
		$users = $this->getUser($id);
		if ($users->profile_image) 
		{
			$path = './assets/uploads/users/';
			unlink($path . $users->profile_image);
		}
	}

	function deleteUser($id) {
		$this->db->where('id', $id);
		$this->db->delete('tbl_users');
	}

	function changeStatus($id, $status) {
		$this->db->where('id',$id);
		$this->db->update('tbl_users', array('status' => $status));
	}

	function checkEmailAddressUnique($emailId, $id)
	{
		$this->db->where('id !=',$id);
		$this->db->where('email',$emailId);
		$query = $this->db->get('tbl_users');
		$result = $query->row();
		return $result;		
	}

	function checkUsernameUnique($username,$id)
	{
		$this->db->where('id !=',$id);
		$this->db->where('username',$username);
		$query = $this->db->get('tbl_users');
		$result = $query->row();
		return $result;	
	}
	
	function checkUserExistByOldPassword($password,$userId)
	{
		$this->db->where('id',$userId);
		$this->db->where('password',$password);
		$query = $this->db->get('tbl_users');
		$result = $query->row();
		return $result;
	}

	function getAdminUserNamebyEditedId($id)
	{
		$this->db->select('username');
		$this->db->where('id',$id);
		$query = $this->db->get('tbl_users');
		$result = $query->row();
		if($result)
			return $result->username;
	}

	function getUserFullNameByUserId($id)
	{
		$this->db->select('*');
		$this->db->where('id',$id);
		$query = $this->db->get('tbl_users');
		$result = $query->row();
		return $result->first_name;
	}	

	function getUserEmailAddressByUserId($id)
	{
		$this->db->select('*');
		$this->db->where('id',$id);
		$query = $this->db->get('tbl_users');
		$result = $query->row();
		return $result->email;
	}

	function getSingleRecordById($id)
	{
		$this->db->select('*');
		$this->db->where('id',$id);
		$query = $this->db->get($this->table);
		$result = $query->row();
		return $result;
	}
	function countAllMembsersOnSite()
	{
		$this->db->select('id');	
		$id = $this->session->userdata('admin_id');
		$this->db->where('id !=',$id);	
		$query = $this->db->get($this->table);
		$result = $query->num_rows();
		return $result;
	}
	function get_user_by_id($id){
        
        $this->db->where('id', $id);
        $query = $this->db->get($this->table);      
        return $query->row();
    }

}