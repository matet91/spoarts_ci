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
}