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
								  "e.UserStatus as ustatus",
								  "(CASE WHEN e.UserStatus=0 THEN 'UNVERIFIED' WHEN e.UserStatus=1 THEN 'ACTIVE' ELSE 'INACTIVE' END) as UserStatus",
								  "1 as action");
				$sTable = "user_details a";
				$leftjoin = " LEFT JOIN clinics b ON b.UserID=a.UserID LEFT JOIN subscriptions c ON c.UserID=a.UserID LEFT JOIN subscription_plans d ON d.PlanID=c.SubscType LEFT JOIN user_accounts e ON e.UserID=a.UserID";
				$sWhere = "WHERE e.UserType=1";
				if($sSearch){$sWhere .= " AND (a.UserID like '%".$sSearch."%' OR e.UserName like '%".$sSearch."%' OR b.clinic_name like '%".$sSearch."%' OR a.SPBirthday like '%".$sSearch."%' OR a.SPContactNo like '%".$sSearch."%' OR a.SPRegisteredDate like '%".$sSearch."%' OR d.PlanName like '%".$sSearch."%' OR UserStatus like '%".$sSearch."%' OR a.spfirstname like '%".$sSearch."%' OR a.splastname like '%".$sSearch."%')";}
				$sOrder = 'ORDER BY '.$aColumns[$sSort].' '.$sSortype;
				$groupby = "";
				$aColumns_output = array("ustatus",
										"UserID",
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
				
				$aColumns = array("PlanID","PlanName", "PlanDesc", "PlanPrice", "PlanTerm");
				$select = array("PlanID","PlanName", "PlanDesc", "PlanPrice", "PlanTerm","1 as action");
				$sTable = "subscription_plans";
				$leftjoin = " ";
				$sWhere = "";
				if($sSearch){$sWhere .= " (PlanName like '%".$sSearch."%' OR PlanDesc like '%".$sSearch."%' OR PlanPrice like '%".$sSearch."%' OR PlanTerm like '%".$sSearch."%')";}
				$sOrder = 'ORDER BY '.$aColumns[$sSort].' '.$sSortype;
				$groupby = "";
				$aColumns_output = array("PlanID","PlanName", "PlanDesc", "PlanPrice", "PlanTerm","action");
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

	function deactivateAccount($id,$t){
		switch($t){
			case 1: //activates
					$cstatus = 1;
			break;

			case 2: //deactivate
					$cstatus = 1;
			break;
		}
		$where = array('UserID'=>$id);
		$this->db->where($where);
		$this->db->update('clinics',array('clinic_status'=>$cstatus));
		$this->db->where($where);
		$q = $this->db->update('user_accounts',array('UserStatus'=>$t));
		return $q; 
	}

	function deleteAccount($id){
		//remove user in user_accounts, user_details, students_enrolled, other tables
		$tables = array('user_accounts','user_details','clinics');
		$where = array('UserID'=>$id);
		$this->db->where('SPID',$id);
		$this->db->delete('services'); //remove services

		$this->db->where($where);
		$q = $this->db->delete($tables);//delete from table arrayed tables
		return $q;
	}

	function savePlan(){
		$data = $this->input->post('data');
		$q = $this->db->insert('subscription_plans',$data);
		return $q;
	}

	function removeItem($id){
		$this->db->where('PlanID',$id);
		$q = $this->db->delete('subscription_plans');
		return $q;
	}

	function getPlanRow($id){
		$this->db->where('PlanID',$id);
		$this->db->select("*");
		$get = $this->db->get('subscription_plans');
		return $get->result();
	}

	function updatePlan($id){
		$data = $this->input->post('data');
		$this->db->where('PlanID',$id);
		$q = $this->db->update('subscription_plans',$data);
		return $q;
	}
}