<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_quote extends CI_Controller {
	
	function __construct() {
		Parent::__construct();
		$this->common_model->checkChildcareLoginInCustomer();
		$this->load->model('front/User_quote_model', 'user_quote');
		$this->load->model('front/user_model', 'users');
		$this->load->model('mailsending_model','mailsending');
		$this->load->helper('string');
	}
	
	public function start_quote() {
		$output['page'] = 'dashboard';
		$output['page_active'] = 'start_quote';
		$random_id = '';
		$id = '';

		if(isset($_GET['unique_id'])) {
			$id = $_GET['unique_id'];
		}
		$is_data_exist = $this->user_quote->get_start_quote_by_id($id);
		if ($is_data_exist) {
			$output['start_quote'] = $is_data_exist;
		}
		
		if ($this->input->post()) {
			$uid = $this->input->post('unique_id');
			
			if ($uid) {
				$id = $uid;
			}
			$success = false;
			$message = '';
			$failure = false;
			$fees_type = $this->input->post('fees_type');
			$age_group = $this->input->post('age_group');
			$this->form_validation->set_rules('start_date', 'start date', 'trim|required');
			$this->form_validation->set_rules('child_first_name', 'first name', 'trim|required');
			$this->form_validation->set_rules('child_last_name', 'last name', 'trim|required');
			$this->form_validation->set_rules('child_date_of_birth', 'date of birth', 'trim|required');

			if ($this->form_validation->run()) {
				$start_quote = array();
				$unique_id = random_string('alnum',20);
				$date = str_replace('/', '-', $this->input->post('start_date'));
				// $start_quote['start_date'] = $this->input->post('start_date');
				$start_quote['start_date'] = date('Y-m-d', strtotime($date));
				$start_quote['child_first_name'] = $this->input->post('child_first_name');
				$start_quote['child_last_name'] = $this->input->post('child_last_name');

				$child_date_of_birth = str_replace('/', '-', $this->input->post('child_date_of_birth'));
				$start_quote['child_date_of_birth'] = date('Y-m-d', strtotime($child_date_of_birth));
				$start_quote['funded_hours_15'] = $this->input->post('funded_hours_15');
				$start_quote['funded_hours_30'] = $this->input->post('funded_hours_30');
				$start_quote['child_age'] = $this->input->post('child_age');
				$start_quote['child_age_in_days'] = $this->input->post('child_age_in_days');
				$start_quote['age_in'] = $this->input->post('age_in');
				$start_quote['fees_type'] = $fees_type;
				$start_quote['age_group'] = $age_group;
				$start_quote['ip_address'] = $_SERVER['REMOTE_ADDR'];
				$is_data_exist = $this->user_quote->get_start_quote_by_id($id);
				
				if ($is_data_exist) {
					$start_quote['update_date'] = $this->common_model->getDefaultToGMTDate(time());
					$start_quote_id = $is_data_exist->id;
					$random_id = $is_data_exist->unique_id;
					$response = $this->user_quote->update_start_quote_by_id($start_quote, $start_quote_id);
					
					if ($response) {
						$failure = false;

					} else {
						$failure = true;
					}

				} else {
					$start_quote['add_date'] = $this->common_model->getDefaultToGMTDate(time());
					$start_quote['unique_id'] = $unique_id;
					$random_id = $unique_id;
					$insert_id = $this->user_quote->add_start_quote($start_quote);

					if ($insert_id) {
						$failure = false;
					
					} else {
						$failure = true;
					}
				}

				if ($failure) {
					$message = 'Technical error. Please try again later.';
					$success = false;
			
				} else {
					$message = false;
					$success = true;
					
					if (($fees_type == 'Non_Funded') && ($age_group == '0_2')) {
						$data['redirectURL'] = site_url('non-funded-age-group-0-2/'.$random_id);
					
					} else if (($fees_type == 'Funded') && ($age_group == '2_3')) {
						$data['redirectURL'] = site_url('funded-age-group-2-3/'.$random_id);
					
					} else if (($fees_type == 'Funded') && ($age_group == '15_3_5')) {
						$data['redirectURL'] = site_url('funded_15/age-group-3-5/'.$random_id);
					
					} else if (($fees_type == 'Funded') && ($age_group == '30_3_5')) {
						$data['redirectURL'] = site_url('funded_30/age-group-3-5/'.$random_id);
					
					} else if(($fees_type == 'Non_Funded') && ($age_group == 'above_5')) {
						$data['redirectURL'] = site_url('non-funded-age-group-above-5/'.$random_id);
					} else {
						$data['redirectURL'] = site_url('non-funded-age-group-0-2/'.$random_id);
					}
				}

			} else {
				$message = validation_errors();
				$success = false;
			}
			
		    $data['success'] = $success;
			$data['message'] = $message;
		    echo json_encode($data); die;
		}
		$this->load->view('front/includes/header', $output);
		$this->load->view('front/user_quote/start_quote');
		$this->load->view('front/includes/footer');
	}

	public function start_quote_one($unique_id) {
		$is_data_exist = $this->user_quote->get_start_quote_by_id($unique_id);
		
		if (!$is_data_exist) {
			redirect('start-quote');
		} 
		//$this->common_model->checkRequestedDataExists($is_data_exist);
		$output['page'] = 'dashboard';
		$output['page_active'] = 'start_quote_one';
		$output['service_provides'] = $this->user_quote->get_non_funded_0_2_service_provides();
		$output['session_types'] = $this->user_quote->get_non_funded_38_session_types();
		$output['unique_id'] = $unique_id;
		$customerServices = $this->user_quote->get_customer_services_tamp($unique_id,$is_data_exist->id,$is_data_exist->fees_type,$is_data_exist->age_group);

		$sessionTypes = $this->user_quote->get_customer_session_types_tamp($unique_id,$is_data_exist->id,$is_data_exist->fees_type,$is_data_exist->age_group,$is_data_exist->week_type);
		$output['sessionTypes'] =  $sessionTypes;
		$output['customerServices'] = $customerServices;
		$output['start_quote'] = $is_data_exist;

		if ($this->input->post()) {
			$service_provide_ids = $this->input->post('service_provide_id');
			
			$success = true;
			$message = '';
			$failure = false;
			$have_session = false;
			$this->form_validation->set_rules('service_provide_id[]', 'service provide', 'trim|required');

			if ($this->form_validation->run()) {
				$sessions = $this->input->post('session');
				
				if ($sessions) {

					foreach ($sessions as $k => $val) {
						
						if (isset($val['session_type_id']) && !empty($val['session_type_id'])) {
							$count = count($val);

							if ($count <= 2) {
								$message.= "<p>Please select atleast one day in ".$val['session_name']."<p>";
								$failure = true;
								$success = false;
							} else {
								$have_session = true;
							}
						}
					}
				}
				
				if (!$have_session && !$failure) {
					$message = "<p>Please select atleast one session.</p>";
					$failure = true;
					$success = false;
				}

				if (!$failure) {


					$start_quote = array();
					$service_provide_ids = $this->input->post('service_provide_id');
					$add_service_provide = array();
				
					if ($customerServices) {
						$this->user_quote->delete_service_provide($unique_id,$is_data_exist->id);
					}
					
					foreach ($service_provide_ids as $key => $value) {
						$add_service_provide[$key]['start_quote_id'] = $is_data_exist->id;
						$add_service_provide[$key]['unique_id'] = $unique_id;
						$add_service_provide[$key]['service_provide_id'] = $value;
						$add_service_provide[$key]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
					}
					$this->user_quote->add_service_provide_tamp($add_service_provide);
					
							
					if ($sessions) {

						if ($sessionTypes) {
							$this->user_quote->delete_session_type($unique_id,$is_data_exist->id);
						}
						$week_type = $this->input->post('week_type');
				
						if ($week_type){
							$this->user_quote->updateWeekTypeById($is_data_exist->id, $unique_id, $week_type);
						}
						
						
						foreach ($sessions as $k => $val) {
							$i = 0;
							$add_session = array();
							
							if (isset($val['monday']) && $val['monday']) {
								$add_session[$i]['start_quote_id'] = $is_data_exist->id;
								$add_session[$i]['unique_id'] = $unique_id;
								$add_session[$i]['session_type_id'] = $val['session_type_id'];
								$add_session[$i]['week_type'] = $this->input->post('week_type');
								$add_session[$i]['day'] = 'Monday';
								$add_session[$i]['day_availability'] = $val['monday'];
								$add_session[$i]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
								$i++;
							}

							if (isset($val['tuesday']) && $val['tuesday']) {
								$add_session[$i]['start_quote_id'] = $is_data_exist->id;
								$add_session[$i]['unique_id'] = $unique_id;
								$add_session[$i]['session_type_id'] = $val['session_type_id'];
								$add_session[$i]['week_type'] = $this->input->post('week_type');
								$add_session[$i]['day'] = 'Tuesday';
								$add_session[$i]['day_availability'] = $val['tuesday'];
								$add_session[$i]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
								$i++;
							}

							if (isset($val['wednesday']) && $val['wednesday']) {
								$add_session[$i]['start_quote_id'] = $is_data_exist->id;
								$add_session[$i]['unique_id'] = $unique_id;
								$add_session[$i]['session_type_id'] = $val['session_type_id'];
								$add_session[$i]['week_type'] = $this->input->post('week_type');
								$add_session[$i]['day'] = 'Wednesday';
								$add_session[$i]['day_availability'] = $val['wednesday'];
								$add_session[$i]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
								$i++;
							}

							if (isset($val['thursday']) && $val['thursday']) {
								$add_session[$i]['start_quote_id'] = $is_data_exist->id;
								$add_session[$i]['unique_id'] = $unique_id;
								$add_session[$i]['session_type_id'] = $val['session_type_id'];
								$add_session[$i]['week_type'] = $this->input->post('week_type');
								$add_session[$i]['day'] = 'Thursday';
								$add_session[$i]['day_availability'] = $val['thursday'];
								$add_session[$i]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
								$i++;
							}

							if (isset($val['friday']) && $val['friday']) {
								$add_session[$i]['start_quote_id'] = $is_data_exist->id;
								$add_session[$i]['unique_id'] = $unique_id;
								$add_session[$i]['session_type_id'] = $val['session_type_id'];
								$add_session[$i]['week_type'] = $this->input->post('week_type');
								$add_session[$i]['day'] = 'Friday';
								$add_session[$i]['day_availability'] = $val['friday'];
								$add_session[$i]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
								$i++;
							}

							if (isset($val['saturday']) && $val['saturday']) {
								$add_session[$i]['start_quote_id'] = $is_data_exist->id;
								$add_session[$i]['unique_id'] = $unique_id;
								$add_session[$i]['session_type_id'] = $val['session_type_id'];
								$add_session[$i]['week_type'] = $this->input->post('week_type');
								$add_session[$i]['day'] = 'Saturday';
								$add_session[$i]['day_availability'] = $val['saturday'];
								$add_session[$i]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
								$i++;
							}

							if (isset($val['sunday']) && $val['sunday']) {
								$add_session[$i]['start_quote_id'] = $is_data_exist->id;
								$add_session[$i]['unique_id'] = $unique_id;
								$add_session[$i]['session_type_id'] = $val['session_type_id'];
								$add_session[$i]['week_type'] = $this->input->post('week_type');
								$add_session[$i]['day'] = 'Sunday';
								$add_session[$i]['day_availability'] = $val['sunday'];
								$add_session[$i]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
								$i++;

							}
							$this->user_quote->add_session_tamp($add_session);
						}

						$message = false;
						$success = true;
						$data['redirectURL'] = site_url('user_quote/final_submission/'.$is_data_exist->unique_id);
					} else {
						$message = 'Please select atleast one session.';
						$success = false;
					}
				}

			} else {
				$message = validation_errors();
				$success = false;
			}
			$data['success'] = $success;
		    $data['message'] = $message;
		    echo json_encode($data); die;
		}

		$this->load->view('front/includes/header', $output);
		$this->load->view('front/user_quote/start_quote_one');
		$this->load->view('front/includes/footer');
	}

	function getAjaxNonFundesQuoteOne() {
		$week_type = $this->input->get('week_type');
		$unique_id = $this->input->get('unique_id');
		$start_quote_id = $this->input->get('start_quote_id');
		$fees_type = $this->input->get('fees_type');
		$age_group = $this->input->get('age_group');
		$output = array();
		
		if ($week_type == "38") {
			$output['session_types'] = $this->user_quote->get_non_funded_38_session_types();
			$sessionTypes = $this->user_quote->get_customer_session_types_tamp($unique_id,$start_quote_id,$fees_type,$age_group,$week_type);
			$output['sessionTypes'] = $sessionTypes;

		} else if($week_type == "52"){
			$output['session_types'] = $this->user_quote->get_non_funded_52_session_types();
			$sessionTypes = $this->user_quote->get_customer_session_types_tamp($unique_id,$start_quote_id,$fees_type,$age_group,$week_type);
			$output['sessionTypes'] = $sessionTypes;
			
		} else {
			$output['sessionTypes'] = '';
		}
        $html = $this->load->view('front/user_quote/get_ajax_non_funded_one',$output, true);
        $data['html'] = $html;
        $data['success']= true;
        echo json_encode($data); die(); 
    }

    public function funded_start_quote_one($unique_id) {
		$is_data_exist = $this->user_quote->get_start_quote_by_id($unique_id);
		
		if (!$is_data_exist) {
			redirect('start-quote');
		} 
		//$this->common_model->checkRequestedDataExists($is_data_exist);
		$output['page'] = 'dashboard';
		$output['page_active'] = 'funded_start_quote_one';
		$output['service_provides'] = $this->user_quote->get_funded_2_3_service_provides();
		$output['session_types'] = $this->user_quote->get_funded_38_session_type_one();
		$output['unique_id'] = $unique_id;
		$customerServices = $this->user_quote->get_customer_services_tamp($unique_id,$is_data_exist->id,$is_data_exist->fees_type,$is_data_exist->age_group);
		$sessionTypes = $this->user_quote->get_customer_session_types_tamp($unique_id,$is_data_exist->id,$is_data_exist->fees_type,$is_data_exist->age_group,$is_data_exist->week_type);
		$output['customerServices'] = $customerServices;
		$output['sessionTypes'] =  $sessionTypes;
		$output['start_quote'] = $is_data_exist;

		if ($this->input->post()) {
			$service_provide_ids = $this->input->post('service_provide_id');
			$success = true;
			$message = '';
			$failure = false;
			$have_session = false;
			$this->form_validation->set_rules('service_provide_id[]', 'service provide', 'trim|required');

			if ($this->form_validation->run()) {
				$sessions = $this->input->post('session');
				
				if ($sessions) {
					
					foreach ($sessions as $k => $val) {
						
						if (isset($val['session_type_id']) && !empty($val['session_type_id'])) {
							$count = count($val);

							if ($count <= 2) {
								$message.= "<p>Please select atleast one day in ".$val['session_name']."<p>";
								$failure = true;
								$success = false;
							} else {
								$have_session = true;
							}
						}
					}
				}
				
				if (!$have_session && !$failure) {
					$message = "<p>Please select atleast one session.</p>";
					$failure = true;
					$success = false;
				}

				if (!$failure) {
					$start_quote = array();
					$service_provide_ids = $this->input->post('service_provide_id');
					$add_service_provide = array();
				
					if ($customerServices) {
						$this->user_quote->delete_service_provide($unique_id,$is_data_exist->id);
					}
					
					foreach ($service_provide_ids as $key => $value) {
						$add_service_provide[$key]['start_quote_id'] = $is_data_exist->id;
						$add_service_provide[$key]['unique_id'] = $unique_id;
						$add_service_provide[$key]['service_provide_id'] = $value;
						$add_service_provide[$key]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
					}
					$this->user_quote->add_service_provide_tamp($add_service_provide);
					
							
					if ($sessions) {

						if ($sessionTypes) {
							$this->user_quote->delete_session_type($unique_id, $is_data_exist->id);
						}
						$week_type = $this->input->post('week_type');
				
						if ($week_type){
							$this->user_quote->updateWeekTypeById($is_data_exist->id, $unique_id, $week_type);
						}
						
						
						foreach ($sessions as $k => $val) {
							$i = 0;
							$add_session = array();
							
							if (isset($val['monday']) && $val['monday']) {
								$add_session[$i]['start_quote_id'] = $is_data_exist->id;
								$add_session[$i]['unique_id'] = $unique_id;
								$add_session[$i]['session_type_id'] = $val['session_type_id'];
								$add_session[$i]['week_type'] = $this->input->post('week_type');
								$add_session[$i]['day'] = 'Monday';
								$add_session[$i]['day_availability'] = $val['monday'];
								$add_session[$i]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
								$i++;
							}

							if (isset($val['tuesday']) && $val['tuesday']) {
								$add_session[$i]['start_quote_id'] = $is_data_exist->id;
								$add_session[$i]['unique_id'] = $unique_id;
								$add_session[$i]['session_type_id'] = $val['session_type_id'];
								$add_session[$i]['week_type'] = $this->input->post('week_type');
								$add_session[$i]['day'] = 'Tuesday';
								$add_session[$i]['day_availability'] = $val['tuesday'];
								$add_session[$i]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
								$i++;
							}

							if (isset($val['wednesday']) && $val['wednesday']) {
								$add_session[$i]['start_quote_id'] = $is_data_exist->id;
								$add_session[$i]['unique_id'] = $unique_id;
								$add_session[$i]['session_type_id'] = $val['session_type_id'];
								$add_session[$i]['week_type'] = $this->input->post('week_type');
								$add_session[$i]['day'] = 'Wednesday';
								$add_session[$i]['day_availability'] = $val['wednesday'];
								$add_session[$i]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
								$i++;
							}

							if (isset($val['thursday']) && $val['thursday']) {
								$add_session[$i]['start_quote_id'] = $is_data_exist->id;
								$add_session[$i]['unique_id'] = $unique_id;
								$add_session[$i]['session_type_id'] = $val['session_type_id'];
								$add_session[$i]['week_type'] = $this->input->post('week_type');
								$add_session[$i]['day'] = 'Thursday';
								$add_session[$i]['day_availability'] = $val['thursday'];
								$add_session[$i]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
								$i++;

							}

							if (isset($val['friday']) && $val['friday']) {
								$add_session[$i]['start_quote_id'] = $is_data_exist->id;
								$add_session[$i]['unique_id'] = $unique_id;
								$add_session[$i]['session_type_id'] = $val['session_type_id'];
								$add_session[$i]['week_type'] = $this->input->post('week_type');
								$add_session[$i]['day'] = 'Friday';
								$add_session[$i]['day_availability'] = $val['friday'];
								$add_session[$i]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
								$i++;
							}

							if (isset($val['saturday']) && $val['saturday']) {
								$add_session[$i]['start_quote_id'] = $is_data_exist->id;
								$add_session[$i]['unique_id'] = $unique_id;
								$add_session[$i]['session_type_id'] = $val['session_type_id'];
								$add_session[$i]['week_type'] = $this->input->post('week_type');
								$add_session[$i]['day'] = 'Saturday';
								$add_session[$i]['day_availability'] = $val['saturday'];
								$add_session[$i]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
								$i++;
							}

							if (isset($val['sunday']) && $val['sunday']) {
								$add_session[$i]['start_quote_id'] = $is_data_exist->id;
								$add_session[$i]['unique_id'] = $unique_id;
								$add_session[$i]['session_type_id'] = $val['session_type_id'];
								$add_session[$i]['week_type'] = $this->input->post('week_type');
								$add_session[$i]['day'] = 'Sunday';
								$add_session[$i]['day_availability'] = $val['sunday'];
								$add_session[$i]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
								$i++;

							}
							$this->user_quote->add_session_tamp($add_session);
						}
						$message = false;
						$success = true;
						$data['redirectURL'] = site_url('user_quote/final_submission/'.$is_data_exist->unique_id);
					} else {
						$message = 'Please select atleast one session.';
						$success = false;
					}
				}

			} else {
				$message = validation_errors();
				$success = false;
			}
			$data['success'] = $success;
		    $data['message'] = $message;
		    echo json_encode($data); die;
		}
		$this->load->view('front/includes/header', $output);
		$this->load->view('front/user_quote/funded_quote_one');
		$this->load->view('front/includes/footer');
	}

	function getAjaxFundesQuoteOne() {
		$week_type = $this->input->get('week_type');
		$unique_id = $this->input->get('unique_id');
		$start_quote_id = $this->input->get('start_quote_id');
		$fees_type = $this->input->get('fees_type');
		$age_group = $this->input->get('age_group');
		$output = array();
		
		if ($week_type == "38") {
			$output['session_types'] = $this->user_quote->get_funded_38_session_type_one();
			$sessionTypes = $this->user_quote->get_customer_session_types_tamp($unique_id,$start_quote_id,$fees_type,$age_group,$week_type);
			$output['sessionTypes'] = $sessionTypes;
		
		} else if ($week_type == "52") {
			$output['session_types'] = $this->user_quote->get_funded_52_session_type_one();
			$sessionTypes = $this->user_quote->get_customer_session_types_tamp($unique_id,$start_quote_id,$fees_type,$age_group,$week_type);
			$output['sessionTypes'] = $sessionTypes;
		}
        $html = $this->load->view('front/user_quote/get_ajax_funded_quote_one',$output, true);
        $data['html'] = $html;
        $data['success']= true;
        echo json_encode($data); die(); 
    }

    public function funded_start_quote_two($unique_id) {
		$is_data_exist = $this->user_quote->get_start_quote_by_id($unique_id);

		if (!$is_data_exist) {
			redirect('start-quote');
		} 
		//$this->common_model->checkRequestedDataExists($is_data_exist);
		$output['page'] = 'dashboard';
		$output['page_active'] = 'funded_start_quote_two';
		$output['service_provides'] = $this->user_quote->get_funded_15_3_5_service_provides();
		$output['session_types'] = $this->user_quote->get_funded_38_session_type_one();
		$output['unique_id'] = $unique_id;
		$customerServices = $this->user_quote->get_customer_services_tamp($unique_id,$is_data_exist->id,$is_data_exist->fees_type,$is_data_exist->age_group);
		$sessionTypes = $this->user_quote->get_customer_session_types_tamp($unique_id,$is_data_exist->id,$is_data_exist->fees_type,$is_data_exist->age_group,$is_data_exist->week_type);
		$output['customerServices'] = $customerServices;
		$output['sessionTypes'] =  $sessionTypes;
		$output['start_quote'] = $is_data_exist;

		if ($this->input->post()) {
			$service_provide_ids = $this->input->post('service_provide_id');
			$success = true;
			$message = '';
			$failure = false;
			$have_session = false;
			$this->form_validation->set_rules('service_provide_id[]', 'service provide', 'trim|required');

			if ($this->form_validation->run()) {
				$sessions = $this->input->post('session');
				
				if ($sessions) {
					
					foreach ($sessions as $k => $val) {
						
						if (isset($val['session_type_id']) && !empty($val['session_type_id'])) {
							$count = count($val);

							if ($count <= 2) {
								$message.= "<p>Please select atleast one day in ".$val['session_name']."<p>";
								$failure = true;
								$success = false;
							} else {
								$have_session = true;
							}
						}
					}
				}
				
				if (!$have_session && !$failure) {
					$message = "<p>Please select atleast one session.</p>";
					$failure = true;
					$success = false;
				}

				if (!$failure) {
					$start_quote = array();
					$service_provide_ids = $this->input->post('service_provide_id');
					$add_service_provide = array();
				
					if ($customerServices) {
						$this->user_quote->delete_service_provide($unique_id,$is_data_exist->id);
					}
					
					foreach ($service_provide_ids as $key => $value) {
						$add_service_provide[$key]['start_quote_id'] = $is_data_exist->id;
						$add_service_provide[$key]['unique_id'] = $unique_id;
						$add_service_provide[$key]['service_provide_id'] = $value;
						$add_service_provide[$key]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
					}
					$this->user_quote->add_service_provide_tamp($add_service_provide);
							
					if ($sessions) {
						
						if ($sessionTypes) {
							$this->user_quote->delete_session_type($unique_id,$is_data_exist->id);
						}

						$week_type = $this->input->post('week_type');
				
						if ($week_type){
							$this->user_quote->updateWeekTypeById($is_data_exist->id, $unique_id, $week_type);
						}
						
						foreach ($sessions as $k => $val) {
							$i = 0;
							$add_session = array();
							
							if (isset($val['monday']) && $val['monday']) {
								$add_session[$i]['start_quote_id'] = $is_data_exist->id;
								$add_session[$i]['unique_id'] = $unique_id;
								$add_session[$i]['session_type_id'] = $val['session_type_id'];
								$add_session[$i]['week_type'] = $this->input->post('week_type');
								$add_session[$i]['day'] = 'Monday';
								$add_session[$i]['day_availability'] = $val['monday'];
								$add_session[$i]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
								$i++;
							}

							if (isset($val['tuesday']) && $val['tuesday']) {
								$add_session[$i]['start_quote_id'] = $is_data_exist->id;
								$add_session[$i]['unique_id'] = $unique_id;
								$add_session[$i]['session_type_id'] = $val['session_type_id'];
								$add_session[$i]['week_type'] = $this->input->post('week_type');
								$add_session[$i]['day'] = 'Tuesday';
								$add_session[$i]['day_availability'] = $val['tuesday'];
								$add_session[$i]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
								$i++;
							}

							if (isset($val['wednesday']) && $val['wednesday']) {
								$add_session[$i]['start_quote_id'] = $is_data_exist->id;
								$add_session[$i]['unique_id'] = $unique_id;
								$add_session[$i]['session_type_id'] = $val['session_type_id'];
								$add_session[$i]['week_type'] = $this->input->post('week_type');
								$add_session[$i]['day'] = 'Wednesday';
								$add_session[$i]['day_availability'] = $val['wednesday'];
								$add_session[$i]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
								$i++;
							}

							if (isset($val['thursday']) && $val['thursday']) {
								$add_session[$i]['start_quote_id'] = $is_data_exist->id;
								$add_session[$i]['unique_id'] = $unique_id;
								$add_session[$i]['session_type_id'] = $val['session_type_id'];
								$add_session[$i]['week_type'] = $this->input->post('week_type');
								$add_session[$i]['day'] = 'Thursday';
								$add_session[$i]['day_availability'] = $val['thursday'];
								$add_session[$i]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
								$i++;

							}

							if (isset($val['friday']) && $val['friday']) {
								$add_session[$i]['start_quote_id'] = $is_data_exist->id;
								$add_session[$i]['unique_id'] = $unique_id;
								$add_session[$i]['session_type_id'] = $val['session_type_id'];
								$add_session[$i]['week_type'] = $this->input->post('week_type');
								$add_session[$i]['day'] = 'Friday';
								$add_session[$i]['day_availability'] = $val['friday'];
								$add_session[$i]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
								$i++;
							}

							if (isset($val['saturday']) && $val['saturday']) {
								$add_session[$i]['start_quote_id'] = $is_data_exist->id;
								$add_session[$i]['unique_id'] = $unique_id;
								$add_session[$i]['session_type_id'] = $val['session_type_id'];
								$add_session[$i]['week_type'] = $this->input->post('week_type');
								$add_session[$i]['day'] = 'Saturday';
								$add_session[$i]['day_availability'] = $val['saturday'];
								$add_session[$i]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
								$i++;
							}

							if (isset($val['sunday']) && $val['sunday']) {
								$add_session[$i]['start_quote_id'] = $is_data_exist->id;
								$add_session[$i]['unique_id'] = $unique_id;
								$add_session[$i]['session_type_id'] = $val['session_type_id'];
								$add_session[$i]['week_type'] = $this->input->post('week_type');
								$add_session[$i]['day'] = 'Sunday';
								$add_session[$i]['day_availability'] = $val['sunday'];
								$add_session[$i]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
								$i++;
							}
							$this->user_quote->add_session_tamp($add_session);
						}
						$message = false;
						$success = true;
						$data['redirectURL'] = site_url('user_quote/final_submission/'.$is_data_exist->unique_id);
					} else {
						$message = 'Please select atleast one session.';
						$success = false;
					}
				}

			} else {
				$message = validation_errors();
				$success = false;
			}
			$data['success'] = $success;
		    $data['message'] = $message;
		    echo json_encode($data); die;
		}
		$this->load->view('front/includes/header', $output);
		$this->load->view('front/user_quote/funded_quote_two');
		$this->load->view('front/includes/footer');
	}

	function getAjaxFundesQuoteTwo() {
		$week_type = $this->input->get('week_type');
		$unique_id = $this->input->get('unique_id');
		$start_quote_id = $this->input->get('start_quote_id');
		$fees_type = $this->input->get('fees_type');
		$age_group = $this->input->get('age_group');
		$output = array();
		
		if ($week_type == "38") {
			$output['session_types'] = $this->user_quote->get_funded_38_session_type_two();
			$sessionTypes = $this->user_quote->get_customer_session_types_tamp($unique_id,$start_quote_id,$fees_type,$age_group,$week_type);
			$output['sessionTypes'] = $sessionTypes;
		
		} else if ($week_type == "52"){
			$output['session_types'] = $this->user_quote->get_funded_52_session_type_two();
			$sessionTypes = $this->user_quote->get_customer_session_types_tamp($unique_id,$start_quote_id,$fees_type,$age_group,$week_type);
			$output['sessionTypes'] = $sessionTypes;
		} else {
			$output['session_types'] = "";
			$output['sessionTypes'] = "";
		}
        $html = $this->load->view('front/user_quote/get_ajax_funded_quote_two',$output, true);
        $data['html'] = $html;
        $data['success']= true;
        echo json_encode($data); die(); 
    }

   	public function funded_start_quote_three($unique_id) {
		$is_data_exist = $this->user_quote->get_start_quote_by_id($unique_id);

		if (!$is_data_exist) {
			redirect('start-quote');
		} 
		//$this->common_model->checkRequestedDataExists($is_data_exist);
		$output['page'] = 'dashboard';
		$output['page_active'] = 'funded_start_quote_three';
		$output['service_provides'] = $this->user_quote->get_funded_30_3_5_service_provides();
		$output['session_types'] = $this->user_quote->get_funded_38_session_type_three();
		$output['unique_id'] = $unique_id;
		$customerServices = $this->user_quote->get_customer_services_tamp($unique_id,$is_data_exist->id,$is_data_exist->fees_type,$is_data_exist->age_group);
		$sessionTypes = $this->user_quote->get_customer_session_types_tamp($unique_id,$is_data_exist->id,$is_data_exist->fees_type,$is_data_exist->age_group,$is_data_exist->week_type);
		$output['customerServices'] = $customerServices;
		$output['sessionTypes'] =  $sessionTypes;
		$output['start_quote'] = $is_data_exist;

		if ($this->input->post()) {
			$service_provide_ids = $this->input->post('service_provide_id');
			$success = true;
			$message = '';
			$failure = false;
			$have_session = false;
			$this->form_validation->set_rules('service_provide_id[]', 'service provide', 'trim|required');

			if ($this->form_validation->run()) {
				$sessions = $this->input->post('session');
				
				if ($sessions) {
					
					foreach ($sessions as $k => $val) {
						
						if (isset($val['session_type_id']) && !empty($val['session_type_id'])) {
							$count = count($val);

							if ($count <= 2) {
								$message.= "<p>Please select atleast one day in ".$val['session_name']."<p>";
								$failure = true;
								$success = false;
							} else {
								$have_session = true;
							}
						}
					}
				}
				
				if (!$have_session && !$failure) {
					$message = "<p>Please select atleast one session.</p>";
					$failure = true;
					$success = false;
				}

				if (!$failure) {
					$start_quote = array();
					$service_provide_ids = $this->input->post('service_provide_id');
					$add_service_provide = array();
				
					if ($customerServices) {
						$this->user_quote->delete_service_provide($unique_id,$is_data_exist->id);
					}
					
					foreach ($service_provide_ids as $key => $value) {
						$add_service_provide[$key]['start_quote_id'] = $is_data_exist->id;
						$add_service_provide[$key]['unique_id'] = $unique_id;
						$add_service_provide[$key]['service_provide_id'] = $value;
						$add_service_provide[$key]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
					}
					$this->user_quote->add_service_provide_tamp($add_service_provide);
							
					if ($sessions) {
						
						if ($sessionTypes) {
							$this->user_quote->delete_session_type($unique_id,$is_data_exist->id);
						}

						$week_type = $this->input->post('week_type');
				
						if ($week_type){
							$this->user_quote->updateWeekTypeById($is_data_exist->id, $unique_id, $week_type);
						}
						
						foreach ($sessions as $k => $val) {
							$i = 0;
							$add_session = array();
							
							if (isset($val['monday']) && $val['monday']) {
								$add_session[$i]['start_quote_id'] = $is_data_exist->id;
								$add_session[$i]['unique_id'] = $unique_id;
								$add_session[$i]['session_type_id'] = $val['session_type_id'];
								$add_session[$i]['week_type'] = $this->input->post('week_type');
								$add_session[$i]['day'] = 'Monday';
								$add_session[$i]['day_availability'] = $val['monday'];
								$add_session[$i]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
								$i++;
							}

							if (isset($val['tuesday']) && $val['tuesday']) {
								$add_session[$i]['start_quote_id'] = $is_data_exist->id;
								$add_session[$i]['unique_id'] = $unique_id;
								$add_session[$i]['session_type_id'] = $val['session_type_id'];
								$add_session[$i]['week_type'] = $this->input->post('week_type');
								$add_session[$i]['day'] = 'Tuesday';
								$add_session[$i]['day_availability'] = $val['tuesday'];
								$add_session[$i]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
								$i++;
							}

							if (isset($val['wednesday']) && $val['wednesday']) {
								$add_session[$i]['start_quote_id'] = $is_data_exist->id;
								$add_session[$i]['unique_id'] = $unique_id;
								$add_session[$i]['session_type_id'] = $val['session_type_id'];
								$add_session[$i]['week_type'] = $this->input->post('week_type');
								$add_session[$i]['day'] = 'Wednesday';
								$add_session[$i]['day_availability'] = $val['wednesday'];
								$add_session[$i]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
								$i++;
							}

							if (isset($val['thursday']) && $val['thursday']) {
								$add_session[$i]['start_quote_id'] = $is_data_exist->id;
								$add_session[$i]['unique_id'] = $unique_id;
								$add_session[$i]['session_type_id'] = $val['session_type_id'];
								$add_session[$i]['week_type'] = $this->input->post('week_type');
								$add_session[$i]['day'] = 'Thursday';
								$add_session[$i]['day_availability'] = $val['thursday'];
								$add_session[$i]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
								$i++;

							}

							if (isset($val['friday']) && $val['friday']) {
								$add_session[$i]['start_quote_id'] = $is_data_exist->id;
								$add_session[$i]['unique_id'] = $unique_id;
								$add_session[$i]['session_type_id'] = $val['session_type_id'];
								$add_session[$i]['week_type'] = $this->input->post('week_type');
								$add_session[$i]['day'] = 'Friday';
								$add_session[$i]['day_availability'] = $val['friday'];
								$add_session[$i]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
								$i++;
							}

							if (isset($val['saturday']) && $val['saturday']) {
								$add_session[$i]['start_quote_id'] = $is_data_exist->id;
								$add_session[$i]['unique_id'] = $unique_id;
								$add_session[$i]['session_type_id'] = $val['session_type_id'];
								$add_session[$i]['week_type'] = $this->input->post('week_type');
								$add_session[$i]['day'] = 'Saturday';
								$add_session[$i]['day_availability'] = $val['saturday'];
								$add_session[$i]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
								$i++;
							}

							if (isset($val['sunday']) && $val['sunday']) {
								$add_session[$i]['start_quote_id'] = $is_data_exist->id;
								$add_session[$i]['unique_id'] = $unique_id;
								$add_session[$i]['session_type_id'] = $val['session_type_id'];
								$add_session[$i]['week_type'] = $this->input->post('week_type');
								$add_session[$i]['day'] = 'Sunday';
								$add_session[$i]['day_availability'] = $val['sunday'];
								$add_session[$i]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
								$i++;

							}
							$this->user_quote->add_session_tamp($add_session);
						}
						$message = false;
						$success = true;
						$data['redirectURL'] = site_url('user_quote/final_submission/'.$is_data_exist->unique_id);
					
					} else {
						$message = 'Please select atleast one session.';
						$success = false;
					}
				}

			} else {
				$message = validation_errors();
				$success = false;
			}
			$data['success'] = $success;
		    $data['message'] = $message;
		    echo json_encode($data); die;
		}
		$this->load->view('front/includes/header', $output);
		$this->load->view('front/user_quote/funded_quote_three');
		$this->load->view('front/includes/footer');
	}
	
    function getAjaxFundesQuoteThree() {
		$week_type = $this->input->get('week_type');
		$unique_id = $this->input->get('unique_id');
		$start_quote_id = $this->input->get('start_quote_id');
		$fees_type = $this->input->get('fees_type');
		$age_group = $this->input->get('age_group');
		$output = array();
		
		if ($week_type == "38") {
			$output['session_types'] = $this->user_quote->get_funded_38_session_type_three();
			$sessionTypes = $this->user_quote->get_customer_session_types_tamp($unique_id,$start_quote_id,$fees_type,$age_group,$week_type);
			$output['sessionTypes'] = $sessionTypes;
		
		} else if ($week_type == "52"){
			$output['session_types'] = $this->user_quote->get_funded_52_session_type_three();
			$sessionTypes = $this->user_quote->get_customer_session_types_tamp($unique_id,$start_quote_id,$fees_type,$age_group,$week_type);
			$output['sessionTypes'] = $sessionTypes;
		} else {
			$output['session_types'] = "";
			$output['sessionTypes'] = "";
		}
        $html = $this->load->view('front/user_quote/get_ajax_funded_quote_three',$output, true);
        $data['html'] = $html;
        $data['success']= true;
        echo json_encode($data); die(); 
    }


    public function non_funded_quote_above_5($unique_id) {
		$is_data_exist = $this->user_quote->get_start_quote_by_id($unique_id);

		if (!$is_data_exist) {
			redirect('start-quote');
		} 
		//$this->common_model->checkRequestedDataExists($is_data_exist);
		$output['page'] = 'dashboard';
		$output['page_active'] = 'non_funded_quote_above_5';
		$output['service_provides'] = $this->user_quote->get_non_funded_aboove_5_service_provides();
		$output['session_types'] = $this->user_quote->get_non_funded_38_session_types_5();
		$output['unique_id'] = $unique_id;
		$customerServices = $this->user_quote->get_customer_services_tamp($unique_id,$is_data_exist->id,$is_data_exist->fees_type,$is_data_exist->age_group);
		$sessionTypes = $this->user_quote->get_customer_session_types_tamp($unique_id,$is_data_exist->id,$is_data_exist->fees_type,$is_data_exist->age_group,$is_data_exist->week_type);
		$output['customerServices'] = $customerServices;
		$output['sessionTypes'] =  $sessionTypes;
		$output['start_quote'] = $is_data_exist;

		if ($this->input->post()) {
			$service_provide_ids = $this->input->post('service_provide_id');
			$week_type = $this->input->post('week_type');
			$success = true;
			$message = '';
			$failure = false;
			$have_session = false;
			$this->form_validation->set_rules('service_provide_id[]', 'service provide', 'trim|required');

			if ($this->form_validation->run()) {
				$sessions = $this->input->post('session');
				
				if ($sessions) {
					
					foreach ($sessions as $k => $val) {
						
						if (isset($val['session_type_id']) && !empty($val['session_type_id'])) {
							$count = count($val);

							if ($count <= 2) {
								$message.= "<p>Please select atleast one day in ".$val['session_name']."<p>";
								$failure = true;
								$success = false;
							} else {
								$have_session = true;
							}
						}
					}
				}
				
				if (!$have_session && !$failure) {
					$message = "<p>Please select atleast one session.</p>";
					$failure = true;
					$success = false;
				}

				if (!$failure) {
					$start_quote = array();
					$service_provide_ids = $this->input->post('service_provide_id');
					$add_service_provide = array();
				
					if ($customerServices) {
						$this->user_quote->delete_service_provide($unique_id,$is_data_exist->id);
					}
					
					foreach ($service_provide_ids as $key => $value) {
						$add_service_provide[$key]['start_quote_id'] = $is_data_exist->id;
						$add_service_provide[$key]['unique_id'] = $unique_id;
						$add_service_provide[$key]['service_provide_id'] = $value;
						$add_service_provide[$key]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
					}
					$this->user_quote->add_service_provide_tamp($add_service_provide);
							
					if ($sessions) {
						
						if ($sessionTypes) {
							$this->user_quote->delete_session_type($unique_id,$is_data_exist->id);
						}

						$week_type = $this->input->post('week_type');
				
						if ($week_type){
							$this->user_quote->updateWeekTypeById($is_data_exist->id, $unique_id, $week_type);
						}
						
						foreach ($sessions as $k => $val) {
							$i = 0;
							$add_session = array();
							
							if (isset($val['monday']) && $val['monday']) {
								$add_session[$i]['start_quote_id'] = $is_data_exist->id;
								$add_session[$i]['unique_id'] = $unique_id;
								$add_session[$i]['session_type_id'] = $val['session_type_id'];
								$add_session[$i]['week_type'] = $this->input->post('week_type');
								$add_session[$i]['day'] = 'Monday';
								$add_session[$i]['day_availability'] = $val['monday'];
								$add_session[$i]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
								$i++;
							}

							if (isset($val['tuesday']) && $val['tuesday']) {
								$add_session[$i]['start_quote_id'] = $is_data_exist->id;
								$add_session[$i]['unique_id'] = $unique_id;
								$add_session[$i]['session_type_id'] = $val['session_type_id'];
								$add_session[$i]['week_type'] = $this->input->post('week_type');
								$add_session[$i]['day'] = 'Tuesday';
								$add_session[$i]['day_availability'] = $val['tuesday'];
								$add_session[$i]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
								$i++;
							}

							if (isset($val['wednesday']) && $val['wednesday']) {
								$add_session[$i]['start_quote_id'] = $is_data_exist->id;
								$add_session[$i]['unique_id'] = $unique_id;
								$add_session[$i]['session_type_id'] = $val['session_type_id'];
								$add_session[$i]['week_type'] = $this->input->post('week_type');
								$add_session[$i]['day'] = 'Wednesday';
								$add_session[$i]['day_availability'] = $val['wednesday'];
								$add_session[$i]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
								$i++;
							}

							if (isset($val['thursday']) && $val['thursday']) {
								$add_session[$i]['start_quote_id'] = $is_data_exist->id;
								$add_session[$i]['unique_id'] = $unique_id;
								$add_session[$i]['session_type_id'] = $val['session_type_id'];
								$add_session[$i]['week_type'] = $this->input->post('week_type');
								$add_session[$i]['day'] = 'Thursday';
								$add_session[$i]['day_availability'] = $val['thursday'];
								$add_session[$i]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
								$i++;

							}

							if (isset($val['friday']) && $val['friday']) {
								$add_session[$i]['start_quote_id'] = $is_data_exist->id;
								$add_session[$i]['unique_id'] = $unique_id;
								$add_session[$i]['session_type_id'] = $val['session_type_id'];
								$add_session[$i]['week_type'] = $this->input->post('week_type');
								$add_session[$i]['day'] = 'Friday';
								$add_session[$i]['day_availability'] = $val['friday'];
								$add_session[$i]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
								$i++;
							}

							if (isset($val['saturday']) && $val['saturday']) {
								$add_session[$i]['start_quote_id'] = $is_data_exist->id;
								$add_session[$i]['unique_id'] = $unique_id;
								$add_session[$i]['session_type_id'] = $val['session_type_id'];
								$add_session[$i]['week_type'] = $this->input->post('week_type');
								$add_session[$i]['day'] = 'Saturday';
								$add_session[$i]['day_availability'] = $val['saturday'];
								$add_session[$i]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
								$i++;
							}

							if (isset($val['sunday']) && $val['sunday']) {
								$add_session[$i]['start_quote_id'] = $is_data_exist->id;
								$add_session[$i]['unique_id'] = $unique_id;
								$add_session[$i]['session_type_id'] = $val['session_type_id'];
								$add_session[$i]['week_type'] = $this->input->post('week_type');
								$add_session[$i]['day'] = 'Sunday';
								$add_session[$i]['day_availability'] = $val['sunday'];
								$add_session[$i]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
								$i++;

							}
							$this->user_quote->add_session_tamp($add_session);
						}
						$message = false;
						$success = true;
						$data['redirectURL'] = site_url('user_quote/final_submission/'.$is_data_exist->unique_id);
					} else {
						$message = 'Please select atleast one session.';
						$success = false;
					}
				}

			} else {
				$message = validation_errors();
				$success = false;
			}
			$data['success'] = $success;
		    $data['message'] = $message;
		    echo json_encode($data); die;
		}
		$this->load->view('front/includes/header', $output);
		$this->load->view('front/user_quote/start_quote_five');
		$this->load->view('front/includes/footer');
	}

	// function getAjaxNonFundesQuoteFive() {
	// 	$week_type = $this->input->get('week_type');
	// 	$output = array();
		
	// 	if ($week_type == "week_type_38") {
	// 		$output['session_types'] = $this->user_quote->get_non_funded_38_session_types_5();
		
	// 	} else {
	// 		$output['session_types'] = $this->user_quote->get_non_funded_52_session_type_5();
	// 	}
 //        $html = $this->load->view('front/user_quote/get_ajax_non_funded_quote_five',$output, true);
 //        $data['html'] = $html;
 //        $data['success']= true;
 //        echo json_encode($data); die(); 
 //    }

     function getAjaxNonFundesQuoteFive() {
		$week_type = $this->input->get('week_type');
		$unique_id = $this->input->get('unique_id');
		$start_quote_id = $this->input->get('start_quote_id');
		$fees_type = $this->input->get('fees_type');
		$age_group = $this->input->get('age_group');
		$output = array();
		
		if ($week_type == "38") {
			$output['session_types'] = $this->user_quote->get_non_funded_38_session_types_5();
			$sessionTypes = $this->user_quote->get_customer_session_types_tamp($unique_id,$start_quote_id,$fees_type,$age_group,$week_type);
			$output['sessionTypes'] = $sessionTypes;
		
		} else if ($week_type == "52"){
			$output['session_types'] = $this->user_quote->get_non_funded_52_session_type_5();
			$sessionTypes = $this->user_quote->get_customer_session_types_tamp($unique_id,$start_quote_id,$fees_type,$age_group,$week_type);
			$output['sessionTypes'] = $sessionTypes;
		} else {
			$output['session_types'] = "";
			$output['sessionTypes'] = "";
		}
        $html = $this->load->view('front/user_quote/get_ajax_non_funded_quote_five',$output, true);
        $data['html'] = $html;
        $data['success']= true;
        echo json_encode($data); die(); 
    }

    public function final_submission($unique_id) {
		$output['page'] = 'dashboard';
		$output['page_active'] = 'view_quote';
		$output['unique_id'] = $unique_id;
    	$quote_detail = $this->user_quote->get_start_quote_by_id($unique_id);

    	if (!$quote_detail) {

    		if ($this->input->is_ajax_request()) {
    			$data['success'] = false;
				$data['message'] = false;
				$data['redirectURL'] = site_url('start-quote');
			    echo json_encode($data); die;

    		} else {
				redirect('start-quote');
    		}
		}
    	$this->common_model->checkRequestedDataExists($quote_detail);
		$carricular_activities = $this->user_quote->get_carricular_activities();
		$special_education = $this->user_quote->get_special_education();
    	$customerServices = $this->user_quote->get_customer_services_tamp($unique_id,$quote_detail->id,$quote_detail->fees_type,$quote_detail->age_group);
		$sessionTypes = $this->user_quote->get_customer_session_types_tamp($unique_id,$quote_detail->id,$quote_detail->fees_type,$quote_detail->age_group,$quote_detail->week_type);
		$output['quote_detail'] = $quote_detail ;
		$output['carricular_activities'] = $carricular_activities;
		$output['special_education'] = $special_education;
		$output['customerServices'] = $customerServices;
		$output['sessionTypes'] = $sessionTypes;
	
		if ($this->input->post()) {
			$success = false;
			$message = '';
			$failure = false;
			$this->form_validation->set_rules('carricular_activities[]', 'carricular activity', 'trim|required');
			$this->form_validation->set_rules('special_education[]', 'special education', 'trim|required');
			$this->form_validation->set_rules('miles', 'miles', 'trim|required');
			$this->form_validation->set_rules('post_code_1', 'post code 1', 'trim|required');
			$this->form_validation->set_rules('post_code_2', 'post code 2', 'trim');
			$this->form_validation->set_rules('first_name', 'first name', 'trim|required');
			$this->form_validation->set_rules('last_name', 'last name', 'trim|required');
			$this->form_validation->set_rules('email_address', 'email address', 'trim|required|valid_email');

			if ($this->form_validation->run()) {
				$address = $_POST['post_code_1'].' '.$_POST['post_code_2'];
				$url = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($address)."&key=AIzaSyCxhgcC9Un6YMIVL5agYr7ygNvQMt306Nc";

			    $result_string = file_get_contents($url);
				$result = json_decode($result_string, true);

				if ($result['status'] == 'ZERO_RESULTS') {
					$message = 'Please select a valid address.';
					$success = false;

				} else {
					$result1[] = $result['results'][0];
					$result2[] = $result1[0]['geometry'];
					$result3[] = $result2[0]['location'];
					$term_data = $this->user_quote->checkCustomerTermExist($quote_detail->start_date);

					$quote_data = array();
					$quote_data['unique_id'] = $quote_detail->unique_id;

					if ($term_data) {
						$quote_data['term_id'] = $term_data->id;
					}
					$quote_data['start_date'] = $quote_detail->start_date;
					$quote_data['child_first_name'] = $quote_detail->child_first_name;
					$quote_data['child_last_name'] = $quote_detail->child_last_name;
					$quote_data['child_date_of_birth'] = $quote_detail->child_date_of_birth;
					$quote_data['child_age'] = $quote_detail->child_age;
					$quote_data['child_age_in_days'] = $quote_detail->child_age_in_days;
					$quote_data['age_in'] = $quote_detail->age_in;
					$quote_data['funded_hours_15'] = $quote_detail->funded_hours_15;
					$quote_data['funded_hours_30'] = $quote_detail->funded_hours_30;
					$quote_data['fees_type'] = $quote_detail->fees_type;
					$quote_data['age_group'] = $quote_detail->age_group;
					$quote_data['miles'] = $this->input->post('miles');
					$quote_data['post_code_1'] = $this->input->post('post_code_1');
					$quote_data['post_code_2'] = $this->input->post('post_code_2');
					$quote_data['latitude'] = $result3[0]['lat'];
					$quote_data['longitude'] = $result3[0]['lng'];
					$quote_data['first_name'] = $this->input->post('first_name');
					$quote_data['last_name'] = $this->input->post('last_name');
					$quote_data['email_address'] = $this->input->post('email_address');
					$quote_data['add_date'] = $this->common_model->getDefaultToGMTDate(time());
					$response = $this->user_quote->add_final_submission($quote_data);

					if ($response) {

						if (!empty($customerServices)) {
							$add_service_provide = array();
							foreach ($customerServices as $key => $value) {
								$add_service_provide[$key]['start_quote_id'] = $response;
								$add_service_provide[$key]['unique_id'] = $quote_detail->unique_id;
								$add_service_provide[$key]['service_provide_id'] = $value->service_provide_id;
								$add_service_provide[$key]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
							}
							$this->user_quote->add_service_provide($add_service_provide);
						}

						if (!empty($sessionTypes)) {
							$add_session_type = array();

							foreach ($sessionTypes as $key => $value) {
								$add_session_type[$key]['start_quote_id'] = $response;
								$add_session_type[$key]['unique_id'] = $quote_detail->unique_id;
								$add_session_type[$key]['session_type_id'] = $value->session_type_id;
								$add_session_type[$key]['week_type'] = $value->week_type;
								$add_session_type[$key]['day'] = $value->day;
								$add_session_type[$key]['day_availability'] = $value->day_availability;
								$add_session_type[$key]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
							}
							$this->user_quote->add_session_types($add_session_type);
						}

						$carricular_activities = $this->input->post('carricular_activities');
						
						if (!empty($carricular_activities)) {
							$add_carricular_activity = array();
							
							foreach ($carricular_activities as $key => $value) {
								$add_carricular_activity[$key]['start_quote_id'] = $quote_detail->id;
								$add_carricular_activity[$key]['unique_id'] = $quote_detail->unique_id;
								$add_carricular_activity[$key]['carricular_activity_id '] = $value;
								$add_carricular_activity[$key]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
							}
							$this->user_quote->add_carricular_activities($add_carricular_activity);
						}

						$special_education = $this->input->post('special_education');
						
						if (!empty($special_education)) {
							$add_special_education = array();
							
							foreach ($carricular_activities as $key => $value) {
								$add_special_education[$key]['start_quote_id'] = $quote_detail->id;
								$add_special_education[$key]['unique_id'] = $quote_detail->unique_id;
								$add_special_education[$key]['special_education_id '] = $value;
								$add_special_education[$key]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
							}
							$this->user_quote->add_special_education($add_special_education);
						}

						$message = 'Your quote submitted successfully.';
						$success = true;
						$this->user_quote->delete_user_temp_quote_by_id($quote_detail->id);
						$data['redirectURL'] = site_url('user-quote/'.$unique_id);
					
					} else {
						$message = 'Technical error. Please try again later.';
						$success = true;
					}
				}

			} else {
				$message = validation_errors();
				$success = false;
			}
			
		    $data['success'] = $success;
			$data['message'] = $message;
		    echo json_encode($data); die;
		}
		$this->load->view('front/includes/header', $output);
		$this->load->view('front/user_quote/final_submission');
		$this->load->view('front/includes/footer');
	}

	public function quoted($unique_id) {
		$quote_basic_data = $this->user_quote->get_quote_data($unique_id);

		if (!$quote_basic_data) {
			$this->common_model->checkRequestedDataExists($quote_basic_data); 
		}
		$output['page'] = 'dashboard';
		$output['page_active'] = 'view_quote';
		$output['unique_id'] = $unique_id;
		$this->load->view('front/includes/header', $output);
		$this->load->view('front/user_quote/quoted_list');
		$this->load->view('front/includes/footer');
	}

	function ajaxQuotedata() {
		$this->load->library('pagination');
		$unique_id = $this->input->get('unique_id');
		$quote_basic_data = $this->user_quote->get_quote_data($unique_id);
		$fees_type = $quote_basic_data->fees_type;//Funded/Non_Funded
		$age_group = $quote_basic_data->age_group;//0_2/2_3/15_3_5/30_3_5/above_5/
		$term_id = $quote_basic_data->term_id;
		$child_age = $quote_basic_data->child_age;

		$quote_session_data = $this->user_quote->get_quote_session_data_group_by($unique_id);
		$session_type_ids = array();

		foreach ($quote_session_data as $key => $value) {
			$session_type_ids[] = $value->session_type_id;
		}
		
		$quote_provision_data = $this->user_quote->get_quote_provision_data($unique_id);
		$session_provision_ids = array();

		foreach ($quote_provision_data as $key => $value) {
			$session_provision_ids[] = $value->service_provide_id;
		}

		$success = true;
        $html = false;
        $load_prev_link = false;
        $load_next_link = false;
		$per_page = '5';
		$page_no = $this->input->get('page_no')?$this->input->get('page_no'):1;
		$page_no_index = ($page_no - 1) * $per_page;
		$sQuery = '';

		if ($unique_id) {
			$sQuery = $sQuery.'&unique_id='.$unique_id;
		}

		$searchData['search_index'] = $page_no_index;
		$searchData['limit'] = $per_page;	
		$searchData['unique_id'] = $unique_id;
		$searchData['session_type_ids'] = $session_type_ids;
		$searchData['session_provision_ids'] = $session_provision_ids;
		$searchData['age_group'] = $age_group;
		$searchData['latitude'] = $quote_basic_data->latitude;
		$searchData['longitude'] = $quote_basic_data->longitude;
		$searchData['radius'] = $quote_basic_data->miles;

		if ($fees_type == 'Non_Funded') {
			$searchData['fees_type'] = 'Non-Funded';

		} else {
			$searchData['fees_type'] = $fees_type;
		}

	   	$config['base_url'] = site_url('user_quote/ajaxQuotedata?'.$sQuery);
		$total_rows = $this->user_quote->count_providers_search($searchData);

		$config['total_rows'] = $total_rows;
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$paging  = $this->pagination->create_links();

		//Fees calculation
		$week_type = $quote_session_data[0]->week_type;//38-52
		// $week_type = 52;

		$quote_all_session_data = $this->user_quote->get_quote_session_data($unique_id);
		$days = array();

		if ($quote_all_session_data) {

			foreach ($quote_all_session_data as $key => $value) {
				$days[$key]['day'] = $value->day;
				$days[$key]['session_type_id'] = $value->session_type_id;
			}
		}

		$records = $this->user_quote->get_providers_list($searchData);

		foreach ($records as $key => $value) {
			// Calculate distance between latitude and longitude
		    $theta = $value->longitude - $quote_basic_data->longitude;
		    $dist = sin(deg2rad($value->latitude)) * sin(deg2rad($quote_basic_data->latitude)) +  cos(deg2rad($value->latitude)) * cos(deg2rad($quote_basic_data->latitude)) * cos(deg2rad($theta));
		    $dist = acos($dist);
		    $dist = rad2deg($dist);
		    $miles = $dist * 60 * 1.1515;

		    // Convert unit and return distance
		    $value->distance_miles = round($miles, 1).' miles';

			$fees = 0;
			$is_parent_break = false;

			if ($session_type_ids) {
				$i = 0;

				foreach ($session_type_ids as $k => $v) {
					$checkSessionTypeExist = $this->user_quote->getSessionTypeByBusinessIDAndSessionTypeID($value->id, $v, $searchData['fees_type'], $week_type);

					if (!$checkSessionTypeExist) {
						$fees = 0;
						$is_parent_break = true;

						unset($records[$key]);
						break;

					} else {

						if ($checkSessionTypeExist->age_type == "different_sets") {
							$records[$key]->session_fees[$i] = $checkSessionTypeExist;
							$calculate_fees = $this->calculateFees($quote_all_session_data, $checkSessionTypeExist);
							$fees = $fees + $calculate_fees;
							$i++;

						} else {
							$sameSetDays = $this->user_quote->getBusinessSessionTypeByID($checkSessionTypeExist->business_session_type_id);

							if ($sameSetDays) {
								$is_exist = false;

								foreach ($quote_all_session_data as $qkey => $qvalue) {
									$break_loop = false;

									if ($qvalue->session_type_id == $checkSessionTypeExist->session_type_id) {
										
										foreach ($sameSetDays as $skey => $svalue) {
											$totalSameSetDays = count($sameSetDays) - 1;

											if ($svalue->day == $qvalue->day) {
												$is_exist = true;
												break;

											} else {
												
												
												if ($totalSameSetDays == $skey) {
													unset($records[$key]);
													$break_loop = true;
													$is_exist = false;
													break;
												}
											}
										}
									}

									if ($break_loop) {
										break;
									}
								}
								

								if ($is_exist) {
									$records[$key]->session_fees[$i] = $checkSessionTypeExist;
									$calculate_fees = $this->calculateFees($quote_all_session_data, $checkSessionTypeExist);
									$fees = $fees + $calculate_fees;
									$i++;
								}
							}
						}
					}
				}
	        }

	        if ($is_parent_break) {

	        } else {
	        	$records[$key]->total_fees = $fees;
	        }
		}

		if ($records) {  

			$records = array_values($records);

			foreach ($records as $k_final => $v_final) {
				//availbility work from here
				$business_room_detail = $this->user_quote->getBusinessRoom($v_final->id, $child_age);
				
				if ($business_room_detail) {
					$business_room_avaiability = $this->user_quote->getRoomAvailability($v_final->id, $term_id, $business_room_detail->id, $week_type, $searchData['fees_type']);
					
					if ($business_room_avaiability) {
						$v_final->room_availbility = min(array($business_room_avaiability->monday, $business_room_avaiability->tuesday, $business_room_avaiability->wednesday, $business_room_avaiability->thursday, $business_room_avaiability->friday, $business_room_avaiability->saturday, $business_room_avaiability->sunday));
						$v_final->is_waiting_option = $business_room_avaiability->customer_option;

						$checkAlreadySaved = $this->user_quote->getSavedQuoteById($v_final->id, $quote_basic_data->id);

						if ($checkAlreadySaved) {
							$v_final->is_quote_save = 'Yes';

						} else {
							$v_final->is_quote_save = 'No';
						}

					} else {
						unset($records[$k_final]);
					}

				} else {
					unset($records[$k_final]);
				}
			}
		}

		$output['records'] = $records;
		$output['user_quote_id'] = $quote_basic_data->id;
		$output['share_text'] =  "Dummy text";
		$output['unique_id'] =  $unique_id;
		$html = $this->load->view('front/user_quote/ajax_quoted_list', $output, true);

		if ($records && !empty($records)) {
			$data['is_record_found'] = true;

		} else {
			$data['is_record_found'] = false;
		}
		$data['success'] = true;
		$data['html'] = $html;
		$data['paging']	= $paging; 
		echo json_encode($data); die;	
	}

	function calculateFees($quoteData, $sessionTypeData){
		$total_fees = 0;
		if ($quoteData) {

			foreach ($quoteData as $key => $value) {
				
				if ($value->session_type_id == $sessionTypeData->session_type_id) {
					$day = $value->day;

					if ($day == "Monday") {
						$total_fees = $total_fees + $sessionTypeData->day_1;
					} else if ($day == "Tuesday") {
						$total_fees = $total_fees + $sessionTypeData->day_2;
					} else if ($day == "Wednesday") {
						$total_fees = $total_fees + $sessionTypeData->day_3;
					} else if ($day == "Thursday") {
						$total_fees = $total_fees + $sessionTypeData->day_4;
					} else if ($day == "Friday") {
						$total_fees = $total_fees + $sessionTypeData->day_5;
					} else if ($day == "Saturday") {
						$total_fees = $total_fees + $sessionTypeData->day_6;
					} else if ($day == "Sunday") {
						$total_fees = $total_fees + $sessionTypeData->day_7;
					}
				}
			}
		}

		return $total_fees;
	}

	function detail()
	{
		$bid = $_GET['bid'];
		$unique_id = $_GET['unique_id'];
		$fees = base64_decode($_GET['fees']);
		$quote_basic_data = $this->user_quote->get_quote_data($unique_id);

		if (!$quote_basic_data) {
			$this->common_model->checkRequestedDataExists($quote_basic_data); 
		}
		$output['page'] = 'dashboard';
		$output['page_active'] = 'view_quote';
		$output['unique_id'] = $unique_id;
		$output['user_quote_id'] = $quote_basic_data->id;
		$output['fees'] = $fees;

		if ($quote_basic_data->post_code_2 && !empty($quote_basic_data->post_code_2)) {
			$output['post_code'] = '['.$quote_basic_data->post_code_1.']['.$quote_basic_data->post_code_2.']';

		} else {
			$output['post_code'] = '['.$quote_basic_data->post_code_1.']';
		}

		$business_detail = $this->user_quote->getBusinessDetail($bid);

		if ($business_detail) {
			// Calculate distance between latitude and longitude
		    $theta    = $business_detail->longitude - $quote_basic_data->longitude;
		    $dist    = sin(deg2rad($business_detail->latitude)) * sin(deg2rad($quote_basic_data->latitude)) +  cos(deg2rad($business_detail->latitude)) * cos(deg2rad($quote_basic_data->latitude)) * cos(deg2rad($theta));
		    $dist    = acos($dist);
		    $dist    = rad2deg($dist);
		    $miles    = $dist * 60 * 1.1515;
		    
		    // Convert unit and return distance
		    $business_detail->distance_miles = round($miles, 1).' miles';
			$business_service = $this->user_quote->getBusinessServiceDetail($business_detail->service_type_id, $business_detail->user_id);
			$business_service->education = $this->users->get_selected_education($business_service->user_service_detail_id);
			$business_service->activity = $this->users->get_selected_activity($business_service->user_service_detail_id);
			$business_detail->business_service = $business_service;
			$output['share_text'] =  "Dummy text";

			$quote_session_data = $this->user_quote->quote_session_data($unique_id);
			$output['sessionTypes'] = $quote_session_data;
			$output['business_detail'] = $business_detail;
			$output['quote_expire_date'] = date('d/M/Y', strtotime($quote_basic_data->start_date. ' + 3 days'));
			$saveQuoteData = $this->user_quote->getSavedQuoteById($bid, $quote_basic_data->id);

			if ($saveQuoteData) {
				$output['reference_number'] = $saveQuoteData->reference_number;
			} else {
				$output['reference_number'] = "";
			}
			// $getFees = $this->user_quote->getFeesData();

		} else {
			echo "<center><strong>Business Not Found</strong></center>";die;
		}

		//pr($business_detail);die;
		$this->load->view('front/includes/header', $output);
		$this->load->view('front/user_quote/detail_of_provider');
		$this->load->view('front/includes/footer');
	}

	function saveInQuoteList()
	{
		$business_id = $this->input->get('business_id');
		$quote_id = $this->input->get('quote_id');
		$fees = $this->input->get('fees');

		$checkAlreadySaved = $this->user_quote->getSavedQuoteById($business_id, $quote_id);

		if ($checkAlreadySaved) {
			$data['success'] = false;
			$data['message'] = "You already added quote in list.";

		} else {
			$uniqueid = rand('100000','999999');
			$input = array();
			$input['quote_id'] = $quote_id;
			$input['business_id'] = $business_id;
			$input['reference_number'] = 'REF'.$business_id.'-'.$uniqueid;
			$input['fees'] = $fees;
			$input['add_date'] = $this->common_model->getDefaultToGMTDate(time());

			$saved_quote_id = $this->user_quote->insert_in_save_quote($input);

			if ($saved_quote_id) {
				$data['success'] = true;
				$data['message'] = "Successfully added in quote list.";

			} else {
				$data['success'] = false;
				$data['message'] = "Technical error, Please try again.";
			}
		}

		echo json_encode($data);
	}

	function removeFromQuoteList()
	{
		$business_id = $this->input->get('business_id');
		$quote_id = $this->input->get('quote_id');

		$checkAlreadySaved = $this->user_quote->getSavedQuoteById($business_id, $quote_id);

		if ($checkAlreadySaved) {
			$this->user_quote->delete_saved_quote($checkAlreadySaved->id);
			$data['success'] = true;
			$data['message'] = "Successfully removed from quote list.";

		} else {
			$data['success'] = false;
			$data['message'] = "This business not added in your quote list.";
		}

		echo json_encode($data);
	}

	function view_save_quote($unique_id)
	{
		$output['page'] = 'dashboard';
		$output['page_active'] = 'view_save_quote';
		$quote_basic_data = $this->user_quote->get_quote_data($unique_id);
		$this->common_model->checkRequestedDataExists($quote_basic_data); 
		$output['unique_id'] = $unique_id;

		// $get_all_saved_quote = $this->user_quote->getSavedQuoteByQuoteId($quote_basic_data->id);

		// if ($get_all_saved_quote) {

		// } else {
		// 	echo "<center><strong>No record available</strong></center>";die;
		// }
		$this->load->view('front/includes/header', $output);
		$this->load->view('front/user_quote/view_save_quote');
		$this->load->view('front/includes/footer');
	}

	function ajaxSavedQuotedata() {
		$this->load->library('pagination');
		$unique_id = $this->input->get('unique_id');
		$quote_basic_data = $this->user_quote->get_quote_data($unique_id);
		$this->common_model->checkRequestedDataExists($quote_basic_data);

		$term_id = $quote_basic_data->term_id;
		$child_age = $quote_basic_data->child_age;
		$fees_type = $quote_basic_data->fees_type;//Funded/Non_Funded

		$success = true;
        $html = false;
        $load_prev_link = false;
        $load_next_link = false;
		$per_page = '5';
		$page_no = $this->input->get('page_no')?$this->input->get('page_no'):1;
		$page_no_index = ($page_no - 1) * $per_page;
		$sQuery = '';

		if ($unique_id) {
			$sQuery = $sQuery.'&unique_id='.$unique_id;
		}

		$searchData['search_index'] = $page_no_index;
		$searchData['limit'] = $per_page;	
		$searchData['unique_id'] = $unique_id;
		$searchData['quote_id'] = $quote_basic_data->id;

		if ($fees_type == 'Non_Funded') {
			$searchData['fees_type'] = 'Non-Funded';

		} else {
			$searchData['fees_type'] = $fees_type;
		}

	   	$config['base_url'] = site_url('user_quote/ajaxSavedQuotedata?'.$sQuery);
		$total_rows = $this->user_quote->countSavedQuoteData($searchData);

		$config['total_rows'] = $total_rows;
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$paging  = $this->pagination->create_links();
		$quote_session_data = $this->user_quote->get_quote_session_data_group_by($unique_id);
		$week_type = $quote_session_data[0]->week_type;//38-52

		$records = $this->user_quote->getSavedQuoteData($searchData);

		foreach ($records as $key => $value) {

			$business_room = $this->user_quote->getBusinessRoom($value->id, $child_age);
				
			if ($business_room) {
				$business_room_avaiability = $this->user_quote->getRoomAvailability($value->id, $term_id, $business_room->id, $week_type, $searchData['fees_type']);
				
				if ($business_room_avaiability) {
					$value->room_availbility = min(array($business_room_avaiability->monday, $business_room_avaiability->tuesday, $business_room_avaiability->wednesday, $business_room_avaiability->thursday, $business_room_avaiability->friday, $business_room_avaiability->saturday, $business_room_avaiability->sunday));
					$value->is_waiting_option = $business_room_avaiability->customer_option;

					// Calculate distance between latitude and longitude
				    $theta    = $value->longitude - $quote_basic_data->longitude;
				    $dist    = sin(deg2rad($value->latitude)) * sin(deg2rad($quote_basic_data->latitude)) +  cos(deg2rad($value->latitude)) * cos(deg2rad($quote_basic_data->latitude)) * cos(deg2rad($theta));
				    $dist    = acos($dist);
				    $dist    = rad2deg($dist);
				    $miles    = $dist * 60 * 1.1515;
				    
				    // Convert unit and return distance
				    $value->distance_miles = round($miles, 1).' miles';
					$checkAlreadySaved = $this->user_quote->getSavedQuoteById($value->id, $quote_basic_data->id);

					if ($checkAlreadySaved) {
						$value->is_quote_save = 'Yes';

					} else {
						$value->is_quote_save = 'No';
					}

				} else {
					unset($records[$key]);
				}

			} else {
				unset($records[$key]);
			}
		}

		$output['records'] = $records;
		$output['user_quote_id'] = $quote_basic_data->id;
		$output['share_text'] =  "Dummy text";
		$output['unique_id'] =  $unique_id;
		$html = $this->load->view('front/user_quote/ajax_saved_quoted_list', $output, true);

		$data['success'] = true;
		$data['html'] = $html;
		$data['paging']	= $paging; 
		echo json_encode($data); die;	
	}

	function save_quote_detail()
	{
		$bid = $_GET['bid'];
		$unique_id = $_GET['unique_id'];
		$fees = base64_decode($_GET['fees']);
		$quote_basic_data = $this->user_quote->get_quote_data($unique_id);

		if (!$quote_basic_data) {
			$this->common_model->checkRequestedDataExists($quote_basic_data); 
		}
		$output['page'] = 'dashboard';
		$output['page_active'] = 'view_quote';
		$output['unique_id'] = $unique_id;
		$output['user_quote_id'] = $quote_basic_data->id;
		$business_detail = $this->user_quote->getBusinessDetail($bid);

		if ($quote_basic_data->post_code_2 && !empty($quote_basic_data->post_code_2)) {
			$output['post_code'] = '['.$quote_basic_data->post_code_1.']['.$quote_basic_data->post_code_2.']';

		} else {
			$output['post_code'] = '['.$quote_basic_data->post_code_1.']';
		}
	//pr($business_detail);die;
		if ($business_detail) {

			// Calculate distance between latitude and longitude
		    $theta    = $business_detail->longitude - $quote_basic_data->longitude;
		    $dist    = sin(deg2rad($business_detail->latitude)) * sin(deg2rad($quote_basic_data->latitude)) +  cos(deg2rad($business_detail->latitude)) * cos(deg2rad($quote_basic_data->latitude)) * cos(deg2rad($theta));
		    $dist    = acos($dist);
		    $dist    = rad2deg($dist);
		    $miles    = $dist * 60 * 1.1515;
		    
		    // Convert unit and return distance
		    $business_detail->distance_miles = round($miles, 1).' miles';
			$business_service = $this->user_quote->getBusinessServiceDetail($business_detail->service_type_id, $business_detail->user_id);
			$business_service->education = $this->users->get_selected_education($business_service->user_service_detail_id);
			$business_service->activity = $this->users->get_selected_activity($business_service->user_service_detail_id);
			$business_detail->business_service = $business_service;
			$output['share_text'] =  "Dummy text";

			$quote_session_data = $this->user_quote->quote_session_data($unique_id);
			$output['sessionTypes'] = $quote_session_data;
			//pr($business_detail);die;
			$output['business_detail'] = $business_detail;
			$output['quote_expire_date'] = date('d/M/Y', strtotime($quote_basic_data->start_date. ' + 3 days'));
			$saveQuoteData = $this->user_quote->getSavedQuoteById($bid, $quote_basic_data->id);

			if ($saveQuoteData) {
				$output['reference_number'] = $saveQuoteData->reference_number;
				$output['fees'] = $saveQuoteData->fees;
			} else {
				$output['reference_number'] = "";
				$output['fees'] = $fees;
			}

			// $getFees = $this->user_quote->getFeesData();

		} else {
			echo "<center><strong>Business Not Found</strong></center>";die;
		}
		// pr($business_detail);die;
		$this->load->view('front/includes/header', $output);
		$this->load->view('front/user_quote/detail_of_saved_provider');
		$this->load->view('front/includes/footer');
	}

	/*function send_email_to_providers()
	{
		$unique_id = $_GET['unique_id'];
		$quote_basic_data = $this->user_quote->get_quote_data($unique_id);
		$this->common_model->checkRequestedDataExists($quote_basic_data); 

		$get_all_saved_quote = $this->user_quote->getSavedQuoteByQuoteId($quote_basic_data->id);

		if ($get_all_saved_quote) {

			foreach ($get_all_saved_quote as $key => $value) {
				$this->mailsending->send_quote_email($quote_basic_data, $value->customer_enquiry_email, $value->trading_name, $value->reference_number);

				$update_status = array();
				$update_status['is_emailed'] = 'Yes';
				$update_status['update_date'] = $this->common_model->getDefaultToGMTDate(time());
				$response = $this->user_quote->updateQuoteStatus($update_status, $value->save_quote_id);
			}

			$data['success'] = true;
			$data['message'] = "Mail Send Successfully.";

		} else {
			$data['success'] = false;
			$data['message'] = "No saved quote found.";
		}

		echo json_encode($data);

	}
*/

	function send_email_to_customer()
	{
		$unique_id = $_GET['unique_id'];
		$quote_basic_data = $this->user_quote->get_quote_data($unique_id);
		$this->common_model->checkRequestedDataExists($quote_basic_data); 
		$get_all_saved_quote = $this->user_quote->getSavedQuoteByQuoteId($quote_basic_data->id);

		if ($get_all_saved_quote) {

			foreach ($get_all_saved_quote as $key => $value) {
				// Calculate distance between latitude and longitude
			    $theta    = $value->longitude - $quote_basic_data->longitude;
			    $dist    = sin(deg2rad($value->latitude)) * sin(deg2rad($quote_basic_data->latitude)) +  cos(deg2rad($value->latitude)) * cos(deg2rad($quote_basic_data->latitude)) * cos(deg2rad($theta));
			    $dist    = acos($dist);
			    $dist    = rad2deg($dist);
			    $miles    = $dist * 60 * 1.1515;
			    
			    // Convert unit and return distance
			    $distance_miles = round($miles, 1).' miles';

				$business_service = $this->user_quote->getBusinessServiceDetail($value->service_type_id, $value->user_id);
				$selected_education = $this->users->get_selected_education($business_service->user_service_detail_id);
				$special_education = array();
				
				if ($selected_education) {
					foreach ($selected_education as $keys => $vals) {
						$special_education[] = $vals->name;
					}
				}
				$special_education_list = implode(",",$special_education);
				$business_service->activity = $this->users->get_selected_activity($business_service->user_service_detail_id);
				$value->business_service = $business_service;
				$quote_session_data = $this->user_quote->quote_session_data($unique_id);
				$html = '';
				if($quote_session_data) {
					foreach ($quote_session_data as $k => $val) {
		    			$html .= '<tr>
							<td style=" border:1px solid #d5d5d5; border-bottom: 0;" width="50%"><span style="font-weight: 400; font-size: 16px; font-family: "Montserrat", sans-serif; color: #222222;">'.$val->day.':</span></td>
							<td align="left" style=" border:1px solid #d5d5d5; border-left: 0; border-bottom: 0;" width="50%"><span style="font-weight: 500; font-size: 16px; font-family: "Montserrat", sans-serif; color: #222222;">'.$val->session_name.'</span></td>
							</tr>';
			    	}

				}
				$quote_expire_date = date('d/M/Y', strtotime($quote_basic_data->start_date. ' + 3 days'));
				$this->mailsending->send_quote_email($quote_basic_data, $quote_basic_data->email_address, $value->trading_name,$business_service,$value->provision_name, $special_education_list, $value->reference_number,$html,$value->fees,$quote_expire_date, $value->customer_enquiry_number, $distance_miles);

				$update_status = array();
				$update_status['is_emailed'] = 'Yes';
				$update_status['update_date'] = $this->common_model->getDefaultToGMTDate(time());
				$response = $this->user_quote->updateQuoteStatus($update_status, $value->save_quote_id);
			}
			$data['success'] = true;
			$data['message'] = "Mail Send Successfully.";

		} else {
			$data['success'] = false;
			$data['message'] = "No saved quote found.";
		}
		echo json_encode($data);
	}

	function send_email_to_business_user()
	{
		$unique_id = $_GET['unique_id'];
		$business_id = $_GET['business_id'];
		$quote_basic_data = $this->user_quote->get_quote_data($unique_id);
		$this->common_model->checkRequestedDataExists($quote_basic_data); 
		$get_saved_quote = $this->user_quote->getSavedQuoteByQuoteIdBusinessId($quote_basic_data->id, $business_id);
		//pr($get_saved_quote);die;

		if ($get_saved_quote) {

			// Calculate distance between latitude and longitude
		    $theta    = $get_saved_quote->longitude - $quote_basic_data->longitude;
		    $dist    = sin(deg2rad($get_saved_quote->latitude)) * sin(deg2rad($quote_basic_data->latitude)) +  cos(deg2rad($get_saved_quote->latitude)) * cos(deg2rad($quote_basic_data->latitude)) * cos(deg2rad($theta));
		    $dist    = acos($dist);
		    $dist    = rad2deg($dist);
		    $miles    = $dist * 60 * 1.1515;
		    
		    // Convert unit and return distance
		    $distance_miles = round($miles, 1).' miles';

			$business_service = $this->user_quote->getBusinessServiceDetail($get_saved_quote->service_type_id, $get_saved_quote->user_id);
			$selected_education = $this->users->get_selected_education($business_service->user_service_detail_id);
			$special_education = array();
			
			if ($selected_education) {
				foreach ($selected_education as $keys => $vals) {
					$special_education[] = $vals->name;
				}
			}
			$special_education_list = implode(",",$special_education);
			$business_service->activity = $this->users->get_selected_activity($business_service->user_service_detail_id);
			$get_saved_quote->business_service = $business_service;
			$quote_session_data = $this->user_quote->quote_session_data($unique_id);
			$html = '';
			if($quote_session_data) {
				foreach ($quote_session_data as $k => $val) {
	    			$html .= '<tr>
						<td style=" border:1px solid #d5d5d5; border-bottom: 0;" width="50%"><span style="font-weight: 400; font-size: 16px; font-family: "Montserrat", sans-serif; color: #222222;">'.$val->day.':</span></td>
						<td align="left" style=" border:1px solid #d5d5d5; border-left: 0; border-bottom: 0;" width="50%"><span style="font-weight: 500; font-size: 16px; font-family: "Montserrat", sans-serif; color: #222222;">'.$val->session_name.'</span></td>
						</tr>';
		    	}

			}
			$quote_expire_date = date('d/M/Y', strtotime($quote_basic_data->start_date. ' + 3 days'));
			$update_status = array();
			$update_status['is_emailed'] = 'Yes';
			$update_status['update_date'] = $this->common_model->getDefaultToGMTDate(time());
			$response = $this->user_quote->updateQuoteStatus($update_status, $get_saved_quote->save_quote_id);

			if ($response) {
				$this->mailsending->send_quote_email($quote_basic_data, $quote_basic_data->email_address, $get_saved_quote->trading_name,$business_service, $get_saved_quote->provision_name, $special_education_list, $get_saved_quote->reference_number, $html, $get_saved_quote->fees, $quote_expire_date, $get_saved_quote->customer_enquiry_number, $distance_miles);

				$data['success'] = true;
				$data['message'] = "Mail Send Successfully.";

			} else {
				$data['success'] = false;
				$data['message'] = "Technical error, Please try again.";
			}

		} else {
			$data['success'] = false;
			$data['message'] = "First add this business in your quote.";
		}
		echo json_encode($data);
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