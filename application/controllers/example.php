<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Example extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('instamojo');
		$this->load->helper('url');
	}


	public function index()
	{	
		
		pr($this->instamojo->pay_request($amount = "200", $purpose = "TEST" ));die;
		$pay = $this->instamojo->pay_request( 

			$amount = "200" , 
			$purpose = "TEST" , 
			$buyer_name = "rbbqq" , 
			$email = "rajeevbbqq@gmail.com" , 
			$phone = "89xxxx2017" ,
 			$send_email = 'TRUE' , 
 			$send_sms = 'TRUE' , 
 			$repeated = 'FALSE'

 		);
		pr($pay);die;
		$redirect_url = $pay['longurl']   ;


		redirect($redirect_url,'refresh') ;

	}

	public function get_all()
	{
		$result = $this->instamojo->all_payment_request();

		print_r($result);
	}


	public function pay_request()
	{
		
		$pay = $this->instamojo->pay_request( 

						$amount = "200" , 
						$purpose = "TEST" , 
						$buyer_name = "rbbqq" , 
						$email = "rajeevbbqq@gmail.com" , 
						$phone = "89xxxx2017" ,
		     			$send_email = 'TRUE' , 
		     			$send_sms = 'TRUE' , 
		     			$repeated = 'FALSE'

		     		);


		$payment_id = $pay['id'];  // <= Payment Id
							      // print_r($pay) ; <=  Prints all the data from the request

	}


	public function status()
	{
		$paymentId  = '7a06f4ccbe0b6f216b8009eb6e015a2c'  ; // $paymentId generated by Instamojo
		$status     = $this->instamojo->status($paymentId);

		print_r($status);
	}


	public function payment_status()
	{
		$requestId = '7a06f4ccbe0b6f216b8009eb6e015a2c'  ;
		$status    = $this->instamojo->status($requestId);

		print_r($status) ;
	}


	public function show()
	{
		$data['request_id'] = '7a06f4ccbe0b6f216b8009eb6e015a2c' ;
		$this->load->view('instamojo' ,$data);
	}

}

/* End of file example.php */
/* Location: ./application/controllers/example.php */
