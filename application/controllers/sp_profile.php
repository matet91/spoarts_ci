<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sp_profile extends CI_Controller {

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
		
		$this->load->model('Mspprofile');
		$this->load->library('paypalcreditcard');
		$this->load->library('paypaldetails');
		$this->load->library('paypalfundinginstrument');
		$this->load->library('paypalitem');
		$this->load->library('paypalitemlist');
		$this->load->library('paypalpayment');
		$this->load->library('paypaltransaction');
		$this->load->library('paypalpayer');
		$this->load->library('paypalamount');
		$this->load->library('paypalredirecturls');
		
	}

	public function index()
	{
		if(!$this->session->userdata('userid')){
			header("Location:login");
		}
		$content = 'sp_profile.php';
		$profile = $this->Mspprofile->loadprofile();
		$title = ucfirst($profile->spfirstname)." ".ucfirst($profile->splastname);
		$clubpic = $profile->clinic_logo;
		$data = array('header' => 'header.php',
					  'content' => 'content/'.$content,
					  'menu' => 'menu.php',
					  'footer' => 'footer.php',
					  'title' => $title,
					  'clubpic'=>$clubpic,
					  'data'=>$profile);
		$this->load->view('index',$data);
	}

	function dataTables($case,$id=null){

		$data = $this->Mspprofile->dataTables($case,$id);
		echo json_encode($data);
	}

	function paypal($type){
		$data = $this->mservices->paypal($type);
		echo json_encode($data);
	}
}
