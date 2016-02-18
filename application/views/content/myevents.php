<style>
  #modal_viewlist .modal-dialog {
    width: 95%; /* or whatever you wish */
  }
  #calendar {
	/*max-width: 900px;*/
	margin: 0 auto;
  }
</style>
<link href='assets/css/jquery.datetimepicker.css' rel='stylesheet' />
<link href='assets/fullcalendar/fullcalendar.css' rel='stylesheet' />
<link href='assets/fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />

<!-- Start Page Banner -->
    <div class="page-banner no-subtitle">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h2>My Events</h2>
				</div>
				<div class="col-md-6">
					<ul class="breadcrumbs">
						<li><a href="?content=home.php">Home</a></li>
						<li>My Events</li>
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
			<div class="page-content" id = "content-events-promos">
				<div id='calendar_events'></div>
			</div>
		</div>
      </div>
    </div>
    <!-- End Content -->
  
    <!-- javascripts -->
<script type="text/javascript" src="assets/js/myevents.js"></script>
<script src='assets/fullcalendar/lib/moment.min.js'></script>
<!--script src='assets/fullcalendar/lib/jquery.min.js'></script-->
<script src='assets/fullcalendar/fullcalendar.min.js'></script>
<script src='assets/js/jquery.datetimepicker.full.min.js'></script>
	
	