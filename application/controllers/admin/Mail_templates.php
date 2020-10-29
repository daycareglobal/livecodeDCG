<?php

if(!defined('BASEPATH')) exit('No direct script access allowed');

class Mail_templates extends CI_Controller {
	
	function __construct() {
		Parent::__construct();
		$this->common_model->checkAdminLogin();
		$this->common_model->checkLoginAdminStatus();
		$this->load->model('admin/mail_templates_model', 'mail_templates');
	}

	function index()
	{
		$output['page_title'] = 'List of Email Templates';
		$output['left_menu'] = 'Mail_templates';
		$output['left_submenu'] = 'List_templates';
		$templates = $this->mail_templates->getAllTemplates();
		$output['templates'] = $templates;
		$this->load->view('admin/includes/header',$output);
		$this->load->view('admin/mail_templates/mail_templates_list');
		$this->load->view('admin/includes/footer');
	}

	function changeStatus() {
		$id = $this->input->get('id');
		$status = $this->input->get('status');
		$this->mail_templates->changeStatusById($id,$status);
		$data['success'] = true;
		$data['message'] = 'Record updated Successfully';
		echo json_encode($data);
	} 	

	function multiTaskOperation() {
		$task = $this->input->post('task');
		$ids = $this->input->post('ids');
		$dataIds = explode(',',$ids);
		foreach ($dataIds as $key => $value) 
		{
			if($task=='Active' || $task=='Inactive')
			{
				$this->mail_templates->changeStatusById($value,$task);			
				$message = 'Status of Selected records changed successfully.';
			}
		}		
		$data['ids'] = $ids;
		$data['success'] = true;
		$data['message'] = $message;
		$data['callBackFunction'] = 'callBackCommonDelete';
		echo json_encode($data); die;
	}

	function update($id)
	{
		$output['page_title'] = 'Update Email Template';
		$output['left_menu'] = 'Mail_templates';
		$output['left_submenu'] = 'List_templates';
		$output['message'] ='';
		$emailTemplate = $this->mail_templates->getSingleTemplateById($id);
		$output['subject'] = $emailTemplate->subject; 
		$output['content'] = $emailTemplate->content;
		$output['name'] = $emailTemplate->name;
		if(isset($_POST) && !empty($_POST))
		{	
			$this->form_validation->set_rules('name', 'Template Name', 'trim|required');			
			$this->form_validation->set_rules('subject', 'Subject', 'trim|required');
			$this->form_validation->set_rules('content', 'Content', 'trim|required');
			if($this->form_validation->run())
			{
				$input = array();
				$input['name'] = $this->input->post('name');
				$input['subject'] = $this->input->post('subject');
				$input['content'] = $this->input->post('content');
				$this->mail_templates->updateEmailTemplate($id, $input);
				$message = 'Record Updated Successfully';
				$success = true;
				$output['redirectURL'] = site_url('admin/mail_templates');
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
		$constants = array();
		$constantsB = explode(',',$emailTemplate->constants);
		foreach ($constantsB as $key => $value) 
		{
			$constants[$value] = '{{'.$value.'}}';
		}
		$output['constants'] = $constants;
		$output['id'] = $id;
		$this->load->view('admin/includes/header',$output);
		$this->load->view('admin/mail_templates/add_form');
		$this->load->view('admin/includes/footer');

	}
	
}