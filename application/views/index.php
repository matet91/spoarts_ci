
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
    <a class="open-switcher show-switcher" id = "login-icon" data-toggle = "popover" data-placement = "right" title = "Welcome <?php echo $this->session->userdata('username');?>! "><i class="fa fa-user fa-2x"></i></a>
    <h4>Profile</h4>

      <div class = "row" style = "width: 221px; text-align:right">
          <button class="btn btn-primary btn-xs" id = "btn-update-profile" data-toggle="tooltip" data-placement="top" title="Update Profile" >
            <i class="fa fa-edit fa-fw"></i>
          </button>
          <button class="btn btn-primary btn-xs" id = "btn-changepwd" data-toggle="tooltip" data-placement="top" title="Change Password" >
            <i class="fa fa-lock fa-fw"></i>
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
        <div class = "row" style = "text-align:right; width: 214px;">
              <button id = "btn-logout" class = "btn btn-primary btn-sm"><i class="fa fa-sign-out fa-2x"></i> Logout</button>
            </div>
         <!-- Divider -->
        <div class="hr1 margin-top"></div>
    <?php }else{?>
      <a class="open-switcher show-switcher" id = "login-icon" data-toggle = "popover" data-placement = "right" title = "Login/Register Here"><i class="fa fa-cog fa-2x"></i></a>
      <h4>Login</h4>
          <a href = "#" id = "register">Register</a>|<a href="#">Forgot Password ?</a>
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
  
  <script type="text/javascript" src="assets/js/script.js"></script>
  <script type="text/javascript" src="assets/js/main.js"></script>
  <script type="text/javascript" src="assets/js/login.js"></script>

</body>

</html>