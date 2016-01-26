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
		$pwd = $this->input->post('pwd');

        $sql = "SELECT * FROM user_accounts where UserName='$uname' and UserStatus=1";
        $q = $this->db->query($sql);

        if($q->num_rows() > 0){
        	$row = $q->row();
        	$password = $row->Password;
        	$password = $this->encrypt->decode($password);

        	if($password == $pwd){
        		$data=1; //correct password
        		//set session 
        		/**get full details of the user**/
        		//check user type
        		$usertype = $row->UserType;
        		$userid = $row->UserID;

        		$sql = "SELECT * FROM $table WHERE UserID='$userid'";
        		$q = $this->db->query($sql);
        		$rowx = $q->row();
        		$session = array('userid' => $userid,
        						 'username' => $row->UserName,
        						 'usertype' => $row->UserType,
        						 '');

        		$this->session->set_userdata($session);
        	}else{
        		$data = 2; //incorrect password
        	}
       	}else{
       		$data = 0; //account does not exist
       	}  
       	return $data;
     }

	
}