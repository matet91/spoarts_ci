$(document).ready(function(){
	$("#btn-login").click(function(){
		login();
	});

	

	$('#password').on('keydown', function(e){
		if(e.which == 13){
			login();
		}
	});
	//registration 
	$("#btn-reg").click(function(){
		register();

	});
	$("#register,#register2").click(function(){
		initAutocomplete('SPAddress');
		var height = $(window).height();
		var dialogHeight = $("#modal_registration").find('.modal-dialog').outerHeight(true);
    	var top = parseInt(height)/5-parseInt(dialogHeight);
		$("#modal_registration").modal('show');
		
	});

	//username validation
	$("#UserName").change(function(){
		checkusername();
	});

	//validate passsword
	$("#regconfirmpwd").change(function(){
		comparepassword('Password','regconfirmpwd','label_regconfirmpwd','SPEmail');
	});

	//validate EMAIL
	$("#SPEmail").change(function(){
		checkEmail();
	});

	//if user type is equal to service provide enable subscription type else disabled it for client user
	$("#UserType").change(function(){
		if($(this).val() == 1){
			$("#SubscType").removeAttr('disabled');
		}else{
			$("#SubscType").attr('disabled','disabled');
			$("#message .alert").html("Please Skip Step 2: Subscription Plan.").addClass("alert-info").show();$("#message").addClass('zindex');
			setTimeout(function(){
				$("#message .alert").html("").removeClass("alert-info").hide();$("#message").removeClass('zindex');
			},3000);
		}
	});
	//check password length

	$("#regconfirmpwd").focus(function(){
		$('#SPEmail').removeAttr('disabled');
		var p1 = $("#Password").val();
		if(p1.length > 10){
			$("#Password").parent().addClass('has-error');
			$("#label_regpwd").attr('title',"<p class = 'text-danger'>Password is too long. It should not be more than 10 characters.</p>").popover({
						html:true
			}).popover('show');
			setTimeout(function(){
				$("#label_regpwd").popover('hide');
				$('#label_regpwd').popover('destroy');
			},2000);
		}else if(p1.length < 8){
			$("#Password").parent().addClass('has-error');
			$("#label_regpwd").attr('title',"<p class = 'text-danger'>Password is too short. It should not be less than 8 characters.</p>").popover({
						html:true
			}).popover('show');
			setTimeout(function(){
				$("#label_regpwd").popover('hide');
				$('#label_regpwd').popover('destroy');
			},2000);
		}else{
			$("#label_regpwd").attr('title',"<p class = 'text-danger'>Good Password.</p>").popover({
						html:true
			}).popover('show');
			setTimeout(function(){
				$("#label_regpwd").popover('hide');
				$('#label_regpwd').popover('destroy');
			},2000);
		}

		if(p1 == ''){
			$("#Password").parent().addClass('has-error');
			$("#label_regpwd").attr('title',"<p class = 'text-danger'>Password should not be empty.</p>").popover({
						html:true
			}).popover('show');
			setTimeout(function(){
				$("#label_regpwd").popover('hide');
				$('#label_regpwd').popover('destroy');
				$('#SPEmail').attr('disabled','disabled');
			},2000);
		}
	});
	
});

function login(){
	var loginData = $("#loginForm").serializeArray();
		var ph = [];
		$.each(loginData,function(i,e){
			if(e.value == ''){
				$("#"+e.name).parent().parent().addClass('has-error');// addclass to its parent div with class form-group for empty textboxes
			}else{
				$("#"+e.name).parent().parent().removeClass('has-error');
			}
		});
		var count = $(".has-error").length; //coutn how many textboxes is in red border or empty
		if(count > 0){
			$(".switcher-box span#error").attr('title',"<div style = 'color:red'>Please enter your username/password</div>").popover({
				html:true
			}).popover('show');
			setTimeout(function(){
				$(".switcher-box span#error").popover('hide');
				$("#loginForm input").parent().parent().removeClass('has-error');
			},2000);
			
		}else{
			$('#loader').show();
			$.ajax({
				url:'login/authenticate',
				data:{pwd:$("#password").val(),uname:$("#username").val()},
				dataType:'JSON',
				type:'POST',
				success:function(msg){
					$('#loader').fadeOut();
					if(msg[0] == 1){

						$("#message .alert").html("").removeClass('alert-danger').hide();$("#message").removeClass('zindex');
						if(msg[1] == "0"){
							window.location = "subscribers";
						}else if(msg[1] == "1"){
							window.location = "services";
						}else{
							window.location = "index";
						}
						
					}else if(msg == 2){//inactive
						$("#message .alert").html("Your account has not been verified. Please check your email. We sent you a new verification code.").addClass('alert-danger').show();$("#message").addClass('zindex');
							setTimeout(function(){
								$("#message .alert").html("").removeClass('alert-danger').hide();$("#message").removeClass('zindex');
							},3500);
					}else if(msg == 3){
						$("#message .alert").html("Your account is inactive. You may send an email request to spoarts.cebu@gmail.com to activate your account.").addClass('alert-danger').show();$("#message").addClass('zindex');
							setTimeout(function(){
								$("#message .alert").html("").removeClass('alert-danger').hide();$("#message").removeClass('zindex');
							},3500);
					}else if(msg == 0){
						$("#message .alert").html("Account not exist.").addClass('alert-danger').show();$("#message").addClass('zindex');

						setTimeout(function(){
							$("#message .alert").html("").removeClass('alert-danger').hide();$("#message").removeClass('zindex');
						},3500);
					}else{

						$("#message .alert").html("Incorrect Username/Password.").addClass("alert-danger").show();$("#message").addClass('zindex');
						setTimeout(function(){
							$("#message .alert").html("").removeClass('alert-danger').hide();$("#message").removeClass('zindex');
						},3500);
					}

				}
			});
		}
}

