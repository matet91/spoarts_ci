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


    <!-- Start Content -->
    <div id="content">
      <div class="container">
        <div class="row sidebar-page"> 
            <div class="col-md-9 page-content">
              <div class="col-md-8">
                <form class="form-horizontal">
                  <div class="form-group">
                    <div class="col-sm-10">
                      <button class="btn btn-primary btn-sm" id="btn-update" data-toggle="tooltip" data-placement="top" title="Save Changes"><span class = "glyphicon glyphicon-floppy-save"></span> </button>
                      <button class="btn btn-info btn-sm" id="btn-renew" data-toggle="tooltip" data-placement="top" title="Upgrade/Renew Subscription"><span class = "glyphicon glyphicon-king"></span> </button>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Club Name</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="clubname" placeholder="Club Name" value = "JohnDoe">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Owner Name: </label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="firstname" placeholder="First Name" value = "John">
                      <br/>
                      <input type="text" class="form-control" id="firstname" placeholder="Last Name" value = "Doe">
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
                      <textarea>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia dolores.</textarea>
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
              <!-- Divider -->
            <div class="hr5" style="margin-top:30px; margin-bottom:45px;"></div>
              <div class="col-sm-10">
                <button class="btn btn-primary btn-sm" id="btn-addService" data-toggle="tooltip" data-placement="top" title="Add Services"><span class = "glyphicon glyphicon-plus"></span></button>
              </div>
              <!-- Divider -->
            <div class="hr5" style="margin-top:30px; margin-bottom:45px;"></div>
              <table id="example" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Services</th>
                        <th>Description</th>
                        <th>Schedule</th>
                        <th>Registration Fee (Peso)</th>
                        <th>Walk-in Fee / Per Session (Peso)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Taekwando</td>
                        <td>Taekwando Description</td>
                        <td>Monday-Saturday 08:00am - 09:00pm</td>
                        <td>300</td>
                        <td>150</td>
                        <td><button class = "btn btn-primary btn-viewlist" data-toggle="tooltip" data-placement="top" title="View Students and Instructors"><span class = "glyphicon glyphicon-list"></span></button></td>
                    </tr>
                    <tr>
                        <td>Voice Lesson</td>
                        <td>Voice Lesson Description</td>
                        <td>Monday-Saturday 08:00am - 09:00pm</td>
                        <td>500</td>
                        <td>250</td>
                        <td><button class = "btn btn-primary btn-viewlist" data-toggle="tooltip" data-placement="top" title="View Students and Instructors"><span class = "glyphicon glyphicon-list"></span></button></td>
                    </tr>
                    <tr>
                        <td>Piano Lesson</td>
                        <td>Piano Lesson Description</td>
                        <td>Monday-Saturday 08:00am - 09:00pm</td>
                        <td>500</td>
                        <td>250</td>
                        <td><button class = "btn btn-primary btn-viewlist" data-toggle="tooltip" data-placement="top" title="View Students and Instructors"><span class = "glyphicon glyphicon-list"></span></button></td>
                    </tr>
                   
                </tbody>
            </table>

          </div>

          <!--Sidebar-->
          <div class="col-md-3 sidebar right-sidebar">

            <!-- Categories Widget -->
            <div class="widget widget-categories">
              <h4>Quick Links <span class="head-line"></span></h4>
              <ul>
                <li>
                  <a href="?content=home.php">Home</a>
                </li>
                <li>
                  <a href="?content=services.php">Services</a>
                </li>
                <li>
                  <a href="?content=eventspromos.php">Events & Promos</a>
                </li>
                <li>
                  <a href="?content=clients.php">Clients</a>
                </li>
                <li>
                  <a href="?content=sales.php">Sales</a>
                </li>
              </ul>
            </div>


          </div>
          <!--End sidebar-->


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
    <!-- javascripts -->
    <script type="text/javascript" src="js/services.js"></script>