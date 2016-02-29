<style>
  #content-services .modal-dialog {
    width 95%; /* or whatever you wish */
  }
   #map {
        width: 500px;
        height: 400px;
      }

</style>
<?php
  $clinicstatus = $this->session->userdata('clinic_status');
?>
<!-- Start Page Banner -->
    <div class="page-banner no-subtitle">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <h2>Clinic Profile</h2>
          </div>
          <div class="col-md-6">
            <ul class="breadcrumbs">
              <li><a href="?content=home.php">Home</a></li>
              <li>Clinic Profile</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <!-- End Page Banner -->

<!-- hidden text boxes -->
<input type = "hidden" id = "action_type"/>
<!-- removing services, set this textbox below of the service id that will be deleted -->
<input type = "hidden" id = "sid"/> 

<!-- update/add indicator for Instructors -->
<input type="hidden" id = "instHiddenVal"/>

<!-- type to delete. 1-services,2-instructors, 3-students -->
<input type="hidden" id = "deleteType"/>

<input type = "hidden" id = "txtHiddenService" value = "">
    <!-- Start Content -->
    <div id="content">
      <div class="container">
        
        <div class="row sidebar-page"> 
            <div class="page-content" id = "content-services">
            <!-- picture -->
            <div class = "col-md-1">
                <div class = "row">
                  <img src="assets/images/<?php echo $clubpic;?>" class="img-circle" style = "width:80px; height:80px; cursorpointer;" id = "clubimage" data-toggle = "popover" data-placement = "top" title = "Click here to change picture.">
                   <input type="file" name="clubpic" id="clubpic" accept="image/*" style = "display:none"/>
                </div>
                 <!-- end picture -->
              </div>
              <div class = "col-md-4">

                <div class="row">
                  <div class="col-sm-10">
                    <button class="btn btn-primary btn-sm" id="btn-update" data-toggle="tooltip" data-placement="top" title="Save Changes" <?php echo ($clinicstatus==0)?'disabled':'';?>><span class = "glyphicon glyphicon-floppy-save" ></span> </button>
                  </div>
                </div>
              </div>
              <div class="col-md-8">
                <br/>
              <div class="alert" role="alert" style = "displaynone"></div>

                <form class="form-horizontal" id = "form-clinic">
                  
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Clinic Name</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="clinic_name" name = "clinic_name" placeholder="Club Name" value = "<?=ucfirst($data->clinic_name);?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Owner Name </label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" value = "<?=ucfirst($this->session->userdata('name'));?>" disabled>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Location</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="SPLocation" name = "SPLocation" placeholder="Location" value = "<?=ucfirst($data->SPLocation);?>">
                      <input type="hidden" class="form-control" id="latitude" name = "latitude" value="<?php echo $data->latitude;?>">
                      <input type="hidden" class="form-control" id="longitude" name = "longitude" value="<?php echo $data->longitude;?>">
                      <span class = "glyphicon glyphicon-map-marker" style = "cursor:pointer !important;" id = "showmap" data-toggle="tooltip" data-placement="top" title="Click to show map"></span>
                    </div>

                  </div>
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">About Us</label>
                    <div class="col-sm-10">
                      <textarea id = "SPAboutMe" name = "SPAboutMe"><?=ucfirst($data->SPAboutMe);?></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Subscription Type</label>
                    <div class="col-sm-10">
                      <select  id = "SubscType" name = "SubscType" class = "form-control" disabled>
                        <option value="1" <?php echo($data->SubscType==1)?'selected':'';?>>Trial</option>
                        <option value="2" <?php echo($data->SubscType==2)?'selected':'';?>>Premium</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Subscription Plan Expiry Date</label>
                    <div class="col-sm-10">
                      <p><?php echo date('F d Y',strtotime($data->SubscEndDate));?></p>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Subscription Plan Status</label>
                    <div class="col-sm-10">
                      <p><?php 
                      if($data->SubscType==2){
                        if($data->SubsStatus==1 && (strtotime($data->SubscEndDate) > strtotime(date('Y-m-d'))))
                        {
                           $datetime1 = date_create($data->SubscEndDate);
                            $datetime2 = date_create(date('Y-m-d'));
                            $interval = date_diff($datetime2, $datetime1);
                          echo "<p class='text-success'>Paid. <p class='text-info'>You have ".$interval->format('%R%a days')." remaining.</span></p>";
                        }else if($data->SubsStatus==0){
                          echo "<p class='text-danger'>Unpaid. Please settle your balance for you to Manage Services Module.</p><button class='btn btn-info btn-sm' id='btn-paynow' data-toggle='tooltip' data-placement='top' title='Pay Now'><i class ='fa fa-cc-visa fa-2x'></i>&nbsp;<i class ='fa fa-cc-paypal fa-2x'></i>&nbsp;</i>&nbsp;<i class ='fa fa-credit-card fa-2x'></i>&nbsp;Pay Now</button>";
                        }else{
                          echo "<p class='text-info'>Your subscription has expired. Renew your subscription to continue using this service.</p>";
                        }
                      }else{
                          if(strtotime($data->SubscEndDate) > strtotime(date('Y-m-d'))){

                            $datetime1 = date_create($data->SubscEndDate);
                            $datetime2 = date_create(date('Y-m-d'));
                            $interval = date_diff($datetime2, $datetime1);
                            echo "<p class='text-info'>You have ".$interval->format('%R%a days')." remaining. <button class='btn btn-info btn-sm' id='btn-paynow' data-toggle='tooltip' data-placement='top' title='Upgrade/Renew Subscription'><span class ='glyphicon glyphicon-king'></span>&nbsp;Upgrade to Premium</button></p>";
                          }else{
                            echo "<p class='text-danger'>Your Free Trial has expired. You can upgrade your account to Premium to enjoy this service.</p><button class='btn btn-info btn-sm' id='btn-paynow' data-toggle='tooltip' data-placement='top' title='Upgrade/Renew Subscription'><span class ='glyphicon glyphicon-king'></span>&nbsp;Upgrade to Premium</button>";
                          }
                      }?></p>
                      
                    </div>
                  </div>
                </form>
              </div>
             </div>
          </div>
        </div>
      </div>
    </div>

    <!-- modal add Room -->
      <div class="modal fade" id = "modal_addRoom" tabindex="-1" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Add Room</h4>
            </div>
            
            <div class="modal-body">
              <div class = "row" style ="margin:3%">
                <form  id="formaddRoom">  
                    <div class = "form-group">
                      <label for = "RoomNo">Room # </label>
                      <input type = "text" placeholder="Room #" class = "form-control" id = "RoomNo" name = "RoomNo" onkeypress = "numbersOnly(this.value,this.name)"/>
                    </div>
                    <div class = "form-group">
                      <label for = "RoomName">Room Name </label>
                      <input type="text" class = "form-control" id = "RoomName" name = "RoomName" placeholder = "Room Name"/>
                    </div>
                    <div class = "form-group">
                      <label for = "RoomStatus">Status</label>
                      <select placeholder="Status" class = "form-control chosen-select" id = "RoomStatus" name = "RoomStatus">
                        <option value = "0">Inactive</option>
                        <option value = "1">Active</option>
                      </select>
                    </div>
                </form>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Exit</button>
              <button type="button" id= "btn-saveRoom" class="btn btn-primary">Save Room</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->
    </div>
  <!-- end Room modal -->

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

  
    <!-- End Content -->
    <!-- javascripts -->
  <script type="text/javascript" src="assets/js/services.js"></script>
  <script>
var autocomplete;

function initAutocomplete() {
  // Create the autocomplete object, restricting the search to geographical
  // location types.
  autocomplete = new google.maps.places.Autocomplete(
      /** @type {!HTMLInputElement} */(document.getElementById('SPLocation')),
      {types: ['geocode']});

  // When the user selects an address from the dropdown, populate the address
  // fields in the form.
  autocomplete.addListener('place_changed', fillInAddress);
}

// [START region_fillform]
function fillInAddress() {
  // Get the place details from the autocomplete object.
  var place = autocomplete.getPlace();
      var lat=place.geometry.location.lat();
      var lng = place.geometry.location.lng();
      $("#latitude").val(lat), $("#longitude").val(lng);
}

</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAoJ0WgzkdpMew-6H3IB1JpVk8Gq_Sxxl0&signed_in=true&sensor=false&libraries=places&callback=initAutocomplete"
         async defer>
</script>