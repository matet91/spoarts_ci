<style>
  #portfolio-list li{
    border: 1px solid #fff;
  }
 #portfolio-list li:hover .more{
    top:68% !important;
  }
  @media screen and (min-width: 768px) {
    .modalinfo {
        width: 70%; /* either % (e.g. 60%) or px (400px) */
    }
}
.colmd{
	width: 100% !important;
}

#services-div,#HideReviewsRatings{
	margin-bottom:10px;
	display:none;
}

#ServiceInfo,.read-more{
	margin-bottom:10px;
}

#SaveComment,#formrate{
	margin-top:10px;
	margin-bottom:10px;
}
</style>
<!-- Bootstrap Rating CSS  -->
 <link rel="stylesheet" href="assets/css/bootstrap-rating.css" type="text/css" media="screen">
<!-- Start Page Banner -->
    <div class="page-banner no-subtitle">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <h2>My Clinics</h2>
          </div>
          <div class="col-md-6">
            <ul class="breadcrumbs">
              <li><a href="?content=home.php">Home</a></li>
              <li>My Clinics</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <!-- End Page Banner -->
 <!-- Start Portfolio Section -->
    <!-- Start Content -->
    <div id="content">
      <div class = "container" id = "clinic">
        <!-- Page Content -->
        <div class="page-content">
          <!-- Classic Heading -->
          <h4 class="classic-title"><span>Clinic List</span></h4> 
			<!-- Start Search -->
			<select class = "form-control chosen-select" id = "clinic_type">
				<option value=1>Arts Clinic Bookmark</option>
				<option value=0>Sports Clinic Bookmark</option>
				<option value=2>Arts Clinic Enrolled</option>
				<option value=3>Sports Clinic Enrolled</option>
			</select>
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
									<label for = "forsched_slot">Available Slot: </label>
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
	
	<!-- modal info -->
    <div class="modal fade" id = "modal_info" tabindex="-1" role="dialog">
		<div class="modal-dialog modalinfo">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="title-promo">More Info</h4>
				</div>
				<div class="modal-body">
					<div class = "row">
						<div class="col-md-6 colmd">
							<a class="main-button" href="#" id="ServiceInfo">Services <i class="fa fa-angle-right"></i></a>
							<div id="services-div"> 
								<table id="services_list" class="display" cellspacing="0" width="100%"></table>
							</div>
							<div class="hr5" style="margin-top:10px; margin-bottom:10px;"></div>
							<a class="read-more" href="#" id="ReviewsRatings">View All Reviews and Ratings...<i class="fa fa-angle-right"></i></a>
							<a class="read-more" href="#" id="HideReviewsRatings">Hide Some Reviews and Ratings...<i class="fa fa-angle-right"></i></a>
							<div id="reviewsratings-div">
								test
							</div>
							<form  id="formrate"> 
								 <div class = "form-group">
									<label for = "forrate_message">Comment</label>
									<div class="survey-builder container">
										<span style="cursor: default;">
											<div title="" data-original-title="" style="display: inline-block; position: relative;" class="rating-symbol"><div style="display: inline-block; position: absolute; overflow: hidden; left: 0px; right: 0px; width: 0px;" class="rating-symbol-foreground"><span></span></div></div>
											<div title="" data-original-title="" style="display: inline-block; position: relative;" class="rating-symbol"><div style="display: inline-block; position: absolute; overflow: hidden; left: 0px; right: 0px; width: 0px;" class="rating-symbol-foreground"><span></span></div></div>
											<div title="" data-original-title="" style="display: inline-block; position: relative;" class="rating-symbol"><div style="display: inline-block; position: absolute; overflow: hidden; left: 0px; right: 0px; width: 0px;" class="rating-symbol-foreground"><span></span></div></div>
											<div title="" data-original-title="" style="display: inline-block; position: relative;" class="rating-symbol"><div style="display: inline-block; position: absolute; overflow: hidden; left: 0px; right: 0px; width: 0px;" class="rating-symbol-foreground"><span></span></div></div>
											<div title="" data-original-title="" style="display: inline-block; position: relative;" class="rating-symbol"><div style="display: inline-block; position: absolute; overflow: hidden; left: 0px; right: 0px; width: 0px;" class="rating-symbol-foreground"><span></span></div></div>
										</span>
										<input class="rating-tooltip" type="hidden" id="Rating" name="Rating">
									</div>
									<textarea class = "form-control" id = "Message" name = "Message"></textarea>
									<a class="main-button" href="#" id="SaveComment">Save</a>
								  </div>
							</form>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Exit</button>
						<!--button type="button" id= "btn-Enroll" class="btn btn-primary">Enroll</button-->
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
	</div>
    <!-- end modal -->
	
    <!-- javascripts -->
    <script type="text/javascript" src="assets/js/myclinics.js"></script>
	<script type="text/javascript" src="assets/js/bootstrap-rating.js"></script>