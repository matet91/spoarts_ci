<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clinics extends CI_Controller {

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
		
		$this->load->model('mclinics');
	}

	public function index()
	{
		$content = 'clinics.php';
		$type = $this->input->get('type');
		$title = ($type == 1)?"Arts Clinic":"Sports Clinic";
		
		$data = array('header' => 'header.php',
					  'content' => 'content/'.$content,
					  'menu' => 'menu.php',
					  'footer' => 'footer.php',
					  'title' => $title);
		$this->load->view('index',$data);
	}

	function loadServices($c,$search=null){
		$data = $this->mclinics->loadServices($c,$search);
		echo json_encode($data);
	}
	function loadClinics($c,$search=null){
		$data = $this->mclinics->loadClinics($c,$search);
		echo json_encode($data);
	}

	function bookmark(){
		$data = $this->mclinics->bookmark();
		echo json_encode($data);
	}
	
	function getSchedule($serviceid){
		$table = "schedules";
		$fields = "SchedID, SchedDate, SchedTime";
		$where = "WHERE ServiceID = '".$serviceid."' AND SchedStatus = 1";
		$order = "";
		
		$data = $this->mclinics->getlist($table, $fields , $where, $order);
		echo json_encode($data);
	}
	
	function getService($c,$userid){
		$table = "services";
		$fields = "ServiceID, ServiceName";
		$where = "WHERE SPID = '".$userid."' AND ServiceType='".$c."' AND ServiceStatus = 1";
		$order = "";
		
		$data = $this->mclinics->getlist($table, $fields , $where, $order);
		echo json_encode($data);
	}
	
	function getexistStud($clinicid){
		$table = "students";
		$fields = "stud_id, stud_name, stud_age";
		$where = "WHERE client_id = '".$this->session->userdata('userid')."' AND stud_status = 1 AND clinic_id = $clinicid";
		$order = "";
		
		$data = $this->mclinics->getlist($table, $fields , $where, $order);
		echo json_encode($data);
	}
	
	function changeSchedule($schedid){
		$table = "schedules";
		$fields = "SchedID, (SELECT RoomName from rooms WHERE RoomID = RoomID) as Room , (SELECT MasterInsName from instructor_masterlist WHERE MasterInsID = InstructorID)as Instructor, SchedSlots, RoomID, InstructorID";
		$where = "WHERE SchedID = '".$schedid."' AND SchedStatus = 1";
		$order = "";
		
		$data = $this->mclinics->getlist($table, $fields , $where, $order);
		echo json_encode($data);
	}
	
	function saveEnroll(){
		$data = $this->mclinics->saveEnroll();
		echo json_encode($data);
	}
}