<?php
/**
* Country controller for Admin
*/
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Country extends CI_Controller {
	
	function __construct() {
		Parent::__construct();
		$this->common_model->checkAdminLogin();
		$this->common_model->checkLoginAdminStatus();
		$this->load->model('admin/Country_model', 'country');
	}	

	function index() {
		$output['page_title'] = 'Country Management';
		$output['left_menu'] = 'Country';
		$allCountries = $this->country->getAllCountries();
		$output['allCountries'] = $allCountries;
		$this->load->view('admin/includes/header',$output);
		$this->load->view('admin/country/country_list');
		$this->load->view('admin/includes/footer');
	}	

	function changeStatus() {
		$id = $this->input->get('id');
		$status = $this->input->get('status');
		$this->country->changeStatusByID($id, $status);
		$data['success'] = true;
		$data['message'] = 'Record updated Successfully';
		echo json_encode($data);
	}

	function delete() {
		$id = $this->input->post('record_id');
		$this->country->deleteCountryRecordByID($id);
		$data['success'] = true;
		$data['message'] = 'Record Deleted Successfully';
		$data['callBackFunction'] = 'callBackCommonDelete';
		echo json_encode($data); die;
	}

	function multiTaskOperation() {
		$task = $this->input->post('task');
		$ids = $this->input->post('ids');
		$dataIds = explode(',',$ids);
		foreach ($dataIds as $key => $value) 
		{
			if($task == 'Delete')
			{
				$this->country->deleteCountryRecordByID($value);
				$message = 'Selected record deleted successfully.';
			}
			else if($task=='Active' || $task=='Inactive')
			{
				$this->country->changeStatusByID($value,$task);			
				$message = 'Status of Selected records changed successfully.';
			}
		}		
		$data['ids'] = $ids;
		$data['success'] = true;
		$data['message'] = $message;
		$data['callBackFunction'] = 'callBackCommonDelete';
		echo json_encode($data); die;
	}

	function add() {
		$output['page_title'] = 'Add New Country';
		$output['left_menu'] = 'Country';
		$output['message']    = '';
		$output['id'] = '';
		$output['name'] = '';	
		$output['sortname'] = '';	
		$output['phonecode'] = '';	
		$output['status'] = 'Active';		
		if(isset($_POST) && !empty($_POST))
		{
			$this->form_validation->set_rules('name', 'Country Name', 'trim|required|is_unique[countries.name]');
			
			if ($this->form_validation->run()) 
			{
				$input = array();                                          
                $input['name'] = $this->input->post('name');
                $input['sortname'] = $this->input->post('sortname');
				$input['phonecode'] = $this->input->post('phonecode');
				$input['status'] = $this->input->post('status');
				$input['add_date'] = $this->common_model->getDefaultToGMTDate(time());	

				if($id = $this->country->addNewCountry($input))
				{					
					$message = 'Record Inserted Successfully';
					$success = true;
					$output['redirectURL'] = site_url('admin/country');
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
		$this->load->view('admin/country/country_form');
		$this->load->view('admin/includes/footer');
	}

	function update($id) {
		$output['page_title'] = 'Update Country';
		$output['left_menu'] = 'Country';
		$output['message'] ='';
		if(isset($_POST) && !empty($_POST))
		{
			$redirect = isset($_GET['redirect'])?$_GET['redirect']:'';
			if(!$redirect)
				$redirect = site_url('admin/country');
			$success = true;
			$this->form_validation->set_rules('name', 'Country Name', 'trim|required');			
			if ($this->form_validation->run()) 
			{	
				if(!$this->country->checkCountryUnique($this->input->post('name'), $id))
				{
					$input = array();
					$input['name'] = $this->input->post('name');						
					$input['sortname'] = $this->input->post('sortname');						
					$input['phonecode'] = $this->input->post('phonecode');						
					$input['status'] = $this->input->post('status');
					$this->country->updateCountryRecordById($id, $input);
					$message = 'Record Updated Successfully';
					$data['redirectURL'] = $redirect;
				}
				else
				{
					$message = 'The Country field must contain a unique value.';
					$success = false;
				}														
			}
			else
			{
				$success = false;
				$message = validation_errors();
			}			
			$data['message'] = $message;
			$data['success'] = $success;
			echo json_encode($data);die;
		}
		$country = $this->country->getCountryRecordById($id);
		$output['name'] = $country->name;
		$output['sortname'] = $country->sortname;
		$output['phonecode'] = $country->phonecode;
		$output['status'] = $country->status;		
		$output['id'] = $id;
		$this->load->view('admin/includes/header',$output);
		$this->load->view('admin/country/country_form');
		$this->load->view('admin/includes/footer');
	}

	function view($id) {
		$output['page_title'] = 'View Country Details';
		$output['left_menu'] = 'Country';
		$country = $this->country->getCountryRecordById($id);		
		$output['country'] = $country;
		$this->load->view('admin/includes/header',$output);
		$this->load->view('admin/country/view_country');
		$this->load->view('admin/includes/footer');
	}



	



	


	

	




}