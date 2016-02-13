<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class mclinics extends CI_Model {
	public function __construct()
	{
			// Call the CI_Model constructor
			parent::__construct();
	}
	
	function getlist($table, $fields , $where, $order){
		$query = $this->db->query("SELECT $fields FROM $table $where $order");
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
			
			$ch = $this->checkData("students", "stud_id", "WHERE stud_name='".$frmdata['stud_name']."' AND stud_age='".$frmdata['stud_age']."' AND stud_address='".$frmdata['stud_address']."' AND clinic_id='".$frmdata['clinic_id']."' AND client_id='".$userid."' AND stud_type=1");
	
			if($ch){
				$error = 3; //existing student in a clinic
			}else{
				$data_stud['stud_name'] = $frmdata['stud_name'];
				$data_stud['stud_age'] = $frmdata['stud_age'];
				$data_stud['stud_address'] = $frmdata['stud_address'];
				$data_stud['clinic_id'] = $frmdata['clinic_id'];
				$data_stud['client_id'] = $userid;
				$data_stud['stud_status'] = 1;
				$data_stud['stud_type'] = 1;
				
				$insert = $this->db->insert('students',$data_stud);
				
				$data_enroll['stud_id'] = $this->getID("students", "stud_id", "WHERE stud_name='".$frmdata['stud_name']."' AND stud_age='".$frmdata['stud_age']."' AND stud_address='".$frmdata['stud_address']."' AND clinic_id='".$frmdata['clinic_id']."' AND client_id='".$userid."' AND stud_type=1");
				$data_enroll['client_id'] = $userid;
				$data_enroll['service_id'] = $frmdata['service_id'];
				$data_enroll['clinic_id'] = $frmdata['clinic_id'];
				$data_enroll['ins_id'] = $frmdata['ins_id'];
				$data_enroll['SchedID'] = $frmdata['SchedID'];
				$data_enroll['StudEnrolledStatus'] = 1;
				
				$insert2 = $this->db->insert('students_enrolled',$data_enroll);
				
				if($insert and $insert2){$error = 0;
				}else{$error = 1;}
			}
		}else if($frmdata['studType'] ==1){ //existing
			$ch = $this->checkData("students_enrolled", "StudEnrolledID", "WHERE stud_id='".$frmdata['stud_id']."' AND client_id='".$userid."' AND service_id='".$frmdata['service_id']."' AND clinic_id='".$frmdata['clinic_id']."' AND SchedID='".$frmdata['SchedID']."' AND StudEnrolledStatus=1");
			
			if($ch){
				$error = 4; //student already enrolled in this schedule
			}else{
				$data_enroll['stud_id'] = $frmdata['stud_id'];
				$data_enroll['client_id'] = $userid;
				$data_enroll['service_id'] = $frmdata['service_id'];
				$data_enroll['clinic_id'] = $frmdata['clinic_id'];
				$data_enroll['ins_id'] = $frmdata['ins_id'];
				$data_enroll['SchedID'] = $frmdata['SchedID'];
				$data_enroll['StudEnrolledStatus'] = 1;
				$data_enroll['stud_type'] = 1;
				$insert = $this->db->insert('students_enrolled',$data_enroll);
				
				if($insert){$error = 0;
				}else{$error = 1;}
			}
		}else if($frmdata['studType'] ==2){ //client_id
			//check first if the client is already in students
			$ch_stud = $this->checkData("students", "stud_id", "WHERE client_id='".$userid."' AND clinic_id='".$frmdata['clinic_id']."' AND stud_type=0 AND stud_status=1");
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
				$data_stud['stud_name'] = $rows['spfirstname'].' '.$rows['splastname'];
				$data_stud['stud_age'] = $age;
				$data_stud['stud_address'] = $rows['spaddress'];
				$data_stud['clinic_id'] = $frmdata['clinic_id'];
				$data_stud['client_id'] = $userid;
				$data_stud['stud_status'] = 1;
				$data_stud['stud_type'] = 0;
				
				$insert = $this->db->insert('students',$data_stud);
				
				if($insert){$error = 0;
				}else{$error = 1;}
			}
			
			$stud_id = $this->getID("students", "stud_id", "WHERE clinic_id='".$frmdata['clinic_id']."' AND client_id='".$userid."' AND stud_type=0");
			
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
}