<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class mservices extends CI_Model {
	public function __construct()
	{
			// Call the CI_Model constructor
			parent::__construct();
	}
		
	function addServices(){
		$frmdata = $this->input->post('data');
		foreach($frmdata as $row=>$val){
			$data[$row]=$val;
		}
		$data['SPID']=$this->session->userdata('userid');
		$data['ServiceStatus'] = 1;
		$insert = $this->db->insert('services',$data);

		return $insert;
	}

	function loadprofile(){
		$userid = $this->session->userdata('userid');
		$sql = "SELECT * FROM user_details a LEFT JOIN clinics b ON a.UserID=b.UserID  LEFT JOIN user_accounts c ON c.UserID = a.UserID WHERE a.UserID='$userid'";

		$q = $this->db->query($sql);

		$row = $q->row();
		return $row;
	}

	function uploadClubPic(){
		$details = $_FILES['clubpic'];
		$userid = $this->session->userdata('userid');
		$name = $details['name'];
		$tmp_name = $details['tmp_name'];
		$dir = "assets/images/".$name;

		move_uploaded_file($tmp_name, $dir);
			$this->db->where('UserID',$userid);
			$this->db->update('clinics',array('clinic_logo'=>$name));
			
		return $name;
	}

	function checkSecurityPwd(){
		$pwd = md5($this->input->post('pwd'));
		$userid = $this->session->userdata('userid');

		$sql = "SELECT * FROM user_accounts WHERE UserID = '$userid' and security_password = '$pwd'";

		$q = $this->db->query($sql);

		if($q->num_rows() > 0){
			return 1;
		}else{
			return 0;
		}
	}

	function saveClinicInfo(){
		$data = $this->input->post('data');
		$userid = $this->session->userdata('userid');

		$this->db->where('UserID',$userid);
		$q = $this->db->update('clinics',$data);

		if($q) return 1;
		else return 0;
	}

	function dataTables($case,$serviceid=null){
		$sSort = $this->input->get('iSortCol_0');
		$sSortype = $this->input->get('sSortDir_0');
		$sSearch = $this->input->get('sSearch');
		$usertype = $this->session->userdata('usertype');
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
				if($usertype == 0)
					$sWhere = "WHERE servicestatus=1";
				else
					$sWhere = "WHERE servicestatus=1 AND spid = ".$this->session->userdata("userid");

				if($sSearch){$sWhere .= " AND (servicename like '%".$sSearch."%' OR servicedesc like '%".$sSearch."%' OR serviceschedule like '%".$sSearch."%' OR serviceregistrationfee like '%".$sSearch."%' OR servicetype like '%".$sSearch."%' OR serviceprice like '%".$sSearch."%')";}
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
				$sWhere = "WHERE service_id = '$serviceid'";
				if($sSearch){$sWhere .= " AND (ins_name like '%".$sSearch."%' OR ins_room like '%".$sSearch."%' OR ins_schedule like '%".$sSearch."%' OR ins_status like '%".$sSearch."%')";}
				$sOrder = 'ORDER BY '.$aColumns[$sSort].' '.$sSortype;
				$groupby = "";
				$aColumns_output = $aColumns;
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

	function addInstructor(){
		$data = $this->input->post('data');
		$data['ins_status'] = 1;
		$q = $this->db->insert('instructors',$data);

		return $q;
	}

	function getData(){
		$id = $this->input->post('id');
		$type = $this->input->post('type');

		switch($type){
			case 1: //services
					$sql = "SELECT * FROM services WHERE ServiceID = '$id'";
			break;
		}

		$q = $this->db->query($sql);

		return $q->result();
	}

	function updateServices($id){
		$data = $this->input->post('data');
		$this->db->where('ServiceId',$id);
		$q = $this->db->update('services',$data);

		return $q;
	}
	
	function deleteService($id){
		$this->db->where('ServiceId',$id);
		$q = $this->db->delete('services');
		return $q;
	}
}