<?php 
  require_once APPPATH.'third_party/paypal/vendor/autoload.php';
use PayPal\Api\ItemList;
class PaypalItemList extends ItemList{ 
    public function __construct() { 
        parent::__construct(); 
    } 
}



