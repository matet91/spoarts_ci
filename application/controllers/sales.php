<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales extends CI_Controller {

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
		
		$this->load->model('msales');
		$this->load->model('mclinics');
	}

	public function index()
	{
		$content = 'sales.php';
		$type = $this->input->get('type');
		$title = "Sales";
		
		$data = array('header' => 'header.php',
					  'content' => 'content/'.$content,
					  'menu' => 'menu.php',
					  'footer' => 'footer.php',
					  'title' => $title);
		$this->load->view('index',$data);
	}
	
	function dataTables($switch,$reptype,$repdate,$serviceid,$scheduleid){
		$data = $this->msales->dataTables($switch,$reptype,$repdate,$serviceid,$scheduleid);
		echo json_encode($data);
	}
	
	function getService(){
		
		$table = "services";
		$fields = "ServiceID,ServiceName";
		$leftjoin = "";
		$where = "WHERE SPID = ".$this->session->userdata('userid')."";
		$order = "";
		$data = $this->mclinics->getlist($table, $fields , $where, $order,$leftjoin);

		echo json_encode($data);
	}
	
	function getSchedule($serviceid){
		
		$table = "schedules";
		$fields = "SchedID,CONCAT(SchedDays,'@',SchedTime)as Sched";
		$leftjoin = "";
		$where = "WHERE ServiceID = ".$serviceid."";
		$order = "";
		$data = $this->mclinics->getlist($table, $fields , $where, $order,$leftjoin);

		echo json_encode($data);
	}
	
	
}