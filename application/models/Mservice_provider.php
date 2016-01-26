<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mservice_provider extends CI_Model {
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
				$aColumns = array("serviceid","servicename", "servicedesc", "serviceschedule", "serviceregistrationfee", "serviceprice","servicetype");
				$select = array("serviceid","servicename", "servicedesc", "serviceschedule", "serviceregistrationfee", "serviceprice","servicetype","1 as action");
				$sTable = "services";
				$leftjoin = " ";
				if($usertype == 0)
					$sWhere = "WHERE servicestatus=1";
				else
					$sWhere = "WHERE servicestatus=1 AND spid = ". $this->session->userdata("userid");

				if($sSearch){$sWhere .= " AND (servicename like '%".$sSearch."%' OR servicedesc like '%".$sSearch."%' OR serviceschedule like '%".$sSearch."%' OR serviceregistrationfee like '%".$sSearch."%' OR servicetype like '%".$sSearch."%' OR serviceprice like '%".$sSearch."%')";}
				$sOrder = 'ORDER BY '.$aColumns[$sSort].' '.$sSortype;
				$groupby = "";
				$aColumns_output = array("serviceid","servicename","servicedesc", "serviceschedule", "serviceregistrationfee", "serviceprice", "servicetype","action");
			break;
			case 2:
				$aColumns = array("memberid","membername", "memberaddress", "memberage", "memberenrolled", "clientid");
				$select = array("memberid","membername", "memberaddress", "memberage", "memberenrolled", "clientid", "1 as action");
				$sTable = "members";
				$leftjoin = " ";
				$sWhere = "WHERE memberstatus=1 AND spid = ". $this->session->userdata("userid");
				if($sSearch){$sWhere .= " AND (membername like '%".$sSearch."%' OR memberaddress like '%".$sSearch."%' OR memberage like '%".$sSearch."%' OR memberenrolled like '%".$sSearch."%' OR clientid like '%".$sSearch."%'";}
				$sOrder = 'ORDER BY '.$aColumns[$sSort].' '.$sSortype;
				$groupby = "";
				$aColumns_output = array("memberid","membername", "memberaddress", "memberage", "memberenrolled", "clientid","action");
			break;
		}
		
		$sIndexColumn = "*";
			
		$sQuery = "SELECT SQL_CALC_FOUND_ROWS ".implode(",", $select)." FROM $sTable $leftjoin $sWhere $groupby $sOrder $sLimit";
		
		//print_r("SELECT SQL_CALC_FOUND_ROWS ".implode(",", $aColumns)." FROM $sTable $leftjoin $sWhere $groupby $sOrder $sLimit");
		
		$rResult = $this->db->query( $sQuery );
		//echo $this->db->last_query();
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
				$row[] = ($aRow->$col =="0") ? '-' : $aRow->$col;
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
}