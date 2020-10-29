<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Service_category extends CI_Controller {
	
	function __construct() {
		Parent::__construct();
		$this->common_model->checkAdminLogin();
		$this->load->model('admin/service_category_model', 'service_category');
	}

	function index()
	{   
		$output['page_title'] = 'Service Categories';
		$output['left_menu'] = 'service_category_module';
		$output['left_submenu'] = 'service_category_list';

		$service_category = $this->service_category->getActiveRecords();

		foreach ($service_category as $key => $value) {
        	$value->add_date = $this->common_model->getGMTDateToLocalDate($value->add_date);
		}
        
        $output['records'] = $service_category;
		$this->load->view('admin/includes/header',$output);
		$this->load->view('admin/service_category/index');
		$this->load->view('admin/includes/footer');
	}

	function changeStatus()
	{
		$id = $this->input->get('id');
		$status = $this->input->get('status');
		$this->service_category->changeStatusById($id,$status);
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
				$this->service_category->changeStatusById($value,$task);			
				$message = 'Status of Selected records changed successfully.';
			}

			if ($task == 'Delete') {			
				// $this->service_category->delete($value);
				$input = array();
				$input['status'] = 'Inactive';
				$input['is_delete'] = 'Yes';
				$input['update_date'] = $this->common_model->getDefaultToGMTDate(time());
				$this->service_category->update_record($input, $value);
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
		$output['page_title'] = 'Service Categories';
		$output['left_menu'] = 'service_category_module';
		$output['left_submenu'] = 'service_category_list';
		$output['task'] = 'add';
		$output['message'] = '';
		$output['status'] = 'Active';
		$output['id'] = '';
		$output['name'] = '';
		$output['is_funded'] = "";
		$output['is_non_funded'] = "";
		$output['age_group_0_2'] = "";
		$output['age_group_2_3'] = "";
		$output['age_group_15_3_5'] = "";
		$output['age_group_30_3_5'] = "";
		$output['is_age_above_5'] = "";

        if (isset($_POST) && !empty($_POST)) {
			$success = true;

			$this->form_validation->set_rules('name', 'Service Name', 'trim|required|callback_check_space|is_unique[tbl_service_category.name]');
			
			if ($this->form_validation->run()) {
				$input = array();
				$input['name'] = $this->input->post('name');

				if ($this->input->post('is_funded')) {
					$input['is_funded'] = 'Yes';

				} else {
					$input['is_funded'] = 'No';
				}

				if ($this->input->post('is_non_funded')) {
					$input['is_non_funded'] = 'Yes';

				} else {
					$input['is_non_funded'] = 'No';
				}

				if ($this->input->post('age_group_0_2')) {
					$input['age_group_0_2'] = 'Yes';

				} else {
					$input['age_group_0_2'] = 'No';
				}

				if ($this->input->post('age_group_2_3')) {
					$input['age_group_2_3'] = 'Yes';

				} else {
					$input['age_group_2_3'] = 'No';
				}

				if ($this->input->post('age_group_15_3_5')) {
					$input['age_group_15_3_5'] = 'Yes';

				} else {
					$input['age_group_15_3_5'] = 'No';
				}

				if ($this->input->post('age_group_30_3_5')) {
					$input['age_group_30_3_5'] = 'Yes';

				} else {
					$input['age_group_30_3_5'] = 'No';
				}

				if ($this->input->post('is_age_above_5')) {
					$input['is_age_above_5'] = 'Yes';

				} else {
					$input['is_age_above_5'] = 'No';
				}

				$input['add_date'] = $this->common_model->getDefaultToGMTDate(time());
				
				$school_id = $this->service_category->insert_record($input);
				
				if ($school_id) {
					$message = 'Record added successfully.';
					$success = true;
					$output['redirectURL'] = site_url('admin/service_category');
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
		$this->load->view('admin/service_category/form');
		$this->load->view('admin/includes/footer');
	}

	
	function update($id)
	{
		$record = $this->service_category->get_record_by_id($id);
		
		if (empty($record)) {
			echo "<center><h1>No record found.</h1></center>";die;
		}

		$output['page_title'] = 'Service Categories';
		$output['left_menu'] = 'service_category_module';
		$output['left_submenu'] = 'service_category_list';
		$output['task'] = 'edit';
		$output['message'] = '';
		$output['status'] = '';
		$output['id'] = $record->id;
		$output['name'] = $record->name;
		$output['is_funded'] = $record->is_funded;
		$output['is_non_funded'] = $record->is_non_funded;
		$output['age_group_0_2'] = $record->age_group_0_2;
		$output['age_group_2_3'] = $record->age_group_2_3;
		$output['age_group_15_3_5'] = $record->age_group_15_3_5;
		$output['age_group_30_3_5'] = $record->age_group_30_3_5;
		$output['is_age_above_5'] = $record->is_age_above_5;
		

        if (isset($_POST) && !empty($_POST)) {
			$success = true;

			$this->form_validation->set_rules('name', 'Service Name', 'trim|required|callback_check_space|callback_check_name_exist['.$id.']');
			
			if ($this->form_validation->run()) {
				$input = array();
				$input['name'] = $this->input->post('name');

				if ($this->input->post('is_funded')) {
					$input['is_funded'] = 'Yes';

				} else {
					$input['is_funded'] = 'No';
				}

				if ($this->input->post('is_non_funded')) {
					$input['is_non_funded'] = 'Yes';

				} else {
					$input['is_non_funded'] = 'No';
				}

				if ($this->input->post('age_group_0_2')) {
					$input['age_group_0_2'] = 'Yes';

				} else {
					$input['age_group_0_2'] = 'No';
				}

				if ($this->input->post('age_group_2_3')) {
					$input['age_group_2_3'] = 'Yes';

				} else {
					$input['age_group_2_3'] = 'No';
				}

				if ($this->input->post('age_group_15_3_5')) {
					$input['age_group_15_3_5'] = 'Yes';

				} else {
					$input['age_group_15_3_5'] = 'No';
				}

				if ($this->input->post('age_group_30_3_5')) {
					$input['age_group_30_3_5'] = 'Yes';

				} else {
					$input['age_group_30_3_5'] = 'No';
				}

				if ($this->input->post('is_age_above_5')) {
					$input['is_age_above_5'] = 'Yes';

				} else {
					$input['is_age_above_5'] = 'No';
				}

				$input['update_date'] = $this->common_model->getDefaultToGMTDate(time());
				$response = $this->service_category->update_record($input, $id);

				if ($response) {
					$message = 'Record updated successfully.';
					$success = true;
					$output['redirectURL'] = site_url('admin/service_category');

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
		$this->load->view('admin/service_category/form');
		$this->load->view('admin/includes/footer');
	}
	
	function delete()
	{   
		$id = $this->input->post('record_id');
		// $this->service_category->delete($id);
		$input = array();
		$input['status'] = 'Inactive';
		$input['is_delete'] = 'Yes';
		$input['update_date'] = $this->common_model->getDefaultToGMTDate(time());
		$this->service_category->update_record($input, $id);
		$data['success'] = true;
		$data['message'] = 'Record deleted successfully.';
		$data['callBackFunction'] = 'callBackCommonDelete';
		echo json_encode($data); die;
	}

	/*function view($id) 
    {
        $record	= $this->service_category->get_record_by_id($id);

        $output = array();
		$output['page_title'] = 'School Management';
		$output['left_menu'] = 'school_module';
		$output['left_submenu'] = 'school_list';

		if ($record) {
        	$record->add_date = $this->common_model->getGMTDateToLocalDate($record->add_date);
        	$output['record'] = $record;
		}
        $this->load->view('admin/includes/header',$output);
		$this->load->view('admin/schools/view');
		$this->load->view('admin/includes/footer');
    }*/

    function view($id) {
		$record = $this->service_category->get_record_by_id($id);

        if (!$record) {
        	echo "<center><h1>No record found.</h1></center>";die;
        }

       	$output['page_title'] = 'Service Categories';
		$output['left_menu'] = 'service_category_module';
		$output['left_submenu'] = 'service_category_list';
		$output['id'] = $id;
		
		if ($record) {
	        $record->add_date = $this->common_model->getGMTDateToLocalDate($record->add_date);
	        $output['service_category'] = $record;
		}
        $this->load->view('admin/includes/header',$output);
		$this->load->view('admin/service_category/view');
		$this->load->view('admin/includes/footer');
	}

    function check_name_exist($value, $id = '')
    {
        if ($this->service_category->doesNameExist( $value, $id )) {
            $this->form_validation->set_message('check_name_exist', 'This School Name already register on our server.');
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