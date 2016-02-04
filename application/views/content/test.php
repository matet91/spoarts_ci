<div style = "position:fixed; top:0; width:100%; text-align:center;">
	<div class = "alert" id = "error" style = "display:none">dsfdsf</div>
</div>
<div class="container-fluid" style = "margin-top:100px;padding:26px; margin-left:100px">
 	<div class = "row">
 	<!-- form for the person's details -->
 		<form id = "frm-addPerson">
 			<div class = "col-md-6">
	 			<div class = "form-group">
	 				<label>First Name :</labe>
	 					<input type = "text" id = "p_firstname" name = "p_firstname"/>
	 			</div>
	 			<div class = "form-group">
	 				<label>Last Name :</labe>
	 					<input type = "text" id = "p_lastname" name = "p_lastname"/>
	 			</div>
 			</div>
 			<div class = "col-md-6">
	 			<div class = "form-group">
	 				<label>Age :</labe>
	 					<input type = "text" id = "p_age" name = "p_age"/>
	 			</div>
 			</div>
 			
 		</form>
 		<button id = "btnSavePerson" class = "btn btn-primary">Add Person</button>
 		<!-- table list for the persons -->
 		<div >
 	</div>
 	<br/>
 	<br/>
 	<br/>
 	<br/>
 	<div class= "row">
 		<table id = "tbl-persons" class = "table table-condensed">
 			<thead>No data to show</thead>
 		</table>

 	</div>
</div>
<!-- action type, 2- update 1- delete 0 - insert -->
<input type = "hidden" id= "action_type">
<script src = "assets/js/test.js"></script>