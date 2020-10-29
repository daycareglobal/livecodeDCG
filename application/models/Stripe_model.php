<?php
class Stripe_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->strip_secret_key = "sk_test_YapOimwQeCxqR1IdNb0TAfvk006dzg3jO6";
		require_once(APPPATH.'libraries/Stripe/init.php');
		
	}
	
	function redeem_amount($token, $amount, $email)
	{
		\Stripe\Stripe::setApiKey($this->strip_secret_key);
		$failure = false;
		$message = false;
		$response = array();
		$customer = \Stripe\Customer::create(array(
			'email' => $email,
			'source'  => $token
		));
		$amount = $amount * 100;
		try {
			$charge = \Stripe\Charge::create(array(
				'customer' => $customer->id,
				'amount'   => $amount,
				'currency' => 'GBP'
			));
			if(!$charge) 
			{
				throw new Exception('no data returned');
			}
			else
			{
				$ChargeArray = $charge->__toArray(true);
				$response['txn_id'] = $ChargeArray['id'];
				$response['payment_status'] = $ChargeArray['status'];
				$response['deduct_amount'] = $ChargeArray['amount'] / 100;
				$response['payment_json'] = json_encode($ChargeArray);
		  	}
		} catch(\Stripe\CardError $e) {
		  $message = $e->getMessage();
		  $failure = true;
		} catch (\Stripe\InvalidRequestError $e) {
		  // Invalid parameters were supplied to Stripe's API
		  $message = $e->getMessage();
		  $failure = true;
		} catch (\Stripe\AuthenticationError $e) {
		  // Authentication with Stripe's API failed
		  $message = $e->getMessage();
		  $failure = true;
		} catch (\Stripe\ApiConnectionError $e) {
		  // Network communication with Stripe failed
		  $message = $e->getMessage();
		  $failure = true;
		} catch (\Stripe\Error $e) {
		  // Display a very generic error to the user, and maybe send
		  // yourself an email
		  $message = $e->getMessage();
		  $failure = true;
		} catch (Exception $e) {
		  // Something else happened, completely unrelated to Stripe
		  $message = $e->getMessage();
		  $failure = true;
		}

		if($failure) {
			$response['success'] = false;
			$response['message'] = $message;
		} else {
			$response['success'] = true;
			$response['message'] = false;
		}
		return $response;
	}
	

}