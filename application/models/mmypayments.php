<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class mmypayments extends CI_Model {
	public function __construct()
	{
			// Call the CI_Model constructor
			parent::__construct();
	}
	
	function dataTables($switch){
		$sSort = $this->input->get('iSortCol_0');
		$sSortype = $this->input->get('sSortDir_0');
		$sSearch = $this->input->get('sSearch');
		$usertype = $this->session->userdata('usertype');
		$sLimit = "";
		if ( $this->input->get('iDisplayStart')!='' && $this->input->get('iDisplayLength') != '-1' )
			$sLimit = "LIMIT ".intVal($this->input->get('iDisplayStart')).", ".intVal($this->input->get('iDisplayLength'));

		switch($switch){
			case 1:
				$aColumns = array("payment_id","payment_date", "payment_amt","payment_balance","payment_desc","stud_name","clinic","service","schedule","payment_type");
				$select = array("payment_id","payment_date", "payment_amt", "payment_balance","payment_desc","stud_name","(clinic_name)as clinic","(ser.ServiceName)as service","CONCAT(sc.SchedDays,'@',sc.SchedTime) as schedule","(CASE WHEN payment_type=0 THEN 'Session'  WHEN payment_type=1 THEN 'Monthly' ELSE 'Membership' END)  as payment_type");
				$sTable = "payment_logs p";
				$leftjoin = " LEFT JOIN students s ON s.stud_id = p.stud_id LEFT JOIN schedules sc ON sc.SchedID = p.SchedID LEFT JOIN services ser ON ser.ServiceID = p.service_id LEFT JOIN clinics u ON u.UserID = p.UserID";
				$sWhere = "WHERE p.client_id = ".$this->session->userdata("userid")."";
				if($sSearch){$sWhere .= " AND (payment_date like '%".$sSearch."%' OR payment_amt like '%".$sSearch."%' OR payment_balance like '%".$sSearch."%'  OR payment_desc like '%".$sSearch."%' OR stud_name like '%".$sSearch."%' OR payment_type like '%".$sSearch."%')";}
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