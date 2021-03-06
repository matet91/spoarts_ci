<style>
  #content-services .modal-dialog {
    width 95%; /* or whatever you wish */
  } 
  #modal_instructor_sched .modal-dialog{
    width:900px; /* or whatever you wish */
  }

</style>
<link href='assets/fullcalendar/fullcalendar.css' rel='stylesheet' />
<link href='assets/fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
 <link rel="stylesheet" href="assets/css/bootstrap-rating.css" type="text/css" media="screen">
<?php $usertype = $this->session->userdata('usertype');?>
<input type = "hidden" id = "usertype" value = "<?=$usertype;?>">
<input type = "hidden" id = "Service">
<!-- Start Page Banner -->
    <div class="page-banner no-subtitle">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <h2><?=ucfirst($data->clinic_name);?></h2>
          </div>
          <div class="col-md-6">
            <ul class="breadcrumbs">
              <li><a href="?content=home.php">Home</a></li>
              <li><?=ucfirst($data->clinic_name);?></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <!-- End Page Banner -->
<div id="map"></div>
   
<!-- hidden text boxes -->
<input type = "hidden" id = "spid" value = "<?=$this->input->get('susid');?>"/>
    <!-- Start Content -->
    <div id="content">
      <div class="container">
        
        <div class="row sidebar-page"> 
            <div class="page-content" id = "content-services">
            <!-- picture -->
            <div class = "col-md-1">
                <div class = "row">
                  <img src="assets/images/<?php echo $clubpic;?>" class="img-circle" style = "width:80px; height:80px; cursorpointer;" id = "clubimage" data-toggle = "popover" data-placement = "top" title = "Click here to change picture.">
                   <input type="file" name="clubpic" id="clubpic" accept="image/*" style = "display:none"/>
                </div>
                 <!-- end picture -->
              </div>
              <div class = "col-md-4">

                <div class="row">
                  <div class="col-sm-10">
                  </div>
                </div>
              </div>
              <div class="col-md-8">
                <br/>
              <div class="alert" role="alert" style = "displaynone"></div>
                <h4 class="classic-title"><span>About Us</span></h4>
                <form class="form-horizontal" id = "form-clinic">
                  <p ><?=ucfirst($data->SPAboutMe);?></p>
                    <ul class="icons-list">
                      <li><i class="fa fa-home">  </i> <strong>Clinic Name :</strong> <?=ucfirst($data->clinic_name);?></li>
                      <li><i class="fa fa-user">  </i> <strong>Owner :</strong> <?=ucfirst($data->spfirstname)." ".ucfirst($data->splastname);?></li>
                      <li><i class="fa fa-globe">  </i> <strong>Address :</strong> <?=ucfirst($data->SPLocation);?></li>
                      <li><i class="fa fa-envelope-o"></i> <strong>Email :</strong> <?=$data->SPEmail;?></li>
                      <li><i class="fa fa-mobile"></i> <strong>Phone :</strong> <?=$data->SPContactNo;?></li>
                     
                    
                      <input type="hidden" class="form-control" id="SPLocation" name = "SPLocation" placeholder="Location" value = "<?=ucfirst($data->SPLocation);?>" disabled>
                      <input type="hidden" class="form-control" id="latitude" name = "latitude" value="<?php echo $data->latitude;?>">
                      <input type="hidden" class="form-control" id="longitude" name = "longitude" value="<?php echo $data->longitude;?>">

                  <?php if($usertype == 0){?>
                   <li></i> <strong>Subscription:</strong> <?=$data->PlanName;?></li>
                   <li></i> <strong>Subscription Plan Expiry Date :</strong> <?php echo date('F d Y',strtotime($data->SubscEndDate));?></li>
                  <li></i><strong>Subscription Plan Status :</strong> 
                      <?php 
                      if($data->SubscType==2){
                        if($data->SubsStatus==1 && (strtotime($data->SubscEndDate) > strtotime(date('Y-m-d'))))
                        {
                           $datetime1 = date_create($data->SubscEndDate);
                            $datetime2 = date_create(date('Y-m-d'));
                            $interval = date_diff($datetime2, $datetime1);
                          echo "<span class='text-success'>Paid. <span class='text-info'> ".$interval->format('%R%a days')." remaining.</span></span>";
                        }else if($data->SubsStatus==0){
                          echo "<span class='text-danger'>Unpaid.</p><button class='btn btn-info btn-sm' id='btn-paynow' data-toggle='tooltip' data-placement='top' title='Pay Now'><i class ='fa fa-cc-visa fa-2x'></i>&nbsp;<i class ='fa fa-cc-paypal fa-2x'></i>&nbsp;</i>&nbsp;<i class ='fa fa-credit-card fa-2x'></i>&nbsp;Pay Now</button>";
                        }else{
                          echo "<p class='text-info'>Subscription has expired.</p>";
                        }
                      }else{
                          if(strtotime($data->SubscEndDate) > strtotime(date('Y-m-d'))){

                            $datetime1 = date_create($data->SubscEndDate);
                            $datetime2 = date_create(date('Y-m-d'));
                            $interval = date_diff($datetime2, $datetime1);
                            echo "<span class='text-info'>".$interval->format('%R%a days')." remaining. <button class='btn btn-info btn-sm' id='btn-paynow' data-toggle='tooltip' data-placement='top' title='Upgrade/Renew Subscription'><span class ='glyphicon glyphicon-king'></span>&nbsp;Upgrade to Premium</button></span>";
                          }else{
                            echo "<span class='text-danger'>Trial has expired.</span><button class='btn btn-info btn-sm' id='btn-paynow' data-toggle='tooltip' data-placement='top' title='Upgrade/Renew Subscription'><span class ='glyphicon glyphicon-king'></span>&nbsp;Upgrade to Premium</button>";
                          }
                      }?>
                  <?php } ?>
                  </ul>
                </form>
              </div>
              <!-- Divider -->
              <div class = "row">
                <div class="hr1 margin-top"></div>
                <div class="col-sm-10">
                  &nbsp;
                  
                </div>
                <!-- Divider -->
                <div class="hr1 margin-top"></div>
              </div>
              <br/>
              <div class="tabs-section" id = "tab-management">

              <!-- Nav Tabs -->
	              <ul class="nav nav-tabs">
	                <li class="active"><a href="#tab-4" data-toggle="tab"><i class="fa fa-desktop"></i>Services</a></li>
					<li><a href="#tab-5" data-toggle="tab"><i class="fa fa-picture-o"></i>Gallery</a></li>
					<li><a href="#tab-6" data-toggle="tab"><i class="fa fa-calendar"></i>Events</a></li>
					<li><a href="#tab-7" data-toggle="tab"><i class="fa fa-gift"></i>Promos</a></li>
	                <li><a href="#tab-8" data-toggle="tab"><i class="fa fa-star"></i>Reviews & Ratings</a></li>
					<li><a href="#tab-11" data-toggle="tab"><i class="fa fa-group"></i>Instructor MasterList</a></li>
	              <?php if($usertype == 0){?> <li><a href="#tab-9" data-toggle="tab"><i class="fa fa-group"></i>Clients</a></li>
					<li><a href="#tab-10" data-toggle="tab"><i class="fa fa-group"></i>Enrolled Students</a></li>
                 <?php } ?>
	              </ul>

	              <!-- Tab panels -->
	            <div class="tab-content">
	                <!-- Tab Content 1 -->
	                <div class="tab-pane fade in active" id="tab-4">
	                <div class="hr1 margin-top"></div>
              			<table id="tbl-services" class="display" cellspacing="0" width="100%"></table>
              		</div>
              		<div class="tab-pane fade in" id="tab-5">
              			<div class="recent-projects">
                      <div id = "albumDisplay">

                      </div>
                      <div class="hr5" style="margin-top:45px; margin-bottom:35px;"></div>
                      <div id="gallerydisplay" class = "touch-carousel" style = "display:none"></div>

                    </div>
                  </div>
                  <div class="tab-pane fade in" id="tab-6">
                     <div id='calendar_events'></div>
                     <input type = "hidden" id = "EventID" name = "EventID"/>
                  </div>
              		<div class="tab-pane fade in" id="tab-7">
                     <div class="row latest-posts-classic" id = "tab-promo">
                    </div>

                    <!-- Divider -->
                    <div class="hr1" style="margin-bottom:30px;"></div>
                  </div>
                  <div class="tab-pane fade in" id="tab-8">
                        <input type = "hidden" id = "clinicname" value = "<?=$data->clinic_name;?>">
                        <input type = "hidden" id = "clinicid" value = "<?=$data->clinic_id?>">
                        <div class="hr5" style="margin-top:10px; margin-bottom:10px;"></div>
                        <a class="read-more" href="#" id="ReviewsRatings">View All Reviews and Ratings...<i class="fa fa-angle-right"></i></a>
                        <a class="read-more" href="#" id="HideReviewsRatings">Hide Some Reviews and Ratings...<i class="fa fa-angle-right"></i></a>
                        <div id="reviewsratings-div">
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
                            <div class="hr1" style="margin-bottom:30px;"></div>
                            <a class="main-button" href="#" id="SaveComment">Save</a>
                            </div>
                        </form>

                    <!-- Divider -->
                    <div class="hr1" style="margin-bottom:30px;"></div>
                  </div>
                  <div class="tab-pane fade in" id="tab-9">
                    <table id="tbl-client" class="display" cellspacing="0" width="100%"></table>
                    <!-- Divider -->
                    <div class="hr1" style="margin-bottom:30px;"></div>
                  </div>
                  <div class="tab-pane fade in" id="tab-10">
                    <table id="tbl-enrolled" class="display" cellspacing="0" width="100%"></table>
                    <!-- Divider -->
                    <div class="hr1" style="margin-bottom:30px;"></div>
                  </div>
                  <div class="tab-pane fade in" id="tab-11">
                    <table id="tbl-ins_masterlist" class="display" cellspacing="0" width="100%"></table>
                    <!-- Divider -->
                    <div class="hr1" style="margin-bottom:30px;"></div>
                  </div>
                </div>
                      <!-- End Recent Posts Carousel -->

                      <!-- Divider -->
                      <div class="hr1" style="margin-bottom:30px;"></div>
              		</div>
              </div>
              </div>
              </div>
