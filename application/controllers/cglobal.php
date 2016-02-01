<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cglobal extends CI_Controller {

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
		
		$this->load->model('mglobal');
	}

	public function index()
	{
		$content = 'global.php';
		$data = array('header' => 'header.php',
					  'content' => 'content/'.$content,
					  'menu' => 'menu.php',
					  'footer' => 'footer.php',
					  'title' => 'Configuration');
		$this->load->view('index',$data);
	}	


	function addQuestion(){
		$data = $this->mglobal->addQuestion();
		echo json_encode($data);
	}

	function dropdown($case){
		switch($case){
			case 1:
					$userid = $this->session->userdata('userid');
					$table = "services";
					$where = " SPID = '$userid' AND ServiceStatus = 1";
			break;
		}

		$data = $this->mglobal->dropdown($table,$case,$where);

		echo json_encode($data);
	}
}