
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
      <?php ($menu !=''?$this->load->view($menu):''); ?>
    </header>
    
    <!-- End Header -->

    <!-- Start Content -->      

    <?php $this->load->view($content);?>
    <!-- End Content -->


    <!-- Start Footer -->
    
      <?php ($footer!=''?$this->load->view($footer):''); ?>
        <!-- End Footer -->

  </div>
  <!-- End Container -->

  <!-- Go To Top Link -->
  <a href="#" class="back-to-top"><i class="fa fa-angle-up"></i></a>
<div id="loader">
  <div class="spinner">
    <div class="dot1"></div>
    <div class="dot2"></div>
  </div>
</div>
  <!-- Style Switcher -->
  <?php if($content!='content/landingpage.php'){?>
  <div class="switcher-box">
  <?php if($this->session->userdata('userid')){?>
    <a class="open-switcher show-switcher" id = "login-icon" data-toggle = "popover" data-placement = "right" title = "Welcome <?php echo $this->session->userdata('username');?>! "><i class="fa fa-user fa-2x"></i></a>
    <h4>Profile</h4>

      <div class = "row" style = "width: 221px; text-align:right">
          <button class="btn btn-primary btn-xs" id = "btn-update-profile" data-toggle="tooltip" data-placement="top" title="Update Profile" >
            <i class="fa fa-edit fa-fw"></i>
          </button>
          <button class="btn btn-primary btn-xs" id = "btn-changepwd" data-toggle="tooltip" data-placement="top" title="Security Settings" >
            <i class="fa fa-gear fa-fw"></i>
          </button>
        </div>
          <!-- Divider -->
          <div class="hr1 margin-top"></div>  
      <div class = "row">
        <img src="assets/images/<?php echo $this->session->userdata('splogoname');?>" alt="..." class="img-circle" style = "width:80px; height:80px;cursor:pointer" id="member_pic" data-toggle = "popover" data-placement = "right" title = "Click here to change picture.">
         <input type="file" name="btn-member_pic" id="btn-member_pic" accept="image/*" style = "display:none"/>
      </div>
        <span style = "text-align:center !important">Hello <?php echo $this->session->userdata('name');?></span>
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
  <?php }?>
  <!-- modal edit profile -->
    <div class="modal fade" id = "modal_profile" tabindex="-1" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Update Profile</h4>
          </div>
          <div class="modal-body">
            <div class = "row">
            <div class="alert" role="alert" style = "display:none"></div>
                <form id = "form-updateProfile">  
                  <div class = "col-md-6">
                    <div class = "form-group">
                      <label for = "f_name">First Name :</label>
                      <input type = "text" class = "form-control" id = "spfirstname" name = "spfirstname" placeholder="First Name"/>
                    </div>
                    <div class = "form-group">
                      <label for = "l_name">Last Name :</label>
                      <input type = "text" class = "form-control" id = "splastname" name = "splastname" placeholder="Last Name"/>
                    </div>
                    <div class = "form-group">
                      <label for = "bday">Birthday :</label>
                      <input type = "text" class = "form-control" id = "spbirthday" name = "spbirthday" placeholder="Birthday"/>
                    </div>
                    
                  </div>
                  <div class = "col-md-6">
                    <div class = "form-group">
                        <label for = "contact">Contact # :</label>
                        <input type = "text" class = "form-control" id = "SPContactNo" name = "SPContactNo" placeholder="Contact Number"/>
                    </div>
                    <div class = "form-group">
                        <label for = "email">E-mail :</label>
                        <input type = "text" class = "form-control" id = "SPEmail" name = "SPEmail" placeholder="Contact Number" style="float:left"/>
                    </div>
                  </div>
                </form>
          </div>
          <div class="modal-footer">
            <button class="btn btn-default" data-dismiss="modal">Close</button>
            <button class="btn btn-primary" id = "btn-saveProfile">Save Changes</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- end modal -->
  </div>
<!-- end profile update -->
  
   <!-- modal security settings -->
    <div class="modal fade" id = "modal_secsettings" tabindex="-1" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Security Settings</h4>
          </div>
          <div class="modal-body">
          <div class="alert" role="alert" style = "display:none"></div>
              <div class="tabs-section" id = "tab-securitysettings">
              <!-- Nav Tabs -->
              <ul class="nav nav-tabs">
                <li class="active"><a href="#tab-1" data-toggle="tab"><i class="fa fa-key"></i>Login Password</a></li>
                <li><a href="#tab-2" data-toggle="tab"><i class="fa fa-key"></i>Security Question and Password</a></li>
              </ul>

              <!-- Tab panels -->
              <div class="tab-content">
                <!-- Tab Content 1 password -->
                <div class="tab-pane fade in active" id="tab-1">
                  <div class = "row" style = "margin: 5px">
                        <form id = "form-secsettings">  
                          <div class = "form-group">
                            <label for = "oldpwd">Old Password :</label>
                            <input type = "password" class = "form-control" id = "oldpwd" name = "oldpwd" placeholder="Enter Old Password" data-placement="top" data-toggle="tooltip" data-placement="top" title="Click outside this textbox to verify inputted password.">
                          </div>
                          <div class = "form-group">
                            <label for = "secpwd"><?=$this->session->userdata('securityquestion')."?"; ?></label>
                            <input type = "password" class = "form-control" id = "secpwd" name = "secpwd" placeholder="Enter Security Password" data-placement="top" data-toggle="tooltip" title="Click outside this textbox to verify inputted password." disabled>
                          </div>
                          <div class = "form-group">
                            <label for = "newpwd" id="label_newpwd" data-placement="top" data-toggle="popover">New Password : <span class ="text-info">Minimum of 8 and maximum of 10 characters.<span></label>
                            <input type = "password" class = "form-control" id = "newpwd" name = "newpwd" placeholder="New Password" disabled>
                          </div>
                          <div class = "form-group">
                            <label for = "con_newpwd" id="label_con_newpwd" data-placement="top" data-toggle="popover">Confirm New Password :</label>
                            <input type = "password" class = "form-control" id = "con_newpwd" name = "con_newpwd" placeholder="Confirm New Password" disabled>
                          </div>
                        </form>
                        <button class="btn btn-primary" id = "btn-newPwd" data-placement="top" data-toggle="tooltip" data-placement="top" title="Save Changes" disabled><span class="glyphicon glyphicon-floppy-save"></span></button>
                  </div>
                </div>
                <!-- Tab Content 2 security questions  -->
                <div class="tab-pane fade" id="tab-2">
                  <div class = "row">
                      <form id = "form-secQsettings">
                          <div class = "form-group">
                            <label for = "sec_pwd">Enter Login Password :</label>
                            <input type = "password" class = "form-control" id = "loginPassword" name = "loginPassword" placeholder="Enter Login Password">
                          </div>
                          <div class = "form-group">

                            <label for = "sec_question">Security Question :</label>
                            <select class = "form-control" id = "security_question_id" name = "security_question_id" disabled>
                            </select>
                          </div>
                          <div class = "form-group">
                            <label for = "sec_pwd">New Security Password :</label>
                            <input type = "password" class = "form-control" id = "security_password" name = "security_password" placeholder="Security Password" disabled>
                          </div>
                      </form>
                     <button class="btn btn-primary" id = "btn-secPwd" data-placement="top" data-toggle="tooltip" data-placement="top" title="Save Changes"><span class="glyphicon glyphicon-floppy-save"></span></button>
                  </div>
                </div>
               
              </div>
              <!-- End Tab Panels -->

            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-default" data-dismiss="modal">Close</button>
            
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- end modal -->
  </div>
<!-- end security settings -->

<!-- modal security -->
    <div class="modal fade" id = "modal_security" tabindex="-1" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Authentication</h4>
          </div>
          <div class="modal-body">
            <div class = "row">
            <div class="alert" role="alert" style = "display:none"></div>
              <form  id="formsecurity">
                <div class = "col-md-8">  
                  <div class = "form-group">
                    <label for = "securitypwd"><?=$this->session->userdata('securityquestion');?></label><input type = "password" placeholder="Service Password" class = "form-control" id = "sec_pwd" name = "sec_pwd"/>
                  </div>
                </div>
              </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Exit</button>
            <button type="button" id= "btn-continue" class="btn btn-primary">Continue</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  </div>
    <!-- end modal -->

    
  <script type="text/javascript" src="assets/js/script.js"></script>
  <script type="text/javascript" src="assets/js/main.js"></script>

</body>

</html>