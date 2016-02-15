<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class mmyevents extends CI_Model {
	public function __construct()
	{
			// Call the CI_Model constructor
			parent::__construct();
	}
		
	function getlistid($table, $fields , $where, $order, $leftjoin){
		$query = $this->db->query("SELECT $fields FROM $table $leftjoin $where $order");
		$rowid = array();
		foreach ($query->result() as $row){
		   $rowid[] = $row->$fields;
		}
		return $rowid;
	}
}