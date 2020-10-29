<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Service_modal extends CI_Model {
	
    function __construct() 
    {
		parent::__construct();
		$this->table = 'tbl_user_services';
	}

    function getServices($address, $latitude, $longitude, $service_types, $check_in, $check_out, $radius)
    {
        $this->db->select('tbl_user_services.*');
        $this->db->select('tbl_users.rating');

        if (isset($latitude) && !empty($latitude)) {
            $this->db->where('(ACOS( SIN( RADIANS(`tbl_user_services`.`latitude` ) ) * SIN( RADIANS( "'.$latitude.'" ) ) + COS( RADIANS( `tbl_user_services`.`latitude` ) ) * COS( RADIANS( "'.$latitude.'" )) * COS( RADIANS( `tbl_user_services`.`longitude` ) - RADIANS( "'.$longitude.'" )) ) * 3959 < ("'.$radius.'"))');
            // $this->db->select('(ACOS( SIN( RADIANS(`tbl_user_services`.`latitude` ) ) * SIN( RADIANS( "'.$latitude.'" ) ) + COS( RADIANS( `tbl_user_services`.`latitude` ) ) * COS( RADIANS( "'.$latitude.'" )) * COS( RADIANS( `tbl_user_services`.`longitude` ) - RADIANS( "'.$longitude.'" )) ) * 3959) as t_d');
        }

        if (isset($service_types) && !empty($service_types)) {
            $this->db->where('tbl_user_services.business_category_id', $service_types);
        }

        $this->db->join('tbl_users', 'tbl_users.id = tbl_user_services.user_id');
        $this->db->where('tbl_users.status', 'Active');
        $data = $this->db->get('tbl_user_services');
        // pr($this->db->last_query());
        // pr( $data->result()); die;
        return $data->result();
    }

     function getServiceTypeById($id)
    {
        $this->db->where('status', 'Active');
        $this->db->where('is_delete', 'No');
        $this->db->where('id', $id);
        $records = $this->db->get('tbl_business_type');
        return $records->row();
    }


    function getServiceImages($service_id){
        $this->db->where('user_service_id', $service_id);
        $data = $this->db->get('tbl_user_services_images');
        return $data->result();
    } 

    function getServiceDays($service_id){
        $this->db->where('user_service_id', $service_id);
        $data = $this->db->get('tbl_user_services_days');
        return $data->result();
    }

    function getProvidedServices($service_id){
        $this->db->select('tbl_user_provided_services.*');
        $this->db->select('tbl_service_category.name');
        $this->db->join('tbl_service_category', 'tbl_service_category.id = tbl_user_provided_services.service_id');
        $this->db->where('user_service_id', $service_id);
        $data = $this->db->get('tbl_user_provided_services');
        return $data->result();
    }

    function getServiceByID($id)
    {
        $this->db->select('tbl_user_services.*');
        $this->db->select('tbl_users.rating');
        $this->db->join('tbl_users', 'tbl_users.id = tbl_user_services.user_id');
        $this->db->where('tbl_user_services.id', $id);
        $data = $this->db->get('tbl_user_services');
        return $data->row();
    }
}