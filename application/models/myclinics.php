<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class myclinics extends CI_Model {
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
	
	function bookmark(){
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
		$frmdata = $this->input->post('data');
		if($frmdata['studType'] ==0){ //new student
			
			$ch = $this->checkData("students", "stud_id", "WHERE stud_name='".$frmdata['stud_name']."' AND stud_age='".$frmdata['stud_age']."' AND stud_address='".$frmdata['stud_address']."' AND clinic_id='".$frmdata['clinic_id']."' AND client_id='".$this->session->userdata('userid')."'");

			if($ch){
				$error = 3; //existing student in a clinic
			}else{
				$data_stud['stud_name'] = $frmdata['stud_name'];
				$data_stud['stud_age'] = $frmdata['stud_age'];
				$data_stud['stud_address'] = $frmdata['stud_address'];
				$data_stud['clinic_id'] = $frmdata['clinic_id'];
				$data_stud['client_id'] = $this->session->userdata('userid');
				$data_stud['stud_status'] = 1;
				
				$insert = $this->db->insert('students',$data_stud);
				
				$data_enroll['stud_id'] = $this->getID("students", "stud_id", "WHERE stud_name='".$frmdata['stud_name']."' AND stud_age='".$frmdata['stud_age']."' AND stud_address='".$frmdata['stud_address']."' AND clinic_id='".$frmdata['clinic_id']."' AND client_id='".$this->session->userdata('userid')."'");;
				$data_enroll['client_id'] = $this->session->userdata('userid');
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
			$ch = $this->checkData("students_enrolled", "StudEnrolledID", "WHERE stud_id='".$frmdata['stud_id']."' AND client_id='".$this->session->userdata('userid')."' AND service_id='".$frmdata['service_id']."' AND clinic_id='".$frmdata['clinic_id']."' AND SchedID='".$frmdata['SchedID']."' AND StudEnrolledStatus=1");
			
			if($ch){
				$error = 4; //student already enrolled in this schedule
			}else{
				$data_enroll['stud_id'] = $frmdata['stud_id'];
				$data_enroll['client_id'] = $this->session->userdata('userid');
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
		$sql = "SELECT $field FROM students $where";
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