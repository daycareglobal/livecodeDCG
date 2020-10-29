<?php
/**
* Login controller for Admin
*/
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
	
	function __construct() {
		Parent::__construct();	
		
		$this->common_model->checkAdminLogin();
		$this->common_model->checkLoginAdminStatus();
		$this->load->model('admin/user_model', 'user');
	}

	function index() {
		$output['page_title'] = "Dashboard";
		$output['left_menu'] = 'Dashboard';
		$output['childcare_providers'] = count($this->user->getRecords('Business'));
		$output['request_quote'] = 0;
		$output['membership_plans_fees'] = 0;
		$output['childrens'] = count($this->user->getRecords('User'));

		$this->load->view('admin/includes/header',$output);
		$this->load->view('admin/admin/index');
		$this->load->view('admin/includes/footer');
	}
}