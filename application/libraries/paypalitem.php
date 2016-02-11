<?php 
  require_once APPPATH.'third_party/paypal/vendor/autoload.php';
use PayPal\Api\Item;
class PaypalItem extends Item{ 
    public function __construct() { 
        parent::__construct(); 
    } 
}