</div>
  <!-- modal add Payment method -->
      <div class="modal fade" id = "modal_payment" tabindex="-1" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Upgrade to Premium</h4>
            </div>
            
            <div class="modal-body">
              <div class = "row" style ="margin:3%">
                <form  id="formpaymentMethod">  
                  <div class="tabs-section" id = "tab-management">
                    <!-- Nav Tabs -->
                    <ul class="nav nav-tabs">
                      <li class="active"><a href="#tab-creditcard" data-toggle="tab"><i class="fa fa-credit-card"></i>Credit Card</a></li>
                    </ul>
                    <!-- Tab panels -->
                  <div class="tab-content">
                      <!-- Tab Content 1 -->
                      <div class="tab-pane fade in active" id="tab-creditcard">
                        <div class = "form-group">
                          <label for = "cardno">Card Number </label>
                          <input type = "text" placeholder="Card Number" class = "form-control" onkeypress = "numbersOnly(this.value,this.name)" id = "cardno" name = "cardno"/>
                        </div>
                        <div class = "form-group">
                          <label for = "cardholdername">Cardholder's Name </label>
                          <div class = "row">
                            <div class = "col-md-4">
                              <input type="text" class = "form-control" id = "cfirstname" name = "cfirstname" placeholder = "First Name"/>
                            </div>
                            <div class = "col-md-4">
                              <input type="text" class = "form-control" id = "clastname" name = "clastname" placeholder = "Last Name"/>
                            </div>
                          </div>
                        </div>
                        <div class = "form-group">

                          <label for = "cardholdername">Expiry Date </label><br/>
                          <div class = "row">
                            <div class = "col-md-4">
                              <input type="text" class = "form-control" id = "expdatemonth" name = "expdatemonth" placeholder = "mm" onkeypress = "numbersOnly(this.value,this.name)" maxlength="2"/>
                            </div>

                            <div class = "col-md-4">
                              <input type="text" class = "form-control" id = "expdateyear" name = "expdateyear" placeholder = "yyyy" maxlength = "4"/>
                            </div>
                          </div>
                        </div>
                        <div class = "form-group">
                          <label for = "ccv">CCV / CCV </label>
                          <input type="text" class = "form-control" id = "ccv" name = "ccv" placeholder = "" onkeypress = "numbersOnly(this.value,this.name)" maxlength = "4"/>
                        </div>
                      </div>
                      <div class="tab-pane fade in" id="tab-paypal">
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Exit</button>
              <button type="button" id= "btn-checkout" class="btn btn-primary">Continue</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->
    </div>
  <!-- end payment method modal -->

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
                <div class = "form-group" id="schedform">
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
                  <div class = "form-group">
						<label for = "forsched_slot">Relationship</label>
						<select class = "form-control chosen-select" id = "relationship" name = "relationship">
							<option value="Mother">Mother</option>
							<option value="Father">Father</option>
							<option value="Brother">Brother</option>
							<option value="Sister">Sister</option>
							<option value="Son">Son</option>
							<option value="Daughter">Daughter</option>
							<option value="Wife">Wife</option>
							<option value="Husband">Husband</option>
							<option value="Relative">Relative</option>
						</select>
					  </div>
                  <input type="hidden" class = "form-control" id = "service_id" name = "service_id" />
                  <input type = "hidden" id = "clinic_id" name = "clinic_id" value = "<?=$data->clinic_id?>">
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
    <!-- javascripts -->
