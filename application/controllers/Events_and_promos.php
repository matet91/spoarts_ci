<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Events_and_promos extends CI_Controller {

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
		
		$this->load->model('mevents_and_promos');
		$this->load->model('mreviews_and_ratings');
		$this->load->model('mservices');
	}

	public function index()
	{
		$content = 'events_and_promos.php';
		$title = "Events and Promos";
		
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
	
	function addEvents(){
		$data = $this->mevents_and_promos->addEvents();
		echo json_encode($data);
	}
	
	function addPromos(){
		$data = $this->mevents_and_promos->addPromos();
		echo json_encode($data);
	}
	
	function updatePromos(){
		$data = $this->mevents_and_promos->updatePromos();
		echo json_encode($data);
	}
	
	function removePromos(){
		$data = $this->mevents_and_promos->removePromos();
		echo json_encode($data);
	}
	
	function updateEvents(){
		$data = $this->mevents_and_promos->updateEvents();
		echo json_encode($data);
	}
	
	function removeEvents(){
		$data = $this->mevents_and_promos->removeEvents();
		echo json_encode($data);
	}
	
	//get an event
	function getAnEvent($id){
		$spid = $this->session->userdata('userid');
		//$spid = $this->mevents_and_promos->getspid();

		$table = "events";
		$fields = "EventID, EventName, EventDesc, EventFor, EventStartDate, EventEndDate,EventLocation";
		$where = "WHERE SPID = '".$spid."' AND EventStatus = 1 AND EventID='".$id."'";
		$order = "";

		$data = $this->mreviews_and_ratings->getlist($table,$fields,$where,$order);
		echo json_encode($data);
	}
	
	//get all events
	function getEvents($spid=null){
		if(!isset($spid))
			$spid = $this->session->userdata('userid');
		
		//$spid = $this->mevents_and_promos->getspid();

		$table = "events";
		$fields = "EventID, EventName, EventDesc, EventFor, EventStartDate, EventEndDate,EventLocation";
		$where = "WHERE SPID = '".$spid."' AND EventStatus = 1";
		$order = "";

		$data = $this->mreviews_and_ratings->getlist($table,$fields,$where,$order);
		echo json_encode($data);
	}
	
	//get all promos
	function getPromos(){
		$spid = $this->session->userdata('userid');
		//$spid = $this->mevents_and_promos->getspid();

		$table = "promos";
		$fields = "PromoID, PromoName, PromoDesc, PromoStartDate, PromoEndDate, (SELECT UserName FROM user_accounts WHERE UserID=SPID) as SPname";
		$where = "WHERE SPID = '".$spid."' AND PromoStatus = 1";
		$order = "";

		$data = $this->mreviews_and_ratings->getlist($table,$fields,$where,$order);
		echo json_encode($data);
	}
	
	//get all service for dropdown in event
	function getService(){
		$spid = $this->session->userdata('userid');
		//$spid = $this->mevents_and_promos->getspid();

		$table = "services";
		$fields = "ServiceID, ServiceName";
		$where = "WHERE SPID = '".$spid."' AND ServiceStatus = 1";
		$order = "";

		$data = $this->mreviews_and_ratings->getlist($table,$fields,$where,$order);
		echo json_encode($data);
	}
	
	function saveReviewRatings(){
		$data = $this->mreviews_and_ratings->saveReviewRatings();
		echo json_encode($data);
	}
}
