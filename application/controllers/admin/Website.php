<?php
/**
* Login controller for Admin
*/
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Website extends CI_Controller {
	
	function __construct() {
		Parent::__construct();
		$this->common_model->checkAdminLogin();
		$this->load->model('admin/website_model', 'website');
	}

	function index() {
		$output['page_title'] = "Website Setting";
		$output['left_menu'] = 'Site_options';
		$output['left_submenu'] = 'Website_setting';
		
		$output['message']    = '';
		if ($_POST) {
			$this->form_validation->set_rules('smtp_host', 'SMTP Host', 'trim|required');
			$this->form_validation->set_rules('smtp_port', 'SMTP Post Number', 'trim|required');
			$this->form_validation->set_rules('smtp_user', 'SMTP Username', 'trim|required');
			$this->form_validation->set_rules('smtp_pass', 'SMTP Password', 'trim|required');
			$this->form_validation->set_rules('copyright_text', 'Copyright Text', 'required|trim');
			$this->form_validation->set_rules('contact_phone', 'Contact Number', 'required|trim');
			$this->form_validation->set_rules('contact_email', 'Contact Email', 'trim|required|valid_email');
			// $this->form_validation->set_rules('facebook_link', 'Facebook Link', 'trim|required');
			// $this->form_validation->set_rules('instagram_link', 'Instagram Link', 'trim|required');
			// $this->form_validation->set_rules('you_tube_link', 'You Tube Link', 'trim|required');
			
			// $this->form_validation->set_rules('google_analytics', 'Google Analytics', 'trim|required');
			// $this->form_validation->set_rules('mailchimp_api_key', 'Mailchimp API Key', 'trim|required');
			// $this->form_validation->set_rules('mailchimp_list_id', 'Mailchimp List Id', 'trim|required');
			// $this->form_validation->set_rules('mailchimp_datacenter', 'Mailchimp Datacenter', 'trim|required');
			// $this->form_validation->set_rules('contact_phone', 'Contact Phone Number', 'trim|required|min_length[7]|max_length[15]|numeric');
			// $this->form_validation->set_rules('contact_address', 'Contact Address', 'trim|required');
			// $this->form_validation->set_rules('latitude', 'Contact Address', 'trim|required');
			// $this->form_validation->set_rules('longitude', 'Contact Address', 'trim|required');
			// $this->form_validation->set_rules('google_site_key', 'Google Site Key', 'trim|required');
			// $this->form_validation->set_rules('google_secret_key', 'Google Secret Key', 'trim|required');
			// $this->form_validation->set_rules('paypal_business_email', 'Paypal Business Email', 'trim|required');
			// $this->form_validation->set_rules('facebook_link', 'Facebook Link', 'trim|required');
			// $this->form_validation->set_rules('twitter_link', 'Twitter Link', 'trim|required');
			// $this->form_validation->set_rules('you_tube_link', 'You Tube Link', 'trim|required');
			// $this->form_validation->set_rules('linkedin_link', 'Linkedin Link', 'trim|required');
			// $this->form_validation->set_rules('google_plus_link', 'Google Plus Link', 'trim|required');
			// $this->form_validation->set_rules('single_job_price', 'Single Job Price', 'trim|required');
			// $this->form_validation->set_rules('expire_job_in_days', 'Expire Job in Days', 'trim|required|numeric');
			// $this->form_validation->set_rules('allow_free_job_post', 'Allow Free Job Post', 'trim|required');
			// $this->form_validation->set_rules('rss_feed_link', 'Rss Feed Link', 'trim|required');
			// $this->form_validation->set_rules('kvk_number', 'KVK Number', 'trim|required|numeric');
			// $this->form_validation->set_rules('suggestion_mail_to_users', 'Max users for suggestion mail', 'trim|required|numeric');
			// $this->form_validation->set_rules('copyright_text', 'Copyright Text', 'required|trim');
			// $copyright_text = $this->input->post('copyright_text');
			
			if ($this->form_validation->run()) 
			{
				$options = $_POST;
				$this->website->updateOptionsSetting($options);			
				$message = 'Record Updated Successfully';
				$success = true;			
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
		$fields = array(                   
                'smtp_host',
                'smtp_port',
                'smtp_user',
                'smtp_pass',
                'copyright_text',
                'mailchimp_api_key',
                'mailchimp_list_id',
                'mailchimp_datacenter',
                'contact_phone',
                'contact_address',
                'contact_email',
                'website_logo',
            );
        $options_data = array();
        
        if(!empty($fields))
        {
            foreach ($fields as $value) 
            {
                $options_data[$value] = $this->website->getValueBySlug($value, true);
            }
        }

        $output['copyright_text'] 	= $this->common_model->getOptionValue('copyright_text');
        $output['contact_email'] 	= $this->common_model->getOptionValue('contact_email');
        $output['contact_phone'] 	= $this->common_model->getOptionValue('contact_phone');
        $output['options_content'] 	= (object) $options_data;

		$this->load->view('admin/includes/header',$output);
		$this->load->view('admin/setting/index');
		$this->load->view('admin/includes/footer');
	}
}