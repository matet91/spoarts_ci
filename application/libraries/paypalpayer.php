<?php 
  require_once APPPATH.'third_party/paypal/vendor/autoload.php';
use PayPal\Api\Payer;
class PaypalPayer extends Payer{ 
    public function __construct() { 
        parent::__construct(); 
    } 
}





