<style>
  #content-services .modal-dialog {
    width 95%; /* or whatever you wish */
  }
</style>
<!-- Start Page Banner -->
    <div class="page-banner no-subtitle">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <h2>Services</h2>
          </div>
          <div class="col-md-6">
            <ul class="breadcrumbs">
              <li><a href="?content=home.php">Home</a></li>
              <li>Services</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <!-- End Page Banner -->

<!-- hidden text boxes -->
<input type = "hidden" id = "action_type"/>
<!-- removing services, set this textbox below of the service id that will be deleted -->
<input type = "hidden" id = "sid"/> 

<!-- update/add indicator for Instructors -->
<input type="hidden" id = "instHiddenVal"/>

<!-- type to delete. 1-services,2-instructors, 3-students -->
<input type="hidden" id = "deleteType"/>

<input type = "hidden" id = "txtHiddenService" value = "">
    <!-- Start Content -->
    <div id="content">
      <div class="container">
        
        <div class="row sidebar-page"> 
            <div class="page-content" id = "content-services">
            <!-- picture -->
            <div class = "col-md-1">
                <div class = "row">
                  <img src="assets/images/<?php echo $clubpic;?>" class="img-circle" style = "width80px; height80px; cursorpointer;" id = "clubimage" data-toggle = "popover" data-placement = "top" title = "Click here to change picture.">
                   <input type="file" name="clubpic" id="clubpic" accept="image/*" style = "display:none"/>
                </div>
                 <!-- end picture -->
              </div>
              <div class = "col-md-4">

                <div class="row">
                  <div class="col-sm-10">
                    <button class="btn btn-primary btn-sm" id="btn-update" data-toggle="tooltip" data-placement="top" title="Save Changes"><span class = "glyphicon glyphicon-floppy-save"></span> </button>
                  </div>
                </div>
              </div>
              <div class="col-md-8">
                <br/>
              <div class="alert" role="alert" style = "displaynone"></div>

                <form class="form-horizontal" id = "form-clinic">
                  
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Clinic Name</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="clinic_name" name = "clinic_name" placeholder="Club Name" value = "<?=ucfirst($data->clinic_name);?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Owner Name </label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" value = "<?=ucfirst($this->session->userdata('name'));?>" disabled>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Location</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="SPLocation" name = "SPLocation" placeholder="Location" value = "<?=ucfirst($data->SPLocation);?>">
                      <span class = "glyphicon glyphicon-map-marker" style = "cursorpointer !important;" data-toggle="tooltip" data-placement="top" title="Click to show map"></span>
                    </div>

                  </div>
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">About Us</label>
                    <div class="col-sm-10">
                      <textarea id = "SPAboutMe" name = "SPAboutMe"><?=ucfirst($data->SPAboutMe);?></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Subscription Type</label>
                    <div class="col-sm-10">
                      <select  id = "SubscType" name = "SubscType" class = "form-control" disabled>
                        <option value="1" <?php echo($data->SubscType==1)?'selected':'';?>>Trial</option>
                        <option value="2" <?php echo($data->SubscType==2)?'selected':'';?>>Premium</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Subscription Plan Expiry Date</label>
                    <div class="col-sm-10">
                      <p><?php echo date('F d Y',strtotime($data->SubscEndDate));?></p>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Subscription Plan Status</label>
                    <div class="col-sm-10">
                      <p><?php 
                      if($data->SubscType==2){
                        if($data->SubsStatus==1 && (strtotime($data->SubscEndDate) > strtotime(date('Y-m-d'))))
                        {
                          echo "<p class='text-success'>Paid</p>";
                        }else if($data->SubsStatus==0){
                          echo "<p class='text-danger'>Unpaid. Please settle your balance for you to Manage Services Module.</p><button class='btn btn-info btn-sm' id='btn-paynow' data-toggle='tooltip' data-placement='top' title='Pay Now'><i class ='fa fa-cc-visa fa-2x'></i>&nbsp;<i class ='fa fa-cc-paypal fa-2x'></i>&nbsp;</i>&nbsp;<i class ='fa fa-credit-card fa-2x'></i>&nbsp;Pay Now</button>";
                        }else{
                          echo "<p class='text-info'>Your subscription has expired. Renew your subscription to continue using this service.</p>";
                        }
                      }else{
                          if(strtotime($data->SubscEndDate) > strtotime(date('Y-m-d'))){

                            $datetime1 = date_create($data->SubscEndDate);
                            $datetime2 = date_create(date('Y-m-d'));
                            $interval = date_diff($datetime2, $datetime1);
                            echo "<p class='text-info'>You have ".$interval->format('%R%a days')." remaining. <button class='btn btn-info btn-sm' id='btn-renew' data-toggle='tooltip' data-placement='top' title='Upgrade/Renew Subscription'><span class ='glyphicon glyphicon-king'></span>&nbsp;Upgrade to Premium</button></p>";
                          }else{
                            echo "<p class='text-danger'>Your Free Trial has expired. You can upgrade your account to Premium to enjoy this service.</p><button class='btn btn-info btn-sm' id='btn-renew' data-toggle='tooltip' data-placement='top' title='Upgrade/Renew Subscription'><span class ='glyphicon glyphicon-king'></span>&nbsp;Upgrade to Premium</button>";
                          }
                      }?></p>
                      
                    </div>
                  </div>
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
	                <li><a href="#tab-5" data-toggle="tab"><i class="fa fa-calendar"></i>Manage Schedules</a></li>
	                <li><a href="#tab-7" data-toggle="tab"><i class="fa fa-map-pin"></i>Manage Rooms</a></li>
	                <li><a href="#tab-6" data-toggle="tab"><i class="fa fa-group"></i>Manage Instructors</a></li>
	              </ul>

	              <!-- Tab panels -->
	            <div class="tab-content">
	                <!-- Tab Content 1 -->
	                <div class="tab-pane fade in active" id="tab-4">
	                <button class="btn btn-primary btn-sm" id="btn-addService" data-toggle="tooltip" data-placement="top" title="Add Services" 
                  <?php
                    if($data->SubscType==2){
                        if($data->SubsStatus==1 && (strtotime($data->SubscEndDate) > strtotime(date('Y-m-d'))))
                        {
                          echo "";
                        }else if($data->SubsStatus==0){
                          echo "disabled";
                        }else{
                          echo "disabled";
                        }
                      }else{
                          if(strtotime($data->SubscEndDate) > strtotime(date('Y-m-d'))){

                            $datetime1 = date_create($data->SubscEndDate);
                            $datetime2 = date_create(date('Y-m-d'));
                            $interval = date_diff($datetime2, $datetime1);
                            echo "";
                          }else{
                            echo "disabled";
                          }
                      }
                  ?>
                  ><i class="fa fa-plus"> Add Services</i></button>
	                <div class="hr1 margin-top"></div>
              			<table id="tbl-services" class="display" cellspacing="0" width="100%"></table>
              		</div>
              		<div class="tab-pane fade in" id="tab-5">
              			<button class="btn btn-primary btn-sm" id="btn-modalSched" data-toggle="tooltip" data-placement="top" title="Add Schedules"
                     <?php
                    if($data->SubscType==2){
                        if($data->SubsStatus==1 && (strtotime($data->SubscEndDate) > strtotime(date('Y-m-d'))))
                        {
                          echo "";
                        }else if($data->SubsStatus==0){
                          echo "disabled";
                        }else{
                          echo "disabled";
                        }
                      }else{
                          if(strtotime($data->SubscEndDate) > strtotime(date('Y-m-d'))){

                            $datetime1 = date_create($data->SubscEndDate);
                            $datetime2 = date_create(date('Y-m-d'));
                            $interval = date_diff($datetime2, $datetime1);
                            echo "";
                          }else{
                            echo "disabled";
                          }
                      }
                  ?>><i class="fa fa-plus"></i> Add Schedules</button>
              			<div class="hr1 margin-top"></div>

              			<table id="tbl-schedules" class="display" cellspacing="0" width="100%"></table>
              		</div>
              		<div class="tab-pane fade in" id="tab-6">
                    <button class="btn btn-primary btn-sm" id="btn-modalInstructor" data-toggle="tooltip" data-placement="top" title="Add Intstructor"
                     <?php
                    if($data->SubscType==2){
                        if($data->SubsStatus==1 && (strtotime($data->SubscEndDate) > strtotime(date('Y-m-d'))))
                        {
                          echo "";
                        }else if($data->SubsStatus==0){
                          echo "disabled";
                        }else{
                          echo "disabled";
                        }
                      }else{
                          if(strtotime($data->SubscEndDate) > strtotime(date('Y-m-d'))){

                            $datetime1 = date_create($data->SubscEndDate);
                            $datetime2 = date_create(date('Y-m-d'));
                            $interval = date_diff($datetime2, $datetime1);
                            echo "";
                          }else{
                            echo "disabled";
                          }
                      }?>><i class="fa fa-plus"></i> Add Instructor</button>
                     <div class="hr1 margin-top"></div>
              			<table id="tbl-insmaterlist" class="display" cellspacing="0" width="100%"></table>
              		</div>
              		<div class="tab-pane fade in" id="tab-7">
                    <button class="btn btn-primary btn-sm" id="btn-modalRoom" data-toggle="tooltip" data-placement="top" title="Add Room"
                     <?php
                    if($data->SubscType==2){
                        if($data->SubsStatus==1 && (strtotime($data->SubscEndDate) > strtotime(date('Y-m-d'))))
                        {
                          echo "";
                        }else if($data->SubsStatus==0){
                          echo "disabled";
                        }else{
                          echo "disabled";
                        }
                      }else{
                          if(strtotime($data->SubscEndDate) > strtotime(date('Y-m-d'))){

                            $datetime1 = date_create($data->SubscEndDate);
                            $datetime2 = date_create(date('Y-m-d'));
                            $interval = date_diff($datetime2, $datetime1);
                            echo "";
                          }else{
                            echo "disabled";
                          }
                      }?>><i class="fa fa-plus"></i> Add Room</button>
                     <div class="hr1 margin-top"></div>
              			<table id="tbl-rooms" class="display" cellspacing="0" width="100%"></table>
              		</div>
              	</div>
              </div>

            <!-- ********** MODAL ************-->
            <!-- modal add Services -->
            <div class="modal fade" id = "modal_addservices" tabindex="-1" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add Service</h4>
                  </div>
                  <input type = "hidden" id = "txtHiddenService" value = "1">
                  <div class="modal-body">
                    <div class = "row">
                    <div class="alert" role="alert" style = "displaynone"></div>
                      <form  id="formaddservice">  
                        <div class="col-md-6">
                          <div class = "form-group">
                            <label for = "ServiceType">Service Type</label>
                            <select class = "form-control chosen-select" onchange="loadInterest(this.value)" id = "serv_type" name = "ServiceType">
                              <option value = "">Please Select Service Type</option>
                              <option value = "0">Sports</option>
                              <option value = "1">Arts</option>
                            </select>
                            <br/>
                            <label for = "interest_id" >Interest List</label>
                            <select class = "form-control chosen-select" id = "interest_id" name = "interest_id">
                              <option value = "">Please select service type to populate this dropdown</option>
                            </select>
                          </div>
                          <div class = "form-group">
                            <label for = "forserv_name">Name</label>
                            <input type = "text" placeholder="Service Name" class = "form-control" id = "ServiceName" name = "ServiceName"/>
                          </div>
                          <div class = "form-group">
                            <label for = "forserv_desc">Description</label>
                            <textarea class = "form-control" id = "ServiceDesc" name = "ServiceDesc"></textarea>
                          </div>
                          <div class = "form-group">
                            <label for = "serv_sched">Schedule</label>
                            <input type="text" placeholder="Schedule" class = "form-control" id = "ServiceSchedule" name = "ServiceSchedule"/>
                          </div>
                        </div>
                        <div class = "col-md-6">
                          <div class = "form-group">
                            <label for = "serv_reg_fee">Registration Fee</label>
                            <input type="text" placeholder="Registration Fee" class = "form-control" id = "ServiceRegistrationFee" name = "ServiceRegistrationFee" onkeypress = "numbersOnly(this.value,this.name)"/>
                          </div>
                          <div class = "form-group">
                            <label for = "serv_walkin">Walk-in/Per Session</label>
                            <input type="text" placeholder="Walk-in/Per Session" class = "form-control" id = "serviceWalkin" name = "serviceWalkin" onkeypress = "numbersOnly(this.value,this.name)"/>
                          </div>
                          <div class = "form-group">
                            <label for = "serv_walkin"># of Hour(s)/Session</label>
                            <input type="text" placeholder="Walk-in/Per Session" class = "form-control" id = "serviceHour" name = "serviceHour" onkeypress = "numbersOnly(this.value,this.name)"/>
                          </div>
                          <div class = "form-group">
                            <label for = "serv_monthly">Monthly Fee</label>
                            <input type="text" placeholder="Monthly Fee" class = "form-control" id = "ServicePrice" name = "ServicePrice" onkeypress = "numbersOnly(this.value,this.name)"/>
                          </div>
                        </div>
                      </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Exit</button>
                    <button type="button" id= "btn-saveServices" class="btn btn-primary"><i class = "fa fa-save fa-fw"></i>Save</button>
                  </div>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
          </div>
            <!-- end modal services-->

            <!-- modal add Schedules -->
            <div class="modal fade" id = "modal_addschedule" tabindex="-1" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add Schedules</h4>
                  </div>
                  <input type = "hidden" id = "txtHiddenSchedule" value = "">
                  <div class="modal-body">
                    <div class = "row">
                    <div class="alert" role="alert" style = "displaynone"></div>
                      <form  id="formaddschedule">  
                      <div class = "col-md-6">
                        <div class = "form-group">
                          
                          <label for = "SchedDate">Days (You can select Multiple)</label>
                              <select type="text" placehoder="Day From" name="SchedDays" id="SchedDays" class = "chosen-select form-control" multiple>
                                <option value = "">Select Days</option>
                                <option value = "Monday">Monday</option>
                                <option value = "Tuesday">Tuesday</option>
                                <option value = "Wednesday">Wednesday</option>
                                <option value = "Thursday">Thursday</option>
                                <option value = "Friday">Friday</option>
                                <option value = "Saturday">Saturday</option>
                                <option value = "Sunday">Sunday</option>
                              </select>
                          </div>
                          <div class = "form-group">
                            <label for = "SchedTime">Start Time </label>
                            <input type = "text" placeholder="Start Time" class = "form-control" id = "startTime" name = "startTime"/>
                          </div>
                          <div class = "form-group">
                            <label for = "SchedTime">End Time </label>
                            <input type = "text" placeholder="End Time" class = "form-control" id = "endTime" name = "endTime"/>
                          </div>
                          <div class = "form-group">
                            <label for = "SchedSlots">Slots</label>
                            <input type="text" placeholder="Slots" class = "form-control" id = "SchedSlots" name = "SchedSlots" onkeypress = "numbersOnly(this.value,this.name)"/>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class = "form-group">
                            <label for = "ServiceID">Service </label>
                            <select name="ServiceID" id="ServiceID" class = "form-control chosen-select" >
                            </select>
                          </div>
                          <div class = "form-group">
                            <label for = "InstructorID">Instructor</label>
                            <select type="text" class = "chosen-select form-control" id = "InstructorID" name = "InstructorID">
                              <option value = "0">Select Instructor</option>
                            </select>
                          </div>
                          <div class = "form-group">
                            <label for = "RoomID">Room</label>
                            <select class = "chosen-select form-control" id = "RoomID" name = "RoomID">
                            <option value = "0">Select Room</option>
                            </select>
                          </div>
                        </div>
                      </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Exit</button>
                    <button type="button" id= "btn-saveSchedule" class="btn btn-primary"><i class = "fa fa-save fa-fw"></i>Save Schedule</button>
                  </div>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
          </div>
            <!-- end modal schedule-->

            <!-- modal add Instructor -->
            <div class="modal fade" id = "modal_addInstructor" tabindex="-1" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add Instructor</h4>
                  </div>
                  
                  <div class="modal-body">
                    <div class = "row">
                    <div class="alert" role="alert" style = "displaynone"></div>
                      <form  id="formaddInstructor">  
                        <div class="col-md-6">
                          <div class = "form-group">
                            <label for = "MasterInsName">Name </label>
                            <input type = "text" placeholder="Instructor's Name" class = "form-control" id = "MasterInsName" name = "MasterInsName"/>
                          </div>
                          <div class = "form-group">
                            <label for = "MasterInsAddress">Address </label>
                            <textarea class = "form-control" id = "MasterInsAddress" name = "MasterInsAddress"></textarea>
                          </div>
                          <div class = "form-group">
                            <label for = "MasterInsEmail">E-mail </label>
                            <input type="text" placeholder="E-mail" class = "form-control" id = "MasterInsEmail" name = "MasterInsEmail" />
                          </div>
                        </div>
                        <div class = "col-md-6">
                          <div class = "form-group">
                            <label for = "MasterInsEmail">Contact # </label>
                            <input type="text" placeholder="Contact #" class = "form-control" id = "MasterInsContactNo" name = "MasterInsContactNo" onkeypress = "numbersOnly(this.value,this.name)"/>
                          </div>
                          <div class = "form-group">
                            <label for = "MasterInsExpertise">Expertise</label>
                            <textarea placeholder="Expertise" class = "form-control" id = "MasterInsExpertise" name = "MasterInsExpertise"></textarea>
                          </div>
                          <div class = "form-group">
                            <label for = "serv_walkin">Status</label>
                            <select placeholder="Status" class = "form-control chosen-select" id = "MasterInsStatus" name = "MasterInsStatus">
                              <option value = "0">Inactive</option>
                              <option value = "1">Active</option>
                            </select>
                          </div>
                        </div>
                      </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Exit</button>
                    <button type="button" id= "btn-saveInstructor" class="btn btn-primary">Save Instructor</button>
                  </div>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
          </div>
            <!-- end Intstructor modal -->

            
            <!-- END MODAL -->
          </div>
        </div>
      </div>
    </div>

    <!-- modal add Room -->
      <div class="modal fade" id = "modal_addRoom" tabindex="-1" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Add Room</h4>
            </div>
            
            <div class="modal-body">
              <div class = "row" style ="margin3%">
                <form  id="formaddRoom">  
                    <div class = "form-group">
                      <label for = "RoomNo">Room # </label>
                      <input type = "text" placeholder="Room #" class = "form-control" id = "RoomNo" name = "RoomNo" onkeypress = "numbersOnly(this.value,this.name)"/>
                    </div>
                    <div class = "form-group">
                      <label for = "RoomName">Room Name </label>
                      <input type="text" class = "form-control" id = "RoomName" name = "RoomName" placeholder = "Room Name"/>
                    </div>
                    <div class = "form-group">
                      <label for = "RoomStatus">Status</label>
                      <select placeholder="Status" class = "form-control chosen-select" id = "RoomStatus" name = "RoomStatus">
                        <option value = "0">Inactive</option>
                        <option value = "1">Active</option>
                      </select>
                    </div>
                </form>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Exit</button>
              <button type="button" id= "btn-saveRoom" class="btn btn-primary">Save Room</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->
    </div>
  <!-- end Room modal -->

  <!-- modal add Payment method -->
      <div class="modal fade" id = "modal_payment" tabindex="-1" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Choose Payment Option</h4>
            </div>
            
            <div class="modal-body">
              <div class = "row" style ="margin3%">
                <form  id="formpaymentMethod">  
                  <div class="tabs-section" id = "tab-management">
                    <!-- Nav Tabs -->
                    <ul class="nav nav-tabs">
                      <li class="active"><a href="#tab-creditcard" data-toggle="tab"><i class="fa fa-credit-card"></i>Credit Card</a></li>
                      <li><a href="#tab-paypal" data-toggle="tab"><i class="fa fa-paypal"></i>Paypal</a></li>
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
                              <input type="text" class = "form-control" id = "expdateyear" name = "expdateyear" placeholder = "yy" maxlength = "4"/>
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
    <!-- End Content -->
    <!-- javascripts -->
    <script type="text/javascript" src="assets/js/services.js"></script>
