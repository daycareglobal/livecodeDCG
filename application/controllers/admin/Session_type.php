<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Session_type extends CI_Controller {
	
	function __construct() {
		Parent::__construct();
		$this->common_model->checkAdminLogin();
		$this->load->model('admin/Session_type_model', 'session_type');
	}

	function index() {   
		$output['page_title'] = 'Session Type';
		$output['left_menu'] = 'session_type';
		$output['left_submenu'] = 'session_type_list';
		$session_types = $this->session_type->get_session_types();
		
		foreach ($session_types as $key => $value) {
        	$value->add_date = $this->common_model->getGMTDateToLocalDate($value->add_date);
		}
        $output['session_types'] = $session_types;
		$this->load->view('admin/includes/header',$output);
		$this->load->view('admin/session_type/index');
		$this->load->view('admin/includes/footer');
	}

	function add() {
		$output['page_title'] = 'Session Type';
		$output['left_menu'] = 'session_type';
		$output['left_submenu'] = 'session_type_add';
		$output['task'] = 'add';
		$output['message'] = '';
		$output['status'] = 'Active';
		$output['id'] = '';
		$output['session_name'] = '';
		$output['is_funded'] = "";
		$output['is_non_funded'] = "";
		$output['age_group_0_2'] = "";
		$output['age_group_2_3'] = "";
		$output['age_group_15_3_5'] = "";
		$output['age_group_30_3_5'] = "";
		$output['is_age_above_5'] = "";
		$output['is_week_38_non_funded'] = "";
		$output['is_week_52_non_funded'] = "";
		$output['is_week_38_funded'] = "";
		$output['is_week_52_funded'] = "";
        if (isset($_POST) && !empty($_POST)) {
		//pr($_POST);die;
			$success = true;

			$this->form_validation->set_rules('session_name', 'session name', 'trim|required|callback_check_space|is_unique[tbl_session_type.session_name]');
			
			if ($this->form_validation->run()) {
				$input = array();
				$input['session_name'] = $this->input->post('session_name');

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

				if ($this->input->post('is_week_38_non_funded')) {
					$input['is_week_38_non_funded'] = 'Yes';

				} else {
					$input['is_week_38_non_funded'] = 'No';
				}

				if ($this->input->post('is_week_52_non_funded')) {
					$input['is_week_52_non_funded'] = 'Yes';

				} else {
					$input['is_week_52_non_funded'] = 'No';
				}

				if ($this->input->post('is_week_38_funded')) {
					$input['is_week_38_funded'] = 'Yes';

				} else {
					$input['is_week_38_funded'] = 'No';
				}

				if ($this->input->post('is_week_52_funded')) {
					$input['is_week_52_funded'] = 'Yes';

				} else {
					$input['is_week_52_funded'] = 'No';
				}

				$input['add_date'] = $this->common_model->getDefaultToGMTDate(time());
				
				$insert_id = $this->session_type->add_session_type($input);
				
				if ($insert_id) {
					$message = 'Session added successfully.';
					$success = true;
					$output['redirectURL'] = site_url('admin/session_type');
				
				} else {
					$message = 'Technical error. PLease try again';
					$success = false;
					$output['redirectURL'] = site_url('admin/session_type');
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
		$this->load->view('admin/session_type/form');
		$this->load->view('admin/includes/footer');
	}

	
	function update($id) {
		$record = $this->session_type->get_session_type_by_id($id);
		
		if (empty($record)) {
			echo "<center><h1>No record found.</h1></center>";die;
		}

		$output['page_title'] = 'Session Type';
		$output['left_menu'] = 'session_type';
		$output['left_submenu'] = 'session_type_add';
		$output['task'] = 'edit';
		$output['message'] = '';
		$output['status'] = '';
		$output['id'] = $record->id;
		$output['session_name'] = $record->session_name;
		$output['is_funded'] = $record->is_funded;
		$output['is_non_funded'] = $record->is_non_funded;
		$output['age_group_0_2'] = $record->age_group_0_2;
		$output['age_group_2_3'] = $record->age_group_2_3;
		$output['age_group_15_3_5'] = $record->age_group_15_3_5;
		$output['age_group_30_3_5'] = $record->age_group_30_3_5;
		$output['is_age_above_5'] = $record->is_age_above_5;
		$output['is_week_38_non_funded'] = $record->is_week_38_non_funded;
		$output['is_week_52_non_funded'] = $record->is_week_52_non_funded;
		$output['is_week_38_funded'] = $record->is_week_38_funded;
		$output['is_week_52_funded'] = $record->is_week_52_funded;

        if (isset($_POST) && !empty($_POST)) {
			$success = true;

			$this->form_validation->set_rules('session_name', 'session name', 'trim|required|callback_check_space|callback_check_name_exist['.$id.']');
			
			if ($this->form_validation->run()) {
				$input = array();
				$input['session_name'] = $this->input->post('session_name');

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

				if ($this->input->post('is_week_38_non_funded')) {
					$input['is_week_38_non_funded'] = 'Yes';

				} else {
					$input['is_week_38_non_funded'] = 'No';
				}

				if ($this->input->post('is_week_52_non_funded')) {
					$input['is_week_52_non_funded'] = 'Yes';

				} else {
					$input['is_week_52_non_funded'] = 'No';
				}

				if ($this->input->post('is_week_38_funded')) {
					$input['is_week_38_funded'] = 'Yes';

				} else {
					$input['is_week_38_funded'] = 'No';
				}

				if ($this->input->post('is_week_52_funded')) {
					$input['is_week_52_funded'] = 'Yes';

				} else {
					$input['is_week_52_funded'] = 'No';
				}

				$input['update_date'] = $this->common_model->getDefaultToGMTDate(time());
				$response = $this->session_type->update_session_type($input, $id);

				if ($response) {
					$message = 'Session type updated successfully.';
					$success = true;
					$data['redirectURL'] = site_url('admin/session_type');

				} else {
					$message = 'Technical error, Please try again.';
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
		$this->load->view('admin/includes/header',$output);
		$this->load->view('admin/session_type/form');
		$this->load->view('admin/includes/footer');
	}

	function view($id) {
		$record	= $this->session_type->get_session_type_by_id($id);

        if (!$record) {
        	echo "<center><h1>No record found.</h1></center>";die;
        }

        $output['page_title'] = 'Session Type';
		$output['left_menu'] = 'session_type';
		$output['left_submenu'] = 'session_type_list';
		$output['id'] = $id;
		
		if ($record) {
	        $record->add_date = $this->common_model->getGMTDateToLocalDate($record->add_date);
	        $output['session_type'] = $record;
		}
        $this->load->view('admin/includes/header',$output);
		$this->load->view('admin/session_type/view');
		$this->load->view('admin/includes/footer');
	}

	function session_request() {
        $output['page_title'] = 'Session Type';
		$output['left_menu'] = 'session_type';
		$output['left_submenu'] = 'session_request_list';
		$records = $this->session_type->get_session_request();

		foreach ($records as $key => $value) {
        	$value->add_date = $this->common_model->getGMTDateToLocalDate($value->add_date);
		}
	    $output['session_request'] = $records;
        $this->load->view('admin/includes/header',$output);
		$this->load->view('admin/session_type/session_request');
		$this->load->view('admin/includes/footer');
	}

	function add_requested_session() {
	
        if (isset($_POST) && !empty($_POST)) {
			$success = true;

			$this->form_validation->set_rules('session_name', 'session name', 'trim|required|callback_check_space|is_unique[tbl_session_type.session_name]');
			
			if ($this->form_validation->run()) {
				$input = array();
				$input['session_name'] = $this->input->post('session_name');

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

				if ($this->input->post('is_week_38_non_funded')) {
					$input['is_week_38_non_funded'] = 'Yes';

				} else {
					$input['is_week_38_non_funded'] = 'No';
				}

				if ($this->input->post('is_week_52_non_funded')) {
					$input['is_week_52_non_funded'] = 'Yes';

				} else {
					$input['is_week_52_non_funded'] = 'No';
				}

				if ($this->input->post('is_week_38_funded')) {
					$input['is_week_38_funded'] = 'Yes';

				} else {
					$input['is_week_38_funded'] = 'No';
				}

				if ($this->input->post('is_week_52_funded')) {
					$input['is_week_52_funded'] = 'Yes';

				} else {
					$input['is_week_52_funded'] = 'No';
				}
				$input['add_date'] = $this->common_model->getDefaultToGMTDate(time());
				$insert_id = $this->session_type->add_session_type($input);
				
				if ($insert_id) {
					$record_id = $this->input->post('record_id');
					$is_approved = 'Yes';
					$this->session_type->changeSessionStatusById($record_id,$insert_id,$is_approved);
					$this->session_type->changeMonthlyStatusById($record_id,$insert_id);

					$message = 'Session added successfully.';
					$success = true;
					$data['redirectURL'] = site_url('admin/session_type');
				
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
        if ($this->session_type->doesNameExist( $value, $id )) {
            $this->form_validation->set_message('check_name_exist', 'This Session Name already register on our server.');
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