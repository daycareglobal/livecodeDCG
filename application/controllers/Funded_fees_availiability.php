<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Funded_fees_availiability extends CI_Controller {
	
	function __construct() {
		Parent::__construct();
		$this->common_model->checkChildcareLogin();
		$this->load->model('front/user_model', 'users');
		$this->load->model('front/Fees_availiability_model', 'fees_availiability');
		$this->load->model('mailsending_model','mailsending');
		$this->childcare_id = $this->session->userdata('childcare_id');
		// $this->common_model->checkChildcarePlanPurchase();
	}

	function funded_session() {
		$business_id = $_GET['bid'];
		$funded_type = $_GET['funded_type'];
		$getBusinessDetail = $this->fees_availiability->getBusinessDetailById($business_id, $this->childcare_id);
		$this->common_model->checkRequestedDataExists($getBusinessDetail);
		$output['page'] = 'dashboard';
		$output['page_active'] = 'fees_availiability';
		$output['business_id'] = $business_id;
		$output['funded_type'] = $funded_type;
		$output['session_types'] = $this->fees_availiability->getSessionTypesForNonFunded();
		$sessions = $this->fees_availiability->getSessionByBusiness($business_id,'Funded',$funded_type);

		foreach ($sessions as $key => $value) {
			$value->days = $this->fees_availiability->getDaysByBusinessSessionId($value->id);
		}
		$output['sessions'] = $sessions;

		if ($sessions) {
			$output['total_session'] = count($sessions);

		} else {
			$output['total_session'] = 1;
		}
		$age_type ='';

		$this->load->view('front/includes/header', $output);
		$this->load->view('front/funded_children/define_sessions_type');
		$this->load->view('front/includes/footer');
	}

	function append_new_session() {
		$output = array();
		$success = true;
		$output['session_index'] = $this->input->get('session_index');
		$output['session_types'] = $this->fees_availiability->getSessionTypesForNonFunded();
		$html = $this->load->view('front/funded_children/ajax_append_session', $output, true);

		$data['success'] = $success;
		$data['html'] = $html;
		echo json_encode($data);die;
	}

	function add_session_type_data() {
		
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
				     	$flag++;
				    }
				}
			}

			if ($flag > 0) {
				$this->form_validation->set_rules('session_type_id', 'session type', 'trim|required', array('required' => 'Please select unique %s.'));
			}

			$this->form_validation->set_rules('business_id', 'Business Id', 'trim|required');

			if (isset($_POST['session_week_per_year'])) {
				$this->form_validation->set_rules('session_week_per_year', 'Week per year', 'trim|required');
			}

			if ($this->form_validation->run()) {
				$business_id = $this->input->post('business_id');
				$funded_type = $this->input->post('funded_type');
				$session = $this->input->post('session');
				$session_type_ids = $this->input->post('session_type_ids');

				if (isset($session_type_ids)) {
					$this->fees_availiability->deleteOldFundedSession($business_id, $session_type_ids, 'Funded',$funded_type);
					$this->fees_availiability->deleteOldFundedSessionDays($business_id,'Funded',$funded_type);
				}

				foreach ($session as $key => $value) {
					$sessionTypeData = array();
					$sessionTypeData['business_id'] = $business_id;
					$sessionTypeData['session_type_id'] = $value['session_type_id'];
					$sessionTypeData['fees_type'] = 'Funded';
					$sessionTypeData['funded_age_group'] = $funded_type;

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
							$sessionTypeDaysData[$k]['fees_type'] = 'Funded';
							$sessionTypeDaysData[$k]['age_group'] = $funded_type;
							$sessionTypeDaysData[$k]['business_id'] = $business_id;
							$sessionTypeDaysData[$k]['day'] = $v;
							$sessionTypeDaysData[$k]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
						}

						if ($sessionTypeDaysData) {
							$this->fees_availiability->add_business_session_days($sessionTypeDaysData);
						}
					}

					$is_session_type_exist = $this->fees_availiability->getSessionTypeById($business_session_type_id, $business_id, 'Funded');
							
					if ($is_session_type_exist) {
						
						if ( ($is_session_type_exist->is_32_week_per_year == 'Yes')  && ($is_session_type_exist->is_52_week_per_year == 'No') ) {
							$this->fees_availiability->deleteMonthlyFessByWeek($business_session_type_id,$business_id, 'Funded', '52');
						}

						if (($is_session_type_exist->is_52_week_per_year == 'Yes') && ($is_session_type_exist->is_32_week_per_year == 'No')) {
							$this->fees_availiability->deleteMonthlyFessByWeek($business_session_type_id,$business_id, 'Funded', '38');
						}

						if (($is_session_type_exist->is_32_week_per_year == 'Yes') && ($is_session_type_exist->is_52_week_per_year == 'Yes')) {

						}

					}

				}

				$message = 'Session data successfully added.';
				$success = true;
				$data['redirectURL'] = base_url('funded-children/set-monthly-fees?bid=').$business_id.'&funded_type='.$funded_type;
			
			} else {
				$success = false;
				$message = validation_errors();
			}
			$data['message'] = $message;
			$data['success'] = $success;
			echo json_encode($data);die;               
	    }
	}

	function funded_monthly_fees() {
		$business_id = $_GET['bid'];
		$funded_type = $_GET['funded_type'];
		$getBusinessDetail = $this->fees_availiability->getBusinessDetailById($business_id, $this->childcare_id);
		$this->common_model->checkRequestedDataExists($getBusinessDetail);
		$output['page'] = 'dashboard';
		$output['page_active'] = 'fees_availiability';
		$output['business_id'] = $business_id;
		$output['funded_type'] = $funded_type;
		$output['business_sessions'] = $this->fees_availiability->getSessionByBusiness($business_id, 'Funded', $funded_type);
		//pr($output['business_sessions']);die;
		$age_type = '';
		$monthly_session_fees_group = $this->fees_availiability->getFundedMonthlyFeesByBusinessId($business_id,'Funded',$age_type,$funded_type,$funded_type);
		
		if ($monthly_session_fees_group) {

			foreach ($monthly_session_fees_group as $key => $value) {
				$value->session_fees = $this->fees_availiability->getMonthlyFeesByBusinessId($business_id,'Funded',$age_type, $value->business_session_type_id);
			}
		}
		$output['monthly_session_fees'] = $monthly_session_fees_group;
		//pr($output['monthly_session_fees']);die;

		if ($monthly_session_fees_group) {
			$output['total_monthly_session'] = count($monthly_session_fees_group);

		} else {
			$output['total_monthly_session'] = 1;
		}

		$room_availiability = $this->fees_availiability->getRoomAvailiabilityByBusinessId($business_id,'Funded');
		$output['room_availiability'] = $room_availiability;
		$output['weekType'] = $this->fees_availiability->getWeekType($business_id,'Funded', $funded_type);
		$this->load->view('front/includes/header', $output);
		$this->load->view('front/funded_children/monthly_fees');
		$this->load->view('front/includes/footer');
	}

	function append_monthly_fees_data() {
		$output = array();
		$success = true;
		$business_id = $this->input->get('business_id');
		$funded_type = $this->input->get('funded_type');
		$output['monthly_session_index'] = $this->input->get('monthly_session_index');
		$output['business_sessions'] = $this->fees_availiability->getSessionByBusiness($business_id,'Funded',$funded_type);
		$output['weekType'] = $this->fees_availiability->getWeekType($business_id,'Funded',$funded_type);
		$html = $this->load->view('front/funded_children/ajax_append_monthly_fees', $output, true);
		$data['success'] = $success;
		$data['html'] = $html;
		echo json_encode($data);die;
	}

	function add_monthly_fees_data() {
		
		if (isset($_POST) && !empty($_POST)) {
			$funded_type = $this->input->post('funded_type');
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

					$this->form_validation->set_rules('monthly_fees_'.$key.'_38_week_day_1', '38 Week Day 1', 'trim|required|numeric', array('required' => 'Please fill %s fee.'));
					$this->form_validation->set_rules('monthly_fees_'.$key.'_38_week_day_2', '38 Week Day 2', 'trim|required|numeric', array('required' => 'Please fill %s fee.'));
					$this->form_validation->set_rules('monthly_fees_'.$key.'_38_week_day_3', '38 Week Day 3', 'trim|required|numeric', array('required' => 'Please fill %s fee.'));
					$this->form_validation->set_rules('monthly_fees_'.$key.'_38_week_day_4', '38 Week Day 4', 'trim|required|numeric', array('required' => 'Please fill %s fee.'));
					$this->form_validation->set_rules('monthly_fees_'.$key.'_38_week_day_5', '38 Week Day 5', 'trim|required|numeric', array('required' => 'Please fill %s fee.'));
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

					$this->form_validation->set_rules('monthly_fees_'.$key.'_52_week_day_1', '52 Week Day 1', 'trim|required|numeric', array('required' => 'Please fill %s fee.'));
					$this->form_validation->set_rules('monthly_fees_'.$key.'_52_week_day_2', '52 Week Day 2', 'trim|required|numeric', array('required' => 'Please fill %s fee.'));
					$this->form_validation->set_rules('monthly_fees_'.$key.'_52_week_day_3', '52 Week Day 3', 'trim|required|numeric', array('required' => 'Please fill %s fee.'));
					$this->form_validation->set_rules('monthly_fees_'.$key.'_52_week_day_4', '52 Week Day 4', 'trim|required|numeric', array('required' => 'Please fill %s fee.'));
					$this->form_validation->set_rules('monthly_fees_'.$key.'_52_week_day_5', '52 Week Day 5', 'trim|required|numeric', array('required' => 'Please fill %s fee.'));
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
					$this->fees_availiability->deleteOldMonthlyFeesById($business_id,$monthly_fees_ids,'Funded');
				}

				$i = 0;
				
				foreach ($monthly_fees as $key => $value) {
					$businessSessionType = $this->fees_availiability->getBusinessSessionTypeById($value['business_session_type_id']);					
					$monthlyFees38Data = array();

					if (isset($value['week_38'])) {
						$monthlyFees38Data['business_id'] = $business_id;
						$monthlyFees38Data['business_session_type_id'] = $value['business_session_type_id'];
						$monthlyFees38Data['session_type_id'] = $businessSessionType->session_type_id;
						$monthlyFees38Data['fees_type'] = 'Funded';
						//$monthlyFees38Data['funded_type'] = $funded_type;
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
						$monthlyFeesData['fees_type'] = 'Funded';
						//$monthlyFeesData['funded_type'] = $funded_type;
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
				$data['redirectURL'] = base_url('funded-children/set-room-availiability?bid=').$business_id.'&funded_type='.$funded_type;

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
		$funded_type = $_GET['funded_type'];
		$getBusinessDetail = $this->fees_availiability->getBusinessDetailById($business_id, $this->childcare_id);
		$this->common_model->checkRequestedDataExists($getBusinessDetail);
		$output['page'] = 'dashboard';
		$output['page_active'] = 'fees_availiability';
		$terms = $this->fees_availiability->getTerms();
		$rooms = $this->fees_availiability->getRooms($business_id);
		$room_availiability = $this->fees_availiability->getRoomAvailiabilityByBusinessId($business_id,'Funded');
		$output['terms'] = $terms;
		$output['rooms'] = $rooms;
		$output['room_availiability'] = $room_availiability;
		$output['business_id'] = $business_id;
		$output['funded_type'] = $funded_type;
		$this->load->view('front/includes/header', $output);
		$this->load->view('front/funded_children/business_room_availiability');
		$this->load->view('front/includes/footer');
	}

	function add_business_room_availiability() {
		
		if (isset($_POST) && !empty($_POST)) {
			$room_availiability = $this->input->post('room_availiability');
			$flag = 0;
			$business_session_types = array();

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
			$this->form_validation->set_rules('business_id', 'business id', 'trim|required');

			if ($this->form_validation->run()) {
				$business_id = $this->input->post('business_id');
				
				foreach ($room_availiability as $k => $availiabilityDays) {
					
					foreach ($availiabilityDays as $key => $value) {
						$roomAvailiability = array();
						$roomAvailiability['business_id'] = $business_id;
						$roomAvailiability['term_id'] = $value['term_id'];
						$roomAvailiability['room_id'] = $value['room_id'];
						$roomAvailiability['fees_type'] = 'Funded';
						
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