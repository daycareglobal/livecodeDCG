<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Services extends CI_Controller {
	
	function __construct() {
		Parent::__construct();
		$this->load->model('front/service_modal', 'service');
		$this->load->model('front/home_model', 'home');
	}
	
	public function index() {

		$output['page'] = 'services';
		$address = $this->input->get('address');
		$latitude = $this->input->get('latitude');
		$longitude = $this->input->get('longitude');
		$service_types = $this->input->get('service_types');
		$check_in = $this->input->get('check_in');
		$check_out = $this->input->get('check_out');
		$radius = 100;
		$service_detail = $this->service->getServices($address, $latitude, $longitude, $service_types, $check_in, $check_out, $radius);
		
		if ($service_detail) {
			// pr($service_detail); die;

			foreach ($service_detail as $key => $value) {				
				$images = $this->service->getServiceImages($value->id);
				$business_service_types = $this->home->getUserBusinessServiceTypes($value->id);
				$value->business_service_days = $this->home->getUserBusinessServiceDays($value->id);
				// $services = $this->service->getProvidedServices($value->id);
				$value->images = $images;
				$value->services = $business_service_types;
			}
		}
		
		if(!empty($service_types)) {
			$service_detail = $this->service->getServiceTypeById($service_types);
			
			if ($service_detail) {
				$service_name = $service_detail->name;
			} else {
				$service_name = '';
			}
			
		} else {
			$service_name = '';
		}
		$output['service_name'] = $service_name;
		$output['address'] = $address;
		$output['latitude'] = $latitude;
		$output['longitude'] = $longitude;
		$output['service_types'] = $service_types;
		$output['check_in'] = $check_in;
		$output['check_out'] = $check_out;

		$this->load->view('front/includes/header', $output);
		$this->load->view('front/services/index');
		$this->load->view('front/includes/footer');
	}

	function get_services()
	{
		//die('here');
		$address = $this->input->get('address');
		$latitude = $this->input->get('latitude');
		$longitude = $this->input->get('longitude');
		$service_types = $this->input->get('service_types');
		$check_in = $this->input->get('check_in');
		$check_out = $this->input->get('check_out');
		$radius = 100;
		$service_detail = $this->service->getServices($address, $latitude, $longitude, $service_types, $check_in, $check_out, $radius);
		
		if ($service_detail) {
			
			foreach ($service_detail as $key => $value) {				
				$images = $this->service->getServiceImages($value->id);
				$business_service_types = $this->home->getUserBusinessServiceTypes($value->id);
				$value->service_days = $this->home->getUserBusinessServiceDays($value->id);
				// $service_days = $this->service->getServiceDays($value->id);
				$value->images = $images;
				$value->services = $business_service_types;
				// $value->service_days = $service_days;
			}
		}
		// pr($service_detail); die;
		$output['services'] = $service_detail;
		$html = $this->load->view('front/services/list', $output, true);
		$data['total_services'] = count($service_detail);
		$data['html'] = $html;
		echo json_encode($data); die;
	}

	public function detail()
	{
		$id = $_GET['sid'];
		$check_in = $_GET['check_in'];
		$check_out = $_GET['check_out'];
		$output['check_in'] = $check_in;
		$output['check_out'] = $check_out;

		if ($id) {
			$service_detail = $this->service->getServiceByID($id);
			
			if ($service_detail) {
				$images = $this->service->getServiceImages($service_detail->id);
				$service_detail->services = $this->home->getUserBusinessServiceTypes($service_detail->id);
				$service_days = $this->home->getUserBusinessServiceDays($service_detail->id);
				$service_detail->images = $images;

				if ($service_days) {

					foreach ($service_days as $k => $val) {
						// $val->open_time = $this->common_model->getGMTDateToLocalDate($val->open_time, 'h:i A');	
						// $val->close_time = $this->common_model->getGMTDateToLocalDate($val->close_time, 'h:i A');
						$val->open_time = $val->open_time;	
						$val->close_time = $val->close_time;
					}
				}
				$service_detail->service_days = $service_days;
				$output['service_detail'] = $service_detail;
				$this->load->view('front/includes/header', $output);
				$this->load->view('front/services/detail');
				$this->load->view('front/includes/footer');

			} else {
				redirect('services');
			}

		} else {
			redirect('services');
		}
	}
}