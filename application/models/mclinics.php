<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class mclinics extends CI_Model {
	public function __construct()
	{
			// Call the CI_Model constructor
			parent::__construct();
	}
	
	function getlist($table, $fields , $where, $order, $leftjoin){
		$query = $this->db->query("SELECT $fields FROM $table $leftjoin $where $order");
		return $query->result();
	}
	
	function loadServices($c,$search){

		if(isset($search) && $search!='0'){
			$search = " AND (s.ServiceName LIKE '$search%' OR c.clinic_name LIKE '$search%')";
		}else{
			$search = "";
		}
		$sql = "SELECT * FROM clinics c LEFT JOIN services s ON s.SPID=c.UserID WHERE s.ServiceStatus='1' and s.ServiceType = '$c' $search";

		$q = $this->db->query($sql);
	//	echo $this->db->last_query();
		return $q->result();
	}
	
	function loadClinics($c,$search){

		if(isset($search) && $search!='0'){
			$search = " AND (c.clinic_name LIKE '$search%')";
		}else{
			$search = "";
		}
		
		$sql = "SELECT c.* FROM services s LEFT JOIN clinics c ON s.spid = c.UserID WHERE s.ServiceStatus=1 AND s.ServiceType=$c AND c.clinic_status=1 $search GROUP BY SPID,ServiceType";
		
		$q = $this->db->query($sql);
		return $q->result();
	}
	
	function bookmark(){
		$clinicid = $this->input->post('clinicid');
		$userid = $this->session->userdata('userid');
		//get list of bookmarked and verify if the clinic already exist
		$this->db->where('client_id',$userid);
		$this->db->select('clinic_id');	
		$q = $this->db->get('bookmark');
		
		if($q->num_rows() > 0){
			$row = $q->row();
			$clinics = explode(',',$row->clinic_id);
			if(in_array($clinicid,$clinics)){
				return 1; //already bookmarked
				exit();
			}else{
				array_push($clinics,$clinicid);
				$this->db->where('client_id',$userid);
				$d = $this->db->update('bookmark',array('clinic_id'=>implode(",",$clinics)));
				if($d == true)
					return 2;//bookmark updated
				else return 0; //error occurred
				exit();
			}

		}else{
			$data = array('clinic_id'=>$clinicid,'client_id'=>$userid);
			$d = $this->db->insert('bookmark',$data);

			if($d == true)
				return 3; //new clinic bookmark added
			else return 0; //error occurred
			exit();
		}
	}
	
	function bookmark_matet(){
		$serviceid = $this->input->post('serviceid');
		$clinicid = $this->input->post('clinicid');
		$userid = $this->session->userdata('userid');
		//get list of bookmarked and verify if the serviceid already exist
		$this->db->where('client_id',$userid);
		$this->db->select('service_id');
		
		$q = $this->db->get('bookmark');
		if($q->num_rows() > 0){
			$row = $q->row();
			$services = explode(',',$row->service_id);
			if(in_array($serviceid,$services)){
				return 1; //already bookmarked
				exit();
			}else{
				array_push($services,$serviceid);
				$this->db->where('client_id',$userid);
				$d = $this->db->update('bookmark',array('service_id'=>implode(",",$services)));
				if($d == true)
					return 2;//bookmark updated
				else return 0; //error occurred
				exit();
			}

		}else{
			$data = array('service_id'=>$serviceid,'clinic_id'=>$clinicid,'client_id'=>$userid);
			$d = $this->db->insert('bookmark',$data);

			if($d == true)
				return 3; //new service bookmark added
			else return 0; //error occurred
			exit();
		}
	}
	
	function saveEnroll(){
		$userid = $this->session->userdata('userid');
		$frmdata = $this->input->post('data');
		if($frmdata['studType'] ==0){ //new student
			
			$ch = $this->checkData("students", "stud_id", "WHERE stud_age='".$frmdata['stud_age']."' AND stud_address='".$frmdata['stud_address']."' AND client_id='".$userid."' AND stud_type=1");
	
			if($ch){
				$error = 3; //existing student in a clinic
			}else{
				$ch_sched = $this->checkData("schedules", "(schedremaining=schedslots) as ch_sched", "WHERE SchedID='".$frmdata['SchedID']."'");
	
				if($ch_sched['ch_sched'] == 0){
					$data_stud['stud_age'] = $frmdata['stud_age'];
					$data_stud['stud_address'] = $frmdata['stud_address'];
					$data_stud['stud_name'] = $frmdata['stud_name'];
					$data_stud['client_id'] = $userid;
					$data_stud['stud_type'] = 1;
					
					$insert = $this->db->insert('students',$data_stud);
					
					$data_enroll['stud_id'] = $this->getID("students", "stud_id", "WHERE  stud_age='".$frmdata['stud_age']."' AND stud_address='".$frmdata['stud_address']."' AND client_id='".$userid."' AND stud_type=1");
					$data_enroll['client_id'] = $userid;
					$data_enroll['service_id'] = $frmdata['service_id'];
					$data_enroll['clinic_id'] = $frmdata['clinic_id'];
					$data_enroll['ins_id'] = $frmdata['ins_id'];
					$data_enroll['SchedID'] = $frmdata['SchedID'];
					$data_enroll['StudEnrolledStatus'] = 0;
					
					$insert2 = $this->db->insert('students_enrolled',$data_enroll);
					
					if($insert and $insert2){$error = 0;
					}else{$error = 1;}
				}else{
					$error = 5; //full capacity
				}
				
			}
		}else if($frmdata['studType'] ==1){ //existing
			$ch = $this->checkData("students_enrolled", "StudEnrolledID", "WHERE stud_id='".$frmdata['stud_id']."' AND client_id='".$userid."' AND service_id='".$frmdata['service_id']."' AND clinic_id='".$frmdata['clinic_id']."' AND SchedID='".$frmdata['SchedID']."' AND StudEnrolledStatus=1");
			
			if($ch){
				$error = 4; //student already enrolled in this schedule
			}else{
				$ch_sched = $this->checkData("schedules", "(schedremaining=schedslots) as ch_sched", "WHERE SchedID='".$frmdata['SchedID']."'");
				if($ch_sched['ch_sched'] == 0){
					$data_enroll['stud_id'] = $frmdata['stud_id'];
					$data_enroll['client_id'] = $userid;
					$data_enroll['service_id'] = $frmdata['service_id'];
					$data_enroll['clinic_id'] = $frmdata['clinic_id'];
					$data_enroll['ins_id'] = $frmdata['ins_id'];
					$data_enroll['SchedID'] = $frmdata['SchedID'];
					$data_enroll['StudEnrolledStatus'] = 1;
					$insert = $this->db->insert('students_enrolled',$data_enroll);
					
					if($insert){$error = 0;
					}else{$error = 1;}
				}else{
					$error = 5;
				}
			}
		}else if($frmdata['studType'] ==2){ //client_id
			//check first if the client is already in students
			$ch_stud = $this->checkData("students", "stud_id", "WHERE client_id='".$userid."' AND stud_type=0");
			if(!$ch_stud){
				$this->db->where('UserID',$userid);
				$this->db->select('spfirstname,splastname,spaddress,spbirthday');
				$q = $this->db->get('user_details');	
				foreach ($q->result() as $row){
				   $rows['spfirstname'] = $row->spfirstname;
				   $rows['splastname'] = $row->splastname;
				   $rows['spaddress'] = $row->spaddress;
				   $rows['spbirthday'] = $row->spbirthday;
				}
				
				$then = DateTime::createFromFormat("Y-m-d", $rows['spbirthday']);
				$diff = $then->diff(new DateTime());
				$age = $diff->format("%y");
				
				//insert client data at first 
				$data_stud['serviceHour'] = $rows['spfirstname'].' '.$rows['splastname'];
				$data_stud['stud_age'] = $age;
				$data_stud['stud_address'] = $rows['spaddress'];
				$data_stud['client_id'] = $userid;
				$data_stud['stud_type'] = 0;
				
				$insert = $this->db->insert('students',$data_stud);
				
				if($insert){$error = 0;
				}else{$error = 1;}
			}
			
			$ch_sched = $this->checkData("schedules", "(schedremaining=schedslots) as ch_sched", "WHERE SchedID='".$frmdata['SchedID']."'");
			if($ch_sched['ch_sched'] == 0){
				$stud_id = $this->getID("students", "stud_id", "WHERE client_id='".$userid."' AND stud_type=0");
			
				$ch = $this->checkData("students_enrolled", "StudEnrolledID", "WHERE stud_id='".$stud_id."' AND client_id='".$userid."' AND service_id='".$frmdata['service_id']."' AND clinic_id='".$frmdata['clinic_id']."' AND SchedID='".$frmdata['SchedID']."' AND StudEnrolledStatus=1");
				if($ch){
					$error = 4; //student already enrolled in this schedule
				}else{	
					$data_enroll['stud_id'] = $stud_id;
					$data_enroll['client_id'] = $userid;
					$data_enroll['service_id'] = $frmdata['service_id'];
					$data_enroll['clinic_id'] = $frmdata['clinic_id'];
					$data_enroll['ins_id'] = $frmdata['ins_id'];
					$data_enroll['SchedID'] = $frmdata['SchedID'];
					$data_enroll['StudEnrolledStatus'] = 1;
					$insert = $this->db->insert('students_enrolled',$data_enroll);
					
					if($insert){$error = 0;
					}else{$error = 1;}
				}
			}else{
				$error = 5;
			}
			
			
		}
		return $error;
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
	
	function dataTables($switch,$id){
		$sSort = $this->input->get('iSortCol_0');
		$sSortype = $this->input->get('sSortDir_0');
		$sSearch = $this->input->get('sSearch');
		$usertype = $this->session->userdata('usertype');
		$sLimit = "";
		if ( $this->input->get('iDisplayStart')!='' && $this->input->get('iDisplayLength') != '-1' )
			$sLimit = "LIMIT ".intVal($this->input->get('iDisplayStart')).", ".intVal($this->input->get('iDisplayLength'));

		switch($switch){
			case 1:
				$aColumns = array("serviceid","servicename", "ServiceRegistrationFee","ServicePrice","serviceWalkin","serviceHour","ServiceType");
				$select = array("serviceid","servicename", "ServiceRegistrationFee", "ServicePrice","serviceWalkin","serviceHour","(CASE WHEN ServiceType=0 THEN 'Sports' ELSE 'Arts' END)  as ServiceType");
				$sTable = "services";
				$leftjoin = "";
				$sWhere = "WHERE SPID = ".$id."";
				if($sSearch){$sWhere .= " AND (servicename like '%".$sSearch."%' OR ServiceRegistrationFee like '%".$sSearch."%' OR ServicePrice like '%".$sSearch."%'  OR serviceWalkin like '%".$sSearch."%' OR serviceHour like '%".$sSearch."%' OR ServiceType like '%".$sSearch."%')";}
				$sOrder = 'ORDER BY '.$aColumns[$sSort].' '.$sSortype;
				$groupby = "";
				$aColumns_output = array("serviceid","servicename", "ServiceRegistrationFee","ServicePrice","serviceWalkin","serviceHour","ServiceType");
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
	
	function SaveRating(){
		$data = $this->input->post('data');
		$userid = $this->session->userdata('userid');
		
		$getstudid = $this->checkData("students_enrolled", "StudEnrolledID", "WHERE clinic_id='".$data['clinic_id']."' AND client_id= '".$userid."'");
		if($getstudid == 0){
			$error = 2; //not enrolled
		}else{
			$data['ReviewStatus'] = 0;
			$data['EnrolledID'] = $userid;

			$insert = $this->db->insert('reviews_and_ratings',$data);
			
			if($insert){$error = 0; //if success
			}else{$error = 1;} //if error
		}

		
		
		return $error;
	}
	
}