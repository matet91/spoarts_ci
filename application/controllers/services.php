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
		$this->load->libraries('paypal');
	}

	public function index()
	{
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
}
