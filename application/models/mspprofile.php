<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mspprofile extends CI_Model {
	public function __construct()
	{
			// Call the CI_Model constructor
			parent::__construct();
	}
		
	function loadprofile(){
		$sql = "SELECT * FROM user_details a LEFT JOIN clinics b ON a.UserID=b.UserID  LEFT JOIN user_accounts c ON c.UserID = a.UserID LEFT JOIN subscriptions d ON d.UserID=a.UserID WHERE a.UserID='".$this->input->get('susid')."'";

		$q = $this->db->query($sql);

		$row = $q->row();
		return $row;
	}

	function dataTables($case,$id=null){
		$sSort = $this->input->get('iSortCol_0');
		$sSortype = $this->input->get('sSortDir_0');
		$sSearch = $this->input->get('sSearch');
		$aColumns = explode(',',$this->input->get('sColumns'));
		$sLimit = "";
		if ( $this->input->get('iDisplayStart')!='' && $this->input->get('iDisplayLength') != '-1' )
			$sLimit = "LIMIT ".intVal($this->input->get('iDisplayStart')).", ".intVal($this->input->get('iDisplayLength'));

		switch($case){
			case 1://list of services
				$aColumns = array("serviceid","servicename", "servicedesc", "serviceschedule", "serviceregistrationfee", "serviceprice",'serviceWalkin',"serviceHour","servicetype");
				$select = array("serviceid","servicename", "servicedesc", "serviceschedule", "serviceregistrationfee", "serviceprice","serviceWalkin","serviceHour as servicehour","(CASE WHEN servicetype=1 THEN 'Arts' ELSE 'Sports' END) as servicetype","1 as action");
				$sTable = "services";
				$leftjoin = " ";
				$sWhere = "WHERE servicestatus=1 AND SPID=$id";

				if($sSearch){
					$sWhere .= " AND (servicename like '%".$sSearch."%' OR servicedesc like '%".$sSearch."%' OR serviceschedule like '%".$sSearch."%' OR serviceregistrationfee like '%".$sSearch."%' OR servicetype like '%".$sSearch."%' OR serviceprice like '%".$sSearch."%')";}
					$sOrder = 'ORDER BY '.$aColumns[$sSort].' '.$sSortype;
					$groupby = "";
					$aColumns_output = array("serviceid","servicename","servicedesc", "serviceschedule", "serviceregistrationfee", "serviceWalkin","servicehour","serviceprice", "servicetype","action");
			break;
			case 2://list of instructors

				$select = $aColumns;
				$select[5] = "(CASE WHEN ins_status = 0 THEN 'Inactive' ELSE 'Active' END) as ins_status";
				$select[6] = "1 as action";
				$sTable = "instructors";
				$leftjoin = "";
				//print_r($select);
				$sWhere = "";
				if($sSearch){
					$sWhere .= "QHERE (ins_name like '%".$sSearch."%' OR ins_room like '%".$sSearch."%' OR ins_schedule like '%".$sSearch."%' OR ins_status like '%".$sSearch."%')";}
				$sOrder = 'ORDER BY '.$aColumns[$sSort].' '.$sSortype;
				$groupby = "";
				$aColumns_output = $aColumns;
			break;

			case 3://schedules
					$select = array("s.SchedID","s.SchedDays","s.SchedTime","r.RoomName","m.MasterInsName","srv.ServiceName","s.SchedSlots","s.date_added","1 as action");
					
					$sTable = "schedules s";
					$leftjoin = "LEFT JOIN services srv ON srv.ServiceID=s.ServiceID
						LEFT JOIN rooms r ON r.RoomID=s.RoomID
						LEFT JOIN instructor_masterlist m ON m.MasterInsID = s.InstructorID";
					//print_r($select);
					$sWhere = "WHERE srv.SPID = '$userid'";
					if($sSearch){
						$sWhere .= " AND (r.RoomName like '%".$sSearch."%' OR m.MasterInsName like '%".$sSearch."%' OR s.SchedTime like '%".$sSearch."%' OR s.date_added like '%".$sSearch."%' OR s.SchedDays like '%".$sSearch."%' OR srv.ServiceName like '%".$sSearch."%')";}
					$sOrder = 'ORDER BY '.$aColumns[$sSort].' '.$sSortype;
					$groupby = "";
					$aColumns_output = array("SchedID","SchedDays","SchedTime","RoomName","MasterInsName","ServiceName","SchedSlots","date_added","action");
			break;
			case 4://masterlist od instructors
					$select = $aColumns;
					$select[6] = "(CASE WHEN MasterInsStatus = 1 THEN 'Active' ELSE 'Inactive' END) as MasterInsStatus";
					$sTable = "instructor_masterlist";
					$leftjoin = "";
					//print_r($select);
					$sWhere = "wHERE UserID='$userid'";
					if($sSearch){
						$sWhere .= " AND (MasterInsName like '%".$sSearch."%' OR MasterInsAddress like '%".$sSearch."%' OR MasterInsContactNo like '%".$sSearch."%' OR MasterInsEmail like '%".$sSearch."%' OR MasterInsExpertise like '%".$sSearch."%')";}
					$sOrder = 'ORDER BY '.$aColumns[$sSort].' '.$sSortype;
					$groupby = "";
					$aColumns_output = array("MasterInsID","MasterInsName","MasterInsAddress","MasterInsContactNo","MasterInsEmail","MasterInsExpertise","MasterInsStatus","action");
			break;

			case 5://rooms
					$select = $aColumns;
					$select[6] = "(CASE WHEN RoomStatus = 1 THEN 'Active' ELSE 'Inactive' END) as RoomStatus";
					$sTable = "rooms";
					$leftjoin = "";
					//print_r($select);
					$sWhere = "wHERE UserID='$userid'";
					if($sSearch){
						$sWhere .= " AND (RoomNo like '%".$sSearch."%' OR RoomName like '%".$sSearch."%' OR RoomStatus like '%".$sSearch."%')";}
					$sOrder = 'ORDER BY '.$aColumns[$sSort].' '.$sSortype;
					$groupby = "";
					$aColumns_output = array("RoomID","RoomNo","RoomName","RoomStatus","action");
			break;
		}
		
		$sIndexColumn = "*";
			
		$sQuery = "SELECT SQL_CALC_FOUND_ROWS ".implode(",", $select)." FROM $sTable $leftjoin $sWhere $groupby $sOrder $sLimit";
		//echo $this->db->last_query();
		//print("SELECT SQL_CALC_FOUND_ROWS ".implode(",", $aColumns)." FROM $sTable $leftjoin $sWhere $groupby $sOrder $sLimit");
		
		$rResult = $this->db->query( $sQuery );
		//echo $this->db->last_query();
		//print_r($rResult->result());
		$sQuery = "SELECT FOUND_ROWS() as count";
		$rResultFilterTotal = $this->db->query( $sQuery);

		$aResultFilterTotal = $rResultFilterTotal->row();
		$iFilteredTotal = $aResultFilterTotal->count;
		
		/* Total data set length */
		$sQuery_total = "SELECT COUNT(".$sIndexColumn.") as count FROM $sTable";
		$rResultTotal = $this->db->query( $sQuery_total);
		$aResultTotal = $rResultTotal->row();
		$iTotal = $aResultTotal->count;
		
		$output = array(
			"sEcho" =>$this->input->get('sEcho'),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		
		foreach($rResult->result() as $aRow){	
			$row = array();
			foreach ( $aColumns_output as $col ){
				if($case == 3){

					$row[] = ($aRow->$col==null) ? 'TBA' : $aRow->$col;
				}else{
					$row[] = ($aRow->$col =='') ? '-' : $aRow->$col;
				}
			}
			$output['aaData'][] = $row;
		}
		return $output;
	}

	function paypal($type){
		$apiContext = new \PayPal\Rest\ApiContext(
		    new \PayPal\Auth\OAuthTokenCredential(
		        'AXk62QC51pffd4zUaXG9LQzu9oFIWNQx5eHzznUGBYYabG4Gi3AQKdH3uvugO5QZE3QXyoCy5p9fsimI',     // ClientID
		        'EC_apl8JodAI6FwbTF6dUiAKgdIGovPxqt90et5vGo2r71I38mmmsu26WKqUS7XmBI-j_BmJr1h-zcTA'      // ClientSecret
		    )
		);
		switch($type){
			case 1: //credit or debit card
					$data = $this->input->post('data');
					//get premium amount in subscription_plans
					$this->db->where('PlanID',2);
					$this->db->select('*');
					$get = $this->db->get('subscription_plans');
					$row = $get->row();
					$term = $row->PlanTerm;
					$price = $row->PlanPrice;


					$number = $data['cardno'];
					$month = $data['expdatemonth'];
					$firstname = $data['cfirstname'];
					$lastname = $data['clastname'];
					$year = $data['expdateyear'];
					$ccv = $data['ccv'];
					$card = new PaypalCreditCard();
					$card->setType("visa")
					    ->setNumber($number)
					    ->setExpireMonth($month)
					    ->setExpireYear($year)
					    ->setCvv2($ccv)
					    ->setFirstName($firstname)
					    ->setLastName($lastname);
					$fi = new PaypalFundingInstrument(); $fi->setCreditCard($card);
					$payer = new PaypalPayer();
					$payer->setPaymentMethod("credit_card")
					    ->setFundingInstruments(array($fi));
					$item1 = new PaypalItem();
					$item1->setName('Premium')
					    ->setDescription('Upgrade/Renew to Premium')
					    ->setCurrency('USD')
					    ->setQuantity(1)
					    ->setTax(0)
					    ->setPrice($price);

					$itemList = new PaypalItemList();
					$itemList->setItems(array($item1));
					$details = new PaypalDetails();
					$details->setShipping(0)
					    ->setTax(0)
					    ->setSubtotal($price);
					$amount = new PaypalAmount();
					$amount->setCurrency("USD")
					    ->setTotal($price)
					    ->setDetails($details);
					$transaction = new PaypalTransaction();
					$transaction->setAmount($amount)
					    ->setItemList($itemList)
					    ->setDescription("Subscription to Premium")
					    ->setInvoiceNumber(uniqid());
					$payment = new PaypalPayment();
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
					$transactions = $payment->getTransactions(); 
					$relatedResources = $transactions[0]->getRelatedResources(); 
					$sale = $relatedResources[0]->getSale(); 
					$userid = $this->session->userdata('userid');
					$transactionID = $sale->getId();
					$createTime = $sale->getCreateTime();
					$status = $sale->getState();
					$invoice = $transactions[0]->getInvoiceNumber();
					if($status == "completed"){
						$paymentlog = array('paypal_amount'=>1500,
											 'paypal_createTime'=>$createTime,
											 'transaction_id'=>$transactionID,
											 'buyer_name'=>$firstname." ".$lastname,
											 'paypal_invoice'=>$invoice,
											 'UserID'=>$userid);
						$this->db->insert('paypal_logs',$paymentlog);
						$d = date('Y-m-d h:i:s');
        				$datetime = new DateTime($d);
						$datetime->add(new DateInterval('P'.$term));
						$subsData = array('SubscType'=>2,
										  'SubsStatus'=>1,
										  'SubscStartDate'=>date('Y-m-d',strtotime($createTime)),
										  'SubscEndDate'=>$datetime->format('Y-m-d'));

						$this->db->where('UserID',$userid);
						$this->db->update('subscriptions',$subsData);

						$this->db->where('UserID',$userid);
						$this->db->update('clinics',array('clinic_status'=>1));
						return true; exit();
					}else{
						return false; exit();
					}
			break;

			case 2: //paypal

					$payer = new PaypalPayer();
					$payer->setPaymentMethod("paypal");
					$item1 = new PaypalItem();
					$item1->setName('Ground Coffee 40 oz')
					    ->setCurrency('USD')
					    ->setQuantity(1)
					    ->setSku("123123") 
					    ->setPrice(7.5);
					$item2 = new PaypalItem();
					$item2->setName('Granola bars')
					    ->setCurrency('USD')
					    ->setQuantity(5)
					    ->setSku("321321") 
					    ->setPrice(2);

					$itemList = new PaypalItemList();
					$itemList->setItems(array($item1, $item2));
					$details = new PaypalDetails();
					$details->setShipping(1.2)
					    ->setTax(1.3)
					    ->setSubtotal(17.50);
					$amount = new PaypalAmount();
					$amount->setCurrency("USD")
					    ->setTotal(20)
					    ->setDetails($details);
					$transaction = new PaypalTransaction();
					$transaction->setAmount($amount)
					    ->setItemList($itemList)
					    ->setDescription("Payment description")
					    ->setInvoiceNumber(uniqid());
					$baseUrl = base_url();
					$redirectUrls = new PaypalRedirectUrls();
					$redirectUrls->setReturnUrl("$baseUrl/ExecutePayment.php?success=true")
					    ->setCancelUrl("$baseUrl/ExecutePayment.php?success=false");

					$payment = new PaypalPayment();
					$payment->setIntent("sale")
					    ->setPayer($payer)
					    ->setRedirectUrls($redirectUrls)
					    ->setTransactions(array($transaction));

					$request = clone $payment;
					try {
					    $payment->create($apiContext);
					} catch (Exception $ex) {
					    exit(1);
					}

					$approvalUrl = $payment->getApprovalLink();
			break;
		}
	}
}