function register(){
	var regdata = $("#form-reg").serializeArray(),err=new Array();

	$.each(regdata, function(i,e){
		var name = $("#"+e.name);
		if(e.value == ""){
			name.parent().addClass("has-error");
			err.push(name.attr('placeholder'));
		}else{
			name.parent().removeClass("has-error");
		}
	});

	var count = $("#form-reg .has-error").length;
	if(count > 0){
		$("#message .alert").html(err.toString()+" should not be empty. All fields are required!").addClass('alert-danger').show();$("#message").addClass('zindex');
	}else{
		$("#message .alert").html("").removeClass('alert-danger').hide();$("#message").removeClass('zindex');

		saveRegister();
	}
}


function checkusername(){
	var uname = $('#UserName').val();

	if(uname == ''){
		$("#UserName").parent().addClass('has-error');
		$("#label_reguname").attr('title',"<p class = 'text-danger'>Don't leave this field blank.</p>").popover({
					html:true
		}).popover('show');
		setTimeout(function(){
			$("#label_reguname").popover('hide');
			$('#label_reguname').popover('destroy');
		},2000);
	}else{
		$("#Password").removeAttr('disabled');
		$.ajax({
			url:'login/checkusername',
			data:{uname:$("#UserName").val()},
			dataType:'JSON',
			type:'POST',
			success: function (msg){
				if(msg == 1){
					$("#UserName").parent().addClass('has-error');
					$("#label_reguname").attr('title',"<p class = 'text-danger'>Username is not avaialble.</p>").popover({
								html:true
					}).popover('show');
					setTimeout(function(){
						$("#label_reguname").popover('hide');
						$('#label_reguname').popover('destroy');
					},3000);
				}else{

					$("#UserName").parent().removeClass('has-error');
					$("#label_reguname").attr('title',"<p class = 'text-success'>Available.</p>").popover({
								html:true
					}).popover('show');
					setTimeout(function(){
						$("#label_reguname").popover('hide');
						$('#label_reguname').popover('destroy');
					},3000);
				}
			}
		});
	}
}

function checkEmail(){
	var email = $("#SPEmail").val();
	$.ajax({
		url:'login/checkEmail',
		dataType:'JSON',
		data:{email:email},
		type:'POST',
		success:function(msg){
			if(msg == 0){
				$("#btn-reg").removeAttr('disabled');
				$("#label_spemail").attr("title","<p class = 'text-success'>Available.</p>").popover({
								html:true
					}).popover('show');
				setTimeout(function(){
						$("#label_spemail").popover('hide');
						$('#label_spemail').popover('destroy');
					},3000);
			}else{
				$("#btn-reg").attr('disabled','disabled');
				$("#SPEmail").parent().addClass('has-error');
					$("#label_spemail").attr('title',"<p class = 'text-danger'>Email is already in registered by different user.</p>").popover({
								html:true
					}).popover('show');
					setTimeout(function(){
						$("#label_spemail").popover('hide');
						$('#label_spemail').popover('destroy');
					},3000);
			}
		}
	});
}

function saveRegister(){
	$("#btn-reg").attr("disabled","disabled");
	var frmdata = $("#form-reg").serializeArray(),data={};
	$.each(frmdata, function(i,e){
		if(e.name != 'regconfirmpwd'){
			data[e.name] = e.value;
		}
		
	});
	$('#loader').show();
	$.ajax({
		url: 'login/saveRegister',
		dataType:'JSON',
		data:{data:data},
		type:'POST',
		success:function(msg){
			$('#loader').fadeOut();
			if(msg == true){
				window.location = "landingpage?type=1";
			}else{
				$("#message .alert").html("An error occurred. Please try again later.").addClass('alert-danger').show();$("#message").addClass('zindex');
			}
		}
	})
}

