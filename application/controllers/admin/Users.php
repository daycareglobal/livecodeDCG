<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {
	
	function __construct() {
		Parent::__construct();
		$this->common_model->checkAdminLogin();
		$this->load->model('admin/user_model', 'user');
		$this->load->model('admin/business_types_model', 'business_types');
		$this->load->model('admin/address_model', 'address');
		$this->load->model('admin/special_education_model', 'special_education');
		$this->load->model('admin/curricular_activities_model', 'curricular_activities');
		$this->load->model('admin/service_category_model', 'service_category');
		$this->load->model('common_model');
		$this->load->library('image_lib');
	}

	function index()
	{   
		$output['page_title'] = 'User Management';
		$output['left_menu'] = 'user_module';
		$output['left_submenu'] = 'user_list';
		$users = $this->user->getRecords('User');

		foreach ($users as $key => $value) {
        	$value->add_date = $this->common_model->getGMTDateToLocalDate($value->add_date);
		}
        
        $output['users'] = $users;
		$this->load->view('admin/includes/header',$output);
		$this->load->view('admin/users/index');
		$this->load->view('admin/includes/footer');
	}

	function changeStatus() {

		$id = $this->input->get('id');
		$status = $this->input->get('status');
		$this->user->changeStatusById($id,$status);
		$data['success'] = true;
		$data['message'] = 'Record updated Successfully';
		echo json_encode($data);
	} 

	function multiTaskOperation()
	{
		$task = $this->input->post('task');
		$ids = $this->input->post('ids');
		$dataIds = explode(',',$ids);
		foreach ($dataIds as $key => $value) 
		{
			if($task=='Active' || $task=='Inactive')
			{
				$this->user->changeStatusById($value,$task);			
				$message = 'Status of Selected records changed successfully.';
			}	
			if($task == 'Delete')
			{			
				$this->user->delete($value);
				$message = 'Selected Record Delete Successfully.';
			}
		}		
		$data['ids'] = $ids;
		$data['success'] = true;
		$data['message'] = $message;
		$data['callBackFunction'] = 'callBackCommonDelete';
		echo json_encode($data); die;
	}

	function add()
	{
		$output['page_title'] = 'User Management';
		$output['left_menu'] = 'user_module';
		$output['left_submenu'] = 'user_list';
		$output['task'] = 'add';
		$output['message'] = '';
		$output['status'] = 'Active';
		$output['id'] = '';
		$output['name'] = '';
		$output['last_name'] = '';
		$output['gender'] = '';
		$output['dob'] = '';
		$output['email'] = '';
		//$output['contact_number'] = '';
		$failure = false;
        $message = '';

        if (isset($_POST) && !empty($_POST)) {
			$success = true;
			$this->form_validation->set_rules('name', 'First name', 'trim|required|callback_check_space');
			$this->form_validation->set_rules('last_name', 'Last name', 'trim|required|callback_check_space');
			$this->form_validation->set_rules('gender', 'Gender', 'trim|required');
			$this->form_validation->set_rules('dob', 'Date of birth', 'trim|required');
			$this->form_validation->set_rules('email', 'Email address', 'trim|required|valid_email|is_unique[tbl_users.email]');
			//$this->form_validation->set_rules('contact_number', 'Contact number', 'trim|required|is_unique[tbl_users.contact_number]');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[15]');
			$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|min_length[6]|max_length[15]|matches[password]');
			
			if ($this->form_validation->run()) {

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

                    } else {
                        $success = false;
                        $failure = true;
                        $message = $this->upload->display_errors();
                    }

                } else {
                    $image_name = '';
                }

                if (!$failure) {
					$password = $this->input->post('password');
					$salt = 'Ijxo1A16';
					$ency_password = md5(md5($password).md5($salt));

					$input = array();
					$input['name'] = $this->input->post('name');
					$input['last_name'] = $this->input->post('last_name');
					$input['gender'] = $this->input->post('gender');
					$input['dob'] = $this->input->post('dob');
					$input['email'] = $this->input->post('email');
					$input['user_type'] = 'User';
					//$input['contact_number'] = $this->input->post('contact_number');
					$input['profile_image'] = $image_name;
					$input['password'] = $ency_password;
					$input['add_date'] = $this->common_model->getDefaultToGMTDate(time());
					$user_id = $this->user->insert_record($input);
					
					if ($user_id) {
						$message = 'Record added successfully.';
						$success = true;
						$output['redirectURL'] = site_url('admin/users');
					}

				} else {
                    $success = false;
                    $message = $message;
                }
			
			} else {
				$success = false;
				$message = validation_errors();
			}
			$output['message'] = $message;
			$output['success'] = $success;
			echo json_encode($output);die;
		}
		$this->load->view('admin/includes/header',$output);
		$this->load->view('admin/users/form');
		$this->load->view('admin/includes/footer');
	}

	
	function update($id)
	{
		$record = $this->user->get_record_by_id($id);
		
		if (empty($record)) {
			echo "<center><h1>No record found.</h1></center>";die;
		}
		
		$output['page_title'] = 'User Management';
		$output['left_menu'] = 'user_module';
		$output['left_submenu'] = 'user_list';
		$output['task'] = 'edit';
		$output['message'] = '';
		$output['status'] = '';
		$output['id'] = $record->id;
		$output['name'] = $record->name;
		$output['last_name'] = $record->last_name;
		$output['gender'] = $record->gender;
		$output['dob'] = $record->dob;
		$output['email'] = $record->email;
		//$output['contact_number'] = $record->contact_number;
		$output['profile_image'] = $record->profile_image;
		$failure = false;
        $message = '';
		

        if (isset($_POST) && !empty($_POST)) {
			$success = true;
			$this->form_validation->set_rules('name', 'First name', 'trim|required|callback_check_space');
			$this->form_validation->set_rules('last_name', 'Last name', 'trim|required|callback_check_space');
			$this->form_validation->set_rules('gender', 'Gender', 'trim|required');
			$this->form_validation->set_rules('dob', 'Date of birth', 'trim|required');
			$this->form_validation->set_rules('email', 'Email address', 'trim|required|valid_email|callback_check_email_exist['.$id.']');
			//$this->form_validation->set_rules('contact_number', 'Contact number', 'trim|required|callback_check_number_exist['.$id.']');			

			if ($_POST['password']) {
				$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[15]');
				$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|min_length[6]|max_length[15]|matches[password]');
			}
			
			if ($this->form_validation->run()) {

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

                    } else {
                        $success = false;
                        $failure = true;
                        $message = $this->upload->display_errors();
                    }

                } else {
                    $image_name = $record->profile_image;
                }

                if (!$failure) {
				
					$password = $this->input->post('password');
					$salt = 'Ijxo1A16';
					$ency_password = md5(md5($password).md5($salt));

					$input = array();
					$input['name'] = $this->input->post('name');
					$input['last_name'] = $this->input->post('last_name');
					$input['gender'] = $this->input->post('gender');
					$input['dob'] = $this->input->post('dob');
					$input['email'] = $this->input->post('email');
					//$input['contact_number'] = $this->input->post('contact_number');
					$input['profile_image'] = $image_name;

					if ($_POST['password']) {
						$input['password'] = $ency_password;
					}
					$input['update_date'] = $this->common_model->getDefaultToGMTDate(time());
					$response = $this->user->update_record($input, $id);
					
					if ($response) {
						$message = 'Record updated successfully.';
						$success = true;
						$output['redirectURL'] = site_url('admin/users');
					
					} else {
						$message = 'Technical error, Please try again.';
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
		$this->load->view('admin/includes/header',$output);
		$this->load->view('admin/users/form');
		$this->load->view('admin/includes/footer');
	}
	
	function delete()
	{   
		$id = $this->input->post('record_id');
		$this->user->delete($id);
		$data['success'] = true;
		$data['message'] = 'Record deleted successfully.';
		$data['callBackFunction'] = 'callBackCommonDelete';
		echo json_encode($data); die;
	}

	function profile_detail($id)
	{
		$record	= $this->user->get_record_by_id($id);

        if (!$record) {
        	echo "<center><h1>No record found.</h1></center>";die;
        }

        $output = array();
		$output['page_title'] = 'Business Management';
		$output['left_menu'] = 'user_module';
		$output['left_submenu'] = 'user_list';
		$output['id'] = $id;
		$business_details = $this->user->getBusinessRecords($id);

		foreach ($business_details as $key => $value) {
        	$value->add_date = $this->common_model->getGMTDateToLocalDate($value->add_date);
		}
        $output['records'] = $business_details;

        $this->load->view('admin/includes/header',$output);
		$this->load->view('admin/users/business_detail');
		$this->load->view('admin/includes/footer');
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
    	$html = $this->load->view('admin/users/ajax_state_data', $output, true);
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
    	$html = $this->load->view('admin/users/ajax_city_data', $output, true);
		$data['html'] = $html;
		$data['success'] = true;
		$data['message'] = true;
		echo json_encode($data);
    }

	function add_business($id)
	{
		$record	= $this->user->get_record_by_id($id);

        if (!$record) {
        	echo "<center><h1>No record found.</h1></center>";die;
        }
		$output['page_title'] = 'User Management';
		$output['left_menu'] = 'user_module';
		$output['left_submenu'] = 'user_list';
		$output['task'] = 'add';
		$output['message'] = '';
		$output['status'] = 'Active';
		$output['user_id'] = $id;
		$output['id'] = '';
		$output['trading_name'] = '';
		$output['number_of_children'] = '';
		$output['business_type_id'] = '';
		$output['business_registered_name'] = '';
		$output['company_registration_number'] = '';
		$output['street_line_1'] = '';
		$output['street_line_2'] = '';
		$output['city_id'] = '';
		$output['state_id'] = '';
		$output['country_id'] = '';
		$output['zipcode'] = '';
		$output['customer_enquiry_number'] = '';
		$output['customer_enquiry_email'] = '';
		$output['special_education_own'] = '';
		$output['curricular_activity_own'] = '';
		// $output['special_education_id'] = '';
		// $output['curricular_activity_id'] = '';
		$output['ofsted_registered'] = '';
		$output['ofsted_registration_number'] = '';
		$output['ofsted_rating'] = '';
		$output['holiday_club_services'] = '';
		$output['emergency_childcare'] = '';
		$output['childcare_voucher'] = '';
		$output['tax_free'] = '';
		$output['fifteen_funded_three_four_year'] = '';
		$output['fifteen_funded_two_year'] = '';
		$output['thirty_funded_three_four_year'] = '';
		$output['bank_holidays'] = '';
		$output['christmas_week'] = '';
		$output['open_all_year'] = '';
		$output['summer_terms'] = '';
		$output['spring_terms'] = '';
		$output['autumn_terms'] = '';
		$output['week_summer'] = '';
		$output['week_spring'] = '';
		$output['week_autumn'] = '';
		$output['business_type'] = $this->business_types->getActiveRecords();
		$output['country'] = $this->address->getCountryRecords();
		$output['special_education'] = $this->special_education->getActiveRecords();
		$output['curricular_activities'] = $this->curricular_activities->getActiveRecords();
		$output['service_type'] = $this->service_category->getActiveRecords();
		$output['selected_education'] = '';
		$output['selected_activity'] = '';
		$output['selected_service_type'] = '';
		$output['business_logo'] = '';
		// $output['business_image_one'] = '';
		// $output['business_image_two'] = '';
		// $output['business_image_three'] = '';
		// $output['business_image_four'] = '';
		// $output['business_image_five'] = '';
		$failure = false;
        $message = '';

        if (isset($_POST) && !empty($_POST)) {
        	// pr($_POST);die;
			$success = true;
			// $this->form_validation->set_rules('user_id', 'User', 'trim|required');
			$this->form_validation->set_rules('trading_name', 'Trading name', 'trim|required|callback_check_space');
			$this->form_validation->set_rules('number_of_children', 'Number of children', 'trim|required|integer');
			$this->form_validation->set_rules('business_type_id', 'Business Type', 'trim|required');
			$this->form_validation->set_rules('business_registered_name', 'Business registered name', 'trim|callback_check_space');
			$this->form_validation->set_rules('company_registration_number', 'Company registered number', 'trim|required|callback_check_space');
			$this->form_validation->set_rules('street_line_1', 'Street address', 'trim|required|callback_check_space');
			$this->form_validation->set_rules('street_line_2', 'Street address', 'trim|callback_check_space');
			$this->form_validation->set_rules('country_id', 'Country', 'trim|required');
			$this->form_validation->set_rules('state_id', 'State', 'trim|required');
			$this->form_validation->set_rules('city_id', 'City', 'trim|required');
			$this->form_validation->set_rules('zipcode', 'zipcode', 'trim|required|callback_check_space');
			$this->form_validation->set_rules('customer_enquiry_number', 'Customer enquiry number', 'trim|required|integer|callback_check_space');
			$this->form_validation->set_rules('customer_enquiry_email', 'Customer enquiry email', 'trim|required|valid_email|callback_check_space');
			$this->form_validation->set_rules('service_type_id[]', 'Service type', 'trim|required');
			$this->form_validation->set_rules('add_own_education', 'add_own_education', 'trim');
			$this->form_validation->set_rules('add_own_activity', 'add_own_activity', 'trim');

			if (isset($_POST['add_own_education'])) {
				$this->form_validation->set_rules('special_education_own[]', 'Special education Own', 'trim|required|callback_check_space');
			} else {
				$this->form_validation->set_rules('special_education_id[]', 'Special education', 'trim|required');
			}

			if (isset($_POST['add_own_activity'])) {
				$this->form_validation->set_rules('curricular_activity_own[]', 'Curricular activity Own', 'trim|required|callback_check_space');
			} else {
				$this->form_validation->set_rules('curricular_activity_id[]', 'Curricular activity', 'trim|required');
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
				$this->form_validation->set_rules('week_summer', 'Select summer weeks', 'trim|required');

				if (isset($_POST['week_summer']) && $_POST['week_summer'] == '38') {
					$this->form_validation->set_rules('38_summer_terms', 'Summer Weeks', 'trim|required|integer');

				} else {
					$this->form_validation->set_rules('52_summer_terms', 'Summer Weeks', 'trim|required|integer');
				}
			}

			if (isset($_POST['spring_terms_check'])) {
				$this->form_validation->set_rules('week_spring', 'Select spring weeks', 'trim|required');

				if (isset($_POST['week_spring']) && $_POST['week_spring'] == '38') {
					$this->form_validation->set_rules('38_spring_terms', 'Spring Weeks', 'trim|required|integer');

				} else {
					$this->form_validation->set_rules('52_spring_terms', 'Spring Weeks', 'trim|required|integer');
				}
			}

			if (isset($_POST['autumn_terms_check'])) {
				$this->form_validation->set_rules('week_autumn', 'Select autumn weeks', 'trim|required');

				if (isset($_POST['week_autumn']) && $_POST['week_autumn'] == '38') {
					$this->form_validation->set_rules('38_autumn_terms', 'Autumn Weeks', 'trim|required|integer');

				} else {
					$this->form_validation->set_rules('52_autumn_terms', 'Autumn Weeks', 'trim|required|integer');
				}
			}

			if ($this->form_validation->run()) {
				// pr($_POST);die;

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
                    $business_logo = NULL;
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
                    $upload_image_one_file = NULL;
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
                    $upload_image_two_file = NULL;
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
                    $upload_image_three_file = NULL;
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
                    $upload_image_four_file = NULL;
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
                    $upload_image_five_file = NULL;
                }

                if (!$failure) {
					$input = array();
					$input['user_id'] = $id;
					$input['trading_name'] = $this->input->post('trading_name');
					$input['number_of_children'] = $this->input->post('number_of_children');
					$input['business_type_id'] = $this->input->post('business_type_id');

					if ($_POST['business_registered_name']) {
						$input['business_registered_name'] = $this->input->post('business_registered_name');
					}

					$input['company_registration_number'] = $this->input->post('company_registration_number');
					$input['street_line_1'] = $this->input->post('street_line_1');

					if (isset($_POST['street_line_2'])) {
						$input['street_line_2'] = $this->input->post('street_line_2');
					}
					$input['city_id'] = $this->input->post('city_id');
					$input['state_id'] = $this->input->post('state_id');
					$input['country_id'] = $this->input->post('country_id');
					$input['zipcode'] = $this->input->post('zipcode');
					$input['customer_enquiry_number'] = $this->input->post('customer_enquiry_number');
					$input['customer_enquiry_email'] = $this->input->post('customer_enquiry_email');

					// if (isset($_POST['add_own_education'])) {
					// 	$input['special_education_own'] = $this->input->post('special_education_own');
						
					// } else {
					// 	$input['special_education_own'] = NULL;
					// }
					
					// if (isset($_POST['add_own_activity'])) {
					// 	$input['curricular_activity_own'] = $this->input->post('curricular_activity_own');
						
					// } else {
					// 	$input['curricular_activity_own'] = NULL;
					// }

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

					if (isset($_POST['summer_terms_check'])) {
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
					}

					$input['business_logo'] = $business_logo;
					$input['business_image_one'] = $upload_image_one_file;
					$input['business_image_two'] = $upload_image_two_file;
					$input['business_image_three'] = $upload_image_three_file;
					$input['business_image_four'] = $upload_image_four_file;
					$input['business_image_five'] = $upload_image_five_file;
					$input['add_date'] = $this->common_model->getDefaultToGMTDate(time());
					$business_id = $this->user->insert_business_record($input);
					
					if ($business_id) {
						$special_education_id = $this->input->post('special_education_id');
						$curricular_activity_id = $this->input->post('curricular_activity_id');
						$service_type_id = $this->input->post('service_type_id');
						$special_education_own = $this->input->post('special_education_own');
						$curricular_activity_own = $this->input->post('curricular_activity_own');

						$special_education = array();
						$curricular_activity = array();
						$service_type = array();
						$education_own = array();
						$activity_own = array();

						if ($special_education_id && !empty($special_education_id)) {

							foreach ($special_education_id as $key => $value) {
								$special_education[$key]['user_business_detail_id'] = $business_id;
								$special_education[$key]['special_education_id'] = $value;
								$special_education[$key]['add_date'] = $this->common_model->getDefaultToGMTDate(time());	
							}

							if ($special_education) {
								$this->user->insert_special_education_record($special_education);
							}
						}

						if ($special_education_own && !empty($special_education_own)) {

							foreach ($special_education_own as $key => $value) {
								$education_own[$key]['user_business_detail_id'] = $business_id;
								$education_own[$key]['education_name'] = $value;
								$education_own[$key]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
							}

							if ($education_own) {
								$this->user->insert_own_education_record($education_own);
							}
						}


						if ($curricular_activity_id && !empty($curricular_activity_id)) {

							foreach ($curricular_activity_id as $key => $value) {
								$curricular_activity[$key]['user_business_detail_id'] = $business_id;
								$curricular_activity[$key]['curricular_activity_id'] = $value;
								$curricular_activity[$key]['add_date'] = $this->common_model->getDefaultToGMTDate(time());	
							}

							if ($curricular_activity) {
								$this->user->insert_curricular_activity_record($curricular_activity);
							}
						}

						if ($curricular_activity_own && !empty($curricular_activity_own)) {

							foreach ($curricular_activity_own as $key => $value) {
								$activity_own[$key]['user_business_detail_id'] = $business_id;
								$activity_own[$key]['activity_name'] = $value;
								$activity_own[$key]['add_date'] = $this->common_model->getDefaultToGMTDate(time());	
							}

							if ($activity_own) {
								$this->user->insert_own_activity_record($activity_own);
							}
						}

						if ($service_type_id && !empty($service_type_id)) {

							foreach ($service_type_id as $key => $value) {
								$service_type[$key]['user_business_detail_id'] = $business_id;
								$service_type[$key]['service_type_id'] = $value;
								$service_type[$key]['add_date'] = $this->common_model->getDefaultToGMTDate(time());	
							}

							if ($service_type) {
								$this->user->insert_service_type_record($service_type);
							}
						}
						$message = 'Record added successfully.';
						$success = true;
						$output['redirectURL'] = site_url('admin/users/profile_detail/'.$id);

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
		$this->load->view('admin/includes/header', $output);
		$this->load->view('admin/users/business_form');
		$this->load->view('admin/includes/footer');
	}

	function update_business($id)
	{
		$record	= $this->user->getBusinessRecordById($id);

        if (!$record) {
        	echo "<center><h1>No record found.</h1></center>";die;
        }
		$output['page_title'] = 'User Management';
		$output['left_menu'] = 'user_module';
		$output['left_submenu'] = 'user_list';
		$output['task'] = 'edit';
		$output['message'] = '';
		$output['status'] = 'Active';
		$output['user_id'] = $record->user_id;
		$output['id'] = $record->id;
		$output['trading_name'] = $record->trading_name;
		$output['number_of_children'] = $record->number_of_children;
		$output['business_type_id'] = $record->business_type_id;
		$output['business_registered_name'] = $record->business_registered_name;
		$output['company_registration_number'] = $record->company_registration_number;
		$output['street_line_1'] = $record->street_line_1;
		$output['street_line_2'] = $record->street_line_2;
		$output['city_id'] = $record->city_id;
		$output['state_id'] = $record->state_id;
		$output['country_id'] = $record->country_id;
		$output['zipcode'] = $record->zipcode;
		$output['customer_enquiry_number'] = $record->customer_enquiry_number;
		$output['customer_enquiry_email'] = $record->customer_enquiry_email;
		// $output['special_education_own'] = $record->special_education_own;
		// $output['curricular_activity_own'] = $record->curricular_activity_own;
		$output['ofsted_registered'] = $record->ofsted_registered;
		$output['ofsted_registration_number'] = $record->ofsted_registration_number;
		$output['ofsted_rating'] = $record->ofsted_rating;
		$output['holiday_club_services'] = $record->holiday_club_services;
		$output['emergency_childcare'] = $record->emergency_childcare;
		$output['childcare_voucher'] = $record->childcare_voucher;
		$output['tax_free'] = $record->tax_free;
		$output['fifteen_funded_three_four_year'] = $record->fifteen_funded_three_four_year;
		$output['fifteen_funded_two_year'] = $record->fifteen_funded_two_year;
		$output['thirty_funded_three_four_year'] = $record->thirty_funded_three_four_year;
		$output['bank_holidays'] = $record->bank_holidays;
		$output['christmas_week'] = $record->christmas_week;
		$output['open_all_year'] = $record->open_all_year;
		$output['summer_terms'] = $record->summer_terms;
		$output['spring_terms'] = $record->spring_terms;
		$output['autumn_terms'] = $record->autumn_terms;
		$output['week_summer'] = $record->week_summer;
		$output['week_spring'] = $record->week_spring;
		$output['week_autumn'] = $record->week_autumn;
		$output['business_logo'] = $record->business_logo;
		$output['business_image_one'] = $record->business_image_one;
		$output['business_image_two'] = $record->business_image_two;
		$output['business_image_three'] = $record->business_image_three;
		$output['business_image_four'] = $record->business_image_four;
		$output['business_image_five'] = $record->business_image_five;
		$output['business_type'] = $this->business_types->getActiveRecords();
		$output['country'] = $this->address->getCountryRecords();
		$output['special_education'] = $this->special_education->getActiveRecords();
		$output['curricular_activities'] = $this->curricular_activities->getActiveRecords();
		$output['service_type'] = $this->service_category->getActiveRecords();
		$output['selected_education'] = $this->user->get_selected_education($id);
		$output['selected_activity'] = $this->user->get_selected_activity($id);
		$output['selected_service_type'] = $this->user->get_selected_service_type($id);
		$output['special_education_own'] = $this->user->get_own_education($id);
		$output['curricular_activity_own'] = $this->user->get_own_activity($id);
		$failure = false;
        $message = '';

        if (isset($_POST) && !empty($_POST)) {
			$success = true;
			$this->form_validation->set_rules('trading_name', 'Trading name', 'trim|required|callback_check_space');
			$this->form_validation->set_rules('number_of_children', 'Number of children', 'trim|required|integer');
			$this->form_validation->set_rules('business_type_id', 'Business Type', 'trim|required');
			$this->form_validation->set_rules('business_registered_name', 'Business registered name', 'trim|callback_check_space');
			$this->form_validation->set_rules('company_registration_number', 'Company registered number', 'trim|required|callback_check_space');
			$this->form_validation->set_rules('street_line_1', 'Street address', 'trim|required|callback_check_space');
			$this->form_validation->set_rules('street_line_2', 'Street address', 'trim|callback_check_space');
			$this->form_validation->set_rules('country_id', 'Country', 'trim|required');
			$this->form_validation->set_rules('state_id', 'State', 'trim|required');
			$this->form_validation->set_rules('city_id', 'City', 'trim|required');
			$this->form_validation->set_rules('zipcode', 'zipcode', 'trim|required|callback_check_space');
			$this->form_validation->set_rules('customer_enquiry_number', 'Customer enquiry number', 'trim|required|integer|callback_check_space');
			$this->form_validation->set_rules('customer_enquiry_email', 'Customer enquiry email', 'trim|required|valid_email|callback_check_space');
			$this->form_validation->set_rules('service_type_id[]', 'Service type', 'trim|required');
			$this->form_validation->set_rules('add_own_education', 'add_own_education', 'trim');
			$this->form_validation->set_rules('add_own_activity', 'add_own_activity', 'trim');

			if (isset($_POST['add_own_education'])) {
				$this->form_validation->set_rules('special_education_own[]', 'Special education Own', 'trim|required|callback_check_space');
			} else {
				$this->form_validation->set_rules('special_education_id[]', 'Special education', 'trim|required');
			}

			if (isset($_POST['add_own_activity'])) {
				$this->form_validation->set_rules('curricular_activity_own[]', 'Curricular activity Own', 'trim|required|callback_check_space');
			} else {
				$this->form_validation->set_rules('curricular_activity_id[]', 'Curricular activity', 'trim|required');
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
				$this->form_validation->set_rules('week_summer', 'Select summer weeks', 'trim|required');

				if (isset($_POST['week_summer']) && $_POST['week_summer'] == '38') {
                    $this->form_validation->set_rules('38_summer_terms', 'Summer Weeks', 'trim|required|integer');

                } else {
                    $this->form_validation->set_rules('52_summer_terms', 'Summer Weeks', 'trim|required|integer');
                }
			}

			if (isset($_POST['spring_terms_check'])) {
				$this->form_validation->set_rules('week_spring', 'Select spring weeks', 'trim|required');

				if (isset($_POST['week_spring']) && $_POST['week_spring'] == '38') {
                    $this->form_validation->set_rules('38_spring_terms', 'Spring Weeks', 'trim|required|integer');

                } else {
                    $this->form_validation->set_rules('52_spring_terms', 'Spring Weeks', 'trim|required|integer');
                }
			}

			if (isset($_POST['autumn_terms_check'])) {
                $this->form_validation->set_rules('week_autumn', 'Select autumn weeks', 'trim|required');

                if (isset($_POST['week_autumn']) && $_POST['week_autumn'] == '38') {
                    $this->form_validation->set_rules('38_autumn_terms', 'Autumn Weeks', 'trim|required|integer');

                } else {
                    $this->form_validation->set_rules('52_autumn_terms', 'Autumn Weeks', 'trim|required|integer');
                }
            }

			if ($this->form_validation->run()) {
				// pr($_POST);die;

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
	                $business_logo = $record->business_logo;
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
                    	$upload_image_one_file = $record->business_image_one;
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
                    	$upload_image_two_file = $record->business_image_two;
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
                    	$upload_image_three_file = $record->business_image_three;
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
                    	$upload_image_four_file = $record->business_image_four;
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
                    	$upload_image_five_file = $record->business_image_five;
                    }
                }

	            if (!$failure) {
					$input = array();
					$input['trading_name'] = $this->input->post('trading_name');
					$input['number_of_children'] = $this->input->post('number_of_children');
					$input['business_type_id'] = $this->input->post('business_type_id');

					if ($_POST['business_registered_name']) {
						$input['business_registered_name'] = $this->input->post('business_registered_name');
					}

					$input['company_registration_number'] = $this->input->post('company_registration_number');
					$input['street_line_1'] = $this->input->post('street_line_1');

					if (isset($_POST['street_line_2'])) {
						$input['street_line_2'] = $this->input->post('street_line_2');
					}
					$input['city_id'] = $this->input->post('city_id');
					$input['state_id'] = $this->input->post('state_id');
					$input['country_id'] = $this->input->post('country_id');
					$input['zipcode'] = $this->input->post('zipcode');
					$input['customer_enquiry_number'] = $this->input->post('customer_enquiry_number');
					$input['customer_enquiry_email'] = $this->input->post('customer_enquiry_email');

					/*if (isset($_POST['add_own_education'])) {
						$input['special_education_own'] = $this->input->post('special_education_own');

					} else {
						$input['special_education_own'] = NULL;
					}
					
					if (isset($_POST['add_own_activity'])) {
						$input['curricular_activity_own'] = $this->input->post('curricular_activity_own');

					} else {
						$input['curricular_activity_own'] = NULL;
					}*/

					$input['ofsted_registered'] = $this->input->post('ofsted_registered');

					if ($_POST['ofsted_registered'] && $_POST['ofsted_registered'] != 'No') {
						$input['ofsted_registration_number'] = $this->input->post('ofsted_registration_number');

					} else {
						$input['ofsted_registration_number'] = NULL;
					}

					if (isset($_POST['ofsted_rating'])) {
						$input['ofsted_rating'] = $this->input->post('ofsted_rating');

					} else {
						$input['ofsted_rating'] = NULL;
					}

					if (isset($_POST['childcare_voucher'])) {
						$input['childcare_voucher'] = $this->input->post('childcare_voucher');

					} else {
						$input['childcare_voucher'] = NULL;
					}

					if (isset($_POST['holiday_club_services'])) {
						$input['holiday_club_services'] = $this->input->post('holiday_club_services');

					} else {
						$input['holiday_club_services'] = NULL;
					}

					if (isset($_POST['emergency_childcare'])) {
						$input['emergency_childcare'] = $this->input->post('emergency_childcare');

					} else {
						$input['emergency_childcare'] = NULL;
					}

					if (isset($_POST['tax_free'])) {
						$input['tax_free'] = 'Yes';

					} else{
						$input['tax_free'] = NULL;
					}

					if (isset($_POST['fifteen_funded_three_four_year'])) {
						$input['fifteen_funded_three_four_year'] = 'Yes';

					} else {
						$input['fifteen_funded_three_four_year'] = NULL;
					}

					if (isset($_POST['fifteen_funded_two_year'])) {
						$input['fifteen_funded_two_year'] = 'Yes';

					} else {
						$input['fifteen_funded_two_year'] = NULL;
					}

					if (isset($_POST['thirty_funded_three_four_year'])) {
						$input['thirty_funded_three_four_year'] = 'Yes';

					} else {
						$input['thirty_funded_three_four_year'] = NULL;
					}

					if (isset($_POST['bank_holidays'])) {
						$input['bank_holidays'] = 'Yes';

					} else {
						$input['bank_holidays'] = NULL;
					}

					if (isset($_POST['christmas_week'])) {
						$input['christmas_week'] = 'Yes';

					} else {
						$input['christmas_week'] = NULL;
					}

					if (isset($_POST['open_all_year'])) {
						$input['open_all_year'] = 'Yes';

					} else {
						$input['open_all_year'] = NULL;
					}

					if (isset($_POST['summer_terms_check'])) {
						$input['week_summer'] = $this->input->post('week_summer');

                        if (isset($_POST['week_summer']) && $_POST['week_summer'] == '38') {
                            $input['summer_terms'] = $this->input->post('38_summer_terms');

                        } else {
                            $input['summer_terms'] = $this->input->post('52_summer_terms');
                        }

					} else {
						$input['week_summer'] = NULL;
						$input['summer_terms'] = NULL;
					}

					if (isset($_POST['spring_terms_check'])) {
						$input['week_spring'] = $this->input->post('week_spring');

                        if (isset($_POST['week_spring']) && $_POST['week_spring'] == '38') {
                            $input['spring_terms'] = $this->input->post('38_spring_terms');

                        } else {
                            $input['spring_terms'] = $this->input->post('52_spring_terms');
                        }

					} else {
						$input['week_spring'] = NULL;
						$input['spring_terms'] = NULL;
					}


                    if (isset($_POST['autumn_terms_check'])) {
                        $input['week_autumn'] = $this->input->post('week_autumn');

                        if (isset($_POST['week_autumn']) && $_POST['week_autumn'] == '38') {
                            $input['autumn_terms'] = $this->input->post('38_autumn_terms');

                        } else {
                            $input['autumn_terms'] = $this->input->post('52_autumn_terms');
                        }

                    } else {
						$input['week_autumn'] = NULL;
						$input['autumn_terms'] = NULL;
					}

					$input['business_logo'] = $business_logo;
					$input['business_image_one'] = $upload_image_one_file;
					$input['business_image_two'] = $upload_image_two_file;
					$input['business_image_three'] = $upload_image_three_file;
					$input['business_image_four'] = $upload_image_four_file;
					$input['business_image_five'] = $upload_image_five_file;
					$input['update_date'] = $this->common_model->getDefaultToGMTDate(time());
					$response = $this->user->update_business_record($input, $id);
					
					if ($response) {
						$this->user->delete_selected_education($id);
						$this->user->delete_selected_activity($id);
						$this->user->delete_selected_service_type($id);
						$this->user->delete_selected_own_education($id);
						$this->user->delete_selected_own_activity($id);

						$special_education_id = $this->input->post('special_education_id');
						$curricular_activity_id = $this->input->post('curricular_activity_id');
						$service_type_id = $this->input->post('service_type_id');
						$special_education_own = $this->input->post('special_education_own');
						$curricular_activity_own = $this->input->post('curricular_activity_own');

						$special_education = array();
						$curricular_activity = array();
						$service_type = array();

						foreach ($special_education_id as $key => $value) {
							$special_education[$key]['user_business_detail_id'] = $id;
							$special_education[$key]['special_education_id'] = $value;
							$special_education[$key]['add_date'] = $this->common_model->getDefaultToGMTDate(time());	
						}

						if ($special_education) {
							$this->user->insert_special_education_record($special_education);
						}

						if ($special_education_own && !empty($special_education_own)) {

							foreach ($special_education_own as $key => $value) {
								$education_own[$key]['user_business_detail_id'] = $id;
								$education_own[$key]['education_name'] = $value;
								$education_own[$key]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
							}

							if ($education_own) {
								$this->user->insert_own_education_record($education_own);
							}
						}

						foreach ($curricular_activity_id as $key => $value) {
							$curricular_activity[$key]['user_business_detail_id'] = $id;
							$curricular_activity[$key]['curricular_activity_id'] = $value;
							$curricular_activity[$key]['add_date'] = $this->common_model->getDefaultToGMTDate(time());	
						}

						if ($curricular_activity) {
							$this->user->insert_curricular_activity_record($curricular_activity);
						}

						if ($curricular_activity_own && !empty($curricular_activity_own)) {

							foreach ($curricular_activity_own as $key => $value) {
								$activity_own[$key]['user_business_detail_id'] = $id;
								$activity_own[$key]['activity_name'] = $value;
								$activity_own[$key]['add_date'] = $this->common_model->getDefaultToGMTDate(time());	
							}

							if ($activity_own) {
								$this->user->insert_own_activity_record($activity_own);
							}
						}

						if ($service_type_id && !empty($service_type_id)) {

							foreach ($service_type_id as $key => $value) {
								$service_type[$key]['user_business_detail_id'] = $id;
								$service_type[$key]['service_type_id'] = $value;
								$service_type[$key]['add_date'] = $this->common_model->getDefaultToGMTDate(time());	
							}

							if ($service_type) {
								$this->user->insert_service_type_record($service_type);
							}
						}

						$message = 'Record updated successfully.';
						$success = true;
						$output['redirectURL'] = site_url('admin/users/profile_detail/'.$record->user_id);

					} else {
						$message = 'Technical error, please try again.';
						$success = false;
					}

				} else {
                    $success = false;
                    $message = $message;
                }

			} else {
				$success = false;
				$message = validation_errors();
			}
			$output['message'] = $message;
			$output['success'] = $success;
			echo json_encode($output);die;
		}
		// pr($output);die;
		$this->load->view('admin/includes/header',$output);
		$this->load->view('admin/users/business_form');
		$this->load->view('admin/includes/footer');
	}

	function view($id)
    {
        $record	= $this->user->get_record_by_id($id);

        if (!$record) {
        	echo "<center><h1>No record found.</h1></center>";die;
        }

        $output = array();
		$output['page_title'] = 'User Management';
		$output['left_menu'] = 'user_module';
		$output['left_submenu'] = 'user_list';

		if ($record) {

			if ($record->study_type == 'School') {
        		$school = $this->school->get_record_by_id($record->school_id);
        		$record->education_name = $school->name;
				
			} else {
        		$university = $this->university->get_record_by_id($record->university_id);
        		$record->education_name = $university->name;

			}
			$record->subject_detail = $this->user->getSubjectDetailByUserId($id);
        	$record->add_date = $this->common_model->getGMTDateToLocalDate($record->add_date);
        	$output['record'] = $record;
		} /*else {
			echo "<center><h1>No record found.</h1></center>";die;
		}*/
		// pr($output);die;
        $this->load->view('admin/includes/header',$output);
		$this->load->view('admin/users/view');
		$this->load->view('admin/includes/footer');
    }

    function business_detail($id)
    {
        $record	= $this->user->getBusinessRecordById($id);

        if (!$record) {
        	echo "<center><h1>No record found.</h1></center>";die;
        }

        $output = array();
		$output['page_title'] = 'User Management';
		$output['left_menu'] = 'user_module';
		$output['left_submenu'] = 'user_list';

		if ($record) {
			$record->selected_education = $this->user->get_selected_education($id);
			$record->selected_activity = $this->user->get_selected_activity($id);
			$record->selected_service_type = $this->user->get_selected_service_type($id);
			$record->special_education_own = $this->user->get_own_education($id);
			$record->curricular_activity_own = $this->user->get_own_activity($id);
        	$record->add_date = $this->common_model->getGMTDateToLocalDate($record->add_date);
        	$output['record'] = $record;
		}
		// pr($output);die;
        $this->load->view('admin/includes/header',$output);
		$this->load->view('admin/users/view_business_detail');
		$this->load->view('admin/includes/footer');
    }

    function append_own_edu()
    {
		$output['key'] = $this->input->post('key');
	    $html = $this->load->view('admin/users/append_special_edu', $output, true);
	    $success = true;
	    $data['html'] = $html;
	    $data['success'] = $success;
    	echo json_encode($data); die;
	}

	function append_own_activity()
    {
		$output['key'] = $this->input->post('key');
	    $html = $this->load->view('admin/users/append_own_activity', $output, true);
	    $success = true;
	    $data['html'] = $html;
	    $data['success'] = $success;
    	echo json_encode($data); die;
	}

    function ajax_study()
    {
    	$study_type = $this->input->get('study_type');

    	if ($this->input->get('education_id')) {
    		$output['education_id'] = $this->input->get('education_id');

    	} else {
    		$output['education_id'] = null;
    	}

    	$output['study_type'] = $study_type;

    	if ($study_type == 'School') {
    		$output['records'] = $this->school->getActiveRecords();

    	} else {
			$output['records'] = $this->university->getActiveRecords();
    	}

    	$html = $this->load->view('admin/users/ajax_study_data', $output, true);		

		$data['html'] = $html;
		$data['success'] = true;
		$data['message'] = true;
		echo json_encode($data);
    }

    function ajax_subjects()
    {
    	$subject_ids = $this->input->get('subject_ids');

    	if ($this->input->get('id')) {
    		$user_id = $this->input->get('id');
    		// $output['selected_subject'] = $this->user->getSubjectDetailByUserId($id);
    		$output['subject_records'] = $this->user->getSubjectDetailByUserId1($subject_ids, $user_id);

    	} else {
    		$output['form_task'] = null;
    		$output['subject_records'] = $this->subject->getRecordByIds($subject_ids);
    	}

    	$html = $this->load->view('admin/users/ajax_subject_data', $output, true);
    	// pr($html);die;	

		$data['html'] = $html;
		$data['success'] = true;
		$data['message'] = true;
		echo json_encode($data);
    }

    function check_email_exist($value, $id = '')
    {
        if($this->user->doesEmailExist( $value, $id )) {
            $this->form_validation->set_message('check_email_exist', 'This E-Mail address already register on our server.');
            return false;
        }
        return true;
    }

    function check_number_exist($value, $id = '')
    {
        if($this->user->doesNumberExist( $value, $id )) {
            $this->form_validation->set_message('check_number_exist', 'This mobile number already register on our server.');
            return false;
        }
        return true;
    }

    function check_space($value)
    {
        if ( ! preg_match("/^[a-zA-Z0-9_@#$^&%*)(_+}{;:?\/., ]*$/", $value) ){
           $this->form_validation->set_message('check_space', 'The %s field should contain only letters, numbers or periods');
           return false;
       }
        else
        return true;
    }
    function check_space_front_end($value)
    {
        if(!preg_match('/^[a-zA-Z0-9_@#$^&%*)(_+}{;:?\/.,]*$/',$value) || preg_match('/^ /',$value) || preg_match('/ $/',$value)) {
           $this->form_validation->set_message('check_space_front_end', 'The %s field should contain only letters, numbers or periods');
           return false;
       }
        else
        return true;
    }
}