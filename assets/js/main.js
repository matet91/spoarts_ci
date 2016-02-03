$(document).ready(function(){
	$('.modal').on('hidden.bs.modal', function(e){
	      var table = $(".modal .dataTable").DataTable();
	      table.destroy(); 

	  });

	var height = $(window).height();
	$("#spbirthday").datepicker({
		'dateFormat':'yy-mm-dd'
	});
	loadSecurity();
	$("#btn-update-profile").click(function(){
		
		var dialogHeight = $("#modal_profile").find('.modal-dialog').outerHeight(true);
    	var top = parseInt(height)/5-parseInt(dialogHeight);
		$('#modal_profile').modal('show').attr('style','top:'+top+'px !important');
		myprofile();

	});

	$('[data-toggle="tooltip"]').tooltip();

	$("#register").click(function(){
		var dialogHeight = $("#modal_registration").find('.modal-dialog').outerHeight(true);
    	var top = parseInt(height)/5-parseInt(dialogHeight);
		$("#modal_registration").modal('show').attr('style','top:'+top+'px !important');
		
	});

	$("#regbday").datepicker();

	//username validation
	$("#regpwd").focus(function(){
		checkusername();
	});

	//validate passsword
	$("#regemail").focus(function(){
		comparepassword('regpwd','regconfirmpwd','label_regconfirmpwd','regemail');
	});

	//check password length

	$("#regconfirmpwd").focus(function(){
		$('#regemail').removeAttr('disabled');
		var p1 = $("#regpwd").val();
		if(p1.length > 10){
			$("#regpwd").parent().addClass('has-error');
			$("#label_regpwd").attr('title',"<p class = 'text-danger'>Password is too long. It should not be more than 10 characters.</p>").popover({
						html:true
			}).popover('show');
			setTimeout(function(){
				$("#label_regpwd").popover('hide');
				$('#label_regpwd').popover('destroy');
			},2000);
		}else if(p1.length < 8){
			$("#regpwd").parent().addClass('has-error');
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
			$("#regpwd").parent().addClass('has-error');
			$("#label_regpwd").attr('title',"<p class = 'text-danger'>Password should not be empty.</p>").popover({
						html:true
			}).popover('show');
			setTimeout(function(){
				$("#label_regpwd").popover('hide');
				$('#label_regpwd').popover('destroy');
				$('#regemail').attr('disabled','disabled');
			},2000);
		}
	});

$("#btn-saveProfile").click(function(){
	validateProfile();
});

$("#member_pic").click(function(){
	$("#btn-member_pic").click();
});
uploadProfilePhoto();

//security settings open modal
$('#btn-changepwd').click(function(){
	var dialogHeight = $("#modal_secsettings").find('.modal-dialog').outerHeight(true);
	var top = parseInt(height)/5-parseInt(dialogHeight);
	$("#modal_secsettings").modal('show').attr('style','top:'+top+'px !important');
});

//security settings change password login password validation
$("#oldpwd").change(function(){
	verifyPassword(1);
});
$("#secpwd").change(function(){
	verifyPassword(2);
});

$("#newpwd").change(function(){
	//check password length
	var length = $(this).val();
		if(length.length > 10){
			$(this).parent().addClass('has-error');
			$("#label_newpwd").attr('title',"<p class = 'text-danger'>Password is too long. It should not be more than 10 characters.</p>").popover({
						html:true
			}).popover('show');
			setTimeout(function(){
				$("#label_newpwd").popover('hide');
				$('#label_newpwd').popover('destroy');
			},2000);
		}else if(length.length < 8){
			$(this).parent().addClass('has-error');
			$("#label_newpwd").attr('title',"<p class = 'text-danger'>Password is too short. It should not be less than 8 characters.</p>").popover({
						html:true
			}).popover('show');
			setTimeout(function(){
				$("#label_newpwd").popover('hide');
				$('#label_newpwd').popover('destroy');
			},2000);
		}else{
			$(this).parent().removeClass('has-error');
			$("#label_newpwd").attr('title',"<p class = 'text-success'>Good Password.</p>").popover({
						html:true
			}).popover('show');
			$("#con_newpwd").removeAttr('disabled');
			setTimeout(function(){
				$("#label_newpwd").popover('hide');
				$('#label_newpwd').popover('destroy');
			},2000);
		}
});
$("#con_newpwd").change(function(){
	comparepassword('newpwd','con_newpwd','label_con_newpwd','btn-newPwd');
});
});


