<?php 
  require_once APPPATH.'third_party/paypal/vendor/autoload.php';
use PayPal\Api\Payment;
class PaypalPayment extends Payment{ 
    public function __construct() { 
        parent::__construct(); 
    } 
}







