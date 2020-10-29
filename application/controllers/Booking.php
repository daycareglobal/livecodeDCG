<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking extends CI_Controller {
	
	function __construct() {
		Parent::__construct();
		$this->load->model('front/Booking_modal', 'booking');
		$this->user_id = $this->session->userdata('user_id');
		$this->load->model('front/service_modal', 'service');
		$this->load->model('front/home_model', 'home');
	}

	function check_space($value) {
        if ( ! preg_match("/^[a-zA-Z'0-9_@#$^&%*)(_+}{;:?\/., -]*$/", $value) ) {
           $this->form_validation->set_message('check_space', 'The %s field should contain only letters, numbers or periods');
           return false;
        }
        else
        return true;
    }

	function book_now() {		
		$output['page'] = 'add_booking';
		$output['page_active'] = 'booking';
		$message = 'Default error Msg';
		$success = false;
		$failure = false;

		$sid = $_GET['sid'];
		$total_amout = 0;

		if ($sid) {
			$service_detail = $this->service->getServiceByID($sid);
			
			if ($service_detail) {
				$monthly_amount = 0;
				$daily_amount = 0;
				$hourly_amount = 0;
				$minute_amount = 0;
				$total_house_string = '';
				$check_in = $this->input->get('check_in');
				$check_out = $this->input->get('check_out');
				$dteStart = new DateTime($check_in);
		   		$dteEnd   = new DateTime($check_out);
				$dteDiff  = $dteStart->diff($dteEnd);
				// $total_hours = $dteDiff->format("%H");

				if (!empty($check_in) && !empty($check_out)) {
					$date1=date_create($_GET['check_in']);
				    $date2=date_create($_GET['check_out']);
				    $total_child = $_GET['child'];
				    $diff=date_diff($date1, $date2);//OP: +272 days

				    if ($diff->m > 0) {
				    	$monthly_amount = ($service_detail->monthly_charges * $diff->m) * $total_child;
				    	$total_house_string = $diff->m.' months ';
				    }

				    if ($diff->d > 0) {
				    	$daily_amount = ($service_detail->daily_charges * $diff->d) * $total_child;
				    	$total_house_string .= $diff->d.' days ';
				    }

				    if ($diff->h > 0) {
				    	$hourly_amount = ($service_detail->hourly_charges * $diff->h) * $total_child;
				    	$total_house_string .= $diff->h.' hours ';
				    }

				    if ($diff->i > 0) {
				    	$minute_amount = $service_detail->hourly_charges * $total_child;
				    	$total_house_string .= $diff->i.' minutes ';
				    }

				    $total_amout = $monthly_amount + $daily_amount + $hourly_amount + $minute_amount;

	   				// if ($diff->days < 1) {

	   				// 	if ($diff->h < 1) {
	   				// 		$hours = 1;
	   				// 	} else {
	   				// 		$hours = $diff->h;
	   				// 	}
				    // 	$total_amout = ($hours * $service_detail->hourly_charges) * $total_child;

	   				// } else {
				    // 	$total_amout = ($diff->days * $service_detail->daily_charges) * $total_child;
	   				// }


				    // pr($diff);die;

					$service_detail->business_images = $this->home->getUserBusinessImages($service_detail->id);
					$service_detail->business_service_types = $this->home->getUserBusinessServiceTypes($service_detail->id);
					$business_service_days = $this->home->getUserBusinessServiceDays($service_detail->id);

					if ($business_service_days) {

						foreach ($business_service_days as $k => $val) {
							$val->open_time = $this->common_model->getGMTDateToLocalDate($val->open_time, 'h:i A');							
							$val->close_time = $this->common_model->getGMTDateToLocalDate($val->close_time, 'h:i A');
						}

					}

					$service_detail->business_service_days = $business_service_days;
					$output['business_list'] = $service_detail;
				}
			}
		}

		if (isset($_POST) && !empty($_POST)) {
			$this->form_validation->set_rules('name', 'name', 'trim|required|callback_check_space');
			$this->form_validation->set_rules('age', 'age', 'trim|required|numeric|max_length[3]');
			//$this->form_validation->set_rules('email', 'email', 'trim|required|valid_email');
			//$this->form_validation->set_rules('phone_number', 'phone number', 'trim|required|numeric|min_length[10]|max_length[10]');
			//$this->form_validation->set_rules('amount', 'amount', 'trim|required|numeric');
			
			$this->form_validation->set_rules('check_in', 'check in', 'trim|required');
			$this->form_validation->set_rules('check_out', 'check out', 'trim|required');
			$this->form_validation->set_rules('child', 'child', 'trim|required');
			$this->form_validation->set_rules('parent_name', 'parent name', 'trim|required');
			$this->form_validation->set_rules('parent_phone_number', 'parent phone number', 'trim|required|numeric|min_length[10]|max_length[10]');
			$this->form_validation->set_rules('parent_email_address', 'parent email address', 'trim|required|valid_email');
			$this->form_validation->set_rules('emergancy_phone_number', 'emergancy phone number', 'trim|required|numeric|min_length[10]|max_length[10]');

			if ($this->form_validation->run()) {
				$input['user_id'] = $this->user_id;
				$input['name'] = $this->input->post('name');
				$input['age'] = $this->input->post('age');
				$input['parent_name'] = $this->input->post('parent_name');
				$input['parent_phone_number'] = $this->input->post('parent_phone_number');
				$input['parent_email_address'] = $this->input->post('parent_email_address');
				$input['emergancy_phone_number'] = $this->input->post('emergancy_phone_number');
				//$input['email'] = $this->input->post('email');
				//$input['phone_number'] = $this->input->post('phone_number');
				//$input['amount'] = $this->input->post('amount');
				$input['check_in'] = $this->input->post('check_in');
				$input['check_out'] = $this->input->post('check_out');
				$input['child'] = $this->input->post('child');
				$input['service_id'] = $sid;
				$input['total_amount'] = $total_amout;
				$input['payment_status'] = 'Pending';
				// $input['payment_status'] = 'Success';
				$input['add_date'] = $this->common_model->getDefaultToGMTDate(time());
				$business_service_id = $this->booking->insertBooking($input);
			   // $business_service_id = true;

				if ($business_service_id) {
					$this->load->helper('url');
					$ch = curl_init();
			        curl_setopt($ch, CURLOPT_URL, 'https://test.instamojo.com/api/1.1/payment-requests/');
			        curl_setopt($ch, CURLOPT_HEADER, FALSE);
			        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
			        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //<---- add this line or attach ssl certi
			        curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-Api-Key:test_b7c18dc3a396ddcb1cdbc936ea6",
			            "X-Auth-Token:test_86bac2d4be79fd7126784b31b98"));
			        $thank_you_page = base_url('booking/thankyou/'.$business_service_id);
			        $payload = Array(
			            'purpose' => 'DayCare Booking',
			            'amount' => $total_amout,
			            'phone' => $this->input->post('parent_phone_number'),
			            'buyer_name' => $this->input->post('parent_name'),
			            'redirect_url' => $thank_you_page,
			            'send_email' => true,
			            'webhook' => '',
			            'send_sms' => true,
			            'email' => $this->input->post('parent_email_address'),
			            'allow_repeated_payments' => false,
			        );
			        curl_setopt($ch, CURLOPT_POST, true);
			        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
			        $response = curl_exec($ch);
			        curl_close($ch);
			        $result = json_decode($response, TRUE);
			        
			        if (isset($result['success']) && $result['success'] === true) {
			          $success = true;
					  $message = '';
					  $data['redirectURL'] = $result['payment_request']['longurl'];

					} else {
						// pr($result); die;
						$success = false;
					  	$message = $result['message']['amount'][0];
					}
					
				} else {
					$success = false;
					$message = 'Technical error, please try again.';
				}


			} else {
				$success = false;
				$message = validation_errors();
			}
			$data['message'] = $message;
			$data['success'] = $success;
			echo json_encode($data);die;   
		}
		$output['total_amout'] = $total_amout;
		$output['total_child'] = $total_child;
		$output['service_detail'] = $service_detail;
		$output['total_hours'] = $total_house_string;
		$this->load->view('front/includes/header', $output);
		$this->load->view('front/booking/booking_now');
		$this->load->view('front/includes/footer');
	}

	public function check_time() {
		$sid = $_GET['sid'];
		$total_amout = 0;

		if ($sid) {
			$service_detail = $this->service->getServiceByID($sid);
			
			if ($service_detail) {
				$check_in = $this->input->get('check_in');
				$check_out = $this->input->get('check_out');
				$dteStart = new DateTime($check_in);
		   		$dteEnd   = new DateTime($check_out);
				$dteDiff  = $dteStart->diff($dteEnd);
				// $total_hours = $dteDiff->format("%H");

				if (!empty($check_in) && !empty($check_out)) {
					$date1=date_create($_GET['check_in']);
				    $date2=date_create($_GET['check_out']);
				    $total_child = $_GET['child'];
				    $diff=date_diff($date1, $date2);//OP: +272 days

	   				if ($diff->days < 1) {

	   					if ($diff->h < 1) {
	   						$success = false;
	   						$message = 'Check out time should be greater then 1 hour of check in time.';
	   					} else {
	   						$success = true;
	   						$message = false;
	   					}

	   				} else {
				    	$success = true;
	   					$message = false;
	   				}
				} else {
					$success = false;
					$message = 'Please enter the above information for proceed';
				}
			} else {
				$success = false;
				$message = 'Technical error. Please try again.';
			}
		}

		$data['success'] = $success;
		$data['message'] = $message;

		echo json_encode($data); die;
	}
	public function callbackUrl() {
		pr($_POST);die;
	}

	public function thankyou($pid = null) {
		// pr($_REQUEST);die;
		$output['page'] = 'add_booking';

		if ($pid) {
			$updateData['payment_id'] = $_REQUEST['payment_id']; 
			$updateData['payment_status'] = 'Success'; 
			$updateData['payment_request_id'] = $_REQUEST['payment_request_id']; 
			$this->booking->updateBooking($updateData, $pid);
		}
		$output['page_active'] = 'booking';
		$output['booking_id'] = $pid;
		$this->load->view('front/includes/header', $output);
		$this->load->view('front/booking/thankyou');
		$this->load->view('front/includes/footer');
	}

	public function booking_list() {
		$this->common_model->checkUserLogin();
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		$output['page'] = 'booking list';
		$output['page_active'] = 'booking_list';

		$booking_list = $this->booking->getBookingListByUserId($user_id);
		// pr($booking_list);die;

		if ($booking_list) {
			
			foreach ($booking_list as $key => $value) {
				$service_detail = $this->service->getServiceByID($value->service_id);
			
				if ($service_detail) {
					$monthly_amount = 0;
					$daily_amount = 0;
					$hourly_amount = 0;
					$minute_amount = 0;
					$total_house_string = '';
					$check_in = $value->check_in;
					$check_out = $value->check_out;
					$dteStart = new DateTime($check_in);
			   		$dteEnd   = new DateTime($check_out);
					$dteDiff  = $dteStart->diff($dteEnd);
					// $total_hours = $dteDiff->format("%H");

					if (!empty($check_in) && !empty($check_out)) {
						$date1=date_create($value->check_in);
					    $date2=date_create($value->check_out);
					    $total_child = $value->child;
					    $diff=date_diff($date1, $date2);//OP: +272 days

					    if ($diff->m > 0) {
					    	$monthly_amount = ($service_detail->monthly_charges * $diff->m) * $total_child;
					    	$total_house_string = $diff->m.' months ';
					    }

					    if ($diff->d > 0) {
					    	$daily_amount = ($service_detail->daily_charges * $diff->d) * $total_child;
					    	$total_house_string .= $diff->d.' days ';
					    }

					    if ($diff->h > 0) {
					    	$hourly_amount = ($service_detail->hourly_charges * $diff->h) * $total_child;
					    	$total_house_string .= $diff->h.' hours ';
					    }

					    if ($diff->i > 0) {
					    	$minute_amount = $service_detail->hourly_charges * $total_child;
					    	$total_house_string .= $diff->i.' minutes ';
					    }

					    $total_amout = $monthly_amount + $daily_amount + $hourly_amount + $minute_amount;
					    $value->total_house_string = $total_house_string;
					}
				}
			}
		}

		$output['booking_list'] = $booking_list;
		$this->load->view('front/includes/header', $output);
		$this->load->view('front/booking/booking_list');
		$this->load->view('front/includes/footer');
	}

	public function business_booking_list() {
		$this->common_model->checkUserLogin();
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		$output['page'] = 'booking list';
		$output['page_active'] = 'booking_list';
		$user_services = $this->booking->getDaycareListByUserId($user_id);
		$booking_list = array();

		if ($user_services) {
			$services = array();

			foreach ($user_services as $k => $v) {
				$services[] = $v->id;
			}

			$booking_list = $this->booking->getBookingListByServiceId($services);
			
			foreach ($booking_list as $key => $value) {
				$service_detail = $this->service->getServiceByID($value->service_id);
			
				if ($service_detail) {
					$monthly_amount = 0;
					$daily_amount = 0;
					$hourly_amount = 0;
					$minute_amount = 0;
					$total_house_string = '';
					$check_in = $value->check_in;
					$check_out = $value->check_out;
					$dteStart = new DateTime($check_in);
			   		$dteEnd   = new DateTime($check_out);
					$dteDiff  = $dteStart->diff($dteEnd);
					// $total_hours = $dteDiff->format("%H");

					if (!empty($check_in) && !empty($check_out)) {
						$date1=date_create($value->check_in);
					    $date2=date_create($value->check_out);
					    $total_child = $value->child;
					    $diff=date_diff($date1, $date2);//OP: +272 days

					    if ($diff->m > 0) {
					    	$monthly_amount = ($service_detail->monthly_charges * $diff->m) * $total_child;
					    	$total_house_string = $diff->m.' months ';
					    }

					    if ($diff->d > 0) {
					    	$daily_amount = ($service_detail->daily_charges * $diff->d) * $total_child;
					    	$total_house_string .= $diff->d.' days ';
					    }

					    if ($diff->h > 0) {
					    	$hourly_amount = ($service_detail->hourly_charges * $diff->h) * $total_child;
					    	$total_house_string .= $diff->h.' hours ';
					    }

					    if ($diff->i > 0) {
					    	$minute_amount = $service_detail->hourly_charges * $total_child;
					    	$total_house_string .= $diff->i.' minutes ';
					    }

					    $total_amout = $monthly_amount + $daily_amount + $hourly_amount + $minute_amount;
					    $value->total_house_string = $total_house_string;
					}
				}
			}
		}

		$output['booking_list'] = $booking_list;
		$this->load->view('front/includes/header', $output);
		$this->load->view('front/booking/booking_list');
		$this->load->view('front/includes/footer');
	}

}