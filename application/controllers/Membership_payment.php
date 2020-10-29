<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Membership_payment extends CI_Controller {
	
	function __construct() {
		Parent::__construct();
		$this->common_model->checkChildcareLogin();
		$this->load->model('front/user_model', 'users');
		$this->load->model('front/Plan_model', 'plan');
		$this->load->model('mailsending_model','mailsending');
		$this->childcare_id = $this->session->userdata('childcare_id');
	}
	
	public function index() {
		$output['page'] = 'dashboard';
		$output['page_active'] = 'fees_availiability';

		$this->load->view('front/includes/header', $output);
		$this->load->view('front/fees_availiability/index');
		$this->load->view('front/includes/footer');
	}

	/**
	* my_membership using Membership_payment controller.
	* @category   apps
	* @package    get my membership plan
	* @subpackage controllers
	* @author     Created By Reena Singh (24-04-2019)
	* @copyright  2019 Daycare
	*/
    function my_membership() {
		$output['page'] = 'dashboard';
		$output['page_active'] = 'my_membership';
		$childcare_id = $this->session->userdata('childcare_id');
		$membership = $this->plan->getMemberShipPlanByUserId($childcare_id);

		$user_last_plan = $this->users->getUserLastPlan($childcare_id);

		if ($user_last_plan) {
			$output['plan_exist'] = 'Yes';

		} else {
			$output['plan_exist'] = 'No';
		}

		if ($membership) {
			$plan_type = $membership->plan_type;
			$membership_plan_type = $membership->membership_plan_type;
			$month = $membership->month;

			if ($membership_plan_type == 'Free') {
				$months = '+'.$month.' months';
				$membership->plan_exipry_date = date('d M, Y', strtotime($months, strtotime($membership->add_date)));

			} else {

				if ($plan_type == 'Monthly') {
					$membership->plan_exipry_date = date('d M, Y', strtotime("+1 months", strtotime($membership->add_date)));

				} else {
					$membership->plan_exipry_date = date('d M, Y', strtotime("+12 months", strtotime($membership->add_date)));
				}
			}
		}
		$output['membership'] = $membership;
		$this->load->view('front/includes/header', $output);
		$this->load->view('front/plan/my_membership');
		$this->load->view('front/includes/footer');
	}

	/**
	* cancel_plan using Membership_payment controller.
	* @category   apps
	* @package    cancel plan
	* @subpackage controllers
	* @author     Created By Reena Singh (24-04-2019)
	* @copyright  2019 Daycare
	*/
	function cancel_plan() {
		$output['page'] = 'dashboard';
		$output['page_active'] = 'cancel_plan';
		$output['memberShipCancelation'] = $this->plan->getMemberShipCancelation();
		$running_plan = $this->plan->getRunningPlan($this->childcare_id);
		$output['running_plan'] = $running_plan;

		if (empty($running_plan)) {
			redirect(base_url('purchase-plan'));
		}
		$this->load->view('front/includes/header', $output);
		$this->load->view('front/plan/cancel_plan');
		$this->load->view('front/includes/footer');
	}

	/**
	* cancelMemberShipPlan using Membership_payment controller.
	* @category   apps
	* @package    cancel plan by ajax
	* @subpackage controllers
	* @author     Created By Reena Singh (24-04-2019)
	* @copyright  2019 Daycare
	*/
	// function cancelMemberShipPlan()	{
	// 	$success = true;
	// 	$message = '';
	// 	$cancelPlan = array();
	// 	$user_id = $this->session->userdata('childcare_id');
	// 	$type = $this->input->post('cancelation_id');
		
	// 	if ($type == 'Other') {
			
	// 		if (!empty($this->input->post('other'))) {
	// 			$success = true;
	// 			$message = '';
	// 		} else {
	// 			$success = false;
	// 			$message = 'The other field is required';
	// 		}
	// 	}

	// 	if ($success) {
	// 		$is_cancel_plan_exist = $this->plan->getCancelledPlan($user_id);
	// 		pr($is_cancel_plan_exist);die;
			
	// 		if ($is_cancel_plan_exist->plan_status == 'Expired') {
	// 			$success = false;
	// 			$message = 'This plan has been expired';
			
	// 		} else if ($is_cancel_plan_exist->plan_status == 'Cancelled') {
	// 			$success = false;
	// 			$message = 'This plan has been cancelled';

	// 		} else {
	// 			$plan_status = 'Cancelled';
				
	// 			if ($type == 'Other') {
	// 				$cancelPlan['cancelation_id'] = '';
	// 				$cancelPlan['cancelation_reason'] = $this->input->post('other');
				
	// 			} else {
	// 				$cancelPlan['cancelation_id'] = $type;
	// 				$cancelPlan['cancelation_reason'] = '';
	// 			}
	// 			$cancelPlan['plan_status'] = $plan_status;
	// 			$this->plan->cancelPlanByUserId($user_id,$cancelPlan);
	// 			$success = true;
	// 			$message = 'Membership plan has been cancelled successfully';
	// 			$data['redirectURL'] = base_url('my-membership');
	// 		}
	// 	}
	// 	$data['success'] = $success;
	// 	$data['message'] = $message;
	// 	echo json_encode($data);
	// }

	function cancelMemberShipPlan()	{
		$success = true;
		$message = '';
		$cancelPlan = array();

		$this->form_validation->set_rules('exist_plan_id', 'Exist Plan', 'trim|required', array('required' => 'Sorry!!! Somthing went wrong.'));
		$this->form_validation->set_rules('cancelation_id', 'Reasion', 'trim|required');
		$type = $this->input->post('cancelation_id');
		
		if ($type == 'Other') {
			$this->form_validation->set_rules('other', 'Reasion', 'trim|required', array('required' => 'Please enter reasion for cancel plan.'));
		}

		if ($this->form_validation->run()) {
			$checkPlanExist = $this->plan->getPlanById($this->input->post('exist_plan_id'));
				
			if ($checkPlanExist->plan_status == 'Expired') {
				$success = false;
				$message = 'This plan already expired.';
			
			} else if ($checkPlanExist->plan_status == 'Cancelled') {
				$success = false;
				$message = 'This plan already cancelled.';

			} else {
				$cancelPlan = array();

				if ($type == 'Other') {
					$cancelPlan['cancelation_id'] = Null;
					$cancelPlan['cancelation_reason'] = $this->input->post('other');
				
				} else {
					$cancelPlan['cancelation_id'] = $type;
					$cancelPlan['cancelation_reason'] = Null;
				}
				$cancelPlan['plan_status'] = 'Cancelled';
				$cancelPlan['update_date'] = $this->common_model->getDefaultToGMTDate(time());
				$this->plan->cancelPlanById($checkPlanExist->id, $cancelPlan);

				$userData['plan_active'] = 'No';
				$userData['update_date'] = $this->common_model->getDefaultToGMTDate(time());
				$this->users->update_record($userData, $this->childcare_id);//for tbl_user

				$success = true;
				$message = 'Membership plan has been cancelled successfully';
				$data['redirectURL'] = base_url('my-membership');
			}
		
		} else {
			$message = validation_errors();
			$success = false;
		}
		
	    $data['success'] = $success;
		$data['message'] = $message;
	    echo json_encode($data); die;
	}


	/**
	* billing_history using Membership_payment controller.
	* @category   apps
	* @package    get billing history
	* @subpackage controllers
	* @author     Created By Reena Singh (24-04-2019)
	* @copyright  2019 Daycare
	*/
	function billing_history() {
		$output['page'] = 'dashboard';
		$output['page_active'] = 'billing_history';
		$user_id = $this->session->userdata('childcare_id');
		$output['billingHistory'] = $this->plan->getBillingHistoryByUserId($user_id);
		//pr($output['billingHistory']);die;
		$allBillingHistory = $this->plan->getAllBillingHistoryByUserId($user_id);
		$output['allBillingHistory'] = count($allBillingHistory);
		// pr($output);die;

		$this->load->view('front/includes/header', $output);
		$this->load->view('front/plan/billing_history');
		$this->load->view('front/includes/footer');
	}

	function generatePdf(){ 
		$id = $this->input->get('id');
		$plan_name = $this->input->get('plan_name');
		$plan_type = $this->input->get('plan_type');
		$amount = $this->input->get('amount');
		$annual_discount = $this->input->get('annual_discount');
		$add_date = $this->input->get('add_date');
		$expiry_date = $this->input->get('expiry_date');
		$success = true;
		$html = false;
		$output['id'] = $id;
		$output['plan_name'] = $plan_name;
		$output['plan_type'] = $plan_type;
		$output['amount'] = $amount;
		
		if ($annual_discount) {
			$output['annual_discount'] = $annual_discount;
		}
		$output['add_date'] = $add_date;
		$output['expiry_date'] = $expiry_date;
		$html = $this->load->view('front/plan/pdf',$output,true);
		$admin_pdf = time();
		file_put_contents(ASSETSPATH. 'pdf/'.$admin_pdf.".html", $html);
		$newpdf_path = ASSETSPATH. 'pdf/'.$admin_pdf.".pdf";
		exec ('/usr/local/bin/wkhtmltopdf '. base_url('assets/pdf/').$admin_pdf.'.html '.$newpdf_path." 2>&1 ", $output);
		$data['success'] = true;
		$data['pdf_path'] = base_url('assets/pdf/').$admin_pdf.'.pdf';
		$data['redirectURL'] = site_url('membership_payment/generatePdf');
		echo json_encode($data); die;
	}
	
	/**
	* get_billing_history using Membership_payment controller.
	* @category   apps
	* @package    get  all billing history by ajax
	* @subpackage controllers
	* @author     Created By Reena Singh (24-04-2019)
	* @copyright  2019 Daycare
	*/
	function get_billing_history() {
		$user_id = $this->session->userdata('childcare_id');
		$output['billingHistory'] = $this->plan->getAllBillingHistoryByUserId($user_id);
        $html = $this->load->view('front/plan/ajax_billing_history',$output, true);
        $data['html'] = $html;
        $data['success']= true;
        echo json_encode($data);die; 
    }

    function delete_user_account() {
		$user_businesses = $this->users->getUserBusinesRecords($this->childcare_id);

		if ($user_businesses) {
			$business_ids = array();

			foreach ($user_businesses as $key => $value) {
				$business_ids[] = $value->id;
			}

			$this->users->deleteUserBusinessRoomAvailability($business_ids);//delete user business rooms availability
			$this->users->deleteUserBusinessTiming($business_ids);//delete user business timming
			$this->users->deleteUserBusinessRooms($business_ids);//delete user business rooms
			$this->users->deleteUserBusinessMonthlyFees($business_ids);//delete user business monthly fees
			$this->users->deleteUserBusinessSessions($business_ids);//delete user business sessions
			$this->users->deleteUserBusinessSessionsDays($business_ids);//delete user business sessions
			$this->users->deleteUserBusinessAgeGroup($business_ids);//delete user business age group
			$this->users->deleteUserBusiness($business_ids);//delete user business sessions

			$this->users->deleteUserSaveQuotes($business_ids);//delete user Save Quotes
		}

		$user_provisions = $this->users->getUserProvisions($this->childcare_id);

		if ($user_provisions) {
			$service_type_ids = array();
			$user_service_detail_ids = array();

			foreach ($user_provisions as $k_provision => $v_provision) {
				$service_type_ids[] = $v_provision->service_type_id;
				$user_service_detail_ids[] = $v_provision->id;
			}

			$this->users->deleteUserSpecialEducation($user_service_detail_ids);//delete user Special Education
			$this->users->deleteUserOwnEducation($user_service_detail_ids);//delete user Own Education

			$this->users->deleteUserActivity($user_service_detail_ids);//delete user Activity
			$this->users->deleteUserOwnActivity($user_service_detail_ids);//delete user Own Activity

			$this->users->deleteUserServices($this->childcare_id);//delete user services
			$this->users->deleteUserServices_temp($this->childcare_id);//delete user services
			$this->users->deleteUserProvisions($this->childcare_id);//delete user provisions
		}

		$this->users->deleteUserSentEmails($this->childcare_id);//delete user send emails
		$this->users->deleteUserEmail_temp($this->childcare_id);//delete user emails from temp table
		$this->users->deleteUserMembershipPlan_temp($this->childcare_id);//delete user membership plan from temp table
		$delete_respo = $this->users->deleteUserMembershipPlan($this->childcare_id);//delete user membership plan

		if ($delete_respo) {
			$message = 'Your account has been delete successfully.';
			$success = true;
			$data['redirectURL'] = base_url('logout');

		} else {
			$message = 'Technical error, Please try again.';
			$success = false;
		}

        $data['message'] = $message;
        $data['success']= $success;
        echo json_encode($data);die; 
    }

    function check_space($value) {
        if ( ! preg_match("/^[a-zA-Z'0-9_@#$^&%*)(_+}{;:?\/., -]*$/", $value) ) {
           $this->form_validation->set_message('check_space', 'The %s field should contain only letters, numbers or periods');
           return false;
        }
        else
        return true;
    }
}