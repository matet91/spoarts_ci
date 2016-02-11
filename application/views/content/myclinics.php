<style>
  #portfolio-list li{
    border: 1px solid #fff;
  }
 #portfolio-list li:hover .more{
    top:68% !important;
  }
</style>
<!-- Start Page Banner -->
    <div class="page-banner no-subtitle">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <h2><?php echo ($this->input->get('type')==1)?'Arts Clinic':'Sports Clinic';?></h2>
          </div>
          <div class="col-md-6">
            <ul class="breadcrumbs">
              <li><a href="?content=home.php">Home</a></li>
              <li><?php echo ($this->input->get('type')==1)?'Arts':'Sports';?></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <!-- End Page Banner -->
 <!-- Start Portfolio Section -->
    <input type = "hidden" id = "clinic_type" value = "<?=$this->input->get('type');?>">
    <!-- Start Content -->
    <div id="content">
      <div class = "container" id = "clinic">
        <!-- Page Content -->
        <div class="page-content">
          <!-- Classic Heading -->
          <h4 class="classic-title"><span><?php echo ($this->input->get('type')==1)?'Arts':'Sports';?> Clinic List</span></h4> 
        <!-- Stat Search -->
            <div class="search-side">
              <a class="show-search"><i class="fa fa-search"></i></a>
              <div class="search-form">
                  <input type="text" value="" name="searchClinic" id="searchClinic" placeholder="Search clinic..."/>
              </div>
            
            <!-- End Search -->
          </div>
        
        <!-- Divider -->
        <div class="hr1 margin-top"></div>

        <div class="section full-width-portfolio" style="border-top:0; border-bottom:0; background:#fff;">

          <!-- Start Recent Projects Carousel -->
          <ul id="portfolio-list" data-animated="fadeIn">
          </ul>
          <!-- End Recent Projects Carousel -->
        
        <!-- End Portfolio Section -->
        </div>
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
						<div class="alert" role="alert" style = "display:none"></div>
						<form  id="formschedule">  
							<div class="col-md-6">
							  <div class = "form-group">
								<label for = "forsched_name">Schedules</label>
								<select class = "form-control" id = "Schedule" name = "Schedule"></select>
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
								<select class = "form-control" id = "StudType"><option value=0>New</option><option value=1>Existing</option></select>
							  </div>
							  <div id="stud-exist" style="display:none"> 
								  <select class = "form-control" id = "stud_id" name = "stud_id"></select>
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
	
    <!-- javascripts -->
    <script type="text/javascript" src="assets/js/clinics.js"></script>