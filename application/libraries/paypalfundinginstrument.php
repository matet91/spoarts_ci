<?php 
  require_once APPPATH.'third_party/paypal/vendor/autoload.php';
use PayPal\Api\FundingInstrument;

class PaypalFundingInstrument extends FundingInstrument{ 
    public function __construct() { 
        parent::__construct(); 
    } 
}


