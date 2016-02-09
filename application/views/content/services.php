<style>
  .modal-dialog {
    width: 95%; /* or whatever you wish */
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

    <!-- Start Content -->
    <div id="content">
      <div class="container">
        
        <div class="row sidebar-page"> 
            <div class="page-content" id = "content-services">
            <!-- picture -->
            <div class = "col-md-1">
                <div class = "row">
                  <img src="assets/images/<?php echo $clubpic;?>" class="img-circle" style = "width:80px; height:80px; cursor:pointer;" id = "clubimage" data-toggle = "popover" data-placement = "top" title = "Click here to change picture.">
                   <input type="file" name="clubpic" id="clubpic" accept="image/*" style = "display:none"/>
                </div>
                 <!-- end picture -->
              </div>
              <div class = "col-md-4">

                <div class="row">
                  <div class="col-sm-10">
                    <button class="btn btn-primary btn-sm" id="btn-update" data-toggle="tooltip" data-placement="top" title="Save Changes"><span class = "glyphicon glyphicon-floppy-save"></span> </button>
                    <button class="btn btn-info btn-sm" id="btn-renew" data-toggle="tooltip" data-placement="top" title="Upgrade/Renew Subscription"><span class = "glyphicon glyphicon-king"></span> </button>
                     <form id="myContainer" method="post" action="/checkout"></form>
                  </div>
                </div>
              </div>
              <div class="col-md-8">
                <br/>
              <div class="alert" role="alert" style = "display:none"></div>

                <form class="form-horizontal" id = "form-clinic">
                  
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Clinic Name</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="clinic_name" name = "clinic_name" placeholder="Club Name" value = "<?=$data->clinic_name;?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Owner Name: </label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" value = "<?=$this->session->userdata('name');?>" disabled>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Location</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="SPLocation" name = "SPLocation" placeholder="Location" value = "<?=$data->SPLocation;?>">
                      <span class = "glyphicon glyphicon-map-marker" style = "cursor:pointer !important;" data-toggle="tooltip" data-placement="top" title="Click to show map"></span>
                    </div>

                  </div>
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">About Us</label>
                    <div class="col-sm-10">
                      <textarea id = "SPAboutMe" name = "SPAboutMe"><?=$data->SPAboutMe;?></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Subscription Type</label>
                    <div class="col-sm-10">
                      <select  id = "SubscType" name = "SubscType" class = "form-control">
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
                          echo "<p class='text-danger'>Unpaid. Please settle your balance for you to Manage Services Module.</p>";
                        }else{
                          echo "<p class='text-info'>Your subscription has expired. Renew your subscription to continue using this service.</p>";
                        }
                      }else{
                          if(strtotime($data->SubscEndDate) > strtotime(date('Y-m-d'))){

                            $datetime1 = date_create($data->SubscEndDate);
                            $datetime2 = date_create(date('Y-m-d'));
                            $interval = date_diff($datetime2, $datetime1);
                            echo "<p class='text-info'>You have ".$interval->format('%R%a days')." remaining</p>";
                          }else{
                            echo "<p class='text-danger'>Your Free Trial has expired. You can upgrade your account to Premium to enjoy this service.</p>";
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
	                <li><a href="#tab-6" data-toggle="tab"><i class="fa fa-map-pin"></i>Manage Rooms</a></li>
	                <li><a href="#tab-7" data-toggle="tab"><i class="fa fa-group"></i>Manage Instructors</a></li>
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
              			<table id="tbl-rooms" class="display" cellspacing="0" width="100%"></table>
              		</div>
              		<div class="tab-pane fade in" id="tab-7">
              			<table id="tbl-rooms" class="display" cellspacing="0" width="100%"></table>
              		</div>
              	</div>
              </div>

          </div>
        </div>
      </div>
    </div>
    <!-- End Content -->
    <!-- modal dialog for view students and instructors -->
    <div class="modal fade" id = "modal_viewlist" tabindex="-1" role="dialog" >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">View Students and Instructors</h4>
          </div>
          <div class="modal-body">
            <div id = "studentattendancelog" style= "display:none">
              <button id = "btn-backtotab" class="btn btn-primary"><span class = "glyphicon glyphicon-arrow-left"></span>back to list</button>
              <table id="example9" class="display" cellspacing="0" width="100%">
                  <thead>
                      <tr>
                          <th>Date</th>
                          <th>Time In</th>
                          <th>Time Out</th>
                          <th>Status</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                          <td>January 01, 2016</td>
                          <td>09:00am</td>
                          <td>12:00pm</td>
                          <td>Present</td>
                      </tr>
                      <tr>
                          <td>January 02, 2016</td>
                          <td>-</td>
                          <td>-</td>
                          <td>Absent</td>
                      </tr>
                      <tr>
                          <td>January 03, 2016</td>
                          <td>-</td>
                          <td>-</td>
                          <td>Absent</td>
                      </tr>
                     
                  </tbody>
              </table>
            </div>
            <div class="tabs-section" id = "studentsInstructor_tab">

              <!-- Nav Tabs -->
              <ul class="nav nav-tabs">
                <li class="active"><a href="#tab-1" data-toggle="tab"><i class="fa fa-desktop"></i>Students</a></li>
                <li><a href="#tab-2" data-toggle="tab"><i class="fa fa-leaf"></i>Instructors</a></li>
              </ul>

              <!-- Tab panels -->
              <div class="tab-content">
                <!-- Tab Content 1 -->
                <div class="tab-pane fade in active" id="tab-1">
                  <table id="example7" class="display" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Age</th>
                                <th>Member Since</th>
                                <th>Client</th>
                                <th>Status</th>
                                <th>Time In</th>
                                <th>Time Out</th>
                                <th>Paid Today ?</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>John Doe 1</td>
                                <td>Cebu City</td>
                                <td>12</td>
                                <td>December 01, 2015</td>
                                <td>John Doe</td>
                                <td>Regular</td>
                                <td>January 21, 2016 08:00am</td>
                                <td>-</td>
                                <td>Yes</td>
                                <td><button class = "btn btn-primary btn-attendance btn-xs" data-toggle="tooltip" data-placement="top" title="View Attendance History"><span class = "glyphicon glyphicon-calendar"></span></button>
                                  <button class = "btn btn-info btn-paymentlog btn-xs" data-toggle="tooltip" data-placement="top" title="Payment Logs"><span class = "glyphicon glyphicon-piggy-bank"></span></button>
                                  <button class = "btn btn-warning btn-timeinout btn-xs" data-toggle="tooltip" data-placement="top" title="Time in & out"><span class = "glyphicon glyphicon-time"></span></button>
                                  <button class = "btn btn-warning btn-timeinout btn-xs" data-toggle="tooltip" data-placement="top" title="Mark As Paid"><span class = "glyphicon glyphicon-usd"></span></button>
                                </td>
                            </tr>
                            <tr>
                                <td>John Doe 2</td>
                                <td>Cebu City</td>
                                <td>12</td>
                                <td>December 01, 2015</td>
                                <td>John Doe</td>
                                <td>Regular</td>
                                <td>January 21, 2016 08:00am</td>
                                <td>-</td>
                                <td>No</td>
                                <td><button class = "btn btn-primary btn-attendance btn-xs" data-toggle="tooltip" data-placement="top" title="View Attendance History"><span class = "glyphicon glyphicon-calendar"></span></button>
                                  <button class = "btn btn-info btn-paymentlog btn-xs" data-toggle="tooltip" data-placement="top" title="Payment Logs"><span class = "glyphicon glyphicon-piggy-bank"></span></button>
                                  <button class = "btn btn-warning btn-timeinout btn-xs" data-toggle="tooltip" data-placement="top" title="Time in & out"><span class = "glyphicon glyphicon-time"></span></button>
                                <button class = "btn btn-warning btn-timeinout btn-xs" data-toggle="tooltip" data-placement="top" title="Mark As Paid"><span class = "glyphicon glyphicon-usd"></span></button>
                              </td>
                            </tr>
                            <tr>
                                <td>John Doe 3</td>
                                <td>Cebu City</td>
                                <td>12</td>
                                <td>December 01, 2015</td>
                                <td>John Doe</td>
                                <td>Regular</td>
                                <td>January 21, 2016 08:00am</td>
                                <td>-</td>
                                <td>No</td>

                                <td><button class = "btn btn-primary btn-attendance btn-xs" data-toggle="tooltip" data-placement="top" title="View Attendance History"><span class = "glyphicon glyphicon-calendar"></span></button>
                                  <button class = "btn btn-info btn-paymentlog btn-xs" data-toggle="tooltip" data-placement="top" title="Payment Logs"><span class = "glyphicon glyphicon-piggy-bank"></span></button>
                                  <button class = "btn btn-warning btn-timeinout btn-xs" data-toggle="tooltip" data-placement="top" title="Time in & out"><span class = "glyphicon glyphicon-time"></span></button>
                                  <button class = "btn btn-warning btn-timeinout btn-xs" data-toggle="tooltip" data-placement="top" title="Mark As Paid"><span class = "glyphicon glyphicon-usd"></span></button>
                                </td>
                            </tr>
                           
                        </tbody>
                    </table>
                </div>
                <!-- Tab Content 2 -->
                <div class="tab-pane fade" id="tab-2" id = "instructor-tab">
                  
                  <?php if($this->session->userdata('usertype') == 1){?>
                  <h4 class="classic-title"><span>Add Instructor</span></h4>
                     <div class="col-sm-10">
                        <button class="btn btn-primary btn-sm" id="btn-addInstructor" data-toggle="tooltip" data-placement="top" title="Save"><span class = "glyphicon glyphicon-floppy-save"></span></button>
                      </div>
                      <!-- Divider -->
                    <div class="hr5" style="margin-top:30px; margin-bottom:45px;"></div>
                   
                  <div class = "row">
                    <div class="alert" role="alert" style = "display:none"></div>
                      <form  id="formaddinstructor">  
                        <div class="col-md-6">
                          <div class = "form-group">
                            <label for = "service_id">Select Service :</label>
                            <select class = "form-control" id = "service_id" name = "service_id">
                            </select>
                          </div>
                          <div class = "form-group">
                            <label for = "ins_name">Name :</label>
                            <input type = "text" placeholder="Instructor Name" class = "form-control" id = "ins_name" name = "ins_name"/>
                          </div>
                          <div class = "form-group">
                            <label for = "ins_slot">Slots :</label>
                            <input type = "text" placeholder="Slots" class = "form-control" id = "ins_slot" name = "ins_slot"/>
                          </div>
                        </div>
                        <div class = "col-md-6">
                          <div class = "form-group">
                            <label for = "ins_sched">Schedule :</label>
                            <input type = "text" placeholder= "Instructor's Schedule" class = "form-control" id = "ins_schedule" name = "ins_schedule"/>
                          </div>
                          <div class = "form-group">
                            <label for = "serv_sched">Room :</label>
                            <input type="text" placeholder="Room" class = "form-control" id = "ins_room" name = "ins_room"/>
                          </div>
                          <div class = "form-group">
                            <label for = "serv_sched">Room :</label>
                            <select class = "form-control" id = "ins_status" name = "ins_status">
                              <option value = "1">Active</option>
                              <option value = "0">Inactive</option>
                            </select>
                          </div>
                        </div>
                      </form>
                  </div>
                  <?php } ?>
                  <table id="tbl-instructor" class="display" cellspacing="0" width="100%">
                  </table>
                </div>
               
              </div>
              <!-- End Tab Panels -->
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- end modal -->

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
            <div class="alert" role="alert" style = "display:none"></div>
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
                    <select class = "form-control" id = "interest_id" name = "interest_id">
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
                    <input type="text" placeholder="Registration Fee" class = "form-control" id = "ServiceRegistrationFee" name = "ServiceRegistrationFee"/>
                  </div>
                  <div class = "form-group">
                    <label for = "serv_walkin">Walk-in/Per Session</label>
                    <input type="text" placeholder="Walk-in/Per Session" class = "form-control" id = "serviceWalkin" name = "serviceWalkin"/>
                  </div>
                  <div class = "form-group">
                    <label for = "serv_walkin"># of Hour(s)/Session</label>
                    <input type="text" placeholder="Walk-in/Per Session" class = "form-control" id = "serviceHour" name = "serviceHour"/>
                  </div>
                  <div class = "form-group">
                    <label for = "serv_monthly">Monthly Fee</label>
                    <input type="text" placeholder="Monthly Fee" class = "form-control" id = "ServicePrice" name = "ServicePrice"/>
                  </div>
                </div>
              </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Exit</button>
            <button type="button" id= "btn-saveServices" class="btn btn-primary">Save</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  </div>
    <!-- end modal --><!-- modal add Schedules -->
    <div class="modal fade" id = "modal_addschedule" tabindex="-1" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Add Schedules</h4>
          </div>
          <input type = "hidden" id = "txtHiddenSchedule" value = "1">
          <div class="modal-body">
            <div class = "row">
            <div class="alert" role="alert" style = "display:none"></div>
              <form  id="formaddschedule">  
                <div class="col-md-6">
                  <div class = "form-group">
                    <label for = "ServiceID">Service :</label>
                    <select name="ServiceID" id="ServiceID" class = "form-control" >
                    </select>
                  </div>
                  <div class = "form-group">
                    <label for = "SchedDate">Date :</label>
                    <input type="text" placehoder="Date" name="SchedDate" id="SchedDate" class = "form-control" />
                  </div>
                  <div class = "form-group">
                    <label for = "SchedTime">Start Time :</label>
                    <input type = "text" placeholder="Start Time" class = "form-control" id = "startTime" name = "startTime"/>
                  </div>
                  <div class = "form-group">
                    <label for = "SchedTime">End Time :</label>
                    <input type = "text" placeholder="End Time" class = "form-control" id = "endTime" name = "endTime"/>
                  </div>
                  <div class = "form-group">
                    <label for = "RoomID">Room</label>
                    <select class = "form-control" id = "RoomID" name = "RoomID">
                    <option value = "0">Select Room</option>
                    </select>
                  </div>
                  <div class = "form-group">
                    <label for = "InstructorID">Instructor</label>
                    <select type="text" class = "form-control" id = "InstructorID" name = "InstructorID">
                      <option value = "0">Select Instructor</option>
                    </select>
                  </div>
                </div>
                <div class = "col-md-6">
                  <div class = "form-group">
                    <label for = "SchedSlots">Slots</label>
                    <input type="text" placeholder="Slots" class = "form-control" id = "SchedSlots" name = "SchedSlots"/>
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
    <!-- end modal -->

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
            <div class="alert" role="alert" style = "display:none"></div>
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
                    <select class = "form-control" id = "interest_id" name = "interest_id">
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
                    <input type="text" placeholder="Registration Fee" class = "form-control" id = "ServiceRegistrationFee" name = "ServiceRegistrationFee"/>
                  </div>
                  <div class = "form-group">
                    <label for = "serv_walkin">Walk-in/Per Session</label>
                    <input type="text" placeholder="Walk-in/Per Session" class = "form-control" id = "serviceWalkin" name = "serviceWalkin"/>
                  </div>
                  <div class = "form-group">
                    <label for = "serv_walkin"># of Hour(s)/Session</label>
                    <input type="text" placeholder="Walk-in/Per Session" class = "form-control" id = "serviceHour" name = "serviceHour"/>
                  </div>
                  <div class = "form-group">
                    <label for = "serv_monthly">Monthly Fee</label>
                    <input type="text" placeholder="Monthly Fee" class = "form-control" id = "ServicePrice" name = "ServicePrice"/>
                  </div>
                </div>
              </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Exit</button>
            <button type="button" id= "btn-saveServices" class="btn btn-primary">Save</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  </div>
    <!-- end modal -->
    <!-- javascripts -->
    <script type="text/javascript" src="assets/js/services.js"></script>
