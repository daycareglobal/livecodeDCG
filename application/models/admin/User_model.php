<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class User_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->table = 'tbl_users';
	}

    function get_records()
    {
        $records = $this->db->get($this->table);
        return $records->result();
    }

    function getActiveRecords($user_type)
    {    
        $this->db->where('user_type',$user_type);
        $this->db->where('status','Active');
        $records = $this->db->get($this->table);
        return $records->result();
    }

    function getRecords($user_type)
    {
        $this->db->where('user_type',$user_type);
        $records = $this->db->get($this->table);
        return $records->result();
    }

    function get_record_by_id($id){
        
        $this->db->where('id', $id);
        // $this->db->where('user_type', 'User');
        $query = $this->db->get($this->table);      
        return $query->row();
    }

	function insert_record($data){
        
        $this->db->insert('tbl_users', $data);
        return $this->db->insert_id();
    }

    function insert_business_types($data) {
        $this->db->insert_batch('tbl_user_business_types', $data);
        return $this->db->insert_id();
    }

    function getSelectedBusinessTypes($user_id)
    {
        $this->db->where('user_id', $user_id);
        $records = $this->db->get('tbl_user_business_types');
        return $records->result();
    }

    function delete_business_types($user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->delete('tbl_user_business_types');
    }

    function changeStatusById($id,$status)
    {
        $this->db->where('id',$id);
        $this->db->update('tbl_users',array('status' => $status));
    }

    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tbl_users');
    }

    function doesEmailExist($email = '', $id = '')
    {
        $record = $this->db->get_where('tbl_users', array('email' => $email, 'id !=' => $id));
        $status = $record->row();
        if( $status )
            return TRUE;
        return FALSE;
    }

    function doesNumberExist($contact_number = '', $id = '')
    {
        $record = $this->db->get_where($this->table, array('contact_number' => $contact_number, 'id !=' => $id));
        $status = $record->row();
        if( $status )
            return TRUE;
        return FALSE;
    }

    function doesUserNameExist($username = '', $id = '')
    {
        $record = $this->db->get_where('tbl_users', array('username' => $username, 'id !=' => $id));
        $status = $record->row();
        if( $status )
            return TRUE;
        return FALSE;
    }

    function update_record($data, $id)
    {
        $this->db->where('id', $id);

        if ($this->db->update($this->table, $data)) {
            return true;

        } else{
            return false;
        }   
    }

    function getBusinessRecords($user_id)
    {
        $this->db->select('tbl_user_business_detail.*');
        $this->db->select('tbl_business_type.name as business_type');
        $this->db->select('cities.name as city_name');
        $this->db->select('states.name as state_name');
        $this->db->select('countries.name as country_name');
        $this->db->join('cities', 'cities.id = tbl_user_business_detail.city_id ');
        $this->db->join('states', 'states.id = tbl_user_business_detail.state_id ');
        $this->db->join('countries', 'countries.id = tbl_user_business_detail.country_id ');
        $this->db->join('tbl_business_type', 'tbl_business_type.id = tbl_user_business_detail.business_type_id ');
        $this->db->where('tbl_user_business_detail.user_id', $user_id);
        $query = $this->db->get('tbl_user_business_detail');      
        return $query->result();
    }

    function getBusinessRecordById($id)
    {
        $this->db->select('tbl_user_business_detail.*');
        $this->db->select('tbl_business_type.name as business_type');
        $this->db->select('cities.name as city_name');
        $this->db->select('states.name as state_name');
        $this->db->select('countries.name as country_name');
        $this->db->join('cities', 'cities.id = tbl_user_business_detail.city_id ');
        $this->db->join('states', 'states.id = tbl_user_business_detail.state_id ');
        $this->db->join('countries', 'countries.id = tbl_user_business_detail.country_id ');
        $this->db->join('tbl_business_type', 'tbl_business_type.id = tbl_user_business_detail.business_type_id ');
        $this->db->where('tbl_user_business_detail.id', $id);
        $query = $this->db->get('tbl_user_business_detail');      
        return $query->row();
    }

    function insert_business_record($data){
        
        $this->db->insert('tbl_user_business_detail', $data);
        return $this->db->insert_id();
    }

    function update_business_record($data, $id)
    {
        $this->db->where('id', $id);

        if ($this->db->update('tbl_user_business_detail', $data)) {
            return true;

        } else{
            return false;
        }   
    }

    function insert_special_education_record($data = array())
    {
        $this->db->insert_batch('tbl_user_special_education', $data);
    }

    function insert_curricular_activity_record($data = array())
    {
        $this->db->insert_batch('tbl_user_curricular_activity', $data);
    }

    function insert_service_type_record($data = array())
    {
        $this->db->insert_batch('tbl_user_service_type', $data);
    }

    function insert_own_education_record($data = array())
    {
        $this->db->insert_batch('tbl_user_own_education', $data);
    }

    function insert_own_activity_record($data = array())
    {
        $this->db->insert_batch('tbl_user_own_activity', $data);
    }

    function delete_selected_education($id)
    {
        $this->db->where('user_business_detail_id', $id);
        $this->db->delete('tbl_user_special_education');
    }

    function delete_selected_activity($id)
    {
        $this->db->where('user_business_detail_id', $id);
        $this->db->delete('tbl_user_curricular_activity');
    }

    function delete_selected_service_type($id)
    {
        $this->db->where('user_business_detail_id', $id);
        $this->db->delete('tbl_user_service_type');
    }

    function delete_selected_own_education($id)
    {
        $this->db->where('user_business_detail_id', $id);
        $this->db->delete('tbl_user_own_education');
    }

    function delete_selected_own_activity($id)
    {
        $this->db->where('user_business_detail_id', $id);
        $this->db->delete('tbl_user_own_activity');
    }

    function get_selected_education($id)
    {
        $this->db->select('tbl_user_special_education.*');
        $this->db->select('tbl_special_education.name');
        $this->db->join('tbl_special_education', 'tbl_special_education.id = tbl_user_special_education.special_education_id');
        $this->db->where('user_business_detail_id',$id);
        $records = $this->db->get('tbl_user_special_education');
        return $records->result();
    }

    function get_selected_activity($id)
    {
        $this->db->select('tbl_user_curricular_activity.*');
        $this->db->select('tbl_carricular_activities.name');
        $this->db->join('tbl_carricular_activities', 'tbl_carricular_activities.id = tbl_user_curricular_activity.curricular_activity_id');
        $this->db->where('user_business_detail_id',$id);
        $records = $this->db->get('tbl_user_curricular_activity');
        return $records->result();
    }

    function get_selected_service_type($id)
    {
        $this->db->select('tbl_user_service_type.*');
        $this->db->select('tbl_service_category.name');
        $this->db->join('tbl_service_category', 'tbl_service_category.id = tbl_user_service_type.service_type_id');
        $this->db->where('user_business_detail_id',$id);
        $records = $this->db->get('tbl_user_service_type');
        return $records->result();
    }

    function get_own_education($id)
    {
        $this->db->select('tbl_user_own_education.*');
        $this->db->where('user_business_detail_id',$id);
        $records = $this->db->get('tbl_user_own_education');
        return $records->result();
    }

    function get_own_activity($id)
    {
        $this->db->select('tbl_user_own_activity.*');
        $this->db->where('user_business_detail_id',$id);
        $records = $this->db->get('tbl_user_own_activity');
        return $records->result();
    }
}