<style>
  #subscribers-content .modal-dialog {
    width: 95%; /* or whatever you wish */
  }
</style>

<input type = "hidden" id = "planEdit" />
<!-- Start Page Banner -->
    <div class="page-banner no-subtitle">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h2>Manage Subscribers</h2>
				</div>
				<div class="col-md-6">
					<ul class="breadcrumbs">
						<li><a href="?content=home.php">Home</a></li>
						<li>Subscribers</li>
					</ul>
				</div>
			</div>
		</div>
    </div>
    <!-- End Page Banner -->


    <!-- Start Content -->
    <div id="content">
		<div class="container" id = "subscribers-content">
			<div class="row sidebar-page">
				<!-- Page Content -->
				<div class="page-content">
					<!-- Classic Heading -->
					<h4 class="classic-title"><span>Subscribers</span></h4> 
					
					<!-- Divider -->
					<div class="hr5" style="margin-top:30px; margin-bottom:45px;"></div>
					<div class="tabs-section" id = "tab-subscription">
			        <!-- Nav Tabs -->
			        <ul class="nav nav-tabs">
			        	<li class="active"><a href="#tab-subscribers" data-toggle="tab"><i class="fa fa-group"></i>Subscribers</a></li>
			          	<li><a href="#tab-settings" data-toggle="tab"><i class="fa fa-gear"></i>Subscription Settings</a></li>
			        </ul>
			        <!-- Tab panels -->
			      	<div class="tab-content">

			          <!-- Tab Content 1 -->
			          <div class="tab-pane fade in active" id="tab-subscribers">
			      		<!-- Divider -->
							<div class="hr5" style="margin-top:30px; margin-bottom:45px;"></div>
			           		<table id="tbl-subscribers" class="display" cellspacing="0" width="100%"></table>
			          </div>
			          <div class="tab-pane fade in" id="tab-settings">
                <button class="btn btn-primary btn-sm" id="btn-addPlan" data-toggle="tooltip" data-placement="top" title="New Plan" >New Plan</button>
                <div class="hr5" style="margin-top:30px; margin-bottom:45px;"></div>
			      		   <table id="tbl-sub_plan" class="display" cellspacing="0" width="100%"></table>
			      		<!-- Divider -->
						<div class="hr5" style="margin-top:30px; margin-bottom:45px;"></div>
			          </div>
			        </div>
			      </div>
					
				</div>
				<!-- End Page Content-->



			</div>
		</div>
    </div>
    <!-- End Content -->
	
    
    <!-- modal add plan-->
    <div class="modal fade" id = "modal_plan" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Create Subscription Plan</h4>
				</div>
				<div class="modal-body">
					<div class = "row">
						<div class = "col-xs-9">
							<form id = "frm-sp">  
								<div class = "form-group">
									<label for = "PlanName">Plan Name </label>
									<input type = "text" class = "form-control" id = "PlanName" name = "PlanName" placeholder="Plan Name" />
								</div>
                <div class = "form-group">
                  <label for = "PlanDesc">Description </label>
                  <textarea class = "form-control" id = "PlanDesc" name = "PlanDesc" placeholder="Description">
                  </textarea>
                </div>
                <div class = "form-group">
                  <label for = "PlanPrice">PRICE </label>
                  <input type = "text" class = "form-control" id = "PlanPrice" name = "PlanPrice" placeholder="Price" />
                </div>
                <div class = "form-group">
                  <label for = "PlanTerm">Plan Term </label>
                  <input type = "text" class = "form-control" id = "PlanTerm" name = "PlanTerm" placeholder="Enter number of Years, days or Month" onkeypress="numbersOnly(this.value,this.id)" />
                </div>
                <div class = "form-group">
                  <select class = "form-control chosen-select" id = "ymd" name = "ymd">
                    <option value = 'Y'>Year(s)</option>
                    <option value = 'M'>Month(s)</option>
                    <option value = 'D'>Day(s)</option>
                  </select>
                </div>
							</form>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary" id = "saveplan">Save Plan</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
	</div>
	<!-- end modal -->
	
	 <!-- modal add Payment method -->
      <div class="modal fade" id = "modal_payment" tabindex="-1" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Upgrade to Premium</h4>
            </div>
            
            <div class="modal-body">
              <div class = "row" style ="margin:3%">
                <form  id="formpaymentMethod">  
                  <div class="tabs-section" id = "tab-management">
                    <!-- Nav Tabs -->
                    <ul class="nav nav-tabs">
                    <input type = "hidden" id = "spid"/>
                      <li class="active"><a href="#tab-creditcard" data-toggle="tab"><i class="fa fa-credit-card"></i>Credit Card</a></li>
                    </ul>
                    <!-- Tab panels -->
                  <div class="tab-content">
                      <!-- Tab Content 1 -->
                      <div class="tab-pane fade in active" id="tab-creditcard">
                        <div class = "form-group">
                          <label for = "cardno">Card Number </label>
                          <input type = "text" placeholder="Card Number" class = "form-control" onkeypress = "numbersOnly(this.value,this.name)" id = "cardno" name = "cardno"/>
                        </div>
                        <div class = "form-group">
                          <label for = "cardholdername">Cardholder's Name </label>
                          <div class = "row">
                            <div class = "col-md-4">
                              <input type="text" class = "form-control" id = "cfirstname" name = "cfirstname" placeholder = "First Name"/>
                            </div>
                            <div class = "col-md-4">
                              <input type="text" class = "form-control" id = "clastname" name = "clastname" placeholder = "Last Name"/>
                            </div>
                          </div>
                        </div>
                        <div class = "form-group">

                          <label for = "cardholdername">Expiry Date </label><br/>
                          <div class = "row">
                            <div class = "col-md-4">
                              <input type="text" class = "form-control" id = "expdatemonth" name = "expdatemonth" placeholder = "mm" onkeypress = "numbersOnly(this.value,this.name)" maxlength="2"/>
                            </div>

                            <div class = "col-md-4">
                              <input type="text" class = "form-control" id = "expdateyear" name = "expdateyear" placeholder = "yyyy" maxlength = "4"/>
                            </div>
                          </div>
                        </div>
                        <div class = "form-group">
                          <label for = "ccv">CCV / CCV </label>
                          <input type="text" class = "form-control" id = "ccv" name = "ccv" placeholder = "" onkeypress = "numbersOnly(this.value,this.name)" maxlength = "4"/>
                        </div>
                      </div>
                      <div class="tab-pane fade in" id="tab-paypal">
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Exit</button>
              <button type="button" id= "btn-checkout" class="btn btn-primary">Continue</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->
    </div>
  <!-- end payment method modal -->
	
    <!-- javascripts -->
    <script type="text/javascript" src="assets/js/subscribers.js"></script>
	
	