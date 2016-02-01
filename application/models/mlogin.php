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

        $sql = "SELECT * FROM user_accounts where UserName='$uname' and Password='$pwd' and UserStatus=1";
        $q = $this->db->query($sql);

        if($q->num_rows() > 0){
        	$row = $q->row();
    		$data=1; //correct password
    		//set session 
    		/**get full details of the user**/
    		//check user type
    		$usertype = $row->UserType;
    		$userid = $row->UserID;

    		$sql = "SELECT * FROM user_details a LEFT JOIN user_accounts b ON a.UserID=b.UserID LEFT JOIN security_questions c ON b.security_question_id = c.sec_id WHERE a.UserID='$userid'";
    		$q = $this->db->query($sql);
    		$rowx = $q->row();
    		$session = array('userid' => $userid,
    						 'username' => $row->UserName,
    						 'usertype' => $row->UserType,
                             'name'=>ucfirst($rowx->spfirstname)." ".ucfirst($rowx->splastname),
                            'splogoname'=>$rowx->splogoName,
                            'securityquestion'=>$rowx->sec_questions
    						 );
    		$this->session->set_userdata($session);

       	}else{
       		$data = 0; //account does not exist or incorrect passsword
       	}  
       	return $data;
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
}