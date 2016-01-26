
<!doctype html>
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><html lang="en" class="no-js"> <![endif]-->
<html lang="en">

<head>
  <?php $this->load->view($header); ?>
</head>

<body>

  <!-- Container -->
  <div id="container">

    <!-- Start Header -->
    <div class="hidden-header"></div>
    <header class="clearfix">
      <?php $this->load->view($menu); ?>
    </header>
    <!-- End Header -->

    <!-- Start Content -->      
    <?php $this->load->view($content);?>
    <!-- End Content -->


    <!-- Start Footer -->
    <footer>
      <?php $this->load->view($footer); ?>
    </footer>
    <!-- End Footer -->

  </div>
  <!-- End Container -->

  <!-- Go To Top Link -->
  <a href="#" class="back-to-top"><i class="fa fa-angle-up"></i></a>

  <!-- Style Switcher -->
  <div class="switcher-box">
  <?php if($this->session->userdata('userid')){?>
    <a class="open-switcher show-switcher" id = "login-icon" data-toggle = "popover" data-placement = "right" title = "Welcome Admin! "><i class="fa fa-user fa-2x"></i></a>
    <h4>Profile</h4>

      <div class = "row" style = "width: 221px; text-align:right">
          <button class="btn btn-primary btn-xs" id = "btn-update-profile" data-toggle="tooltip" data-placement="top" title="Update Profile" >
            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
          </button>
          <button class="btn btn-primary btn-xs" id = "btn-changepwd" data-toggle="tooltip" data-placement="top" title="Change Password" >
            <span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
          </button>
        </div>
          <!-- Divider -->
          <div class="hr1 margin-top"></div>  
      <div class = "row">
        <img src="assets/images/member-02.jpg" alt="..." class="img-circle" style = "width:80px; height:80px">
         
      </div>
        <span style = "text-align:center !important">Hello Ariana</span>
        <!-- Divider -->
        <div class="hr1 margin-top"></div>
        
        
    <?php }else{?>
      <a class="open-switcher show-switcher" id = "login-icon" data-toggle = "popover" data-placement = "right" title = "Login/Register Here"><i class="fa fa-cog fa-2x"></i></a>
      <h4>Login</h4>
          <a href = "#">Register</a>|<a href="#">Forgot Password ?</a>
          <br/>
          <span id = "error" data-placement="top" data-toggle="popover"></span>
          <!-- Divider -->
          <div class="hr1 margin-top"></div>
          <div class = "row" >
          <div class = "col-md-8" style = "margin-left:10px">
            <form id = "loginForm">
              <div class = "form-group">
                <div class = "controls">
                  <input type = "text" id = "username" name = "username" class="form-control" placeholder="Username" style = "width:190px"/>
                </div>
              </div>
              <div class = "form-group">
                <div class = "controls">
                  <input type = "password" id = "password" name = "password" class="form-control" placeholder="Password" style = "width:190px"/>
                </div>
              </div>
            </form>
            </div>
          </div>
          <!-- Divider -->
        <div class="hr1 margin-top"></div>
          <div class = "row" style = "text-align:right; width: 214px;">
              <button id = "btn-login" class = "btn btn-primary btn-sm"><i class="fa fa-sign-in fa-2x"></i> Login</button>
            </div>
            <!-- Divider -->
        <div class="hr1 margin-top"></div>
    <?php } ?>
  </div>
  <!-- modal enter security password -->
    <div class="modal fade" id = "modal_profile" tabindex="-1" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Update Profile</h4>
          </div>
          <div class="modal-body">
            <div class = "row">
              <div class = "col-xs-9">
                <form>  
                    <div class = "form-group">
                      <label for = "f_name">First Name :</label>
                      <input type = "text" class = "form-control" id = "f_name" name = "f_name" placeholder="First Name"/>
                    </div>
                    <div class = "form-group">
                      <label for = "l_name">Last Name :</label>
                      <input type = "text" class = "form-control" id = "l_name" name = "l_name" placeholder="Last Name"/>
                    </div>
                    <div class = "form-group">
                      <label for = "bday">Birthday :</label>
                      <input type = "text" class = "form-control" id = "bday" name = "bday" placeholder="Birthday"/>
                    </div>
                    <div class = "form-group">
                      <label for = "contact">Contact # :</label>
                      <input type = "text" class = "form-control" id = "contact" name = "contact" placeholder="Contact Number"/>
                    </div>
                </form>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save Changes</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- end modal -->
  <script type="text/javascript" src="assets/js/script.js"></script>
  <script type="text/javascript" src="assets/js/main.js"></script>
  <script type="text/javascript" src="assets/js/login.js"></script>

</body>

</html>