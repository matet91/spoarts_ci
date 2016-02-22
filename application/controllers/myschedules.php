<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Myschedules extends CI_Controller {

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
		
		$this->load->model('mmyschedules');
	}

	public function index()
	{
		$content = 'myschedules.php';
		$type = $this->input->get('type');
		$title = "My Schedules";
		
		$data = array('header' => 'header.php',
					  'content' => 'content/'.$content,
					  'menu' => 'menu.php',
					  'footer' => 'footer.php',
					  'title' => $title);
		$this->load->view('index',$data);
	}
	
	function dataTables($switch){
		$data = $this->mmyschedules->dataTables($switch);
		echo json_encode($data);
	}
	
	//get all events
	function getCalendarSched(){
		$userid = $this->session->userdata('userid');
		
		$fields ="se.StudEnrolledID,s.stud_name,CONCAT(sc.SchedDays, '@',sc.SchedTime)as Schedule,(CASE WHEN sc.RoomID=0 THEN 'TBA'  ELSE CONCAT(r.RoomNo, '-',r.RoomName) END)as Room,(CASE WHEN sc.InstructorID=0 THEN 'TBA'  ELSE m.MasterInsName END) as Instructor,ser.ServiceName as Service,c.clinic_name as Clinic,sc.SchedDays,sc.SchedTime";
		$table = "students_enrolled se";
		$leftjoin = " LEFT JOIN students s ON s.stud_id = se.stud_id LEFT JOIN schedules sc ON sc.SchedID = se.SchedID LEFT JOIN rooms r ON r.RoomID = sc.RoomID LEFT JOIN instructor_masterlist m ON m.MasterInsID = sc.InstructorID LEFT JOIN services ser ON ser.ServiceID = se.service_id LEFT JOIN clinics c ON c.clinic_id = se.clinic_id";
		$where = "WHERE se.client_id = ".$userid." AND se.StudEnrolledStatus=1";
		$order = "";
	
		$data = $this->mmyschedules->getlist($table, $fields , $where, $order, $leftjoin);

		echo json_encode($data);
	}
}