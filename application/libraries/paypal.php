<?php 
  require_once APPPATH.'third_party/paypal/vendor/autoload.php';
use PayPal\Api\Amount;
use PayPal\Api\CreditCard;
use PayPal\Api\Details;
use PayPal\Api\FundingInstrument;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\Transaction;
class Paypal extends CreditCard{ 
    public function __construct() { 
        parent::__construct(); 
    } 
}
 