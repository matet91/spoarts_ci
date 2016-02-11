<?php 
  require_once APPPATH.'third_party/paypal/vendor/autoload.php';
use PayPal\Api\Details;
class PaypalDetails extends Details{ 
    public function __construct() { 
        parent::__construct(); 
    } 
}

