<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class mevents_and_promos extends CI_Model {
	public function __construct()
	{
			// Call the CI_Model constructor
			parent::__construct();
			$this->load->model('mglobal');
			$this->load->model('mmyevents');
	}
		
	function getlist($table, $fields , $where, $order){
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
	
	function getspid(){
		$userid = $this->session->userdata('userid');
		$sql = "SELECT SPID FROM user_details WHERE UserID='$userid'";
		$q = $this->db->query($sql);
		$spid = 0;
		if($q->num_rows() > 0){
			foreach($q->result() as $row){
				$spid = $row->SPID;
			}
		}
		
		return $spid;
	}
	
	function getdatabyfield($table, $field, $where, $order){
		$userid = $this->session->userdata('userid');
		$sql = "SELECT $field FROM $table $where $order";
		$q = $this->db->query($sql);
		$ndata = "";
		if($q->num_rows() > 0){
			foreach($q->result() as $row){
				$ndata = $row->$field;
			}
		}
		
		return $ndata;
	}
	
	function addEvents(){
		$userid= $this->session->userdata('userid');
		$frmdata = $this->input->post('data');
		foreach($frmdata as $row=>$val){
			if($row == "EventStartDate" or $row == "EventEndDate"){
				$data[$row]= date("Y-m-d", strtotime($val));
			}else{ $data[$row]=$val; }
		}
		$data['SPID']=$userid;
		$data['EventStatus'] = 1;
		$insert = $this->db->insert('events',$data);
		
		//saveNotification
		$sname = $this->getdatabyfield("services", "servicename", "WHERE SPID = $userid", ""); //service name
		$dataNotif["Subject"] = "New Event";
		$dataNotif["Message"] = "Event ".$frmdata['EventName']. " has been added by ".$sname;
		$dataNotif["DateCreated"] = date('Y-m-d');
		$dataNotif["SPID"] = $userid;
		$dataNotif["NotifStatus"] = 0;
		
		foreach($this->getCliendidAll() as $row){
			$dataNotif["ClientID"] = $row;
			$notif = $this->db->insert('notifications',$dataNotif);
			
		}
		
		if($insert and $notif){$error = 0;
		}else{$error = 1;}

		return $error;
	}
	
	function updateEvents(){
		$frmdata = $this->input->post('data');
		foreach($frmdata as $row=>$val){
			if($row == "EventStartDate" or $row == "EventEndDate"){
				$data[$row]= date("Y-m-d", strtotime($val));
			}else{ $data[$row]=$val; }
		}
		$data['SPID']=$this->session->userdata('userid');
		
		$this->db->where('EventID',$data['EventID']);	
		$update = $this->db->update('events',$data);
		
		//saveNotification
		$sname = $this->getdatabyfield("services", "servicename", "WHERE SPID = $userid", ""); //service name
		$dataNotif["Subject"] = "Update Event";
		$dataNotif["Message"] = "Event ".$frmdata['EventName']. " has been updated by ".$sname;
		$dataNotif["DateCreated"] = date('Y-m-d');
		$dataNotif["SPID"] = $userid;
		$dataNotif["NotifStatus"] = 0;
		
		foreach($this->getCliendidAll() as $row){
			$dataNotif["ClientID"] = $row;
			$notif = $this->db->insert('notifications',$dataNotif);
		}
		
		if($update and $notif){ $error = 0; //If successful
		}else{ $error = 1; } //If not successful

		return $error;
	}
	
	function getCliendidAll(){
		$userid= $this->session->userdata('userid');
		$clinicid = $this->getdatabyfield("clinics", "clinic_id", "WHERE UserID = $userid", ""); //clinic id
		$clientid_b = $this->mmyevents->getlistid("bookmark","client_id","WHERE clinic_id IN(".$clinicid.")","",""); // clients from bookmark
		$clientid_e = $this->mmyevents->getlistid("students_enrolled","client_id","WHERE clinic_id = ".$clinicid." AND StudEnrolledStatus=1 ","GROUP BY client_id,clinic_id",""); //client from enrollment
		$clientid_all = array_unique( array_merge( $clientid_e, $clientid_b ) ); //fuse two clients
		//$clientid_all = implode("," , $clientid_all); 
		
		return $clientid_all;
	}
	
	function addPromos(){
		$frmdata = $this->input->post('data');
		foreach($frmdata as $row=>$val){
			if($row == "PromoStartDate" or $row == "PromoEndDate"){
				$data[$row]= date("Y-m-d", strtotime($val));
			}else{ $data[$row]=$val; }
		}
		$data['SPID']=$this->session->userdata('userid');
		$data['PromoStatus'] = 1;
		$insert = $this->db->insert('promos',$data);
		
		//saveNotification
		$sname = $this->getdatabyfield("services", "servicename", "WHERE SPID = $userid", ""); //service name
		$dataNotif["Subject"] = "New Promo";
		$dataNotif["Message"] = "Promo ".$frmdata['PromoName']. " has been added by ".$sname;
		$dataNotif["DateCreated"] = date('Y-m-d');
		$dataNotif["SPID"] = $userid;
		$dataNotif["NotifStatus"] = 0;
		
		foreach($this->getCliendidAll() as $row){
			$dataNotif["ClientID"] = $row;
			$notif = $this->db->insert('notifications',$dataNotif);
		}
		
		if($insert and $notif){//if successful return 0
			$error = 0;
		}else{
			$error = 1;
		}

		return $error;
	}
	
	function updatePromos(){
		$frmdata = $this->input->post('data');
		foreach($frmdata as $row=>$val){
			if($row == "PromoStartDate" or $row == "PromoEndDate"){
				$data[$row]= date("Y-m-d", strtotime($val));
			}else{ $data[$row]=$val; }
		}
		$data['SPID']=$this->session->userdata('userid');
		
		$this->db->where('PromoID',$data['PromoID']);	
		$update = $this->db->update('promos',$data);
		
		//saveNotification
		$sname = $this->getdatabyfield("services", "servicename", "WHERE SPID = $userid", ""); //service name
		$dataNotif["Subject"] = "Update Promo";
		$dataNotif["Message"] = "Promo ".$frmdata['PromoName']. " has been updated by ".$sname;
		$dataNotif["DateCreated"] = date('Y-m-d');
		$dataNotif["SPID"] = $userid;
		$dataNotif["NotifStatus"] = 0;
		
		foreach($this->getCliendidAll() as $row){
			$dataNotif["ClientID"] = $row;
			$notif = $this->db->insert('notifications',$dataNotif);
		}
		
		if($update and $notif){ $error = 0; //If successful
		}else{ $error = 1; } //If not successful

		return $error;
	}
	
	function removePromos(){
		$stat = $this->input->post('stat');
		$promoid = $this->input->post('id');
		$userid = $this->session->userdata('userid');
		
		$data = array("PromoStatus"=>$stat, "PromoID"=>$promoid);
		
		$this->db->where('PromoID',$promoid);	
		$q = $this->db->update('promos',$data);

		if($q) return 0;
		else return 1;
	}
	
	function removeEvents(){
		$stat = $this->input->post('stat');
		$eventid = $this->input->post('id');
		$userid = $this->session->userdata('userid');
		
		$data = array("EventStatus"=>$stat, "EventID"=>$eventid);
		
		$this->db->where('EventID',$eventid);	
		$q = $this->db->update('events',$data);

		if($q) return 0;
		else return 1;
	}
}