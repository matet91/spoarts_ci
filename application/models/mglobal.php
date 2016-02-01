<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class mglobal extends CI_Model {
	public function __construct()
	{
			// Call the CI_Model constructor
			parent::__construct();
	}
		
	function addQuestion(){
		$data['sec_questions'] = $this->input->post('quest');
		$q = $this->db->insert('security_questions',$data);

		return $q;
	}

	function loadSecurity(){
		$sql = "SELECT * FROM security_questions";
		$q = $this->db->query($sql);

		$result = $q->result();

		return $result;
	}

	function saveProfile(){
		$data = $this->input->post('data');
		$userid = $this->session->userdata('userid');
		$this->db->where('UserID',$userid);
		$tbl1 = $this->db->update('user_details',$data);
		
		if($tbl1) return 1;//successful
		else return 0;//error
	}

	function uploadProfilePhoto(){
		$details = $_FILES['member_pic'];
		$userid = $this->session->userdata('userid');
		$name = $details['name'];
		$tmp_name = $details['tmp_name'];
		$dir = "assets/images/".$name;

		move_uploaded_file($tmp_name, $dir);
			$this->db->where('UserID',$userid);
			$this->db->update('user_details',array('splogoname'=>$name));
			
		return $name;
	}

	function verifyPassword(){
		$case = $this->input->post('c');
		$pwd = md5($this->input->post('pwd'));
		$userid = $this->session->userdata('userid');

		switch($case){
			case 1://login password verify
				$field = 'Password';
			break;

			case 2:
				$field = 'security_password';
			break;
		}

		$sql = "SELECT * FROM user_accounts WHERE UserId='$userid' and $field='$pwd'";
		$q = $this->db->query($sql);

		if($q->num_rows() > 0) return 1;//verified
		else return 0; //incorrect password
	}

	function dropdown($table,$case,$where){

		$sql = "SELECT * FROM $table WHERE $where";
		$q = $this->db->query($sql);
		if($q->num_rows() > 0)
			$result = $q->result();
		else $result = array();

		return $result;
	}
}