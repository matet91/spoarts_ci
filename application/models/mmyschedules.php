<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class mmyschedules extends CI_Model {
	public function __construct()
	{
			// Call the CI_Model constructor
			parent::__construct();
	}
	
	function getlist($table, $fields , $where, $order, $leftjoin){
		$query = $this->db->query("SELECT $fields FROM $table $leftjoin $where $order");
		return $query->result();
	}
	
	function dataTables($switch){
		$sSort = $this->input->get('iSortCol_0');
		$sSortype = $this->input->get('sSortDir_0');
		$sSearch = $this->input->get('sSearch');
		$usertype = $this->session->userdata('usertype');
		$sLimit = "";
		if ( $this->input->get('iDisplayStart')!='' && $this->input->get('iDisplayLength') != '-1' )
			$sLimit = "LIMIT ".intVal($this->input->get('iDisplayStart')).", ".intVal($this->input->get('iDisplayLength'));

		switch($switch){
			case 1:
				$aColumns = array("StudEnrolledID","stud_name","Schedule","Room","Instructor","Service","Clinic");
				$select = array("se.StudEnrolledID","s.stud_name", "CONCAT(sc.SchedDays, '@',sc.SchedTime)as Schedule", "(CASE WHEN sc.RoomID=0 THEN 'TBA'  ELSE CONCAT(r.RoomNo, '-',r.RoomName) END)as Room","(CASE WHEN sc.InstructorID=0 THEN 'TBA'  ELSE m.MasterInsName END) as Instructor","ser.ServiceName as Service","c.clinic_name as Clinic");
				$sTable = "students_enrolled se";
				$leftjoin = " LEFT JOIN students s ON s.stud_id = se.stud_id LEFT JOIN schedules sc ON sc.SchedID = se.SchedID LEFT JOIN rooms r ON r.RoomID = sc.RoomID LEFT JOIN instructor_masterlist m ON m.MasterInsID = sc.InstructorID LEFT JOIN services ser ON ser.ServiceID = se.service_id LEFT JOIN clinics c ON c.clinic_id = se.clinic_id";
				$sWhere = "WHERE se.client_id = ".$this->session->userdata("userid")."";
				if($sSearch){$sWhere .= " AND (s.stud_name like '%".$sSearch."%' OR sc.scheddays like '%".$sSearch."%' OR sc.schedtime like '%".$sSearch."%'  OR r.RoomNo like '%".$sSearch."%' OR r.RoomName like '%".$sSearch."%' OR m.MasterInsName like '%".$sSearch."%' OR ser.ServiceName like '%".$sSearch."%' OR c.clinic_name like '%".$sSearch."%')";}
				$sOrder = 'ORDER BY '.$aColumns[$sSort].' '.$sSortype;
				$groupby = "";
				$aColumns_output = array("StudEnrolledID","stud_name","Schedule","Room","Instructor","Service","Clinic");
			break;
		}
		
		$sIndexColumn = "*";
			
		$sQuery = "SELECT SQL_CALC_FOUND_ROWS ".implode(",", $select)." FROM $sTable $leftjoin $sWhere $groupby $sOrder $sLimit";
		
		//print_r("SELECT SQL_CALC_FOUND_ROWS ".implode(",", $aColumns)." FROM $sTable $leftjoin $sWhere $groupby $sOrder $sLimit");
		
		$rResult = $this->db->query( $sQuery );
		//echo $this->db->last_query();
		$sQuery = "SELECT FOUND_ROWS() as count";
		$rResultFilterTotal = $this->db->query( $sQuery);

		$aResultFilterTotal = $rResultFilterTotal->row();
		$iFilteredTotal = $aResultFilterTotal->count;
		
		/* Total data set length */
		
		$sQuery_total = "SELECT COUNT(".$sIndexColumn.") as count FROM $sTable";
		$rResultTotal = $this->db->query( $sQuery_total);
		$aResultTotal = $rResultTotal->row();
		$iTotal = $aResultTotal->count;
		
		$output = array(
			"sEcho" =>$this->input->get('sEcho'),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		
		foreach($rResult->result() as $aRow){	
			$row = array();
			foreach ( $aColumns_output as $col ){
				$row[] = ($aRow->$col =="0") ? '-' : ucfirst($aRow->$col);
			}
			$output['aaData'][] = $row;
		}
		return $output;
	}
}