<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cglobal extends CI_Controller {

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
		
		$this->load->model('mglobal');
		$this->load->model('mmyevents');
		$this->load->model('mclinics');
	}

	public function index()
	{
		$content = 'global.php';
		$data = array('header' => 'header.php',
					  'content' => 'content/'.$content,
					  'menu' => 'menu.php',
					  'footer' => 'footer.php',
					  'title' => 'Configuration');
		$this->load->view('index',$data);
	}	


	function addQuestion(){
		$data = $this->mglobal->addQuestion();
		echo json_encode($data);
	}

	function dropdown($case){
		switch($case){
			case 1:
					$userid = $this->session->userdata('userid');
					$table = "services";
					$where = " SPID = '$userid' AND ServiceStatus = 1";
			break;
		}

		$data = $this->mglobal->dropdown($table,$case,$where);

		echo json_encode($data);
	}

	function addInterest(){
		$data = $this->mglobal->addInterest();
		echo json_encode($data);
	}

	function loadInterest($t){
		$data = $this->mglobal->loadInterest($t);
		echo json_encode($data);
	}
	
	function loadClinics(){
		$userid = $this->session->userdata('userid');
		$interest_ids = $this->mmyevents->getlistid("client_interest","interest_ids","WHERE client_id= $userid","","");
		
		$data = $this->mglobal->loadClinics($interest_ids);
		echo json_encode($data);
	}
	
	function getService($userid){
		$table = "services";
		$fields = "ServiceID, ServiceName";
		$where = "WHERE SPID = '".$userid."' AND ServiceStatus = 1";
		$order = "";
		$leftjoin = "";
		$data = $this->mclinics->getlist($table, $fields , $where, $order,$leftjoin);
		echo json_encode($data);
	}
	
	function saveNotification(){
		$data = $this->mglobal->saveNotification();
		echo json_encode($data);
	}
	
	function countNotification(){
		$data = $this->mglobal->countNotification();
		echo json_encode($data);
	}
	
	function loadEventPromo(){
		$data = $this->mglobal->loadEventPromo();
		echo json_encode($data);
	}
	function loadAllClinic(){
		$data = $this->mglobal->loadAllClinic();
		echo json_encode($data);
	}
	function readNotification(){
		$data = $this->mglobal->readNotification();
		echo json_encode($data);
	}
	
	function getInterests(){
		$data = $this->mglobal->getInterests();
		echo json_encode($data);
	}
}