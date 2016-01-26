<!-- Start Top Bar -->

      <div class="top-bar">
        <div class="container">
          <div class="row">
            <div class="col-md-6">
              <!-- Start Contact Info -->
              <ul class="contact-details">
                <li><a href="#"><i class="fa fa-map-marker"></i> Cebu City</a>
                </li>
                <li><a href="#"><i class="fa fa-envelope-o"></i> spoarts@spoarts.com</a>
                </li>
                <li><a href="#"><i class="fa fa-phone"></i> +63 9999 1234</a>
                </li>
              </ul>
              <!-- End Contact Info -->
            </div>
            <div class="col-md-6">
              <!-- Start Social Links -->
              <ul class="social-list">
                <li>
                  <a class="facebook itl-tooltip" data-placement="bottom" title="Facebook" href="#"><i class="fa fa-facebook"></i></a>
                </li>
                <li>
                  <a class="twitter itl-tooltip" data-placement="bottom" title="Twitter" href="#"><i class="fa fa-twitter"></i></a>
                </li>
                <li>
                  <a class="google itl-tooltip" data-placement="bottom" title="Google Plus" href="#"><i class="fa fa-google-plus"></i></a>
                </li>
                <li>
                  <a class="dribbble itl-tooltip" data-placement="bottom" title="Dribble" href="#"><i class="fa fa-dribbble"></i></a>
                </li>
                <li>
                  <a class="linkdin itl-tooltip" data-placement="bottom" title="Linkedin" href="#"><i class="fa fa-linkedin"></i></a>
                </li>
                <li>
                  <a class="flickr itl-tooltip" data-placement="bottom" title="Flickr" href="#"><i class="fa fa-flickr"></i></a>
                </li>
                <li>
                  <a class="tumblr itl-tooltip" data-placement="bottom" title="Tumblr" href="#"><i class="fa fa-tumblr"></i></a>
                </li>
                <li>
                  <a class="instgram itl-tooltip" data-placement="bottom" title="Instagram" href="#"><i class="fa fa-instagram"></i></a>
                </li>
                <li>
                  <a class="vimeo itl-tooltip" data-placement="bottom" title="vimeo" href="#"><i class="fa fa-vimeo-square"></i></a>
                </li>
                <li>
                  <a class="skype itl-tooltip" data-placement="bottom" title="Skype" href="#"><i class="fa fa-skype"></i></a>
                </li>
              </ul>
              <!-- End Social Links -->
            </div>
          </div>
        </div>
      </div>
      <!-- End Top Bar -->

      <!-- Start Header ( Logo & Naviagtion ) -->
      <div class="navbar navbar-default navbar-top">
        <div class="container">
          <div class="navbar-header">
            <!-- Stat Toggle Nav Link For Mobiles -->
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <i class="fa fa-bars"></i>
            </button>
            <!-- End Toggle Nav Link For Mobiles -->
            <a class="navbar-brand" href="index.html"><img alt="" src="assets/images/logo.png"></a>
          </div>
          <div class="navbar-collapse collapse">
            <!-- Stat Search -->
            <div class="search-side">
              <button class = "btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" title="Notifications"><span class = "glyphicon glyphicon-bell"></span> 3</button>
            </div>
            <!-- End Search -->
            <!-- Start Navigation List -->
            <ul class="nav navbar-nav navbar-right">
              <li>
                <a class = "<?php echo ($content == 'home.php'?'active':'');?>" href="?content=home.php">Home</a>
              </li>
              <li>
              <?php if($this->session->userdata('userid') && $this->session->userdata('usertype') == 0){?>
                <a href="#" class = "<?php echo ($content == 'content/service_provider.php'?'active':'');?>">Subscribers</a>
                <ul class="dropdown">
                  <li><a href="service_provider" >Service Providers</a></li>
                  <li><a href="?content=subscription_settings">Subscription Setttings</a></li>
                </ul>
                <?php }else{ ?>
                <a href="#" class = "<?php echo ($content == 'service_provider.php'?'active':'');?>">Clubs</a>
                <ul class="dropdown">
                  <li><a href="service_provider" >Arts</a></li>
                  <li><a href="?content=subscription_settings">Sports</a></li>
                </ul>
                <?php } ?>
              </li>
              <?php if($this->session->userdata('userid') && $this->session->userdata('usertype') == 0){?>
                <li>
                  <a href="?content=testimonials.php" class = "<?php echo ($content == 'testimonials.php'?'active':'');?>">Testimonials</a>
                </li>
                <li><a href="?content=sales.php" class = "<?php echo ($content == 'sales.php'?'active':'');?>">Sales</a></li>
              <?php } ?>
            </ul>
            <!-- End Navigation List -->
          </div>
        </div>

        <!-- Mobile Menu Start -->
        <ul class="wpb-mobile-menu">
          <li>
            <a class = "<?php echo ($content == 'home.php'?'active':'');?>" href="?content=home.php">Home</a>
          </li>
          <li>
          <?php if($this->session->userdata('userid') && $this->session->userdata('usertype') == 0){?>
            <a href="#" class = "<?php echo ($content == 'service_provider.php'?'active':'');?>">Subscribers</a>
            <ul class="dropdown">
              <li><a href="service_provider">Service Providers</a>
              </li>
              <li><a href="?content=subscription_settings">Subscription Settings</a>
              </li>
            </ul>
            <?php }else{?>
              <a href="#" class = "<?php echo ($content == 'service_provider.php'?'active':'');?>">Clubs</a>
              <ul class="dropdown">
                <li><a href="service_provider">Arts</a>
                </li>
                <li><a href="?content=subscription_settings">Sports</a>
                </li>
              </ul>
            <?php } ?>
          </li>
          <?php if($this->session->userdata('userid') && $this->session->userdata('usertype') == 0){?>
          <li>
            <a href="?content=testimonials.php" class = "<?php echo ($content == 'testimonials.php'?'active':'');?>">Testimonials</a>
          </li>
          <li>
            <a href="?content=sales.php" class = "<?php echo ($content == 'sales.php'?'active':'');?>">Sales</a>
          </li>
          <?php } ?>
        </ul>
        <!-- Mobile Menu End -->

      </div>
      <!-- End Header ( Logo & Naviagtion ) -->