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
		 $this->session->set_userdata('splogoname',$name);
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

	function addInterest(){
		$interest = $this->input->post('interest');
		$type = $this->input->post('type');

		$q = $this->db->insert('interest',array('interest_name'=>$interest,'interest_type'=>$type));

		if($q == true) return 1;
		else return 0;
	}

	function loadInterest($t){
		$this->db->order_by('interest_name');
		$this->db->where('interest_type',$t);
		$this->db->select('*');
		$q = $this->db->get('interest');

		$result = $q->result();
		return $result;
	}

	function saveSQSettings(){
		$sq = $this->input->post('sq');
		$sq_pwd = md5($this->input->post('sq_pwd'));
		$firstlogin = 1;
		$userid = $this->session->userdata('userid');

		$data = array(
						'security_question_id'=>$sq,
						'security_password'=>$sq_pwd,
						'first_login'=>$firstlogin
					);
		$this->db->where('UserID',$userid);
		$q = $this->db->update('user_accounts',$data);
		if($q == true){
			$this->db->where("sec_id",$sq);
			$this->db->select("*");
			$get = $this->db->get("security_questions");
			$sqrow=$get->row();
			$this->session->set_userdata('first_login',1);
			$this->session->set_userdata('securityquestion',$sqrow->sec_questions);
		}
		return $q;
	}

	function listInterest(){
		$this->db->select("*");
		$get = $this->db->get("interest");
		return $get->result();
	}

	function saveInterest(){
		$sq = $this->input->post('sq');
		$sq_pwd = md5($this->input->post('sq_pwd'));
		$interest =$this->input->post('interest');
		$firstlogin = 1;
		$userid = $this->session->userdata('userid');

		$data = array(
						'security_question_id'=>$sq,
						'security_password'=>$sq_pwd,
						'first_login'=>$firstlogin
					);
		$this->db->where('UserID',$userid);
		$q = $this->db->update('user_accounts',$data);

		$dataInterest = array(
							'client_id'=>$userid,
							'interest_ids'=>$interest
						);
		$this->db->insert('client_interest',$dataInterest);
		if($q == true){
			$this->db->where("sec_id",$sq);
			$this->db->select("*");
			$get = $this->db->get("security_questions");
			$sqrow=$get->row();

			$this->session->set_userdata('first_login',1);
			$this->session->set_userdata('securityquestion',$sqrow->sec_questions);
		}
		return $q;
	}

	function listings($c,$id=null){
			$select = "*";
		switch($c){
			case 1: //country
					
					$table = "countries";
			break;

			case 2: //states
					$where = array('country_id'=>$id);
					$table = "states";
					$this->db->where($where);
			break;

			case 3://cities
					$table = "cities";
					$where = array('state_id'=>$id);
					$this->db->where($where);
			break;

			case 4: //instructors
					$table = "instructor_masterlist";
					$select = "MasterInsID as id,MasterInsName as name";
					
			break;

			case 5: //room
					$table = "rooms";
					$select = "RoomID as id,RoomName as name";
					
			break;
		}

		$this->db->select($select);
		$data = $this->db->get($table);
		return $data->result();
	}
}