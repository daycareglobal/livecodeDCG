<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Payment_history extends CI_Controller {
	
	function __construct() {
		Parent::__construct();
		$this->common_model->checkAdminLogin();
		$this->load->model('admin/Payment_history_model', 'payment_history');
	}

	function index()
	{   
		$output['page_title'] = 'Payment history';
		$output['left_menu'] = 'payment_history';
		$output['left_submenu'] = 'payment_history_list';
		$payment_history = $this->payment_history->get_payment_history();
		
		foreach ($payment_history as $key => $value) {
        	$value->add_date = $this->common_model->getGMTDateToLocalDate($value->add_date);
		}
        $output['payment_history'] = $payment_history;
		$this->load->view('admin/includes/header',$output);
		$this->load->view('admin/payment_history/index');
		$this->load->view('admin/includes/footer');
	}

	function view($id) 
    {
        $record	= $this->payment_history->get_payment_history_by_id($id);
        if (empty($record)) {
			echo "<center><h1>No record found.</h1></center>";die;
		}
		$output['page_title'] = 'Payment history';
		$output['left_menu'] = 'payment_history';
		$output['left_submenu'] = 'payment_history_list';

		if ($record) {
        	$record->add_date = $this->common_model->getGMTDateToLocalDate($record->add_date);
        	$output['record'] = $record;
		}
        $this->load->view('admin/includes/header',$output);
		$this->load->view('admin/payment_history/view');
		$this->load->view('admin/includes/footer');
    }
}