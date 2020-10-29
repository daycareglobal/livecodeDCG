<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Services extends CI_Controller {
	
	function __construct() {
		Parent::__construct();
		$this->common_model->checkAdminLogin();
		$this->load->model('admin/Services_model', 'services');
	}

	function index()
	{   
		$output['page_title'] = 'Services';
		$output['left_menu'] = 'service_module';
		$output['left_submenu'] = 'service_list';

		$services = $this->services->getServices();

		foreach ($services as $key => $value) {
        	$value->add_date = $this->common_model->getGMTDateToLocalDate($value->add_date);
		}
        
        $output['services'] = $services;
		$this->load->view('admin/includes/header',$output);
		$this->load->view('admin/services/index');
		$this->load->view('admin/includes/footer');
	}


	function add()
	{
		$output['page_title'] = 'Service';
		$output['left_menu'] = 'service_module';
		$output['left_submenu'] = 'service_list';
		$output['task'] = 'add';
		$output['id'] = '';
		$output['message'] = '';
		$output['daycare_name'] = '';
		$output['address'] = '';
		$output['hourly_charges'] = '';
		$output['monthly_charges'] = '';
		$output['daily_charges'] = '';
		$output['total_capacity'] = '';
		$output['age_accepted'] = '';
		$output['age_accepted'] = '';
		$output['age_accepted'] = '';
		$output['status'] = 'Active';
		$output['business_types'] = $this->services->getBusinesActiveRecords();
		$output['service_types'] = $this->services->getActiveServiceCategory();
		$output['business_users'] = $this->services->getBusinesUsers();

        if (isset($_POST) && !empty($_POST)) {
			$success = true;
			$failure = false;
			$this->form_validation->set_rules('business_type_id', 'business type', 'trim|required|callback_check_space');
			$this->form_validation->set_rules('daycare_name', 'daycare name', 'trim|required|callback_check_space');
			$this->form_validation->set_rules('address', 'address', 'trim|required|callback_check_space');
			$this->form_validation->set_rules('latitude', 'latitude', 'trim|required');
			$this->form_validation->set_rules('longitude', 'longitude', 'trim|required');
			$this->form_validation->set_rules('hourly_charges', 'hourly charges', 'trim|required');
			$this->form_validation->set_rules('monthly_charges', 'monthly charges', 'trim|required');
			$this->form_validation->set_rules('daily_charges', 'daily charges', 'trim|required');
			$this->form_validation->set_rules('service_types[]', 'service types', 'trim|required');
			$this->form_validation->set_rules('about_daycare', 'about daycare', 'trim|required');

			
			if ($this->form_validation->run()) {

				if (isset($_FILES['files']) && !empty($_FILES['files'])) {
					$cpt = count($_FILES['files']['name']);

					if ($cpt <= 0) {
						$failure = true;
						$success = false;
						$message = 'Please select image of your service.';
					}
				
				} else {
					$failure = true;
					$success = false;
					$message = 'Please select image of your service.';
				}

				if (!$failure) {
					$input['user_id'] = $this->input->post('user_id');
					$input['business_category_id'] = $this->input->post('business_type_id');
					$input['daycare_name'] = $this->input->post('daycare_name');
					$input['daycare_address'] = $this->input->post('address');
					$input['latitude'] = $this->input->post('latitude');
					$input['longitude'] = $this->input->post('longitude');
					$input['hourly_charges'] = $this->input->post('hourly_charges');
					$input['monthly_charges'] = $this->input->post('monthly_charges');
					$input['daily_charges'] = $this->input->post('daily_charges');
					$input['about_daycare_center'] = $this->input->post('about_daycare');
					$input['age_accepted'] = $this->input->post('age_accepted');
					$input['total_capacity'] = $this->input->post('total_capacity');
					$input['add_date'] = $this->common_model->getDefaultToGMTDate(time());
					$business_service_id = $this->services->insertBusinessDetails($input);
					// $business_service_id = true;

					if ($business_service_id) {

						if ($_FILES && isset($_FILES['files'])) {
							$this->load->library('upload');
							$uploadImgData = array();
							$files = $_FILES;

							for ($i=0; $i<$cpt; $i++) {
						        $_FILES['files']['name']= $files['files']['name'][$i];
						        $_FILES['files']['type']= $files['files']['type'][$i];
						        $_FILES['files']['tmp_name']= $files['files']['tmp_name'][$i];
						        $_FILES['files']['error']= $files['files']['error'][$i];
						        $_FILES['files']['size']= $files['files']['size'][$i];    

						        // File upload configuration
					            $uploadPath = './assets/uploads/business_logo/';
					            $config['upload_path'] = $uploadPath;
					            $config['allowed_types'] = 'jpg|jpeg|png|gif';
					            $config['encrypt_name']  = TRUE;

					            // Load and initialize upload library
					            $this->load->library('upload', $config);
					            $this->upload->initialize($config);

					            // Upload file to server
					            if ($this->upload->do_upload('files')) {
					                // Uploaded file data
					                $imageData = $this->upload->data();
					                $uploadImgData[$i]['user_service_id'] = $business_service_id;
					                $uploadImgData[$i]['image'] = $imageData['file_name'];
					                $uploadImgData[$i]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
					            }
						    }

						    if ($uploadImgData && !empty($uploadImgData)) {
						    	$this->services->insertBusinessServiceImages($uploadImgData);
						    }
						}

						$service_days = array();

						if (isset($_POST['monday']['open'])) {
							$service_days[0]['user_service_id'] = $business_service_id;
							$service_days[0]['day'] = 'monday';
							$service_days[0]['open_time'] = $this->common_model->getDefaultToGMTDate(strtotime($_POST['monday']['open']), 'H:i:s');
							$service_days[0]['close_time'] = $this->common_model->getDefaultToGMTDate(strtotime($_POST['monday']['close']), 'H:i:s');
							$service_days[0]['is_holiday'] = 'No';
							$service_days[0]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
						} 

						if (isset($_POST['tuesday']['open'])) {
							$service_days[1]['user_service_id'] = $business_service_id;
							$service_days[1]['day'] = 'tuesday';
							$service_days[1]['open_time'] = $this->common_model->getDefaultToGMTDate(strtotime($_POST['tuesday']['open']), 'H:i:s');
							$service_days[1]['close_time'] = $this->common_model->getDefaultToGMTDate(strtotime($_POST['tuesday']['close']), 'H:i:s');
							$service_days[1]['is_holiday'] = 'No';
							$service_days[1]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
						}

						if (isset($_POST['wednesday']['open'])) {
							$service_days[2]['user_service_id'] = $business_service_id;
							$service_days[2]['day'] = 'wednesday';
							$service_days[2]['open_time'] = $this->common_model->getDefaultToGMTDate(strtotime($_POST['wednesday']['open']), 'H:i:s');
							$service_days[2]['close_time'] = $this->common_model->getDefaultToGMTDate(strtotime($_POST['wednesday']['close']), 'H:i:s');
							$service_days[2]['is_holiday'] = 'No';
							$service_days[2]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
						}

						if (isset($_POST['thrusday']['open'])) {
							$service_days[3]['user_service_id'] = $business_service_id;
							$service_days[3]['day'] = 'thrusday';
							$service_days[3]['open_time'] = $this->common_model->getDefaultToGMTDate(strtotime($_POST['thrusday']['open']), 'H:i:s');
							$service_days[3]['close_time'] = $this->common_model->getDefaultToGMTDate(strtotime($_POST['thrusday']['close']), 'H:i:s');
							$service_days[3]['is_holiday'] = 'No';
							$service_days[3]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
						}

						if (isset($_POST['friday']['open'])) {
							$service_days[4]['user_service_id'] = $business_service_id;
							$service_days[4]['day'] = 'friday';
							$service_days[4]['open_time'] = $this->common_model->getDefaultToGMTDate(strtotime($_POST['friday']['open']), 'H:i:s');
							$service_days[4]['close_time'] = $this->common_model->getDefaultToGMTDate(strtotime($_POST['friday']['close']), 'H:i:s');
							$service_days[4]['is_holiday'] = 'No';
							$service_days[4]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
						}

						if (isset($_POST['saturday']['open'])) {
							$service_days[5]['user_service_id'] = $business_service_id;
							$service_days[5]['day'] = 'saturday';
							$service_days[5]['open_time'] = $this->common_model->getDefaultToGMTDate(strtotime($_POST['saturday']['open']), 'H:i:s');
							$service_days[5]['close_time'] = $this->common_model->getDefaultToGMTDate(strtotime($_POST['saturday']['close']), 'H:i:s');
							$service_days[5]['is_holiday'] = 'No';
							$service_days[5]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
						}

						if (isset($_POST['sunday']['open'])) {
							$service_days[6]['user_service_id'] = $business_service_id;
							$service_days[6]['day'] = 'sunday';
							$service_days[6]['open_time'] = $this->common_model->getDefaultToGMTDate(strtotime($_POST['sunday']['open']), 'H:i:s');
							$service_days[6]['close_time'] = $this->common_model->getDefaultToGMTDate(strtotime($_POST['sunday']['close']), 'H:i:s');
							$service_days[6]['is_holiday'] = 'No';
							$service_days[6]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
						}

						if ($service_days && !empty($service_days)) {
							$this->services->insertBusinessServiceDays($service_days);
						}

						$service_types = $this->input->post('service_types');

						if ($service_types && !empty($service_types)) {

							foreach ($service_types as $key => $value) {
								$business_service_type[$key]['business_service_id'] = $business_service_id;
								$business_service_type[$key]['service_type_id'] = $key;
								$business_service_type[$key]['is_available'] = $value;
								$business_service_type[$key]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
							}

							if ($business_service_type && !empty($business_service_type)) {
								$this->services->insertBusinessServiceTypes($business_service_type);
							}
						}

						$success = true;
						$message = 'Your business service added successfully.';
						//$data['redirectURL'] = base_url('dashboard');
						$output['redirectURL'] = site_url('admin/services');
					} else {
						$success = false;
						$message = 'Technical error, please try again.';
					}
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
		$this->load->view('admin/services/form');
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