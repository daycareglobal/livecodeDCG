<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Special_education extends CI_Controller {
	
	function __construct() {
		Parent::__construct();
		$this->common_model->checkAdminLogin();
		$this->load->model('admin/special_education_model', 'special_education');
	}

	function index()
	{   
		$output['page_title'] = 'Special Education';
		$output['left_menu'] = 'special_education_module';
		$output['left_submenu'] = 'special_education_list';

		$special_education = $this->special_education->getActiveRecords();

		foreach ($special_education as $key => $value) {
        	$value->add_date = $this->common_model->getGMTDateToLocalDate($value->add_date);
		}
        
        $output['records'] = $special_education;
		$this->load->view('admin/includes/header',$output);
		$this->load->view('admin/special_education/index');
		$this->load->view('admin/includes/footer');
	}

	function changeStatus()
	{
		$id = $this->input->get('id');
		$status = $this->input->get('status');
		$this->special_education->changeStatusById($id,$status);
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
				$this->special_education->changeStatusById($value,$task);			
				$message = 'Status of Selected records changed successfully.';
			}

			if ($task == 'Delete') {			
				// $this->special_education->delete($value);
				$input = array();
				$input['status'] = 'Inactive';
				$input['is_delete'] = 'Yes';
				$input['update_date'] = $this->common_model->getDefaultToGMTDate(time());
				$this->special_education->update_record($input, $value);
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
		$output['page_title'] = 'Special Education';
		$output['left_menu'] = 'special_education_module';
		$output['left_submenu'] = 'special_education_list';
		$output['task'] = 'add';
		$output['message'] = '';
		$output['status'] = 'Active';
		$output['id'] = '';
		$output['name'] = '';

        if (isset($_POST) && !empty($_POST)) {
			$success = true;

			$this->form_validation->set_rules('name', 'Education Name', 'trim|required|callback_check_space|is_unique[tbl_special_education.name]');
			
			if ($this->form_validation->run()) {
				$input = array();
				$input['name'] = $this->input->post('name');
				$input['add_date'] = $this->common_model->getDefaultToGMTDate(time());
				$school_id = $this->special_education->insert_record($input);
				
				if ($school_id) {
					$message = 'Record added successfully.';
					$success = true;
					$output['redirectURL'] = site_url('admin/special_education');
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
		$this->load->view('admin/special_education/form');
		$this->load->view('admin/includes/footer');
	}

	
	function update($id)
	{
		$record = $this->special_education->get_record_by_id($id);
		
		if (empty($record)) {
			echo "<center><h1>No record found.</h1></center>";die;
		}
		
		$output['page_title'] = 'Special Education';
		$output['left_menu'] = 'special_education_module';
		$output['left_submenu'] = 'special_education_list';
		$output['task'] = 'edit';
		$output['message'] = '';
		$output['status'] = '';
		$output['id'] = $record->id;
		$output['name'] = $record->name;
		

        if (isset($_POST) && !empty($_POST)) {
			$success = true;

			$this->form_validation->set_rules('name', 'Education Name', 'trim|required|callback_check_space|callback_check_name_exist['.$id.']');
			
			if ($this->form_validation->run()) {
				$input = array();
				$input['name'] = $this->input->post('name');
				$input['update_date'] = $this->common_model->getDefaultToGMTDate(time());
				$response = $this->special_education->update_record($input, $id);

				if ($response) {
					$message = 'Record updated successfully.';
					$success = true;
					$output['redirectURL'] = site_url('admin/special_education');

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
		$this->load->view('admin/special_education/form');
		$this->load->view('admin/includes/footer');
	}
	
	function delete()
	{   
		$id = $this->input->post('record_id');
		$input = array();
		$input['status'] = 'Inactive';
		$input['is_delete'] = 'Yes';
		$input['update_date'] = $this->common_model->getDefaultToGMTDate(time());
		$this->special_education->update_record($input, $id);
		$data['success'] = true;
		$data['message'] = 'Record deleted successfully.';
		$data['callBackFunction'] = 'callBackCommonDelete';
		echo json_encode($data); die;
	}

    function request() {
        $output['page_title'] = 'Special Education';
		$output['left_menu'] = 'special_education_module';
		$output['left_submenu'] = 'special_education_request_list';
		$records = $this->special_education->get_special_education_request();

		foreach ($records as $key => $value) {
        	$value->add_date = $this->common_model->getGMTDateToLocalDate($value->add_date);
		}
	    $output['requests'] = $records;
        $this->load->view('admin/includes/header',$output);
		$this->load->view('admin/special_education/special_education_request');
		$this->load->view('admin/includes/footer');
	}

	function add_request() {
	
        if (isset($_POST) && !empty($_POST)) {
			$success = true;

			$this->form_validation->set_rules('education_name', 'session name', 'trim|required|callback_check_space|is_unique[tbl_special_education.name]');
			
			if ($this->form_validation->run()) {
				$input = array();
				$input['name'] = $this->input->post('education_name');
				$input['add_date'] = $this->common_model->getDefaultToGMTDate(time());
				$insert_id = $this->special_education->insert_record($input);
				
				if ($insert_id) {
					$record_id = $this->input->post('record_id');
					$user_service_detail_id = $this->input->post('user_service_detail_id');
					$this->special_education->delete_request($record_id);
					$add_request = array();
					$add_request['user_service_detail_id'] = $this->input->post('user_service_detail_id');
					$add_request['special_education_id'] = $insert_id;
					$this->special_education->add_request($add_request);
					$message = 'Session added successfully.';
					$success = true;
					$data['redirectURL'] = site_url('admin/special_education');
				
				} else {
					$message = 'Technical error. PLease try again';
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

    function check_name_exist($value, $id = '')
    {
        if ($this->special_education->doesNameExist( $value, $id )) {
            $this->form_validation->set_message('check_name_exist', 'This Education Name already register on our server.');
            return false;
        }
        return true;
    }

    function check_space($value)
    {
        if ( ! preg_match("/^[a-zA-Z0-9_@#$^&%*)(_+}{;:?\/., -]*$/", $value) ) {
           $this->form_validation->set_message('check_space', 'The %s field should contain only letters, numbers or periods');
           return false;
        }
        else
        return true;
    }
}