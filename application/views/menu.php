<style>
.colmd{
	width: 100% !important;
}

#NewNotification, #OldNotification{
	margin-bottom: 10px;
}

#oldnotif-div{
	display:none;
	margin-bottom: 10px;
}
</style>
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
            <?php if($this->session->userdata('usertype') == '2' || $this->session->userdata('usertype') == '1'){ ?>
            <div class="search-side">
              <button class = "btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" title="Notifications" id="notification"  style = "cursor:pointer"><span class = "glyphicon glyphicon-bell" style = "cursor:pointer" ></span></button>
            </div>
			     <?php } ?>
            <!-- End Search -->
            <!-- Start Navigation List -->
            <ul class="nav navbar-nav navbar-right " id = "menus">
            <?php if($this->session->userdata('userid')==2){?>
                <li><a href="clinicprofile" class = "<?php echo ($content == 'content/clinicprofile.php'?'active':'');?>">Clinic Profile</a></li>
              <?php } ?>
            <?php if(!$this->session->userdata('userid') || $this->session->userdata('usertype') == 2){?>
              <li>
                <a class = "<?php echo ($content == 'content/login.php'?'active':''); echo ($content == 'content/home.php'?'active':'');?>" href="<?= (!$this->session->userdata('userid'))?'login':'index';?>">Home</a>
              </li>
              <?php } ?>
              <li>
              <?php  if($this->session->userdata('userid') && $this->session->userdata('usertype') == '0'){?>
                <a href="subscribers" class = "<?php echo ($content == 'content/subscribers.php'?'active':'');?>">Subscribers</a>
              </li>
                <?php }else if($this->session->userdata('userid') && $this->session->userdata('usertype') == 1){?>
                 <li> <a href="services" class = "<?php echo ($content == 'content/services.php'?'active':'');?>">Services</a></li>
                 <li> <a href="events_and_promos" class = "<?php echo ($content == 'content/events_and_promos.php'?'active':'');?>">Events & Promos</a></li>
                 <li> <a href="reviews_and_ratings" class = "<?php echo ($content == 'content/reviews_and_ratings.php'?'active':'');?>">Reviews and Ratings</a></li>
                <li><a href="clients" class = "<?php echo ($content == 'content/clients.php'?'active':'');?>">Clients</a></li>
                <?php }else{ 
                if($this->session->userdata('usertype') == 2 || !$this->session->userdata('userid')){?>
                <a href="#" class = "<?php echo ($content == 'content/clinics.php'?'active':'');?>">Clinics</a>
                <ul class="dropdown">
                  <li><a href="clinics?type=1">Arts</a></li>
                  <li><a href="clinics?type=0">Sports</a></li>
                </ul>
                <?php }} if($this->session->userdata('userid') && $this->session->userdata('usertype') == '2'){?>
          				<li> <a href="myclinics" class = "<?php echo ($content == 'content/myclinics.php'?'active':'');?>">My Clinics</a></li>
          				<li> <a href="myschedules" class = "<?php echo ($content == 'content/myschedules.php'?'active':'');?>">My Schedules</a></li>
          				<li> <a href="myinterests" class = "<?php echo ($content == 'content/myinterests.php'?'active':'');?>">My Interest</a></li>
          				<li> <a href="mypayments" class = "<?php echo ($content == 'content/mypayments.php'?'active':'');?>">My Payments</a></li>
          				<li> <a href="myevents" class = "<?php echo ($content == 'content/myevents.php'?'active':'');?>">My Events</a></li>
                <?php } ?>
              </li>
              <?php if($this->session->userdata('userid') && $this->session->userdata('usertype') == 1){?>
                <li><a href="gallery" class = "<?php echo ($content == 'content/gallery.php'?'active':'');?>">Gallery</a></li>
              <?php } ?>
              <?php if($this->session->userdata('userid') && $this->session->userdata('usertype') == 0){?>
                <li><a href="manageaccounts" class = "<?php echo ($content == 'manageaccounts.php'?'active':'');?>">Client Management</a></li>
              <?php } ?>
              <?php if($this->session->userdata('userid') && $this->session->userdata('usertype') == 1){?>
                <li><a href="sales?type=1" class = "<?php echo ($content == 'content/sales.php'?'active':'');?>">Sales</a></li>
              <?php } ?>
              <?php if($this->session->userdata('userid') && $this->session->userdata('usertype') == 0){?>
                <li><a href="sales?type=0" class = "<?php echo ($content == 'content/sales.php'?'active':'');?>">Sales</a></li>
              <?php } ?>
              <?php if(!$this->session->userdata('userid')){?>
                <li><a href="sales?type=0" class = "<?php echo ($content == 'content/registration.php'?'active':'');?>">Register</a></li>
              <?php } ?>
            </ul>
            <!-- End Navigation List -->
          </div>
        </div>

        <!-- Mobile Menu Start -->
        <ul class="wpb-mobile-menu">
          <?php if($this->session->userdata('userid')==2){?>
                <li><a href="clinicprofile" class = "<?php echo ($content == 'content/clinicprofile.php'?'active':'');?>">Clinic Profile</a></li>
              <?php } ?>
          <?php if(!$this->session->userdata('userid') || $this->session->userdata('usertype') == 2){?>
              <li>
                <a class = "<?php echo ($content == 'home.php'?'active':'');?>" href="<?= (!$this->session->userdata('userid'))?'login':'index';?>">Home</a>
              </li>
              <?php } ?>
              <li>
              <?php  if($this->session->userdata('userid') && $this->session->userdata('usertype') == '0'){?>
                <a href="subscribers" class = "<?php echo ($content == 'content/subscribers.php'?'active':'');?>">Subscribers</a>
              </li>
                <?php }else if($this->session->userdata('userid') && $this->session->userdata('usertype') == 1){?>
                 <li> <a href="services" class = "<?php echo ($content == 'content/services.php'?'active':'');?>">Services</a></li>
                 <li> <a href="events_and_promos" class = "<?php echo ($content == 'content/events_and_promos.php'?'active':'');?>">Events & Promos</a></li>
                 <li> <a href="reviews_and_ratings" class = "<?php echo ($content == 'content/reviews_and_ratings.php'?'active':'');?>">Reviews and Ratings</a></li>
                <li><a href="clients" class = "<?php echo ($content == 'content/clients.php'?'active':'');?>">Clients</a></li>
                <?php }else{ 
                if($this->session->userdata('usertype') == 2 || !$this->session->userdata('userid')){?>
                <a href="#" class = "<?php echo ($content == 'content/clinics.php'?'active':'');?>">Clinics</a>
                <ul class="dropdown">
                  <li><a href="clinics?type=1">Arts</a></li>
                  <li><a href="clinics?type=0">Sports</a></li>
                </ul>
                <?php }} if($this->session->userdata('userid') && $this->session->userdata('usertype') == '2'){?>
                  <li> <a href="myclinics" class = "<?php echo ($content == 'content/myclinics.php'?'active':'');?>">My Clinics</a></li>
                  <li> <a href="myschedules" class = "<?php echo ($content == 'content/myschedules.php'?'active':'');?>">My Schedules</a></li>
                  <li> <a href="myinterests" class = "<?php echo ($content == 'content/myinterests.php'?'active':'');?>">My Interest</a></li>
                  <li> <a href="mypayments" class = "<?php echo ($content == 'content/mypayments.php'?'active':'');?>">My Payments</a></li>
                  <li> <a href="myevents" class = "<?php echo ($content == 'content/myevents.php'?'active':'');?>">My Events</a></li>
                <?php } ?>
              </li>
              <?php if($this->session->userdata('userid') && $this->session->userdata('usertype') == 1){?>
                <li><a href="gallery" class = "<?php echo ($content == 'content/gallery.php'?'active':'');?>">Gallery</a></li>
              <?php } ?>
              <?php if($this->session->userdata('userid') && $this->session->userdata('usertype') == 0){?>
                <li><a href="manageaccounts" class = "<?php echo ($content == 'manageaccounts.php'?'active':'');?>">Client Management</a></li>
              <?php } ?>
              <?php if($this->session->userdata('userid') && $this->session->userdata('usertype') == 1){?>
                <li><a href="sales?type=1" class = "<?php echo ($content == 'content/sales.php'?'active':'');?>">Sales</a></li>
              <?php } ?>
              <?php if($this->session->userdata('userid') && $this->session->userdata('usertype') == 0){?>
                <li><a href="sales?type=0" class = "<?php echo ($content == 'content/sales.php'?'active':'');?>">Sales</a></li>
              <?php } ?>
              <?php if(!$this->session->userdata('userid')){?>
                <li><a href="sales?type=0" class = "<?php echo ($content == 'content/registration.php'?'active':'');?>">Register</a></li>
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
	  
	  <!-- modal info -->
    <div class="modal fade" id = "modal_notif" tabindex="-1" role="dialog">
		<div class="modal-dialog" style = "width: 95% !important">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="title-promo">Notifications</h4>
				</div>
				<div class="modal-body">
					<div class = "row">
						<div class="col-md-6 colmd">
							<a class="main-button" href="#" id="NewNotification">New Notification<i class="fa fa-angle-right"></i></a>
							<div id="newnotif-div"> 
								<table id="newnotif_list" class="display" cellspacing="0" width="100%"></table>
							</div>
							<div class="hr5" style="margin-top:10px; margin-bottom:10px;"></div>
							
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Exit</button>
						<!--button type="button" id= "btn-Enroll" class="btn btn-primary">Enroll</button-->
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
	</div>
    <!-- end modal -->
	  
      <!-- End Header ( Logo & Naviagtion ) -->
	      <!-- javascripts -->
<script type="text/javascript" src="assets/js/notification.js"></script>