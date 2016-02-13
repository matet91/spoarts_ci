<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Myevents extends CI_Controller {

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
		
		$this->load->model('mreviews_and_ratings');
		$this->load->model('mmyevents');
	}

	public function index()
	{
		$content = 'myevents.php';
		$type = $this->input->get('type');
		$title = "My Events";
		
		$data = array('header' => 'header.php',
					  'content' => 'content/'.$content,
					  'menu' => 'menu.php',
					  'footer' => 'footer.php',
					  'title' => $title);
		$this->load->view('index',$data);
	}
	
	//get all events
	function getEvents(){
		$userid = $this->session->userdata('userid');
		//$spid = $this->mevents_and_promos->getspid();
		
		$service_ids = $this->mmyevents->getlistid("students s","service_id","WHERE s.stud_type=0 AND s.client_id= $userid","","LEFT JOIN students_enrolled se ON se.stud_id = s.stud_id");
		
		$table = "events";
		$fields = "EventID, EventName, EventDesc, EventFor, EventStartDate, EventEndDate,EventLocation";
		$where = "WHERE EventFor in(".implode(",",$service_ids).") AND EventStatus = 1";
		$order = "";

		$data = $this->mreviews_and_ratings->getlist($table,$fields,$where,$order);
		echo json_encode($data);
	}
}