function checkusername(){
	var uname = $('#reguname').val();

	if(uname == ''){
		$("#reguname").parent().addClass('has-error');
		$("#label_reguname").attr('title',"<p class = 'text-danger'>Don't leave this field blank.</p>").popover({
					html:true
		}).popover('show');
		setTimeout(function(){
			$("#label_reguname").popover('hide');
			$('#label_reguname').popover('destroy');
		},2000);
	}else{
		$("#regpwd").removeAttr('disabled');
		$.ajax({
			url:'login/checkusername',
			data:{uname:$("#reguname").val()},
			dataType:'JSON',
			type:'POST',
			success: function (msg){
				if(msg == 1){
					$("#reguname").parent().addClass('has-error');
					$("#label_reguname").attr('title',"<p class = 'text-danger'>Username is not avaialble.</p>").popover({
								html:true
					}).popover('show');
					setTimeout(function(){
						$("#label_reguname").popover('hide');
						$('#label_reguname').popover('destroy');
					},3000);
				}
				if(msg == 0){

					$("#reguname").parent().removeClass('has-error');
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

function comparepassword(p1val,p2val,p2label,x){
	var p1 = $("#"+p1val).val();
	var p2 = $("#"+p2val).val();
	
	if(p1 == p2){
		$("#"+p2label).attr('title',"<p class = 'text-success'>Password matched.</p>").popover({
					html:true
		}).popover('show');
		setTimeout(function(){
			$("#"+p2label).popover('hide');
			$('#'+p2label).popover('destroy');
		},2000);
		$('#'+x).removeAttr('disabled');
	}else{
		$("#"+p2val).parent().addClass('has-error');
		$("#label_"+p2val).attr('title',"<p class = 'text-danger'>Password does not match.</p>").popover({
					html:true
		}).popover('show');
		$('#'+x).attr('disabled','disabled');
		setTimeout(function(){
			$("#"+p2label).popover('hide');
			$("#"+p2val).parent().removeClass('has-error');
			$('#'+p2label).popover('destroy');
			
		},1000);
	}
}

function myprofile(){

	$.ajax({
		url:'index/loadProfile',
		dataType:'JSON',
		success:function(msg){
			var frmdata = $("#form-updateProfile").serializeArray();
			$.each(frmdata, function(i,e){
				var name = $("#form-updateProfile #"+e.name);
				var idname = e.name;
				name.val(msg[idname]);
			});
		}

	});
}

function loadSecurity(){
	$.ajax({
		url:'index/loadSecurity',
		dataType:'JSON',
		success:function(msg){

			var opt = "";
			$.each(msg,function(i,e){
				opt += "<option value = "+e.sec_id+">"+e.sec_questions+"</option>";
			});

			$("#security_question_id").html(opt);
		}
	});
}

function validateProfile(){
	var frmdata = $("#form-updateProfile").serializeArray(),data={};
	$.each(frmdata, function(i,e){
		var name= $("#"+e.name);
		if(e.value!=''){
			name.parent().removeClass("has-error");
			data[e.name] = e.value;
		}else{
			name.parent().addClass('has-error');
			
		}
	});

	var count = $("#form-updateProfile .has-error").length;

	if(count > 0){
		$("#modal_profile .alert").html("All fields are required.").show().addClass('alert-danger');
	}else{
		$("#modal_profile .alert").html("").removeClass('alert-danger').hide();

		saveProfile(data);
	}
}

function saveProfile(data){
	$.ajax({
		url: 'index/saveProfile',
		data:{data:data},
		dataType:'JSON',
		type:'POST',
		success:function(msg){
			if(msg == 1){
				$("#modal_profile .alert").html("Changes saved. Modal will automatically close.").removeClass('alert-danger').show().addClass('alert-success');
				setTimeout(function(){
					$("#modal_profile").modal('hide');
					window.reload();
				},4000);
				
			}else{
				$("#modal_profile .alert").html("Changes can't be save right now. Please try again later or contact the WebDev Support Team.").show().removeClass('alert-success').addClass('alert-danger');
			}
		}
	});
}

function uploadProfilePhoto(){
  $('#btn-member_pic').change( function(e) {
    var file = this.files[0];
    var fd = new FormData();
    fd.append("member_pic", file);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'index/uploadProfilePhoto', true);
    
    xhr.upload.onprogress = function(e) {
      if (e.lengthComputable) {
        var percentComplete = (e.loaded / e.total) * 100;
        $('#loader').show();
      }
    };
    xhr.onreadystatechange = function() {
        if (this.readyState === 4) {
            if (this.status === 200) {
                $("#member_pic").attr('src',"assets/images/"+xhr.responseText);
                $('#loader').fadeOut();
            }
        }
    };
    xhr.send(fd);
  });
}

function verifyPassword(c){
	
	switch(c){
		case 1: //login password 
			var pwd = $("#oldpwd").val();
		break;

		case 2://security password
			var pwd = $('#secpwd').val();
		break;
	}
	$.ajax({
		url:'index/verifyPassword',
		data:{c:c,pwd:pwd},
		dataType:'JSON',
		type:'POST',
		success:function(msg){
			if(msg == 1){//enable ff input text/select
				$("#modal_secsettings .alert").html('').removeClass('alert-danger').hide();
				switch(c){

					case 1://login password
						$("#oldpwd").parent().removeClass('has-error');
						$("#secpwd").removeAttr('disabled');
					break;
					case 2: //security password validation
						$("#secpwd").parent().removeClass('has-error');
						$("#newpwd").removeAttr('disabled');
					break;
				}
			}else{
				switch(c){
					case 1: //login password
						$("#modal_secsettings .alert").html('Incorrect Login Password.').addClass('alert-danger').show();
						$("#oldpwd").parent().addClass('has-error');
						$("#secpwd").attr('disabled','disabled');
					break;

					case 2://security password
						$("#modal_secsettings .alert").html('Incorrect Login Password.').addClass('alert-danger').show();
						$("#secpwd").parent().addClass('has-error');
						$("#newpwd").attr('disabled','disabled');
					break;
				}
			}
		}
	});
}

function checkSecurityPwd(pwd,t){
  $.ajax({
    url:'services/checkSecurityPwd',
    dataType:'JSON',
    type:'POST',
    data:{pwd:pwd},
    success:function(msg){
      if(msg == 1){ //if correct
      	switch(t){
      		case '1': //save clinic info under services menu of service provider's dashboard
      				saveClinicInfo();
      		break;

      		case '2': //delete service
      				removeData();
      		break;
      	}
      }else{//incorrect password
        $("#modal_security #sec_pwd").parent().addClass('has-error');
        $("#modal_security .alert").html("Incorrect Password.").addClass("alert-danger").show();
      }
    }
  });
}