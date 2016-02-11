<?php 
  require_once APPPATH.'third_party/paypal/vendor/autoload.php';
use PayPal\Api\Amount;
class PaypalAmount extends Amount{ 
    public function __construct() { 
        parent::__construct(); 
    } 
}








