<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Landingpage extends CI_Controller {

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
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct(){
			parent::__construct();
			$this->load->library('session');
			$this->load->library('encrypt');
			$this->load->model('mlogin');
	}

	function index(){
		$type = $this->input->get('type');
		if($type == 1){
			$title = "Registration Completed";
			$data = "";
		}else if($type==3){
			$title = "Forgot Password";
			$data = $this->mlogin->verify();
		}else{
			$title = "Account Verification Status";
			$data = $this->mlogin->verify();
		}
		$data = array('header'=>'header.php',
						'content'=>'content/landingpage.php',
						'menu'=>'',
						'footer'=>'',
						'title'=>$title,
						'data'=>$data
					);
		
		$this->load->view('index.php',$data);
	}

}