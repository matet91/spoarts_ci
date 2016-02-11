<?php 
  require_once APPPATH.'third_party/paypal/vendor/autoload.php';
use PayPal\Api\RedirectUrls;
class PaypalRedirectUrls extends RedirectUrls{ 
    public function __construct() { 
        parent::__construct(); 
    } 
}



