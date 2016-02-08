
      <!-- Start Header ( Logo & Naviagtion ) -->
      <div class="navbar navbar-default navbar-top">
        <div class="container">
          <div class="navbar-header">
            
            <!-- Stat Toggle Nav Link For Mobiles -->
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <i class="fa fa-bars"></i>
            </button>
            <!-- End Toggle Nav Link For Mobiles -->
            <a class="navbar-brand" href="#"><img alt="" src="assets/images/logo.png"></a>
          </div>
          <div class="navbar-collapse collapse">
            
            <div class="search-side">
              <button class = "btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" title="Notifications"><span class = "glyphicon glyphicon-bell"></span> 3</button>
            </div>
            <!-- End Search -->
            <!-- Start Navigation List -->
            <ul class="nav navbar-nav navbar-right " id = "menus">
              <li>
                <a class = "<?php echo ($content == 'home.php'?'active':'');?>" href="?content=home.php">Home</a>
              </li>
              <li>
              <?php  if($this->session->userdata('userid') && $this->session->userdata('usertype') == '0'){?>
                <a href="#" class = "<?php echo ($content == 'content/service_provider.php'?'active':'');?>">Subscribers</a>
                <ul class="dropdown">
                  <li><a href="service_provider" >Service Providers</a></li>
                  <li><a href="?content=subscription_settings">Subscription Setttings</a></li>
                </ul>
              </li>
                <?php }else if($this->session->userdata('userid') && $this->session->userdata('usertype') == 1){?>
                 <li> <a href="services" class = "<?php echo ($content == 'content/services.php'?'active':'');?>">Services</a></li>
                 <li> <a href="events_and_promos" class = "<?php echo ($content == 'content/events_and_promos.php'?'active':'');?>">Events & Promos</a></li>
                 <li> <a href="reviews_and_ratings" class = "<?php echo ($content == 'content/reviews_and_ratings.php'?'active':'');?>">Reviews and Ratings</a></li>
                <li><a href="clients" class = "<?php echo ($content == 'content/clients.php'?'active':'');?>">Clients</a></li>
                <?php }else{ ?>
                <a href="#" class = "<?php echo ($content == 'content/clinics.php'?'active':'');?>">Clinics</a>
                <ul class="dropdown">
                  <li><a href="clinics?type=1">Arts</a></li>
                  <li><a href="clinics?type=0">Sports</a></li>
                </ul>
                <?php } ?>
              </li>
              <?php if($this->session->userdata('userid') && $this->session->userdata('usertype') == 1){?>
                <li><a href="?content=sales.php" class = "<?php echo ($content == 'sales.php'?'active':'');?>">Sales</a></li>
              <?php } ?>
              <?php if($this->session->userdata('userid') && $this->session->userdata('usertype') == 0){?>
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
            <?php }else if($this->session->userdata('userid') && $this->session->userdata('usertype') == 1){?>
            <li><a href="services" class = "<?php echo ($content == 'content/services.php'?'active':'');?>">Services</a></li>
            <li> <a href="events_and_promos" class = "<?php echo ($content == 'content/events_and_promos.php'?'active':'');?>">Events & Promos</a></li>
                 <li> <a href="reviews_and_ratings" class = "<?php echo ($content == 'content/reviews_and_ratings.php'?'active':'');?>">Reviews and Ratings</a></li>
            <li><a href="clients" class = "<?php echo ($content == 'content/clients.php'?'active':'');?>">Clients</a></li>
            <?php }else{?>
              <a href="clinics" class = "<?php echo ($content == 'clinics.php'?'active':'');?>">Clinics</a>
              <ul class="dropdown">
                <li><a href="service_provider">Arts</a>
                </li>
                <li><a href="?content=subscription_settings">Sports</a>
                </li>
              </ul>
            <?php } ?>
          </li>
          <?php if($this->session->userdata('userid') && $this->session->userdata('usertype') == 1){?>
          
          <li>
            <a href="?content=sales.php" class = "<?php echo ($content == 'sales.php'?'active':'');?>">Sales</a>
          </li>
          <?php } ?>
        </ul>
        <!-- Mobile Menu End -->

      </div>
      <div id="message">
        <div style="padding: 5px;">
            <div id="inner-message" class="alert alert-error">
            </div>
        </div>
      </div>
      <!-- End Header ( Logo & Naviagtion ) -->