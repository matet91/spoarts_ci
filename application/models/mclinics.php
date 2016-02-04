<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class mclinics extends CI_Model {
	public function __construct()
	{
			// Call the CI_Model constructor
			parent::__construct();
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
				array_push($services,$service);
				$this->db->where('client_id',$userid);
				$d = $this->db->update('bookmark',array('service_id'=>implode($services)));
				if($d == true)
					return 2;//bookmark updated
				else return 0; //error occurred
				exit();
			}

		}else{
			$data = array('service_id'=>$serviceid,'clinic_id'=>$clinicid,'client_id'=>$userid);
			$d = $this->db->insert('bookmark');

			if($d == true)
				return 3: //new service bookmark
			else return 0; //error occurred
			exit();
		}
	}
}