<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
require "application/third_party/braintree/lib/autoload.php";
class Payment_model extends CI_Model {
	function __construct() {
		parent::__construct();
        
	}
    function pay_by_braintree($amount, $paymentMethodNonce)
    {
        $environment = getSiteOption('environment',true);
        $private_key = getSiteOption('private_key',true);
        $public_key = getSiteOption('public_key',true);
        $merchant_id = getSiteOption('merchant_id',true);

        $gateway = new Braintree_Gateway([
          'environment' => $environment,
          'merchantId' => $merchant_id,
          'publicKey' => $public_key,
          'privateKey' => $private_key
        ]);

        $result = $gateway->transaction()->sale([
          'amount' => $amount,
          'paymentMethodNonce' => $paymentMethodNonce,
          'options' => [
            'submitForSettlement' => True
          ]
        ]);
        return $result;
    }
}