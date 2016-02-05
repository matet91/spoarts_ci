<?php
// 1. Autoload the SDK Package. This will include all the files and classes to your autoloader
// Used for composer based installation
require __DIR__  . '/vendor/autoload.php';
// Use below for direct download installation
// require __DIR__  . '/vendor/autoload.php';
// After Step 1
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
$card = new CreditCard();
$card->setType("visa")
    ->setNumber(" 4032034118189292")
    ->setExpireMonth("11")
    ->setExpireYear("2019")
    ->setCvv2("012")
    ->setFirstName("Joe")
    ->setLastName("Shopper");
$fi = new FundingInstrument(); $fi->setCreditCard($card);
$payer = new Payer();
$payer->setPaymentMethod("credit_card")
    ->setFundingInstruments(array($fi));
$item1 = new Item();
$item1->setName('Ground Coffee 40 oz')
    ->setDescription('Ground Coffee 40 oz')
    ->setCurrency('USD')
    ->setQuantity(1)
    ->setTax(0.3)
    ->setPrice(7.50);
$item2 = new Item();
$item2->setName('Granola bars')
    ->setDescription('Granola Bars with Peanuts')
    ->setCurrency('USD')
    ->setQuantity(5)
    ->setTax(0.2)
    ->setPrice(2);

$itemList = new ItemList();
$itemList->setItems(array($item1, $item2));
$details = new Details();
$details->setShipping(1.2)
    ->setTax(1.3)
    ->setSubtotal(17.5);
$amount = new Amount();
$amount->setCurrency("USD")
    ->setTotal(20)
    ->setDetails($details);
$transaction = new Transaction();
$transaction->setAmount($amount)
    ->setItemList($itemList)
    ->setDescription("Payment description")
    ->setInvoiceNumber(uniqid());
$payment = new Payment();
$payment->setIntent("sale")
    ->setPayer($payer)
    ->setTransactions(array($transaction));

$request = clone $payment;
try {
    $payment->create($apiContext);
} catch (Exception $ex) {

 	//ResultPrinter::printError('Create Payment Using Credit Card. If 500 Exception, try creating a new Credit Card using <a href="https://ppmts.custhelp.com/app/answers/detail/a_id/750">Step 4, on this link</a>, and using it.', 'Payment', null, $request, $ex);
    exit(1);
}

// ResultPrinter::printResult('Create Payment Using Credit Card', 'Payment', $payment->getId(), $request, $payment);

return $payment;
?>