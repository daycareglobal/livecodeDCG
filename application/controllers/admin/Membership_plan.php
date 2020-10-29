<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Membership_plan extends CI_Controller {
	
	function __construct() {
		Parent::__construct();
		$this->common_model->checkAdminLogin();
		$this->load->model('admin/membership_plan_model', 'membership_plan');
	}

	function index()
	{   
		$output['page_title'] = 'Membership Plan';
		$output['left_menu'] = 'membership_plan_module';
		$output['left_submenu'] = 'membership_plan_list';
		$membership_plan = $this->membership_plan->getRecords();

		foreach ($membership_plan as $key => $value) {
        	$value->add_date = $this->common_model->getGMTDateToLocalDate($value->add_date);
		}
        $output['records'] = $membership_plan;
		$this->load->view('admin/includes/header',$output);
		$this->load->view('admin/membership_plan/index');
		$this->load->view('admin/includes/footer');
	}

	function changeStatus()
	{
		$id = $this->input->get('id');
		$status = $this->input->get('status');
		$this->membership_plan->changeStatusById($id,$status);
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
				$this->membership_plan->changeStatusById($value,$task);			
				$message = 'Status of Selected records changed successfully.';
			}

			if ($task == 'Delete') {			
				$this->membership_plan->delete($value);
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
		$output['page_title'] = 'Membership Plan';
		$output['left_menu'] = 'membership_plan_module';
		$output['left_submenu'] = 'membership_plan_list';
		$output['task'] = 'add';
		$output['message'] = '';
		$output['status'] = 'Active';
		$output['id'] = '';
		$output['plan_name'] = '';
		$output['provision_allowed'] = '';
		$output['plan_type'] = '';
		$output['month'] = '';
		$output['price'] = '';
		$output['annual_discount'] = '';

        if (isset($_POST) && !empty($_POST)) {
			$success = true;

			$this->form_validation->set_rules('plan_name', 'Plan Name', 'trim|required|callback_check_space|is_unique[tbl_membership_plan.plan_name]');
			$this->form_validation->set_rules('plan_type', 'Plan Type', 'trim|required');

			if ($this->input->post('plan_type') == 'Free') {
				$this->form_validation->set_rules('month', 'Month', 'trim|required|integer');

			} else {
				$this->form_validation->set_rules('price', 'Price', 'trim|required|numeric');
				$this->form_validation->set_rules('annual_discount', 'Annual Discount', 'trim|required|numeric');
			}

			$this->form_validation->set_rules('provision_allowed', 'provision', 'trim|required|integer');
			
			if ($this->form_validation->run()) {
				$input = array();
				$input['plan_name'] = $this->input->post('plan_name');
				$input['plan_type'] = $this->input->post('plan_type');
				$input['provision_allowed'] = $this->input->post('provision_allowed');

				if ($this->input->post('plan_type') == 'Free') {
					$input['month'] = $this->input->post('month');

				} else {
					$input['price'] = $this->input->post('price');
					$input['annual_discount'] = $this->input->post('annual_discount');					
				}

				$input['add_date'] = $this->common_model->getDefaultToGMTDate(time());
				$activity_id = $this->membership_plan->insert_record($input);
				
				if ($activity_id) {
					$message = 'Record added successfully.';
					$success = true;
					$output['redirectURL'] = site_url('admin/membership_plan');
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
		$this->load->view('admin/membership_plan/form');
		$this->load->view('admin/includes/footer');
	}

	
	function update($id)
	{
		$record = $this->membership_plan->get_record_by_id($id);
		
		if (empty($record)) {
			echo "<center><h1>No record found.</h1></center>";die;
		}

		$output['page_title'] = 'Membership Plan';
		$output['left_menu'] = 'membership_plan_module';
		$output['left_submenu'] = 'membership_plan_list';
		$output['task'] = 'edit';
		$output['message'] = '';
		$output['status'] = '';
		$output['id'] = $record->id;
		$output['plan_name'] = $record->plan_name;
		$output['plan_type'] = $record->plan_type;
		$output['provision_allowed'] = $record->provision_allowed;
		$output['month'] = $record->month;
		$output['price'] = $record->price;
		$output['annual_discount'] = $record->annual_discount;

        if (isset($_POST) && !empty($_POST)) {
			$success = true;
			$this->form_validation->set_rules('plan_name', 'Plan Name', 'trim|required|callback_check_space|callback_check_name_exist['.$id.']');
			$this->form_validation->set_rules('plan_type', 'Plan Type', 'trim|required');

			if ($this->input->post('plan_type') == 'Free') {
				$this->form_validation->set_rules('month', 'Month', 'trim|required|integer');

			} else {
				$this->form_validation->set_rules('price', 'Price', 'trim|required|numeric');
				$this->form_validation->set_rules('annual_discount', 'Annual Discount', 'trim|required|numeric');
			}

			$this->form_validation->set_rules('provision_allowed', 'provision', 'trim|required|integer');

			if ($this->form_validation->run()) {
				$input = array();
				$input['plan_name'] = $this->input->post('plan_name');
				$input['plan_type'] = $this->input->post('plan_type');
				$input['provision_allowed'] = $this->input->post('provision_allowed');

				if ($this->input->post('plan_type') == 'Free') {
					$input['month'] = $this->input->post('month');
					$input['price'] = NULL;
					$input['annual_discount'] = NULL;

				} else {
					$input['month'] = NULL;
					$input['price'] = $this->input->post('price');
					$input['annual_discount'] = $this->input->post('annual_discount');					
				}

				$input['update_date'] = $this->common_model->getDefaultToGMTDate(time());
				$response = $this->membership_plan->update_record($input, $id);

				if ($response) {
					$message = 'Record updated successfully.';
					$success = true;
					$output['redirectURL'] = site_url('admin/membership_plan');

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
		$this->load->view('admin/membership_plan/form');
		$this->load->view('admin/includes/footer');
	}

	function delete()
	{   
		$id = $this->input->post('record_id');
		$this->membership_plan->delete($id);
		$data['success'] = true;
		$data['message'] = 'Record deleted successfully.';
		$data['callBackFunction'] = 'callBackCommonDelete';
		echo json_encode($data); die;
	}

	/*function view($id) 
    {
        $record	= $this->membership_plan->get_record_by_id($id);

        $output = array();
		$output['page_title'] = 'Membership Plan';
		$output['left_menu'] = 'membership_plan_module';
		$output['left_submenu'] = 'membership_plan_list';

		if ($record) {
        	$record->add_date = $this->common_model->getGMTDateToLocalDate($record->add_date);
        	$output['record'] = $record;
		}
        $this->load->view('admin/includes/header',$output);
		$this->load->view('admin/membership_plan/view');
		$this->load->view('admin/includes/footer');
    }*/

    function check_name_exist($value, $id = '')
    {
        if ($this->membership_plan->doesNameExist( $value, $id )) {
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