<?php 
  require_once APPPATH.'third_party/paypal/vendor/autoload.php';
use PayPal\Api\Transaction;
class PaypalTransaction extends Transaction{ 
    public function __construct() { 
        parent::__construct(); 
    } 
}








