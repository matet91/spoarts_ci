<!-- Start HomePage Slider -->
<style>
  .modal-dialog {
    width: 65%; /* or whatever you wish */
    
  }
  .pac-container{
    z-index: 99999999 !important;
  }
</style>
<input type="hidden" id="huserid" value="<?php echo $this->session->userdata('userid');?>" />
    <section id="home">
      <!-- Carousel -->
      <div id="main-slide" class="carousel slide" data-ride="carousel">

        <!-- Indicators -->
        <ol class="carousel-indicators">
          <li data-target="#main-slide" data-slide-to="0" class="active"></li>
          <li data-target="#main-slide" data-slide-to="1"></li>
          <li data-target="#main-slide" data-slide-to="2"></li>
        </ol>
        <!--/ Indicators end-->

        <!-- Carousel inner -->
        <div class="carousel-inner">
          <div class="item active">
            <img class="img-responsive" src="assets/images/slider/bg1.jpg" alt="slider">
            <div class="slider-content">
              <div class="col-md-12 text-center">
                <h2 class="animated2">
              <span>Welcome to <strong>SpoArts</strong></span>
          </h2>
                <h3 class="animated3">
           <span>Learn from the experts. Go to the right Club.</span>
       </h3>
                <p class="animated4"><a href="#" id = "register2" class="slider btn btn-system btn-large">Click to Register</a></p>
              </div>
            </div>
          </div>
          <!--/ Carousel item end -->
          <div class="item">
            <img class="img-responsive" src="assets/images/slider/bg2.jpg" alt="slider">
            <div class="slider-content">
              <div class="col-md-12 text-center">
                <h2 class="animated4">
        <span><strong>SpoArts</strong> for the highest</span>
    </h2>
                <h3 class="animated5">
     <span>Check out our Clinics</span>
 </h3>
                <p class="animated6"><a href="#" class="slider btn btn-system btn-large">Arts</a></p>
                <p class="animated6"><a href="#" class="slider btn btn-system btn-large">Sports</a></p>
              </div>
            </div>
          </div>
          <!--/ Carousel item end -->
          <div class="item">
            <img class="img-responsive" src="assets/images/slider/bg3.jpg" alt="slider">
            <div class="slider-content">
              <div class="col-md-12 text-center">
                <h2 class="animated7 white">
        <span>The way of <strong>Success</strong></span>
    </h2>
                <h3 class="animated8 white">
     <span>What are you waiting</span>
 </h3>
                <div class="">
                  <a class="animated4 slider btn btn-system btn-large btn-min-block" href="#">Join Now</a>
                </div>
              </div>
            </div>
          </div>
          <!--/ Carousel item end -->
        </div>
        <!-- Carousel inner end-->

        <!-- Controls -->
        <a class="left carousel-control" href="#main-slide" data-slide="prev">
          <span><i class="fa fa-angle-left"></i></span>
        </a>
        <a class="right carousel-control" href="#main-slide" data-slide="next">
          <span><i class="fa fa-angle-right"></i></span>
        </a>
      </div>
      <!-- /carousel -->
    </section>
    <!-- End HomePage Slider -->


    <!-- Start Content -->
    <div id="content">
      <div class="container">

        <!-- Start Services Icons -->
        <div class="row">

           <div class="col-md-8">

              <!-- Start Recent Posts Carousel -->
              <div class="latest-posts">
                <h4 class="classic-title"><span>Latest Events & Promos</span></h4>
				
                <div class="latest-posts-classic" id="eventpromolist">

                  
                </div>
              </div>
              <!-- End Recent Posts Carousel -->

            </div>

            <div class="col-md-4">

            <!-- Classic Heading -->
            <h4 class="classic-title"><span>Testimonials</span></h4>

            <!-- Start Testimonials Carousel -->
            <div id = "testimonials">
              
            </div>
            <!-- End Testimonials Carousel -->

          </div>
        </div>
        <!-- End Services Icons -->

        <!-- Divider -->
        <div class="hr1 margin-top"></div>


        <!-- Start Recent Projects Carousel -->
        <div class="recent-projects">
          <h4 class="title"><span>Arts and Sports Club</span></h4>
          <div id="allclinics">

            
          </div>
        </div>
        <!-- End Recent Projects Carousel -->

      </div>
    </div>
    <!-- End Content -->

    <!-- modal registration -->
    <div class="modal fade" id = "modal_registration" tabindex="-1" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Registration</h4>
          </div>
          <div class="modal-body">
            <div class = "row">
              <div class = "col-xs-9" style = "margin-left:92px">
                <form id = "form-reg">  

                    <!-- Start registration Carousel -->
                    <div class="custom-carousel show-one-slide touch-carousel" data-appeared-items="1">
                      <!-- Testimonial 1 -->
                      <div class="classic-testimonials item">
                         <!-- Classic Heading -->
                       <h4 class="classic-title"><span>STEP 1 : Please Choose Account Type</span></h4>
                          <div class = "form-group">
                            <select class = "form-control" id = "UserType" name = "UserType" >
                                <option value = "1">Service Provider</option>
                                <option value = "2">Client</option>
                            </select>
                          </div>
                          
                      </div>
                      <!-- Testimonial 2 -->
                      <div class="classic-testimonials item">
                        <!-- Classic Heading -->
                       <h4 class="classic-title"><span>STEP 2 : Choose Subscription Plan</span></h4>
                          <div class = "form-group">
                           <select class = "form-control" id = "SubscType" name = "SubscType" >
                                <option value = "">Select Subscription Type</option>
                                <option value = "2">Premium</option>
                                <option value = "1">Free 30 Day Trial</option>
                            </select>
                          </div>
                      </div>
                      <!-- registration 3 -->
                      <div class="classic-testimonials item">
                        <!-- Classic Heading -->
                        <h4 class="classic-title"><span>STEP 3 : Personal Information</span></h4>
                            <div class = "form-group">
                              <label for = "spfirstname">First Name :</label>
                              <input type = "text" class = "form-control" id = "spfirstname" name = "spfirstname" placeholder="First Name"/>
                            </div>
                            <div class = "form-group">
                              <label for = "splastname">Last Name :</label>
                              <input type = "text" class = "form-control" id = "splastname" name = "splastname" placeholder="Last Name"/>
                            </div>
                            <div class = "form-group">
                              <label for = "spbirthday">Birthday :</label>
                              <input type = "text" class = "form-control" id = "spbirthday" name = "spbirthday" placeholder="Birthday"/>
                            </div>
                            <div class = "form-group">
                              <label for = "SPContactNo">Contact # :</label>
                              <input type = "text" class = "form-control" id = "SPContactNo" name = "SPContactNo" placeholder="Contact Number"/>
                            </div>
                            <div class = "form-group">
                              <label for = "country">Address :</label>
                              <input type = "text" class = "form-control" id = "SPAddress" name = "SPAddress" placeholder="Address" />
                              <input type = "hidden" class = "form-control" id = "longitude" name = "longitude"/>
                              <input type = "hidden" class = "form-control" id = "latitude" name = "latitude" />
                            </div>
                      </div>
                      <!-- registration 3 -->
                      <div class="classic-testimonials item">
                        <!-- Classic Heading -->
                       <h4 class="classic-title"><span>STEP 3 : Account Setup</span></h4>
                        <div class = "form-group">
                            <label for = "UserName" id="label_reguname" data-placement="right" data-toggle="popover">Username : </label>
                            <input type = "text" class = "form-control" id = "UserName" name = "UserName" placeholder="Username"/>
                          </div>
                          <div class = "form-group">
                            <label for = "Password" id="label_regpwd" data-placement="top" data-toggle="popover">Enter Password : <span class ="text-info">Minimum of 8 and maximum of 10 characters.<span></label>
                            <input type = "password" class = "form-control" id = "Password" name = "Password" placeholder="Enter Password"/>
                          </div>
                          <div class = "form-group">
                            <label for = "regconfirmpwd" id="label_regconfirmpwd" data-placement="top-right" data-toggle="popover">Re-enter Password :</label>
                            <input type = "password" class = "form-control" id = "regconfirmpwd" name = "regconfirmpwd" placeholder="Re-enter Password"/>
                          </div>
                          <div class = "form-group">
                            <label for = "SPEmail" id="label_spemail" data-placement="top-right" data-toggle="popover">Email :</label>
                            <input type = "text" class = "form-control" id = "SPEmail" name = "SPEmail" placeholder="Email"/>
                          </div>
                      </div>
                    </div>
                    <!-- End REGISTRATION Carousel -->

                </div>
                <!-- End Services Icons -->
                    
                </form>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Exit</button>
            <button type="button" id = "btn-reg" class="btn btn-primary">Register</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  </div>
    <!-- end modal -->
