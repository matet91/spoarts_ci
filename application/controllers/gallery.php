<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery extends CI_Controller {

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
		
		$this->load->model('mgallery');
	}
	public function index()
	{
		
		$content = 'gallery.php';
		$title = "Gallery";

		$data = array('header' => 'header.php',
					  'content' => 'content/'.$content,
					  'menu' => 'menu.php',
					  'footer' => 'footer.php',
					  'title' => $title);
		$this->load->view('index',$data);
	}
	
	function albumlist(){
		$data = $this->mgallery->albumlist();
		echo json_encode($data);
	}

	function createAlbum(){
		$data = $this->mgallery->createAlbum();
		echo json_encode($data);
	}

	function uploadPictures($albumid){
		$data = $this->mgallery->uploadPictures($albumid);
		echo json_encode($data);
	}

	function albumDisplay($spid=null){
		$data = $this->mgallery->albumDisplay($spid);
		echo json_encode($data);
	}

	function loadImages($id){
		$data = $this->mgallery->loadImages($id);
		echo json_encode($data);
	}
}
