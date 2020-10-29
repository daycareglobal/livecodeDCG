<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Business_types extends CI_Controller {
	
	function __construct() {
		Parent::__construct();
		$this->common_model->checkAdminLogin();
		$this->load->model('admin/business_types_model', 'business_types');
	}

	function index()
	{   
		$output['page_title'] = 'Business Type';
		$output['left_menu'] = 'business_module';
		$output['left_submenu'] = 'business_type_list';
		$business_types = $this->business_types->getActiveRecords();

		foreach ($business_types as $key => $value) {
        	$value->add_date = $this->common_model->getGMTDateToLocalDate($value->add_date);
		}
        $output['records'] = $business_types;
		$this->load->view('admin/includes/header',$output);
		$this->load->view('admin/business_types/index');
		$this->load->view('admin/includes/footer');
	}

	function changeStatus()
	{
		$id = $this->input->get('id');
		$status = $this->input->get('status');
		$this->business_types->changeStatusById($id,$status);
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
				$this->business_types->changeStatusById($value,$task);			
				$message = 'Status of Selected records changed successfully.';
			}

			if ($task == 'Delete') {			
				// $this->business_types->delete($value);
				$input = array();
				$input['status'] = 'Inactive';
				$input['is_delete'] = 'Yes';
				$input['update_date'] = $this->common_model->getDefaultToGMTDate(time());
				$this->business_types->update_record($input, $value);
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
		$output['page_title'] = 'Business Type';
		$output['left_menu'] = 'business_module';
		$output['left_submenu'] = 'business_type_list';
		$output['task'] = 'add';
		$output['message'] = '';
		$output['status'] = 'Active';
		$output['id'] = '';
		$output['name'] = '';

        if (isset($_POST) && !empty($_POST)) {
			$success = true;

			$this->form_validation->set_rules('name', 'Business Type Name', 'trim|required|callback_check_space|is_unique[tbl_business_type.name]');
			
			if ($this->form_validation->run()) {
				$input = array();
				$input['name'] = $this->input->post('name');
				$input['add_date'] = $this->common_model->getDefaultToGMTDate(time());
				$business_type_id = $this->business_types->insert_record($input);
				
				if ($business_type_id) {
					$message = 'Record added successfully.';
					$success = true;
					$output['redirectURL'] = site_url('admin/business_types');
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
		$this->load->view('admin/business_types/form');
		$this->load->view('admin/includes/footer');
	}

	
	function update($id)
	{
		$record = $this->business_types->get_record_by_id($id);
		
		if (empty($record)) {
			echo "<center><h1>No record found.</h1></center>";die;
		}

		$output['page_title'] = 'Business Type';
		$output['left_menu'] = 'business_module';
		$output['left_submenu'] = 'business_type_list';
		$output['task'] = 'edit';
		$output['message'] = '';
		$output['status'] = '';
		$output['id'] = $record->id;
		$output['name'] = $record->name;

        if (isset($_POST) && !empty($_POST)) {
			$success = true;
			$this->form_validation->set_rules('name', 'Business Type Name', 'trim|required|callback_check_space|callback_check_name_exist['.$id.']');

			if ($this->form_validation->run()) {
				$input = array();
				$input['name'] = $this->input->post('name');
				$input['update_date'] = $this->common_model->getDefaultToGMTDate(time());
				$response = $this->business_types->update_record($input, $id);

				if ($response) {
					$message = 'Record updated successfully.';
					$success = true;
					$output['redirectURL'] = site_url('admin/business_types');

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
		$this->load->view('admin/business_types/form');
		$this->load->view('admin/includes/footer');
	}

	function delete()
	{   
		$id = $this->input->post('record_id');
		// $this->business_types->delete($id);
		$input = array();
		$input['status'] = 'Inactive';
		$input['is_delete'] = 'Yes';
		$input['update_date'] = $this->common_model->getDefaultToGMTDate(time());
		$this->business_types->update_record($input, $id);
		$data['success'] = true;
		$data['message'] = 'Record remove successfully.';
		$data['callBackFunction'] = 'callBackCommonDelete';
		echo json_encode($data); die;
	}

	/*function view($id) 
    {
        $record	= $this->business_types->get_record_by_id($id);

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

    function check_name_exist($value, $id = '')
    {
        if ($this->business_types->doesNameExist( $value, $id )) {
            $this->form_validation->set_message('check_name_exist', 'This Business Type Name already register on our server.');
            return false;
        }
        return true;
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