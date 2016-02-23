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
		$sql="SELECT a.interest_id, a.interest_name FROM services b LEFT JOIN interest a ON a.interest_id=b.interest_id WHERE b.ServiceStatus=1 GROUP BY b.interest_id";
		$get = $this->db->query($sql);
		return $get->result();
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

	function resetpassword(){
		$email = $this->input->post('email');
		$sql = "SELECT a.UserID,b.spfirstname,b.splastname FROM user_accounts a LEFT JOIN WHERE UserName = '$email'";
		$q = $this->db->query($sql);

		if($q->num_rows() > 0){
			//email here
			$rowx = $q->row();
			$userid = $rowx->UserID;
			$fname = $rowx->spfirstname;
	        $to = $email;
	        $subject = "[Do not reply] Spoarts: Reset Password";
	        $message = "<span style='color:#3BACAD'>Hi ".$fname."!</span><br/>
	                    <p style='color:#0298D3;'> To change your password, click <a href='http://localhost/spoarts_ci/landingpage?type=3&id=".$UserID."' target='_blank'>HERE</a> to continue your request. If you do not wish to change your password,just ignore this message. </b><br/><br/><span style='color:#3BACAD'>Best Regards</span>,<br/>
	                    <h3 style='color:#0298D3'>Spoarts Team</h3></p>";
	        $mail = new Mailer();
	       // $mail->SMTPDebug = 3;
	        $mail->isSMTP(); // Set mailer to use SMTP
	        $mail->Host = 'smtp.gmail.com';// Specify main and backup SMTP servers
	        $mail->SMTPAuth = true; // Enable SMTP authentication
	        $mail->Username = 'spoarts.cebu@gmail.com';// SMTP username
	        $mail->Password = 'sp0@rt$2016';// SMTP password
	        $mail->SMTPSecure = 'tls';// Enable TLS encryption, `ssl` also accepted
	        $mail->Port = 587;// TCP port to connect to
	        $mail->addAddress($to);// Add a recipien
	        $mail->isHTML(true);// Set email format to HTML
	        $mail->setFrom('spoarts.cebu@gmail.com', 'Spoarts');
	        $mail->Subject = $subject;
	        $mail->Body    = $message;

	        if(!$mail->send()) {

	            //echo $mail->ErrorInfo;
	            return 0; exit(); //not send
	        }else{
	        	return 1;exit();//sent
	        }
	    }else return 2;//email not exist
	}
}