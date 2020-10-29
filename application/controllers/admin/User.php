<?php
/**
* User controller for Admin
*/
if(!defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
	
	function __construct() {
		Parent::__construct();
		$this->common_model->checkAdminLogin();
		$this->common_model->checkLoginAdminStatus();
		$this->load->model('admin/member_model', 'members');
		$this->load->model('mailsending_model', 'mailsend');
		// $this->load->model('admin/permission_model', 'permission');
	}

	function updateProfile() 
	{
		$output['page_title'] = 'Update Admin Profile';
		$output['left_menu'] = 'Admin';
		$output['message'] ='';
		$output['left_menu'] ='';
		
		$userId = $this->session->userdata('admin_id');
		$user = $this->members->get_user_by_id($userId);
		if(isset($_POST) && !empty($_POST))
		{
			$this->form_validation->set_rules('name', 'Full Name', 'trim|required|regex_match[/^[-A-Za-z0-9_ ]+$/]|max_length[50]');
			$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
			if ($this->form_validation->run()) 
			{
				if(!$this->members->checkEmailAddressUnique($this->input->post('email'),$userId))
				{
					if(!$this->members->checkUsernameUnique($this->input->post('name'),$userId))
					{
						$input = array();
						$input['name'] = $this->input->post('name');
						$input['email'] = $this->input->post('email');
						$this->members->update_user_by_id($userId, $input);
						$this->session->set_userdata(array('name' => $this->input->post('name')));
						$message = 'Record Updated Successfully';
						$success = true;
						$output['redirectURL'] = site_url('admin');
					}
					else
					{
						$message = 'Username field must contain a unique value.';
						$success = false;
					}					
				}
				else
				{
					$message = 'The Email field must contain a unique value.';
					$success = false;
				}
				
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
		$output['name'] = $user->name;
		$output['email'] = $user->email;
		$this->load->view('admin/includes/header',$output);
		$this->load->view('admin/members/update_profile');
		$this->load->view('admin/includes/footer');
	}

	function changePasswordForAdmin() {
		$output['page_title'] = 'Change Password';
		$output['message'] ='';
		$output['left_menu'] ='';
		if(isset($_POST) && !empty($_POST))
		{
			$this->form_validation->set_rules('current_password', 'Current Password', 'trim|required');
			$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|matches[re_new_password]|min_length[6]|max_length[15]');
			$this->form_validation->set_rules('re_new_password', 'Confirmation Password', 'trim|required|min_length[6]|max_length[15]');

			if ($this->form_validation->run()) 
			{
				$password = $this->input->post('current_password');
				$salt = 'Ijxo1A16';
				$ency_password = md5(md5($password).md5($salt));
				$userId = $this->session->userdata('admin_id');
				$user = $this->members->checkUserExistByOldPassword($ency_password,$userId);

				if($user)
				{
					$newPassword = $this->input->post('new_password');
					$salt = 'Ijxo1A16';
					$encyPassword = md5(md5($newPassword).md5($salt));
					$input = array();
					$input['password'] = $encyPassword;
					$this->members->update_user_by_id($userId, $input);
					$message = 'Password updated successfully';
					$success = true;
					$output['redirectURL'] = site_url('admin');
				}
				else
				{
					$message = 'Current Password Incorrect';
					$success = false;
				}
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
		$this->load->view('admin/includes/header',$output);
		$this->load->view('admin/members/change_password');
		$this->load->view('admin/includes/footer');
	}	

}