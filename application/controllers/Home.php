<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	
	function __construct() {
		Parent::__construct();
		$this->load->model('front/home_model', 'home');
		$this->load->model('front/client_feedback_model', 'client_feedback');
		$this->load->model('front/service_category_model', 'service_category');
		$this->load->model('front/business_types_model', 'business_type');
	}

	/*public function index() {
		$output['page'] = 'home';
		$output['client_feedback'] = $this->client_feedback->getRecords(2);
		$output['service_types'] = $this->service_category->getActiveRecords();

		$this->load->view('front/includes/header', $output);
		$this->load->view('front/home/index');
		$this->load->view('front/includes/footer');
	}*/

	public function index() {
		$output['page'] = 'home';
		$output['extra_class'] = 'homepage';
		$output['client_feedback'] = $this->client_feedback->getRecords(2);
		// $output['service_types'] = $this->service_category->getActiveRecords();
		$output['service_types'] = $this->business_type->getActiveRecords();
		$output['our_values_content'] = $this->home->getHomePageContent('our-values');
		// pr($output['our_values_content'][0]->title); die;
		$this->load->view('front/includes/header', $output);
		$this->load->view('front/home/index');
		$this->load->view('front/includes/footer');
	}

	function search()
	{
		$address = $this->input->post('address');
		$latitude = $this->input->post('latitude');
		$longitude = $this->input->post('longitude');
		$service_types = $this->input->post('service_types');
		$check_in = $this->input->post('check_in');
		$check_out = $this->input->post('check_out');

		$dteStart = new DateTime($check_in);
   		$dteEnd   = new DateTime($check_out);
		$dteDiff  = $dteStart->diff($dteEnd);
		$hours = $dteDiff->h;
		$total_hours = $hours + ($dteDiff->days*24);
		// pr($dteDiff);die;
		// $total_hours = $dteDiff->format("%H");

		if (!empty($check_in) && !empty($check_out)) {

			if ($total_hours >= 1) {
				// print();die;
				$redirect_url = base_url().'services?address='.$address.'&latitude='.$latitude.'&longitude='.$longitude.'&service_types='.$service_types.'&check_in='.$check_in.'&check_out='.$check_out; 
				$data['success'] = true;
				$data['message'] = false;
				$data['redirectURL'] = $redirect_url;
				echo json_encode($data); die;

			} else {
				$data['success'] = false;
				$data['message'] = 'Your check-in and check-out time must have atleast 1 hour difference.';
				echo json_encode($data); die;
			}

		} else {
			$redirect_url = base_url().'services?address='.$address.'&latitude='.$latitude.'&longitude='.$longitude.'&service_types='.$service_types.'&check_in='.$check_in.'&check_out='.$check_out; 
			$data['success'] = true;
			$data['message'] = false;
			$data['redirectURL'] = $redirect_url;
			echo json_encode($data); die;
		}

	}
}