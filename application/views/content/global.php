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
            <h2>Services</h2>
          </div>
          <div class="col-md-6">
            <ul class="breadcrumbs">
              <li><a href="?content=home.php">Home</a></li>
              <li>Services</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <!-- End Page Banner -->


    <!-- Start Content -->
    <div id="content">
      <div class="container">
        <div class = "row">
          <textarea id = "questions"></textarea>
    		<button class="btn btn-primary btn-sm" id="btn-saveQ" data-toggle="tooltip" data-placement="top" title="Save Changes"><span class = "glyphicon glyphicon-floppy-save"></span> </button>
      </div>
      <div class = "row">
       <input type ="text" name = "interest" id = "interest" placeholder="Interest Name">
       <select id = "interest_type" >
          <option value = "0">Sports</option>
          <option value = "1">Arts</option>
       </select>
    <button class="btn btn-primary btn-sm" id="btn-saveInterest" data-toggle="tooltip" data-placement="top" title="Save Interest"><span class = "glyphicon glyphicon-floppy-save"></span> </button>
      </div>
      </div>
    </div>
    <!-- End Content -->

    <!-- javascripts -->
    <script type="text/javascript" src="assets/js/global.js"></script>
