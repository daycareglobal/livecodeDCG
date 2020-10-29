<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Fees_availiability extends CI_Controller {
	
	function __construct() {
		Parent::__construct();
		$this->common_model->checkAdminLogin();
		$this->load->model('admin/Fees_availiability_model', 'fees_availiability');
	}

	function index()
	{   
		$output['page_title'] = 'Fees availiability';
		$output['left_menu'] = 'fees_availiability';
		$output['left_submenu'] = 'fees_availiability_list';
		$fees_availiability = $this->fees_availiability->get_user_business_list();
		foreach ($fees_availiability as $key => $value) {
        	$value->add_date = $this->common_model->getGMTDateToLocalDate($value->add_date);
		}
        $output['fees_availiability'] = $fees_availiability;
		$this->load->view('admin/includes/header',$output);
		$this->load->view('admin/fees_availiability/index');
		$this->load->view('admin/includes/footer');
	}

	function trading_timing($business_id) 
    {
		$output['page_title'] = 'Fees availiability';
		$output['left_menu'] = 'fees_availiability';
		$output['left_submenu'] = 'fees_availiability_list';
        $record	= $this->fees_availiability->get_trading_timing_by_business_id($business_id);
        $this->common_model->checkRequestedDataExists($record);
		
		foreach ($record as $key => $value) {
        	$value->add_date = $this->common_model->getGMTDateToLocalDate($value->add_date);
		}
		$output['trading_timing'] = $record;
        $this->load->view('admin/includes/header',$output);
		$this->load->view('admin/fees_availiability/trading_timming');
		$this->load->view('admin/includes/footer');
    }

    function base_room_groups($business_id) 
    {
		$output['page_title'] = 'Fees availiability';
		$output['left_menu'] = 'fees_availiability';
		$output['left_submenu'] = 'fees_availiability_list';
        $record	= $this->fees_availiability->get_room_by_business_id($business_id);
        $this->common_model->checkRequestedDataExists($record);
		foreach ($record as $key => $value) {
        	$value->add_date = $this->common_model->getGMTDateToLocalDate($value->add_date);
		}
		$output['base_room_groups'] = $record;
        $this->load->view('admin/includes/header',$output);
		$this->load->view('admin/fees_availiability/base_room_groups');
		$this->load->view('admin/includes/footer');
    }

    function non_funded_children($business_id) 
    {
		$output['page_title'] = 'Fees availiability';
		$output['left_menu'] = 'fees_availiability';
		$output['left_submenu'] = 'fees_availiability_list';
       	$output['groups'] = '';
        $groups	= $this->fees_availiability->get_groups($business_id);
        //$this->common_model->checkRequestedDataExists($groups);
        if ($groups) {
        	$businessGroups = $this->fees_availiability->get_group_by_business_id($business_id,'Non-Funded');
			foreach ($businessGroups as $key => $value) {
				$value->monthly_session_fees = $this->fees_availiability->getMonthlyGroupFeesByBusinessId($business_id,$value->business_group_id,'Non-Funded','different_sets');
				$output['total_monthly_session'] = count($value->monthly_session_fees);
				
				foreach ($value->monthly_session_fees as $k => $val) {
					$val->session_fees = $this->fees_availiability->getMonthlyFeesByBusinessId($business_id,'Non-Funded','different_sets', $val->business_session_type_id,$value->business_group_id);
				}
			}
			$output['groups'] = $groups;
			$output['businessGroups'] = $businessGroups;

        } else {
        	$funded_type = '';
        	$sessions = $this->fees_availiability->getSessionByBusiness($business_id, 'Non-Funded',$funded_type);

			foreach ($sessions as $key => $value) {
				$value->days = $this->fees_availiability->getDaysByBusinessSessionId($value->id);
			}
			$output['sessions'] = $sessions;
        	$monthly_session_fees_group = $this->fees_availiability->getMonthlyFeesGroupByBusinessId($business_id,'Non-Funded','same_sets');

			if ($monthly_session_fees_group) {

				foreach ($monthly_session_fees_group as $key => $value) {
					$value->session_fees = $this->fees_availiability->getMonthlyFeesByBusinessId($business_id,'Non-Funded','same_sets', $value->business_session_type_id);
				}
			}
			$output['monthly_session_fees'] = $monthly_session_fees_group;
        }
       
        $room_availiability = $this->fees_availiability->getRoomAvailiabilityByBusinessId($business_id,'Non-Funded');
		
		if ($room_availiability) {
			foreach ($room_availiability as $key => $value) {
				$value->rooms = $this->fees_availiability->getRooms($business_id,'Non-Funded',$value->room_id);
			}
		}
		$output['room_availiability'] = $room_availiability;
        $this->load->view('admin/includes/header',$output);
		$this->load->view('admin/fees_availiability/non_funded_children');
		$this->load->view('admin/includes/footer');
    }

    function funded_children() 
    {
    	$business_id = $_GET['bid'];
    	$funded_type = $_GET['funded_type'];
		$output['page_title'] = 'Fees availiability';
		$output['left_menu'] = 'fees_availiability';
		$output['left_submenu'] = 'fees_availiability_list';
       	$output['groups'] = '';
        $groups	= $this->fees_availiability->get_groups($business_id);
    	$sessions = $this->fees_availiability->getSessionByBusiness($business_id, 'Funded',$funded_type);
    	$age_type = '';
		
		foreach ($sessions as $key => $value) {
			$value->days = $this->fees_availiability->getDaysByBusinessSessionId($value->id);
		}
		$output['sessions'] = $sessions;
    	$monthly_session_fees_group = $this->fees_availiability->getFundedMonthlyFeesByBusinessId($business_id,'Funded',$age_type,$funded_type);

		if ($monthly_session_fees_group) {

			foreach ($monthly_session_fees_group as $key => $value) {
				$value->session_fees = $this->fees_availiability->getMonthlyFeesByBusinessId($business_id,'Funded',$age_type, $value->business_session_type_id);
			}
		}
		$room_availiability = $this->fees_availiability->getRoomAvailiabilityByBusinessId($business_id,'Funded');
		
		if ($room_availiability) {
			foreach ($room_availiability as $key => $value) {
				$value->rooms = $this->fees_availiability->getRooms($business_id,'Funded',$value->room_id);
			}
		}
		$output['funded_type'] = $funded_type;
		$output['monthly_session_fees'] = $monthly_session_fees_group;
		$output['room_availiability'] = $room_availiability;
        $this->load->view('admin/includes/header',$output);
		$this->load->view('admin/fees_availiability/funded_children');
		$this->load->view('admin/includes/footer');
    }
}