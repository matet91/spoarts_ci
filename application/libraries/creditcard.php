<?php 
  require_once APPPATH.'third_party/paypal/vendor/autoload.php';
use PayPal\Api\CreditCard;
class CreditCard extends CreditCard{ 
    public function __construct() { 
        parent::__construct(); 
    } 
}
