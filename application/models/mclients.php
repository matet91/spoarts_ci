<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class mclients extends CI_Model {
	public function __construct()
	{
			// Call the CI_Model constructor
			parent::__construct();
			date_default_timezone_set('Asia/Manila');
			$this->load->model('mglobal');
	}

	function dataTables($case,$id=null){
		$sSort = $this->input->get('iSortCol_0');
		$sSortype = $this->input->get('sSortDir_0');
		$sSearch = $this->input->get('sSearch');
		$usertype = $this->session->userdata('usertype');
		$userid = $this->session->userdata('userid');
		$aColumns = explode(',',$this->input->get('sColumns'));
		$sLimit = "";
		if ( $this->input->get('iDisplayStart')!='' && $this->input->get('iDisplayLength') != '-1' )
			$sLimit = "LIMIT ".intVal($this->input->get('iDisplayStart')).", ".intVal($this->input->get('iDisplayLength'));

		switch($case){
			case 1://approved students
					$select = array("a.StudEnrolledID as ID",
									"a.SchedID as SchedID",
									"a.clinic_id as clinicid",
									"a.service_id as serviceid",
									"a.client_id as clientid",
									"b.stud_id as studid",
									"b.stud_name as name",
									"b.stud_age as age",
									"b.stud_address as address",
									"CONCAT(c.spfirstname,' ',c.splastname) as client",
									"d.ServiceName as service",
									"a.date_enrolled",
									"CONCAT(e.SchedDays,' ',e.SchedTime) as schedules",
									"f.MasterInsName as instructor",
									"1 as action");
					$sTable = "students_enrolled a";
					$leftjoin = " LEFT JOIN students b ON b.stud_id=a.stud_id LEFT JOIN user_details c ON c.UserID=a.client_id LEFT JOIN services d ON d.ServiceID=a.service_id LEFT JOIN schedules e ON e.SchedID=a.SchedID LEFT JOIN instructor_masterlist f ON f.MasterInsID=a.ins_id";
					//print_r($select);
					$sWhere = "wHERE d.SPID='$userid' AND a.StudEnrolledStatus=1";
					if($sSearch){
						$chkSearch = explode('_',$sSearch);
						if(count($chkSearch) > 1){
							$sWhere .= " AND d.ServiceID='".$chkSearch[1]."'";
						}else{
							$sWhere .= " AND (b.stud_name like '%".$sSearch."%' OR b.stud_age like '%".$sSearch."%' OR b.stud_address like '%".$sSearch."%' OR c.spfirstname like '%".$sSearch."%' OR c.splastname like '%".$sSearch."%' OR d.ServiceName like '%".$sSearch."%' OR a.date_enrolled like '%".$sSearch."%' OR e.ScedDays like '%".$sSearch."%' OR e.SchedTime like '%".$sSearch."%' OR f.MasterInsName like '%".$sSearch."%' OR b.stud_id like '%".$sSearch."%')";
						}
					}
					$aColumns = array("a.StudEnrolledID",
									  "a.SchedID",
									  "a.clinic_id",
									  "a.service_id",
									  "a.client_id",
									  "b.studid",
									  "b.stud_name",
									  "b.stud_age",
									  "b.stud_address",
									  "c.spfirstname",
									  'd.ServiceName',
									  "f.MasterInsName",
									  "a.date_enrolled",
									  "e.SchedDays"
									);
					$sOrder = 'ORDER BY '.$aColumns[$sSort].' '.$sSortype;
					$groupby = "";
					$aColumns_output = array("ID","SchedID","clinicid","serviceid","clientid","studid","name","age","address","client","service","instructor","date_enrolled","schedules","totalamt","totalbalance","action");
			break;

			case 2://disapproved students
					$select = array("a.StudEnrolledID as ID",
									"a.SchedID as SchedID",
									"a.clinic_id as clinicid",
									"a.service_id as serviceid",
									"a.client_id as clientid",
									"b.stud_id as studid",
									"b.stud_name as name",
									"b.stud_age as age",
									"b.stud_address as address",
									"CONCAT(c.spfirstname,' ',c.splastname) as client",
									"d.ServiceName as service",
									"a.date_enrolled",
									"CONCAT(e.SchedDays,' ',e.SchedTime) as schedules",
									"f.MasterInsName as instructor",
									"1 as action");
					$sTable = "students_enrolled a";
					$leftjoin = " LEFT JOIN students b ON b.stud_id=a.stud_id LEFT JOIN user_details c ON c.UserID=a.client_id LEFT JOIN services d ON d.ServiceID=a.service_id LEFT JOIN schedules e ON e.SchedID=a.SchedID LEFT JOIN instructor_masterlist f ON f.MasterInsID=a.ins_id";
					//print_r($select);
					$sWhere = "wHERE d.SPID='$userid' AND a.StudEnrolledStatus=0";
					if($sSearch){
						$chkSearch = explode('_',$sSearch);
						if(count($chkSearch) > 1){
							$sWhere .= " AND d.ServiceID='".$chkSearch[1]."'";
						}else{
							$sWhere .= " AND (b.stud_name like '%".$sSearch."%' OR b.stud_age like '%".$sSearch."%' OR b.stud_address like '%".$sSearch."%' OR c.spfirstname like '%".$sSearch."%' OR c.splastname like '%".$sSearch."%' OR d.ServiceName like '%".$sSearch."%' OR a.date_enrolled like '%".$sSearch."%' OR e.ScedDays like '%".$sSearch."%' OR e.SchedTime like '%".$sSearch."%' OR f.MasterInsName like '%".$sSearch."%' OR b.stud_id like '%".$sSearch."%')";
						}
					}
					$aColumns = array("a.StudEnrolledID",
									  "a.SchedID",
									  "a.clinic_id",
									  "a.service_id",
									  "a.client_id",
									  "b.studid",
									  "b.stud_name",
									  "b.stud_age",
									  "b.stud_address",
									  "c.spfirstname",
									  'd.ServiceName',
									  "f.MasterInsName",
									  "a.date_enrolled",
									  "e.SchedDays"
									);
					$sOrder = 'ORDER BY '.$aColumns[$sSort].' '.$sSortype;
					$groupby = "";
					$aColumns_output = array("ID","SchedID","clinicid","serviceid","clientid","studid","name","age","address","client","service","instructor","date_enrolled","schedules","action");
			break;
			case 3://time logs
					$select = array("tl_id",
									"tl_in",
									"tl_out",
									"(CASE WHEN tl_paid=0 THEN 'UNPAID' WHEN tl_paid=1 THEN 'PAID' ELSE 'PARTIAL PAYMENT' END) as payment_status");
					$sTable = "time_logs";
					$leftjoin = "";
					//print_r($select);
					$sWhere = "WHERE StudEnrolledID='$id'";
					if($sSearch){
						$sWhere .= " AND (tl_in like '%".$sSearch."%' OR tl_out like '%".$sSearch."%')";
						
					}
					$aColumns = array("tl_id","tl_in",
									  "tl_out",'tl_paid'
									);
					$sOrder = 'ORDER BY '.$aColumns[$sSort].' '.$sSortype;
					$groupby = "";
					$aColumns_output = array("tl_id","date","tl_in","tl_out",'payment_status');
			break;
			case 4://payment logs
					$select = array("b.payment_id",
									"DATE(b.payment_date) as start_date",
									"DATE(b.payment_end_date) as end_date",
									"(CASE WHEN b.payment_type=0 THEN 'Session' WHEN b.payment_type=1 THEN 'Monthly' ELSE 'Membership' END) as payment_type",
									"b.payment_amt",
									"b.payment_balance",
									"b.date_added",
									"b.last_updated",
									"1 as action");
					$sTable = "students_enrolled a";
					$leftjoin = " LEFT JOIN payment_logs b ON b.stud_id=a.stud_id AND b.service_id=a.service_id";
					//print_r($select); 
					$sWhere = "WHERE a.StudEnrolledID='$id'";
					if($sSearch){
						$sWhere .= " AND (b.payment_date like '%".$sSearch."%' OR b.payment_end_date like '%".$sSearch."%' OR b.payment_type like '%".$sSearch."%' OR b.payment_amt like '%".$sSearch."%' OR b.payment_balance like '%".$sSearch."%' OR b.date_added like '%".$sSearch."%' OR b.last_updated like '%".$sSearch."%')";
						
					}
					$aColumns = array("b.payment_id","b.payment_date",
									  "b.payment_end_date",'b.payment_type','b.payment_amt','b.payment_balance','b.date_added','b.last_updated'
									);
					$sOrder = 'ORDER BY '.$aColumns[$sSort].' '.$sSortype;
					$groupby = "";
					$aColumns_output = array("payment_id","start_date","end_date","payment_type",'payment_amt','payment_balance','date_added','last_updated','action');
			break;
			case 5://enrolled student in events logs
					$userid = $this->session->userdata('userid');
					$select = array("ee.EventEnrolledID",
									"e.EventName",
									"s.stud_name",
									"CONCAT(u.spfirstname,' ',u.splastname) as client",
									"ee.dateEnrolled");
					$sTable = "events_enrolled ee";
					$leftjoin = " LEFT JOIN events e ON e.EventID=ee.EventID LEFT JOIN students s ON s.stud_id = ee.stud_id LEFT JOIN user_details u ON u.UserID=ee.client_id";
					//print_r($select); 
					$sWhere = "WHERE ee.EventEnrolledStatus=1 AND ee.clinic_id='$userid'";
					if($sSearch){
						$sWhere .= " AND (e.EventName like '%".$sSearch."%' OR s.stud_name like '%".$sSearch."%' OR u.spfirstname like '%".$sSearch."%' OR u.splastname like '%".$sSearch."%' OR ee.dateEnrolled like '%".$sSearch."%')";
						
					}
					$aColumns = array("ee.EventEnrolledID","e.EventName",
									  "s.stud_name",'client','ee.dateEnrolled'
									);
					$sOrder = 'ORDER BY '.$aColumns[$sSort].' '.$sSortype;
					$groupby = "";
					$aColumns_output = array("EventEnrolledID","EventName","stud_name","client",'dateEnrolled');
			break;
		}
		
		$sIndexColumn = "*";
			
		$sQuery = "SELECT SQL_CALC_FOUND_ROWS ".implode(",", $select)." FROM $sTable $leftjoin $sWhere $groupby $sOrder $sLimit";
		//echo $this->db->last_query();
		//print("SELECT SQL_CALC_FOUND_ROWS ".implode(",", $aColumns)." FROM $sTable $leftjoin $sWhere $groupby $sOrder $sLimit");
		
		$rResult = $this->db->query( $sQuery );
		//echo $this->db->last_query();
		//print_r($rResult->result());
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
				if($case == 3){
					if($col == 'date'){
						$date = date('Y-m-d',strtotime($aRow->tl_in));
						$row[] = $date;
					}else if($col == 'tl_in'){
						$row[] = date('h:i:s',strtotime($aRow->tl_in));
					}else if($col=='tl_out'){
						$row[] = ($aRow->$col =='') ? '-' :date('h:i:s',strtotime($aRow->tl_out));
					}else {
						$row[] = ($aRow->$col =='') ? '-' : $aRow->$col;
					}
				}else if($case == 1){
					$studid = $aRow->studid;
					$serviceid = $aRow->serviceid;
					if($col == 'totalamt' || $col == 'totalbalance'){
						$where = array("stud_id"=>$studid,
										"service_id"=>$serviceid);
						$select = array("SUM(payment_amt) as totalamt","SUM(payment_balance) as totalbalance");
						$this->db->where($where);
						$this->db->select($select);
						$get = $this->db->get("payment_logs");
						if($get->num_rows() > 0){
							$grow = $get->row();
							$totalAmt = $grow->totalamt;
							$totalbalance = $grow->totalbalance;
						}else{
							$totalAmt = "-";
							$totalbalance = "-";
						}
						if($col == 'totalamt'){
							$row[] = $totalAmt;
						}else{
							$row[] = $totalbalance;
						}
					}else $row[] = ($aRow->$col =='') ? '-' : $aRow->$col;
				}else $row[] = ($aRow->$col =='') ? '-' : $aRow->$col;
			}
			$output['aaData'][] = $row;
		}
		return $output;
	}

	function checkStatus($id){
		$today = date('Y-m-d');
		$sql = "SELECT * FROM time_logs WHERE StudEnrolledID='$id' and tl_in LIKE '$today%'";
		$q = $this->db->query($sql);

		if($q->num_rows() > 0){
			return $q->row(); exit();
		}else{
			return 0; exit();
		}
	}

	function in_out($id,$schedid,$studid,$clinicid,$serviceid){
		$today = date('Y-m-d');
		$sql = "SELECT * FROM time_logs a WHERE a.StudEnrolledID='$id' and tl_in LIKE '$today%'";
		$q = $this->db->query($sql);
		$datetime = date('Y-m-d h:i:s');
		if($q->num_rows() > 0){
			//echo '1';
			$row = $q->row();
			$tlid = $row->tl_id;
			$tlout = $row->tl_out;
			$tlpaid = $row->tl_paid;
			if(!isset($tlout)){
				$this->db->where('tl_id',$tlid);
				$this->db->update('time_logs',array('tl_out'=>$datetime));
				//get info for students
				$sql = "SELECT b.ServiceName,a.client_id,d.stud_name,c.clinic_name from students_enrolled a LEFT JOIN services b ON a.service_id=b.ServiceID LEFT JOIN clinics c ON c.clinic_id=a.clinic_id LEFT JOIN students d ON d.stud_id=a.stud_id WHERE a.StudEnrolledID='$id'";

				$qx = $this->db->query($sql);
				$rowx = $qx->row();
				$studname = $rowx->stud_name;
				$clientid = $rowx->client_id;
				$clinicname = $rowx->clinic_name;
				$servicename = $rowx->ServiceName;
				$subj = "Time In/Out";
				$msg = "$studname just logged out today ".date('Y-m-d h:i:s')." [".$clinicname."-".$servicename."]";

				$this->mglobal->addNotif($subj,$msg,$clientid);
				return 1; //timeout updated return and change it to completed today's session
				exit();
			}

			//check if paid
			if($tlpaid != 1){
				$sql = "SELECT * FROM payment_logs WHERE stud_id='$studid' and service_id='$serviceid' and payment_type='1' and date(payment_end_date) >= '$today'";
				$q = $this->db->query($sql);
				if($q->num_rows() > 0){
					$row = $q->row();
					$bal = $row->payment_balance;
					if($bal > 0)//check if balance
						$paid = 2; //partial payment
					else $paid = 1; //fully paid

					$this->db->where('tl_id',$tlid);
					$this->db->update('time_logs',array('tl_paid'=>$paid));
				}
			}
		}else{//echo '2';
			//check if paid
			$sql = "SELECT * FROM payment_logs WHERE stud_id='$studid' and service_id='$serviceid' and payment_type='1' and date(payment_end_date) >= '$today'";
				$q = $this->db->query($sql);
				if($q->num_rows() > 0){
					$row = $q->row();
					$bal = $row->payment_balance;
					if($bal > 0)//check if balance
						$paid = 2; //partial payment
					else $paid = 1; //fully paid
				}else{
					$paid = 0;
				}

			//insert a new row for students that has no records yet in time logs
			$data = array('SchedID'=>$schedid,
							'tl_in'=>date('Y-m-d h:i:s'),
							'StudEnrolledID'=>$id,
							'service_id'=>$serviceid,
							'clinic_id'=>$clinicid,
							'stud_id'=>$studid,
							'tl_paid'=>$paid
						);
			$this->db->insert('time_logs',$data);

			//get info for students
				$sql = "SELECT b.ServiceName,a.client_id,d.stud_name,c.clinic_name from students_enrolled a LEFT JOIN services b ON a.service_id=b.ServiceID LEFT JOIN clinics c ON c.clinic_id=a.clinic_id LEFT JOIN students d ON d.stud_id=a.stud_id WHERE a.StudEnrolledID='$id'";

				$qx = $this->db->query($sql);
				$rowx = $qx->row();
				$studname = $rowx->stud_name;
				$clientid = $rowx->client_id;
				$clinicname = $rowx->clinic_name;
				$servicename = $rowx->ServiceName;
				$subj = "Time In/Out";
				$msg = "$studname just logged in today ".date('Y-m-d h:i:s')." [".$clinicname."-".$servicename."]";

				$this->mglobal->addNotif($subj,$msg,$clientid);
			return 0; exit();
		}
	}

	function clientPayment(){
		$data = $this->input->post('data');
		$userid = $this->session->userdata('userid');
		$now = date('Y-m-d h:i:s');
		$bal = $data['payment_balance'];
		$paymentLog['payment_date'] = $now;
		//check payment_type
		$paymenttype = $data['payment_type'];
		if($paymenttype == 0){ //paid per session
			//valid for 1 day
			$pt = "Session";
			$paymentLog['payment_end_date'] = $now;
			$timelogid = $data['date_log'];
			
			if(isset($timelogid)){
				if($bal > 0)
					$paid = 2; //partial payment
				else $paid = 1; //fully paid payment

				$this->db->where('tl_id',$timelogid);
				$this->db->update('time_logs',array("tl_paid"=>$paid));
			}
		}else if($paymenttype == 1){//monthly
			$pt = "Monthly";
			$end_date = new DateTime($now);
			$end_date->add(new DateInterval('P1M'));
			$edate = $end_date->format('Y-m-d h:i:s');
			$paymentLog['payment_end_date'] = $edate;
			$end = date('Y-m-d',strtotime($edate));
			$start = date('Y-m-d',strtotime($now));

			//update all time logs of student's specific service for column tl_paid to 1(paid) w/c date is between payment_date and tldate or the payment_end_date 
			$serviceid = $data['service_id'];
			$student = $data['stud_id'];
			if($bal > 0)
					$paid = 2; //partial payment
				else $paid = 1; //fully paid payment

			$sql = "UPDATE time_logs set tl_paid='$paid' WHERE service_id='$serviceid' and stud_id = '$student' and DATE(tl_in) BETWEEN '$start' AND '$end'";
			$this->db->query($sql);

		}else{ //membership
			$pt = "Membership";
			$paymentLog['payment_end_date'] = '';
		}
		$payArr = array('payment_amt',
							'payment_type',
							'payment_balance',
							'stud_id',
							'client_id',
							'payment_desc',
							'SchedID',
							'service_id');
		foreach($payArr as $val){
			$paymentLog[$val] = $data[$val];
		}
		$paymentLog['UserID'] = $userid;
		$d = $this->db->insert('payment_logs',$paymentLog);
		//get info for students
		$sql = "SELECT b.ServiceName,a.client_id,d.stud_name,c.clinic_name from students_enrolled a LEFT JOIN services b ON a.service_id=b.ServiceID LEFT JOIN clinics c ON c.clinic_id=a.clinic_id LEFT JOIN students d ON d.stud_id=a.stud_id WHERE a.StudEnrolledID='".$data['stud_id']."'";

		$qx = $this->db->query($sql);
		$rowx = $qx->row();
		$studname = $rowx->stud_name;
		$clientid = $rowx->client_id;
		$clinicname = $rowx->clinic_name;
		$servicename = $rowx->ServiceName;

		$subj = "$pt Payment ".date('Y-m-d h:i:s');
		$msg = "Paid Today with amount of ".$data['payment_amt']." and outstanding balance of ".$data['payment_balance']." [ ".$clinicname."-".$servicename." ] ";

		$this->mglobal->addNotif($subj,$msg,$clientid);
		return $d;
	}

	function getPaymentDetails($id){
		$sql = "SELECT SUM(f.payment_amt) as totalamt,SUM(f.payment_balance) as totalbalance,b.ServiceName as servicename,CONCAT(d.spfirstname,' ',d.splastname) as clientname,e.stud_name as studentname,g.clinic_name as clinicname FROM students_enrolled a LEFT JOIN services b ON b.ServiceID=a.service_id LEFT JOIN students c ON c.stud_id=a.stud_id LEFT JOIN user_details d ON d.UserID=a.client_id LEFT JOIN students e ON e.stud_id = a.stud_id  LEFT JOIN payment_logs f ON f.stud_id = a.stud_id and f.service_id=a.service_id LEFT JOIN clinics g ON g.clinic_id=a.clinic_id WHERE a.StudEnrolledID='$id'";

		$q = $this->db->query($sql);

		return $q->result();
	}

	function updateBalance($paymentid){
		$amt = $this->input->post('payment_amt');
		$bal = $this->input->post('payment_balance');
		$data = array('payment_amt'=>$amt,'payment_balance'=>$bal);
		$this->db->where('payment_id',$paymentid);
		$q = $this->db->update('payment_logs',$data);
		return $q;
	}

	function approve($id,$schedid){
		$sql = "SELECT StudEnrolledID FROM students_enrolled WHERE SchedID='$schedid' and StudEnrolledStatus = 1";
		$q = $this->db->query($sql);
		$count = $q->num_rows()+1;
		//check if schedule exist
		$this->db->where('SchedID',$schedid);
		$this->db->select('*');
		$get = $this->db->get('schedules');

		//check if the student has conflict schedule
		//get the sched time and day and the students id of $id (its the studenrolledid of students_enrolled)
		$sqlx = "SELECT * FROM students_enrolled a LEFT JOIN schedules b ON a.SchedID=b.SchedID WHERE a.StudEnrolledID='$id'";
		$qx = $this->db->query($sqlx);
		$rowx = $qx->row();
		$sDays = explode(',',$rowx->SchedDays);
		$sTime = explode('-',$rowx->SchedTime);
		$sStart = date('h:i a',strtotime(str_replace(' ','',$sTime[0])));
		$sEnd = date('h:i a',strtotime(str_replace(' ','',$sTime[1])));
		$studid = $rowx->stud_id;
		$startTime = "STR_TO_DATE(SUBSTRING_INDEX(b.SchedTime,'-',1),'%h:%i %p')";
		$endTime = "STR_TO_DATE(SUBSTRING_INDEX(b.SchedTime,'-',-1),'%h:%i %p')";
		$start = "STR_TO_DATE('$sStart','%h:%i %p')";
		$end = "STR_TO_DATE('$sEnd','%h:%i %p')";

		$sqlb = "SELECT * FROM students_enrolled a LEFT JOIN schedules b ON b.SchedID = a.SchedID WHERE b.SchedDays REGEXP '".implode('|',$sDays)."' AND (($startTime BETWEEN $start AND $end AND $startTime !=$end) OR ($endTime BETWEEN $start AND $end AND $endTime != $start) OR ($startTime <= $start && $endTime >= $end)) AND a.stud_id='$studid' and a.StudEnrolledStatus=1";

		$qb = $this->db->query($sqlb);
		if($qb->num_rows() > 0){
			//get info for students
			$sql = "SELECT b.ServiceName,a.client_id,d.stud_name,c.clinic_name from students_enrolled a LEFT JOIN services b ON a.service_id=b.ServiceID LEFT JOIN clinics c ON c.clinic_id=a.clinic_id LEFT JOIN students d ON d.stud_id=a.stud_id WHERE a.StudEnrolledID='$id'";

			$qx = $this->db->query($sql);
			$rowx = $qx->row();
			$studname = $rowx->stud_name;
			$clientid = $rowx->client_id;
			$clinicname = $rowx->clinic_name;
			$servicename = $rowx->ServiceName;
			$subj = "Enrollment Request Approval";
			$msg = "$studname enrollment to ".$servicename." of ".$servicename." has been decline because the schedule is conflict to some of your student's schedule. [".$clinicname."-".$servicename."]";

			$this->mglobal->addNotif($subj,$msg,$clientid);

			return 2; exit(); //student's schedule is conflict
		}
		//end conflict checking
		if($get->num_rows() > 0){
			$update = "UPDATE schedules set SchedRemaining='$count' WHERE SchedID = '$schedid' AND SchedSlots > '$count'";
			$qup = $this->db->query($update);
			if($qup == true){
				$this->db->where('StudEnrolledID',$id);
				$qx = $this->db->update('students_enrolled',array('StudEnrolledStatus'=>1));

				//get info for students
				$sql = "SELECT b.ServiceName,a.client_id,d.stud_name,c.clinic_name from students_enrolled a LEFT JOIN services b ON a.service_id=b.ServiceID LEFT JOIN clinics c ON c.clinic_id=a.clinic_id LEFT JOIN students d ON d.stud_id=a.stud_id WHERE a.StudEnrolledID='$id'";

				$qx = $this->db->query($sql);
				$rowx = $qx->row();
				$studname = $rowx->stud_name;
				$clientid = $rowx->client_id;
				$clinicname = $rowx->clinic_name;
				$servicename = $rowx->ServiceName;
				$subj = "Enrollment Request Approval";
				$msg = "$studname enrollment to ".$servicename." of ".$clinicname." has been approved last ".date('Y-m-d h:i:s')." [".$clinicname."-".$servicename."]";

				$this->mglobal->addNotif($subj,$msg,$clientid);


				return 3; exit();
			}else{
				//get info for students
				$sql = "SELECT b.ServiceName,a.client_id,d.stud_name,c.clinic_name from students_enrolled a LEFT JOIN services b ON a.service_id=b.ServiceID LEFT JOIN clinics c ON c.clinic_id=a.clinic_id LEFT JOIN students d ON d.stud_id=a.stud_id WHERE a.StudEnrolledID='$id'";

				$qx = $this->db->query($sql);
				$rowx = $qx->row();
				$studname = $rowx->stud_name;
				$clientid = $rowx->client_id;
				$clinicname = $rowx->clinic_name;
				$servicename = $rowx->ServiceName;
				$subj = "Enrollment Request Approval";
				$msg = "$studname was not able to enroll to ".$servicename." of ".$clinicname." because there is no available slot. [".$clinicname."-".$servicename."]";

				$this->mglobal->addNotif($subj,$msg,$clientid);
				return 1; exit(); //full
			}
		}else{
			return 0; exit(); //schedule does not exist
		}
	}

	function countPendings(){
		$clinic = $this->session->userdata('clinic_id');
		$sql = "SELECT * FROM students_enrolled WHERE StudEnrolledStatus=0 and clinic_id = '$clinic'";
		$q  = $this->db->query($sql);

		return $q->num_rows();
	}

	function removePending($id){
		$sqlz = $this->db->query("SELECT * FROM students_enrolled WHERE StudEnrolledID='$id'");
		$ros = $sqlz->row();
		$schedid = $ros->SchedID;
		//update waiting list
		$sql = $this->db->query("UPDATE schedules set SchedRemaining = (SchedRemaining-1) WHERE SchedID='$schedid'");

		$this->db->where('StudEnrolledID',$id);
		return $this->db->delete('students_enrolled');
	}
}