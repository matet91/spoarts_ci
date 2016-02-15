<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct(){
			parent::__construct();
			$this->load->library('session');
			$this->load->library('encrypt');
			$this->load->library('mailer');
			$this->load->model('mlogin');
			$this->load->model('mglobal');
			

	}
	public function index()
	{
		
		$data = array('header'=>'header.php',
						'content'=>'content/login.php',
						'menu'=>'menu.php',
						'footer'=>'footer.php',
						'title'=>'Welcome'
					);
		
		$this->load->view('index.php',$data);
	}
	
	function authenticate(){
	
		$data = $this->mlogin->authenticate();
		echo json_encode($data);
	}
	function updatepwd(){
		$pwd = md5("1234");
		$this->db->query("update user_accounts set Password='$pwd'");
	}

	function logout(){
		$this->session->sess_destroy();
	}
	function checkusername(){
		$data = $this->mlogin->checkusername();
		echo json_encode($data);
	}

	function checkEmail(){
		$data = $this->mlogin->checkEmail();
		echo json_encode($data);
	}

	function saveRegister(){
		$data = $this->mlogin->saveRegister();
		echo json_encode($data);
	}

	function listings($c,$id){
		$data = $this->mglobal->listings($c, $id);
		echo json_encode($data);
	}

	function changepassword(){
		$data = $this->mlogin->changepassword();
		echo json_encode($data);
	}

	function testimonials(){
		$data = $this->mglobal->testimonials();
		echo json_encode($data);
	}
}
