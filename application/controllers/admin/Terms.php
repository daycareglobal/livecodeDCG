<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Terms extends CI_Controller {
	
	function __construct() {
		Parent::__construct();
		$this->common_model->checkAdminLogin();
		$this->load->model('admin/Terms_model', 'terms');
	}

	function index() {   
		$output['page_title'] = 'Terms Management';
		$output['left_menu'] = 'terms_management';
		$output['left_submenu'] = 'terms_list';
		$terms = $this->terms->get_terms();
        $output['terms'] = $terms;
		$this->load->view('admin/includes/header',$output);
		$this->load->view('admin/terms/index');
		$this->load->view('admin/includes/footer');
	}

	// function add() {
	// 	$output['page_title'] = 'Add term';
	// 	$output['left_menu'] = 'terms_management';
	// 	$output['left_submenu'] = 'terms_add';
	// 	$output['id'] = '';
	// 	$output['task'] = 'add';
	// 	$output['message'] = '';
	// 	$output['status'] = 'Active';
		
 //        if (isset($_POST) && !empty($_POST)) {
	// 		$success = true;
	// 		$this->form_validation->set_rules('term_name', 'term name', 'trim|required|callback_check_space');
	// 		$this->form_validation->set_rules('term_start_date', 'term start date', 'trim|required');
	// 		$this->form_validation->set_rules('term_end_date', 'term end date', 'trim|required');
			
	// 		if ($this->form_validation->run()) {

	// 			if (strtotime($this->input->post('term_start_date')) > strtotime($this->input->post('term_end_date'))) {
	// 				$message = 'The end date must be greater than the start date.';
	// 				$success = false;

	// 			} else {
	// 				$input = array();
	// 				$input['term_name'] = $this->input->post('term_name');
	// 				$input['term_start_date'] = $this->input->post('term_start_date');
	// 				$input['start_date'] = date('Y-m-d', strtotime($this->input->post('term_start_date')));
	// 				$input['term_end_date'] = $this->input->post('term_end_date');
	// 				$input['end_date'] = date('Y-m-d', strtotime($this->input->post('term_end_date')));
	// 				$input['add_date'] = $this->common_model->getDefaultToGMTDate(time());
	// 				$response = $this->terms->add_term($input);
					
	// 				if ($response) {
	// 					$message = 'term added successfully.';
	// 					$success = true;
	// 					$data['redirectURL'] = site_url('admin/terms');
					
	// 				} else {
	// 					$message = 'Technical error. Please try again later.';
	// 					$success = false;
	// 				}
	// 			}

	// 		} else {
	// 			$success = false;
	// 			$message = validation_errors();
	// 		}
	// 		$data['message'] = $message;
	// 		$data['success'] = $success;
	// 		echo json_encode($data);die;
	// 	}
	// 	$this->load->view('admin/includes/header',$output);
	// 	$this->load->view('admin/terms/form');
	// 	$this->load->view('admin/includes/footer');
	// }

	function update($id) {
		$record = $this->terms->get_term_by_id($id);
		
		if (empty($record)) {
			echo "<center><h1>No record found.</h1></center>";die;
		}
		$output['page_title'] = 'Update term';
		$output['left_menu'] = 'terms_management';
		$output['left_submenu'] = 'terms_add';
		$output['task'] = 'edit';
		$output['message'] = '';
		$output['record'] = $record;
		$output['id'] = $record->id;

        if (isset($_POST) && !empty($_POST)) {
			$success = true;
			$this->form_validation->set_rules('term_name', 'term name', 'trim|required|callback_check_space');
			$this->form_validation->set_rules('term_start_date', 'term start date', 'trim|required');
			$this->form_validation->set_rules('term_end_date', 'term end date', 'trim|required');

			if ($this->form_validation->run()) {
				if (strtotime($this->input->post('term_start_date')) > strtotime($this->input->post('term_end_date'))) {
					$message = 'The end date must be greater than the start date.';
					$success = false;
				
				} else {
					$input = array();
					$input['term_name'] = $this->input->post('term_name');
					$input['term_start_date'] = $this->input->post('term_start_date');
					$input['start_date'] = date('Y-m-d', strtotime($this->input->post('term_start_date')));
					$input['term_end_date'] = $this->input->post('term_end_date');
					$input['end_date'] = date('Y-m-d', strtotime($this->input->post('term_end_date')));
					$input['update_date'] = $this->common_model->getDefaultToGMTDate(time());
					$response = $this->terms->update_term_by_id($input, $id);

					if ($response) {
						$message = 'Term updated successfully.';
						$success = true;
						$data['redirectURL'] = site_url('admin/terms');

					} else {
						$message = 'Technical error, Please try again.';
						$success = false;
					}
				}

			} else {
				$success = false;
				$message = validation_errors();
			}
			$data['message'] = $message;
			$data['success'] = $success;
			echo json_encode($data);die;
		}
		$this->load->view('admin/includes/header',$output);
		$this->load->view('admin/terms/form');
		$this->load->view('admin/includes/footer');
	}



	function changeStatus() {
		$id = $this->input->get('id');
		$status = $this->input->get('status');
		$this->terms->change_status_by_id($id,$status);
		$data['success'] = true;
		$data['message'] = 'Term status has been changed successfully';
		echo json_encode($data);
	}

	function delete() {   
		$id = $this->input->post('record_id');
		$this->terms->delete_term_by_id($id);
		$data['success'] = true;
		$data['message'] = 'Record remove successfully.';
		$data['callBackFunction'] = 'callBackCommonDelete';
		echo json_encode($data); die;
	}

	function multiTaskOperation() {
		$task = $this->input->post('task');
		$ids = $this->input->post('ids');
		$dataIds = explode(',', $ids);

		foreach ($dataIds as $key => $value) {

			if ($task=='Active' || $task=='Inactive') {
				$this->terms->change_status_by_id($value,$task);			
				$message = 'Status of selected term has been changed successfully.';
			}

			if ($task == 'Delete') {			
				$this->terms->delete_term_by_id($value);
				$message = 'Selected term remove successfully.';
			}
		}		
		$data['ids'] = $ids;
		$data['success'] = true;
		$data['message'] = $message;
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