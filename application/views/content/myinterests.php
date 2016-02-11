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
					<h2>My Interest</h2>
				</div>
				<div class="col-md-6">
					<ul class="breadcrumbs">
						<li><a href="?content=home.php">Home</a></li>
						<li>My Interest</li>
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
            <div class="page-content" id = "content-reviews-ratings">
				<button class="btn btn-primary btn-sm" id="btn-addInterest" data-toggle="tooltip" data-placement="top" title="Add Interest"><span class = "glyphicon glyphicon-plus"></span></button>
				<div class="hr5" style="margin-top:10px; margin-bottom:10px;"></div>
				<table id="myinterest_list" class="display" cellspacing="0" width="100%"></table>
			</div>
        </div>
      </div>
    </div>
    <!-- End Content -->
  
    <!-- modal add interests -->
	<div class="modal fade" id = "modal_interest" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="title-promo">Interest</h4>
				</div>
				<div class="modal-body">
					<div class = "row">
						<div class="alert" role="alert" style = "display:none"></div>
						<form  id="formschedule">  
							<div class="col-md-6">
							  <div class = "form-group">
								<label for = "forsched_name">Type</label>
								<select class = "form-control" id = "interest_type" name = "interest_type">
									<option value=0>Arts</option>
									<option value=1>Sports</option>
								</select>
							  </div>
							  <div class = "form-group">
								<label for = "forsched_name">Interest Names</label>
							  </div>
							  <div class = "form-group">
								<select multiple="multiple" class="chosenElement" id = "interest_id" name = "interest_id"></select>
							  </div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Exit</button>
						<button type="button" id= "btn-saveInterest" class="btn btn-primary">Save</button>
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
                    <label for = "securitypwd"><?=$this->session->userdata('securityquestion');?></label><input type = "password" placeholder="Password" class = "form-control" id = "sec_pwd" name = "sec_pwd"/>
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
    <!-- javascripts -->
<script type="text/javascript" src="assets/js/myinterests.js"></script>
<script src='assets/fullcalendar/lib/moment.min.js'></script>
<script src='assets/fullcalendar/fullcalendar.min.js'></script>
<script src='assets/js/jquery.datetimepicker.full.min.js'></script>
<script type="text/javascript" src="assets/js/bootstrap-multiselect.js"></script>