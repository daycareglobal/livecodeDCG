<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Fees_availiability_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->table = 'tbl_user_business_detail';
	}

    function get_user_business_list()
    {
        $this->db->select('tbl_user_business_detail.*');
        $this->db->select('tbl_users.name, tbl_users.last_name');
        $this->db->select('tbl_service_category.name as service_name');
        $this->db->join('tbl_users', 'tbl_users.id = tbl_user_business_detail.user_id');
        $this->db->join('tbl_service_category','tbl_user_business_detail.service_type_id = tbl_service_category.id');
        $query = $this->db->get('tbl_user_business_detail');
        return $query->result();
    }

    function get_trading_timing_by_business_id($business_id)
    {
        $this->db->select('tbl_business_timming.*');
        $this->db->where('tbl_business_timming.business_id', $business_id);
        $query = $this->db->get('tbl_business_timming');      
        return $query->result();
    }

    function get_room_by_business_id($business_id)
    {
        $this->db->select('tbl_business_room.*');
        $this->db->where('tbl_business_room.business_id', $business_id);
        $query = $this->db->get('tbl_business_room');
        return $query->result();
    }
    // group
    function get_groups($business_id)
    {
        $this->db->select('tbl_business_non_funded_age_group.*');
        $this->db->where('tbl_business_non_funded_age_group.business_id', $business_id);
        $query = $this->db->get('tbl_business_non_funded_age_group');
        return $query->result();
    }

    function get_group_by_business_id($business_id, $fees_type) {
        $this->db->select('tbl_business_monthly_fees.id,tbl_business_monthly_fees.business_group_id,tbl_business_monthly_fees.week_per_year');
        $this->db->select('tbl_business_non_funded_age_group.from_month,tbl_business_non_funded_age_group.to_month');
        $this->db->join('tbl_business_non_funded_age_group','tbl_business_non_funded_age_group.id = tbl_business_monthly_fees.business_group_id', 'left');
        $this->db->where('tbl_business_monthly_fees.business_id', $business_id);
        $this->db->where('tbl_business_monthly_fees.fees_type', $fees_type);
        $this->db->group_by('tbl_business_monthly_fees.business_group_id');
        $query = $this->db->get('tbl_business_monthly_fees');
        return $query->result();
    }

    function getMonthlyGroupFeesByBusinessId($business_id,$business_group_id, $fees_type,$age_type = null) {
       $this->db->select('tbl_business_monthly_fees.business_session_type_id, tbl_business_monthly_fees.id,tbl_business_monthly_fees.business_group_id,tbl_business_monthly_fees.week_per_year');
        $this->db->select('tbl_session_type.session_name');
        $this->db->select('tbl_business_non_funded_age_group.from_month,tbl_business_non_funded_age_group.to_month');
        $this->db->join('tbl_session_type','tbl_session_type.id = tbl_business_monthly_fees.business_session_type_id', 'left');
        $this->db->join('tbl_business_non_funded_age_group','tbl_business_non_funded_age_group.id = tbl_business_monthly_fees.business_group_id', 'left');
        $this->db->where('tbl_business_monthly_fees.business_id', $business_id);
        $this->db->where('tbl_business_monthly_fees.business_group_id', $business_group_id);
        $this->db->where('tbl_business_monthly_fees.fees_type', $fees_type);

        if ($age_type) {
            $this->db->where('tbl_business_monthly_fees.age_type', $age_type);
        }
        $this->db->group_by('tbl_business_monthly_fees.business_session_type_id');
        //$this->db->group_by('tbl_business_monthly_fees.business_group_id');
        $query = $this->db->get('tbl_business_monthly_fees');
        return $query->result();
    }

    function getMonthlyFeesByBusinessId($business_id, $fees_type, $age_type = null, $business_session_type_id = null,  $business_group_id = null) {
        $this->db->select('tbl_business_monthly_fees.*');
        $this->db->select('tbl_session_type.session_name');
        $this->db->join('tbl_session_type','tbl_session_type.id = tbl_business_monthly_fees.business_session_type_id', 'left');
        $this->db->where('tbl_business_monthly_fees.business_id', $business_id);
        $this->db->where('tbl_business_monthly_fees.fees_type', $fees_type);

        if ($age_type) {
            $this->db->where('tbl_business_monthly_fees.age_type', $age_type);
        }

        if ($business_session_type_id) { 
            $this->db->where('tbl_business_monthly_fees.business_session_type_id', $business_session_type_id);
        }

        if ($business_group_id) { 
            $this->db->where('tbl_business_monthly_fees.business_group_id', $business_group_id);
        }
        $query = $this->db->get('tbl_business_monthly_fees');
        return $query->result();
    }

    function getMonthlyFeesGroupByBusinessId($business_id, $fees_type, $age_type = null) {

        $this->db->select('tbl_business_monthly_fees.business_session_type_id, tbl_business_monthly_fees.id');
        $this->db->select('tbl_session_type.session_name');
        $this->db->join('tbl_session_type','tbl_session_type.id = tbl_business_monthly_fees.business_session_type_id', 'left');
        $this->db->where('tbl_business_monthly_fees.business_id', $business_id);
        $this->db->where('tbl_business_monthly_fees.fees_type', $fees_type);
        
        if ($age_type) {
            $this->db->where('tbl_business_monthly_fees.age_type', $age_type);
        }
        $this->db->group_by('tbl_business_monthly_fees.business_session_type_id');
        $query = $this->db->get('tbl_business_monthly_fees');
        return $query->result();
    }

    function getFundedMonthlyFeesByBusinessId($business_id, $fees_type, $age_type = null,$funded_type = null) {
        $this->db->select('tbl_business_monthly_fees.business_session_type_id, tbl_business_monthly_fees.id');
        
        $this->db->select('tbl_session_type.session_name');
        $this->db->select('tbl_business_session_type.funded_age_group');
        $this->db->join('tbl_business_session_type','tbl_business_session_type.id = tbl_business_monthly_fees.business_session_type_id');
        $this->db->join('tbl_session_type','tbl_session_type.id = tbl_business_monthly_fees.business_session_type_id', 'left');

        $this->db->where('tbl_business_monthly_fees.business_id', $business_id);
        $this->db->where('tbl_business_monthly_fees.fees_type', $fees_type);
        
        if ($age_type) {
            $this->db->where('tbl_business_monthly_fees.age_type', $age_type);
        }

        if ($funded_type) {
            $this->db->where('tbl_business_session_type.funded_age_group', $funded_type);
        }

        $this->db->group_by('tbl_business_monthly_fees.business_session_type_id');
        $query = $this->db->get('tbl_business_monthly_fees');
        return $query->result();
    }

    function getSessionByBusiness($business_id, $fees_type, $funded_type = null)
    {
        $this->db->select('tbl_business_session_type.*');
        $this->db->select('tbl_session_type.session_name');
        $this->db->join('tbl_session_type','tbl_session_type.id = tbl_business_session_type.session_type_id', 'left');
        $this->db->where('tbl_business_session_type.business_id', $business_id);
        $this->db->where('tbl_business_session_type.fees_type', $fees_type);
        
        if ($funded_type)
            $this->db->where('tbl_business_session_type.funded_age_group', $funded_type);
        $query = $this->db->get('tbl_business_session_type');
        return $query->result();
    }


    function getDaysByBusinessSessionId($business_session_type_id)
    {
        $this->db->select('tbl_business_session_type_days.*');
        $this->db->where('tbl_business_session_type_days.business_session_type_id', $business_session_type_id);
        $query = $this->db->get('tbl_business_session_type_days');
        return $query->result();
    }

    function getRoomAvailiabilityByBusinessId($business_id, $fees_type) {
        $this->db->select('tbl_busness_rooms_availability.id,tbl_busness_rooms_availability.room_id,tbl_busness_rooms_availability.customer_option,tbl_busness_rooms_availability.week_type');
        $this->db->select('tbl_terms.term_name');
        $this->db->select('tbl_business_room.room_name');
        $this->db->join('tbl_terms','tbl_terms.id = tbl_busness_rooms_availability.term_id', 'left');
        $this->db->join('tbl_business_room','tbl_business_room.id = tbl_busness_rooms_availability.room_id', 'left');
        $this->db->where('tbl_busness_rooms_availability.business_id', $business_id);
        $this->db->where('tbl_busness_rooms_availability.fees_type', $fees_type);
        $this->db->group_by('tbl_busness_rooms_availability.room_id');
        $query = $this->db->get('tbl_busness_rooms_availability');
        return $query->result();
    }

    function getRooms($business_id, $fees_type,$room_id) {
        $this->db->select('tbl_busness_rooms_availability.*');
        $this->db->select('tbl_terms.term_name');
        $this->db->select('tbl_business_room.room_name');
        $this->db->join('tbl_terms','tbl_terms.id = tbl_busness_rooms_availability.term_id', 'left');
        $this->db->join('tbl_business_room','tbl_business_room.id = tbl_busness_rooms_availability.room_id', 'left');
        $this->db->where('tbl_busness_rooms_availability.business_id', $business_id);
        $this->db->where('tbl_busness_rooms_availability.fees_type', $fees_type);
        $this->db->where('tbl_busness_rooms_availability.room_id', $room_id);
        $query = $this->db->get('tbl_busness_rooms_availability');
        return $query->result();
    }

    function get_quote_detail_by_id($id) {
        $this->db->select('tbl_user_quote.*');
        $this->db->where('tbl_user_quote.id', $id);
        $query = $this->db->get('tbl_user_quote');
        $result = $query->row();
        return $result;
    }
}