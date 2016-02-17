<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class mgallery extends CI_Model {
	public function __construct()
	{
			// Call the CI_Model constructor
			parent::__construct();
			date_default_timezone_set('Asia/Manila');
	}

	function albumlist(){
		$userid = $this->session->userdata('userid');
		$this->db->where('UserID',$userid);
		$this->db->select('*');
		$qalbum = $this->db->get('albums');

		return $qalbum->result();
	}
	function albumDisplay(){
		$userid = $this->session->userdata('userid');
		$sql = "SELECT count(b.galleryID) as count,a.UserID,a.albumName,a.albumID as albumID,a.dateCreated,a.albumDesc,b.fileName FROM albums a LEFT JOIN gallery b ON a.albumID=b.albumID WHERE a.UserID='$userid' GROUP BY b.albumID ";

		$d = $this->db->query($sql);
		return $d->result();
	}
	function createAlbum(){
		$userid = $this->session->userdata('userid');
		$data = $this->input->post('data');
		$data['UserID'] = $userid;
		//check if another album with the same name of this user already exist
		$where = array('UserID'=>$userid,'albumName'=>$data['albumName']);
		$this->db->where($where);
		$this->db->select('*');
		$get = $this->db->get('albums');
		if($get->num_rows() > 0){
			return 1; exit();
		}else{
			$album = $data['albumName']."_".$userid;

			$dir = "assets/images/".$album;
			if( is_dir($dir) === false )
			{
			    mkdir($dir);
			    return $this->db->insert('albums',$data);
				exit();
			}else{
				return 2; exit();
			}
			
		}
	}

	function uploadPictures($albumid){
		$file = $_FILES['files'];
		$userid = $this->session->userdata('userid');
		$name = $file['name'][0];
		$tmp_name = $file['tmp_name'][0];

		$this->db->where('albumID',$albumid);
		$this->db->select("albumName");
		$get = $this->db->get('albums');
		$row = $get->row();
		$album = $row->albumName."_".$userid;

		$dir = "assets/images/".$album;
		if( is_dir($dir) === false )
		{
		    mkdir($dir);
		}		
		$dir = $dir."/".$name;

		move_uploaded_file($tmp_name, $dir);
		$err = $file['error'][0];	
		if ($err == 0) 
		{
			$data = array('albumID'=>$albumid,
							'fileName'=>$name);
			
			$this->db->insert('gallery',$data);
			return 1; exit();
		}else{
			return 0; exit();
		}
	}

	function loadImages($id){
		$userid = $this->session->userdata('userid');
		$get = $this->db->query("SELECT a.galleryID, a.fileName,CONCAT(b.albumName,'_',b.UserID) as albumName,a.dateCreated FROM gallery a LEFT JOIN albums b ON a.albumID=b.albumID WHERE a.albumID='$id'");
		return $get->result();
	}
}