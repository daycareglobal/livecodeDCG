<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Request_quote extends CI_Controller {
	
	function __construct() {
		Parent::__construct();
		$this->common_model->checkAdminLogin();
		$this->load->model('admin/Request_quote_model', 'request_quote');
	}

	function index()
	{   
		$output['page_title'] = 'Request quote';
		$output['left_menu'] = 'request_quote';
		$output['left_submenu'] = 'request_quote_list';
		$request_quote = $this->request_quote->get_request_quote();
		
		foreach ($request_quote as $key => $value) {
			$quote_expire_date = date('d-M-Y', strtotime($value->start_date. ' + 3 days'));
			$value->quote_expire_date = $quote_expire_date;
        	$value->add_date = $this->common_model->getGMTDateToLocalDate($value->add_date);
		}
        $output['request_quote'] = $request_quote;
		$this->load->view('admin/includes/header',$output);
		$this->load->view('admin/request_quote/index');
		$this->load->view('admin/includes/footer');
	}

	function view($id) 
    {
        $record	= $this->request_quote->get_quote_detail_by_id($id);
        if (empty($record)) {
			echo "<center><h1>No record found.</h1></center>";die;
		}
		$output['page_title'] = 'Request quote';
		$output['left_menu'] = 'request_quote';
		$output['left_submenu'] = 'request_quote_list';

		if ($record) {
        	$record->add_date = $this->common_model->getGMTDateToLocalDate($record->add_date);
        	$output['record'] = $record;
		}
        $this->load->view('admin/includes/header',$output);
		$this->load->view('admin/request_quote/view');
		$this->load->view('admin/includes/footer');
    }
}