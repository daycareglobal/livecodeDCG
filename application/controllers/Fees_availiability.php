<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fees_availiability extends CI_Controller {
	
	function __construct() {
		Parent::__construct();
		$this->common_model->checkChildcareLogin();
		$this->load->model('front/user_model', 'users');
		$this->load->model('front/fees_availiability_model', 'fees_availiability');
		$this->load->model('mailsending_model','mailsending');
		$this->childcare_id = $this->session->userdata('childcare_id');
		// $this->common_model->checkChildcarePlanPurchase();
	}
	
	public function index() {
		$output['page'] = 'dashboard';
		$output['page_active'] = 'fees_availiability';
		$output['business_provisions'] = $this->users->getUserBusinessWithService($this->childcare_id);

		$this->load->view('front/includes/header', $output);
		$this->load->view('front/fees_availiability/index');
		$this->load->view('front/includes/footer');
	}

	function trading_timming($business_id)
	{
		$getBusinessDetail = $this->fees_availiability->getBusinessDetailById($business_id, $this->childcare_id);
		$this->common_model->checkRequestedDataExists($getBusinessDetail);

		$output['page'] = 'dashboard';
		$output['page_active'] = 'fees_availiability';
		$trading_timming = $this->fees_availiability->getTradingTimingByBusinessId($business_id);
		$provision_record = $this->users->getBusinessRecordById($business_id);
		$output['provision_record'] = $provision_record;
		$day = array();

		if ($trading_timming) {

			foreach ($trading_timming as $key => $value) {
				$day[$value->trading_day]['trading_day'] = $value->trading_day;
				$day[$value->trading_day]['from_time'] = $value->from_time;
				$day[$value->trading_day]['to_time'] = $value->to_time;
				$day[$value->trading_day]['available'] = $value->available;
			}
		}
		$output['trading_timming'] = $day;
		$this->load->view('front/includes/header', $output);
		$this->load->view('front/fees_availiability/trading_days_hours');
		$this->load->view('front/includes/footer');
	}

	function update_timing()
	{
		$input = array();
		$date = date('Y-m-d', time());

		if (($this->input->post('monday_from_time')) || ($this->input->post('monday_to_time'))) {
			$start_time = $this->input->post('monday_from_time');
			$end_time = $this->input->post('monday_to_time');

			$start_date_time = strtotime("$date $start_time");
			$end_date_time = strtotime("$date $end_time");

			if ($start_date_time < $end_date_time) {
				$monday = $this->input->post('monday');

				if ($monday) {
					$input['available'] = 'Yes';

				} else {
					$input['available'] = 'No';
				}
				$input['trading_day'] = 'Monday';
				$input['from_time'] = $this->input->post('monday_from_time');
				$input['to_time'] = $this->input->post('monday_to_time');
				$input['business_id'] = $this->input->post('business_id');

				$checkAlreadySubmitted = $this->fees_availiability->getBusinessTimingByDay($this->input->post('business_id'), 'Monday');
				$failier = false;

			} else {
				$failier = true;
				$success = false;
				$message = "Your time is not correct.";
			}

		} else if (($this->input->post('tuesday_from_time')) || ($this->input->post('tuesday_to_time'))) {

			$start_time = $this->input->post('tuesday_from_time');
			$end_time = $this->input->post('tuesday_to_time');

			$start_date_time = strtotime("$date $start_time");
			$end_date_time = strtotime("$date $end_time");

			if ($start_date_time < $end_date_time) {
				$tuesday = $this->input->post('tuesday');

				if ($tuesday) {
					$input['available'] = 'Yes';

				} else {
					$input['available'] = 'No';
				}
				$input['trading_day'] = 'Tuesday';
				$input['from_time'] = $this->input->post('tuesday_from_time');
				$input['to_time'] = $this->input->post('tuesday_to_time');
				$input['business_id'] = $this->input->post('business_id');

				$checkAlreadySubmitted = $this->fees_availiability->getBusinessTimingByDay($this->input->post('business_id'), 'Tuesday');
				$failier = false;

			} else {
				$failier = true;
				$success = false;
				$message = "Your time is not correct.";
			}

		} else if (($this->input->post('wednesday_from_time')) || ($this->input->post('wednesday_to_time'))) {
			$start_time = $this->input->post('wednesday_from_time');
			$end_time = $this->input->post('wednesday_to_time');

			$start_date_time = strtotime("$date $start_time");
			$end_date_time = strtotime("$date $end_time");

			if ($start_date_time < $end_date_time) {
				$wednesday = $this->input->post('wednesday');

				if ($wednesday) {
					$input['available'] = 'Yes';

				} else {
					$input['available'] = 'No';
				}
				$input['trading_day'] = 'Wednesday';
				$input['from_time'] = $this->input->post('wednesday_from_time');
				$input['to_time'] = $this->input->post('wednesday_to_time');
				$input['business_id'] = $this->input->post('business_id');

				$checkAlreadySubmitted = $this->fees_availiability->getBusinessTimingByDay($this->input->post('business_id'), 'Wednesday');
				$failier = false;

			} else {
				$failier = true;
				$success = false;
				$message = "Your time is not correct.";
			}

		} else if (($this->input->post('thursday_from_time')) || ($this->input->post('thursday_to_time'))) {
			$start_time = $this->input->post('thursday_from_time');
			$end_time = $this->input->post('thursday_to_time');

			$start_date_time = strtotime("$date $start_time");
			$end_date_time = strtotime("$date $end_time");

			if ($start_date_time < $end_date_time) {
				$thursday = $this->input->post('thursday');

				if ($thursday) {
					$input['available'] = 'Yes';

				} else {
					$input['available'] = 'No';
				}
				$input['trading_day'] = 'Thursday';
				$input['from_time'] = $this->input->post('thursday_from_time');
				$input['to_time'] = $this->input->post('thursday_to_time');
				$input['business_id'] = $this->input->post('business_id');

				$checkAlreadySubmitted = $this->fees_availiability->getBusinessTimingByDay($this->input->post('business_id'), 'Thursday');
				$failier = false;

			} else {
				$failier = true;
				$success = false;
				$message = "Your time is not correct.";
			}

		} else if (($this->input->post('friday_from_time')) || ($this->input->post('friday_to_time'))) {
			$start_time = $this->input->post('friday_from_time');
			$end_time = $this->input->post('friday_to_time');

			$start_date_time = strtotime("$date $start_time");
			$end_date_time = strtotime("$date $end_time");

			if ($start_date_time < $end_date_time) {
				$friday = $this->input->post('friday');

				if ($friday) {
					$input['available'] = 'Yes';

				} else {
					$input['available'] = 'No';
				}
				$input['trading_day'] = 'Friday';
				$input['from_time'] = $this->input->post('friday_from_time');
				$input['to_time'] = $this->input->post('friday_to_time');
				$input['business_id'] = $this->input->post('business_id');

				$checkAlreadySubmitted = $this->fees_availiability->getBusinessTimingByDay($this->input->post('business_id'), 'Friday');
				$failier = false;

			} else {
				$failier = true;
				$success = false;
				$message = "Your time is not correct.";
			}

		} else if (($this->input->post('saturday_from_time')) || ($this->input->post('saturday_to_time'))) {
			$start_time = $this->input->post('saturday_from_time');
			$end_time = $this->input->post('saturday_to_time');

			$start_date_time = strtotime("$date $start_time");
			$end_date_time = strtotime("$date $end_time");

			if ($start_date_time < $end_date_time) {
				$saturday = $this->input->post('saturday');

				if ($saturday) {
					$input['available'] = 'Yes';

				} else {
					$input['available'] = 'No';
				}
				$input['trading_day'] = 'Saturday';
				$input['from_time'] = $this->input->post('saturday_from_time');
				$input['to_time'] = $this->input->post('saturday_to_time');
				$input['business_id'] = $this->input->post('business_id');

				$checkAlreadySubmitted = $this->fees_availiability->getBusinessTimingByDay($this->input->post('business_id'), 'Saturday');
				$failier = false;

			} else {
				$failier = true;
				$success = false;
				$message = "Your time is not correct.";
			}

		} else if (($this->input->post('sunday_from_time')) || ($this->input->post('sunday_to_time'))) {
			$start_time = $this->input->post('sunday_from_time');
			$end_time = $this->input->post('sunday_to_time');

			$start_date_time = strtotime("$date $start_time");
			$end_date_time = strtotime("$date $end_time");

			if ($start_date_time < $end_date_time) {
				$sunday = $this->input->post('sunday');

				if ($sunday) {
					$input['available'] = 'Yes';

				} else {
					$input['available'] = 'No';
				}
				$input['trading_day'] = 'Sunday';
				$input['from_time'] = $this->input->post('sunday_from_time');
				$input['to_time'] = $this->input->post('sunday_to_time');
				$input['business_id'] = $this->input->post('business_id');

				$checkAlreadySubmitted = $this->fees_availiability->getBusinessTimingByDay($this->input->post('business_id'), 'Sunday');
				$failier = false;

			} else {
				$failier = true;
				$success = false;
				$message = "Your time is not correct.";
			}
		}

		if (!$failier) {

			if ($checkAlreadySubmitted) {
				$input['update_date'] = $this->common_model->getDefaultToGMTDate(time());
				$response = $this->fees_availiability->update_record($input, $checkAlreadySubmitted->id);

				if ($response) {
					$success = true;
					$message = "Time successfully updated.";

				} else {
					$success = false;
					$message = "Technical error.";
				}

			} else {
				$input['add_date'] = $this->common_model->getDefaultToGMTDate(time());
				$timing_id = $this->fees_availiability->insert_record($input);

				if ($timing_id) {
					$success = true;
					$message = "Time successfully added.";

				} else {
					$success = false;
					$message = "Technical error.";
				}
			}
		}

		$data['success'] = $success;
		$data['message'] = $message;
		echo json_encode($data);	
	}

	function base_rooms($business_id)
	{
		$getBusinessDetail = $this->fees_availiability->getBusinessDetailById($business_id, $this->childcare_id);
		$this->common_model->checkRequestedDataExists($getBusinessDetail);

		$output['page'] = 'dashboard';
		$output['page_active'] = 'fees_availiability';
		$output['business_id'] = $business_id;
		$rooms = $this->fees_availiability->getRoomByBusiness($business_id);
		$output['rooms'] = $rooms;

		if ($rooms) {
			$output['total_rooms'] = count($rooms);

		} else {
			$output['total_rooms'] = 1;
		}
		$this->load->view('front/includes/header', $output);
		$this->load->view('front/fees_availiability/base_room_groups');
		$this->load->view('front/includes/footer');
	}

	function add_room_data()
	{
		if (isset($_POST) && !empty($_POST)) {
			$room = $this->input->post('room');

			foreach ($room as $key => $value) {
				$_POST['room_'.$key.'_name'] = $value["name"];
				$_POST['room_'.$key.'_from_month'] = $value["from_month"];
				$_POST['room_'.$key.'_to_month'] = $value["to_month"];
				$this->form_validation->set_rules('room_'.$key.'_name', 'Room Name', 'trim|required');
				$this->form_validation->set_rules('room_'.$key.'_from_month', 'From Month', 'trim|required|is_natural');
				$this->form_validation->set_rules('room_'.$key.'_to_month', 'To Month', 'trim|required|is_natural_no_zero');
			}
			$this->form_validation->set_rules('business_id', 'Business Id', 'trim|required');

			if ($this->form_validation->run()) {
				$business_id = $this->input->post('business_id');

				$room_ids = $this->input->post('room_ids');

				if (isset($room_ids)) {
					$this->fees_availiability->deleteOldRooms($business_id,$room_ids);
					$this->fees_availiability->deleteOldRoomsAvailablity1($business_id,$room_ids);
				}
				$room = $this->input->post('room');
				//$i = 0;

				foreach ($room as $key => $value) {
					$roomData['business_id'] = $business_id;
					$roomData['room_name'] = $value['name'];
					$roomData['from_month'] = $value['from_month'];
					$roomData['to_month'] = $value['to_month'];

					if (isset($value['room_id']) && $value['room_id']) {
						$roomData['update_date'] = $this->common_model->getDefaultToGMTDate(time());
						$this->fees_availiability->updateRoomById($roomData,$value['room_id']);

					} else {
					  $roomData['add_date'] = $this->common_model->getDefaultToGMTDate(time());
					  $this->fees_availiability->insert_business_room($roomData);

					}
					//$i++;
				}
				$message = 'Room data successfully added.';
				$success = true;
				$data['redirectURL'] = base_url('fees-and-availiability');

			} else {
				$success = false;
				$message = validation_errors();
			}

			$data['message'] = $message;
			$data['success'] = $success;
			echo json_encode($data);die;               
	    }
	}

	function append_new_room()
	{
		$output = array();
		$success = true;
		$output['room_index'] = $this->input->get('room_index');
		$html = $this->load->view('front/fees_availiability/ajax_append_room', $output, true);

		$data['success'] = $success;
		$data['html'] = $html;
		echo json_encode($data);die;
	}

	function non_funded_age_group()
	{	
		$business_id = $_GET['bid'];
		$getBusinessDetail = $this->fees_availiability->getBusinessDetailById($business_id, $this->childcare_id);
		$this->common_model->checkRequestedDataExists($getBusinessDetail);

		$output['page'] = 'dashboard';
		$output['page_active'] = 'fees_availiability';
		$output['business_id'] = $business_id;
		$groups = $this->fees_availiability->getGroupByBusiness($business_id);
		$output['groups'] = $groups;

		$sessions = $this->fees_availiability->getSessionByBusiness($business_id, 'Non-Funded');
		$output['sessions'] = $sessions;

		if ($groups) {
			$output['total_groups'] = count($groups);

		} else {
			$output['total_groups'] = 1;
		}

		$this->load->view('front/includes/header', $output);
		$this->load->view('front/non_funded_children/define_age_groups');
		$this->load->view('front/includes/footer');
	}

	function append_new_group()
	{
		$output = array();
		$success = true;
		$output['group_index'] = $this->input->get('group_index');
		$html = $this->load->view('front/non_funded_children/ajax_append_group', $output, true);

		$data['success'] = $success;
		$data['html'] = $html;
		echo json_encode($data);die;
	}

	function add_age_group_data()
	{
		if (isset($_POST) && !empty($_POST)) {
			$group = $this->input->post('group');

			foreach ($group as $key => $value) {
				$_POST['group_'.$key.'_from_month'] = $value["from_month"];
				$_POST['group_'.$key.'_to_month'] = $value["to_month"];

				$this->form_validation->set_rules('group_'.$key.'_from_month', 'From Month', 'trim|required|is_natural_no_zero');
				$this->form_validation->set_rules('group_'.$key.'_to_month', 'To Month', 'trim|required|is_natural_no_zero');
			}
			$this->form_validation->set_rules('business_id', 'Business Id', 'trim|required');

			if ($this->form_validation->run()) {
				$business_id = $this->input->post('business_id');

				$getBusinessDetail = $this->fees_availiability->getBusinessDetailById($business_id, $this->childcare_id);

				if ($getBusinessDetail->fees_type_for_ages == 'same set different age') {
					$monthly_session_fees = $this->fees_availiability->getMonthlyFeesByBusinessId($business_id,'Non-Funded','same_sets');
					
					if (isset($monthly_session_fees) && !empty($monthly_session_fees)) {
						$this->fees_availiability->deleteMonthlyFeesBusinessGroup($business_id, 'Non-Funded','same_sets'); 
					}
				} 

				$businessUpdateData = array();
				$businessUpdateData['fees_type_for_ages'] = 'different set differnet age';
				$businessUpdateData['update_date'] = $this->common_model->getDefaultToGMTDate(time());
				$updateRespo = $this->fees_availiability->update_business_detail($businessUpdateData, $business_id);

				if ($updateRespo) {
					$group = $this->input->post('group');
					$age_group_ids = $this->input->post('age_group_ids');
					$groupData = array();

					if (isset($age_group_ids)) {
						$this->fees_availiability->deleteOldGroups($age_group_ids);
					}
					$i = 0;

					foreach ($group as $key => $value) {

						if (isset($value['age_group_id']) && $value['age_group_id']) {
							$groupUpdateData['business_id'] = $business_id;
							$groupUpdateData['from_month'] = $value['from_month'];
							$groupUpdateData['to_month'] = $value['to_month'];
							$groupUpdateData['update_date'] = $this->common_model->getDefaultToGMTDate(time());
							$this->fees_availiability->update_business_age_groups($groupUpdateData, $value['age_group_id']);

						} else {
							$groupData[$i]['business_id'] = $business_id;
							$groupData[$i]['from_month'] = $value['from_month'];
							$groupData[$i]['to_month'] = $value['to_month'];
							$groupData[$i]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
							$i++;
						}
					}

					if ($groupData) {
						$this->fees_availiability->insert_business_age_groups($groupData);
					}
					$message = 'Group data successfully added.';
					$this->fees_availiability->deleteOldSessionType($business_id, 'Non-Funded');
					$this->fees_availiability->deleteOldSessionDays($business_id, 'Non-Funded');

					$success = true;
					$data['redirectURL'] = base_url('non-funded-children/set-monthly-fees?bid=').$business_id.'&sets=different_sets';

				} else {
					$success = false;
					$message = 'Technical error, Please try again.';
				}

			} else {
				$success = false;
				$message = validation_errors();
			}

			$data['message'] = $message;
			$data['success'] = $success;
			echo json_encode($data);die;               
	    }
	}

	function non_funded_session() {
		$business_id = $_GET['bid'];
		$getBusinessDetail = $this->fees_availiability->getBusinessDetailById($business_id, $this->childcare_id);
		$this->common_model->checkRequestedDataExists($getBusinessDetail);
		$output['page'] = 'dashboard';
		$output['page_active'] = 'fees_availiability';
		$output['business_id'] = $business_id;
		$output['session_types'] = $this->fees_availiability->getSessionTypesForNonFunded();
		$sessions = $this->fees_availiability->getSessionByBusiness($business_id, 'Non-Funded');

		foreach ($sessions as $key => $value) {
			$value->days = $this->fees_availiability->getDaysByBusinessSessionId($value->id);
		}
		$output['sessions'] = $sessions;

		$groups = $this->fees_availiability->getGroupByBusiness($business_id);
		$output['groups'] = $groups;
	
		if ($sessions) {
			$output['total_session'] = count($sessions);

		} else {
			$output['total_session'] = 1;
		}
		$this->load->view('front/includes/header', $output);
		$this->load->view('front/non_funded_children/define_sessions_type');
		$this->load->view('front/includes/footer');
	}

	function append_new_session()
	{
		$output = array();
		$success = true;
		$output['session_index'] = $this->input->get('session_index');
		$output['session_types'] = $this->fees_availiability->getSessionTypesForNonFunded();
		$html = $this->load->view('front/non_funded_children/ajax_append_session', $output, true);
		$data['success'] = $success;
		$data['html'] = $html;
		echo json_encode($data);die;
	}

	function add_session_type_data()
	{
		if (isset($_POST) && !empty($_POST)) {
			$session = $this->input->post('session');
			$flag = 0;
			$session_type_id = array();
			$is_32_week_per_year = $this->input->post('is_32_week_per_year');
			$is_52_week_per_year = $this->input->post('is_52_week_per_year');
			
			if (isset($is_32_week_per_year) || isset($is_52_week_per_year)) {

			} else {

				if (isset($is_32_week_per_year)) {
					$_POST['session_week_per_year'] = $is_32_week_per_year;

				} else if (isset($is_52_week_per_year)) {
					$_POST['session_week_per_year'] = $is_52_week_per_year;

				} else {
					$_POST['session_week_per_year'] = "";
				}
			}
			
			foreach ($session as $key => $value) {
				$_POST['session_'.$key.'_from_time'] = $value["from_time"];
				$_POST['session_'.$key.'_to_time'] = $value["to_time"];
				$_POST['session_'.$key.'_excluded_from_time'] = $value["excluded_from_time"];
				$_POST['session_'.$key.'_excluded_to_time'] = $value["excluded_to_time"];

				if ($value['session_type_id'] && $value['session_type_id'] == 'own_session') {
					$_POST['session_'.$key.'_own_session'] = $value['own_session'];
				}

				if (isset($value['days']) && $value['days']) {
					$_POST['session_'.$key.'_days'] = $value["days"];

				} else {
					$_POST['session_'.$key.'_days'] = "";
				}

				if ($value['session_type_id'] && $value['session_type_id'] == 'own_session') {
					$this->form_validation->set_rules('session_'.$key.'_own_session', 'Define your own session', 'trim|required|callback_check_space');
				}

				$this->form_validation->set_rules('session_'.$key.'_from_time', 'Start Time', 'trim|required');
				$this->form_validation->set_rules('session_'.$key.'_to_time', 'End Time', 'trim|required');
				$this->form_validation->set_rules('session_'.$key.'_excluded_from_time', 'Excluded Start Time', 'trim');
				$this->form_validation->set_rules('session_'.$key.'_excluded_to_time', 'Excluded End Time', 'trim');
				$this->form_validation->set_rules('session_'.$key.'_days[]', 'days', 'trim|required');

				if (!empty($value['session_type_id'])) {

					if (!in_array($value['session_type_id'], $session_type_id)) {
				        $session_type_id[] = $value['session_type_id'];

				    } else {

				    	if ($value['session_type_id'] && $value['session_type_id'] != 'own_session') {
				     		$flag++;
				     	}
				    }
				}
			}

			//pr($flag);die;

			if ($flag > 0) {
				$this->form_validation->set_rules('session_type_id', 'session type', 'trim|required', array('required' => 'Please select unique %s.'));
			}

			$this->form_validation->set_rules('business_id', 'Business Id', 'trim|required');

			if (isset($_POST['session_week_per_year'])) {
				$this->form_validation->set_rules('session_week_per_year', 'Week per year', 'trim|required');
			}

			if ($this->form_validation->run()) {
				$business_id = $this->input->post('business_id');

				$getBusinessDetail = $this->fees_availiability->getBusinessDetailById($business_id, $this->childcare_id);

				if ($getBusinessDetail->fees_type_for_ages == 'different set differnet age') {
					$monthly_session_fees = $this->fees_availiability->getMonthlyFeesByBusinessId($business_id,'Non-Funded','different_sets');
					
					if (isset($monthly_session_fees) && !empty($monthly_session_fees)) {
						$this->fees_availiability->deleteMonthlyFeesBusinessGroup($business_id, 'Non-Funded','different_sets'); 
					}
				} 
				$businessUpdateData = array();
				$businessUpdateData['fees_type_for_ages'] = 'same set different age';
				$businessUpdateData['update_date'] = $this->common_model->getDefaultToGMTDate(time());
				$updateRespo = $this->fees_availiability->update_business_detail($businessUpdateData, $business_id);

				if ($updateRespo) {
					$this->fees_availiability->deleteBusinessGroup($business_id, 'Non-Funded'); 
					$session = $this->input->post('session');
					$session_type_ids = $this->input->post('session_type_ids');

					if (isset($session_type_ids)) {
						$this->fees_availiability->deleteOldSession($business_id, $session_type_ids,'Non-Funded');
						$this->fees_availiability->deleteOldSessionDays($business_id, 'Non-Funded');
					}

					foreach ($session as $key => $value) {
						$sessionTypeData = array();
						$sessionTypeData['business_id'] = $business_id;
						$sessionTypeData['fees_type'] = 'Non-Funded';
						$sessionTypeData['session_type_id'] = $value['session_type_id'];

						if (isset($value['own_session']) && $value['own_session']) {
							$sessionTypeData['own_session'] = $value['own_session'];
						}
						$sessionTypeData['from_time'] = $value['from_time'];
						$sessionTypeData['to_time'] = $value['to_time'];

						if (isset($value['excluded_from_time'])) {
							$sessionTypeData['excluded_from_time'] = $value['excluded_from_time'];
						}

						if (isset($value['excluded_to_time'])) {
							$sessionTypeData['excluded_to_time'] = $value['excluded_to_time'];
						}

						if (isset($is_32_week_per_year)) {
							$sessionTypeData['is_32_week_per_year'] = 'Yes';

						} else {
							$sessionTypeData['is_32_week_per_year'] = 'No';
						}

						if (isset($is_52_week_per_year)) {
							$sessionTypeData['is_52_week_per_year'] = 'Yes';

						} else {
							$sessionTypeData['is_52_week_per_year'] = 'No';
						}

						if (isset($value['business_session_type_id']) && $value['business_session_type_id']) {
							$sessionTypeData['update_date'] = $this->common_model->getDefaultToGMTDate(time());
							$business_session_type_id = $this->fees_availiability->update_business_session_type($sessionTypeData, $value['business_session_type_id']);

						} else {
							$sessionTypeData['add_date'] = $this->common_model->getDefaultToGMTDate(time());
							$business_session_type_id = $this->fees_availiability->add_business_session_type($sessionTypeData);
						}

						if ($business_session_type_id) {
							$sessionTypeDaysData = array();

							foreach ($value['days'] as $k => $v) {
								$sessionTypeDaysData[$k]['business_session_type_id'] = $business_session_type_id;
								$sessionTypeDaysData[$k]['fees_type'] = 'Non-Funded';
								$sessionTypeDaysData[$k]['business_id'] = $business_id;
								$sessionTypeDaysData[$k]['day'] = $v;
								$sessionTypeDaysData[$k]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
							}

							if ($sessionTypeDaysData) {
								$this->fees_availiability->add_business_session_days($sessionTypeDaysData);
							}

							$is_session_type_exist = $this->fees_availiability->getSessionTypeById($business_session_type_id, $business_id, 'Non-Funded');
							
							if ($is_session_type_exist) {
								
								if ( ($is_session_type_exist->is_32_week_per_year == 'Yes')  && ($is_session_type_exist->is_52_week_per_year == 'No') ) {
									$this->fees_availiability->deleteMonthlyFessByWeek($business_session_type_id,$business_id, 'Non-Funded', '52');
								}

								if (($is_session_type_exist->is_52_week_per_year == 'Yes') && ($is_session_type_exist->is_32_week_per_year == 'No')) {
									$this->fees_availiability->deleteMonthlyFessByWeek($business_session_type_id,$business_id, 'Non-Funded', '38');
								}

								if (($is_session_type_exist->is_32_week_per_year == 'Yes') && ($is_session_type_exist->is_52_week_per_year == 'Yes')) {

								}
							}
						}
					}

					$message = 'Session data successfully added.';
					$success = true;
					$data['redirectURL'] = base_url('non-funded-children/set-monthly-fees?bid=').$business_id.'&sets=same_sets';

				} else {
					$message = 'Technical error, Please try again.';
					$success = false;
				}

			} else {
				$success = false;
				$message = validation_errors();
			}

			$data['message'] = $message;
			$data['success'] = $success;
			echo json_encode($data);die;               
	    }
	}

	function non_funded_monthly_fees() {
		$business_id = $_GET['bid'];
		$sets = $_GET['sets'];
		$getBusinessDetail = $this->fees_availiability->getBusinessDetailById($business_id, $this->childcare_id);
		$this->common_model->checkRequestedDataExists($getBusinessDetail);
		$output['page'] = 'dashboard';
		$output['page_active'] = 'fees_availiability';
		$output['sessions_types'] = '';
		$output['business_sessions'] = '';
		$output['business_id'] = $business_id;
		$output['sets'] = $sets;
		$room_availiability = $this->fees_availiability->getRoomAvailiabilityByBusinessId($business_id,'Non-Funded');
		$output['room_availiability'] = $room_availiability;

		if ($sets == 'different_sets') {
			$business_groups = $this->fees_availiability->getGroupByBusiness($business_id);
			$output['business_groups'] = $business_groups;
			$output['sessions_types'] = $this->fees_availiability->getSessionTypesForNonFunded();
			$businessGroups = $this->fees_availiability->getGroupByBusinessId($business_id,'Non-Funded');

			if ($businessGroups) {
				$week_per_year = $this->fees_availiability->getGroupWeekPerYear($business_id,'Non-Funded');
				$weekPerYear = array();
				
				foreach ($week_per_year as $key => $value) {
					$weekPerYear[] = $value->week_per_year;
				}

				foreach ($businessGroups as $key => $value) {
					$value->monthly_session_fees = $this->fees_availiability->getMonthlyGroupFeesByBusinessId($business_id,$value->business_group_id,'Non-Funded','different_sets');
					$output['total_monthly_session'] = count($value->monthly_session_fees);
					
					foreach ($value->monthly_session_fees as $k => $val) {
						$val->session_fees = $this->fees_availiability->getMonthlyFeesByBusinessId($business_id,'Non-Funded','different_sets', $val->business_session_type_id,$value->business_group_id);
					}
				}
				$output['businessGroups'] = $businessGroups;
				$output['weekPerYear'] = $weekPerYear;
				
			}
			$this->load->view('front/includes/header', $output);
			$this->load->view('front/non_funded_children/group_monthly_fees');

		} else {
			$monthly_session_fees_group = $this->fees_availiability->getMonthlyFeesGroupByBusinessId($business_id,'Non-Funded','same_sets');

			if ($monthly_session_fees_group) {

				foreach ($monthly_session_fees_group as $key => $value) {
					$value->session_fees = $this->fees_availiability->getMonthlyFeesByBusinessId($business_id,'Non-Funded','same_sets', $value->business_session_type_id);
				}
			}
			$output['monthly_session_fees'] = $monthly_session_fees_group;

			if ($monthly_session_fees_group) {
				$output['total_monthly_session'] = count($monthly_session_fees_group);

			} else {
				$output['total_monthly_session'] = 1;
			}
			$output['business_sessions'] = $this->fees_availiability->getSessionByBusiness($business_id,'Non-Funded');
			$output['weekType'] = $this->fees_availiability->getWeekType($business_id,'Non-Funded');
			$this->load->view('front/includes/header', $output);
			$this->load->view('front/non_funded_children/monthly_fees');
		}
		$this->load->view('front/includes/footer');
	}

	function append_monthly_fees_data() {
		$output = array();
		$success = true;
		$business_id = $this->input->get('business_id');
		$output['monthly_session_index'] = $this->input->get('monthly_session_index');
		$output['business_sessions'] = $this->fees_availiability->getSessionByBusiness($business_id,'Non-Funded');
		$output['weekType'] = $this->fees_availiability->getWeekType($business_id,'Non-Funded');
		$html = $this->load->view('front/non_funded_children/ajax_append_monthly_fees', $output, true);
		$data['success'] = $success;
		$data['html'] = $html;
		echo json_encode($data);die;
	}

	function append_age_group_set() {
		$output = array();
		$success = true;
		$business_id = $this->input->get('business_id');
		$selected_32 = $this->input->get('selected_32');
		$selected_52 = $this->input->get('selected_52');
	
		$sets = $this->input->get('sets');
		$getBusinessDetail = $this->fees_availiability->getBusinessDetailById($business_id, $this->childcare_id);
		$output['monthly_business_groups_index'] = $this->input->get('monthly_business_groups_index');
		$output['monthly_session_index'] = $this->input->get('monthly_session_index');
		$output['sessions_types'] = $this->fees_availiability->getSessionTypesForNonFunded();
		$output['business_groups'] = $this->fees_availiability->getGroupByBusiness($business_id);
		$output['fees_type_for_ages'] = $getBusinessDetail->fees_type_for_ages;
		$output['sets'] = $sets;
		$output['business_id'] = $business_id;
		$output['selected_32'] = $selected_32;
		$output['selected_52'] = $selected_52;
		$html = $this->load->view('front/non_funded_children/ajax_append_age_group_set', $output, true);
		$data['success'] = $success;
		$data['html'] = $html;
		echo json_encode($data);die;
	}
	
	function append_group_monthly_fees() {
		$output = array();
		$success = true;
		$business_id = $this->input->get('business_id');
		$output['monthly_business_groups_index'] = $this->input->get('monthly_business_groups_index');
		$output['monthly_session_index'] = $this->input->get('monthly_session_index') + 1;
		$output['sessions_types'] = $this->fees_availiability->getSessionTypesForNonFunded();
		$html = $this->load->view('front/non_funded_children/ajax_append_group_monthly_fees', $output, true);
		$data['success'] = $success;
		$data['html'] = $html;
		echo json_encode($data);die;
	}

	function add_monthly_fees_data() {
		
		if (isset($_POST) && !empty($_POST)) {
			$sets = $this->input->post('sets');
			$monthly_fees = $this->input->post('monthly_fees');
			$flag = 0;
			$business_session_types = array();

			foreach ($monthly_fees as $key => $value) {
				$business_session_type_id = $value["business_session_type_id"];
				$_POST['monthly_fees_'.$key.'_business_session_type_id'] = $value["business_session_type_id"];
				$this->form_validation->set_rules('monthly_fees_'.$key.'_business_session_type_id', 'session type', 'trim|required');

				if (isset($value['week_38'])) {
					$_POST['monthly_fees_'.$key.'_38_week_day_1'] = $value['week_38']["day_1"];
					$_POST['monthly_fees_'.$key.'_38_week_day_2'] = $value['week_38']["day_2"];
					$_POST['monthly_fees_'.$key.'_38_week_day_3'] = $value['week_38']["day_3"];
					$_POST['monthly_fees_'.$key.'_38_week_day_4'] = $value['week_38']["day_4"];
					$_POST['monthly_fees_'.$key.'_38_week_day_5'] = $value['week_38']["day_5"];
					$_POST['monthly_fees_'.$key.'_38_week_day_6'] = $value['week_38']["day_6"];
					$_POST['monthly_fees_'.$key.'_38_week_day_7'] = $value['week_38']["day_7"];

					$this->form_validation->set_rules('monthly_fees_'.$key.'_38_week_day_1', '38 Week Day 1', 'trim|required|numeric|greater_than[0]', array('required' => 'Please fill %s fee.'));
					$this->form_validation->set_rules('monthly_fees_'.$key.'_38_week_day_2', '38 Week Day 2', 'trim|required|numeric|greater_than[0]', array('required' => 'Please fill %s fee.'));
					$this->form_validation->set_rules('monthly_fees_'.$key.'_38_week_day_3', '38 Week Day 3', 'trim|required|numeric|greater_than[0]', array('required' => 'Please fill %s fee.'));
					$this->form_validation->set_rules('monthly_fees_'.$key.'_38_week_day_4', '38 Week Day 4', 'trim|required|numeric|greater_than[0]', array('required' => 'Please fill %s fee.'));
					$this->form_validation->set_rules('monthly_fees_'.$key.'_38_week_day_5', '38 Week Day 5', 'trim|required|numeric|greater_than[0]', array('required' => 'Please fill %s fee.'));
					$this->form_validation->set_rules('monthly_fees_'.$key.'_38_week_day_6', '38 Week Day 6', 'trim|numeric');
					$this->form_validation->set_rules('monthly_fees_'.$key.'_38_week_day_7', '38 Week Day 7', 'trim|numeric');
				}

				if (isset($value['week_52'])) {
					$_POST['monthly_fees_'.$key.'_52_week_day_1'] = $value['week_52']["day_1"];
					$_POST['monthly_fees_'.$key.'_52_week_day_2'] = $value['week_52']["day_2"];
					$_POST['monthly_fees_'.$key.'_52_week_day_3'] = $value['week_52']["day_3"];
					$_POST['monthly_fees_'.$key.'_52_week_day_4'] = $value['week_52']["day_4"];
					$_POST['monthly_fees_'.$key.'_52_week_day_5'] = $value['week_52']["day_5"];
					$_POST['monthly_fees_'.$key.'_52_week_day_6'] = $value['week_52']["day_6"];
					$_POST['monthly_fees_'.$key.'_52_week_day_7'] = $value['week_52']["day_7"];

					$this->form_validation->set_rules('monthly_fees_'.$key.'_52_week_day_1', '52 Week Day 1', 'trim|required|numeric|greater_than[0]', array('required' => 'Please fill %s fee.'));
					$this->form_validation->set_rules('monthly_fees_'.$key.'_52_week_day_2', '52 Week Day 2', 'trim|required|numeric|greater_than[0]', array('required' => 'Please fill %s fee.'));
					$this->form_validation->set_rules('monthly_fees_'.$key.'_52_week_day_3', '52 Week Day 3', 'trim|required|numeric|greater_than[0]', array('required' => 'Please fill %s fee.'));
					$this->form_validation->set_rules('monthly_fees_'.$key.'_52_week_day_4', '52 Week Day 4', 'trim|required|numeric|greater_than[0]', array('required' => 'Please fill %s fee.'));
					$this->form_validation->set_rules('monthly_fees_'.$key.'_52_week_day_5', '52 Week Day 5', 'trim|required|numeric|greater_than[0]', array('required' => 'Please fill %s fee.'));
					$this->form_validation->set_rules('monthly_fees_'.$key.'_52_week_day_6', '52 Week Day 6', 'trim|numeric');
					$this->form_validation->set_rules('monthly_fees_'.$key.'_52_week_day_7', '52 Week Day 7', 'trim|numeric');
				}

				if (!empty($value['business_session_type_id'])) {

					if (!in_array($value['business_session_type_id'], $business_session_types)) {
				        $business_session_types[] = $value['business_session_type_id'];

				    } else {
				     	$flag++;
				    }
				}
			}

			if ($flag > 0) {
				$this->form_validation->set_rules('business_session_type_id', 'session type', 'trim|required', array('required' => 'Please select unique %s.'));
			}

			$this->form_validation->set_rules('business_id', 'business id', 'trim|required');

			if ($this->form_validation->run()) {
				$business_id = $this->input->post('business_id');
				$funded_type = $this->input->post('funded_type');
				$monthly_fees_ids = $this->input->post('monthly_fees_ids');

				if (isset($monthly_fees_ids)) {
					$this->fees_availiability->deleteOldMonthlyFeesById($business_id,$monthly_fees_ids,'Non-Funded');
				}

				$i = 0;
				foreach ($monthly_fees as $key => $value) {
					$businessSessionType = $this->fees_availiability->getBusinessSessionTypeById($value['business_session_type_id']);
					
					$monthlyFees38Data = array();

					if (isset($value['week_38'])) {
						$monthlyFees38Data['business_id'] = $business_id;
						$monthlyFees38Data['business_session_type_id'] = $value['business_session_type_id'];
						$monthlyFees38Data['session_type_id'] = $businessSessionType->session_type_id;
						$monthlyFees38Data['fees_type'] = 'Non-Funded';
						$monthlyFees38Data['age_type'] = $sets;
						$monthlyFees38Data['day_1'] = $value['week_38']['day_1'];
						$monthlyFees38Data['day_2'] = $value['week_38']['day_2'];
						$monthlyFees38Data['day_3'] = $value['week_38']['day_3'];
						$monthlyFees38Data['day_4'] = $value['week_38']['day_4'];
						$monthlyFees38Data['day_5'] = $value['week_38']['day_5'];
						$monthlyFees38Data['day_6'] = $value['week_38']['day_6'];
						$monthlyFees38Data['day_7'] = $value['week_38']['day_7'];
						$monthlyFees38Data['week_per_year'] = '38';
					}

					$monthlyFeesData = array();
					
					if (isset($value['week_52'])) {
						$monthlyFeesData['business_id'] = $business_id;
						$monthlyFeesData['business_session_type_id'] = $value['business_session_type_id'];
						$monthlyFeesData['session_type_id'] = $businessSessionType->session_type_id;
						$monthlyFeesData['fees_type'] = 'Non-Funded';
						$monthlyFeesData['age_type'] = $sets;
						$monthlyFeesData['day_1'] = $value['week_52']['day_1'];
						$monthlyFeesData['day_2'] = $value['week_52']['day_2'];
						$monthlyFeesData['day_3'] = $value['week_52']['day_3'];
						$monthlyFeesData['day_4'] = $value['week_52']['day_4'];
						$monthlyFeesData['day_5'] = $value['week_52']['day_5'];
						$monthlyFeesData['day_6'] = $value['week_52']['day_6'];
						$monthlyFeesData['day_7'] = $value['week_52']['day_7'];
						$monthlyFeesData['week_per_year'] = '52';

					}
					if ($monthlyFees38Data) {
						if (isset($value['week_38']['monthly_fees_id']) && $value['week_38']['monthly_fees_id']) {
							$monthlyFees38Data['update_date'] = $this->common_model->getDefaultToGMTDate(time());
							$this->fees_availiability->update_monthly_fees_by_id($monthlyFees38Data, $value['week_38']['monthly_fees_id']);

						} else {
							$monthlyFees38Data['add_date'] = $this->common_model->getDefaultToGMTDate(time());
							$this->fees_availiability->add_monthly_fees($monthlyFees38Data);
						}
					}
					
					if ($monthlyFeesData) {
						if (isset($value['week_52']['monthly_fees_id']) && $value['week_52']['monthly_fees_id']) {
							$monthlyFeesData['update_date'] = $this->common_model->getDefaultToGMTDate(time());
							$this->fees_availiability->update_monthly_fees_by_id($monthlyFeesData, $value['week_52']['monthly_fees_id']);

						} else {
							$monthlyFeesData['add_date'] = $this->common_model->getDefaultToGMTDate(time());
							$this->fees_availiability->add_monthly_fees($monthlyFeesData);
						}
					}
				}
				$message = 'Monthly fees data successfully added.';
				$success = true;
				$data['redirectURL'] = base_url('non-funded-children/set-room-availiability?bid=').$business_id.'&sets='.$sets;

			} else {
				$success = false;
				$message = validation_errors();
			}
			$data['message'] = $message;
			$data['success'] = $success;
			echo json_encode($data);die;               
	    }
	}


	function add_monthly_group_fees_data() {
		
		if (isset($_POST) && !empty($_POST)) {
			//pr($_POST);die;
			$groups = $this->input->post('group');

			$flag = 0;
			$groupFlag = 0;
			$business_group = array();
			$week_per_year_38 = $this->input->post('week_per_year_38');
			$week_per_year_52 = $this->input->post('week_per_year_52');
			
			foreach ($groups as $key => $value) {
				$business_session_types = array();
				$_POST['group_'.$key.'_business_group_id'] = $value["business_group_id"];
				$this->form_validation->set_rules('group_'.$key.'_business_group_id', 'group', 'trim|required');
				$business_group_id = $value["business_group_id"];

				foreach ($value['session'] as $k => $val) {
					
					if ($week_per_year_38) {
						
						if (isset($val['week_38'])) {
							$_POST['group_'.$business_group_id.'_'.$k.'_38_week_day_1'] = $val['week_38']["day_1"];
							$_POST['group_'.$business_group_id.'_'.$k.'_38_week_day_2'] = $val['week_38']["day_2"];
							$_POST['group_'.$business_group_id.'_'.$k.'_38_week_day_3'] = $val['week_38']["day_3"];
							$_POST['group_'.$business_group_id.'_'.$k.'_38_week_day_4'] = $val['week_38']["day_4"];
							$_POST['group_'.$business_group_id.'_'.$k.'_38_week_day_5'] = $val['week_38']["day_5"];
							$_POST['group_'.$business_group_id.'_'.$k.'_38_week_day_6'] = $val['week_38']["day_6"];
							$_POST['group_'.$business_group_id.'_'.$k.'_38_week_day_7'] = $val['week_38']["day_7"];

							$this->form_validation->set_rules('group_'.$business_group_id.'_'.$k.'_38_week_day_1', '38 Week Day 1', 'trim|required|numeric|greater_than[0]', array('required' => 'Please fill %s fee.'));
							$this->form_validation->set_rules('group_'.$business_group_id.'_'.$k.'_38_week_day_2', '38 Week Day 2', 'trim|required|numeric|greater_than[0]', array('required' => 'Please fill %s fee.'));
							$this->form_validation->set_rules('group_'.$business_group_id.'_'.$k.'_38_week_day_3', '38 Week Day 3', 'trim|required|numeric|greater_than[0]', array('required' => 'Please fill %s fee.'));
							$this->form_validation->set_rules('group_'.$business_group_id.'_'.$k.'_38_week_day_4', '38 Week Day 4', 'trim|required|numeric|greater_than[0]', array('required' => 'Please fill %s fee.'));
							$this->form_validation->set_rules('group_'.$business_group_id.'_'.$k.'_38_week_day_5', '38 Week Day 5', 'trim|required|numeric|greater_than[0]', array('required' => 'Please fill %s fee.'));
							$this->form_validation->set_rules('group_'.$business_group_id.'_'.$k.'_38_week_day_6', '38 Week Day 6', 'trim|numeric');
							$this->form_validation->set_rules('group_'.$business_group_id.'_'.$k.'_38_week_day_7', '38 Week Day 7', 'trim|numeric');
						}
					}
					
					if ($week_per_year_52) {
						
						if (isset($val['week_52'])) {
							$_POST['group_'.$business_group_id.'_'.$k.'_52_week_day_1'] = $val['week_52']["day_1"];
							$_POST['group_'.$business_group_id.'_'.$k.'_52_week_day_2'] = $val['week_52']["day_2"];
							$_POST['group_'.$business_group_id.'_'.$k.'_52_week_day_3'] = $val['week_52']["day_3"];
							$_POST['group_'.$business_group_id.'_'.$k.'_52_week_day_4'] = $val['week_52']["day_4"];
							$_POST['group_'.$business_group_id.'_'.$k.'_52_week_day_5'] = $val['week_52']["day_5"];
							$_POST['group_'.$business_group_id.'_'.$k.'_52_week_day_6'] = $val['week_52']["day_6"];
							$_POST['group_'.$business_group_id.'_'.$k.'_52_week_day_7'] = $val['week_52']["day_7"];

							$this->form_validation->set_rules('group_'.$business_group_id.'_'.$k.'_52_week_day_1', '52 Week Day 1', 'trim|required|numeric|greater_than[0]', array('required' => 'Please fill %s fee.'));
							$this->form_validation->set_rules('group_'.$business_group_id.'_'.$k.'_52_week_day_2', '52 Week Day 2', 'trim|required|numeric|greater_than[0]', array('required' => 'Please fill %s fee.'));
							$this->form_validation->set_rules('group_'.$business_group_id.'_'.$k.'_52_week_day_3', '52 Week Day 3', 'trim|required|numeric|greater_than[0]', array('required' => 'Please fill %s fee.'));
							$this->form_validation->set_rules('group_'.$business_group_id.'_'.$k.'_52_week_day_4', '52 Week Day 4', 'trim|required|numeric|greater_than[0]', array('required' => 'Please fill %s fee.'));
							$this->form_validation->set_rules('group_'.$business_group_id.'_'.$k.'_52_week_day_5', '52 Week Day 5', 'trim|required|numeric|greater_than[0]', array('required' => 'Please fill %s fee.'));
							$this->form_validation->set_rules('group_'.$business_group_id.'_'.$k.'_52_week_day_6', '52 Week Day 6', 'trim|numeric');
							$this->form_validation->set_rules('group_'.$business_group_id.'_'.$k.'_52_week_day_7', '52 Week Day 7', 'trim|numeric');
						}
					}
					if (!empty($val['business_session_type_id'])) {

						if (!in_array($val['business_session_type_id'], $business_session_types)) {
					        $business_session_types[] = $val['business_session_type_id'];

					    } else {
					     	$flag++;
					    }
					}
				}

				if (!empty($value['business_group_id'])) {

					if (!in_array($value['business_group_id'], $business_group)) {
				        $business_group[] = $value['business_group_id'];

				    } else {
				     	$groupFlag++;
				    }
				}
			}
			
			if ($flag > 0) {
				$this->form_validation->set_rules('business_session_type_id', 'session type', 'trim|required', array('required' => 'Please select unique %s.'));
			}

			if ($groupFlag > 0) {
				$this->form_validation->set_rules('business_group_id', 'group', 'trim|required', array('required' => 'Please select unique %s.'));
			}
			$this->form_validation->set_rules('business_id', 'business id', 'trim|required');

			if ($this->form_validation->run()) {
				$business_id = $this->input->post('business_id');
				$sets = $this->input->post('sets');
				$monthly_fees_ids = $this->input->post('monthly_fees_ids');

				if (isset($monthly_fees_ids)) {
					$this->fees_availiability->deleteOldMonthlyFeesById($business_id,$monthly_fees_ids,'Non-Funded');
				}

				foreach ($groups as $key => $value) {
			
					foreach ($value['session'] as $k => $val) {
						$monthlyFees38Data = array();
						$monthlyFeesData = array();

						if (isset($val['week_38'])) {

							if ($week_per_year_38) {
								$monthlyFees38Data['business_id'] = $business_id;
								$monthlyFees38Data['business_session_type_id'] = $val['business_session_type_id'];
								$monthlyFees38Data['session_type_id'] = $val['business_session_type_id'];
								$monthlyFees38Data['business_group_id'] = $value['business_group_id'];
								$monthlyFees38Data['fees_type'] = 'Non-Funded';
								$monthlyFees38Data['age_type'] = $sets;
								$monthlyFees38Data['day_1'] = $val['week_38']['day_1'];
								$monthlyFees38Data['day_2'] = $val['week_38']['day_2'];
								$monthlyFees38Data['day_3'] = $val['week_38']['day_3'];
								$monthlyFees38Data['day_4'] = $val['week_38']['day_4'];
								$monthlyFees38Data['day_5'] = $val['week_38']['day_5'];
								$monthlyFees38Data['day_6'] = $val['week_38']['day_6'];
								$monthlyFees38Data['day_7'] = $val['week_38']['day_7'];
								$monthlyFees38Data['week_per_year'] = '38';
							} else {

								if (isset($val['week_38']['monthly_fees_id']) && $val['week_38']['monthly_fees_id']) {
									$this->fees_availiability->deleteMonthlyFessByID($val['week_38']['monthly_fees_id']);
								}
							}

						}

						if (isset($val['week_52'])) {

							if ($week_per_year_52) {
								$monthlyFeesData['business_id'] = $business_id;
								$monthlyFeesData['business_session_type_id'] = $val['business_session_type_id'];
								$monthlyFeesData['session_type_id'] = $val['business_session_type_id'];
								$monthlyFeesData['business_group_id'] = $value['business_group_id'];
								$monthlyFeesData['fees_type'] = 'Non-Funded';
								$monthlyFeesData['age_type'] = $sets;
								$monthlyFeesData['day_1'] = $val['week_52']['day_1'];
								$monthlyFeesData['day_2'] = $val['week_52']['day_2'];
								$monthlyFeesData['day_3'] = $val['week_52']['day_3'];
								$monthlyFeesData['day_4'] = $val['week_52']['day_4'];
								$monthlyFeesData['day_5'] = $val['week_52']['day_5'];
								$monthlyFeesData['day_6'] = $val['week_52']['day_6'];
								$monthlyFeesData['day_7'] = $val['week_52']['day_7'];
								$monthlyFeesData['week_per_year'] = '52';
							} else {

								if (isset($val['week_52']['monthly_fees_id']) && $val['week_52']['monthly_fees_id']) {
									$this->fees_availiability->deleteMonthlyFessByID($val['week_52']['monthly_fees_id']);
								}
							}
						}
						
						if ($monthlyFees38Data) {
							
							if (isset($val['week_38']['monthly_fees_id']) && $val['week_38']['monthly_fees_id']) {
								$monthlyFees38Data['update_date'] = $this->common_model->getDefaultToGMTDate(time());
								$this->fees_availiability->update_monthly_fees_by_id($monthlyFees38Data, $val['week_38']['monthly_fees_id']);

							} else {
								$monthlyFees38Data['add_date'] = $this->common_model->getDefaultToGMTDate(time());
								$this->fees_availiability->add_monthly_fees($monthlyFees38Data);
							}
						}

						if ($monthlyFeesData) {

							if (isset($val['week_52']['monthly_fees_id']) && $val['week_52']['monthly_fees_id']) {
								$monthlyFeesData['update_date'] = $this->common_model->getDefaultToGMTDate(time());
								$this->fees_availiability->update_monthly_fees_by_id($monthlyFeesData, $val['week_52']['monthly_fees_id']);

							} else {
								$monthlyFeesData['add_date'] = $this->common_model->getDefaultToGMTDate(time());
								$this->fees_availiability->add_monthly_fees($monthlyFeesData);
							}
						}
					}
				}
				$message = 'Monthly fees data successfully added.';
				$success = true;
				$data['redirectURL'] = base_url('non-funded-children/set-room-availiability?bid=').$business_id.'&sets='.$sets;

			} else {
				$success = false;
				$message = validation_errors();
			}

			$data['message'] = $message;
			$data['success'] = $success;
			echo json_encode($data);die;               
	    }
	}

	function business_room_availiability() {
		$business_id = $_GET['bid'];
		$sets = $_GET['sets'];
		$getBusinessDetail = $this->fees_availiability->getBusinessDetailById($business_id, $this->childcare_id);
		$this->common_model->checkRequestedDataExists($getBusinessDetail);
		$output['page'] = 'dashboard';
		$output['page_active'] = 'fees_availiability';
		$terms = $this->fees_availiability->getTerms();
		$rooms = $this->fees_availiability->getRooms($business_id);
		$room_availiability = $this->fees_availiability->getRoomAvailiabilityByBusinessId($business_id,'Non-Funded');
		//pr($room_availiability);die;
		$output['terms'] = $terms;
		$output['rooms'] = $rooms;
		$output['room_availiability'] = $room_availiability;
		$output['business_id'] = $business_id;
		$output['sets'] = $sets;
		$this->load->view('front/includes/header', $output);
		$this->load->view('front/non_funded_children/business_room_availiability');
		$this->load->view('front/includes/footer');
	}

	function add_business_room_availiability() {
		
		if (isset($_POST) && !empty($_POST)) {
			$room_availiability = $this->input->post('room_availiability');
			$flag = 0;
			$business_session_types = array();

			if ($room_availiability) {

				foreach ($room_availiability as $k => $availiabilityDays) {

					foreach ($availiabilityDays as $key => $value) {
						$_POST['room_availiability_'.$k.'_'.$key.'_monday'] = $value["monday"];
						$_POST['room_availiability_'.$k.'_'.$key.'_tuesday'] = $value["tuesday"];
						$_POST['room_availiability_'.$k.'_'.$key.'_wednesday'] = $value["wednesday"];
						$_POST['room_availiability_'.$k.'_'.$key.'_thursday'] = $value["thursday"];
						$_POST['room_availiability_'.$k.'_'.$key.'_friday'] = $value["friday"];
						$_POST['room_availiability_'.$k.'_'.$key.'_saturday'] = $value["saturday"];
						$_POST['room_availiability_'.$k.'_'.$key.'_sunday'] = $value["sunday"];
						$room_name = $value["room_name"];

						$this->form_validation->set_rules('room_availiability_'.$k.'_'.$key.'_monday', 'monday', 'trim|required', array('required' => 'Please Enter children quantity for %s in room '.$room_name));
						$this->form_validation->set_rules('room_availiability_'.$k.'_'.$key.'_tuesday', 'tuesday', 'trim|required', array('required' => 'Please Enter children quantity for %s in room '.$room_name));
						$this->form_validation->set_rules('room_availiability_'.$k.'_'.$key.'_wednesday', 'wednesday', 'trim|required', array('required' => 'Please Enter children quantity for %s in room '.$room_name));
						$this->form_validation->set_rules('room_availiability_'.$k.'_'.$key.'_thursday', 'thursday', 'trim|required', array('required' => 'Please Enter children quantity for %s in room '.$room_name));
						$this->form_validation->set_rules('room_availiability_'.$k.'_'.$key.'_friday', 'friday', 'trim|required', array('required' => 'Please Enter children quantity for %s in room '.$room_name));
						$this->form_validation->set_rules('room_availiability_'.$k.'_'.$key.'_saturday', 'saturday', 'trim|required', array('required' => 'Please Enter children quantity for %s in room '.$room_name));
						$this->form_validation->set_rules('room_availiability_'.$k.'_'.$key.'_sunday', 'sunday', 'trim|required', array('required' => 'Please Enter children quantity for %s in room '.$room_name));
					}

				}

			} else {
				$this->form_validation->set_rules('room_availiability[]', 'rooms', 'trim|required', array('required' => 'Please add %s first'));
			}

			$this->form_validation->set_rules('business_id', 'business id', 'trim|required');

			if ($this->form_validation->run()) {
				$business_id = $this->input->post('business_id');
				
				foreach ($room_availiability as $k => $availiabilityDays) {
					
					foreach ($availiabilityDays as $key => $value) {
						$roomAvailiability = array();
						$roomAvailiability['business_id'] = $business_id;
						$roomAvailiability['term_id'] = $value['term_id'];
						$roomAvailiability['room_id'] = $value['room_id'];
						$roomAvailiability['fees_type'] = 'Non-Funded';
						
						if (isset($value['customer_option']) && !empty($value['customer_option'])) {
							$roomAvailiability['customer_option'] = $value['customer_option'];
						} else {
							$roomAvailiability['customer_option'] = 'No';
						}
						$roomAvailiability['week_type'] = $value['week_type'];
						$roomAvailiability['monday'] = $value['monday'];
						$roomAvailiability['tuesday'] = $value['tuesday'];
						$roomAvailiability['wednesday'] = $value['wednesday'];
						$roomAvailiability['thursday'] = $value['thursday'];
						$roomAvailiability['friday'] = $value['friday'];
						$roomAvailiability['saturday'] = $value['saturday'];
						$roomAvailiability['sunday'] = $value['sunday'];
						
						if (isset($value['room_availiability_id']) && $value['room_availiability_id']) {

							$roomAvailiability['update_date'] = $this->common_model->getDefaultToGMTDate(time());
							$this->fees_availiability->update_room_availiability($roomAvailiability, $value['room_availiability_id']);

						} else {
							$roomAvailiability['add_date'] = $this->common_model->getDefaultToGMTDate(time());
							$this->fees_availiability->add_room_availiability($roomAvailiability);
						}
					}
				}
				$message = 'Room availiability added successfully.';
				$success = true;
				$data['redirectURL'] = base_url('fees-and-availiability');

			} else {
				$success = false;
				$message = validation_errors();
			}
			$data['message'] = $message;
			$data['success'] = $success;
			echo json_encode($data);die;               
	    }
	}

	// function check_name_exist($value, $id = '')
 //    {
 //        if ($this->fees_availiability->doesSessionNameExist( $value, $id )) {
 //            $this->form_validation->set_message('check_name_exist', 'This Session Name already register on our server.');
 //            return false;
 //        }
 //        return true;
 //    }

	function check_space($value)
    {
        if ( ! preg_match("/^[a-zA-Z'0-9_@#$^&%*)(_+}{;:?\/., -]*$/", $value) ) {
           $this->form_validation->set_message('check_space', 'The %s field should contain only letters, numbers or periods');
           return false;
        }
        else
        return true;
    }
}