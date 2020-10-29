<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {
	
	function __construct() {
		Parent::__construct();
		$this->load->model('front/user_model', 'users');
		$this->load->model('front/business_types_model', 'business_type');
		$this->load->model('mailsending_model','mailsending');
	}

	function sign_up()
    {        
    	if (is_childcare_logged_in()) {
       		redirect(base_url());
        }
        $output = array();
        $output['title'] = "Childcare :Signup";
        $output['page'] = "sign-up";
        $output['gender'] = "";
        $failure = false;
        $message = '';

        if (isset($_POST) && !empty($_POST)) {
        	$this->form_validation->set_rules('first_name', 'First name', 'trim|required|callback_check_space');
			$this->form_validation->set_rules('last_name', 'Last name', 'trim|required|callback_check_space');
			$this->form_validation->set_rules('gender', 'Gender', 'trim|required');
			// $this->form_validation->set_rules('dob', 'Date of birth', 'trim|required');
			$this->form_validation->set_rules('contact_number', 'Contact number', 'trim|required|is_unique[tbl_users.contact_number]|min_length[10]|max_length[10]');
			$this->form_validation->set_rules('email', 'Email address', 'trim|required|valid_email|is_unique[tbl_users.email]');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[15]');
			// $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|min_length[6]|max_length[15]|matches[password]');
            
            if ($this->form_validation->run()) {
            	$otp = mt_rand(100000,999999);
            	$input = array();
				$input['email'] = $this->input->post('email');
				$input['mobile_number'] = $this->input->post('contact_number');
				$input['otp'] =  $otp;
				$input['add_date'] = $this->common_model->getDefaultToGMTDate(time());
				$otp_id = $this->users->insert_otp($input);

				sentOtp($otp, $this->input->post('contact_number'));
            	$success = true;           
            	$message = false;           
            	$data['callBackFunction'] = "openUserOTPPopup";
                

            } else {
				$success = false;
				$message = validation_errors();
			}

			$data['message'] = $message;
			$data['success'] = $success;
			echo json_encode($data);die;               
	    }
		// $this->load->view('front/includes/header', $output);
      	$this->load->view('front/users/sign_up', $output);
        // $this->load->view('front/includes/footer');
	}

	function send_user_opt()
    {
    	if (is_childcare_logged_in()) {
       		redirect(base_url());
        }
        $output = array();
        $output['title'] = "Childcare :Signup";
        $output['page'] = "sign-up";
        $output['gender'] = "";
        $failure = false;
        $message = '';

        if (isset($_POST) && !empty($_POST)) {
        	$this->form_validation->set_rules('first_name', 'First name', 'trim|required|callback_check_space');
			$this->form_validation->set_rules('last_name', 'Last name', 'trim|required|callback_check_space');
			$this->form_validation->set_rules('gender', 'Gender', 'trim|required');
			// $this->form_validation->set_rules('dob', 'Date of birth', 'trim|required');
			$this->form_validation->set_rules('contact_number', 'Contact number', 'trim|required|is_unique[tbl_users.contact_number]|min_length[10]|max_length[10]');
			$this->form_validation->set_rules('email', 'Email address', 'trim|required|valid_email|is_unique[tbl_users.email]');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[15]');
			$this->form_validation->set_rules('otp', 'OTP', 'required');
			// $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|min_length[6]|max_length[15]|matches[password]');
            
            if ($this->form_validation->run()) {
            	$check_otp_exist = $this->users->checkOTPExist($this->input->post('contact_number'));

            	if ($check_otp_exist && $check_otp_exist->otp == $this->input->post('otp')) {
	                $password = $this->input->post('password');
					$salt = 'Ijxo1A16';
					$ency_password = md5(md5($password).md5($salt));

					$input = array();
					$input['name'] = $this->input->post('first_name');
					$input['last_name'] = $this->input->post('last_name');
					$input['gender'] = $this->input->post('gender');
					$input['contact_number'] = $this->input->post('contact_number');
					// $input['dob'] = $this->input->post('dob');
					$input['email'] = $this->input->post('email');
					$input['user_type'] = 'User';
					// $input['profile_image'] = $image_name;
					$input['password'] = $ency_password;
					$input['add_date'] = $this->common_model->getDefaultToGMTDate(time());
					$user_id = $this->users->insert_record($input);
					
					if ($user_id) {
						$message = 'You are successfully registered on our server, Please login.';
						$success = true;
						$data['redirectURL'] = site_url('login');

					} else {
						$success = false;
						$message = 'Technical error, Please try again.';
					}

				} else {
            		$success = false;
					$message = 'Please enter a valid OTP.';
            	}

            } else {
				$success = false;
				$message = validation_errors();
			}

			$data['message'] = $message;
			$data['success'] = $success;
			echo json_encode($data);die;               
	    }
		// $this->load->view('front/includes/header', $output);
      	$this->load->view('front/users/sign_up', $output);
        // $this->load->view('front/includes/footer');
	}

	function send_opt()
    {        
    	if (is_childcare_logged_in()) {

       		redirect(base_url());
        }
        $output = array();
        $output['title'] = "Childcare :Signup";
        $output['page'] = "sign-up";
        $output['business_types'] = $this->business_type->getActiveRecords();
        $failure = false;
        $message = '';

        if (isset($_POST) && !empty($_POST)) {
        	$this->form_validation->set_rules('business_name', 'Business name', 'trim|required|callback_check_space');
			$this->form_validation->set_rules('business_type_id', 'Business type', 'trim|required|callback_check_space');
			$this->form_validation->set_rules('email', 'Email address', 'trim|required|valid_email|is_unique[tbl_users.email]');
			$this->form_validation->set_rules('contact_number', 'Contact number', 'trim|required|is_unique[tbl_users.contact_number]|min_length[10]|max_length[10]');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[15]');

			// $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
			$this->form_validation->set_rules('otp', 'OTP', 'required');



			/*if (!isset($_POST['privacy_policy'])) {
				$this->form_validation->set_rules('privacy_policy', 'Terms and Conditions', 'trim|required', array('required' => 'You must accept %s.'));
			}*/
            
            if ($this->form_validation->run()) {
            	$check_otp_exist = $this->users->checkOTPExist($this->input->post('contact_number'));

            	if ($check_otp_exist && $check_otp_exist->otp == $this->input->post('otp')) {
            		$password = $this->input->post('password');
					$salt = 'Ijxo1A16';
					$ency_password = md5(md5($password).md5($salt));

					$input = array();
					$input['name'] = $this->input->post('business_name');
					$input['email'] = $this->input->post('email');
					$input['contact_number'] = $this->input->post('contact_number');
					$input['password'] = $ency_password;
					$input['add_date'] = $this->common_model->getDefaultToGMTDate(time());
					$user_id = $this->users->insert_record($input);

					if ($user_id) {
						$business_type_ids = explode(',', $_POST['business_type_id']);
						// $business_type_ids = $this->input->post('business_type_id');
						$business_type = array();

						if (!empty($business_type_ids)) {

							foreach ($business_type_ids as $key => $value) {
								$business_type[$key]['user_id'] = $user_id;
								$business_type[$key]['business_type_id'] = $value;
								$business_type[$key]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
							}

							if (!empty($business_type)) {
								$this->users->insert_business_types($business_type);
							}
						}
						$message = 'You are successfully registered on our server, Please login.';
						$success = true;
						$data['redirectURL'] = site_url('login');
					}
				    else {
						$success = false;
						$message = 'Technical error, Please try again.';
					}
            	} else {
            		$success = false;
					$message = 'Please enter a valid OTP.';
            	}
            	
                

            } else {
				$success = false;
				$message = validation_errors();
			}

			$data['message'] = $message;
			$data['success'] = $success;
			echo json_encode($data);die;               
	    }
		// $this->load->view('front/includes/header', $output);
      	$this->load->view('front/users/business_sign_up', $output);
        // $this->load->view('front/includes/footer');
	}

	function business_sign_up()
    {        
    	if (is_childcare_logged_in()) {

       		redirect(base_url());
        }
        $output = array();
        $output['title'] = "Childcare :Signup";
        $output['page'] = "sign-up";
        $output['business_types'] = $this->business_type->getActiveRecords();
        $failure = false;
        $message = '';

        if (isset($_POST) && !empty($_POST)) {
        	$this->form_validation->set_rules('business_name', 'Business name', 'trim|required|callback_check_space');
			$this->form_validation->set_rules('business_type_id[]', 'Business type', 'trim|required|callback_check_space');
			$this->form_validation->set_rules('email', 'Email address', 'trim|required|valid_email|is_unique[tbl_users.email]');
			$this->form_validation->set_rules('contact_number', 'Contact number', 'trim|required|is_unique[tbl_users.contact_number]|min_length[10]|max_length[10]');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[15]');

			$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');



			/*if (!isset($_POST['privacy_policy'])) {
				$this->form_validation->set_rules('privacy_policy', 'Terms and Conditions', 'trim|required', array('required' => 'You must accept %s.'));
			}*/
            
            if ($this->form_validation->run()) {
            	$otp = mt_rand(100000,999999);
            	$input = array();
				$input['email'] = $this->input->post('email');
				$input['mobile_number'] = $this->input->post('contact_number');
				$input['otp'] =  $otp;
				$input['add_date'] = $this->common_model->getDefaultToGMTDate(time());
				$otp_id = $this->users->insert_otp($input);

				sentOtp($otp, $this->input->post('contact_number'));
            	$success = true;           
            	$message = false;           
            	$data['callBackFunction'] = "openOTPPopup";           

            } else {
				$success = false;
				$message = validation_errors();
			}

			$data['message'] = $message;
			$data['success'] = $success;
			echo json_encode($data);die;               
	    }
		// $this->load->view('front/includes/header', $output);
      	$this->load->view('front/users/business_sign_up', $output);
        // $this->load->view('front/includes/footer');
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