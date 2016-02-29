<div id="message">
<div style="padding: 5px;">
    <div id="inner-message" class="alert alert-error">
    </div>
</div>
</div>
<div id="content">
    <div class="container">
     
       <div class = "row">
        <div class = "col-xs-6 col-md-2">&nbsp;
          </div>
          <div class = "col-xs-6 col-md-8">
            <div class="jumbotron">
            <img alt="" src="assets/images/logo.png" style = "margin-left: -8%;position: absolute;margin-top: -11%;z-index: 2147483647;">
          <h3 class="classic-title"><span>Registration</span></h3>
              <div class = "row">
              <div class = "col-xs-9" style = "margin-left:92px">
                <form id = "form-reg">  
                    <div class = "form-group">
                      <select class = "form-control" id = "UserType" name = "UserType" placeholder="User Type">
                          <option value = "">Select User Type</option>
                          <option value = "1">Service Provider</option>
                          <option value = "2">Client</option>
                      </select>
                    </div>
                    <div class = "form-group">
                     <select class = "form-control" id = "SubscType" name = "SubscType" placeholder="Subscription type">
                          <option value = "">Select Subscription Type</option>
                          <option value = "2">Premium</option>
                          <option value = "1">Free 30 Day Trial</option>
                      </select>
                    </div>
                      <div class = "form-group">
                        <label for = "spfirstname">First Name :</label>
                        <input type = "text" class = "form-control" id = "spfirstname" name = "spfirstname" placeholder="First Name"/>
                      </div>
                      <div class = "form-group">
                        <label for = "splastname">Last Name :</label>
                        <input type = "text" class = "form-control" id = "splastname" name = "splastname" placeholder="Last Name"/>
                      </div>
                      <div class = "form-group">
                        <label for = "spbirthday">Birthday :</label>
                        <input type = "text" class = "form-control" id = "spbirthday" name = "spbirthday" placeholder="Birthday"/>
                      </div>
                      <div class = "form-group">
                        <label for = "SPContactNo">Contact # :</label>
                        <input type = "text" class = "form-control" id = "SPContactNo" name = "SPContactNo" placeholder="Contact Number"/>
                      </div>
                      <div class = "form-group">
                        <label for = "country">Address :</label>
                        <input type = "text" class = "form-control" id = "SPAddress" name = "SPAddress" placeholder="Address" />
                        <input type = "hidden" class = "form-control" id = "longitude" name = "longitude"/>
                        <input type = "hidden" class = "form-control" id = "latitude" name = "latitude" />
                      </div>
                  <div class = "form-group">
                      <label for = "UserName" id="label_reguname" data-placement="right" data-toggle="popover">Username : </label>
                      <input type = "text" class = "form-control" id = "UserName" name = "UserName" placeholder="Username"/>
                    </div>
                    <div class = "form-group">
                      <label for = "Password" id="label_regpwd" data-placement="top" data-toggle="popover">Enter Password : <span class ="text-info">Minimum of 8 and maximum of 10 characters.</span></label>
                      <input type = "password" class = "form-control" id = "Password" name = "Password" placeholder="Enter Password"/>
                    </div>
                    <div class = "form-group">
                      <label for = "regconfirmpwd" id="label_regconfirmpwd" data-placement="top-right" data-toggle="popover">Re-enter Password :</label>
                      <input type = "password" class = "form-control" id = "regconfirmpwd" name = "regconfirmpwd" placeholder="Re-enter Password"/>
                    </div>
                    <div class = "form-group">
                      <label for = "SPEmail" id="label_spemail" data-placement="top-right" data-toggle="popover">Email :</label>
                      <input type = "text" class = "form-control" id = "SPEmail" name = "SPEmail" placeholder="Email"/>
                    </div>
                    <div class = "row" style="float:right">
                      <button type="button" id = "btn-reg" class="btn btn-primary">Register</button>
                    </div>
                <!-- End Services Icons -->
                    
                </form>

              </div>

        </div>
    </div>
  </div>
</div>
</div>
</div>
<script type="text/javascript" src="assets/js/firstlogin.js"></script>
