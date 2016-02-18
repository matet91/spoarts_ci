<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class msales extends CI_Model {
	public function __construct()
	{
			// Call the CI_Model constructor
			parent::__construct();
	}
	
	function dataTables($switch,$reptype,$repdate){
		$sSort = $this->input->get('iSortCol_0');
		$sSortype = $this->input->get('sSortDir_0');
		$sSearch = $this->input->get('sSearch');
		$usertype = $this->session->userdata('usertype');
		$sLimit = "";
		$wheredate = "";
		if($reptype==1){//monthly
			$date = explode("%20",$repdate);
			$mdate = $date[0];
			$ydate = $date[1];
			$stdate = $ydate."-".$mdate."-"."01";
			$stdate = date("Y-m-d",strtotime($stdate));
			$endate = date("Y-m-t", strtotime($stdate));
			if($switch == 1){
				$wheredate = " AND p.payment_date BETWEEN '".$stdate."' AND '".$endate."'";
			}else{
				$wheredate = " WHERE p.paypal_createTime BETWEEN '".$stdate."' AND '".$endate."'";
			}
			
		}else if($reptype==2){//yearly
			$stdate = $repdate."-"."01"."-"."01";
			$stdate = date("Y-m-d",strtotime($stdate));
			$endate = $repdate."-"."12"."-"."31";
			$endate = date("Y-m-d", strtotime($endate));
			if($switch == 1){
				$wheredate = " AND p.payment_date BETWEEN '".$stdate."' AND '".$endate."'";
			}else{
				$wheredate = " WHERE p.paypal_createTime BETWEEN '".$stdate."' AND '".$endate."'";
			}
		}
		
		if ( $this->input->get('iDisplayStart')!='' && $this->input->get('iDisplayLength') != '-1' )
			$sLimit = "LIMIT ".intVal($this->input->get('iDisplayStart')).", ".intVal($this->input->get('iDisplayLength'));

		switch($switch){
			case 0: //for admin
				$aColumns = array("paypal_id","paypal_createTime", "buyer_name","clinic","paypal_amount","paypal_invoice","transaction_id");
				$select = array("paypal_id","paypal_createTime", "buyer_name", "(c.clinic_name) as clinic","paypal_amount","paypal_invoice","transaction_id");
				$sTable = "paypal_logs p";
				$leftjoin = " LEFT JOIN clinics c ON c.UserID = p.UserID";
				$sWhere = "".$wheredate;
				if($sSearch){$sWhere .= " WHERE (paypal_createTime like '%".$sSearch."%' OR buyer_name like '%".$sSearch."%' OR c.clinic_name like '%".$sSearch."%'  OR paypal_amount like '%".$sSearch."%' OR paypal_invoice like '%".$sSearch."%' OR transaction_id like '%".$sSearch."%')";}
				$sOrder = 'ORDER BY '.$aColumns[$sSort].' '.$sSortype;
				$groupby = "";
				$aColumns_output = array("paypal_id","paypal_createTime", "buyer_name","clinic","paypal_amount","paypal_invoice","transaction_id");
			break;
			case 1: //for service provider
				$aColumns = array("payment_id","payment_date", "payment_amt","payment_balance","payment_desc","stud_name","clinic","service","schedule","payment_type");
				$select = array("payment_id","payment_date", "payment_amt", "payment_balance","payment_desc","stud_name","(u.clinic_name)as clinic","(ser.ServiceName)as service","CONCAT(sc.SchedDays,'@',sc.SchedTime) as schedule","(CASE WHEN payment_type=0 THEN 'Session'  WHEN payment_type=1 THEN 'Monthly' ELSE 'Membership' END)  as payment_type");
				$sTable = "payment_logs p";
				$leftjoin = " LEFT JOIN students s ON s.stud_id = p.stud_id LEFT JOIN schedules sc ON sc.SchedID = p.SchedID LEFT JOIN services ser ON ser.ServiceID = p.service_id LEFT JOIN clinics u ON u.UserID = p.UserID";
				$sWhere = "WHERE p.UserID = ".$this->session->userdata("userid")."";
				$sWhere .= $wheredate;
				if($sSearch){$sWhere .= " AND (payment_date like '%".$sSearch."%' OR payment_amt like '%".$sSearch."%' OR payment_balance like '%".$sSearch."%'  OR payment_desc like '%".$sSearch."%' OR stud_name like '%".$sSearch."%' OR payment_type like '%".$sSearch."%' OR ser.ServiceName like '%".$sSearch."%' OR sc.SchedDays like '%".$sSearch."%' OR sc.SchedTime like '%".$sSearch."%' OR u.clinic_name like '%".$sSearch."%')";}
				$sOrder = 'ORDER BY '.$aColumns[$sSort].' '.$sSortype;
				$groupby = "";
				$aColumns_output = array("payment_id","payment_date", "payment_amt","payment_balance","payment_desc","stud_name","clinic","service","schedule","payment_type");
			break;
		}
		
		$sIndexColumn = "*";
			
		$sQuery = "SELECT SQL_CALC_FOUND_ROWS ".implode(",", $select)." FROM $sTable $leftjoin $sWhere $groupby $sOrder $sLimit";
		
		//print_r("SELECT SQL_CALC_FOUND_ROWS ".implode(",", $aColumns)." FROM $sTable $leftjoin $sWhere $groupby $sOrder $sLimit");
		
		$rResult = $this->db->query( $sQuery );
		// 	echo $this->db->last_query();
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
				$row[] = ($aRow->$col =="0") ? '-' : ucfirst($aRow->$col);
			}
			$output['aaData'][] = $row;
		}
		return $output;
	}
}