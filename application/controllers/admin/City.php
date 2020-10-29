<?php
/**
* City controller for Admin
*/
if(!defined('BASEPATH')) exit('No direct script access allowed');

class City extends CI_Controller {
	
	function __construct() {
		Parent::__construct();
		$this->common_model->checkAdminLogin();
		$this->common_model->checkLoginAdminStatus();
		$this->load->model('admin/City_model', 'cities');
		$this->load->model('admin/State_model', 'state');
	}	

	function index() {
		$output['page_title'] = 'City Management';
		$output['left_menu'] = 'City';
		/*$allCity = $this->cities->getAllCity();
		$output['allCity'] = $allCity;*/
		$this->load->view('admin/includes/header',$output);
		$this->load->view('admin/city/city_list');
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
        $config['base_url'] = site_url('admin/city/ajaxList?'.$sQuery);
        $config['total_rows'] = $this->cities->countRecord($searchA);
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['paging'] = $this->pagination->create_links();
        $records = $this->cities->getAllRecords($searchA);
        $output['records'] = $records; 
        $html = $this->load->view('admin/city/city_ajax_list',$output, true);
        $data['html'] = $html;
        $data['success']= true;
        echo json_encode($data); die(); 
    }

	function add() {
		$output['page_title'] = 'Add New City';
		$output['left_menu'] = 'City';
		$output['message']    = '';
		$output['id'] = '';
		$output['name'] = '';		
		$output['status'] = 'Active';		
		if(isset($_POST) && !empty($_POST))
		{
			// $this->form_validation->set_rules('name', 'city Name', 'trim|required|is_unique[cities.name]');
			$this->form_validation->set_rules('name', 'city Name', 'trim|required');
			$this->form_validation->set_rules('state_id', 'State Name', 'trim|required');
			if ($this->form_validation->run()) 
			{
				$input = array();                                          
                $input['name'] = $this->input->post('name');				
				$input['status'] = $this->input->post('status');
				$input['state_id'] = $this->input->post('state_id');
				$input['add_date'] = $this->common_model->getDefaultToGMTDate(time());			
				if($id = $this->cities->addNewCity($input))
				{					
					$message = 'Record Inserted Successfully';
					$success = true;
					$output['redirectURL'] = site_url('admin/city');
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

		$allStatesRecord = $this->state->getstateName();
		$output['allStates'] = $allStatesRecord;

		$this->load->view('admin/includes/header',$output);
		$this->load->view('admin/city/city_form');
		$this->load->view('admin/includes/footer');
	}

	function update($id) {
		$output['page_title'] = 'Update City';
		$output['left_menu'] = 'City';
		$output['message'] ='';
		if(isset($_POST) && !empty($_POST))
		{
			$redirect = isset($_GET['redirect'])?$_GET['redirect']:'';
			if(!$redirect)
				$redirect = site_url('admin/city');
			$success = true;
			$this->form_validation->set_rules('name', '	City Name', 'trim|required');
			$this->form_validation->set_rules('state_id', 'State', 'required');
			if ($this->form_validation->run()) 
			{	
				// if(!$this->cities->checkCityUnique($this->input->post('name'), $id))
				// {
					$input = array();
					$input['name'] = $this->input->post('name');							
					$input['status'] = $this->input->post('status');
					$input['state_id'] = $this->input->post('state_id');
					$this->cities->updateCityRecordById($id,$input);
					$message = 'Record Updated Successfully';
					$data['redirectURL'] = $redirect;
				// }
				// else
				// {
				// 	$message = 'The City field must contain a unique value.';
				// 	$success = false;
				// }														
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
		$cities = $this->cities->getCityRecordById($id);
		//print_r($cities);die;
		$output['name'] = $cities->name;		
		$output['status'] = $cities->status;
		$output['state_id'] = $cities->state_id;

		$output['id'] = $id;


        $output['state'] = $this->state->getstateNameByStateId($cities->state_id);
        //echo "<pre>"; print_r($output['state_id']);die;	
       // echo $state_id->state_name;
        $output['allStates'] = $this->state->getAllActiveState();

		$this->load->view('admin/includes/header',$output);
		$this->load->view('admin/city/city_form');
		$this->load->view('admin/includes/footer');
	}


	function view($id) {
		$output['page_title'] = 'View City Details';
		$output['left_menu'] = 'City';
		$cities = $this->cities->getCityRecordById($id);		
		$output['cities'] = $cities;
		$this->load->view('admin/includes/header',$output);
		$this->load->view('admin/city/view_city');
		$this->load->view('admin/includes/footer');
	}



	function delete() {
		$id = $this->input->post('record_id');
		$this->cities->deleteCityRecordByID($id);
		$data['success'] = true;
		$data['message'] = 'Record Deleted Successfully';
		$data['callBackFunction'] = 'callBackCommonDelete';
		echo json_encode($data); die;
	}

	function changeStatus() {
		$id = $this->input->get('id');
		$status = $this->input->get('status');
		$q=$this->cities->changeStatusByID($id, $status);
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
			if($task == 'Delete')
			{
				$this->cities->deleteCityRecordByID($value);
				$message = 'Selected record deleted successfully.';
			}
			else if($task=='Active' || $task=='Inactive')
			{
				$this->cities->changeStatusByID($value,$task);	
				$message = 'Status of Selected records changed successfully.';
			}
		}		
		$data['ids'] = $ids;
		$data['success'] = true;
		$data['message'] = $message;
		$data['callBackFunction'] = 'callBackCommonDelete';
		echo json_encode($data); die;
	}


}