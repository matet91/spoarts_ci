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
}