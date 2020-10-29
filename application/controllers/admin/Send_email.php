<?php

if(!defined('BASEPATH')) exit('No direct script access allowed');

class Send_email extends CI_Controller {
	
	function __construct() {
		Parent::__construct();
		$this->common_model->checkAdminLogin();
		$this->common_model->checkLoginAdminStatus();
		$this->load->model('admin/send_email_model', 'send_email');
		$this->load->model('admin/user_model', 'users');
		$this->load->model('Mailsending_model', 'mailsend');
	}

	function index()
	{
		$output['page_title'] = 'List of Templates';
		$output['left_menu'] = 'send_email_module';
		$output['left_submenu'] = 'templates_list';
		$templates = $this->send_email->getAllTemplates();

		$output['templates'] = $templates;
		$this->load->view('admin/includes/header',$output);
		$this->load->view('admin/send_email/templates_list');
		$this->load->view('admin/includes/footer');
	}

	function email_sent_list()
	{
		$output['page_title'] = 'List of Templates';
		$output['left_menu'] = 'send_email_module';
		$output['left_submenu'] = 'email_sent_list';
		$email_sent_users = $this->send_email->getSentTemplates();

		$output['records'] = $email_sent_users;
		$this->load->view('admin/includes/header',$output);
		$this->load->view('admin/send_email/email_sent_list');
		$this->load->view('admin/includes/footer');
	}

	function email_notification()
	{
		$output['page_title'] = 'Send Email Notification';
		$output['left_menu'] = 'send_email_module';
		$output['left_submenu'] = 'email_sent_list';
		$output['message'] = '';
		$output['id'] = '';
		$output['users_list'] = $this->users->getActiveRecords('User');
		$output['templates_list'] = $this->send_email->getAllTemplates('Active');

		if (isset($_POST) && !empty($_POST)) {
			$this->form_validation->set_rules('email_template_id', 'Template Name', 'trim|required');			
			$this->form_validation->set_rules('user_id[]', 'User Name', 'trim|required');

			if ($this->form_validation->run()) {
				$user_id = $this->input->post('user_id');

				foreach ($user_id as $key => $value) {

                    if (!empty($value)) {
                        $insert_data[$key]['user_id'] = $value;
                        $insert_data[$key]['email_template_id'] = $this->input->post('email_template_id');
                        $insert_data[$key]['add_date'] = $this->common_model->getDefaultToGMTDate(time());

                        $this->mailsend->send_email_notification($value, $this->input->post('email_template_id'));
                    }
                }

				$this->send_email->insert_sent_email_record($insert_data);

				$message = 'Record Added Successfully';
				$success = true;
				$output['redirectURL'] = site_url('admin/send_email/email_sent_list');

			} else {
				$success = false;
				$message = validation_errors();
			}

			$output['message'] = $message;
			$output['success'] = $success;
			echo json_encode($output);die;
		}

		$this->load->view('admin/includes/header',$output);
		$this->load->view('admin/send_email/email_notification_form');
		$this->load->view('admin/includes/footer');
	}

	function changeStatus() {
		$id = $this->input->get('id');
		$status = $this->input->get('status');
		$this->send_email->changeStatusById($id,$status);
		$data['success'] = true;
		$data['message'] = 'Record updated Successfully';
		echo json_encode($data);
	} 	

	function multiTaskOperation() {
		$task = $this->input->post('task');
		$ids = $this->input->post('ids');
		$dataIds = explode(',', $ids);

		foreach ($dataIds as $key => $value) {

			if ($task == 'Active' || $task == 'Inactive') {
				$this->send_email->changeStatusById($value, $task);			
				$message = 'Status of Selected records changed successfully.';
			}

			if ($task == 'Delete') {
				// $this->curricular_activities->delete($value);
				$input = array();
				$input['status'] = 'Inactive';
				$input['is_delete'] = 'Yes';
				$input['update_date'] = $this->common_model->getDefaultToGMTDate(time());
				$this->send_email->updateEmailTemplate($value, $input);
				$message = 'Selected Record Remove Successfully.';
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
		$output['page_title'] = 'Add Email Template';
		$output['left_menu'] = 'send_email_module';
		$output['left_submenu'] = 'templates_list';
		$output['message'] = '';
		$output['subject'] = '';
		$output['content'] = '';
		$output['name'] = '';
		$output['id'] = '';

		if (isset($_POST) && !empty($_POST)) {
			$this->form_validation->set_rules('name', 'Template Name', 'trim|required');			
			$this->form_validation->set_rules('subject', 'Subject', 'trim|required');
			$this->form_validation->set_rules('content', 'Content', 'trim|required');

			if ($this->form_validation->run()) {
				$input = array();
				$input['name'] = $this->input->post('name');
				$input['subject'] = $this->input->post('subject');
				$input['content'] = $this->input->post('content');
				$input['add_date'] = $this->common_model->getDefaultToGMTDate(time());
				$this->send_email->insert_record($input);

				$message = 'Record Added Successfully';
				$success = true;
				$output['redirectURL'] = site_url('admin/send_email');

			} else {
				$success = false;
				$message = validation_errors();
			}

			$output['message'] = $message;
			$output['success'] = $success;
			echo json_encode($output);die;
		}

		$this->load->view('admin/includes/header',$output);
		$this->load->view('admin/send_email/add_form');
		$this->load->view('admin/includes/footer');
	}

	function update($id)
	{
		$emailTemplate = $this->send_email->getSingleTemplateById($id);

		if (empty($emailTemplate)) {
			echo "<center><h1>No record found.</h1></center>";die;
		}
		$output['page_title'] = 'Update Email Template';
		$output['left_menu'] = 'send_email_module';
		$output['left_submenu'] = 'templates_list';
		$output['message'] ='';
		$output['subject'] = $emailTemplate->subject; 
		$output['content'] = $emailTemplate->content;
		$output['name'] = $emailTemplate->name;
		$output['id'] = $id;

		if (isset($_POST) && !empty($_POST)) {	
			$this->form_validation->set_rules('name', 'Template Name', 'trim|required');			
			$this->form_validation->set_rules('subject', 'Subject', 'trim|required');
			$this->form_validation->set_rules('content', 'Content', 'trim|required');
			
			if ($this->form_validation->run()) {
				$input = array();
				$input['name'] = $this->input->post('name');
				$input['subject'] = $this->input->post('subject');
				$input['content'] = $this->input->post('content');
				$this->send_email->updateEmailTemplate($id, $input);

				$message = 'Record Updated Successfully';
				$success = true;
				$output['redirectURL'] = site_url('admin/send_email');

			} else {
				$success = false;
				$message = validation_errors();
			}

			$output['message'] = $message;
			$output['success'] = $success;
			echo json_encode($output);die;
		}

		$this->load->view('admin/includes/header',$output);
		$this->load->view('admin/send_email/add_form');
		$this->load->view('admin/includes/footer');
	}

	function delete()
	{   
		$id = $this->input->post('record_id');
		// $this->curricular_activities->delete($id);
		$input = array();
		$input['status'] = 'Inactive';
		$input['is_delete'] = 'Yes';
		$input['update_date'] = $this->common_model->getDefaultToGMTDate(time());
		$this->send_email->updateEmailTemplate($id, $input);
		$data['success'] = true;
		$data['message'] = 'Record deleted successfully.';
		$data['callBackFunction'] = 'callBackCommonDelete';
		echo json_encode($data); die;
	}	
}