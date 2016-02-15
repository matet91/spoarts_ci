<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class mmyinterests extends CI_Model {
	public function __construct()
	{
			// Call the CI_Model constructor
			parent::__construct();
	}
	
	function getlist($table, $fields , $where, $order){
		$query = $this->db->query("SELECT $fields FROM $table $where $order");
		return $query->result();
	}
	
	
	function checkData($table, $field, $where){
		$sql = "SELECT $field FROM $table $where";
		$q = $this->db->query($sql);
		
		return $q->num_rows();
		
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
	
	function saveInterest(){
		$interestid = $this->input->post('interestid');
		$userid = $this->session->userdata('userid');
	
		//get list of selected interest
		$this->db->where('client_id',$userid);
		$this->db->select('interest_ids');	
		$q = $this->db->get('client_interest');
		
		if($q->num_rows() > 0){
			$row = $q->row();
			$rowinterestid = explode(',',$row->interest_ids);
			
			if(in_array($interestid,$rowinterestid)){
				return 1; //already save
				exit();
			}else{
				array_push($rowinterestid,implode(",",$interestid));
				$this->db->where('client_id',$userid);
				$d = $this->db->update('client_interest',array('interest_ids'=>implode(",",$rowinterestid)));
				if($d == true)
					return 2;//interest updated
				else return 0; //error occurred
				exit();
			}

		}else{
			$data = array('interest_ids'=>$clinicid,'client_id'=>$userid);
			$d = $this->db->insert('client_interest',$data);

			if($d == true)
				return 3; //new interest added
			else return 0; //error occurred
			exit();
		}
	}
	
	function deleteInterest(){
		$interestid = $this->input->post('interestid');
		$userid = $this->session->userdata('userid');
		
		$db_ids = explode(",",$this->mmyinterests->getID("client_interest", "interest_ids" , "WHERE client_id = '".$userid."'"));
		
		$key = array_search($interestid,$db_ids);
		
		if($key!==false){
			unset($db_ids[$key]);
		}
		
		$this->db->where('client_id',$userid);
		
		$d = $this->db->update('client_interest',array('interest_ids'=>implode(",",$db_ids)));
		if($d == true)
			return 1;//interest updated
		else return 0; //error occurred
		exit();

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
}