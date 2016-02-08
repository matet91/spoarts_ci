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
					<h2>Reviews and Ratings</h2>
				</div>
				<div class="col-md-6">
					<ul class="breadcrumbs">
						<li><a href="?content=home.php">Home</a></li>
						<li>Reviews and Ratings</li>
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
				<div class="tabs-section">
					<!-- Nav Tabs -->
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tab-approved" data-toggle="tab"><span class = "glyphicon glyphicon-ok"></span>Approved</a></li>
						<li><a href="#tab-pending" data-toggle="tab"><span class = "glyphicon glyphicon-bell"></span>Pending</a></li>
						<li><a href="#tab-disapproved" data-toggle="tab"><span class = "glyphicon glyphicon-remove"></span>Disapproved</a></li>
					</ul>
					<!-- Tab panels -->
					<div class="tab-content">
						<!-- Tab Content Approved -->
						<div class="tab-pane fade in active" id="tab-approved">
							<!-- approved -->
						</div>
						<!-- Tab Content Pending -->
						<div class="tab-pane fade" id="tab-pending">
							<!-- Pending -->
						</div>
						<!-- Tab Content Disapproved -->
						<div class="tab-pane fade" id="tab-disapproved">
							<!-- disapproved -->
						</div>
					</div>
				</div>
			</div>
        </div>
      </div>
    </div>
    <!-- End Content -->
  
    <!-- modal add reviews and rating -->

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
    <!-- javascripts -->
    <script type="text/javascript" src="assets/js/reviews_and_ratings.js"></script>