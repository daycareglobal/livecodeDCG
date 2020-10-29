<?php
/**
* State controller for Admin
*/
if(!defined('BASEPATH')) exit('No direct script access allowed');

class State extends CI_Controller {
	
	function __construct() {
		Parent::__construct();
		$this->common_model->checkAdminLogin();
		$this->common_model->checkLoginAdminStatus();
		$this->load->model('admin/State_model', 'state');
		$this->load->model('admin/Country_model', 'country');

	}	

	function index() {
		$output['page_title'] = 'State Management';
		$output['left_menu'] = 'State';
		/*$allStates = $this->state->getAllStates();
		$output['allStates'] = $allStates;*/
		$this->load->view('admin/includes/header',$output);
		$this->load->view('admin/state/state_list');
		$this->load->view('admin/includes/footer');
	}

	function ajaxList()
    {
    	$this->load->library('pagination');
    	$success = true;
        $html = false;
        $load_prev_link = false;
        $load_next_link = false;
		$keyword = $this->input->get('keyword');
		$page_limit = $this->input->get('page_limit');	       
        $page_no = $this->input->get('page_no')?$this->input->get('page_no'):1;
        $page_no_index = ($page_no - 1) * $page_limit;
        $sQuery = '';
		if($keyword)
			$sQuery = $sQuery.'&keyword='.$keyword;
		if($page_limit)
			$sQuery = $sQuery.'&page_limit='.$page_limit;		
		$per_page = $this->input->get('page_limit');
		$searchA['search_index'] = $page_no_index;
		$searchA['limit'] = $per_page;		
		$searchA['keyword'] = $keyword;	
        $config['base_url'] = site_url('admin/state/ajaxList?'.$sQuery);
        $config['total_rows'] = $this->state->countRecord($searchA);
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['paging'] = $this->pagination->create_links();
        $records = $this->state->getAllRecords($searchA);
        $output['records'] = $records; 
        $html = $this->load->view('admin/state/state_ajax_list',$output, true);
        $data['html'] = $html;
        $data['success']= true;
        echo json_encode($data); die(); 
    }	

	function changeStatus() {
		$id = $this->input->get('id');
		$status = $this->input->get('status');
		$this->state->changeStatusByID($id, $status);
		$data['success'] = true;
		$data['message'] = 'Record updated Successfully';
		echo json_encode($data);
	}

	function delete() {
		$id = $this->input->post('record_id');
		$this->state->deleteStateRecordByID($id);
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
				$this->state->deleteStateRecordByID($value);
				$message = 'Selected record deleted successfully.';
			}
			else if($task=='Active' || $task=='Inactive')
			{
				$this->state->changeStatusByID($value,$task);			
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
		$output['page_title'] = 'Add New State';
		$output['left_menu'] = 'State';
		$output['message']    = '';
		$output['id'] = '';
		$output['name'] = '';		
		$output['status'] = 'Active';		
		if(isset($_POST) && !empty($_POST))
		{
			$this->form_validation->set_rules('name', 'State Name', 'trim|required');
			$this->form_validation->set_rules('country_id', 'Country Name', 'trim|required');
			if ($this->form_validation->run()) 
			{
				$input = array();                                          
                $input['name'] = $this->input->post('name');					
				$input['status'] = $this->input->post('status');
				$input['country_id'] = $this->input->post('country_id');
				$input['add_date'] = $this->common_model->getDefaultToGMTDate(time());			
				if($id = $this->state->addNewState($input))
				{					
					$message = 'Record Inserted Successfully';
					$success = true;
					$output['redirectURL'] = site_url('admin/state');
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
		$countryRecord = $this->country->getCountryName();
		$output['allCountries'] = $countryRecord;
		$this->load->view('admin/includes/header',$output);
		$this->load->view('admin/state/state_form');
		$this->load->view('admin/includes/footer');
	}

	function update($id) {
		$output['page_title'] = 'Update State';
		$output['left_menu'] = 'State';
		$output['message'] ='';
		if(isset($_POST) && !empty($_POST))
		{
			$redirect = isset($_GET['redirect'])?$_GET['redirect']:'';
			if(!$redirect)
				$redirect = site_url('admin/state');
			$success = true;
			$this->form_validation->set_rules('name', 'State Name', 'trim|required');
			$this->form_validation->set_rules('country_id', 'Country', 'required');
			
			if ($this->form_validation->run()) 
			{	
				if(!$this->state->checkStateUnique($this->input->post('name'), $id))
				{
					$input = array();
					$input['name'] = $this->input->post('name');							
					$input['status'] = $this->input->post('status');
					$input['country_id'] = $this->input->post('country_id');
					$this->state->updateStateRecordById($id,$input);
					$message = 'Record Updated Successfully';
					$data['redirectURL'] = $redirect;
				}
				else
				{
					$message = 'The State field must contain a unique value.';
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
		$state = $this->state->getStateRecordById($id);
		$output['country_id'] = $state->country_id;


		$output['country'] = $this->country->getCountryNameByCountryId($state->country_id);
        $output['allCountries'] = $this->country->getAllActiveCountries();

		$output['name'] = $state->name;		
		$output['status'] = $state->status;		
		$output['id'] = $id;
		$this->load->view('admin/includes/header',$output);
		$this->load->view('admin/state/state_form');
		$this->load->view('admin/includes/footer');
	}

	function view($id) {
		$output['page_title'] = 'View State Details';
		$output['left_menu'] = 'State';
		$state = $this->state->getStateRecordById($id);		
		$output['state'] = $state;
		$this->load->view('admin/includes/header',$output);
		$this->load->view('admin/state/view_state');
		$this->load->view('admin/includes/footer');
	}



	



	


	

	




}