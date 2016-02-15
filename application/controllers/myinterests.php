<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Myinterests extends CI_Controller {

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
		$this->load->model('mmyinterests');
	}

	public function index()
	{
		$content = 'myinterests.php';
		$type = $this->input->get('type');
		$title = "My Interests";
		
		$data = array('header' => 'header.php',
					  'content' => 'content/'.$content,
					  'menu' => 'menu.php',
					  'footer' => 'footer.php',
					  'title' => $title);
		$this->load->view('index',$data);
	}
	
	function dataTables($switch){
		$data = $this->mmyinterests->dataTables($switch);
		echo json_encode($data);
	}

	//get all interest for dropdown in event
	function getselInterest($type){
		$userid = $this->session->userdata('userid');
		//list of interest that is added on his list
		$interestids = $this->mmyinterests->getID("client_interest", "interest_ids" , "WHERE client_id = '".$userid."'");
		
		$table = "interest";
		$fields = "interest_id, interest_name";
		$where = "WHERE interest_type = '".$type."' AND interest_id NOT IN(".$interestids.")";
		$order = "";

		$data = $this->mreviews_and_ratings->getlist($table,$fields,$where,$order);
		echo json_encode($data);
	}
	
	function saveInterest(){
		$data = $this->mmyinterests->saveInterest();
		echo json_encode($data);
	}
	
	function deleteInterest(){
		$data = $this->mmyinterests->deleteInterest();
		echo json_encode($data);
	}
}