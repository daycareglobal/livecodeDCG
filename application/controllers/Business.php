<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Business extends CI_Controller {
	
	function __construct() {
		Parent::__construct();
		$this->load->model('front/user_model', 'users');
		$this->load->model('front/business_types_model', 'business_type');
		$this->load->model('front/service_category_model', 'service_category');
		$this->load->model('front/home_model', 'home');
		$this->user_id = $this->session->userdata('user_id');
	}
	
	public function business_type() {
		$output['page'] = 'dashboard';
		$output['page_active'] = 'dashboard';
		$output['business_type'] = $_GET['business-type'];

		if (isset($_GET['business-type']) && !empty($_GET['business-type'])) {
			$business_type = $this->business_type->getBusinessTypeBySlug($_GET['business-type']);

			if ($business_type) {
				$business_list = $this->home->getAllBusinessByBusinessType($business_type->id);

				if ($business_list) {

					foreach ($business_list as $key => $value) {
						$value->business_images = $this->home->getUserBusinessImages($value->id);
						$value->business_service_types = $this->home->getUserBusinessServiceTypes($value->id);
						$business_service_days = $this->home->getUserBusinessServiceDays($value->id);

						if ($business_service_days) {

							foreach ($business_service_days as $k => $val) {
								# code...
							
								$val->open_time = $this->common_model->getGMTDateToLocalDate($val->open_time, 'h:i A');							
								$val->close_time = $this->common_model->getGMTDateToLocalDate($val->close_time, 'h:i A');
								# cobusiness_service_daysde...
							}

						}

						$value->business_service_days = $business_service_days;
					}
				}
				// pr($business_list); die;
				$output['business_list'] = $business_list;
				$this->load->view('front/includes/header', $output);
				$this->load->view('front/business/business_list');
				$this->load->view('front/includes/footer');

			} else {
				echo "<center><h1><b>Invalid URL String!!!</b></h1></center>";
			}

		} else {
			echo "<center><h1><b>Invalid URL String!!!</b></h1></center>";
		}
	}

	public function business_detail($id) {
		$output['page'] = 'dashboard';
		$output['page_active'] = 'dashboard';

		if (isset($id)) {
			$business_list = $this->home->getBusinessDetailById($id);

			if ($business_list) {
				$business_list->business_images = $this->home->getUserBusinessImages($business_list->id);
				$business_list->business_service_types = $this->home->getUserBusinessServiceTypes($business_list->id);
				$business_service_days = $this->home->getUserBusinessServiceDays($business_list->id);

				if ($business_service_days) {

					foreach ($business_service_days as $k => $val) {
						// $val->open_time = $this->common_model->getGMTDateToLocalDate($val->open_time, 'h:i A');
						// $val->close_time = $this->common_model->getGMTDateToLocalDate($val->close_time, 'h:i A');

						$val->open_time = $val->open_time;
						$val->close_time = $val->close_time;
					}

				}

				$business_list->business_service_days = $business_service_days;
			}

			$output['business_list'] = $business_list;
			$output['id'] = $id;
			$this->load->view('front/includes/header', $output);
			$this->load->view('front/business/business_detail');
			$this->load->view('front/includes/footer');

		} else {
			echo "<center><h1><b>Invalid URL String!!!</b></h1></center>";
		}
	}

	function my_profile()
	{
		$output['page'] = 'my_profile';
		$output['page_active'] = 'business_detail';
		$user_record = $this->users->get_record_by_id($this->user_id);
		$output['user_record'] = $user_record;

		$this->load->view('front/includes/header', $output);
		$this->load->view('front/dashboard/my_profile');
		$this->load->view('front/includes/footer');
	}

	function update_profile()
	{
		
		$output['page'] = 'my_profile';
		$output['page_active'] = 'business_detail';
		$user_record = $this->users->get_record_by_id($this->user_id);
		$output['user_record'] = $user_record;
		$output['country'] = $this->address->getCountryRecords();
		$output['state_id'] = '';
		$output['city_id'] = '';
		$output['city_name'] = '';
		
		if (isset($_GET['type'])) {
			$output['load_page'] = $_GET['type'];

		} else {
			$output['load_page'] = '';			
		}
		$output['business_details'] = $this->users->getUserBusinesRecords($this->user_id);

		$this->load->view('front/includes/header', $output);
		$this->load->view('front/dashboard/update_profile');
		$this->load->view('front/includes/footer');
	}

	function add_service()
	{		
		$output['page'] = 'add_service';
		$output['page_active'] = 'dashboard';
		$output['business_types'] = $this->business_type->getActiveRecords();
		$output['service_types'] = $this->service_category->getActiveRecords();

		if (isset($_POST) && !empty($_POST)) {
			$this->form_validation->set_rules('business_type_id', 'business type', 'trim|required|callback_check_space');
			$this->form_validation->set_rules('daycare_name', 'daycare name', 'trim|required|callback_check_space');
			$this->form_validation->set_rules('address', 'address', 'trim|required|callback_check_space');
			$this->form_validation->set_rules('latitude', 'latitude', 'trim|required');
			$this->form_validation->set_rules('longitude', 'longitude', 'trim|required');
			$this->form_validation->set_rules('hourly_charges', 'hourly charges', 'trim|required');
			$this->form_validation->set_rules('monthly_charges', 'monthly charges', 'trim|required');
			$this->form_validation->set_rules('daily_charges', 'daily charges', 'trim|required');
			$this->form_validation->set_rules('service_types[]', 'service types', 'trim|required');
			$this->form_validation->set_rules('about_daycare', 'about daycare', 'trim|required');

			if ($this->form_validation->run()) {
				$input['user_id'] = $this->user_id;
				$input['business_category_id'] = $this->input->post('business_type_id');
				$input['daycare_name'] = $this->input->post('daycare_name');
				$input['daycare_address'] = $this->input->post('address');
				$input['latitude'] = $this->input->post('latitude');
				$input['longitude'] = $this->input->post('longitude');
				$input['hourly_charges'] = $this->input->post('hourly_charges');
				$input['monthly_charges'] = $this->input->post('monthly_charges');
				$input['daily_charges'] = $this->input->post('daily_charges');
				$input['about_daycare_center'] = $this->input->post('about_daycare');
				$input['add_date'] = $this->common_model->getDefaultToGMTDate(time());
				$business_service_id = $this->home->insertBusinessDetails($input);
				// $business_service_id = true;

				if ($business_service_id) {
					$service_days = array();

					if (isset($_POST['monday']['open'])) {
						$service_days[0]['user_service_id'] = $business_service_id;
						$service_days[0]['day'] = 'monday';
						$service_days[0]['open_time'] = $_POST['monday']['open'];
						$service_days[0]['close_time'] = $_POST['monday']['close'];
						$service_days[0]['is_holiday'] = 'No';
						$service_days[0]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
					}

					if (isset($_POST['tuesday']['open'])) {
						$service_days[1]['user_service_id'] = $business_service_id;
						$service_days[1]['day'] = 'tuesday';
						$service_days[1]['open_time'] = $_POST['tuesday']['open'];
						$service_days[1]['close_time'] = $_POST['tuesday']['close'];
						$service_days[1]['is_holiday'] = 'No';
						$service_days[1]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
					}

					if (isset($_POST['wednesday']['open'])) {
						$service_days[2]['user_service_id'] = $business_service_id;
						$service_days[2]['day'] = 'wednesday';
						$service_days[2]['open_time'] = $_POST['wednesday']['open'];
						$service_days[2]['close_time'] = $_POST['wednesday']['close'];
						$service_days[2]['is_holiday'] = 'No';
						$service_days[2]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
					}

					if (isset($_POST['thrusday']['open'])) {
						$service_days[3]['user_service_id'] = $business_service_id;
						$service_days[3]['day'] = 'thrusday';
						$service_days[3]['open_time'] = $_POST['thrusday']['open'];
						$service_days[3]['close_time'] = $_POST['thrusday']['close'];
						$service_days[3]['is_holiday'] = 'No';
						$service_days[3]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
					}

					if (isset($_POST['friday']['open'])) {
						$service_days[4]['user_service_id'] = $business_service_id;
						$service_days[4]['day'] = 'friday';
						$service_days[4]['open_time'] = $_POST['friday']['open'];
						$service_days[4]['close_time'] = $_POST['friday']['close'];
						$service_days[4]['is_holiday'] = 'No';
						$service_days[4]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
					}

					if (isset($_POST['saturday']['open'])) {
						$service_days[5]['user_service_id'] = $business_service_id;
						$service_days[5]['day'] = 'saturday';
						$service_days[5]['open_time'] = $_POST['saturday']['open'];
						$service_days[5]['close_time'] = $_POST['saturday']['close'];
						$service_days[5]['is_holiday'] = 'No';
						$service_days[5]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
					}

					if (isset($_POST['sunday']['open'])) {
						$service_days[6]['user_service_id'] = $business_service_id;
						$service_days[6]['day'] = 'sunday';
						$service_days[6]['open_time'] = $_POST['sunday']['open'];
						$service_days[6]['close_time'] = $_POST['sunday']['close'];
						$service_days[6]['is_holiday'] = 'No';
						$service_days[6]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
					}

					if ($service_days && !empty($service_days)) {
						$this->home->insertBusinessServiceDays($service_days);
					}

					$service_types = $this->input->post('service_types');

					if ($service_types && !empty($service_types)) {

						foreach ($service_types as $key => $value) {
							$business_service_type[$key]['business_service_id'] = $business_service_id;
							$business_service_type[$key]['service_type_id'] = $key;
							$business_service_type[$key]['is_available'] = $value;
							$business_service_type[$key]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
						}

						if ($business_service_type && !empty($business_service_type)) {
							$this->home->insertBusinessServiceTypes($business_service_type);
						}
					}

					$success = true;
					$message = 'Your business service added successfully.';
					$data['redirectURL'] = base_url('dashboard');
				} else {
					$success = false;
					$message = 'Technical error, please try again.';
				}

			} else {
				$success = false;
				$message = validation_errors();
			}
			$data['message'] = $message;
			$data['success'] = $success;
			echo json_encode($data);die;   
		}

		$this->load->view('front/includes/header', $output);
		$this->load->view('front/dashboard/add_service');
		$this->load->view('front/includes/footer');
	}

	function update_profile_info()
	{
		if (isset($_POST) && !empty($_POST)) {
        	$this->form_validation->set_rules('first_name', 'First name', 'trim|required|callback_check_space');
			$this->form_validation->set_rules('last_name', 'Last name', 'trim|required|callback_check_space');
			// $this->form_validation->set_rules('gender', 'Gender', 'trim|required');
			$this->form_validation->set_rules('dob', 'Date of birth', 'trim|required');

			if ($this->form_validation->run()) {
				$updateData = array();
				$updateData['name'] = $this->input->post('first_name');
				$updateData['last_name'] = $this->input->post('last_name');
				// $updateData['gender'] = $this->input->post('gender');
				$updateData['dob'] = date('Y-m-d', strtotime($this->input->post('dob')));
				$updateData['update_date'] = $this->common_model->getDefaultToGMTDate(time());
				$update_respo = $this->users->update_record($updateData, $this->user_id);

				if ($update_respo) {
					$message = 'Personal data updated successfully.';
					$success = true;

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

	function update_address_info()
	{
		if (isset($_POST) && !empty($_POST)) {
        	$this->form_validation->set_rules('house_number', 'house number', 'trim|required|callback_check_space');
			$this->form_validation->set_rules('street', 'street', 'trim|required|callback_check_space');
			$this->form_validation->set_rules('town', 'town', 'trim|required');
			$this->form_validation->set_rules('country', 'country', 'trim|required');
			$this->form_validation->set_rules('postcode', 'postcode', 'trim|required');

			if ($this->form_validation->run()) {
				$updateData = array();
				$updateData['house_number'] = $this->input->post('house_number');
				$updateData['street'] = $this->input->post('street');
				$updateData['town'] = $this->input->post('town');
				$updateData['country'] = $this->input->post('country');
				$updateData['postcode'] = $this->input->post('postcode');
				$updateData['update_date'] = $this->common_model->getDefaultToGMTDate(time());
				$update_respo = $this->users->update_record($updateData, $this->user_id);

				if ($update_respo) {
					$message = 'Address data updated successfully.';
					$success = true;

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

	function update_password()
	{
		if (isset($_POST) && !empty($_POST)) {
        	$this->form_validation->set_rules('old_password', 'old password', 'trim|required');
			$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[6]|max_length[15]');
			$this->form_validation->set_rules('re_new_password', 'Confirmation Password', 'trim|required|matches[new_password]|min_length[6]|max_length[15]');

			if ($this->form_validation->run()) {
				$password = $this->input->post('old_password');
				$salt = 'Ijxo1A16';
				$ency_password = md5(md5($password).md5($salt));

				$user = $this->users->checkUserExistByOldPassword($ency_password, $this->user_id);

				if ($user) {
					$newPassword = $this->input->post('new_password');
					$salt = 'Ijxo1A16';
					$encyPassword = md5(md5($newPassword).md5($salt));

					$updateData = array();
					$updateData['password'] = $encyPassword;
					$updateData['update_date'] = $this->common_model->getDefaultToGMTDate(time());
					$update_respo = $this->users->update_record($updateData, $this->user_id);

					if ($update_respo) {
						$message = 'Password updated successfully.';
						$success = true;
						$data['resetForm'] = true;

					} else {
						$success = false;
						$message = 'Technical error, Please try again.';
					}

				} else {
					$message = 'Old Password Incorrect';
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

	function update_email_info()
	{
		if (isset($_POST) && !empty($_POST)) {
        	$this->form_validation->set_rules('email', 'Email address', 'trim|required|valid_email|callback_check_email_exist['.$this->user_id.']');

			if ($this->form_validation->run()) {
				$user_detail = $this->users->get_record_by_id($this->user_id);

				if ($user_detail->email == $this->input->post('email')) {
					$message = 'Email updated successfully.';
					$success = true;

				} else {
					$email_verified_key = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 30);

					$updateData = array();
					$updateData['user_id'] = $this->user_id;
					$updateData['email'] = $this->input->post('email');
					$updateData['email_verified_key'] = $email_verified_key;
					$check_already_request = $this->users->check_already_request($this->user_id);

					if ($check_already_request) {
						$updateData['update_date'] = $this->common_model->getDefaultToGMTDate(time());
						$update_respo = $this->users->update_user_email($updateData, $check_already_request->id);

					} else {
						$updateData['add_date'] = $this->common_model->getDefaultToGMTDate(time());
						$update_respo = $this->users->insert_user_email($updateData);
					}

					if ($update_respo) {
						//Send Email verification link
						$this->mailsending->sendEmailUpdateVerifiedLink($this->user_id, $email_verified_key, $this->input->post('email'));
						$message = 'We have sent you a verification mail, Please verify!';
						$success = true;
						$data['resetForm'] = true;

					} else {
						$success = false;
						$message = 'Technical error, Please try again.';
					}
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

	function update_profile_image()
	{
		if ($_FILES && isset($_FILES['profile_image'])) {
            $file_directory = './assets/uploads/profile_image/';
            @mkdir($file_directory, 0777); 
            @chmod($file_directory, 0777);

            $config['upload_path']  = $file_directory;
            $config['allowed_types'] = 'png|jpg|jpeg';
            $config['encrypt_name'] = TRUE;
           
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('profile_image')) {
                $image = $this->upload->data();
                $image_url = $file_directory.$image['file_name'];
                $directory_300 = $file_directory."/thumbs_300X300/";
                $this->common_model->resize_image1($directory_300,$image_url,300,300,$image['file_name']);    
                
                $image_name = $image['file_name'];

                $updateData = array();
				$updateData['profile_image'] = $image_name;
				$updateData['update_date'] = $this->common_model->getDefaultToGMTDate(time());
				$update_respo = $this->users->update_record($updateData, $this->user_id);

				if ($update_respo) {
					$this->session->set_userdata('profile_image', $image_name);
					$success = true;
                	$message = 'Profile image updated successfully.';
					$data['resetForm'] = true;
					$data['image_url'] = $this->config->item('uploads').'profile_image/'.$image_name;
					$data['callBackFunction'] = 'callbackProfileImageUploded';

				} else {
					$success = false;
					$message = 'Technical error, Please try again.';
				}

            } else {
                $success = false;
                $message = $this->upload->display_errors();
                $data['resetForm'] = true;
            }

        } else {
        	$success = false;
			$message = 'Please select an image.';
        }
        $data['message'] = $message;
		$data['success'] = $success;
		echo json_encode($data);die;
	}

	function load_business_detail()
	{
		$output = array();
		$success = true;
		$business_id = $this->input->post('business_id');

		$output['business_type'] = $this->business_types->getActiveRecords();
		$output['country'] = $this->address->getCountryRecords();
		$output['service_type'] = $this->users->getUserPlanServices($this->user_id);

		if (isset($business_id) && $business_id) {
			$business = $this->users->getBusinessRecordById($business_id);
			$output['business'] = $business;
			$data['state_id'] = $business->state_id;
			// $data['city_id'] = $business->city_id;
			$data['city_id'] = null;
			$data['business_id'] = $business_id;

		} else {
			$output['default_country'] = 230;
		}
		$html = $this->load->view('front/dashboard/ajax_business_detail', $output, true);

		$data['success'] = $success;
		$data['html'] = $html;
		echo json_encode($data);die;
	}

	function load_service_detail()
	{
		$output = array();
		$success = true;
		$first_request = false;
		$service_type_id = $this->input->post('service_type_id');
		$output['service_type_id'] = $service_type_id;
		//pr($output['service_type_id']);die;
		$output['service_type'] = $this->users->getUserPlanServices($this->user_id);

		$output['special_education'] = $this->special_education->getActiveRecords();
		$output['curricular_activities'] = $this->curricular_activities->getActiveRecords();

		if (isset($service_type_id) && $service_type_id) {
			$user_service_detail = $this->users->getServiceRecordById($this->user_id, $service_type_id);

			if ($user_service_detail) {
				$selected_own_education = $this->users->get_selected_own_education($user_service_detail->id);

			} else {
				$selected_own_education = array();
			}
			// if ($selected_own_education) {
			// 	$first_request = true;
			// }
			$service = $this->users->getServiceRecordById($this->user_id, $service_type_id);

			if ($service) {
				$selected_own_activity = $this->users->get_selected_own_activity($user_service_detail->id);

			} else {
				$selected_own_activity = array();
			}
			// if($selected_own_activity) {

			// }

			if ($service) {
				$output['service'] = $service;
				$selected_education = $this->users->get_selected_education($service->id);
				$selected_activity = $this->users->get_selected_activity($service->id);
				
			} else {
				$selected_education = array();
				$selected_own_education = array();
				$selected_activity = array();
				$selected_own_activity = array();
			}

		} else {
			$selected_education = array();
			$selected_own_education = array();
			$selected_activity = array();
			$selected_own_activity = array();
		}
		$output['selected_education'] = $selected_education;
		$output['selected_own_education'] = $selected_own_education;
		$output['selected_activity'] = $selected_activity;
		$output['selected_own_activity'] = $selected_own_activity;
		$html = $this->load->view('front/dashboard/ajax_service_detail', $output, true);
		// pr($html);die;
		$data['success'] = $success;
		$data['html'] = $html;
		echo json_encode($data);die;
	}

	function ajax_states()
    {
    	$country_id = $this->input->get('country_id');
    	$selected_state_id = $this->input->get('selected_state_id');

    	if ($selected_state_id) {
    		$output['state_id'] = $selected_state_id;

    	} else {
    		$output['state_id'] = null;
    	}
    	$output['state_list'] = $this->address->getStateRecordsByCountry($country_id);
    	$html = $this->load->view('front/dashboard/ajax_state_data', $output, true);
		$data['html'] = $html;
		$data['success'] = true;
		$data['message'] = true;
		echo json_encode($data);
    }

    function ajax_city()
    {
    	$state_id = $this->input->get('state_id');

    	if ($this->input->get('city_id')) {
    		$output['city_id'] = $this->input->get('city_id');

    	} else {
    		$output['city_id'] = null;
    	}
    	$output['city_list'] = $this->address->getCityRecordsByState($state_id);
    	$html = $this->load->view('front/dashboard/ajax_city_data', $output, true);
		$data['html'] = $html;
		$data['success'] = true;
		$data['message'] = true;
		echo json_encode($data);
    }

    function load_business_trading()
    {
    	$output['business_details'] = $this->users->getUserBusinesRecords($this->user_id);
    	$html = $this->load->view('front/dashboard/ajax_business_tradding', $output, true);
		$data['html'] = $html;
		$data['success'] = true;
		$data['message'] = true;
		echo json_encode($data);
    }

    function load_provision_services()
    {
    	$output['service_type'] = $this->users->getUserPlanServices($this->user_id);
    	$html = $this->load->view('front/dashboard/ajax_provision_services', $output, true);
		$data['html'] = $html;
		$data['success'] = true;
		$data['message'] = true;
		echo json_encode($data);
    }

    function update_business_details()
    {
		$this->form_validation->set_rules('business_id', 'Business', 'trim');
		$this->form_validation->set_rules('service_type_id', 'Service type', 'trim|required');
		$this->form_validation->set_rules('number_of_children', 'Number of children', 'trim|required|is_natural_no_zero');
    	$this->form_validation->set_rules('trading_name', 'Trading name', 'trim|required|callback_check_space');
		$this->form_validation->set_rules('business_registered_name', 'Business registered name', 'trim|callback_check_space');
		$this->form_validation->set_rules('business_type_id', 'Business Type', 'trim|required');
		$this->form_validation->set_rules('company_registration_number', 'Company registered number', 'trim|callback_check_space');
		$this->form_validation->set_rules('street_line_1', 'Street address', 'trim|required|callback_check_space');
		$this->form_validation->set_rules('street_line_2', 'Street address', 'trim|callback_check_space');
		$this->form_validation->set_rules('country_id', 'Country', 'trim|required');
		$this->form_validation->set_rules('state_id', 'State', 'trim|required');
		// $this->form_validation->set_rules('city_id', 'City', 'trim|required');
		$this->form_validation->set_rules('city_name', 'City Name', 'trim|required');
		$this->form_validation->set_rules('zipcode', 'zipcode', 'trim|required|callback_check_space');
		$this->form_validation->set_rules('customer_enquiry_number', 'Customer enquiry number', 'trim|required|integer|callback_check_space');
		$this->form_validation->set_rules('customer_enquiry_email', 'Customer enquiry email', 'trim|required|valid_email|callback_check_space');

		if ($this->form_validation->run()) {
			$country_data = $this->address->get_record_by_id($_POST['country_id']);
			$state_data = $this->address->get_record_by_state_id($_POST['state_id']);
			// $city_data = $this->address->get_record_by_city_id($_POST['city_id']);
			// $address = $_POST['street_line_1'].' '.$city_data->name.' '.$state_data->name.' '.$country_data->name.' '.$_POST['zipcode'];
			$address = $_POST['zipcode'];

			$url = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($address)."&key=AIzaSyCxhgcC9Un6YMIVL5agYr7ygNvQMt306Nc";
		    $result_string = file_get_contents($url);
			$result = json_decode($result_string, true);

			if ($result['status'] == 'ZERO_RESULTS') {
				$message = 'Please select a valid address.';
				$success = false;

			} else {
				$result1[]=$result['results'][0];
				$result2[]=$result1[0]['geometry'];
				$result3[]=$result2[0]['location'];

				$business_id = $this->input->post('business_id');
				$input = array();
				$input['trading_name'] = $this->input->post('trading_name');
				$input['number_of_children'] = $this->input->post('number_of_children');
				$input['business_type_id'] = $this->input->post('business_type_id');
				$input['service_type_id'] = $this->input->post('service_type_id');

				if ($_POST['business_registered_name']) {
					$input['business_registered_name'] = $this->input->post('business_registered_name');
				}

				if ($_POST['company_registration_number']) {
					$input['company_registration_number'] = $this->input->post('company_registration_number');
				}
				$input['street_line_1'] = $this->input->post('street_line_1');

				if (isset($_POST['street_line_2'])) {
					$input['street_line_2'] = $this->input->post('street_line_2');
				}
				// $input['city_id'] = $this->input->post('city_id');
				$input['city_name'] = $this->input->post('city_name');
				$input['state_id'] = $this->input->post('state_id');
				$input['country_id'] = $this->input->post('country_id');
				$input['zipcode'] = $this->input->post('zipcode');
				$input['latitude'] = $result3[0]['lat'];
				$input['longitude'] = $result3[0]['lng'];
				$input['customer_enquiry_number'] = $this->input->post('customer_enquiry_number');
				$input['customer_enquiry_email'] = $this->input->post('customer_enquiry_email');
				
				if ($business_id && !empty($business_id)) {
					$input['update_date'] = $this->common_model->getDefaultToGMTDate(time());
					$response = $this->users->update_business_record($input, $business_id);

					if ($response) {
						$message = 'Business info saved successfully.';
						$success = true;

					} else {
						$message = 'Technical error, please try again.';
						$success = false;
					}

				} else {
					$already_added_provision = $this->users->getBusinessByServiceId($this->user_id, $this->input->post('service_type_id'));
					$check_provision_allow = $this->users->getProvisionsByServiceId($this->user_id, $this->input->post('service_type_id'));

					if ($check_provision_allow->provisions > $already_added_provision) {
						$input['user_id'] = $this->user_id;
						$input['add_date'] = $this->common_model->getDefaultToGMTDate(time());
						$response = $this->users->insert_business_record($input);
						$output['callBackFunction'] = 'callbackBusinesTradind';

						if ($response) {
							$message = 'Business info saved successfully.';
							$success = true;

						} else {
							$message = 'Technical error, please try again.';
							$success = false;
						}

					} else {
						$message = 'Your can not add provision for this service type.';
						$success = false;
					}
				}
			}

		} else {
			$success = false;
			$message = validation_errors();
		}

		$output['message'] = $message;
		$output['success'] = $success;
		echo json_encode($output);die;
    }

    function update_service_details()
    {
    	$this->form_validation->set_rules('service_type_id', 'Service type', 'trim|required');
    	$this->form_validation->set_rules('add_own_education', 'add_own_education', 'trim');
		$this->form_validation->set_rules('add_own_activity', 'add_own_activity', 'trim');

		if (isset($_POST['add_own_education'])) {
			$this->form_validation->set_rules('special_education_own[]', 'Special education Own', 'trim|required|callback_check_space');
		} else {
			// $this->form_validation->set_rules('special_education_id[]', 'Special education', 'trim|required');
			$this->form_validation->set_rules('special_education_id[]', 'Special education', 'trim');
		}

		if (isset($_POST['add_own_activity'])) {
			$this->form_validation->set_rules('curricular_activity_own[]', 'Curricular activity Own', 'trim|required|callback_check_space');
		} else {
			// $this->form_validation->set_rules('curricular_activity_id[]', 'Curricular activity', 'trim|required');
			$this->form_validation->set_rules('curricular_activity_id[]', 'Curricular activity', 'trim');
		}
		
		$this->form_validation->set_rules('ofsted_registered', 'Ofsted registered', 'trim|required');

		if (isset($_POST['ofsted_registered']) && $_POST['ofsted_registered'] != 'No') {
			$this->form_validation->set_rules('ofsted_registration_number', 'Ofsted registration number', 'trim|required');
		}
		$this->form_validation->set_rules('ofsted_rating', 'Ofsted rating', 'trim');
		$this->form_validation->set_rules('childcare_voucher', 'Childcare voucher', 'trim');
		$this->form_validation->set_rules('tax_free', 'Tax Free', 'trim');
		$this->form_validation->set_rules('fifteen_funded_three_four_year', '15 funded hours for 3 and 4 years old', 'trim');
		$this->form_validation->set_rules('fifteen_funded_two_year', '15 funded hours for 2 years old', 'trim');
		$this->form_validation->set_rules('thirty_funded_three_four_year', '30 funded hours for 3 and 4 years old', 'trim');
		$this->form_validation->set_rules('holiday_club_services', 'Holiday club services', 'trim');
		$this->form_validation->set_rules('emergency_childcare', 'Emergency childcare', 'trim');
		$this->form_validation->set_rules('summer_terms_check', 'Summer Terms', 'trim');
		$this->form_validation->set_rules('spring_terms_check', 'Summer Terms', 'trim');

		if (isset($_POST['bank_holidays']) || isset($_POST['christmas_week']) || isset($_POST['open_all_year']) || isset($_POST['summer_terms_check']) || isset($_POST['spring_terms_check'])) {

		} else {
			$this->form_validation->set_rules('bank_holidays', 'business clossing time', 'trim|required');
		}

		if (isset($_POST['summer_terms_check'])) {
			$this->form_validation->set_rules('summer_terms', 'Summer Weeks', 'trim|required|integer');
			/*$this->form_validation->set_rules('week_summer', 'Select summer weeks', 'trim|required');

			if (isset($_POST['week_summer']) && $_POST['week_summer'] == '38') {
				$this->form_validation->set_rules('38_summer_terms', 'Summer Weeks', 'trim|required|integer');

			} else {
				$this->form_validation->set_rules('52_summer_terms', 'Summer Weeks', 'trim|required|integer');
			}*/
		}

		if (isset($_POST['spring_terms_check'])) {
			$this->form_validation->set_rules('spring_terms', 'Spring Weeks', 'trim|required|integer');
			/*$this->form_validation->set_rules('week_spring', 'Select spring weeks', 'trim|required');

			if (isset($_POST['week_spring']) && $_POST['week_spring'] == '38') {
				$this->form_validation->set_rules('38_spring_terms', 'Spring Weeks', 'trim|required|integer');

			} else {
				$this->form_validation->set_rules('52_spring_terms', 'Spring Weeks', 'trim|required|integer');
			}*/
		}

		if (isset($_POST['autumn_terms_check'])) {
			$this->form_validation->set_rules('autumn_terms', 'Autumn Weeks', 'trim|required|integer');
			/*$this->form_validation->set_rules('week_autumn', 'Select autumn weeks', 'trim|required');

			if (isset($_POST['week_autumn']) && $_POST['week_autumn'] == '38') {
				$this->form_validation->set_rules('38_autumn_terms', 'Autumn Weeks', 'trim|required|integer');

			} else {
				$this->form_validation->set_rules('52_autumn_terms', 'Autumn Weeks', 'trim|required|integer');
			}*/
		}

		if ($this->form_validation->run()) {
			// pr($_POST);die;
			$failure = false;
			$check_already_submitted_service = $this->users->getServiceRecordByRecordId($_POST['user_service_detail_id']);

			if ($_FILES && isset($_FILES['business_logo'])) {
                $file_directory = './assets/uploads/business_logo/';
                @mkdir($file_directory, 0777); 
                @chmod($file_directory, 0777);

                $config['upload_path']  = $file_directory;
                $config['allowed_types'] = 'png|jpg|jpeg';
                $config['encrypt_name'] = TRUE;
               
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('business_logo')) {
                    
                    $image = $this->upload->data();
                    $image_url = $file_directory.$image['file_name'];
                    $directory_300 = $file_directory."/thumbs_300X300/";
                    $this->common_model->resize_image1($directory_300,$image_url,300,300,$image['file_name']);    
                    
                    $business_logo = $image['file_name'];

                } else {
                    $success = false;
                    $failure = true;
                    $message = $this->upload->display_errors();
                }

            } else {
                $business_logo = ($check_already_submitted_service && $check_already_submitted_service->business_logo) ? $check_already_submitted_service->business_logo : NULL;
            }

            if ($_FILES && isset($_FILES['upload_image_one_file'])) {
                $file_directory = './assets/uploads/business_logo/';
                @mkdir($file_directory, 0777); 
                @chmod($file_directory, 0777);

                $config['upload_path']  = $file_directory;
                $config['allowed_types'] = 'png|jpg|jpeg';
                $config['encrypt_name'] = TRUE;
               
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('upload_image_one_file')) {
                    
                    $image = $this->upload->data();
                    $image_url = $file_directory.$image['file_name'];
                    $directory_300 = $file_directory."/thumbs_300X300/";
                    $this->common_model->resize_image1($directory_300,$image_url,300,300,$image['file_name']);    
                    
                    $upload_image_one_file = $image['file_name'];

                } else {
                    $success = false;
                    $failure = true;
                    $message = $this->upload->display_errors();
                }

            } else {

            	if ($_POST['deleted_business_image_one'] && $_POST['deleted_business_image_one'] == 'Yes') {
                	$upload_image_one_file = NULL;

            	} else {
                	$upload_image_one_file = ($check_already_submitted_service && $check_already_submitted_service->business_image_one) ? $check_already_submitted_service->business_image_one : NULL;
            	}
            }

            if ($_FILES && isset($_FILES['upload_image_two_file'])) {
                $file_directory = './assets/uploads/business_logo/';
                @mkdir($file_directory, 0777); 
                @chmod($file_directory, 0777);

                $config['upload_path']  = $file_directory;
                $config['allowed_types'] = 'png|jpg|jpeg';
                $config['encrypt_name'] = TRUE;
               
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('upload_image_two_file')) {
                    
                    $image = $this->upload->data();
                    $image_url = $file_directory.$image['file_name'];
                    $directory_300 = $file_directory."/thumbs_300X300/";
                    $this->common_model->resize_image1($directory_300,$image_url,300,300,$image['file_name']);    
                    
                    $upload_image_two_file = $image['file_name'];

                } else {
                    $success = false;
                    $failure = true;
                    $message = $this->upload->display_errors();
                }

            } else {

            	if ($_POST['deleted_business_image_two'] && $_POST['deleted_business_image_two'] == 'Yes') {
                	$upload_image_two_file = NULL;

            	} else {
                	$upload_image_two_file = ($check_already_submitted_service && $check_already_submitted_service->business_image_two) ? $check_already_submitted_service->business_image_two : NULL;
                }
            }

            if ($_FILES && isset($_FILES['upload_image_three_file'])) {
                $file_directory = './assets/uploads/business_logo/';
                @mkdir($file_directory, 0777); 
                @chmod($file_directory, 0777);

                $config['upload_path']  = $file_directory;
                $config['allowed_types'] = 'png|jpg|jpeg';
                $config['encrypt_name'] = TRUE;
               
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('upload_image_three_file')) {
                    
                    $image = $this->upload->data();
                    $image_url = $file_directory.$image['file_name'];
                    $directory_300 = $file_directory."/thumbs_300X300/";
                    $this->common_model->resize_image1($directory_300,$image_url,300,300,$image['file_name']);    
                    
                    $upload_image_three_file = $image['file_name'];

                } else {
                    $success = false;
                    $failure = true;
                    $message = $this->upload->display_errors();
                }

            } else {

            	if ($_POST['deleted_business_image_three'] && $_POST['deleted_business_image_three'] == 'Yes') {
                	$upload_image_three_file = NULL;

            	} else {
                	$upload_image_three_file = ($check_already_submitted_service && $check_already_submitted_service->business_image_three) ? $check_already_submitted_service->business_image_three : NULL;
                }
            }

            if ($_FILES && isset($_FILES['upload_image_four_file'])) {
                $file_directory = './assets/uploads/business_logo/';
                @mkdir($file_directory, 0777); 
                @chmod($file_directory, 0777);

                $config['upload_path']  = $file_directory;
                $config['allowed_types'] = 'png|jpg|jpeg';
                $config['encrypt_name'] = TRUE;
               
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('upload_image_four_file')) {
                    
                    $image = $this->upload->data();
                    $image_url = $file_directory.$image['file_name'];
                    $directory_300 = $file_directory."/thumbs_300X300/";
                    $this->common_model->resize_image1($directory_300,$image_url,300,300,$image['file_name']);    
                    
                    $upload_image_four_file = $image['file_name'];

                } else {
                    $success = false;
                    $failure = true;
                    $message = $this->upload->display_errors();
                }

            } else {

            	if ($_POST['deleted_business_image_four'] && $_POST['deleted_business_image_four'] == 'Yes') {
                	$upload_image_four_file = NULL;

            	} else {
                	$upload_image_four_file = ($check_already_submitted_service && $check_already_submitted_service->business_image_four) ? $check_already_submitted_service->business_image_four : NULL;
                }
            }

            if ($_FILES && isset($_FILES['upload_image_five_file'])) {
                $file_directory = './assets/uploads/business_logo/';
                @mkdir($file_directory, 0777); 
                @chmod($file_directory, 0777);

                $config['upload_path']  = $file_directory;
                $config['allowed_types'] = 'png|jpg|jpeg';
                $config['encrypt_name'] = TRUE;
               
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('upload_image_five_file')) {
                    
                    $image = $this->upload->data();
                    $image_url = $file_directory.$image['file_name'];
                    $directory_300 = $file_directory."/thumbs_300X300/";
                    $this->common_model->resize_image1($directory_300,$image_url,300,300,$image['file_name']);    
                    
                    $upload_image_five_file = $image['file_name'];

                } else {
                    $success = false;
                    $failure = true;
                    $message = $this->upload->display_errors();
                }

            } else {

            	if ($_POST['deleted_business_image_five'] && $_POST['deleted_business_image_five'] == 'Yes') {
                	$upload_image_five_file = NULL;

            	} else {
                	$upload_image_five_file = ($check_already_submitted_service && $check_already_submitted_service->business_image_five) ? $check_already_submitted_service->business_image_five : NULL;
                }
            }

            if (!$failure) {
				$input = array();
				$input['user_id'] = $this->user_id;
				$input['service_type_id'] = $this->input->post('service_type_id');
				$input['ofsted_registered'] = $this->input->post('ofsted_registered');

				if ($_POST['ofsted_registered'] && $_POST['ofsted_registered'] != 'No') {
					$input['ofsted_registration_number'] = $this->input->post('ofsted_registration_number');
				}

				if (isset($_POST['ofsted_rating'])) {
					$input['ofsted_rating'] = $this->input->post('ofsted_rating');
				}

				if (isset($_POST['childcare_voucher'])) {
					$input['childcare_voucher'] = $this->input->post('childcare_voucher');
				}

				if (isset($_POST['holiday_club_services'])) {
					$input['holiday_club_services'] = $this->input->post('holiday_club_services');
				}

				if (isset($_POST['emergency_childcare'])) {
					$input['emergency_childcare'] = $this->input->post('emergency_childcare');
				}

				if (isset($_POST['tax_free'])) {
					$input['tax_free'] = 'Yes';
				}

				if (isset($_POST['fifteen_funded_three_four_year'])) {
					$input['fifteen_funded_three_four_year'] = 'Yes';
				}

				if (isset($_POST['fifteen_funded_two_year'])) {
					$input['fifteen_funded_two_year'] = 'Yes';
				}

				if (isset($_POST['thirty_funded_three_four_year'])) {
					$input['thirty_funded_three_four_year'] = 'Yes';
				}

				if (isset($_POST['bank_holidays'])) {
					$input['bank_holidays'] = 'Yes';
				}

				if (isset($_POST['christmas_week'])) {
					$input['christmas_week'] = 'Yes';
				}

				if (isset($_POST['open_all_year'])) {
					$input['open_all_year'] = 'Yes';
				}

				$input['summer_terms'] = $this->input->post('summer_terms');
				$input['spring_terms'] = $this->input->post('spring_terms');
				$input['autumn_terms'] = $this->input->post('autumn_terms');

				/*if (isset($_POST['summer_terms_check'])) {
					$input['week_summer'] = $this->input->post('week_summer');

					if (isset($_POST['week_summer']) && $_POST['week_summer'] == '38') {
						$input['summer_terms'] = $this->input->post('38_summer_terms');

					} else {
						$input['summer_terms'] = $this->input->post('52_summer_terms');
					}
				}

				if (isset($_POST['spring_terms_check'])) {
					$input['week_spring'] = $this->input->post('week_spring');

					if (isset($_POST['week_spring']) && $_POST['week_spring'] == '38') {
						$input['spring_terms'] = $this->input->post('38_spring_terms');

					} else {
						$input['spring_terms'] = $this->input->post('52_spring_terms');
					}
				}

				if (isset($_POST['autumn_terms_check'])) {
					$input['week_autumn'] = $this->input->post('week_autumn');

					if (isset($_POST['week_autumn']) && $_POST['week_autumn'] == '38') {
						$input['autumn_terms'] = $this->input->post('38_autumn_terms');

					} else {
						$input['autumn_terms'] = $this->input->post('52_autumn_terms');
					}
				}*/

				$input['business_logo'] = $business_logo;
				$input['business_image_one'] = $upload_image_one_file;
				$input['business_image_two'] = $upload_image_two_file;
				$input['business_image_three'] = $upload_image_three_file;
				$input['business_image_four'] = $upload_image_four_file;
				$input['business_image_five'] = $upload_image_five_file;

				if ($_POST['user_service_detail_id'] && !empty($_POST['user_service_detail_id'])) {
					$input['update_date'] = $this->common_model->getDefaultToGMTDate(time());
					$service_id = $this->users->update_service_record($input, $_POST['user_service_detail_id']);

				} else {
					$input['add_date'] = $this->common_model->getDefaultToGMTDate(time());
					$service_id = $this->users->insert_service_record($input);
				}
				
				if ($service_id) {

					if ($_POST['user_service_detail_id'] && !empty($_POST['user_service_detail_id'])) {
						$this->users->delete_selected_education($_POST['user_service_detail_id']);
						$this->users->delete_selected_activity($_POST['user_service_detail_id']);
						$this->users->delete_selected_own_education($_POST['user_service_detail_id']);
						$this->users->delete_selected_own_activity($_POST['user_service_detail_id']);
						$message = 'Service updated successfully.';

					} else {
						$message = 'Service added successfully.';
					}

					$special_education_id = $this->input->post('special_education_id');
					$curricular_activity_id = $this->input->post('curricular_activity_id');
					$special_education_own = $this->input->post('special_education_own');
					$curricular_activity_own = $this->input->post('curricular_activity_own');

					$special_education = array();
					$curricular_activity = array();
					$service_type = array();
					$education_own = array();
					$activity_own = array();

					if ($special_education_id && !empty($special_education_id)) {

						foreach ($special_education_id as $key => $value) {
							$special_education[$key]['user_service_detail_id'] = $service_id;
							$special_education[$key]['special_education_id'] = $value;
							$special_education[$key]['add_date'] = $this->common_model->getDefaultToGMTDate(time());	
						}

						if ($special_education) {
							$this->users->insert_special_education_record($special_education);
						}
					}

					if (isset($_POST['add_own_education'])) {

						if ($special_education_own && !empty($special_education_own)) {

							foreach ($special_education_own as $key => $value) {
								$education_own[$key]['user_service_detail_id'] = $service_id;
								$education_own[$key]['education_name'] = $value;
								$education_own[$key]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
							}

							if ($education_own) {
								$this->users->insert_own_education_record($education_own);
							}
						}
					}

					if ($curricular_activity_id && !empty($curricular_activity_id)) {

						foreach ($curricular_activity_id as $key => $value) {
							$curricular_activity[$key]['user_service_detail_id'] = $service_id;
							$curricular_activity[$key]['curricular_activity_id'] = $value;
							$curricular_activity[$key]['add_date'] = $this->common_model->getDefaultToGMTDate(time());	
						}

						if ($curricular_activity) {
							$this->users->insert_curricular_activity_record($curricular_activity);
						}
					}

					if (isset($_POST['add_own_activity'])) {

						if ($curricular_activity_own && !empty($curricular_activity_own)) {

							foreach ($curricular_activity_own as $key => $value) {
								$activity_own[$key]['user_service_detail_id'] = $service_id;
								$activity_own[$key]['activity_name'] = $value;
								$activity_own[$key]['add_date'] = $this->common_model->getDefaultToGMTDate(time());	
							}

							if ($activity_own) {
								$this->users->insert_own_activity_record($activity_own);
							}
						}
					}

					$success = true;
					$output['callBackFunction'] = 'callbackServiceListing';

				} else {
					$message = 'Technical error, please try again.';
					$success = false;
				}

			} else {
                $success = false;
                $message = $response['message'];
            }

		} else {
			$success = false;
			$message = validation_errors();
		}
		$output['message'] = $message;
		$output['success'] = $success;
		echo json_encode($output);die;
    }

    function delete_provision()
    {
    	$business_id = $this->input->post('business_id');
    	$checkUserHaveBusiness = $this->users->getUserBusinesRecordByUserId($this->user_id, $business_id);

    	if ($checkUserHaveBusiness) {
	    	$this->users->deleteUserBusinessRoomAvailability_byBusinessId($business_id);//delete user business rooms availability
			$this->users->deleteUserBusinessTiming_byBusinessId($business_id);//delete user business timming
			$this->users->deleteUserBusinessRooms_byBusinessId($business_id);//delete user business rooms
			$this->users->deleteUserBusinessMonthlyFees_byBusinessId($business_id);//delete user business monthly fees
			$this->users->deleteUserBusinessSessions_byBusinessId($business_id);//delete user business sessions
			$this->users->deleteUserBusinessSessionsDays_byBusinessId($business_id);//delete user business sessions
			$this->users->deleteUserBusinessAgeGroup_byBusinessId($business_id);//delete user business age group
			$this->users->deleteUserSaveQuotes_byBusinessId($business_id);//delete user Save Quotes
			$this->users->delete_business_detail($business_id);

			$data['success'] = true;
			$data['message'] = 'Provision deleted successfully.';
			$data['callBackFunction'] = 'callbackDeleteProvision';

    	} else {
    		$data['success'] = false;
			$data['message'] = 'Invalid Request.';
    	}
		echo json_encode($data); die;
    }

    function append_own_edu()
    {
		$output['key'] = $this->input->post('key');
	    $html = $this->load->view('front/dashboard/append_special_edu', $output, true);
	    $success = true;
	    $data['html'] = $html;
	    $data['success'] = $success;
    	echo json_encode($data); die;
	}

	function append_own_activity()
    {
		$output['key'] = $this->input->post('key');
	    $html = $this->load->view('front/dashboard/append_own_activity', $output, true);
	    $success = true;
	    $data['html'] = $html;
	    $data['success'] = $success;
    	echo json_encode($data); die;
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

    function check_email_exist($value, $id = '')
    {
        if($this->users->doesEmailExist( $value, $id )) {
            $this->form_validation->set_message('check_email_exist', 'This E-Mail address already register on our server.');
            return false;
        }
        return true;
    }
}