<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Faq extends CI_Controller {
	
	function __construct() {
		Parent::__construct();
		$this->common_model->checkAdminLogin();
		$this->load->model('admin/faq_model', 'faq');
	}

	function index()
	{   
		$output['page_title'] = 'Static Contents';
		$output['left_menu'] = 'Content_management';
		$output['left_submenu'] = 'faq_list';
		$faq_list = $this->faq->get_records();

		foreach ($faq_list as $key => $value) {
        	$value->add_date = $this->common_model->getGMTDateToLocalDate($value->add_date);
		}
        $output['records'] = $faq_list;
		$this->load->view('admin/includes/header',$output);
		$this->load->view('admin/faq/index');
		$this->load->view('admin/includes/footer');
	}

	function changeStatus()
	{
		$id = $this->input->get('id');
		$status = $this->input->get('status');
		$this->faq->changeStatusById($id,$status);
		$data['success'] = true;
		$data['message'] = 'Record updated Successfully';
		echo json_encode($data);
	}

	function multiTaskOperation()
	{
		$task = $this->input->post('task');
		$ids = $this->input->post('ids');
		$dataIds = explode(',', $ids);

		foreach ($dataIds as $key => $value) {

			if ($task=='Active' || $task=='Inactive') {
				$this->faq->changeStatusById($value,$task);			
				$message = 'Status of Selected records changed successfully.';
			}

			if ($task == 'Delete') {			
				$this->faq->delete($value);
				/*$input = array();
				$input['status'] = 'Inactive';
				$input['is_delete'] = 'Yes';
				$input['update_date'] = $this->common_model->getDefaultToGMTDate(time());
				$this->faq->update_record($input, $value);*/
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
		$output['page_title'] = 'Static Contents';
		$output['left_menu'] = 'Content_management';
		$output['left_submenu'] = 'faq_list';
		$output['task'] = 'add';
		$output['message'] = '';
		$output['status'] = 'Active';
		$output['id'] = '';
		$output['question'] = '';
		$output['answer'] = '';

        if (isset($_POST) && !empty($_POST)) {
			$success = true;

			$this->form_validation->set_rules('question', 'Question', 'trim|required|callback_check_space');
			$this->form_validation->set_rules('answer', 'Answer', 'trim|required|callback_check_space');
			
			if ($this->form_validation->run()) {
				$input = array();
				$input['question'] = $this->input->post('question');
				$input['answer'] = $this->input->post('answer');
				$input['add_date'] = $this->common_model->getDefaultToGMTDate(time());
				$faq_id = $this->faq->insert_record($input);
				
				if ($faq_id) {
					$message = 'Record added successfully.';
					$success = true;
					$output['redirectURL'] = site_url('admin/faq');
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
		$this->load->view('admin/faq/form');
		$this->load->view('admin/includes/footer');
	}

	
	function update($id)
	{
		$record = $this->faq->get_record_by_id($id);
		
		if (empty($record)) {
			echo "<center><h1>No record found.</h1></center>";die;
		}

		$output['page_title'] = 'Static Contents';
		$output['left_menu'] = 'Content_management';
		$output['left_submenu'] = 'faq_list';
		$output['task'] = 'edit';
		$output['message'] = '';
		$output['status'] = '';
		$output['id'] = $record->id;
		$output['question'] = $record->question;
		$output['answer'] = $record->answer;

        if (isset($_POST) && !empty($_POST)) {
			$success = true;
			$this->form_validation->set_rules('question', 'Question', 'trim|required|callback_check_space');
			$this->form_validation->set_rules('answer', 'Answer', 'trim|required|callback_check_space');

			if ($this->form_validation->run()) {
				$input = array();
				$input['question'] = $this->input->post('question');
				$input['answer'] = $this->input->post('answer');
				$input['update_date'] = $this->common_model->getDefaultToGMTDate(time());
				$response = $this->faq->update_record($input, $id);

				if ($response) {
					$message = 'Record updated successfully.';
					$success = true;
					$output['redirectURL'] = site_url('admin/faq');

				} else {
					$message = 'Technical error, Please try again.';
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

		$this->load->view('admin/includes/header',$output);
		$this->load->view('admin/faq/form');
		$this->load->view('admin/includes/footer');
	}

	function delete()
	{   
		$id = $this->input->post('record_id');
		$this->faq->delete($id);
		// $input = array();
		// $input['status'] = 'Inactive';
		// $input['is_delete'] = 'Yes';
		// $input['update_date'] = $this->common_model->getDefaultToGMTDate(time());
		// $this->faq->update_record($input, $id);
		$data['success'] = true;
		$data['message'] = 'Record remove successfully.';
		$data['callBackFunction'] = 'callBackCommonDelete';
		echo json_encode($data); die;
	}

	/*function view($id) 
    {
        $record	= $this->faq->get_record_by_id($id);

        $output = array();
		$output['page_title'] = 'Business Type';
		$output['left_menu'] = 'business_module';
		$output['left_submenu'] = 'business_type_list';

		if ($record) {
        	$record->add_date = $this->common_model->getGMTDateToLocalDate($record->add_date);
        	$output['record'] = $record;
		}
        $this->load->view('admin/includes/header',$output);
		$this->load->view('admin/business_types/view');
		$this->load->view('admin/includes/footer');
    }*/

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