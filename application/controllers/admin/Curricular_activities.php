<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Curricular_activities extends CI_Controller {
	
	function __construct() {
		Parent::__construct();
		$this->common_model->checkAdminLogin();
		$this->load->model('admin/curricular_activities_model', 'curricular_activities');
	}

	function index()
	{   
		$output['page_title'] = 'Curricular Activities';
		$output['left_menu'] = 'curricular_activities_module';
		$output['left_submenu'] = 'curricular_activities_list';
		$curricular_activities = $this->curricular_activities->getActiveRecords();

		foreach ($curricular_activities as $key => $value) {
        	$value->add_date = $this->common_model->getGMTDateToLocalDate($value->add_date);
		}
        $output['records'] = $curricular_activities;
		$this->load->view('admin/includes/header',$output);
		$this->load->view('admin/curricular_activities/index');
		$this->load->view('admin/includes/footer');
	}

	function changeStatus()
	{
		$id = $this->input->get('id');
		$status = $this->input->get('status');
		$this->curricular_activities->changeStatusById($id,$status);
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
				$this->curricular_activities->changeStatusById($value,$task);			
				$message = 'Status of Selected records changed successfully.';
			}

			if ($task == 'Delete') {
				// $this->curricular_activities->delete($value);
				$input = array();
				$input['status'] = 'Inactive';
				$input['is_delete'] = 'Yes';
				$input['update_date'] = $this->common_model->getDefaultToGMTDate(time());
				$this->curricular_activities->update_record($input, $value);
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
		$output['page_title'] = 'Curricular Activities';
		$output['left_menu'] = 'curricular_activities_module';
		$output['left_submenu'] = 'curricular_activities_list';
		$output['task'] = 'add';
		$output['message'] = '';
		$output['status'] = 'Active';
		$output['id'] = '';
		$output['name'] = '';

        if (isset($_POST) && !empty($_POST)) {
			$success = true;

			$this->form_validation->set_rules('name', 'Activity Name', 'trim|required|callback_check_space|is_unique[tbl_carricular_activities.name]');
			
			if ($this->form_validation->run()) {
				$input = array();
				$input['name'] = $this->input->post('name');
				$input['add_date'] = $this->common_model->getDefaultToGMTDate(time());
				$activity_id = $this->curricular_activities->insert_record($input);
				
				if ($activity_id) {
					$message = 'Record added successfully.';
					$success = true;
					$output['redirectURL'] = site_url('admin/curricular_activities');
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
		$this->load->view('admin/curricular_activities/form');
		$this->load->view('admin/includes/footer');
	}

	
	function update($id)
	{
		$record = $this->curricular_activities->get_record_by_id($id);
		
		if (empty($record)) {
			echo "<center><h1>No record found.</h1></center>";die;
		}

		$output['page_title'] = 'Curricular Activities';
		$output['left_menu'] = 'curricular_activities_module';
		$output['left_submenu'] = 'curricular_activities_list';
		$output['task'] = 'edit';
		$output['message'] = '';
		$output['status'] = '';
		$output['id'] = $record->id;
		$output['name'] = $record->name;

        if (isset($_POST) && !empty($_POST)) {
			$success = true;
			$this->form_validation->set_rules('name', 'Activity Name', 'trim|required|callback_check_space|callback_check_name_exist['.$id.']');

			if ($this->form_validation->run()) {
				$input = array();
				$input['name'] = $this->input->post('name');
				$input['update_date'] = $this->common_model->getDefaultToGMTDate(time());
				$response = $this->curricular_activities->update_record($input, $id);

				if ($response) {
					$message = 'Record updated successfully.';
					$success = true;
					$output['redirectURL'] = site_url('admin/curricular_activities');

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
		$this->load->view('admin/curricular_activities/form');
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
		$this->curricular_activities->update_record($input, $id);
		$data['success'] = true;
		$data['message'] = 'Record deleted successfully.';
		$data['callBackFunction'] = 'callBackCommonDelete';
		echo json_encode($data); die;
	}

	/*function view($id) 
    {
        $record	= $this->curricular_activities->get_record_by_id($id);

        $output = array();
		$output['page_title'] = 'Special Education Management';
		$output['left_menu'] = 'curricular_activities';
		$output['left_submenu'] = 'special_education_list';

		if ($record) {
        	$record->add_date = $this->common_model->getGMTDateToLocalDate($record->add_date);
        	$output['record'] = $record;
		}
        $this->load->view('admin/includes/header',$output);
		$this->load->view('admin/curricular_activities/view');
		$this->load->view('admin/includes/footer');
    }*/

    function request() {
       	$output['page_title'] = 'Curricular Activities';
		$output['left_menu'] = 'curricular_activities_module';
		$output['left_submenu'] = 'curricular_activities_request_list';
		$records = $this->curricular_activities->get_activity_request();
		//pr($records);die;


		foreach ($records as $key => $value) {
        	$value->add_date = $this->common_model->getGMTDateToLocalDate($value->add_date);
		}
	    $output['requests'] = $records;
        $this->load->view('admin/includes/header',$output);
		$this->load->view('admin/curricular_activities/request');
		$this->load->view('admin/includes/footer');
	}

	function add_request() {
	
        if (isset($_POST) && !empty($_POST)) {
			$success = true;

			$this->form_validation->set_rules('activity_name', 'activity name', 'trim|required|callback_check_space|is_unique[tbl_carricular_activities.name]');
			
			if ($this->form_validation->run()) {
				$input = array();
				$input['name'] = $this->input->post('activity_name');
				$input['add_date'] = $this->common_model->getDefaultToGMTDate(time());
				$insert_id = $this->curricular_activities->insert_record($input);
				
				if ($insert_id) {
					$record_id = $this->input->post('record_id');
					$user_service_detail_id = $this->input->post('user_service_detail_id');
					$this->curricular_activities->delete_request($record_id);
					$add_request = array();
					$add_request['user_service_detail_id'] = $this->input->post('user_service_detail_id');
					$add_request['curricular_activity_id'] = $insert_id;
					$this->curricular_activities->add_request($add_request);
					$message = 'Session added successfully.';
					$success = true;
					$data['redirectURL'] = site_url('admin/curricular_activities');
				
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
        if ($this->curricular_activities->doesNameExist( $value, $id )) {
            $this->form_validation->set_message('check_name_exist', 'This Activity Name already register on our server.');
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