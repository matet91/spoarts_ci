<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {

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
			//$this->load->model('mglobal');
	}
	public function index()
	{
		$userid = $this->session->userdata('userid');
  		$userType = $this->session->userdata('usertype');
		$data = array('header'=>'header.php',
						'content'=>'content/home.php',
						'menu'=>'menu.php',
						'footer'=>'footer.php',
						'title'=>'Home',
						'userid'=>$userid,
						'userType'=>$userType
					);


		$this->load->view('index.php',$data);
		
	}
}
