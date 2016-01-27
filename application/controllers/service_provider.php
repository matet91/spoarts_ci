<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service_provider extends CI_Controller {

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
		$dbconnect = $this->load->database();
		$this->load->library('session');
		
		$this->load->model('Mservice_provider');
	}
	public function index()
	{
		
		if($this->session->userdata('usertype')==0 ){
			$content = 'service_provider.php';
			$title = "Service Provider";
		}else{
			$content = 'services.php';
			$title = "Services";
		}
		$data = array('header' => 'header.php',
					  'content' => 'content/'.$content,
					  'menu' => 'menu.php',
					  'footer' => 'footer.php',
					  'title' => $title);
		$this->load->view('index',$data);
	}
	
	function dataTables($switch){
		$data = $this->Mservice_provider->dataTables($switch);
		echo json_encode($data);
	}
	
	function addservice(){
		$data = $this->Mservice_provider->addservice();
		return $data;
	}
	function listall(){
		$data = $this->Mservice_provider->listall();
		echo json_encode($data);
	}
}
