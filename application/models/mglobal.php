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
		$sql="SELECT interest_id FROM services WHERE ServiceStatus=1 GROUP BY interest_id";
		$get = $this->db->query($sql);
		$arrayInt = $this->interestlist(null);
		if($get->num_rows() > 0){
			foreach($get->result() as $key=>$val){
				$interest[$key] = $key;
			}

			$data = array_intersect_key($arrayInt, $interest);
		}else{
			$data = $arrayInt;
		}
		return $data;
	}

	function saveInterest(){
		$interest =$this->input->post('interest');
		$firstlogin = 1;
		$userid = $this->session->userdata('userid');

		$data = array(
						'first_login'=>$firstlogin
					);
		$this->db->where('UserID',$userid);
		$q = $this->db->update('user_accounts',$data);

		$dataInterest = array(
							'client_id'=>$userid,
							'interest_ids'=>$interest
						);
		$this->db->insert('client_interest',$dataInterest);
		$this->session->set_userdata('first_login',1);
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
					$this->db->where('MasterInsStatus',1);
					$this->db->where('UserID',$this->session->userdata('userid'));
			break;

			case 5: //room
					$table = "rooms";
					$select = "RoomID as id,CONCAT(RoomNo,'-',RoomName)as name";
					$this->db->where('RoomStatus',1);
					$this->db->where('UserID',$this->session->userdata('userid'));
			break;

			case 6: //services
					$table = "services";
					$select = "ServiceID as id,ServiceName as name";
					$this->db->where('SPID',$this->session->userdata('userid'));
			break;
			case 7: //time logs
					$table = "time_logs";
					$select = "DATE(tl_in) as name,tl_id as id";
					$this->db->where('StudEnrolledID',$id);
					$this->db->where('tl_paid',0);
			break;
		}

		$this->db->select($select);
		$data = $this->db->get($table);
		return $data->result();
	}

	function testimonials(){
		$sql = "SELECT a.ReviewsID,a.DatePosted,a.Message,a.Rating,b.clinic_name as clinic,CONCAT(c.spfirstname,'',c.splastname) as client FROM reviews_and_ratings a LEFT JOIN clinics b ON a.SPID=b.UserID LEFT JOIN user_details c ON a.EnrolledID = c.UserID WHERE a.ReviewStatus = 2 ORDER BY a.ReviewsID desc";
		$get = $this->db->query($sql);
		return $get->result();
	}

	function showallclubs(){
		$userid = $this->session->userdata('userid');
		if($userid){
			$this->db->where('client_id',$userid);
			$this->db->select('clinic_id');
			$getB = $this->db->get('bookmark');
			$clinic = array();
			if($getB->num_rows() > 0){
				$row = $getB->row();
				$clinic = explode(',',$row->clinic_id);
			}

			//get interest
			$this->db->where('client_id',$userid);
			$this->db->select('interest_ids');
			$getI = $this->db->get('client_interest');
			if($getI->num_rows() > 0){
				$rowx = $getI->row();
				$inid = $rowx->interest_ids;
				$sqlx = "SELECT b.clinic_id FROM services a LEFT JOIN clinics b ON a.SPID=b.UserID WHERE a.interest_id in (".$inid.") GROUP BY a.SPID";
				$qx = $this->db->query($sqlx);
				if($qx->num_rows() > 0){
					foreach($qx->result() as $qrow){
						array_push($clinic,$qrow->clinic_id);
					}
				}
			}
			$cliniclist = $clinic;

			if(isset($cliniclist)){
				$this->db->where_in('clinic_id',$cliniclist);
			}
		}
		$this->db->where('clinic_status',1);
		$this->db->select("*");
		$get = $this->db->get("clinics");

		return $get->result();	
	}

	function loadEventPromo(){
		$sql = "SELECT EventName as name, EventDesc as 'desc',EventStartDate as start, EventEndDate as 'end',EventLocation as location,timestamp FROM events WHERE EventStatus=1 ORDER BY timestamp desc";
		$q = $this->db->query($sql);
		$data = array();
		if($q->num_rows > 0){
			foreach($q->result() as $row){
				$data[] = array('name' => $row->name,
							'desc' =>$row->desc,
							'start' => $row->start,
							'end' => $row->end,
							'location' => $row->location,
							'timestamp' => date('Y-m-d',strtotime($row->timestamp)),
							'type' => 0);
			}
		}

		$sql = "SELECT PromoName as name,PromoDesc as 'desc',PromoStartDate as start,PromoEndDate as 'end',timestamp FROM promos WHERE PromoStatus=1 ORDER BY timestamp desc";
		$qx = $this->db->query($sql);
		if($qx->num_rows() > 0){
			foreach($qx->result() as $row){
				$data[] = array('name' =>$row->name,
								'desc' =>$row->desc,
								'start' => $row->start,
								'end' => $row->end,
								'location' => '',
								'timestamp' => date('Y-m-d',strtotime($row->timestamp)),
								'type' => 1);
			}
		}

		return $data;
	}

	function countNotification(){
		$userid = $this->session->userdata('userid');
		$sql = "SELECT NotifID FROM notifications WHERE ClientID =".$userid." AND NotifStatus=0";
		$q = $this->db->query($sql);
		
		return $q->num_rows();
	}

	function addNotif($subj,$msg,$clientid){
		$userid = $this->session->userdata('userid');
		$data = array('Subject'=>$subj,'Message'=>$msg,'ClientID'=>$clientid,'SPID'=>$userid);
		$this->db->insert('notifications',$data);
	}
	function saveNotification(){
		$values = $this->input->post('data');
		$userid = $this->session->userdata('userid');
		
		foreach($values as $key =>$val){
			$data[$key] = $val;
		}
		
		$insert = $this->db->insert('notifications',$data);
					
		if($insert){$error = 0;
		}else{$error = 1;}
		
		return $error;
	}
	function readNotification(){
		$userid = $this->session->userdata('userid');
		$sql = "Update notifications SET NotifStatus=1 WHERE ClientID=$userid";
		$q = $this->db->query($sql);
		return 0;
	}
	
	function getInterests(){
		$interest = (object)array(array("interest_id"=>1,"interest_name"=>"Animation","interest_type"=>1),
			array("interest_id"=>2,"interest_name"=>"Architecture","interest_type"=>1),
			array("interest_id"=>3,"interest_name"=>"Body Art","interest_type"=>1),
			array("interest_id"=>6,"interest_name"=>"Brief Art","interest_type"=>1),
			array("interest_id"=>7,"interest_name"=>"Cinema","interest_type"=>1),
			array("interest_id"=>8,"interest_name"=>"Comic Writing","interest_type"=>1),
			array("interest_id"=>9,"interest_name"=>"Dance","interest_type"=>1),
			array("interest_id"=>10,"interest_name"=>"Digital Art","interest_type"=>1),
			array("interest_id"=>11,"interest_name"=>"Drawing","interest_type"=>1),
			array("interest_id"=>12,"interest_name"=>"Engraving","interest_type"=>1),
			array("interest_id"=>13,"interest_name"=>"Fractal art","interest_type"=>1),
			array("interest_id"=>14,"interest_name"=>"Gastronomy","interest_type"=>1),
			array("interest_id"=>15,"interest_name"=>"Gold-smithery, silver-smithery, and jewellery","interest_type"=>1),
			array("interest_id"=>16,"interest_name"=>"Graffiti","interest_type"=>1),
			array("interest_id"=>17,"interest_name"=>"Music","interest_type"=>1),
			array("interest_id"=>18,"interest_name"=>"Opera","interest_type"=>1),
			array("interest_id"=>19,"interest_name"=>"Painting","interest_type"=>1),
			array("interest_id"=>20,"interest_name"=>"Photography","interest_type"=>1),
			array("interest_id"=>21,"interest_name"=>"Poetry","interest_type"=>1),
			array("interest_id"=>22,"interest_name"=>"Pottery","interest_type"=>1),
			array("interest_id"=>23,"interest_name"=>"Sculpture","interest_type"=>1),
			array("interest_id"=>24,"interest_name"=>"Singing","interest_type"=>1),
			array("interest_id"=>25,"interest_name"=>"Theatre","interest_type"=>1),
			array("interest_id"=>27,"interest_name"=>"Woodwork","interest_type"=>1),
			array("interest_id"=>28,"interest_name"=>"Writing","interest_type"=>1),
			array("interest_id"=>29,"interest_name"=>"Air sports","interest_type"=>0),
			array("interest_id"=>30,"interest_name"=>"Archery","interest_type"=>0),
			array("interest_id"=>31,"interest_name"=>"Ball-over-net games","interest_type"=>0),
			array("interest_id"=>32,"interest_name"=>"Basketball family","interest_type"=>0),
			array("interest_id"=>33,"interest_name"=>"Board sports","interest_type"=>0),
			array("interest_id"=>34,"interest_name"=>"Climbing","interest_type"=>0),
			array("interest_id"=>35,"interest_name"=>"Cycling","interest_type"=>0),
			array("interest_id"=>36,"interest_name"=>"Combat sports: Wrestling and martial arts","interest_type"=>0),
			array("interest_id"=>37,"interest_name"=>"Dance","interest_type"=>0),
			array("interest_id"=>38,"interest_name"=>"Football","interest_type"=>0),
			array("interest_id"=>39,"interest_name"=>"Ice sports","interest_type"=>0),
			array("interest_id"=>40,"interest_name"=>"Running","interest_type"=>0),
			array("interest_id"=>41,"interest_name"=>"Snow sports","interest_type"=>0),
			array("interest_id"=>42,"interest_name"=>"Table sports","interest_type"=>0)
		);
		return $interest;
	}

	function interestlist($id){ //indae


		$arraylist = array("","Animation","Architecture","Body Art","Brief Art","Cinema","Comic Writing","Dance","Digital Art","Drawing","Engraving","Fractal art","Gastronomy","Gold-smithery, silver-smithery, and jewellery","Graffiti","Music","Opera","Painting","Photography","Poetry","Pottery","Sculpture","Singing","Theatre","Woodwork","Writing","Air sports","Archery","Ball-over-net games","Basketball family","Board sports","Climbing","Cycling","Combat sports: Wrestling and martial arts","Dance","Football","Ice sports","Running","Snow sports","Table sports");

		$data = (isset($id))?$arraylist[$id]:$arraylist;

		return $data;
	}
}