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
<link rel="stylesheet" href="assets/css/bootstrap-multiselect.css" type="text/css"/>

<!-- Start Page Banner -->
    <div class="page-banner no-subtitle">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h2>Events and Promos</h2>
				</div>
				<div class="col-md-6">
					<ul class="breadcrumbs">
						<li><a href="?content=home.php">Home</a></li>
						<li>Events and Promos</li>
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
				<div class="tabs-section">
					<!-- Nav Tabs -->
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tab-events" data-toggle="tab"><span class = "glyphicon glyphicon-ok"></span>Events</a></li>
						<li><a href="#tab-promos" data-toggle="tab"><span class = "glyphicon glyphicon-bell"></span>Promos</a></li>
					</ul>
					<!-- Tab panels -->
					<div class="tab-content">
						<!-- Tab Content Events -->
						<div class="tab-pane fade in active" id="tab-events">
							<button class="btn btn-primary btn-sm" id="btn-addEvents" data-toggle="tooltip" data-placement="top" title="Add Events"><span class = "glyphicon glyphicon-plus"></span></button>
							<div class="hr5" style="margin-top:10px; margin-bottom:10px;"></div>
							<div id='calendar_events'></div>
						</div>
						<!-- Tab Content Promos -->
						<div class="tab-pane fade" id="tab-promos">
							<button class="btn btn-primary btn-sm" id="btn-addPromos" data-toggle="tooltip" data-placement="top" title="Add Promos"><span class = "glyphicon glyphicon-plus"></span></button>
							<div class="hr5" style="margin-top:10px; margin-bottom:10px;"></div>
							<div id="promo-result"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
      </div>
    </div>
    <!-- End Content -->
  
  
   <!-- modal add events -->
    <div class="modal fade" id = "modal_addevents" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Add Events</h4>
				</div>
				<div class="modal-body">
					<div class = "row">
						<div class="alert" role="alert" style = "display:none"></div>
						<form  id="formaddevents">  
							<div class="col-md-6">
							  <div class = "form-group">
								<label for = "forevent_name">Name</label>
								<input type = "text" placeholder="Event Name" class = "form-control" id = "EventName" name = "EventName"/>
							  </div>
							  <div class = "form-group">
								<label for = "forevent_desc">Description</label>
								<textarea class = "form-control" id = "EventDesc" name = "EventDesc"></textarea>
							  </div>
							  <div class = "form-group">
								<label for = "forevent_for">Services</label>
								<select multiple="multiple" class="chosenElement" id = "EventFor" name = "EventFor"></select>
							  </div>
							</div>
							<div class = "col-md-6">
							  <div class = "form-group">
								<label for = "forevent_stdate">Start Date</label>
								<input type="text" placeholder="Start Date" class = "form-control" id = "EventStartDate" name = "EventStartDate"/>
							  </div>
							   <div class = "form-group">
								<label for = "forevent_endate">End Date</label>
								<input type="text" placeholder="End Date" class = "form-control" id = "EventEndDate" name = "EventEndDate"/>
							  </div>
							  <div class = "form-group">
								<label for = "forevent_location">Location</label>
								<input type="text" placeholder="Location" class = "form-control" id = "EventLocation" name = "EventLocation"/>
							  </div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Exit</button>
						<button type="button" id= "btn-saveEvents" class="btn btn-primary">Save</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
	</div>
    <!-- end modal -->
	
	<!-- modal add promo -->
    <div class="modal fade" id = "modal_addpromos" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="title-promo">Add Promos</h4>
				</div>
				<div class="modal-body">
					<div class = "row">
						<div class="alert" role="alert" style = "display:none"></div>
						<form  id="formaddpromo">  
							<div class="col-md-6">
							  <div class = "form-group">
								<label for = "forpromo_name">Name</label>
								<input type = "text" placeholder="Promo Name" class = "form-control" id = "PromoName" name = "PromoName"/>
							  </div>
							  <div class = "form-group">
								<label for = "forpromo_desc">Description</label>
								<textarea class = "form-control" id = "PromoDesc" name = "PromoDesc"></textarea>
							  </div>
							</div>
							<div class = "col-md-6">
							  <div class = "form-group">
								<label for = "forpromo_term">Start Date</label>
								<input type="text" placeholder="Start Date" class = "form-control" id = "PromoStartDate" name = "PromoStartDate"/>
							  </div>
							  <div class = "form-group">
								<label for = "forpromo_date">End Date</label>
								<input type="text" placeholder="End Date" class = "form-control" id = "PromoEndDate" name = "PromoEndDate"/>
							  </div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Exit</button>
						<button type="button" id= "btn-savePromos" class="btn btn-primary">Save</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
	</div>
    <!-- end modal -->

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
                    <label for = "securitypwd"><?=$this->session->userdata('securityquestion');?></label><input type = "password" placeholder="Service Name" class = "form-control" id = "sec_pwd" name = "sec_pwd"/>
                  </div>
                </div>
              </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Exit</button>
            <button type="button" id= "btn-continue" class="btn btn-primary">Save</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  </div>
    <!-- end modal -->
	
	<!-- modal alert -->
    <div class="modal fade" id = "modal_alert" tabindex="-1" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Authentication</h4>
          </div>
          <div class="modal-body">
            <div id="message-alert"></div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Exit</button>
			  </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  </div>
    <!-- end modal -->
  
  
    <!-- javascripts -->
<script type="text/javascript" src="assets/js/events_and_promos.js"></script>
<script src='assets/fullcalendar/lib/moment.min.js'></script>
<!--script src='assets/fullcalendar/lib/jquery.min.js'></script-->
<script src='assets/fullcalendar/fullcalendar.min.js'></script>
<script src='assets/js/jquery.datetimepicker.full.min.js'></script>
<script type="text/javascript" src="assets/js/bootstrap-multiselect.js"></script>
	
	