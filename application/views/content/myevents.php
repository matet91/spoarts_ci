<style>
  #modal_viewlist .modal-dialog {
    width: 95%; /* or whatever you wish */
  }
  #calendar {
	/*max-width: 900px;*/
	margin: 0 auto;
  }
</style>
<link href='assets/css/jquery.datetimepicker.css' rel='stylesheet' />
<link href='assets/fullcalendar/fullcalendar.css' rel='stylesheet' />
<link href='assets/fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />

<!-- Start Page Banner -->
    <div class="page-banner no-subtitle">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h2>My Events</h2>
				</div>
				<div class="col-md-6">
					<ul class="breadcrumbs">
						<li><a href="?content=home.php">Home</a></li>
						<li>My Events</li>
					</ul>
				</div>
			</div>
		</div>
    </div>
    <!-- End Page Banner -->


    <!-- Start Content -->
    <div id="content">
      <div class="container">
		<div class="row sidebar-page"> 
			<div class="page-content" id = "content-events-promos">
				<div id='calendar_events'></div>
			</div>
		</div>
      </div>
    </div>
    <!-- End Content -->
  
  <!-- modal enroll -->
    <div class="modal fade" id = "modal_enroll" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="title-promo">Enroll</h4>
				</div>
				<div class="modal-body">
					<div class = "row">
						<form id="formevent">
							<div class="col-md-6">
							  <div class = "form-group">
								<label for = "forsched_name">Student Type</label>
								<select class = "form-control chosen-select" id = "StudType"><option value=0>New</option><option value=1>Existing</option><option value=2>Client</option></select>
							  </div>
							  <div id="stud-exist" style="display:none"> 
								  <label for = "forsched_name">Student</label>
								  <select class = "form-control chosen-select" id = "stud_id" name = "stud_id"></select>
							  </div>
							  <div id="stud-new">
								  <div class = "form-group">
									<label for = "forsched_name">Name</label>
									<input type="text" class = "form-control" id = "stud_name" name = "stud_name" />
								  </div>
								  <div class = "form-group">
									<label for = "forsched_instructor">Age</label>
									<input type="text" class = "form-control" id = "stud_age" name = "stud_age" />
								  </div>
								  <div class = "form-group">
									<label for = "forsched_slot">Address</label>
									<input type="text" class = "form-control" id = "stud_address" name = "stud_address" />
								  </div>
								  <div class = "form-group">
									<label for = "forsched_slot">Relationship</label>
									<select class = "form-control chosen-select" id = "stud_relationship" name = "stud_relationship"></select>
								  </div>
								  <input type="hidden" class = "form-control" id = "SPID" name = "SPID" />
								  <input type="hidden" class = "form-control" id = "EventID" name = "EventID" />
							  </div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Exit</button>
						<button type="button" id= "btn-EventEnroll" class="btn btn-primary">Enroll</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
	</div>
    <!-- end modal -->
  
    <!-- javascripts -->
<script type="text/javascript" src="assets/js/myevents.js"></script>
<script src='assets/fullcalendar/lib/moment.min.js'></script>
<!--script src='assets/fullcalendar/lib/jquery.min.js'></script-->
<script src='assets/fullcalendar/fullcalendar.min.js'></script>
<script src='assets/js/jquery.datetimepicker.full.min.js'></script>
	
	