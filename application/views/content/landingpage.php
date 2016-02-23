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
			  	<?php if($this->input->get('type') == 1){ ?>
		 			<h3 class="classic-title"><span>Registration Completed!</span></h3>
		 			<p><h6>Congratulations! Your registration has been completed. We sent you your verification Link. Please check your email to activate your account. You have 24 hours before your verification link expired.</h6></p>
		 		<?php }else if($this->input->get('type') == 3){
		 					if(!$this->input->get('id')){
		 			?>	

		 				<div class = "row">
	 						<form class = "frm-resetpassword">
	 							<div class = "row">
	 								<div class = "form-group">
	 									<label>Please type your email</label>
	 									<input type="text" id="email" name = "email" class = "form-control"/>
	 								</div>
	 							</div>
	 						</form>
	 						<button type="button" class="btn btn-lg btn-primary" id="resetpwd">RESET PASSWORD</button>
	 					</div>
		 			<?php
		 				}
		 				else{
		 				?><input type = "hidden" id = "resetiduser" value="<?=$this->input->get('id');?>"/>
		 					<div class = "row">
		 						<div class = "row" style = "margin: 5px">
			                        <form id = "form-resetpassword-req">  
			                          <div class = "form-group">
			                            <label for = "newpwd1" id="label_newpwd" data-placement="top" data-toggle="popover">New Password : <span class ="text-info">Minimum of 8 and maximum of 10 characters.<span></label>
			                            <input type = "password" class = "form-control" id = "newpwd1" name = "newpwd1" placeholder="New Password">
			                          </div>
			                          <div class = "form-group">
			                            <label for = "con_newpwd1" id="label_con_newpwd1" data-placement="top" data-toggle="popover">Confirm New Password :</label>
			                            <input type = "password" class = "form-control" id = "con_newpwd1" name = "con_newpwd1" placeholder="Confirm New Password" disabled>
			                          </div>
			                        </form>
			                        <button class="btn btn-primary" id = "btn-newPwd1" data-placement="top" data-toggle="tooltip" data-placement="top" title="Save Changes" disabled><span class="glyphicon glyphicon-floppy-save"></span>SAVE CHANGES</button>
		 					</div>
		 				<?php
		 				}
		 			}else { switch($data){ case 1:?>
		 					<h3 class="classic-title"><span>Account Verification Error!</span></h3>
		 					<p><h6>Your account has already been verified and activated.</h6></p>
				 		<?php break;case 2:?>
				 			<h3 class="classic-title"><span>Account Verification Error!</span></h3>
		 					<p><h6>Your account has been verified. You can now login to your account.</h6></p>
				 		<?php break; case 3: ?>
				 			<h3 class="classic-title"><span>Account Verified!</span></h3>
		 					<p><h6>Your account has been verified. You can now login to your account.</h6></p>
				 		<?php break; case 4: ?>
				 			<h3 class="classic-title"><span>Account Verification Error!</span></h3>
		 					<p><h6>Can't verify at this time. Plase try again later.</h6></p>
				 		<?php break; case 5: ?>
				 			<h3 class="classic-title"><span>Account Verification Error!</span></h3>
		 					<p><h6>Verification code is invalid. Your account does not exist.</h6></p>
				 		<?php break; case 6: ?>
				 			<h3 class="classic-title"><span>Account Verification Error!</span></h3>
		 					<p><h6>Your Verification Link has expired. Type your email below to re-send your new verification link.</h6>
		 					</p>
		 					<div class = "row">
		 						<form class = "frm-verify">
		 							<div class = "row">
		 								<div class = "form-group">
		 									<label>Please type your email</label>
		 									<input type="text" id="email" name = "email" class = "form-control"/>
		 								</div>
		 							</div>
		 						</form>
		 						<button type="button" class="btn btn-lg btn-primary">RESEND LINK</button>
		 					</div>
				 		<?php break; }?>
		 		<?php } ?>
		 			<h6 class = "classic-title"><span> <a href="login"> >> Go back to Homepage</a></span></h6>
				</div>
		  	</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="assets/js/firstlogin.js"></script>