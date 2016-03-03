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
		$fields = "SchedID, SchedDays, SchedTime";
		//$where = "WHERE ServiceID = '".$serviceid."' AND SchedStatus = 1";
		$where = "WHERE ServiceID = '".$serviceid."'";
		$order = "";
		$leftjoin = "";
		$data = $this->mclinics->getlist($table, $fields , $where, $order,$leftjoin);
		echo json_encode($data);
	}
	
	//get Instructor Sched
	function getInstructorSched($istructorid){
		$table = "schedules sc";
		$fields = "sc.SchedID, sc.SchedDays,sc.SchedTime, se.ServiceName, (schedremaining=schedslots) as ch_sched, se.SPID, sc.ServiceID,CONCAT(r.RoomNo,'-',r.RoomName)as Room  ";
		$where = "WHERE sc.InstructorID = '".$istructorid."'";
		$leftjoin = "LEFT JOIN services se ON se.ServiceID = sc.ServiceId LEFT JOIN rooms r ON r.RoomID = sc.RoomID";
		$order = "";

		$data = $this->mclinics->getlist($table,$fields,$where,$order,$leftjoin);
		echo json_encode($data);
	}
	
	function getService($c,$userid){
		$table = "services";
		$fields = "ServiceID, ServiceName";
		$where = "WHERE SPID = '".$userid."' AND ServiceType='".$c."' AND ServiceStatus = 1";
		$order = "";
		$leftjoin = "";
		$data = $this->mclinics->getlist($table, $fields , $where, $order,$leftjoin);
		echo json_encode($data);
	}
	
	function getexistStud(){
		$table = "students";
		$fields = "stud_id, stud_name, stud_age";
		$where = "WHERE client_id = '".$this->session->userdata('userid')."'";
		$order = "";
		$leftjoin = "";
		$data = $this->mclinics->getlist($table, $fields , $where, $order,$leftjoin);
		echo json_encode($data);
	}
	
	function changeSchedule($schedid){
		$table = "schedules s";
		$fields = "s.SchedID, CONCAT(r.RoomNo, ' ' ,r.RoomName) as Room , (m.MasterInsName) as Instructor, (CASE WHEN s.SchedSlots > s.SchedRemaining THEN s.SchedSlots-s.SchedRemaining ELSE 0 END) as SchedSlots, s.RoomID, s.InstructorID";
		//$where = "WHERE SchedID = '".$schedid."' AND SchedStatus = 1";
		$leftjoin = "LEFT JOIN rooms r ON r.RoomID = s.RoomID LEFT JOIN instructor_masterlist m ON m.MasterInsID = s.InstructorID";
		$where = "WHERE SchedID = '".$schedid."'";
		$order = "";
		
		$data = $this->mclinics->getlist($table, $fields , $where, $order,$leftjoin);
		echo json_encode($data);
	}
	
	function saveEnroll(){
		$data = $this->mclinics->saveEnroll();
		echo json_encode($data);
	}
	
	function getRelationship(){
		$table = "relationship_status";
		$fields = "relationship_id,relationship_name";
		$leftjoin = "";
		$where = "";
		$order = "";
		$data = $this->mclinics->getlist($table, $fields , $where, $order,$leftjoin);
		echo json_encode($data);
	}
	function getReviewsRatings($id,$limit){
		
		$table = "reviews_and_ratings r";
		$fields = "r.ReviewsID, r.Message , r.DatePosted, r.Rating, CONCAT(u.spfirstname,' ',u.splastname) as Cname";
		$leftjoin = "LEFT JOIN user_details u ON u.UserID = r.SPID";
		$where = "WHERE r.ReviewStatus=2 AND r.clinic_id = ".$id."";
		$order = "";
		if($limit == 0 ){
			$order = "LIMIT 2";
		}
		
		
		$data = $this->mclinics->getlist($table, $fields , $where, $order,$leftjoin);

		echo json_encode($data);
	}
	
	function dataTables($switch,$id){
		$data = $this->mclinics->dataTables($switch,$id);
		echo json_encode($data);
	}
	
	function SaveRating(){
		$data = $this->mclinics->SaveRating();
		echo json_encode($data);
	}
}