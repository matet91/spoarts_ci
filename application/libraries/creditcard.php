<?php 
 require_once APPPATH."third_party/paypal/vendor/autoload.php"; 
 $apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        'AXk62QC51pffd4zUaXG9LQzu9oFIWNQx5eHzznUGBYYabG4Gi3AQKdH3uvugO5QZE3QXyoCy5p9fsimI',     // ClientID
        'EC_apl8JodAI6FwbTF6dUiAKgdIGovPxqt90et5vGo2r71I38mmmsu26WKqUS7XmBI-j_BmJr1h-zcTA'      // ClientSecret
    )
);

use PayPal\Api\Amount;
use PayPal\Api\CreditCard;
use PayPal\Api\Details;
use PayPal\Api\FundingInstrument;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\Transaction;
