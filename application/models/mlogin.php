<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mlogin extends CI_Model {
	public function __construct()
	{
			// Call the CI_Model constructor
			parent::__construct();
            
	}
		
	function authenticate(){
		$uname = $this->input->post('uname');
		$pwd = md5($this->input->post('pwd'));

        $sql = "SELECT * FROM user_accounts where UserName='$uname'";
        $q = $this->db->query($sql);

        if($q->num_rows() > 0){
        	$row = $q->row();
            $password =  $row->Password;
            //check user status
            if($password != $pwd){ return 4; exit(); }//incorrect password

            if($row->UserStatus == 0){ return 2; exit();//unverified
            }else if($row->UserStatus == 2) {return 3; exit(); //inactive
            }else{
        		
        		//set session 
        		/**get full details of the user**/
        		//check user type
        		$usertype = $row->UserType;
        		$userid = $row->UserID;
                switch($usertype){
                    case 1: //service provide
                            $sql = "SELECT * FROM user_details a LEFT JOIN user_accounts b ON a.UserID=b.UserID LEFT JOIN subscriptions d ON d.UserID=a.UserID WHERE a.UserID='$userid'";
                    break;

                    case 2: //client
                            $sql = "SELECT * FROM user_details a LEFT JOIN user_accounts b ON a.UserID=b.UserID WHERE a.UserID='$userid'";
                    break;

                    case 0://admin
                            $sql = "SELECT * FROM user_details a LEFT JOIN user_accounts b ON a.UserID=b.UserID WHERE a.UserID='$userid'";
                    break;
                }
        		
        		$q = $this->db->query($sql);
        		$rowx = $q->row();
                switch($usertype){
                    case 0: //admin
                            $session = array('userid' => $userid,
                                 'username' => $row->UserName,
                                 'usertype' => $row->UserType,
                                 'name'=>ucfirst($rowx->spfirstname)." ".ucfirst($rowx->splastname),
                                'splogoname'=>$rowx->splogoName,
                                'first_login'=>$rowx->first_login
                                 );
                    break;

                    case 1: //service provider
                                $session = array('userid' => $userid,
                                 'username' => $row->UserName,
                                 'usertype' => $row->UserType,
                                 'name'=>ucfirst($rowx->spfirstname)." ".ucfirst($rowx->splastname),
                                'splogoname'=>$rowx->splogoName,
                                'first_login'=>$rowx->first_login,
                                'SubsStatus'=>$rowx->SubsStatus
                                 );
                    break;

                    case 2://client
                                $session = array('userid' => $userid,
                                 'username' => $row->UserName,
                                 'usertype' => $row->UserType,
                                 'name'=>($rowx->spfirstname!=NULL)?ucfirst($rowx->spfirstname):'First Name not set'." ".($rowx->splastname!=NULL)?ucfirst($rowx->splastname):'Last Name not set',
                                'splogoname'=>$rowx->splogoName,
                                'first_login'=>$rowx->first_login
                                 );
                    break;
                }
        		
        		$this->session->set_userdata($session);
                return array(1, $row->UserType); exit(); //correct password
            }

       	}else{
       		return 0; exit();//account does not exist or incorrect passsword
       	}  
     }

	function checkusername(){
		$uname = $this->input->post('uname');
		$sql = "SELECT * FROM user_accounts WHERE UserName = '$uname'";
		$q = $this->db->query($sql);

		if($q->num_rows() > 0){
			$data  = 1;
		}else{
			$data = 0;
		}

		return $data;
	}

    function checkEmail(){
        $email = $this->input->post('email');
        $this->db->where('SPEmail',$email);
        $this->db->select('*');
        $q = $this->db->get('user_details');
        $data = ($q->num_rows() > 0) ? 1:0;
        return $data;
    }

    function saveRegister(){
        $data = $this->input->post('data');
        $useraccount = array('UserName','Password','UserType');

        $userdetails = array('spfirstname','splastname','spbirthday','SPContactNo','SPEmail','SPAddress','latitude','longitude');

        foreach($useraccount as $val){
            if($val == 'Password') $UAData[$val] = md5($data[$val]);

            else $UAData[$val]=$data[$val]; //get data for user_accounts table
        }
        $UAData['verification_code'] = rand(1,strtotime(date('Y-m-d h:i:s')));
        foreach($userdetails as $val){
            if($val == 'spbirthday') $UDData[$val] = date('Y-m-d', strtotime($data[$val]));

            else $UDData[$val] = $data[$val]; //get the data for user_details table
        }

        //VERIFY FOR DUPLICATE
            // $where = array(
            //         'SPEmail'=>$data['SPEmail'],
            //         'spfirstname'=>$data['spfirstname'],
            //         "splastname"=>$data['splastname']);
            // $this->db->where($where);
            // $this->db->select('*');
            // $emailchk = $this->db->get("user_details");
            // if($emailchk->num_rows() > 0){
            //     return 4; exit();
            // }
        //END DUPLICATE VERIFICATION

        //verify expiry settings
        $today = date('Y-m-d h:i:s');
        $datetime = new DateTime($today);
        $datetime->add(new DateInterval('P1D'));
        $UAData['verify_expiry'] = $datetime->format('Y-m-d H:i:s');
        //insert to user_accounts and get the userid
        $d = $this->db->insert('user_accounts',$UAData);
        if($d == true) {
            $UserID = $this->db->insert_id();
            //add userid to $UAData
            $UDData['UserID'] = $UserID;

            //INSERT DATA TO USER_DETAILS AND SUBSCRIPTIONS TABLE

            $ua = $this->db->insert('user_details',$UDData);
            if($ua == false) {
                $this->db->where('UserID',$UserID);
                $this->db->delete('user_accounts');
                return false; exit();
            }
            if($data['UserType'] == 1){
                $subscription = array('SubscType'=>$data['SubscType'],'SubscStartDate'=>date('Y-m-d'));

                //get the plan term
                $this->db->where("PlanID",$data['SubscType']);
                $this->db->select("*");
                $get = $this->db->get("subscription_plans");
                $splan = $get->row();
                $sterm = $splan->PlanTerm;
                
                $termdate = new DateTime($today);
                $termdate->add(new DateInterval('P'.$sterm));
                $subscription['SubscEndDate'] = $termdate->format('Y-m-d');

                 //ADD UserID to $subscription
                 $subscription['UserID'] = $UserID;
                 $subs = $this->db->insert('subscriptions',$subscription);
                if($subs == false){
                    $this->db->where('UserID',$UserID);
                    $this->db->delete('user_accounts');

                    $this->db->where('UserID',$UserID);
                    $this->db->delete('user_details');
                    return false; exit();
                }
            }
            
            
            //email here
            $to = $data['SPEmail'];
            $subject = "[Do not reply] Spoarts: Account Verification";
            $message = "<span style='color:#3BACAD'>Hi ".$data['spfirstname']."!</span><br/>
                        <p style='color:#0298D3;'>Congratulations. You are now a member of Spoarts.To verify your account click <a href='http://localhost/spoarts_ci/landingpage?type=2&code=".$UAData['verification_code']."&id=".$UserID."' target='_blank'>HERE</a>. For mobile user, please use this <b>CODE : ".$UAData['verification_code']."</b><br/><br/><span style='color:#3BACAD'>Best Regards</span>,<br/>
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
                return false; exit();
            }
            //echo $this->email->print_debugger();
            return $d;
        }else {return false; exit();};
    }

    function verify(){
        $userid = $this->input->get('id');
        $code = $this->input->get('code');

        $where = array(
                        'UserID'=>$userid,
                        'verification_code'=>$code
                    );
        //check if already verified
        $this->db->where($where);
        $this->db->select('*');
        $get = $this->db->get('user_accounts');
        if($get->num_rows() > 0){
            $row = $get->row();
            $UserStatus = $row->UserStatus;
            $vDate = strtotime($row->verify_expiry);
            if($vDate < strtotime(date('Y-m-d h:i:s')) && $UserStatus != 1){
                return 6; //verification code has expired
            }else{
                if($UserStatus == 1){
                    return 1;//"Your account is already verified and actived."
                    exit();
                }else if($UserStatus==2){
                    return 2;//"Your account is not active. Please send email request for activation to spoarts.cebu@gmail.com."
                    exit();
                }else{
                    $this->db->where($where);
                    $q = $this->db->update('user_accounts',array('UserStatus'=>1));
                    if($q == true){
                        return 3;//Your account has been verified successfully
                        exit();
                    }else{
                        return 4;//can't verify at this time please try again later
                    }
                }
            }
        }else{
            return 5; //account not found
            exit();
        }

    }

    function changepassword($id=null){
        $pwd = md5($this->input->post('pwd'));
        $userid = ($id)?$id:$this->session->userdata('userid');
        $this->db->where('UserID',$userid);
        $q = $this->db->update('user_accounts',array('Password'=>$pwd));

        return $q;
    }   
}
