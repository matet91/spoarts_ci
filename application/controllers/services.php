<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Services extends CI_Controller {

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
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	 
	public function __construct(){
		parent::__construct();
		
		$this->load->model('mservices');
		$this->load->library('paypalcreditcard');
		$this->load->library('paypaldetails');
		$this->load->library('paypalfundinginstrument');
		$this->load->library('paypalitem');
		$this->load->library('paypalitemlist');
		$this->load->library('paypalpayment');
		$this->load->library('paypaltransaction');
		$this->load->library('paypalpayer');
		$this->load->library('paypalamount');
		$this->load->library('paypalredirecturls');
		
	}

	public function index()
	{
		if(!$this->session->userdata('userid')){
			header("Location:login");
		}
		$content = 'services.php';
		$title = "Services";
		
		$profile = $this->mservices->loadprofile();
		$clubpic = $profile->clinic_logo;
		$data = array('header' => 'header.php',
					  'content' => 'content/'.$content,
					  'menu' => 'menu.php',
					  'footer' => 'footer.php',
					  'title' => $title,
					  'clubpic'=>$clubpic,
					  'data'=>$profile);
		$this->load->view('index',$data);
	}
	function addServices(){
		$data = $this->mservices->addServices();
		echo json_encode($data);
	}

	function uploadClubPic(){
		$data = $this->mservices->uploadClubPic();
		echo $data;
	}

	function checkSecurityPwd(){
		$data = $this->mservices->checkSecurityPwd();
		echo json_encode($data);
	}

	function saveClinicInfo(){
		$data = $this->mservices->saveClinicInfo();
		echo json_encode($data);
	}
	function dataTables($case,$serviceid=null){
		$data = $this->mservices->dataTables($case,$serviceid);

		echo json_encode($data);
	}

	function addInstructor(){
		$data = $this->mservices->addInstructor();
		echo json_encode($data);
	}

	function getData(){
		$data = $this->mservices->getData();
		echo json_encode($data);
	}

	function updateServices($id){
		$data = $this->mservices->UpdateData($id,1);
		echo json_encode($data);
	}

	function removeData($id,$type){
		$data = $this->mservices->removeData($id,$type);
		echo json_encode($data);
	}

	function updateInstructor($id){
		$data = $this->mservices->UpdateData($id,2);
		echo json_encode($data);
	}

	function addSchedule(){
		$data = $this->mservices->addSchedule();
		echo json_encode($data);
	}

	function addRoom(){
		$data = $this->mservices->addRoom();
		echo json_encode($data);
	}

	function paypal($type){
		$data = $this->mservices->paypal($type);
		echo json_encode($data);
	}
}
