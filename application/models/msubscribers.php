<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Msubscribers extends CI_Model {
	public function __construct()
	{
			// Call the CI_Model constructor
			parent::__construct();
	}
		
	function addservice(){
		$values = $this->input->post('values');
		$values['SPID'] = $this->session->userdata("userid");
		$values['servicestatus'] = 1;
		//$check_table = $this->checktable('tbl_list_tools','agent_id','WHERE agent_id='.$values['agent_id']);
		
		foreach($values as $key =>$val){
			$data[$key] = $val;
		}
		
		//if($check_table == 0){
			$this->db->insert('services',$data);
		//}else{
			//$this->db->where('agent_id',$values['agent_id']);
			//$this->db->update('tbl_list_tools',$data);
		//}
		
		$msg = 'List of logins has been successfully saved.';
		
		return $msg;
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
				$aColumns = array("serviceid","servicename", "servicedesc", "serviceschedule", "serviceregistrationfee", "serviceprice",'serviceWalkin',"serviceHour","servicetype");
				$select = array("serviceid","servicename", "servicedesc", "serviceschedule", "serviceregistrationfee", "serviceprice","serviceWalkin","serviceHour as servicehour","(CASE WHEN servicetype=1 THEN 'Arts' ELSE 'Sports' END) as servicetype","1 as action");
				$sTable = "services";
				$leftjoin = " ";
				if($usertype == 0)
					$sWhere = "WHERE servicestatus=1";
				else
					$sWhere = "WHERE servicestatus=1 AND spid = ".$this->session->userdata("userid");

				if($sSearch){$sWhere .= " AND (servicename like '%".$sSearch."%' OR servicedesc like '%".$sSearch."%' OR serviceschedule like '%".$sSearch."%' OR serviceregistrationfee like '%".$sSearch."%' OR servicetype like '%".$sSearch."%' OR serviceprice like '%".$sSearch."%')";}
				$sOrder = 'ORDER BY '.$aColumns[$sSort].' '.$sSortype;
				$groupby = "";
				$aColumns_output = array("serviceid","servicename","servicedesc", "serviceschedule", "serviceregistrationfee", "serviceWalkin","servicehour","serviceprice", "servicetype","action");
			break;
			case 2:
				$aColumns = array("a.UserID",
								  "e.UserName", 
								  "b.clinic_name", 
								  "a.SPBirthday", 
								  "a.SPContactNo", 
								  "a.SPEmail",
								  "a.SPRegisteredDate",
								  "d.PlanName",
								  "a.UserStatus");
				$select = array("a.UserID as UserID",
								 "CONCAT(a.spfirstname,' ',a.splastname) as name",
								  "e.UserName", 
								  "b.clinic_name", 
								  "a.SPBirthday", 
								  "a.SPContactNo", 
								  "a.SPEmail",
								  "a.SPRegisteredDate",
								  "d.PlanName",
								  "(CASE WHEN e.UserStatus=0 THEN 'UNVERIFIED' WHEN e.UserStatus=1 THEN 'ACTIVE' ELSE 'INACTIVE' END) as UserStatus",
								  "1 as action");
				$sTable = "user_details a";
				$leftjoin = " LEFT JOIN clinics b ON b.UserID=a.UserID LEFT JOIN subscriptions c ON c.UserID=a.UserID LEFT JOIN subscription_plans d ON d.PlanID=c.SubscType LEFT JOIN user_accounts e ON e.UserID=a.UserID";
				$sWhere = "WHERE e.UserType=1";
				if($sSearch){$sWhere .= " AND (a.UserID like '%".$sSearch."%' OR e.UserName like '%".$sSearch."%' OR b.clinic_name like '%".$sSearch."%' OR a.SPBirthday like '%".$sSearch."%' OR a.SPContactNo like '%".$sSearch."%' OR a.SPRegisteredDate like '%".$sSearch."%' OR d.PlanName like '%".$sSearch."%' OR UserStatus like '%".$sSearch."%' OR a.spfirstname like '%".$sSearch."%' OR a.splastname like '%".$sSearch."%')";}
				$sOrder = 'ORDER BY '.$aColumns[$sSort].' '.$sSortype;
				$groupby = "";
				$aColumns_output = array("UserID",
										"name",
										"UserName", 
										"clinic_name", 
										"SPBirthday", 
										"SPContactNo", 
										"SPEmail",
										"SPRegisteredDate",
										"PlanName",
										"UserStatus",
										"action");
			break;
			case 3:
				$interestids = $this->getID("client_interest", "interest_ids" , "WHERE client_id = '".$this->session->userdata("userid")."'");
				$aColumns = array("interest_id","interest_name", "interest_type");
				$select = array("interest_id","interest_name", "(CASE WHEN interest_type=1 THEN 'Arts' ELSE 'Sports' END) as interest_type", "1 as action");
				$sTable = "interest";
				$leftjoin = " ";
				$sWhere = "WHERE interest_id IN (".$interestids.") ";
				if($sSearch){$sWhere .= " AND (interest_name like '%".$sSearch."%' OR interest_type like '%".$sSearch."%')";}
				$sOrder = 'ORDER BY '.$aColumns[$sSort].' '.$sSortype;
				$groupby = "";
				$aColumns_output = array("interest_id","interest_name", "interest_type","action");
			break;
			case 4:
				$aColumns = array("payment_id","payment_date", "payment_amt","payment_balance","payment_desc","stud_name","payment_type");
				$select = array("payment_id","payment_date", "payment_amt", "payment_balance","payment_desc","stud_name","(CASE WHEN payment_type=0 THEN 'Session'  WHEN payment_type=1 THEN 'Monthly' ELSE 'Membership' END)  as payment_type");
				$sTable = "payment_logs p";
				$leftjoin = " LEFT JOIN students s ON s.stud_id = p.stud_id";
				$sWhere = "WHERE p.client_id = ".$this->session->userdata("userid")."";
				if($sSearch){$sWhere .= " AND (payment_date like '%".$sSearch."%' OR payment_amt like '%".$sSearch."% OR payment_balance like '%".$sSearch."%  OR payment_desc like '%".$sSearch."% OR stud_name like '%".$sSearch."% OR payment_type like '%".$sSearch."%')";}
				$sOrder = 'ORDER BY '.$aColumns[$sSort].' '.$sSortype;
				$groupby = "";
				$aColumns_output = array("payment_id","payment_date", "payment_amt","payment_balance","payment_desc","stud_name","payment_type");
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

	public function get_data($table, $fields , $where, $order){
		$query = $this->db->query("SELECT $fields FROM $table $where $order");
		return $query->result();
	}

	function listall(){
		$sql = "SELECT * FROM user_details WHERE usertype = 1 and userstatus=1";
		$q = $this->db->query($sql);

		if($q->num_rows() > 0){
			foreach($q->result() as $row){
				$spname = $row->SPName;
			}
		}
	}
	function getID($table,$field,$where){
		$sql = "SELECT $field FROM $table $where";
		$q = $this->db->query($sql);
		$id = 0;
		if($q->num_rows() > 0){
			foreach($q->result() as $row){
				$id = $row->$field;
			}
		}	
		return $id;
	}
}