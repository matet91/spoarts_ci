<style>
	#clients .modal-dialog{
		width: 85% !important;
	}
</style>


<!-- Start Page Banner -->
    <div class="page-banner no-subtitle">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <h2>Clients</h2>
          </div>
          <div class="col-md-6">
            <ul class="breadcrumbs">
              <li><a href="?content=home.php">Home</a></li>
              <li>Clients</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <!-- End Page Banner -->
<div id="content">
  <div class = "container" id = "clients">
  <input type = "hidden" id = "studEnrolledID">
<input type = "hidden" id = "SchedID"/>
<input type = "hidden" id = "studid"/>
<input type = "hidden" id = "clinicid"/>
<input type = "hidden" id = "serviceid"/>
<input type = "hidden" id = "clientid"/>
<input type = "hidden" id = "paymentid"/>
    <!-- Page Content -->
    <div class="page-content">
      <div class="tabs-section" id = "tab-clients">
        <!-- Nav Tabs -->
        <ul class="nav nav-tabs">
        <li class="active"><a href="#tab-clients" data-toggle="tab"><i class="fa fa-group"></i>Clients</a></li>
          <li><a href="#tab-student_approved" data-toggle="tab"><i class="fa fa-group"></i>Approved Students</a></li>
          <li><a href="#tab-students_pending" data-toggle="tab"><i class="fa fa-group"></i>Pending Students&nbsp;<span id='countPending' class='text-danger'></span></a></li>
          
        </ul>
        <!-- Tab panels -->
      	<div class="tab-content">

          <!-- Tab Content 1 -->
          <div class="tab-pane fade in active" id="tab-clients">
      		<!-- Divider -->
				<div class="hr5" style="margin-top:30px; margin-bottom:45px;"></div>
           		<table id="tbl-clients" class="display" cellspacing="0" width="100%"></table>
          </div>
          <div class="tab-pane fade in" id="tab-student_approved">
      		<select id = "service_id" class = "chosen-select">
      		</select>
      		<!-- Divider -->
			<div class="hr5" style="margin-top:30px; margin-bottom:45px;"></div>
           	<table id="tbl-approved_students" class="display" cellspacing="0" width="100%"></table>
          </div>

          <div class="tab-pane fade in" id="tab-students_pending">
      		<!-- Divider -->
				<div class="hr5" style="margin-top:30px; margin-bottom:45px;"></div>
           		<table id="tbl-disapproved_students" class="display" cellspacing="0" width="100%"></table>
          </div>
        </div>
      </div>
	</div>
	<!-- MODAL -->
	<!-- modal time logs -->
    <div class="modal fade" id = "modal_timelogs" tabindex="-1" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

            <h4 class="modal-title">Time Logs</h4>
          </div>
          <div class="modal-body">
          	<div class = "row" style = "margin: 3%">
          		<button class = "btn btn-lg btn-primary" id="in_out"><i class = "fa fa-clock-o fa-fw"></i>Time In</button>
          		<button class = "btn btn-lg btn-primary" id="paynow"><i class = "fa fa-money fa-fw"></i>Pay Now</button>
          		
          		<form id = "frm-paynow" style = "display:none">
          		<div class="hr5" style="margin-top:30px; margin-bottom:45px;"></div>
          			<div class = "col-md-6">
          				<div class = "form-group">
              				<label>Payment Type</label>
              				<select id = "payment_type" name = "payment_type" class="form-control chosen-select" placeholder="Payment Type">
              					<option value = "0">Session</option>
              					<option value = "1">Monthly</option>
              					<option value = "2">Membership Fee</option>
              				</select>
              			</div>
              			<div class = "form-group">
              				<label>Select Date [<span class = "text-info"> To update/check PARTIAL PAYMENTS or OUTSTANDING BALANCE, check on PAYMENT LOGS </span>]</label>
              				<select id = 'date_log' name = 'date_log' class = "chosen-select" placeholder="Date">
              				</select>
              			</div>
              			
              			<div class = "form-group">
              				<label>Amount to Pay</label>
              				<input type = "text" id = "payment_amt" name = "payment_amt" class = "form-control" placeholder="Amount" value="0" onkeypress="numbersOnly(this.value,this.name)"/>
              			</div>
              		</div>
              		<div class = "col-md-6">
              			<div class = "form-group">
              				<label>Balance</label>
              				<input type = "text" id = "payment_balance" name = "payment_balance" class = "form-control" value="0"  onkeypress="numbersOnly(this.value,this.name)"/>
              			</div>

              			<div class = "form-group">
              				<label>Note</label>
              				<textarea id = "payment_desc" name = "payment_desc" class = "form-control" placeholder="Payment Description"></textarea>
              			</div>
              		</div>
              		<div class = "form-group" style="float:right">
              			<button type="button" id = "btn-close" class="btn btn-default">Close</button>&nbsp;<button type="button" class="btn btn-primary" id = "btn-payout">Submit</button>
              		</div>
          		</form>

          	</div>

             <div class="hr5" style="margin-top:30px; margin-bottom:45px;"></div>
             <span class = "text-info"> To update/check PARTIAL PAYMENTS or OUTSTANDING BALANCE, check on PAYMENT LOGS </span>
             <br/>
             <br/>
   			 <table id="tbl-timelogs" class="display" cellspacing="0" width="100%"></table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  <!-- end modal time logs-->
  <!-- modal add Services -->
    <div class="modal fade" id = "modal_paymentlogs" tabindex="-1" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

            <h4 class="modal-title">Payment Logs</h4>
          </div>
          <div class="modal-body">	
             <form id = "frm-paymentdetails">
	             <div class = "col-md-6">
	             	<div class = "form-group">
	             		<label>Total Amount Spent :</label>
	             		<input type = "text" id = "totalamt" name = "totalamt" class = "form-control" disabled/>
	             	</div>
	             	<div class = "form-group">
	             		<label>Service Name :</label>
	             		<input type = "text" id = "servicename" name = "servicename" class = "form-control" disabled/>
	             	</div>
	             	<div class = "form-group">
	             		<label>Student Name :</label>
	             		<input type = "text" id = "studentname" name = "studentname" class = "form-control" disabled/>
	             	</div>
	             </div>
	             <div class = "col-md-6">
	             	<div class = "form-group">
	             		<label>Total Outstanding Balance :</label>
	             		<input type = "text" id = "totalbalance" name = "totalbalance" class = "form-control" disabled/>
	             	</div>
	             	<div class = "form-group">
	             		<label>Clinic Name :</label>
	             		<input type = "text" id = "clinicname" name = "clinicname" class = "form-control" disabled/>
	             	</div>
	             	<div class = "form-group">
	             		<label>Client Name :</label>
	             		<input type = "text" id = "clientname" name = "clientname" class = "form-control" disabled/>
	             	</div>
	             </div>
	         </form>
             <div class="hr5" style="margin-top:30px; margin-bottom:45px;"></div>
   			 <table id="tbl-paymentlogs" class="display" cellspacing="0" width="100%"></table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
 <!-- end modal services-->
	<!-- END MODAL -->
	</div>
</div>
<script type="text/javascript" src="assets/js/clients.js"></script>