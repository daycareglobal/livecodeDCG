<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Home_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

    function insertBusinessDetails($data){
        
        $this->db->insert('tbl_user_services', $data);
        return $this->db->insert_id();
    }

    function setServiceById($data, $id)
    {
        $this->db->where('id', $id);

        if ($this->db->update('tbl_user_services', $data)) {
            return true;

        } else{
            return false;
        }   
    }

    function getServiceById($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('tbl_user_services');      
        return $query->row();
    }

    function getHomePageContent($type)
    {
        $this->db->where('type', $type);
        $query = $this->db->get('tbl_home_page');      
        return $query->result();
    }

    function getValueBySlug($key = '', $value = false)
    {
        if($key != '')
        {
            $query = $this->db->get_where('tbl_home_page', array('slug' => $key));
            $option = $query->row();

            if (!empty($option)) {
                
                if ($value) {
                    return $option->value;
                } else {
                    return $option;
                }

            } else {
                return false;
            }

        } else {
            return false;
        }
    }

    function insertBusinessServiceTypes($data) {
        $this->db->insert_batch('tbl_user_service_types', $data);
        return $this->db->insert_id();
    }

    function insertBusinessServiceDays($data) {
        $this->db->insert_batch('tbl_user_services_days', $data);
        return $this->db->insert_id();
    }

    function insertBusinessServiceImages($data) {
        $this->db->insert_batch('tbl_user_services_images', $data);
        return $this->db->insert_id();
    }

    function getBusinessServiceImages($user_service_id)
    {        
        $this->db->where('user_service_id', $user_service_id);
        $query = $this->db->get('tbl_user_services_images');      
        return $query->result();
    }

    function deleteBusinessServiceImages($imageArrIds) {
        $this->db->where_in('id', $imageArrIds);
        $this->db->delete('tbl_user_services_images');
    }

    function deleteWorkingDays($user_service_id) {
        $this->db->where('user_service_id', $user_service_id);
        $this->db->delete('tbl_user_services_days');
    }

    function getUserBusinessServices($user_id)
    {        
        $this->db->select('tbl_user_services.*');
        $this->db->select('tbl_business_type.name');
        $this->db->join('tbl_business_type', 'tbl_business_type.id = tbl_user_services.business_category_id');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('tbl_user_services');      
        return $query->result();
    }

    function getUserBusinessImages($user_service_id)
    {
        $this->db->where('user_service_id', $user_service_id);
        $query = $this->db->get('tbl_user_services_images');      
        return $query->result();
    }

    function getUserBusinessServiceDays($user_service_id)
    {
        $this->db->where('user_service_id', $user_service_id);
        $query = $this->db->get('tbl_user_services_days');      
        return $query->result();
    }

    function getUserBusinessServiceTypes($user_service_id)
    {
        $this->db->select('tbl_user_service_types.id, is_available, service_type_id');
        $this->db->select('tbl_service_category.name, icon');
        $this->db->join('tbl_service_category', 'tbl_service_category.id = tbl_user_service_types.service_type_id');
        $this->db->where('tbl_user_service_types.business_service_id', $user_service_id);
        $this->db->where('tbl_user_service_types.is_available', 'Yes');
        $query = $this->db->get('tbl_user_service_types');      
        return $query->result();
    }

    function getSelectedBusinessServiceTypes($user_service_id)
    {
        $this->db->select('tbl_user_service_types.id, is_available, service_type_id');
        $this->db->select('tbl_service_category.name, icon');
        $this->db->join('tbl_service_category', 'tbl_service_category.id = tbl_user_service_types.service_type_id');
        $this->db->where('tbl_user_service_types.business_service_id', $user_service_id);
        $query = $this->db->get('tbl_user_service_types');      
        return $query->result();
    }

    function getAllBusinessByBusinessType($business_type_id)
    {        
        $this->db->select('tbl_user_services.*');
        $this->db->select('tbl_business_type.name');
        $this->db->select('tbl_users.rating');
        $this->db->join('tbl_business_type', 'tbl_business_type.id = tbl_user_services.business_category_id');
        $this->db->join('tbl_users', 'tbl_users.id = tbl_user_services.user_id');
        $this->db->where('tbl_user_services.business_category_id', $business_type_id);
        $this->db->where('tbl_users.status', 'Active');
        $query = $this->db->get('tbl_user_services');      
        return $query->result();
    }

    function getBusinessDetailById($id)
    {        
        $this->db->select('tbl_user_services.*');
        $this->db->select('tbl_business_type.name');
        $this->db->select('tbl_users.rating');
        $this->db->join('tbl_business_type', 'tbl_business_type.id = tbl_user_services.business_category_id');
        $this->db->join('tbl_users', 'tbl_users.id = tbl_user_services.user_id');
        $this->db->where('tbl_user_services.id', $id);
        $query = $this->db->get('tbl_user_services');      
        return $query->row();
    }

    function deleteBusinessService($id) {
        $this->db->where('id', $id);
        $this->db->delete('tbl_user_services');
    }

    function deleteBusinessServiceType($business_service_id) {
        $this->db->where('business_service_id', $business_service_id);
        $this->db->delete('tbl_user_service_types');
    }
}