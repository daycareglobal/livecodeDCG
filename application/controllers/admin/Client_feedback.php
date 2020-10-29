<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Client_feedback extends CI_Controller {
	
	function __construct() {
		Parent::__construct();
		$this->common_model->checkAdminLogin();
		$this->load->model('admin/client_feedback_model', 'client_feedback');
		$this->load->library('image_lib');
	}

	function index()
	{   
		$output['page_title'] = 'Client Feedback';
		$output['left_menu'] = 'feedback_module';
		$output['left_submenu'] = 'feedback_list';
		$client_feedback = $this->client_feedback->getRecords();

		foreach ($client_feedback as $key => $value) {
        	$value->add_date = $this->common_model->getGMTDateToLocalDate($value->add_date);
		}
        $output['records'] = $client_feedback;
		$this->load->view('admin/includes/header',$output);
		$this->load->view('admin/client_feedback/index');
		$this->load->view('admin/includes/footer');
	}

	function changeStatus() {

		$id = $this->input->get('id');
		$status = $this->input->get('status');
		$this->client_feedback->changeStatusById($id, $status);
		$data['success'] = true;
		$data['message'] = 'Record updated Successfully';
		echo json_encode($data);
	}

	function multiTaskOperation()
	{
		$task = $this->input->post('task');
		$ids = $this->input->post('ids');
		$dataIds = explode(',',$ids);
		foreach ($dataIds as $key => $value) 
		{
			if($task=='Active' || $task=='Inactive')
			{
				$this->client_feedback->changeStatusById($value,$task);			
				$message = 'Status of Selected records changed successfully.';
			}	
			if($task == 'Delete')
			{			
				$this->user->delete($value);
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
		$output['page_title'] = 'Client Feedback';
		$output['left_menu'] = 'feedback_module';
		$output['left_submenu'] = 'feedback_list';
		$output['task'] = 'add';
		$output['message'] = '';
		$output['status'] = 'Active';
		$output['id'] = '';
		$output['title'] = '';
		$output['image'] = '';
		$output['description'] = '';
		$failure = false;

        if (isset($_POST) && !empty($_POST)) {
			$success = true;
			$this->form_validation->set_rules('title', 'title', 'trim|required');
			$this->form_validation->set_rules('description', 'Description', 'trim|required');
			
			if ($this->form_validation->run()) {

				if ($_FILES && isset($_FILES['image'])) {
                    $file_directory = './assets/uploads/profile_image/';
                    @mkdir($file_directory, 0777); 
                    @chmod($file_directory, 0777);

                    $config['upload_path']  = $file_directory;
                    $config['allowed_types'] = 'png|jpg|jpeg';
                    $config['encrypt_name'] = TRUE;
                   
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('image')) {
                        
                        $image = $this->upload->data();
                        $image_url = $file_directory.$image['file_name'];
                        $directory_300 = $file_directory."/thumbs_300X300/";
                        $this->common_model->resize_image1($directory_300,$image_url,300,300,$image['file_name']);    
                        
                        $image_name = $image['file_name'];

                    } else {
                        $success = false;
                        $failure = true;
                        $message = $this->upload->display_errors();
                    }

                } else {
                    $image_name = '';
                }

                if (!$failure) {
					$input = array();
					$input['title'] = $this->input->post('title');
					$input['description'] = $this->input->post('description');
					$input['image'] = $image_name;
					$input['add_date'] = $this->common_model->getDefaultToGMTDate(time());
					$activity_id = $this->client_feedback->insertRecord($input);
					
					if ($activity_id) {
						$message = 'Record added successfully.';
						$success = true;
						$output['redirectURL'] = site_url('admin/client_feedback');
					}

				} else {
                    $success = false;
                    $message = $message;
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
		$this->load->view('admin/client_feedback/form');
		$this->load->view('admin/includes/footer');
	}
	
	function update($id)
	{
		$record = $this->client_feedback->get_record_by_id($id);
		
		if (empty($record)) {
			echo "<center><h1>No record found.</h1></center>";die;
		}

		$output['page_title'] = 'Client Feedback';
		$output['left_menu'] = 'feedback_module';
		$output['left_submenu'] = 'feedback_list';
		$output['task'] = 'edit';
		$output['message'] = '';
		$output['status'] = 'Active';
		$output['id'] = $record->id;
		$output['title'] = $record->title;
		$output['image'] = $record->image;
		$output['description'] = $record->description;
		$failure = false;

        if (isset($_POST) && !empty($_POST)) {
			$success = true;
			$this->form_validation->set_rules('title', 'title', 'trim|required');
			$this->form_validation->set_rules('description', 'Description', 'trim|required');

			if ($this->form_validation->run()) {

				if ($_FILES && isset($_FILES['image'])) {
                    $file_directory = './assets/uploads/profile_image/';
                    @mkdir($file_directory, 0777); 
                    @chmod($file_directory, 0777);

                    $config['upload_path']  = $file_directory;
                    $config['allowed_types'] = 'png|jpg|jpeg';
                    $config['encrypt_name'] = TRUE;
                   
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('image')) {
                        $image = $this->upload->data();
                        $image_url = $file_directory.$image['file_name'];
                        $directory_300 = $file_directory."/thumbs_300X300/";
                        $this->common_model->resize_image1($directory_300,$image_url,300,300,$image['file_name']);    
                        
                        $image_name = $image['file_name'];

                    } else {
                        $success = false;
                        $failure = true;
                        $message = $this->upload->display_errors();
                    }

                } else {
                    $image_name = $record->image;
                }

                if (!$failure) {
					$input = array();
					$input['title'] = $this->input->post('title');
					$input['description'] = $this->input->post('description');
					$input['image'] = $image_name;
					$input['update_date'] = $this->common_model->getDefaultToGMTDate(time());
					$response = $this->client_feedback->update_record($input, $id);

					if ($response) {
						$message = 'Record updated successfully.';
						$success = true;
						$output['redirectURL'] = site_url('admin/client_feedback');

					} else {
						$message = 'Technical error, Please try again.';
						$success = false;
					}

				} else {
                    $success = false;
                    $message = $message;
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
		$this->load->view('admin/client_feedback/form');
		$this->load->view('admin/includes/footer');
	}

	function delete_offer()
	{   
		$id = $this->input->post('record_id');
		$this->advertisement->delete_offer($id);
		$data['success'] = true;
		$data['message'] = 'Record deleted successfully.';
		$data['callBackFunction'] = 'callBackCommonDelete';
		echo json_encode($data); die;
	}

	function delete_event()
	{   
		$id = $this->input->post('record_id');
		$this->advertisement->delete_event($id);
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