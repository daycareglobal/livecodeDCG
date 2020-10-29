<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Plan extends CI_Controller {
	
	function __construct() {
		Parent::__construct();
		$this->common_model->checkChildcareLogin();
		$this->load->model('front/user_model', 'users');
		$this->load->model('front/plan_model', 'plans');
		$this->load->model('stripe_model', 'stripe');
		$this->childcare_id = $this->session->userdata('childcare_id');
	}
	
	function purchase_plan() {
		$user_exist_plan = $this->plans->getRunningPlan($this->childcare_id);

		if ($user_exist_plan) {
			redirect('my-membership');
		}
		$output['page'] = 'purchase_plan';
		$membership_plans = $this->plans->getMembershipPlans();

		foreach ($membership_plans as $key => $value) {
			
			if ($value->plan_type == 'Free') {
				$checkFreePlanUse = $this->plans->getUserFreePlanByUserId($this->childcare_id, $value->id);
				
				if ($checkFreePlanUse) {
					unset($membership_plans[$key]);
				}
			}
		}
		$output['membership_plans'] = $membership_plans;
		$this->load->view('front/includes/header', $output);
		$this->load->view('front/plan/plan_list');
		$this->load->view('front/includes/footer');
	}

	function provision()
	{
		$plan = $this->input->get('plan');
		$plan_type = $this->input->get('plan_type');

		$output['page'] = 'purchase_plan';
		$output['plan'] = $plan;
		$output['plan_type'] = $plan_type;
		$plan_detail = $this->plans->getMembershipPlanBySlug($plan);
		$checkFreePlanUse = $this->plans->getUserFreePlanByUserId($this->childcare_id, $plan_detail->id);

		if ($plan_detail->plan_type == 'Free' && $checkFreePlanUse) {
			redirect('purchase-plan');
		} else {
			$output['plan_detail'] = $plan_detail;
			$output['provisions'] = $this->plans->getServiceType();

			if ($this->input->post()) {
				$not_numeric_provision = false;
				$provision = $this->input->post('provision');

				foreach ($provision as $key => $value) {

					if (!empty($value['number'])) {

						if (is_numeric($value['number'])) {

						} else {
							$not_numeric_provision = true;
						}
					}
				}

				if ($not_numeric_provision) {
					$this->form_validation->set_rules('provision', 'Provision number', 'trim|required', array('required' => '%s should contain only numeric value.')); 
				}
				$this->form_validation->set_rules('provision[]', 'Provision', 'trim|required');

				if ($this->form_validation->run()) {
					$provision = $this->input->post('provision');
					$number_of_provisions = 0;

					foreach ($provision as $key => $value) {

						if ($value['number'] && !empty($value['number'])) {
							$number_of_provisions = $number_of_provisions + $value['number'];
						}
					}

					if ($number_of_provisions < 1) {
						$message = 'Please select atleast One Provision.';
						$success = false;

					} else {

						if ($number_of_provisions > $plan_detail->provision_allowed) {
							$message = 'Number of provision should be lesser or equal than your plan choosed.';
							$success = false;
						} else {
							$input = array();
							$input['membership_plan_id'] = $plan_detail->id;
							$input['user_id'] = $this->childcare_id;
							$input['plan_type'] = $plan_type;
							$input['add_date'] = $this->common_model->getDefaultToGMTDate(time());

							if ($plan_detail->plan_type == 'Free') {
								$user_plan_id = $this->users->insert_user_plan($input);

							} else {
								$user_plan_id = $this->users->insert_user_plan_temp($input);
							}

							if ($user_plan_id) {
								$inputProvision = array();

								foreach ($provision as $key => $value) {

									if ($value['number'] && !empty($value['number'])) {
										// $number_of_provisions = $number_of_provisions + $value['number'];
										$inputProvision[$key]['user_id'] = $this->childcare_id;
										$inputProvision[$key]['user_plan_id'] = $user_plan_id;
										$inputProvision[$key]['service_type_id'] = $value['id'];
										$inputProvision[$key]['provisions'] = $value['number'];
										$inputProvision[$key]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
									}
								}

								if (!empty($inputProvision)) {

									if ($plan_detail->plan_type == 'Free') {
										$this->users->insert_provision_data($inputProvision);
										$data['redirectURL'] = site_url('my-profile');

									} else {
										$this->users->insert_provision_data_temp($inputProvision);
										$data['redirectURL'] = site_url('plan/payment/').$user_plan_id;
									}
								}

								$success = true;
								$message = 'Provision submitted successfully.';

							} else {
								$success = false;
								$message = 'Technical error, Please try again.';
							}
						}
					}

				} else {
					$message = validation_errors();
					$success = false;
				}

				$data['message'] = $message;
				$data['success'] = $success;
				echo json_encode($data);die;
			}
		}


		$this->load->view('front/includes/header', $output);
		$this->load->view('front/plan/number_of_provisions');
		$this->load->view('front/includes/footer');
	}

	function payment($user_plan_id)
	{
		$user_plan_detail = $this->users->getUserPlanById($user_plan_id, $this->childcare_id);

		if ($user_plan_detail) {
			$plan_detail = $this->plans->getMembershipPlanById($user_plan_detail->membership_plan_id);
			$output['page'] = 'purchase_plan';
			$output['user_plan_id'] = $user_plan_id;

			if ($plan_detail) {

				if ($plan_detail->plan_type == 'Free') {
					redirect(base_url('dashboard'));

				} else {
					$plan_price = $plan_detail->price;
					$annual_discount = $plan_detail->annual_discount;

					if ($user_plan_detail->plan_type == 'Monthly') {
						$output['price'] = $plan_price;

					} else {
						$plan_price = $plan_price * 12;

						if ($annual_discount && !empty($annual_discount)) {
							$discount_price = $plan_price * $annual_discount / 100;
							$plan_price = $plan_price - $discount_price;
						}

						$output['price'] = $plan_price;
					}
				}

			} else {
				$success = false;
				$message = 'Technical error, Please try again.';

				$data['message'] = $message;
				$data['success'] = $success;
				echo json_encode($data);die;
			}

		} else {
			$success = false;
			$message = 'Invalid Request.';

			$data['message'] = $message;
			$data['success'] = $success;
			echo json_encode($data);die;
		}

		$this->load->view('front/includes/header', $output);
		$this->load->view('front/plan/payment');
		$this->load->view('front/includes/footer');
	}

	function make_payment()
	{
		$stripe_token = $this->input->post('stripe_token');
		$user_plan_id = $this->input->post('user_plan_id');

		$this->form_validation->set_rules('company', 'company', 'trim');
		$this->form_validation->set_rules('first_name', 'first name', 'required');
		$this->form_validation->set_rules('last_name', 'last name', 'required');
		$this->form_validation->set_rules('country', 'country', 'required');
		$this->form_validation->set_rules('postal_code', 'postal code', 'required');
		$this->form_validation->set_rules('card_type', 'card type', 'required');
		$this->form_validation->set_rules('card_number', 'card number', 'required');
		$this->form_validation->set_rules('expiry_month', 'expiry month', 'required');
		$this->form_validation->set_rules('expiry_year', 'expiry year', 'required');
		$this->form_validation->set_rules('stripe_token', 'stripe token', 'required');

		if ($this->form_validation->run()) {
			$amount = $this->input->post('amount');

			if ($stripe_token && $user_plan_id) {
				$user_plan_detail = $this->users->getUserPlanById($user_plan_id, $this->childcare_id);
				$user_plan_services_detail = $this->users->getUserServiceByPlanId($user_plan_detail->id);

				if ($user_plan_detail) {
					$plan_detail = $this->plans->getMembershipPlanById($user_plan_detail->membership_plan_id);//Get Plan detail Free/Paid
					$response = $this->stripe->redeem_amount($stripe_token, $amount, $user_plan_detail->email);

					if ($response['success']) {
						$user_exist_plan = $this->plans->getRunningPlan($this->childcare_id);

						if ($user_exist_plan) {
							$memberData['plan_status'] = 'Cancelled';
							$memberData['update_date'] = $this->common_model->getDefaultToGMTDate(time());
							$this->users->updateOldPlanStatus($memberData, $user_exist_plan->id);//from tbl_user_membership_plan
						}

						//calculate plan expiry date
						$membership_plan_type = $plan_detail->plan_type;
						$month = $plan_detail->month;

						if ($membership_plan_type == 'Free') {
							$months = '+'.$month.' months';
							$plan_expiry_date = date('Y-m-d', strtotime($months, strtotime($this->common_model->getDefaultToGMTDate(time()))));

						} else {

							if ($user_plan_detail->plan_type == 'Monthly') {
								$plan_expiry_date = date('Y-m-d', strtotime("+1 months", strtotime($this->common_model->getDefaultToGMTDate(time()))));

							} else {
								$plan_expiry_date = date('Y-m-d', strtotime("+12 months", strtotime($this->common_model->getDefaultToGMTDate(time()))));
							}
						}

						$input = array();
						$input['membership_plan_id'] = $user_plan_detail->membership_plan_id;
						$input['user_id'] = $user_plan_detail->user_id;
						$input['plan_type'] = $user_plan_detail->plan_type;
						$input['amount'] = $amount;
						$input['company'] = $this->input->post('company');
						$input['card_holder_name'] = $this->input->post('first_name').' '.$this->input->post('last_name');
						$input['country'] = $this->input->post('country');
						$input['postal_code'] = $this->input->post('postal_code');
						$input['card_type'] = $this->input->post('card_type');
						$input['card_number'] = $this->input->post('card_number');
						$input['expiry_month_year'] = $this->input->post('expiry_month').'/'.$this->input->post('expiry_year');
						$input['stripe_token'] = $this->input->post('stripe_token');
						$input['plan_expiry_date'] = $plan_expiry_date;
						$input['add_date'] = $this->common_model->getDefaultToGMTDate(time());
						$user_plan_id = $this->users->insert_user_plan($input);

						if ($user_plan_id) {
							$userData['plan_active'] = 'Yes';
							$userData['update_date'] = $this->common_model->getDefaultToGMTDate(time());
							$this->users->update_record($userData, $this->childcare_id);//for tbl_user

							$inputProvision = array();

							foreach ($user_plan_services_detail as $key => $value) {
								$inputProvision[$key]['user_id'] = $value->user_id;
								$inputProvision[$key]['user_plan_id'] = $user_plan_id;
								$inputProvision[$key]['service_type_id'] = $value->service_type_id;
								$inputProvision[$key]['provisions'] = $value->provisions;
								$inputProvision[$key]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
							}

							if (!empty($inputProvision)) {
								$this->users->insert_provision_data($inputProvision);
							}

							$this->users->delete_user_membership_temp_data($user_plan_detail->id);
							$success = true;
							$message = 'Plan purchased successfully.';
							$data['redirectURL'] = base_url('dashboard');

						} else {
							$success = false;
							$message = 'Technical error, Please try again.';
						}

					} else {
						$success = false;
						$message = $response['message'];
					}

				} else {
					$success = false;
					$message = 'User Plan detail Missing.';
				}

			} else {
				$message = 'Please enter valid card detail.';
				$success = false;
			}

		} else {
			$message = validation_errors();
			$success = false;
			$data['redirectURL'] = site_url('plan/payment/').$user_plan_id;
		}

		$data['message'] = $message;
		$data['success'] = $success;
		echo json_encode($data);die;
	}
	/*change plan functions Start*/
	function change_plan() {
		/*$user_exist_plan = $this->plans->getRunningPlan($this->childcare_id);

		if ($user_exist_plan) {
			redirect('my-membership');
		}*/

		$user_last_plan = $this->users->getUserLastPlan($this->childcare_id);

		if (!$user_last_plan) {
			redirect('purchase-plan');
		}

		$output['page'] = 'purchase_plan';
		$membership_plans = $this->plans->getMembershipPlans();

		foreach ($membership_plans as $key => $value) {
			
			if ($value->plan_type == 'Free') {
				$checkFreePlanUse = $this->plans->getUserFreePlanByUserId($this->childcare_id, $value->id);
				
				if ($checkFreePlanUse) {
					unset($membership_plans[$key]);
				}
			}
		}
		$output['membership_plans'] = $membership_plans;
		$this->load->view('front/includes/header', $output);
		$this->load->view('front/change_plan/plan_list');
		$this->load->view('front/includes/footer');
	}

	function choose_provision()
	{
		// $user_exist_plan = $this->common_model->checkChildcarePlanPurchase();
		$plan = $this->input->get('plan');
		$plan_type = $this->input->get('plan_type');

		$output['page'] = 'purchase_plan';
		$output['plan'] = $plan;
		$output['plan_type'] = $plan_type;
		$plan_detail = $this->plans->getMembershipPlanBySlug($plan);
		$checkFreePlanUse = $this->plans->getUserFreePlanByUserId($this->childcare_id, $plan_detail->id);
		$user_exist_plan = $this->users->getUserLastPlan($this->childcare_id);

		if ($plan_detail->plan_type == 'Free' && $checkFreePlanUse) {
			redirect('purchase-plan');

		} else {
			$output['plan_detail'] = $plan_detail;
			$provisions = $this->plans->getServiceType();

			foreach ($provisions as $key => $value) {
				$userProvisionDetail = $this->plans->getProvisionsById($value->id, $user_exist_plan->id);

				if ($userProvisionDetail) {
					$value->provisions_count = $userProvisionDetail->provisions;

				} else {
					$value->provisions_count = '';
				}
			}
			$output['provisions'] = $provisions;

			if ($this->input->post()) {
				$not_numeric_provision = false;
				$provision = $this->input->post('provision');

				foreach ($provision as $key => $value) {

					if (!empty($value['number'])) {

						if (is_numeric($value['number'])) {

						} else {
							$not_numeric_provision = true;
						}
					}
				}

				if ($not_numeric_provision) {
					$this->form_validation->set_rules('provision', 'Provision number', 'trim|required', array('required' => '%s should contain only numeric value.')); 
				}
				$this->form_validation->set_rules('provision[]', 'Provision', 'trim|required');

				if ($this->form_validation->run()) {
					$provision = $this->input->post('provision');
					$number_of_provisions = 0;
					$error_count = 0;
					$message = '';

					foreach ($provision as $key => $value) {

						if ($value['number'] && !empty($value['number'])) {
							$number_of_provisions = $number_of_provisions + $value['number'];
						}

						$getUserBusinessCountByProvisionId = $this->users->getBusinessByServiceId($this->childcare_id, $value['id']);
						$provision_data = $this->plans->getServiceTypeById($value['id']);

						if ($getUserBusinessCountByProvisionId > $value['number']) {

							if ($value['number'] && !empty($value['number'])) {
								$number = $getUserBusinessCountByProvisionId - $value['number'];

							} else {
								$number = $getUserBusinessCountByProvisionId;
							}

							$error_count++;
							$message .= 'Please Remove your '.$number.' business for "'.$provision_data->name.'" Provision<br>';
						}
					}

					if ($error_count > 0) {
						$message = $message;
						$success = false;

					} else {

						if ($number_of_provisions < 1) {
							$message = 'Please select atleast One Provision.';
							$success = false;

						} else {

							if ($number_of_provisions > $plan_detail->provision_allowed) {
								$message = 'Number of provision should be lesser or equal than your plan choosed.';
								$success = false;

							} else {
								$input = array();
								$input['membership_plan_id'] = $plan_detail->id;
								$input['user_id'] = $this->childcare_id;
								$input['plan_type'] = $plan_type;
								$input['add_date'] = $this->common_model->getDefaultToGMTDate(time());

								if ($plan_detail->plan_type == 'Free') {
									$memberData['plan_status'] = 'Cancelled';
									$memberData['update_date'] = $this->common_model->getDefaultToGMTDate(time());
									$respo = $this->users->updateOldPlanStatus($memberData, $user_exist_plan->id);//from tbl_user_membership_plan

									if ($respo) {
										$user_plan_id = $this->users->insert_user_plan($input);
									}

								} else {
									$user_plan_id = $this->users->insert_user_plan_temp($input);
								}

								if ($user_plan_id) {
									$inputProvision = array();

									foreach ($provision as $key => $value) {

										if ($value['number'] && !empty($value['number'])) {
											// $number_of_provisions = $number_of_provisions + $value['number'];
											$inputProvision[$key]['user_id'] = $this->childcare_id;
											$inputProvision[$key]['user_plan_id'] = $user_plan_id;
											$inputProvision[$key]['service_type_id'] = $value['id'];
											$inputProvision[$key]['provisions'] = $value['number'];
											$inputProvision[$key]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
										}
									}

									if (!empty($inputProvision)) {

										if ($plan_detail->plan_type == 'Free') {
											$this->users->insert_provision_data($inputProvision);
											$data['redirectURL'] = site_url('my-profile');

										} else {
											$this->users->insert_provision_data_temp($inputProvision);
											$data['redirectURL'] = site_url('plan/payment/').$user_plan_id;
										}
									}

									$success = true;
									$message = 'Provision submitted successfully.';

								} else {
									$success = false;
									$message = 'Technical error, Please try again.';
								}
							}
						}
					}

				} else {
					$message = validation_errors();
					$success = false;
				}

				$data['message'] = $message;
				$data['success'] = $success;
				echo json_encode($data);die;
			}
		}

		$this->load->view('front/includes/header', $output);
		$this->load->view('front/change_plan/number_of_provisions');
		$this->load->view('front/includes/footer');
	}

	function choose_plan_make_payment()
	{
		$stripe_token = $this->input->post('stripe_token');
		$user_plan_id = $this->input->post('user_plan_id');

		$this->form_validation->set_rules('company', 'company', 'trim');
		$this->form_validation->set_rules('first_name', 'first name', 'required');
		$this->form_validation->set_rules('last_name', 'last name', 'required');
		$this->form_validation->set_rules('country', 'country', 'required');
		$this->form_validation->set_rules('postal_code', 'postal code', 'required');
		$this->form_validation->set_rules('card_type', 'card type', 'required');
		$this->form_validation->set_rules('card_number', 'card number', 'required');
		$this->form_validation->set_rules('expiry_month', 'expiry month', 'required');
		$this->form_validation->set_rules('expiry_year', 'expiry year', 'required');
		$this->form_validation->set_rules('stripe_token', 'stripe token', 'required');

		if ($this->form_validation->run()) {
			$amount = $this->input->post('amount');

			if ($stripe_token && $user_plan_id) {
				$user_plan_detail = $this->users->getUserPlanById($user_plan_id, $this->childcare_id);
				$user_plan_services_detail = $this->users->getUserServiceByPlanId($user_plan_detail->id);

				if ($user_plan_detail) {
					$plan_detail = $this->plans->getMembershipPlanById($user_plan_detail->membership_plan_id);//Get Plan detail Free/Paid
					$response = $this->stripe->redeem_amount($stripe_token, $amount, $user_plan_detail->email);

					if ($response['success']) {
						$user_exist_plan = $this->plans->getRunningPlan($this->childcare_id);

						if ($user_exist_plan) {
							$memberData['plan_status'] = 'Cancelled';
							$memberData['update_date'] = $this->common_model->getDefaultToGMTDate(time());
							$this->users->updateOldPlanStatus($memberData, $user_exist_plan->id);//from tbl_user_membership_plan
						}

						//calculate plan expiry date
						$membership_plan_type = $plan_detail->plan_type;
						$month = $plan_detail->month;

						if ($membership_plan_type == 'Free') {
							$months = '+'.$month.' months';
							$plan_expiry_date = date('Y-m-d', strtotime($months, strtotime($this->common_model->getDefaultToGMTDate(time()))));

						} else {

							if ($plan_type == 'Monthly') {
								$plan_expiry_date = date('Y-m-d', strtotime("+1 months", strtotime($this->common_model->getDefaultToGMTDate(time()))));

							} else {
								$plan_expiry_date = date('Y-m-d', strtotime("+12 months", strtotime($this->common_model->getDefaultToGMTDate(time()))));
							}
						}

						$input = array();
						$input['membership_plan_id'] = $user_plan_detail->membership_plan_id;
						$input['user_id'] = $user_plan_detail->user_id;
						$input['plan_type'] = $user_plan_detail->plan_type;
						$input['amount'] = $amount;
						$input['company'] = $this->input->post('company');
						$input['card_holder_name'] = $this->input->post('first_name').' '.$this->input->post('last_name');
						$input['country'] = $this->input->post('country');
						$input['postal_code'] = $this->input->post('postal_code');
						$input['card_type'] = $this->input->post('card_type');
						$input['card_number'] = $this->input->post('card_number');
						$input['expiry_month_year'] = $this->input->post('expiry_month').'/'.$this->input->post('expiry_year');
						$input['stripe_token'] = $this->input->post('stripe_token');
						$input['plan_expiry_date'] = $plan_expiry_date;
						$input['add_date'] = $this->common_model->getDefaultToGMTDate(time());
						$user_plan_id = $this->users->insert_user_plan($input);

						if ($user_plan_id) {
							$inputProvision = array();

							foreach ($user_plan_services_detail as $key => $value) {
								$inputProvision[$key]['user_id'] = $value->user_id;
								$inputProvision[$key]['user_plan_id'] = $user_plan_id;
								$inputProvision[$key]['service_type_id'] = $value->service_type_id;
								$inputProvision[$key]['provisions'] = $value->provisions;
								$inputProvision[$key]['add_date'] = $this->common_model->getDefaultToGMTDate(time());
							}

							if (!empty($inputProvision)) {
								$this->users->insert_provision_data($inputProvision);
							}

							$this->users->delete_user_membership_temp_data($user_plan_detail->id);
							$success = true;
							$message = 'Plan purchased successfully.';
							$data['redirectURL'] = base_url('dashboard');

						} else {
							$success = false;
							$message = 'Technical error, Please try again.';
						}

					} else {
						$success = false;
						$message = $response['message'];
					}

				} else {
					$success = false;
					$message = 'User Plan detail Missing.';
				}

			} else {
				$message = 'Please enter valid card detail.';
				$success = false;
			}

		} else {
			$message = validation_errors();
			$success = false;
			$data['redirectURL'] = site_url('plan/payment/').$user_plan_id;
		}

		$data['message'] = $message;
		$data['success'] = $success;
		echo json_encode($data);die;
	}
}