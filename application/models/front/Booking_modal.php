<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Booking_modal extends CI_Model {
	
    function __construct() 
    {
		parent::__construct();
		$this->table = 'tbl_payment';
	}

    function insertBooking($data){
        
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    function updateBooking($data, $id){
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
    }


    function getServices($address, $latitude, $longitude, $service_types, $check_in, $check_out, $radius)
    {
        $this->db->select('tbl_user_services.*');

        if (isset($latitude) && !empty($latitude)) {
            $this->db->where('(ACOS( SIN( RADIANS(`tbl_user_services`.`latitude` ) ) * SIN( RADIANS( "'.$latitude.'" ) ) + COS( RADIANS( `tbl_user_services`.`latitude` ) ) * COS( RADIANS( "'.$latitude.'" )) * COS( RADIANS( `tbl_user_services`.`longitude` ) - RADIANS( "'.$longitude.'" )) ) * 3959 < ("'.$radius.'"))');
        }

        if (isset($service_types) && !empty($service_types)) {
            $this->db->where('tbl_user_services.business_category_id', $service_types);
        }
        $data = $this->db->get('tbl_user_services');
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
        $this->db->where('id', $id);
        $data = $this->db->get('tbl_user_services');
        return $data->row();
    }

    function getBookingListByUserId($user_id)
    {
        $this->db->select('tbl_payment.*');
        $this->db->select('tbl_user_services.daycare_name, tbl_user_services.daycare_address');
        $this->db->join('tbl_user_services', 'tbl_user_services.id = tbl_payment.service_id');
        $this->db->where('tbl_payment.user_id', $user_id);
        $this->db->where('tbl_payment.payment_status', 'Success');
        $data = $this->db->get('tbl_payment');
        return $data->result();
    }

    function getBookingListByServiceId($service_id)
    {
        $this->db->select('tbl_payment.*');
        $this->db->select('tbl_user_services.daycare_name, tbl_user_services.daycare_address');
        $this->db->join('tbl_user_services', 'tbl_user_services.id = tbl_payment.service_id');
        $this->db->where_in('tbl_payment.service_id', $service_id);
        $this->db->where_in('tbl_payment.payment_status', 'Success');
        $data = $this->db->get('tbl_payment');
        return $data->result();
    }

    function getDaycareListByUserId($user_id)
    {
        $this->db->select('tbl_user_services.id');
        $this->db->where('tbl_user_services.user_id', $user_id);
        $data = $this->db->get('tbl_user_services');
        return $data->result();
    }
}