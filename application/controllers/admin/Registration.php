<?php
/**
*Controller for Registration and authentication
*/
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Registration extends CI_Controller {

	function __construct() {
		Parent::__construct();
		$this->load->model('admin/auth_model', 'auth');
		$this->load->model('mailsending_model','mailsend');
		$this->load->helper('string_helper');
	}

	function login() {
		if(is_logged_in())
		{
			redirect('admin');
		}
		if (isset($_POST)) {
			$success = true;
			$failure = false;
			$message = false;
			$this->form_validation->set_rules('email', 'E-mail Address', 'trim|required|valid_email');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[15]');

			if ($this->form_validation->run()) {
				$password = $this->input->post('password');
				$salt = 'Ijxo1A16';
				$ency_password = md5(md5($password).md5($salt));
				$user = array(
					'email' => $this->input->post('email'),
					'is_admin' => 'Yes',
					'is_email_verified' => 'Yes',
					// 'is_delete' => 'No',
					'status' => 'Active',
					'password' => $ency_password
				);
				$valid_user = $this->auth->checkValidUser($user);
				
				if ($valid_user) {
					
					$this->session->set_userdata(array('admin_id' => $valid_user->id,'name' => $valid_user->name));
					$message = 'You are successfully login.';
				} else {
					$message = 'Incorrect login credentials';
					$failure = true;
				}
			}
			else
			{
				$message = validation_errors();
				$failure = true;
			}
			if($failure)
			{
				$data['success'] = false;
			}
			else
			{
				$data['success'] = true;
				$data['resetForm'] = true;
				$data['redirectURL'] = site_url('admin');
			}
			$data['message'] = $message;
			if($this->input->is_ajax_request())
			{
				echo json_encode($data); die;
			}	
		}
		$this->load->view('admin/register/login');
	}

	function logout() {
		echo $this->session->unset_userdata('admin_id');
		$this->session->unset_userdata('name');
		redirect('admin/login');
	}

	function forgotPassword() {

		if (is_logged_in()) {
	 		redirect('admin');
	 	}

		$output['message']    = '';

		if (isset($_POST) && !empty($_POST)) {
			$this->form_validation->set_rules('email_id', 'Email Address', 'trim|required|valid_email');

			if ($this->form_validation->run()) {
				$emailId = $this->input->post('email_id');
				$user = $this->auth->getUserByEmailId($emailId);

				if ($user) {
					$userid = $user->id;
					$forgotPasswordKey = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 30);		
					$resetURL = '<a href="'.site_url('admin/reset-password/'. $forgotPasswordKey).'">Reset Password</a>';			
					$input = array();
					$input['forgot_password_key'] = $forgotPasswordKey;
					$input['expire_time'] = date('Y-m-d H:i:s', strtotime("+3 hour"));
					$this->auth->updateUserForgotKeyByEmailid($userid, $input);
					$this->mailsend->forgotPasswordUserMailSending($userid, $forgotPasswordKey, $resetURL);
					$message = 'Please check E-mail and reset password.';
					$success = true;
					$output['redirectURL'] = site_url('admin/login');

				} else {
					$message = 'Email Address incorrect.';
					$success = false;
				}

			} else {
				$success = false;
				$message = validation_errors();
			}

			$output['message'] = $message;
			$output['success'] = $success;
			echo json_encode($output);die;
		}
		$this->load->view('admin/register/forgot_password');
	}

	function resetPassword($key = '')
	{
		$forgotPasswordKey = $key;
		$user = $this->auth->getUserByForgotPasswordKey($forgotPasswordKey);
		if($user)
		{
			$emailAddress = $user->email;
			$id = $user->id;
			$checkValidURL = $this->auth->checkExpireTime($emailAddress,$forgotPasswordKey);
			if($checkValidURL)
			{
				if(isset($_POST) && !empty($_POST))
				{
					$this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[6]|max_length[15]');
				    $this->form_validation->set_rules('confirm_password', 'Re-Password', 'required|matches[new_password]');
				    if ($this->form_validation->run()) 
					{
						$password = $this->input->post('new_password');
						$salt = 'Ijxo1A16';
						$ency_password = md5(md5($password).md5($salt));
						$input = array();
						$input['password'] = $ency_password;
						$input['forgot_password_key'] = '';
						$input['expire_time'] = '';
						$this->auth->updateUserPassword($input,$id);
						$message = 'Password Successfully Updated.';
						$success = true;
						$output['redirectURL'] = site_url('admin/login');
 					}
					else
					{
						$success = false;
						$message = validation_errors();
					}
					$output['message'] = $message;
					$output['success'] = $success;
					echo json_encode($output);die;
				}	
				$this->load->view('admin/register/reset_password');
			}
			else
			{
				$output['message'] = 'Your reset password link is expired. Please change your password again.';
				$this->load->view('admin/register/errors',$output);
			}
		}
		else
		{
			$output['message'] = 'Your reset password link is expired. Please change your password again.';
			$this->load->view('admin/register/errors',$output);
		}		
	}
	
	function check_space($value)
    {
        if (!preg_match('/^[a-zA-Z0-9_@#$^&%*)(_+}{;:?\/., ]*$/', $value)) {
           $this->form_validation->set_message('check_space', 'The %s field should contain only letters');
           return false;
        }
        else
        return true;
    }
}