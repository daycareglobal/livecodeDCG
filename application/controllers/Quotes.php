<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quotes extends CI_Controller {
	
	function __construct() {
		Parent::__construct();
		$this->common_model->checkChildcareLogin();
		$this->load->model('front/user_model', 'users');
		$this->load->model('front/provider_quote_model', 'provider_quote');
		$this->load->model('mailsending_model','mailsending');
		$this->childcare_id = $this->session->userdata('childcare_id');
		// $this->common_model->checkChildcarePlanPurchase();
	}
	
	public function index() {
		$output['page'] = 'dashboard';
		$output['page_active'] = 'quote';
		$output['business_provisions'] = $this->users->getUserBusinessWithService($this->childcare_id);
		//pr($output['business_provisions']);die;

		$this->load->view('front/includes/header', $output);
		$this->load->view('front/quote/index');
		$this->load->view('front/includes/footer');
	}

	function ajaxQuoteList()
	{
		$this->load->library('pagination');
		$business_id = $this->input->get('business_id');
		$business_detail = $this->users->getBusinessRecordById($business_id);

		$success = true;
        $html = false;
        $load_prev_link = false;
        $load_next_link = false;
		$per_page = '5';
		$page_no = $this->input->get('page_no')?$this->input->get('page_no'):1;
		$page_no_index = ($page_no - 1) * $per_page;
		$sQuery = '';

		// if ($unique_id) {
		// 	$sQuery = $sQuery.'&unique_id='.$unique_id;
		// }

		$searchData['search_index'] = $page_no_index;
		$searchData['limit'] = $per_page;
		$searchData['business_id'] = $business_id;

	   	$config['base_url'] = site_url('quotes/ajaxQuoteList?'.$sQuery);
		$total_rows = $this->provider_quote->countAddedQuoteData($searchData);

		$config['total_rows'] = $total_rows;
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$paging  = $this->pagination->create_links();

		$records = $this->provider_quote->getAddedQuoteData($searchData);

		foreach ($records as $key => $value) {
			$quote_expire_date = date('d-M-Y', strtotime($value->start_date. ' + 3 days'));
			$value->quote_expire_date = $quote_expire_date;
			$expire =  date('d-M-Y 23:59:59', strtotime($value->start_date. ' + 3 days'));
			$current_time = date('Y-m-d H:i:s');

			if (strtotime($current_time) >= strtotime($expire)){
			    $value->is_expired = 'Yes';
			} else {
			    $value->is_expired = 'No';
			}
		}
		//pr($records);die;
		$output['records'] = $records;
		$output['business_id'] =  $business_id;
		$output['business_detail'] =  $business_detail;
		$html = $this->load->view('front/quote/ajaxQuoteList', $output, true);

		$data['success'] = true;
		$data['html'] = $html;
		$data['paging']	= $paging; 
		echo json_encode($data); die;
	}

	function addQuote()
	{
		$reference_number = $this->input->get('reference_number');
		$checkReferenceNumberExist = $this->provider_quote->getRecordByReferenceNumber($reference_number);

		if ($checkReferenceNumberExist) {

			if ($checkReferenceNumberExist->is_provider_added_quote == 'No') {
				$checkUserBusiness = $this->users->getUserBusinesRecordByUserId($this->childcare_id, $checkReferenceNumberExist->business_id);

				if ($checkUserBusiness) {
					$update = array();
					$update['is_provider_added_quote'] = 'Yes';
					$update['update_date'] = $this->common_model->getDefaultToGMTDate(time());

					$response = $this->provider_quote->update_record($update, $checkReferenceNumberExist->id);

					if ($response) {
						$data['success'] = true;
						$data['message'] = 'Quote added successfully.';

					} else {
						$data['success'] = false;
						$data['message'] = 'Technical error, please try again.';
					}
				} else {
					$data['success'] = false;
					$data['message'] = 'Invalid reference number.';
				}

			} else {
				$data['success'] = false;
				$data['message'] = 'You already added this quote.';
			}

		} else {
			$data['success'] = false;
			$data['message'] = 'Invalid reference number.';
		}
		echo json_encode($data); die;
	}

	function view_quote_detail($reference_number)
	{
		$output['page'] = 'dashboard';
		$output['page_active'] = 'quote';
		$checkReferenceNumberExist = $this->provider_quote->getRecordByReferenceNumber($reference_number);

		if ($checkReferenceNumberExist) {
			$output['save_quote_id'] = $checkReferenceNumberExist->id;

			if ($checkReferenceNumberExist->is_provider_added_quote == 'Yes') {
				$checkUserBusiness = $this->users->getUserBusinesRecordByUserId($this->childcare_id, $checkReferenceNumberExist->business_id);

				if ($checkUserBusiness) {
					$quote_detail = $this->provider_quote->getQuoteDetailById($checkReferenceNumberExist->quote_id);
					
					if ($quote_detail) {
						$sessionData = $this->provider_quote->getSessionData($quote_detail->id);
						$quote_detail->week_type = $sessionData[0]->week_type;
						$output['quote_expire_date'] = date('d-M-Y', strtotime($quote_detail->start_date. ' + 3 days'));
						$quote_session_data = $this->provider_quote->quote_session_data($checkReferenceNumberExist->quote_id);
						$output['sessionTypes'] = $quote_session_data;
						$datetime1 = date('Y-m-d', strtotime($quote_detail->start_date));
						$datetime2 = date('Y-m-d', strtotime($quote_detail->child_date_of_birth));
						$interval = strtotime($datetime1) - strtotime($datetime2);
						$quote_detail->child_age = floor(($interval)/2628000);
						$quote_detail->fees = $checkReferenceNumberExist->fees;
					}
					$output['quote_detail'] = $quote_detail;
				} else {
					echo "<center><strong>Invalid reference number</strong></center>";die;
				}

			} else {
				echo "<center><strong>Invalid reference number</strong></center>";die;
			}

		} else {
			echo "<center><strong>Invalid reference number</strong></center>";die;
		}
		$this->load->view('front/includes/header', $output);
		$this->load->view('front/quote/child_details');
		$this->load->view('front/includes/footer');
	}

	function generatePdf(){ 
		$id = $this->input->get('id');
		$quote_detail = $this->provider_quote->getQuoteById($id);
		$output = array();
		
		if ($quote_detail) {
			$checkUserBusiness = $this->users->getUserBusinesRecordByUserId($this->childcare_id, $quote_detail->business_id);
			
			if ($checkUserBusiness) {
				$detail = $this->provider_quote->getQuoteDetailById($quote_detail->quote_id);

				if ($detail) {
					$sessionData = $this->provider_quote->getSessionData($detail->id);
					$detail->week_type = $sessionData[0]->week_type;
					$output['quote_expire_date'] = date('d-M-Y', strtotime($detail->start_date. ' + 3 days'));
					$quote_session_data = $this->provider_quote->quote_session_data($quote_detail->quote_id);
					$output['sessionTypes'] = $quote_session_data;
					$datetime1 = date('Y-m-d', strtotime($detail->start_date));
					$datetime2 = date('Y-m-d', strtotime($detail->child_date_of_birth));
					$interval = strtotime($datetime1) - strtotime($datetime2);
					$detail->child_age = floor(($interval)/2628000);
					$detail->fees = $quote_detail->fees;
				}
				$output['quote_detail'] = $detail;
			}
		}
		$success = true;
		$html = false;
		$html = $this->load->view('front/quote/pdf',$output,true);
		$admin_pdf = time();
		file_put_contents(ASSETSPATH. 'pdf/'.$admin_pdf.".html", $html);
		$newpdf_path = ASSETSPATH. 'pdf/'.$admin_pdf.".pdf";
		exec ('/usr/local/bin/wkhtmltopdf '. base_url('assets/pdf/').$admin_pdf.'.html '.$newpdf_path." 2>&1 ", $output);
		$data['success'] = true;
		$data['pdf_path'] = base_url('assets/pdf/').$admin_pdf.'.pdf';
		$data['redirectURL'] = site_url('quotes/generatePdf');
		echo json_encode($data); die;
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