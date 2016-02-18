<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subscribers extends CI_Controller {

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
		
		$this->load->model('msubscribers');
	}
	public function index()
	{
		
		$content = 'subscribers.php';
		$title = "Subscribers";

		$data = array('header' => 'header.php',
					  'content' => 'content/'.$content,
					  'menu' => 'menu.php',
					  'footer' => 'footer.php',
					  'title' => $title);
		$this->load->view('index',$data);
	}
	
	function dataTables($switch){
		$data = $this->msubscribers->dataTables($switch);
		echo json_encode($data);
	}
	
	function addservice(){
		$data = $this->msubscribers->addservice();
		return $data;
	}
	function listall(){
		$data = $this->msubscribers->listall();
		echo json_encode($data);
	}

	function deactivateAccount($id,$t){
		$data = $this->msubscribers->deactivateAccount($id,$t);
		echo  json_encode($data);
	}

	function deleteAccount($id){
		$data = $this->msubscribers->deleteAccount($id);
		echo json_encode($data);
	}

	function savePlan(){
		$data = $this->msubscribers->savePlan();
		echo json_encode($data);
	}

	function removeItem($id){
		$data = $this->msubscribers->removeItem($id);
		echo json_encode($data);
	}

	function getPlanRow($id){
		$data = $this->msubscribers->getPlanRow($id);
		echo json_encode($data);
	}

	function updatePlan($id){
		$data = $this->msubscribers->updatePlan($id);
		echo json_encode($data);
	}
}
