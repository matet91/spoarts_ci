 <!-- Start Content -->
    <div id="content">
      <div class="container">
        <!-- Start Recent Projects Carousel -->
        <div class="recent-projects">
          <h4 class="title"><span>Arts and Sports Club</span></h4>
          <div id="allclinics">
          

          </div>
        </div>
        <!-- End Recent Projects Carousel -->
      </div>
    </div>
	
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
						<input type="hidden" class = "form-control" id = "ctype"/>
						<form  id="formschedule">  
							<div class="col-md-6">
							  <div class = "form-group">
								<label for = "forsched_name">Services</label>
								<select class = "form-control chosen-select" id = "Service" name = "Service"></select>
							  </div>
							  <div class = "form-group" id="schedform" style="display: none">
								<label for = "forsched_name">Schedules</label>
								<select class = "form-control chosen-select" id = "Schedule" name = "Schedule"></select>
							  </div>
							  <div id="sched-info" style="display:none">
								  <div class = "form-group">
									<label for = "forsched_instructor">Instructor: </label>
									<label id = "instructor"></label>
								  </div>
								  <div class = "form-group">
									<label for = "forsched_slot">Slot: </label>
									<label id = "slot"></label>
								  </div>
								  <div class = "form-group">
									<label for = "forsched_room">Room: </label>
									<label id = "room"></label>
								  </div>
							  </div>
							</div>
						</form>
						<form id="formstudent" style="display:none;">
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
								  <input type="hidden" class = "form-control" id = "service_id" name = "service_id" />
								  <input type="hidden" class = "form-control" id = "clinic_id" name = "clinic_id" />
								  <input type="hidden" class = "form-control" id = "ins_id" name = "ins_id" />
								  <input type="hidden" class = "form-control" id = "SchedID" name = "SchedID" />
							  </div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Exit</button>
						<button type="button" id= "btn-Enroll" class="btn btn-primary">Enroll</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
	</div>
    <!-- end modal -->
	
    <!-- End Content -->
    <script type="text/javascript" src="assets/js/home.js"></script>