<link rel="stylesheet" href="assets/css/jquery.fileupload.css">
<style>
  @charset "UTF-8";

img {
  border: 0;
  vertical-align: middle;
}

.fileupload-progress {
  margin: 10px 0;
}
.fileupload-progress .progress-extended {
  margin-top: 5px;
}
#modal_gallery{
  width: 95% !important;
}

</style>
    <!-- Start Page Banner -->
    <div class="page-banner no-subtitle">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <h2>Gallery</h2>
          </div>
          <div class="col-md-6">
            <ul class="breadcrumbs">
              <li><a href="#">Home</a></li>
              <li>Gallery</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <!-- End Page Banner -->


    <!-- Start Content -->
    <div id="content">
      <div class="container">
        <div class="page-content">
          <!-- Divider -->
          <form>
            <div class = "row">
              <div class = "col-md-6">
                <div class = "form-group">
                  <select id = "albumlist" class = "chosen-select form-control" placeholder="Please select an album">
                  </select>
                </div> 
              </div>
              <div class = "col-md-6">
                <div class = "form-group">
                  <button id = "browserpic" class = "btn btn-primary">Add Files</button> 
                  <input type="file" name="files[]" id = "fileupload" accept="image/*" style = "display:none" multiple/>
                </div>
              </div>
            </div>
          </form>
        
            <!-- The container for the uploaded files -->
            <div id="files" class="files"></div>
          <div class="hr5" style="margin-top:45px; margin-bottom:35px;"></div>

          <!--Start Recent Projects-->
          <div class="recent-projects">
            <div id = "albumDisplay">

            </div>
          </div>
          <!--End Recent Projects-->
          <div class="hr5" style="margin-top:45px; margin-bottom:35px;"></div>
          <!-- The container for the uploaded files -->
          <div class="recent-projects" id="gallery_list">
            <h4 class="title"></h4>
            <div id="gallerydisplay" class = "touch-carousel" style = "display:none"></div>
          </div>
        </div>
      </div>
    </div>
    <!-- modal add album -->
    <div class="modal fade" id = "modal_album" tabindex="-1" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

            <h4 class="modal-title">Create Album</h4>
          </div>
          <div class="modal-body">  
             <form id = "frm-album">
                <div class = "form-group">
                  <label>Album Namme :</label>
                  <input type = "text" id = "albumName" name = "albumName" class = "form-control"/>
                </div>
                <div class = "form-group">
                  <label>Description :</label>
                  <textarea id = "albumDesc" name = "albumDesc" class = "form-control">
                  </textarea>
                </div>
                
            </form>
             <div class="hr5" style="margin-top:30px; margin-bottom:45px;"></div>
         <table id="tbl-paymentlogs" class="display" cellspacing="0" width="100%"></table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id = "btn-saveAlbum">Create Album</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
 <!-- end modal album-->

 <!-- modal gallery -->
    <div class="modal fade" id = "modal_gallery" tabindex="-1" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

            <h4 class="modal-title"></h4>
          </div>
          <div class="modal-body">  
             
             <div class="hr5" style="margin-top:30px; margin-bottom:45px;"></div>
         <table id="tbl-paymentlogs" class="display" cellspacing="0" width="100%"></table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
 <!-- end modal gallery-->
    <!-- End Content -->
    <script src="assets/js/jquery.ui.widget.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="assets/js/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="assets/js/canvas-to-blob.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="assets/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="assets/js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="assets/js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="assets/js/jquery.fileupload-image.js"></script>
<!-- The File Upload validation plugin -->
<script src="assets/js/jquery.fileupload-validate.js"></script>


  <script type="text/javascript" src="assets/js/gallery.js"></script>
