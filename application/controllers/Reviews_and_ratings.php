<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reviews_and_ratings extends CI_Controller {

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
		$this->load->model('mservices');
	}

	public function index()
	{
		$content = 'reviews_and_ratings.php';
		$title = "Reviews and ratings";
		
		$profile = $this->mservices->loadprofile();
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
	function addServices(){
		$data = $this->mservices->addServices();
		echo json_encode($data);
	}
	
	//get all list
	function getlist($switch){
		$spid = $this->session->userdata('userid');
		//$spid = $this->mreviews_and_ratings->getspid();
		
		if($switch == 4){ //get reviews for home
			$where = "WHERE ReviewStatus = 2";	
		}else{
			$where = "WHERE SPID = '".$spid."' AND ReviewStatus= '".$switch."'";
		}
		$table = "reviews_and_ratings";
		$fields = "ReviewsID, DatePosted, Message, Rating, (SELECT UserName FROM user_accounts WHERE UserID=SPID) as SPname,(SELECT CONCAT(spfirstname,' ',splastname) FROM user_details WHERE UserID=EnrolledID) as EnrolledName , ReviewStatus";
		$order = "";
		$data = $this->mreviews_and_ratings->getlist($table,$fields,$where,$order);
		echo json_encode($data);
	}
	
	function saveReviewRatings(){
		$data = $this->mreviews_and_ratings->saveReviewRatings();
		echo json_encode($data);
	}
}
