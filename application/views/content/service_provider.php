<style>
  #modal_viewlist .modal-dialog {
    width: 95%; /* or whatever you wish */
  }
</style>


<!-- Start Page Banner -->
    <div class="page-banner no-subtitle">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h2>manage Service Providers</h2>
				</div>
				<div class="col-md-6">
					<ul class="breadcrumbs">
						<li><a href="?content=home.php">Home</a></li>
						<li>Service Providers</li>
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
				<!-- Page Content -->
				<div class="col-md-9 page-content">
					<!-- Classic Heading -->
					<h4 class="classic-title"><span>Service Providers' List with their Services and Clients</span></h4> 
					
					<!-- Divider -->
					<div class="hr5" style="margin-top:30px; margin-bottom:45px;"></div>
					
					<!-- carousel -->
					<div class="custom-carousel show-one-slide touch-carousel" data-appeared-items="1">
			   
						<!-- Accordion -->
						<div class = "item">
							<div class="panel-group" id="accordion">
								<!-- Start Accordion 1 -->
								<div class="panel panel-default">
									<!-- Toggle Heading -->
									<div class="panel-heading">
										<h4 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordion" href="#collapse-4">
												<i class="fa fa-angle-up control-icon"></i>
												<span class=" glyphicon glyphicon-user"></span> John Doe
											</a>
										</h4>
									</div>
								  
									<!-- Toggle Content -->
									<div id="collapse-4" class="panel-collapse collapse in">
										<div class="col-md-2">
											<div class = "row">
												<img src="assets/images/member-02.jpg" alt="..." class="img-circle" style = "width:80px; height:80px">
											</div>
										</div>
										<div class="col-md-8">
											<form class="form-horizontal" id="formaddservice">
												<div class="form-group">
													<div class="col-sm-10">
													  <button class="btn btn-primary btn-sm" id="btn-update" data-toggle="tooltip" data-placement="top" title="Save Service"><span class = "glyphicon glyphicon-floppy-save"></span> </button>
													  <button class="btn btn-danger btn-sm" id="btn-end" data-toggle="tooltip" data-placement="top" title="Turn Off Account"><span class = "glyphicon glyphicon-off"></span> </button>
													  <button class="btn btn-info btn-sm" id="btn-renew" data-toggle="tooltip" data-placement="top" title="Upgrade/Renew Subscription"><span class = "glyphicon glyphicon-king"></span> </button>
													  <button class="btn btn-warning btn-sm" id="btn-reset" data-toggle="tooltip" data-placement="top" title="Reset Password"><span class = "glyphicon glyphicon-refresh"></span> </button>
													</div>
												</div>
												<div class="form-group">
						                            <label for="inputEmail3" class="col-sm-2 control-label">Club Name</label>
						                            <div class="col-sm-10">
						                              <input type="text" class="form-control" id="clubname" placeholder="Club Name">
						                            </div>
						                          </div>
						                          <div class="form-group">
						                            <label for="inputEmail3" class="col-sm-2 control-label">Owner Name: </label>
						                            <div class="col-sm-10">
						                              <input type="text" class="form-control" id="firstname" placeholder="First Name">
						                              <br/>
						                              <input type="text" class="form-control" id="firstname" placeholder="Last Name">
						                            </div>
						                          </div>

						                          <div class="form-group">
						                            <label for="inputEmail3" class="col-sm-2 control-label">Location</label>
						                            <div class="col-sm-10">
						                              <input type="text" class="form-control" id="firstname" placeholder="Location">
						                              <span class = "glyphicon glyphicon-map-marker" style = "cursor:pointer !important;" data-toggle="tooltip" data-placement="top" title="Click to show map"></span>
						                            </div>

						                          </div>
						                          <div class="form-group">
						                            <label for="inputEmail3" class="col-sm-2 control-label">About Me</label>
						                            <div class="col-sm-10">
						                              <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia dolores</p>
						                            </div>
						                          </div>
						                          <div class="form-group">
						                            <label for="inputEmail3" class="col-sm-2 control-label">Subscription Plan</label>
						                            <div class="col-sm-10">
						                              <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia dolores.</p>
						                            </div>
						                          </div>
						                          <div class="form-group">
						                            <label for="inputEmail3" class="col-sm-2 control-label">Subscription Plan Expiry Date</label>
						                            <div class="col-sm-10">
						                              <p>January 01, 2017</p>
						                            </div>
						                          </div>
												

											</form>
										</div>
										<table id="service_list" class="display">
										</table>
									</div>
								</div>
							  <!-- End Accordion 1 -->
							</div>
							<!-- End Accordion -->
						</div>
					</div> 
					<!-- end carousel -->
				</div>
				<!-- End Page Content-->


			<!--Sidebar-->
			<div class="col-md-3 sidebar right-sidebar">
				<!-- Search Widget -->
				<div class="widget widget-search">
					<form action="#">
						<input type="search" placeholder="Enter Keywords..." />
						<button class="search-btn" type="submit"><i class="fa fa-search"></i></button>
					</form>
				</div>

				<!-- Categories Widget -->
				<div class="widget widget-categories">
					<h4>Quick Links <span class="head-line"></span></h4>
					<ul>
						<li><a href="?content=home.php">Home</a></li>
						<li><a href="?content=service_provider.php">Service Provider</a></li>
						<li><a href="?content=subscription_settings.php">Subscription Settings</a></li>
						<li><a href="?content=testimonials.php">Testimonials</a></li>
						<li><a href="?content=sales.php">Sales</a></li>
					</ul>
				</div>
			</div>
			<!--End sidebar-->

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
	
	<!-- modal enter security password -->
    <div class="modal fade" id = "modal_status" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="modal_title">Enter Security Password</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class = "col-xs-9" id="modal_bodytext">
							message here
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
	
    <!-- javascripts -->
    <script type="text/javascript" src="assets/js/service_provider.js"></script>
	
	