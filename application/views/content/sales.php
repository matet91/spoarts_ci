<style>
  #modal_viewlist .modal-dialog {
    width: 95%; /* or whatever you wish */
  }
  #month_chosen,#year_chosen{
	 width: 95% !important;
  }
  #div-month{
	  margin-bottom: 10px;
  }
</style>
<!-- Start Page Banner -->
    <div class="page-banner no-subtitle">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h2>Sales</h2>
				</div>
				<div class="col-md-6">
					<ul class="breadcrumbs">
						<li><a href="?content=home.php">Home</a></li>
						<li>Sales</li>
					</ul>
				</div>
			</div>
		</div>
    </div>
    <!-- End Page Banner -->

	<input type = "hidden" id = "user_type" value = "<?=$this->input->get('type');?>">
    <!-- Start Content -->
    <div id="content">
      <div class="container">
        <div class="row sidebar-page"> 
            <div class="page-content" id = "content-reviews-ratings">
				<div class="col-md-6">
				  <div class = "form-group">
					<label for = "forrep_type">Report Type</label>
					<select class = "form-control chosen-select" id = "report_type" onchange="repchange($(this).val())" >
						<option value=0>Over All</option>
						<option value=1>Monthly</option>
						<option value=2>Yearly</option>
					</select>
				  </div>
				  <div class = "form-group" id="date" style="display:none">
					<label for = "forrep_date">Date</label>
					<div id="div-month">
					<select class = "form-control chosen-select" id = "month" onchange="reloadtable()">
						<option value="01">January</option><option value="02">February</option><option value="03">March</option>
						<option value="04">April</option><option value="05">May</option><option value="06">June</option>
						<option value="07">July</option><option value="08">August</option><option value="09">September</option>
						<option value="10">October</option><option value="11">November</option><option value="12">December</option>
					</select>
					</div>
					<div id="div-year">
					<select class = "form-control chosen-select" id = "year" onchange="reloadtable()"></select>
					</div>
				  </div>
				</div>
				
				<div class="hr5" style="margin-top:10px; margin-bottom:10px;"></div>
				<table id="mypayment_list" class="display" cellspacing="0" width="100%"></table>
			</div>
        </div>
      </div>
    </div>
    <!-- End Content -->
    <!-- javascripts -->
<script type="text/javascript" src="assets/js/sales.js"></script>