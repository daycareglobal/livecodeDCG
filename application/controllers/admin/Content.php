<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Content extends CI_Controller {
	
	function __construct() {
		Parent::__construct();
		$this->common_model->checkAdminLogin();
		$this->load->model('admin/content_model', 'content');
		$this->load->library('image_lib');
	}

	function index()
	{
		$records = array();
		$output['page_title'] = 'Static Contents';
		$output['left_menu'] = 'Content_management';
		$output['left_submenu'] = 'content';

		$records = $this->content->getAllRecords();
		$output['records'] = $records;

		$this->load->view('admin/includes/header',$output);
		$this->load->view('admin/static_pages/index');
		$this->load->view('admin/includes/footer');
	}

	function edit($id = '')
	{
		$output['page_title'] 		= 'Static Contents';
		$output['left_menu'] 		= 'Content_management';
		$output['left_submenu'] 	= 'content';
		$output['task'] 			= 'Edit';
		$output['id'] 				= $id;				
		$record						= $this->content->getRecordById($id);
		$output['record']			= $record;
		$failure = false;

		if ($this->input->post()) {
			$this->form_validation->set_rules('page_name', 'Page Name', 'trim|required|min_length[3]');
			$this->form_validation->set_rules('title', 'Title', 'trim|required|min_length[3]');
			$this->form_validation->set_rules('description', 'Description', 'trim|required|min_length[3]');
			
			if ($this->form_validation->run()) {

				if ($record->slug == 'about-us') {

					if ($_FILES && isset($_FILES['about_us'])) {
	                    $file_directory = './assets/uploads/about_us/';
	                    @mkdir($file_directory, 0777); 
	                    @chmod($file_directory, 0777);

	                    $config['upload_path']  = $file_directory;
	                    $config['allowed_types'] = 'png|jpg|jpeg';
	                    $config['encrypt_name'] = TRUE;
	                   
	                    $this->load->library('upload', $config);
	                    $this->upload->initialize($config);

	                    if ($this->upload->do_upload('about_us')) {
	                        
	                        $image = $this->upload->data();
	                        $image_url = $file_directory.$image['file_name'];
	                        $directory_300 = $file_directory."/thumbs_300X300/";
	                        $this->common_model->resize_image1($directory_300, $image_url, 498, 368, $image['file_name']);    

	                        $image_name = $image['file_name'];

	                    } else {
	                        $success = false;
	                        $failure = true;
	                        $message = $this->upload->display_errors();
	                    }

	                } else {
	                    $image_name = $record->image;
	                    // $failure = true;
	                    // $success = false;
	                    // $message = 'Please Select an Image.';
	                }
				}

				if (!$failure) {
					$userdata = array();

					if ($record->slug == 'about-us') {
	  					$userdata['image'] = $image_name;
					}
	  				$userdata['title'] = $_POST['title'];
	  				$userdata['description'] = $_POST['description'];
	  				$userdata['updated_at'] = date('Y-m-d H:i:s');
	  				
	  				$result = $this->content->updateData($userdata, $id);

	  				if ($result) {
	  					$success = true;
		       			$message = 'Record Updated successfully.';
		       			$data['redirectURL'] = site_url('admin/content');

	  				} else {
	  					$success = false;
		       			$message = 'Technical error. Please try again.';
	  				}

  				} else {
                    $success = false;
                    $message = $message;
                }
			}
			else
			{
				$success = false;
				$message = validation_errors();
			}
			$data['success'] = $success;
			$data['message'] = $message;
			$data['scrollToThisForm'] = true;
			$data['callBackFunction'] = false;
			echo json_encode($data); die;
		}
		$this->load->view('admin/includes/header',$output);
		$this->load->view('admin/static_pages/edit');
		$this->load->view('admin/includes/footer');
	}

	function changeStatus() {

		$id = $this->input->get('id');
		$status = $this->input->get('status');
		$this->content->changeTeamStatusById($id,$status);
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
				$this->content->changeTeamStatusById($value,$task);			
				$message = 'Status of Selected records changed successfully.';
			}
			if($task == 'Delete')
			{			
				$this->content->deleteTeam($value);
				$message = 'Selected Record Delete Successfully.';
			}
		}		
		$data['ids'] = $ids;
		$data['success'] = true;
		$data['message'] = $message;
		$data['callBackFunction'] = 'callBackCommonDelete';
		echo json_encode($data); die;
	}

	function delete()
	{   
		$id = $this->input->post('record_id');
		$this->content->deleteTeam($id);
		$data['success'] = true;
		$data['message'] = 'Record deleted successfully.';
		$data['callBackFunction'] = 'callBackCommonDelete';
		echo json_encode($data); die;
	}

	function about_us_team()
	{
		$output['page_title'] = 'Static Contents';
		$output['left_menu'] = 'Content_management';
		$output['left_submenu'] = 'about_us';
		$teams = $this->content->getAboutUsTeam();

		foreach ($teams as $key => $value) {
        	$value->add_date = $this->common_model->getGMTDateToLocalDate($value->add_date);
		}
        
        $output['records'] = $teams;
        // pr($output);die;
		$this->load->view('admin/includes/header',$output);
		$this->load->view('admin/static_pages/about_us_list');
		$this->load->view('admin/includes/footer');
	}

	function add_team()
	{
		$output['page_title'] = 'Static Contents';
		$output['left_menu'] = 'Content_management';
		$output['left_submenu'] = 'about_us';
		$output['task'] = 'add';
		$output['message'] = '';
		$output['status'] = 'Active';
		$output['id'] = '';
		$output['name'] = '';
		$output['image'] = '';
		$failure = false;
        $message = '';

        if (isset($_POST) && !empty($_POST)) {
			$success = true;
			$this->form_validation->set_rules('name', 'User Name', 'trim|required|callback_check_space');
			
			if ($this->form_validation->run()) {

				if ($_FILES && isset($_FILES['user_image'])) {
                    $file_directory = './assets/uploads/about_us/';
                    @mkdir($file_directory, 0777); 
                    @chmod($file_directory, 0777);

                    $config['upload_path']  = $file_directory;
                    $config['allowed_types'] = 'png|jpg|jpeg';
                    $config['encrypt_name'] = TRUE;
                   
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('user_image')) {
                        
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
                    $success = false;
                    $failure = true;
                    $message = 'Please select an image';
                }

                if (!$failure) {
					$password = $this->input->post('password');
					$salt = 'Ijxo1A16';
					$ency_password = md5(md5($password).md5($salt));

					$input = array();
					$input['name'] = $this->input->post('name');
					$input['image'] = $image_name;
					$input['add_date'] = $this->common_model->getDefaultToGMTDate(time());
					$team_id = $this->content->insert_team_record($input);
					
					if ($team_id) {
						$message = 'Record added successfully.';
						$success = true;
						$output['redirectURL'] = site_url('admin/content/about_us_team');
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
		$this->load->view('admin/static_pages/add_team_form');
		$this->load->view('admin/includes/footer');
	}

	function update_team($id)
	{
		$record = $this->content->getTeamRecordById($id);
		
		if (empty($record)) {
			echo "<center><h1>No record found.</h1></center>";die;
		}

		$output['page_title'] = 'Static Contents';
		$output['left_menu'] = 'Content_management';
		$output['left_submenu'] = 'about_us';
		$output['task'] = 'edit';
		$output['message'] = '';
		$output['status'] = 'Active';
		$output['id'] = $id;
		$output['name'] = $record->name;
		$output['image'] = $record->image;
		$failure = false;
        $message = '';

        if (isset($_POST) && !empty($_POST)) {
			$success = true;
			$this->form_validation->set_rules('name', 'Name', 'trim|required|callback_check_space');
			
			if ($this->form_validation->run()) {

				if ($_FILES && isset($_FILES['user_image'])) {
                    $file_directory = './assets/uploads/about_us/';
                    @mkdir($file_directory, 0777); 
                    @chmod($file_directory, 0777);

                    $config['upload_path']  = $file_directory;
                    $config['allowed_types'] = 'png|jpg|jpeg';
                    $config['encrypt_name'] = TRUE;
                   
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('user_image')) {
                        
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
					$password = $this->input->post('password');
					$salt = 'Ijxo1A16';
					$ency_password = md5(md5($password).md5($salt));

					$input = array();
					$input['name'] = $this->input->post('name');
					$input['image'] = $image_name;
					$input['update_date'] = $this->common_model->getDefaultToGMTDate(time());
					$team_id = $this->content->update_team_record($input, $id);
					
					if ($team_id) {
						$message = 'Record update successfully.';
						$success = true;
						$output['redirectURL'] = site_url('admin/content/about_us_team');
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
		$this->load->view('admin/static_pages/add_team_form');
		$this->load->view('admin/includes/footer');
	}

	function home_page()
	{
		$output['page_title'] = 'Static Contents';
		$output['left_menu'] = 'Content_management';
		$output['left_submenu'] = 'home_page';
		$output['task'] = 'edit';
		$output['message'] = '';
		$output['status'] = 'Active';
		$output['records'] = $this->content->getHomePageContent();
		$failure = false;
        $message = '';

        if (isset($_POST) && !empty($_POST)) {
			$success = true;
			$this->form_validation->set_rules('welcome-to-daycareglobal', 'welcome-to-daycareglobal', 'trim|required');
			$this->form_validation->set_rules('join-the-network', 'join-the-network', 'trim|required');
			$this->form_validation->set_rules('find-a-daycare', 'find-a-daycare', 'trim|required');
			$this->form_validation->set_rules('lock-in-a-date', 'lock-in-a-date', 'trim|required');
			$this->form_validation->set_rules('peace-of-mind', 'peace-of-mind', 'trim|required');
			$this->form_validation->set_rules('our_value[]', 'our_value', 'trim|required');
			
			if ($this->form_validation->run()) {

				if ($_FILES && isset($_FILES['home_page_image'])) {
                    $file_directory = './assets/uploads/static_pages/';
                    @mkdir($file_directory, 0777); 
                    @chmod($file_directory, 0777);

                    $config['upload_path']  = $file_directory;
                    $config['allowed_types'] = 'png|jpg|jpeg';
                    $config['min_width'] = '1800';
                    $config['min_height'] = '800';
                    $config['encrypt_name'] = TRUE;
                   
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('home_page_image')) {
                        
                        $image = $this->upload->data();
                        $image_url = $file_directory.$image['file_name'];
                        $directory_300 = $file_directory."/thumbs_300X300/";
                        $this->common_model->resize_image1($directory_300,$image_url,1920,847,$image['file_name']);    
                        
                        $image_name = $image['file_name'];

                    } else {
                        $success = false;
                        $failure = true;
                        $message = $this->upload->display_errors();
                    }

                }

                if ($_FILES && isset($_FILES['welcome_daycare_image'])) {
                    $file_directory = './assets/uploads/static_pages/';
                    @mkdir($file_directory, 0777); 
                    @chmod($file_directory, 0777);

                    $config_new['upload_path']  = $file_directory;
                    $config_new['allowed_types'] = 'png|jpg|jpeg';
                    $config_new['min_width'] = '400';
                    $config_new['min_height'] = '600';
                    $config_new['encrypt_name'] = TRUE;
                   
                    $this->load->library('upload', $config_new);
                    $this->upload->initialize($config_new);

                    if ($this->upload->do_upload('welcome_daycare_image')) {
                        
                        $image = $this->upload->data();
                        $image_url = $file_directory.$image['file_name'];
                        $directory_300 = $file_directory."/thumbs_300X300/";
                        $this->common_model->resize_image1($directory_300,$image_url,400,600,$image['file_name']);    
                        
                        $welcome_image_name = $image['file_name'];

                    } else {
                        $success = false;
                        $failure = true;
                        $message .= $this->upload->display_errors().'( In Welcome daycare Image)';
                    }

                }

                if (!$failure) {
	                $input = array();
					$input['welcome-to-daycareglobal'] = $this->input->post('welcome-to-daycareglobal');

					if ($_FILES && isset($_FILES['home_page_image'])) {
						$input['home-page-image'] = $image_name;
					}
					$input['join-the-network'] = $this->input->post('join-the-network');
					$input['find-a-daycare'] = $this->input->post('find-a-daycare');
					$input['lock-in-a-date'] = $this->input->post('lock-in-a-date');
					$input['peace-of-mind'] = $this->input->post('peace-of-mind');
					$input['our_value'] = $this->input->post('our_value');
					$this->content->update_home_record($input);

					if ($_FILES && isset($_FILES['welcome_daycare_image'])) {
						$this->content->update_single_record_by_slug('welcome-to-daycareglobal', $welcome_image_name);
					}
					$output['selfReload'] = true;
					$message = 'Record update successfully.';
					$success = true;

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
		$this->load->view('admin/static_pages/home_page');
		$this->load->view('admin/includes/footer');
	}

	function check_space($value)
    {
        if ( ! preg_match("/^[a-zA-Z0-9_@#$^&%*)(_+}{;:?\/., ]*$/", $value) ){
           $this->form_validation->set_message('check_space', 'The %s field should contain only letters, numbers or periods');
           return false;
       }
        else
        return true;
    }
}