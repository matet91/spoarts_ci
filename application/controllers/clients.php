<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clients extends CI_Controller {

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
		$this->load->helper('date');
		$this->load->model('mclients');
		
	}

	public function index()
	{
		if(!$this->session->userdata('userid')){
			header("Location:login");
		}
		$content = 'clients.php';
		$title = "Clients";
		
		$data = array('header' => 'header.php',
					  'content' => 'content/'.$content,
					  'menu' => 'menu.php',
					  'footer' => 'footer.php',
					  'title' => $title);
		$this->load->view('index',$data);
	}

	function dataTables($c,$id=null){
		$data = $this->mclients->dataTables($c,$id);
		echo json_encode($data);
	}

	function checkStatus($id){
		$data = $this->mclients->checkStatus($id);
		echo json_encode($data);
	}

	function in_out($id,$schedid,$studid,$clinicid,$serviceid){
		$data = $this->mclients->in_out($id,$schedid,$studid,$clinicid,$serviceid);
		echo json_encode($data);
	}

	function clientPayment(){
		$data = $this->mclients->clientPayment();
		echo json_encode($data);
	}

	function getPaymentDetails($id){
		$data = $this->mclients->getPaymentDetails($id);
		echo json_encode($data);
	}

	function updateBalance($paymentid){
		$data = $this->mclients->updateBalance($paymentid);
		echo json_encode($data);
	}

	function approve($id,$schedid){
		$data = $this->mclients->approve($id,$schedid);
		echo json_encode($data);
	}

	function countPendings(){
		$data = $this->mclients->countPendings();
		echo json_encode($data);
	}
	function removePending($id){
		$data = $this->mclients->removePending($id);
		echo json_encode($data);
	}
}
