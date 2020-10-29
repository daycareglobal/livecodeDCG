<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Static_pages extends CI_Controller {
	
	function __construct() {
		Parent::__construct();
		$this->load->model('front/content_model', 'content');
	}
	
	function privacy_policy() {
		$output['page'] = 'privacy_policy';
		$output['record'] = $this->content->getRecordBySlug('privacy-policy');

		$this->load->view('front/includes/header', $output);
		$this->load->view('front/static_pages/privacy_policy');
		$this->load->view('front/includes/footer');
	}

	function about_us() {
		$output['page'] = 'about_us';
		$output['record'] = $this->content->getRecordBySlug('about-us');
		$output['team_description'] = $this->content->getRecordBySlug('team-description');
		$output['teams'] = $this->content->getAboutUsTeam();

		$this->load->view('front/includes/header', $output);
		$this->load->view('front/static_pages/about_us');
		$this->load->view('front/includes/footer');
	}

	function terms_conditions() {
		$output['page'] = 'terms_conditions';
		$output['record'] = $this->content->getRecordBySlug('terms-condition');

		$this->load->view('front/includes/header', $output);
		$this->load->view('front/static_pages/terms_conditions');
		$this->load->view('front/includes/footer');
	}

	function cookie_policy() {
		$output['page'] = 'cookie_policy';
		$output['record'] = $this->content->getRecordBySlug('cookie-policy');

		$this->load->view('front/includes/header', $output);
		$this->load->view('front/static_pages/cookie_policy');
		$this->load->view('front/includes/footer');
	}

	function faq() {
		$output['page'] = 'faq';
		$output['record'] = $this->content->getRecordBySlug('faqs');
		$output['faq_question'] = $this->content->getFaqQuestion();

		$this->load->view('front/includes/header', $output);
		$this->load->view('front/static_pages/faq');
		$this->load->view('front/includes/footer');
	}

	function contact_us() {
		$output['page'] = 'contact_us';
		$output['record'] = $this->content->getRecordBySlug('contact-us');

		if (isset($_POST) && !empty($_POST)) {
			$success = true;

			$this->form_validation->set_rules('first_name', 'Name', 'trim|required|callback_check_space');
			$this->form_validation->set_rules('last_name', 'surname', 'trim|required|callback_check_space');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
			$this->form_validation->set_rules('phone_number', 'Phone Number', 'trim|is_natural|numeric|max_length[13]');
			$this->form_validation->set_rules('message', 'Message', 'trim|required');

			if ($this->form_validation->run()) {
				$input = array();
				$input['name'] = $this->input->post('first_name');
				$input['last_name'] = $this->input->post('last_name');
				$input['email'] = $this->input->post('email');
				$input['phone_number'] = $this->input->post('phone_number');
				$input['message'] = $this->input->post('message');
				$input['add_date'] = $this->common_model->getDefaultToGMTDate(time());
				$contact_id = $this->content->insert_contact_record($input);
				
				if ($contact_id) {
					$message = 'Thank you for contact with us, we will get back to you soon.';
					$success = true;
					$data['resetForm'] = true;

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

		$this->load->view('front/includes/header', $output);
		$this->load->view('front/static_pages/contact_us');
		$this->load->view('front/includes/footer');
	}

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