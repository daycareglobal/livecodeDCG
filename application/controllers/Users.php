<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
	
	function __construct() {
		Parent::__construct();
		$this->load->model('front/user_model', 'users');
		$this->load->model('mailsending_model','mailsending');
	}

	function login() {

		if (is_user_logged_in()) {
			redirect(base_url());
		}

		$output['page'] = 'login';

		if (isset($_POST)) {
			$success = true;
			$failure = false;
			$message = false;
			$this->form_validation->set_rules('email', 'Login Id', 'trim|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[15]');

			if ($this->form_validation->run()) {
				$password = $this->input->post('password');
				$salt = 'Ijxo1A16';
				$ency_password = md5(md5($password).md5($salt));
				$user = array(
					// 'email' => $this->input->post('email'),
					'is_admin' => 'No',
					'password' => $ency_password
				);
				$valid_user = $this->users->checkValidUser1($user, $this->input->post('email'));
				//pr($valid_user);die;

				if ($valid_user) {

					if ($valid_user->status == "Active" && $valid_user->is_email_verified == "Yes") {
						$this->session->set_userdata(array('user_id' => $valid_user->id, 'user_name' => $valid_user->name, 'profile_image' => $valid_user->profile_image, 'user_type' => $valid_user->user_type));
						$message = 'You are successfully login.';

						if ($valid_user->user_type == 'Business') {
							$redirectURL = site_url('dashboard');

						} else {
							$redirectURL = site_url('');
						}

					} else if ( $valid_user && $valid_user->is_email_verified == "No" ) {
						$message = 'You account is not verified. Please verify your account and then login';
						$failure = true;
					
					} else if ( $valid_user && $valid_user->status == "Inactive" ) {
						$message = 'Sorry! Your account has been inactive from admin';
						$failure = true;
					} 

				} else {
					$message = 'Incorrect login credentials';
					$failure = true;
				}

			} else {
				$message = validation_errors();
				$failure = true;
			}
			
			if ($failure) {
				$data['success'] = false;

			} else {
				$data['success'] = true;
				$data['resetForm'] = true;

				if (isset($_GET['redirect'])) {
				    $url = base64_decode($_GET['redirect']);
				    $data['redirectURL'] = base_url().$url;
			    } else {

					if (isset($redirectURL)) {
						$data['redirectURL'] = $redirectURL;

					} else {
						$data['redirectURL'] = site_url();
					}
			    } 
					
			}

			$data['message'] = $message;

			if ($this->input->is_ajax_request()) {
				echo json_encode($data); die;
			}	
		}
		// $this->load->view('front/includes/header', $output);
		$this->load->view('front/users/login');
		$this->load->view('front/includes/footer');
	}

	function logout()
	{
		$this->session->unset_userdata('user_id');
		$this->session->unset_userdata('user_name');
		$this->session->unset_userdata('profile_image');
		$this->session->unset_userdata('user_type');
		redirect('');
	}

	function forgot_password() {

		if (is_childcare_logged_in()) {
			redirect(base_url());
		}

		$output['page'] = 'forgot_password';

		if (isset($_POST) && !empty($_POST)) {
			$this->form_validation->set_rules('mobile_number', 'mobile number', 'trim|required|min_length[10]|max_length[10]');

			if ($this->form_validation->run()) {
				$data['message'] = '';
				$mobile_number = $this->input->post('mobile_number');
				$user = $this->users->getUserByMobile($mobile_number);

				if ($user) {
					$otp = mt_rand(100000,999999);
	            	$input = array();
					$input['forgot_password_key'] =  $otp;
					$input['update_date'] = $this->common_model->getDefaultToGMTDate(time());
					$otp_id = $this->users->update_record($input, $user->id);

					sentOtp($otp, $mobile_number);
	            	$success = true;
	            	$message = false;
	            	$data['callBackFunction'] = "openForgotPasswordPopup";

				} else {
					$message = 'Mobile number incorrect.';
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

		$this->load->view('front/users/forgot_password', $output);
		$this->load->view('front/includes/footer');
	}

	/*function forgot_password() {

		if (is_childcare_logged_in()) {
			redirect(base_url());
		}

		$output['page'] = 'forgot_password';

		if (isset($_POST) && !empty($_POST)) {
			$this->form_validation->set_rules('mobile_number', 'mobile number', 'trim|required|min_length[10]|max_length[10]');

			if ($this->form_validation->run()) {
				$data['message'] = '';
				$emailId = $this->input->post('mobile_number');
				$user = $this->users->getUserByEmailId($emailId);

				if ($user) {
					$userid = $user->id;
					$forgotPasswordKey = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 30);		
					$resetURL = '<a href="'.site_url('reset-password/'. $forgotPasswordKey).'">Reset Password</a>';			
					$input = array();
					$input['forgot_password_key'] = $forgotPasswordKey;
					$input['expire_time'] = date('Y-m-d H:i:s', strtotime("+3 hour"));
					$input['update_date'] = $this->common_model->getDefaultToGMTDate(time());
					$this->users->update_record($input, $userid);
					$this->mailsending->forgotPasswordUserMailSending($userid, $forgotPasswordKey, $resetURL);
					$message = 'Please check E-mail and reset password.';
					$success = true;
					$data['redirectURL'] = site_url('login');

				} else {
					$message = 'Email Address incorrect.';
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

		$this->load->view('front/users/forgot_password', $output);
		$this->load->view('front/includes/footer');
	}*/

	function password_reset_form()
	{
		if (isset($_POST) && !empty($_POST)) {
		    $this->form_validation->set_rules('otp', 'OTP', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|max_length[15]');
		    $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
		    $this->form_validation->set_rules('mobile_number', 'mobile number', 'required');

		    if ($this->form_validation->run()) {
		    	$check_otp_exist = $this->users->checkForgotPasswordOTPExist($this->input->post('mobile_number'));

            	if ($check_otp_exist && $check_otp_exist->forgot_password_key == $this->input->post('otp')) {
					$password = $this->input->post('password');
					$salt = 'Ijxo1A16';
					$ency_password = md5(md5($password).md5($salt));
					$input = array();
					$input['password'] = $ency_password;
					$input['forgot_password_key'] = null;
					$input['expire_time'] = null;
					$input['update_date'] = $this->common_model->getDefaultToGMTDate(time());
					$this->users->update_record($input, $check_otp_exist->id);

					$message = 'Password Successfully Updated.';
					$success = true;
					$data['redirectURL'] = site_url('login');

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

		} else {
			$message = 'Invalid request!';
			$success = false;
			$data['message'] = $message;
			$data['success'] = $success;
			echo json_encode($data);die;
		}	
	}

	function reset_password($key = '')
	{
		$forgotPasswordKey = $key;
		$user = $this->users->getUserByForgotPasswordKey($forgotPasswordKey);
		$output['page'] = 'reset_password';
		$output['title'] = 'Reset Password';

		if ($user) {
			$emailAddress = $user->email;
			$id = $user->id;
			$checkValidURL = $this->users->checkExpireTime($emailAddress, $forgotPasswordKey);

			if ($checkValidURL) {

				if (isset($_POST) && !empty($_POST)) {
					$this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[6]|max_length[15]');
				    $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[new_password]');

				    if ($this->form_validation->run()) {
						$password = $this->input->post('new_password');
						$salt = 'Ijxo1A16';
						$ency_password = md5(md5($password).md5($salt));
						$input = array();
						$input['password'] = $ency_password;
						$input['forgot_password_key'] = null;
						$input['expire_time'] = null;
						$input['update_date'] = $this->common_model->getDefaultToGMTDate(time());
						$this->users->update_record($input, $id);

						$message = 'Password Successfully Updated.';
						$success = true;
						$data['redirectURL'] = site_url('login');

 					} else {
						$success = false;
						$message = validation_errors();
					}
					$data['message'] = $message;
					$data['success'] = $success;
					echo json_encode($data);die;
				}

				$this->load->view('front/users/reset_password', $output);
				$this->load->view('front/includes/footer');

			} else {
				$output['heading'] = 'Link Expired!';
				$output['description'] = 'Your reset password link is expired. Please change your password again.';
				$this->load->view('front/includes/header', $output);
				$this->load->view('front/message/message');
				$this->load->view('front/includes/footer');
			}

		} else {
			$output['heading'] = 'Link Expired!';
			$output['description'] = 'Your reset password link is expired. Please change your password again.';
			$this->load->view('front/includes/header', $output);
			$this->load->view('front/message/message');
			$this->load->view('front/includes/footer');
		}		
	}

	function success()
	{
		$output['title'] = "Password Changed.";
		$output['description'] = "Your password has been changed successfully.";
		$this->load->view('front/message/message', $output);
	}

	function verify_account($email_verified_key = null)
	{		
		if ( !$email_verified_key ) {
			redirect('');
		}

		$output['page'] = 'verify_account';
		$output['title'] = 'E-mail verified';

		$user_detail = $this->users->get_user_by_email_verified_key($email_verified_key);

		if ($user_detail) {
			$user_info = array();
			$user_info['email_verified_key'] = NULL;
			$user_info['is_email_verified'] = 'Yes';
			$user_info['update_date'] = $this->common_model->getDefaultToGMTDate(time());
			$this->users->update_record($user_info, $user_detail->id);
			$output['heading'] = 'Thank you!';
			$content = "Congratulation! Your account has been verified.";

		} else {
			$output['heading'] = 'Sorry! This link has been expired.';
			$content = "You already verified!";
		}
			
		$output['description'] = $content;
		$this->load->view('front/includes/header', $output);
		$this->load->view('front/message/message');
		$this->load->view('front/includes/footer');
	}

	function verify_new_email($email_verified_key = null)
	{		
		if ( !$email_verified_key ) {
			redirect('');
		}

		$output['page'] = 'verify_account';
		$output['title'] = 'E-mail verified';

		$user_detail = $this->users->get_email_verified_key_data($email_verified_key);

		if ($user_detail) {
			$user_info = array();
			$user_info['email'] = $user_detail->email;
			$user_info['update_date'] = $this->common_model->getDefaultToGMTDate(time());
			$update_respo = $this->users->update_record($user_info, $user_detail->user_id);

			if ($update_respo) {
				$this->users->delete_temp_email($user_detail->id);
				$output['heading'] = 'Thank you!';
				$content = "Congratulation! Your new email has been verified.";

			} else {
				$output['heading'] = 'Error!';
				$content = "Oops! There is something wrong, Please try again.";
			}


		} else {
			$output['heading'] = 'Sorry! This link has been expired.';
			$content = "Link expired!";
		}
			
		$output['description'] = $content;
		$this->load->view('front/includes/header', $output);
		$this->load->view('front/message/message');
		$this->load->view('front/includes/footer');
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