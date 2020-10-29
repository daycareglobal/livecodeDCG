<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	
	function __construct() {
		Parent::__construct();
		$this->load->model('front/home_model', 'home');
		$this->load->library('instamojo');
		$this->load->helper('url');

	}
	
	public function index() {
		echo '<h1>'.date('M d, Y H:i:s').'</h1>';
	}

	public function payment() {
		$this->load->view('front/home/home');
	}

	public function gatway() {
        $this->load->helper('url');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.instamojo.com/api/1.1/payment-requests/');
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //<---- add this line or attach ssl certi
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-Api-Key:d06ad21d83d10ef38e39b66b94345ba1",
            "X-Auth-Token:7a06f4ccbe0b6f216b8009eb6e015a2c"));

        $payload = Array(
            'purpose' => 'FIFA 16',
            'amount' => '2500',
            'phone' => '9358704504',
            'buyer_name' => 'John Doe',
            'redirect_url' => '',
            'send_email' => true,
            'webhook' => '',
            'send_sms' => true,
            'email' => 'foo@example.com',
            'allow_repeated_payments' => false,
        );
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
        $response = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($response, TRUE);
        //pr($response);die;
        if(isset($data['success']) && $data['success'] === true)
        {
        //pr($data);die;
          $site = $data['payment_request']['longurl'];
          redirect($site, 'refresh');
        }



    }
	
	public function mojo() {
		$ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://test.instamojo.com/api/1.1/payment-requests/');
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-Api-Key:d06ad21d83d10ef38e39b66b94345ba1",
            "X-Auth-Token:7a06f4ccbe0b6f216b8009eb6e015a2c"));
    $payload = Array(
        'purpose' => 'FIFA 16',
        'amount' => '25',
        'phone' => '9358704504',
        'buyer_name' => 'Reena',
        'redirect_url' => '',
        'send_email' => true,
        'webhook' => '',
        'send_sms' => true,
        'email' => 'reenas@mailinator.com',
        'allow_repeated_payments' => true
    );
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
    $response = curl_exec($ch);
    curl_close($ch); 

    echo $response;

	}

    function sentOtp(){
        $otp = '789456';
        $mobile_number = '9887255518';
        sentOtp($otp, $mobile_number);

    }
}