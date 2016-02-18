<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manageaccounts extends CI_Controller {

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
		
		$this->load->model('mmanageaccounts');
	}
	public function index()
	{
		
		$content = 'manageaccounts.php';
		$title = "Client Management";

		$data = array('header' => 'header.php',
					  'content' => 'content/'.$content,
					  'menu' => 'menu.php',
					  'footer' => 'footer.php',
					  'title' => $title);
		$this->load->view('index',$data);
	}
	
	function dataTables($switch){
		$data = $this->mmanageaccounts->dataTables($switch);
		echo json_encode($data);
	}
	function deactivateAccount($id,$t){
		$data = $this->mmanageaccounts->deactivateAccount($id,$t);
		echo  json_encode($data);
	}

	function deleteAccount($id){
		$data = $this->mmanageaccounts->deleteAccount($id);
		echo json_encode($data);
	}
}
