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
			$data[$row]=ucfirst($val);
		}
		$data['SPID']=$this->session->userdata('userid');
		$data['ServiceStatus'] = 1;
		$insert = $this->db->insert('services',$data);

		return $insert;
	}

	function loadprofile(){
		$userid = $this->session->userdata('userid');
		$sql = "SELECT * FROM user_details a LEFT JOIN clinics b ON a.UserID=b.UserID  LEFT JOIN user_accounts c ON c.UserID = a.UserID LEFT JOIN subscriptions d ON d.UserID=a.UserID WHERE a.UserID='$userid'";

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
		$clinicInfo = array('clinic_name','SPLocation','SPAboutMe');

		$subsInfo['SubscType'] = $data['SubscType'];

		foreach($clinicInfo as $key){
			$clinicData[$key] = ucfirst($data[$key]);
		}
		$userid = $this->session->userdata('userid');

		$this->db->where('UserID',$userid);
		$q = $this->db->update('subscriptions',$subsInfo);

		//check if existing
		$this->db->where('UserID',$userid);
		$this->db->select("*");
		$chkq = $this->db->get('clinics');
		if($chkq->num_rows() > 0){
			$this->db->where('UserID',$userid);
			$q = $this->db->update('clinics',$clinicData);
		}else{
			$clinicData['UserID'] = $userid;
			$this->db->insert('clinics',$clinicData);
		}
		

		return $q;
	}

	function dataTables($case,$id=null){
		$sSort = $this->input->get('iSortCol_0');
		$sSortype = $this->input->get('sSortDir_0');
		$sSearch = $this->input->get('sSearch');
		$usertype = $this->session->userdata('usertype');
		$userid = $this->session->userdata('userid');
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

	function addInstructor(){
		$data = $this->input->post('data');
		$data['UserID'] = $this->session->userdata('userid');
		$q = $this->db->insert('instructor_masterlist',$data);
		return $q;
	}

	function getData(){
		$id = $this->input->post('id');
		$type = $this->input->post('type');

		switch($type){
			case 1: //services
					$sql = "SELECT * FROM services WHERE ServiceID = '$id'";
			break;

			case 2: //instructors
					$sql = "SELECT * FROM instructors WHERE ins_id = '$id'";
			break;
		}

		$q = $this->db->query($sql);

		return $q->result();
	}
	function UpdateData($id, $type){
		switch($type){
			case 1: //services
					$field = "ServiceId";
					$table = "services";
			break;
			case 2: //instructor
					$field = "ins_id";
					$table = "instructors";
			break;
		}
		$data = $this->input->post('data');
		$this->db->where($field,$id);
		$q = $this->db->update($table,$data);

		return $q;
	}
	
	function removeData($id,$type){
		switch($type){
			case 1: //services
					$field = 'ServiceId';
					$table = "services";
			break;

			case 2: //instructors
					$field = "isn_id";
					$table = "instructors";
			break;
		}
		$this->db->where($field,$id);
		$q = $this->db->delete($table);
		return $q;
	}

	function addSchedule(){
		$data = $this->input->post('data');
		$q = $this->db->insert('schedules',$data);
		return $q;
	}	

	function addRoom(){
		$data = $this->input->post('data');
		$data['UserID'] = $this->session->userdata('userid');
		$q = $this->db->insert('rooms',$data);
		return $q;
	}
}