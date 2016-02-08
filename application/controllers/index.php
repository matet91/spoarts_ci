<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {

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
			$this->load->model('mservices');
			$this->load->model('mglobal');
	}
	public function index()
	{
		$userid = $this->session->userdata('userid');
  		$userType = $this->session->userdata('usertype');
  		$first_login = $this->session->userdata('first_login');

  		switch($first_login){
  			case 0: //firstlogin
  				$title = "Settings";
  				if($userType == 2)
  					$content = "content/firstlogin_client.php";
  				else
  					$content = "content/firstlogin_sp.php";
  				$menu = "";
  			break;

  			case 1: //old user
  					$title = "Home";
  					$content = "content/home.php";
  					$menu="menu.php";

  			break;
  		}
		$data = array('header'=>'header.php',
						'content'=>$content,
						'menu'=>$menu,
						'footer'=>'footer.php',
						'title'=>$title,
						'userid'=>$userid,
						'userType'=>$userType
					);


		$this->load->view('index.php',$data);
		
	}

	function loadProfile(){
		$data = $this->mservices->loadprofile();
		echo json_encode($data);
	}

	function loadSecurity(){
		$data = $this->mglobal->loadSecurity();
		echo json_encode($data);
	}

	function saveProfile(){
		$data = $this->mglobal->saveProfile();

		echo json_encode($data);
	}

	function uploadProfilePhoto(){
		$data = $this->mglobal->uploadProfilePhoto();
		echo $data;
	}

	function verifyPassword(){
		$data = $this->mglobal->verifyPassword();
		echo json_encode($data);
	}

	function saveSQSettings(){
		$data = $this->mglobal->saveSQSettings();
		echo json_decode($data);
	}

	function listInterest(){
		$data = $this->mglobal->listInterest();
		echo json_encode($data);
	}

	function saveInterest(){
		$data = $this->mglobal->saveInterest();
		echo json_encode($data);
	}
}