<!-- modal enroll -->
    <div class="modal fade" id = "modal_enroll_event" tabindex="-1" role="dialog">
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
                <select class = "form-control chosen-select" id = "StudType1"><option value=0>New</option><option value=1>Existing</option><option value=2>Client</option></select>
                </div>
                <div id="stud-exist1" style="display:none"> 
                  <label for = "forsched_name">Student</label>
                  <select class = "form-control chosen-select" id = "stud_id1" name = "stud_id1"></select>
                </div>
                <div id="stud-new1">
                  <div class = "form-group">
                  <label for = "forsched_name">Name</label>
                  <input type="text" class = "form-control" id = "stud_name1" name = "stud_name1" />
                  </div>
                  <div class = "form-group">
                  <label for = "forsched_instructor">Age</label>
                  <input type="text" class = "form-control" id = "stud_age1" name = "stud_age1" />
                  </div>
                  <div class = "form-group">
                  <label for = "forsched_slot">Address</label>
                  <input type="text" class = "form-control" id = "stud_address1" name = "stud_address1" />
                  </div>
                  <div class = "form-group">
						<label for = "forsched_slot">Relationship</label>
						<select class = "form-control chosen-select" id = "relationship1" name = "relationship1">
							<option value="Mother">Mother</option>
							<option value="Father">Father</option>
							<option value="Brother">Brother</option>
							<option value="Sister">Sister</option>
							<option value="Son">Son</option>
							<option value="Daughter">Daughter</option>
							<option value="Wife">Wife</option>
							<option value="Husband">Husband</option>
							<option value="Relative">Relative</option>
						</select>
					  </div>
                  <input type="hidden" class = "form-control" id = "SPID1" name = "SPID1" value = "<?=$data->clinic_id?>"/>
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
	
	<!-- modal enroll -->
    <div class="modal fade" id = "modal_instructor_sched" tabindex="-1" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="title-promo">Instructor's Schedule</h4>
        </div>
        <div class="modal-body">
          <div class = "row">
				<div id="calendar_instructor_sched"></div>
				<form id="forminstructorenroll" style="display:none">
				  <div class="col-md-6">
					<div class = "form-group">
					<label for = "forsched_name">Student Type</label>
					<select class = "form-control chosen-select" id = "StudTypeins"><option value=0>New</option><option value=1>Existing</option><option value=2>Client</option></select>
					</div>
					<div id="stud-existins" style="display:none"> 
					  <label for = "forsched_name">Student</label>
					  <select class = "form-control chosen-select" id = "stud_idins" name = "stud_idins"></select>
					</div>
					<div id="stud-newins">
					  <div class = "form-group">
					  <label for = "forsched_name">Name</label>
					  <input type="text" class = "form-control" id = "stud_nameins" name = "stud_nameins" />
					  </div>
					  <div class = "form-group">
					  <label for = "forsched_instructor">Age</label>
					  <input type="text" class = "form-control" id = "stud_ageins" name = "stud_ageins" />
					  </div>
					  <div class = "form-group">
					  <label for = "forsched_slot">Address</label>
					  <input type="text" class = "form-control" id = "stud_addressins" name = "stud_addressins" />
					  </div>
					  <div class = "form-group">
						<label for = "forsched_slot">Relationship</label>
						<select class = "form-control chosen-select" id = "relationshipins" name = "relationshipins">
							<option value="Mother">Mother</option>
							<option value="Father">Father</option>
							<option value="Brother">Brother</option>
							<option value="Sister">Sister</option>
							<option value="Son">Son</option>
							<option value="Daughter">Daughter</option>
							<option value="Wife">Wife</option>
							<option value="Husband">Husband</option>
							<option value="Relative">Relative</option>
						</select>
					  </div>
					</div>
				  </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Exit</button>
            <button type="button" id= "btn-InstructorEnroll" class="btn btn-primary" style="display:none">Enroll</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  </div>
    <!-- end modal -->
  <script type="text/javascript" src="assets/js/sp_profile.js"></script>
