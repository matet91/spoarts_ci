<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class mmyevents extends CI_Model {
	public function __construct()
	{
			// Call the CI_Model constructor
			parent::__construct();
			date_default_timezone_set('Asia/Manila');
			$this->load->model('mglobal');
	}
		
	function getlistid($table, $fields , $where, $order, $leftjoin){
		$query = $this->db->query("SELECT $fields FROM $table $leftjoin $where $order");
		$rowid = array();
		foreach ($query->result() as $row){
		   $rowid[] = $row->$fields;
		}
		return $rowid;
	}
	
	function saveEnrollEvent(){
		$userid = $this->session->userdata('userid');
		$frmdata = $this->input->post('data');
		if($frmdata['studType'] ==0){ //new student
			
			$ch = $this->checkData("students", "stud_id", "WHERE stud_age='".$frmdata['stud_age']."' AND stud_address='".$frmdata['stud_address']."' AND client_id='".$userid."' AND stud_type=1");
	
			if($ch){
				$error = 3; //existing student in a clinic
			}else{
				$data_stud['stud_age'] = $frmdata['stud_age'];
				$data_stud['stud_address'] = $frmdata['stud_address'];
				$data_stud['stud_name'] = $frmdata['stud_name'];
				$data_stud['stud_relationship'] = $frmdata['stud_relationship'];
				$data_stud['client_id'] = $userid;
				$data_stud['stud_type'] = 1;
				
				$insert = $this->db->insert('students',$data_stud);
				
				$data_enroll['stud_id'] = $this->getID("students", "stud_id", "WHERE  stud_age='".$frmdata['stud_age']."' AND stud_address='".$frmdata['stud_address']."' AND client_id='".$userid."' AND stud_type=1");
				$data_enroll['client_id'] = $userid;
				$data_enroll['EventID'] = $frmdata['EventID'];
				$data_enroll['clinic_id'] = $frmdata['SPID'];
				$data_enroll['EventEnrolledStatus'] = 1;
				
				$insert2 = $this->db->insert('events_enrolled',$data_enroll);
				
				if($insert and $insert2){$error = 0;
				}else{$error = 1;}
				
			}
		}else if($frmdata['studType'] ==1){ //existing
			$ch = $this->checkData("events_enrolled", "EventEnrolledID", "WHERE stud_id='".$frmdata['stud_id']."' AND client_id='".$userid."' AND clinic_id='".$frmdata['SPID']."' AND EventID='".$frmdata['EventID']."'AND (EventEnrolledStatus=0 or EventEnrolledStatus=1)");
			
			if($ch){
				$error = 4; //student already enrolled in this schedule
			}else{
				$data_enroll['stud_id'] = $frmdata['stud_id'];
				$data_enroll['client_id'] = $userid;
				$data_enroll['EventID'] = $frmdata['EventID'];
				$data_enroll['clinic_id'] = $frmdata['SPID'];
				$data_enroll['EventEnrolledStatus'] = 1;
				$insert = $this->db->insert('events_enrolled',$data_enroll);
				if($insert){$error = 0;
				}else{$error = 1;}
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
				$data_stud['stud_name'] = $rows['spfirstname'].' '.$rows['splastname'];
				$data_stud['stud_age'] = $age;
				$data_stud['stud_address'] = $rows['spaddress'];
				$data_stud['client_id'] = $userid;
				$data_stud['stud_type'] = 0;
				
				$insert = $this->db->insert('students',$data_stud);
				
				if($insert){$error = 0;
				}else{$error = 1;}
			}
			
			$stud_id = $this->getID("students", "stud_id", "WHERE client_id='".$userid."' AND stud_type=0");
			//echo $this->db->last_query();
			$ch = $this->checkData("events_enrolled", "EventEnrolledID", "WHERE stud_id='".$stud_id."' AND client_id='".$userid."' AND clinic_id='".$frmdata['SPID']."' AND EventID='".$frmdata['EventID']."'AND (EventEnrolledStatus=0 or EventEnrolledStatus=1)");
			//echo $this->db->last_query();
			//echo $ch;
			
			if($ch){
				$error = 4; //student already enrolled in this schedule
			}else{	
				$data_enroll['stud_id'] = $stud_id;
				$data_enroll['client_id'] = $userid;
				$data_enroll['EventID'] = $frmdata['EventID'];
				$data_enroll['clinic_id'] = $frmdata['SPID'];
				$data_enroll['EventEnrolledStatus'] = 1;
				$insert = $this->db->insert('events_enrolled',$data_enroll);
				
				if($insert){$error = 0;
				}else{$error = 1;}
			}
			
			
		}
		if($error == 0){
			switch($frmdata['studType']){
				case 0: //new student
						$studname = $frmdata['stud_name'];
						
				break;

				case 1: //existing student
						$sid = $frmdata['stud_id'];
						$sqql21 = $this->db->query("SELECT stud_name FROM students WHERE stud_id='$sid'");
						$rod2 = $sqql21->row();
						$studname = $rod2->stud_name;
				break;

				case 2: //client as student
						$sid = $this->getID("students", "stud_id", "WHERE client_id='".$userid."' AND stud_type=0");
						$sqql21 = $this->db->query("SELECT stud_name FROM students WHERE stud_id='$sid'");
						$rod2 = $sqql1->row();
						$studname = $rod->stud_name;

				break;
			}
			
				
				$EventID = $frmdata['EventID'];

				$sql = $this->db->query("SELECT * FROM events WHERE EventID='$EventID'");
				//echo $this->db->last_query();
				$rowx = $sql->row();
				$eventname = $rowx->EventName;
				$clientid = $rowx->SPID; //service provider id
				$myid = $this->session->userdata('userid'); //logged in userid
				//GET name of the client 
				$sqql1 = $this->db->query("SELECT CONCAT(spfirstname,' ',splastname) as name FROM user_details WHERE UserID='$myid'");
				$rod = $sqql1->row();
				$cname = $rod->name;

				//$subj = "For Approval Event [$eventname] : New Student Request";
				$subj = "Approved Event [$eventname] : New Student Request";
				$msg = "You have a new participant's request from client $cname. Participant Name: $studname.";

				$this->mglobal->addNotif($subj,$msg,$clientid);
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