<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class mreviews_and_ratings extends CI_Model {
	public function __construct()
	{
			// Call the CI_Model constructor
			parent::__construct();
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
	
	function saveReviewRatings(){
		$stat = $this->input->post('stat');
		$reviewsid = $this->input->post('reviewsid');
		$userid = $this->session->userdata('userid');
		
		$data = array("ReviewStatus"=>$stat);
		
		$this->db->where('EnrolledID',$reviewsid);	
		$q = $this->db->update('reviews_and_ratings',$data);

		if($q) return 1;
		else return 0;
	}
}