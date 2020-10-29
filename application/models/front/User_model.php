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
        $this->db->select('tbl_users.*');
        $this->db->where('tbl_users.id', $id);
        $query = $this->db->get($this->table);      
        return $query->row();
    }

    function checkOTPExist($mobile_number){
        $this->db->select('tbl_opt.*');
        $this->db->where('tbl_opt.mobile_number', $mobile_number);
        // $this->db->where('tbl_opt.otp', $otp);
        $this->db->order_by('tbl_opt.id', 'DESC');
        $query = $this->db->get('tbl_opt');      
        return $query->row();
    }

    function checkForgotPasswordOTPExist($mobile_number){
        $this->db->where('contact_number', $mobile_number);
        $query = $this->db->get('tbl_users');      
        return $query->row();
    }

	function insert_record($data){
        
        $this->db->insert('tbl_users', $data);
        return $this->db->insert_id();
    }

    function insert_otp($data){
        
        $this->db->insert('tbl_opt', $data);
        return $this->db->insert_id();
    }

    function insert_business_types($data) {
        $this->db->insert_batch('tbl_user_business_types', $data);
        return $this->db->insert_id();
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
        // $this->db->select('cities.name as city_name');
        $this->db->select('states.name as state_name');
        $this->db->select('countries.name as country_name');
        // $this->db->join('cities', 'cities.id = tbl_user_business_detail.city_id ');
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
        // $this->db->select('cities.name as city_name');
        $this->db->select('states.name as state_name');
        $this->db->select('countries.name as country_name');
        // $this->db->join('cities', 'cities.id = tbl_user_business_detail.city_id ');
        $this->db->join('states', 'states.id = tbl_user_business_detail.state_id ');
        $this->db->join('countries', 'countries.id = tbl_user_business_detail.country_id ');
        $this->db->join('tbl_business_type', 'tbl_business_type.id = tbl_user_business_detail.business_type_id ');
        $this->db->where('tbl_user_business_detail.id', $id);
        $query = $this->db->get('tbl_user_business_detail');      
        return $query->row();
    }

    function insert_business_record($data)
    {        
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
        $this->db->where('user_service_detail_id', $id);
        $this->db->delete('tbl_user_special_education');
    }

    function delete_selected_activity($id)
    {
        $this->db->where('user_service_detail_id', $id);
        $this->db->delete('tbl_user_curricular_activity');
    }

    function delete_selected_service_type($id)
    {
        $this->db->where('user_service_detail_id', $id);
        $this->db->delete('tbl_user_service_type');
    }

    function delete_selected_own_education($id)
    {
        $this->db->where('user_service_detail_id', $id);
        $this->db->delete('tbl_user_own_education');
    }

    function delete_selected_own_activity($id)
    {
        $this->db->where('user_service_detail_id', $id);
        $this->db->delete('tbl_user_own_activity');
    }

    function get_selected_education($id)
    {
        $this->db->select('tbl_user_special_education.*');
        $this->db->select('tbl_special_education.name');
        $this->db->join('tbl_special_education', 'tbl_special_education.id = tbl_user_special_education.special_education_id');
        $this->db->where('user_service_detail_id',$id);
        $records = $this->db->get('tbl_user_special_education');
        return $records->result();
    }

    function get_selected_own_education($id)
    {
        $this->db->select('tbl_user_own_education.*');
        $this->db->where('user_service_detail_id',$id);
        $records = $this->db->get('tbl_user_own_education');
        return $records->result();
    }

    function get_selected_activity($id)
    {
        $this->db->select('tbl_user_curricular_activity.*');
        $this->db->select('tbl_carricular_activities.name');
        $this->db->join('tbl_carricular_activities', 'tbl_carricular_activities.id = tbl_user_curricular_activity.curricular_activity_id');
        $this->db->where('user_service_detail_id',$id);
        $records = $this->db->get('tbl_user_curricular_activity');
        return $records->result();
    }

    function get_selected_own_activity($id)
    {
        $this->db->select('tbl_user_own_activity.*');
        $this->db->where('user_service_detail_id',$id);
        $records = $this->db->get('tbl_user_own_activity');
        return $records->result();
    }

    function get_selected_service_type($id)
    {
        $this->db->select('tbl_user_service_type.*');
        $this->db->select('tbl_service_category.name');
        $this->db->join('tbl_service_category', 'tbl_service_category.id = tbl_user_service_type.service_type_id');
        $this->db->where('user_service_detail_id',$id);
        $records = $this->db->get('tbl_user_service_type');
        return $records->result();
    }

    function get_own_education($id)
    {
        $this->db->select('tbl_user_own_education.*');
        $this->db->where('user_service_detail_id',$id);
        $records = $this->db->get('tbl_user_own_education');
        return $records->result();
    }

    function get_own_activity($id)
    {
        $this->db->select('tbl_user_own_activity.*');
        $this->db->where('user_service_detail_id',$id);
        $records = $this->db->get('tbl_user_own_activity');
        return $records->result();
    }

    function checkValidUser($user)
    {
        $this->db->where($user);
        $records = $this->db->get($this->table);
        return $records->row();
    }

    function checkValidUser1($user, $login_id)
    {
        $this->db->where($user);
        $this->db->group_start();
            $this->db->where('email', $login_id);
            $this->db->or_where('contact_number', $login_id);
        $this->db->group_end();
        $records = $this->db->get($this->table);
        return $records->row();
    }

    function get_user_by_email_verified_key($email_verified_key){
        
        $this->db->where('email_verified_key', $email_verified_key);
        $query = $this->db->get($this->table);      
        return $query->row();
    }

    function getUserByForgotPasswordKey($forgot_password_key){
        
        $this->db->where('forgot_password_key', $forgot_password_key);
        $query = $this->db->get($this->table);      
        return $query->row();
    }

    function getUserByEmailId($email)
    {        
        $this->db->where('email', $email);
        $this->db->where('user_type', 'User');
        $query = $this->db->get($this->table);      
        return $query->row();
    }

    function getUserByMobile($mobile_number)
    {        
        $this->db->where('contact_number', $mobile_number);
        $query = $this->db->get($this->table);      
        return $query->row();
    }

    function checkExpireTime($email,$key)// this function is used to check Expire Time.
    {
        $time = date('Y-m-d H:i:s');
        $this->db->where('expire_time >',$time);
        $this->db->where('email',$email);
        $this->db->where('forgot_password_key',$key);
        $query = $this->db->get('tbl_users');
        $result = $query->row();
        return $result;
    }

    function insert_user_plan_temp($data)
    {    
        $this->db->insert('tbl_user_membership_plan_temp', $data);
        return $this->db->insert_id();
    }

    function insert_user_plan($data)
    {    
        $this->db->insert('tbl_user_membership_plan', $data);
        return $this->db->insert_id();
    }

    function insert_provision_data_temp($data = array())
    {    
        $this->db->insert_batch('tbl_user_service_type_temp', $data);
    }

    function insert_provision_data($data = array())
    {    
        $this->db->insert_batch('tbl_user_provisions', $data);
    }

    function getUserPlanById($user_plan_id)
    {
        $this->db->select('tbl_user_membership_plan_temp.*');
        $this->db->select('tbl_users.name, tbl_users.email');
        $this->db->join('tbl_users', 'tbl_user_membership_plan_temp.user_id = tbl_users.id');
        $this->db->where('tbl_user_membership_plan_temp.id',$user_plan_id);
        $query = $this->db->get('tbl_user_membership_plan_temp');
        $result = $query->row();
        return $result;
    }

    function getUserPlanByUserId($user_id, $plan_status = null)
    {
        $this->db->select('tbl_user_membership_plan.*');
        $this->db->where('tbl_user_membership_plan.user_id', $user_id);

        if ($plan_status) {
            $this->db->where('tbl_user_membership_plan.plan_status', $plan_status);
        }
        $query = $this->db->get('tbl_user_membership_plan');
        $result = $query->row();
        return $result;
    }

    function getUserServiceByPlanId($user_plan_id)
    {
        $this->db->where('tbl_user_service_type_temp.user_plan_id',$user_plan_id);
        $query = $this->db->get('tbl_user_service_type_temp');
        $result = $query->result();
        return $result;
    }

    function delete_user_membership_temp_data($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tbl_user_membership_plan_temp');
        $this->delete_service_temp_data($id);
    }

    function delete_service_temp_data($id)
    {
        $this->db->where('user_plan_id', $id);
        $this->db->delete('tbl_user_service_type_temp');
    }

    function checkUserExistByOldPassword($password, $userId)
    {
        $this->db->where('id', $userId);
        $this->db->where('password', $password);
        $query = $this->db->get('tbl_users');
        $result = $query->row();
        return $result;
    }

    function check_already_request($user_id)
    {
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('tbl_user_email_temp');
        $result = $query->row();
        return $result;
    }

    function update_user_email($data, $id)
    {
        $this->db->where('id', $id);

        if ($this->db->update('tbl_user_email_temp', $data)) {
            return true;

        } else{
            return false;
        }   
    }

    protected function _update($data, $id)
    {
        $this->db->set($data);
        $this->db->where('id', $id);
        $this->db->update('tbl_user_email_temp');
    }

    function insert_user_email($data)
    {        
        $this->db->insert('tbl_user_email_temp', $data);
        return $this->db->insert_id();
    }

    function get_email_verified_key_data($email_verified_key)
    {        
        $this->db->where('email_verified_key', $email_verified_key);
        $query = $this->db->get('tbl_user_email_temp');      
        return $query->row();
    }

    function delete_temp_email($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tbl_user_email_temp');
    }

    function getUserBusinesRecords($user_id)
    {
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('tbl_user_business_detail');      
        return $query->result();
    }

    // function getUserPlanServices($user_id)
    // {
    //     $this->db->select('tbl_user_provisions.*');
    //     $this->db->select('tbl_service_category.name');
    //     $this->db->join('tbl_service_category', 'tbl_service_category.id = tbl_user_provisions.service_type_id');
    //     $this->db->join('tbl_user_membership_plan', 'tbl_user_membership_plan.id = tbl_user_provisions.user_plan_id');
    //     $this->db->where('tbl_user_provisions.user_id', $user_id);
    //     $this->db->where('tbl_user_membership_plan.plan_status', 'Running');
    //     $records = $this->db->get('tbl_user_provisions');
    //     return $records->result();
    // }

    function getUserPlanServices($user_id)
    {
        $user_last_plan = $this->getUserLastPlan($user_id);

        if ($user_last_plan) {
            $this->db->select('tbl_user_provisions.*');
            $this->db->select('tbl_service_category.name');
            $this->db->join('tbl_service_category', 'tbl_service_category.id = tbl_user_provisions.service_type_id');
            $this->db->where('tbl_user_provisions.user_id', $user_id);
            $this->db->where('tbl_user_provisions.user_plan_id', $user_last_plan->id);
            $this->db->order_by('tbl_service_category.name', 'ASC');
            $records = $this->db->get('tbl_user_provisions');
            return $records->result();
        } else {
            return FALSE;
        }
    }

    function getUserLastPlan($user_id) {
        $this->db->where('user_id',$user_id);
        $this->db->order_by('add_date','DESC');
        $records = $this->db->get('tbl_user_membership_plan');
        return $records->row();
    }

    function getProvisionsByServiceId($user_id, $service_type_id)
    {
        $this->db->select('tbl_user_provisions.*');
        $this->db->where('tbl_user_provisions.user_id', $user_id);
        $this->db->where('tbl_user_provisions.service_type_id', $service_type_id);
        $records = $this->db->get('tbl_user_provisions');
        return $records->row();
    }

    function getBusinessByServiceId($user_id, $service_type_id)
    {
        $this->db->select('tbl_user_business_detail.*');
        $this->db->where('tbl_user_business_detail.user_id', $user_id);
        $this->db->where('tbl_user_business_detail.service_type_id', $service_type_id);
        $records = $this->db->get('tbl_user_business_detail');
        return $records->num_rows();
    }

    function getServiceRecordById($user_id, $service_type_id)
    {
        $this->db->select('tbl_user_service_detail.*');
        $this->db->where('tbl_user_service_detail.user_id', $user_id);
        $this->db->where('tbl_user_service_detail.service_type_id', $service_type_id);
        $records = $this->db->get('tbl_user_service_detail');
        return $records->row();
    }

    function getServiceRecordByRecordId($user_service_detail_id)
    {
        $this->db->select('tbl_user_service_detail.*');
        $this->db->where('tbl_user_service_detail.id', $user_service_detail_id);
        $records = $this->db->get('tbl_user_service_detail');
        return $records->row();
    }

    function delete_business_detail($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tbl_user_business_detail');

        if ($this->db->affected_rows() > 0) {
            return $this->db->affected_rows();
        } else {
            return FALSE;
        }
    }

    function insert_service_record($data)
    {        
        $this->db->insert('tbl_user_service_detail', $data);
        return $this->db->insert_id();
    }

    function update_service_record($data, $id)
    {
        $this->db->where('id', $id);

        if ($this->db->update('tbl_user_service_detail', $data)) {
            return $id;

        } else{
            return false;
        }   
    }

    function getUserBusinessWithService($user_id)
    {
        $this->db->select('tbl_user_business_detail.*');
        $this->db->select('tbl_service_category.name as service_name');
        $this->db->join('tbl_service_category','tbl_user_business_detail.service_type_id = tbl_service_category.id');
        $this->db->where('tbl_user_business_detail.user_id', $user_id);
        $query = $this->db->get('tbl_user_business_detail');
        return $query->result();
    }

    function getUserBusinesRecordByUserId($user_id, $business_id)
    {
        $this->db->where('id', $business_id);
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('tbl_user_business_detail');      
        return $query->row();
    }

    function deleteUserBusinessTiming($business_ids)
    {
        $this->db->where_in('business_id', $business_ids);
        $this->db->delete('tbl_business_timming');

        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function deleteUserBusinessRoomAvailability($business_ids)
    {
        $this->db->where_in('business_id', $business_ids);
        $this->db->delete('tbl_busness_rooms_availability');

        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function deleteUserBusinessRooms($business_ids)
    {
        $this->db->where_in('business_id', $business_ids);
        $this->db->delete('tbl_business_room');

        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function deleteUserBusinessMonthlyFees($business_ids)
    {
        $this->db->where_in('business_id', $business_ids);
        $this->db->delete('tbl_business_monthly_fees');

        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function deleteUserBusinessSessions($business_ids)
    {
        $this->db->where_in('business_id', $business_ids);
        $this->db->delete('tbl_business_session_type');

        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function deleteUserBusinessSessionsDays($business_ids)
    {
        $this->db->where_in('business_id', $business_ids);
        $this->db->delete('tbl_business_session_type_days');

        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function deleteUserBusinessAgeGroup($business_ids)
    {
        $this->db->where_in('business_id', $business_ids);
        $this->db->delete('tbl_business_non_funded_age_group');

        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function deleteUserBusiness($business_ids)
    {
        $this->db->where_in('id', $business_ids);
        $this->db->delete('tbl_user_business_detail');

        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function getUserProvisions($user_id)
    {
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('tbl_user_provisions');      
        return $query->result();
    }

    function deleteUserServices($user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->delete('tbl_user_service_detail');

        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function deleteUserServices_temp($user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->delete('tbl_user_service_type_temp');

        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function deleteUserProvisions($user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->delete('tbl_user_provisions');

        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function deleteUserSpecialEducation($user_service_detail_ids)
    {
        $this->db->where_in('user_service_detail_id', $user_service_detail_ids);
        $this->db->delete('tbl_user_special_education');

        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function deleteUserActivity($user_service_detail_ids)
    {
        $this->db->where_in('user_service_detail_id', $user_service_detail_ids);
        $this->db->delete('tbl_user_curricular_activity');

        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function deleteUserOwnActivity($user_service_detail_ids)
    {
        $this->db->where_in('user_service_detail_id', $user_service_detail_ids);
        $this->db->delete('tbl_user_own_activity');

        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function deleteUserOwnEducation($user_service_detail_ids)
    {
        $this->db->where_in('user_service_detail_id', $user_service_detail_ids);
        $this->db->delete('tbl_user_own_education');

        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function deleteUserSentEmails($user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->delete('tbl_sent_emails');

        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function deleteUserSaveQuotes($business_ids)
    {
        $this->db->where_in('business_id', $business_ids);
        $this->db->delete('tbl_save_quote');

        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function deleteUserEmail_temp($user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->delete('tbl_user_email_temp');

        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function deleteUserMembershipPlan_temp($user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->delete('tbl_user_membership_plan_temp');

        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function deleteUserMembershipPlan($user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->delete('tbl_user_membership_plan');

        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function updateOldPlanStatus($data, $id)
    {
        $this->db->where('id', $id);

        if ($this->db->update('tbl_user_membership_plan', $data)) {
            return true;

        } else{
            return false;
        }   
    }

    function deleteUserBusinessTiming_byBusinessId($business_id)
    {
        $this->db->where('business_id', $business_id);
        $this->db->delete('tbl_business_timming');

        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function deleteUserBusinessRoomAvailability_byBusinessId($business_id)
    {
        $this->db->where('business_id', $business_id);
        $this->db->delete('tbl_busness_rooms_availability');

        if ($this->db->affected_rows() > 0) {
            return $this->db->affected_rows();
        } else {
            return FALSE;
        }
    }

    function deleteUserBusinessRooms_byBusinessId($business_id)
    {
        $this->db->where('business_id', $business_id);
        $this->db->delete('tbl_business_room');

        if ($this->db->affected_rows() > 0) {
            return $this->db->affected_rows();
        } else {
            return FALSE;
        }
    }

    function deleteUserBusinessMonthlyFees_byBusinessId($business_id)
    {
        $this->db->where('business_id', $business_id);
        $this->db->delete('tbl_business_monthly_fees');

        if ($this->db->affected_rows() > 0) {
            return $this->db->affected_rows();
        } else {
            return FALSE;
        }
    }

    function deleteUserBusinessSessions_byBusinessId($business_id)
    {
        $this->db->where('business_id', $business_id);
        $this->db->delete('tbl_business_session_type');

        if ($this->db->affected_rows() > 0) {
            return $this->db->affected_rows();
        } else {
            return FALSE;
        }
    }

    function deleteUserBusinessSessionsDays_byBusinessId($business_id)
    {
        $this->db->where('business_id', $business_id);
        $this->db->delete('tbl_business_session_type_days');

        if ($this->db->affected_rows() > 0) {
            return $this->db->affected_rows();
        } else {
            return FALSE;
        }
    }

    function deleteUserBusinessAgeGroup_byBusinessId($business_id)
    {
        $this->db->where('business_id', $business_id);
        $this->db->delete('tbl_business_non_funded_age_group');

        if ($this->db->affected_rows() > 0) {
            return $this->db->affected_rows();
        } else {
            return FALSE;
        }
    }

    function deleteUserSaveQuotes_byBusinessId($business_id)
    {
        $this->db->where('business_id', $business_id);
        $this->db->delete('tbl_save_quote');

        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}