<script>
function maps(){
    var lat = parseFloat($("#latitude").val()),
      infowindow = new google.maps.InfoWindow({
        content: $("#SPLocation").val()
      }),
      long = parseFloat($("#longitude").val()),
      myLatLng = {lat: lat, lng: long},
      originalMapCenter = new google.maps.LatLng(lat, long);
      mapDiv = document.getElementById('map'),
      map = new google.maps.Map(mapDiv, {
          center: originalMapCenter,
          zoom: 16
        }),
        marker = new google.maps.Marker({
          position: originalMapCenter,
          map: map,
          title: $("#SPLocation").val(),
        });
        map.panTo(marker.getPosition());
       marker.addListener('click', function() {
        infowindow.open(marker.get('map'), marker);
      });
}

</script>


<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAoJ0WgzkdpMew-6H3IB1JpVk8Gq_Sxxl0&signed_in=true&sensor=false&libraries=places&callback=maps"
         async defer>
</script>
<script src='assets/fullcalendar/lib/moment.min.js'></script>
<!--script src='assets/fullcalendar/lib/jquery.min.js'></script-->
<script src='assets/fullcalendar/fullcalendar.min.js'></script>
<script src='assets/js/jquery.datetimepicker.full.min.js'></script>
<script type="text/javascript" src="assets/js/bootstrap-multiselect.js"></script>
<script type="text/javascript" src="assets/js/bootstrap-rating.js"></script>