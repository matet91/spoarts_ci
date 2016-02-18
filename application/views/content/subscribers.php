<style>
  #subscribers-content .modal-dialog {
    width: 95%; /* or whatever you wish */
  }
</style>


<!-- Start Page Banner -->
    <div class="page-banner no-subtitle">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h2>Manage Subscribers</h2>
				</div>
				<div class="col-md-6">
					<ul class="breadcrumbs">
						<li><a href="?content=home.php">Home</a></li>
						<li>Subscribers</li>
					</ul>
				</div>
			</div>
		</div>
    </div>
    <!-- End Page Banner -->


    <!-- Start Content -->
    <div id="content">
		<div class="container" id = "subscribers-content">
			<div class="row sidebar-page">
				<!-- Page Content -->
				<div class="page-content">
					<!-- Classic Heading -->
					<h4 class="classic-title"><span>Subscribers</span></h4> 
					
					<!-- Divider -->
					<div class="hr5" style="margin-top:30px; margin-bottom:45px;"></div>
					<div class="tabs-section" id = "tab-subscription">
			        <!-- Nav Tabs -->
			        <ul class="nav nav-tabs">
			        	<li class="active"><a href="#tab-subscribers" data-toggle="tab"><i class="fa fa-group"></i>Subscribers</a></li>
			          	<li><a href="#tab-settings" data-toggle="tab"><i class="fa fa-gear"></i>Subscription Settings</a></li>
			        </ul>
			        <!-- Tab panels -->
			      	<div class="tab-content">

			          <!-- Tab Content 1 -->
			          <div class="tab-pane fade in active" id="tab-subscribers">
			      		<!-- Divider -->
							<div class="hr5" style="margin-top:30px; margin-bottom:45px;"></div>
			           		<table id="tbl-subscribers" class="display" cellspacing="0" width="100%"></table>
			          </div>
			          <div class="tab-pane fade in" id="tab-settings">
			      		<select id = "service_id" class = "chosen-select">
			      		</select>
			      		<!-- Divider -->
						<div class="hr5" style="margin-top:30px; margin-bottom:45px;"></div>
			          </div>
			        </div>
			      </div>
					
				</div>
				<!-- End Page Content-->



			</div>
		</div>
    </div>
    <!-- End Content -->
	
    <!-- modal dialog for view students and instructors -->
    <div class="modal fade" id = "modal_viewlist" tabindex="-1" role="dialog">
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
					<table id="students_list" class="display" cellspacing="0" width="100%">
					</table>
					
                  <!--table id="example7" class="display" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Age</th>
                                <th>Member Since</th>
                                <th>Client</th>
                                <th>Status</th>
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
                                <td><button class = "btn btn-primary btn-attendance" data-toggle="tooltip" data-placement="top" title="View Attendance History"><span class = "glyphicon glyphicon-calendar"></span></button></td>
                            </tr>
                            <tr>
                                <td>John Doe 2</td>
                                <td>Cebu City</td>
                                <td>12</td>
                                <td>December 01, 2015</td>
                                <td>John Doe</td>
                                <td>Regular</td>
                                <td><button class = "btn btn-primary btn-attendance" data-toggle="tooltip" data-placement="top" title="View Attendance History"><span class = "glyphicon glyphicon-calendar"></span></button></td>
                            </tr>
                            <tr>
                                <td>John Doe 3</td>
                                <td>Cebu City</td>
                                <td>12</td>
                                <td>December 01, 2015</td>
                                <td>John Doe</td>
                                <td>Regular</td>
                                <td><button class = "btn btn-primary btn-attendance" data-toggle="tooltip" data-placement="top" title="View Attendance History"><span class = "glyphicon glyphicon-calendar"></span></button></td>
                            </tr>
                           
                        </tbody>
                    </table-->
                </div>
                <!-- Tab Content 2 -->
                <div class="tab-pane fade" id="tab-2">
                  <table id="example8" class="display" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Schedule</th>
                                <th>Room</th>
                                <th>Slots</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>John Doe 1</td>
                                <td>Monday 08:00am-12:00pm</td>
                                <td>room 8</td>
                                <td>10</td>
                            </tr>
                            <tr>
                                <td>John Doe 1</td>
                                <td>Monday 08:00am-12:00pm</td>
                                <td>room 8</td>
                                <td>10</td>
                            </tr>
                            <tr>
                                <td>John Doe 1</td>
                                <td>Monday 08:00am-12:00pm</td>
                                <td>room 8</td>
                                <td>10</td>
                            </tr>
                           
                        </tbody>
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

    <!-- modal enter security password -->
    <div class="modal fade" id = "modal_securitypwd" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Enter Security Password</h4>
				</div>
				<div class="modal-body">
					<div class = "row">
						<div class = "col-xs-9">
							<form>  
								<div class = "form-group">
									<label for = "securitypwd">What is the name of your pet?</label>
									<input type = "password" class = "form-control" id = "securitypwd" name = "securitypwd"/>
								</div>
							</form>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary">Done</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
	</div>
	<!-- end modal -->
	
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
                    <input type = "hidden" id = "spid"/>
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
	
    <!-- javascripts -->
    <script type="text/javascript" src="assets/js/subscribers.js"></script>
	
	