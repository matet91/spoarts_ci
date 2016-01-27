$(document).ready(function(){
	var height = $(window).height();
	

	$("#btn-update-profile").click(function(){
		var dialogHeight = $("#modal_profile").find('.modal-dialog').outerHeight(true);
    	var top = parseInt(height)/5-parseInt(dialogHeight);
		$('#modal_profile').modal('show').attr('style','top:'+top+'px !important');
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
		comparepassword();
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

function comparepassword(){
	var p1 = $("#regpwd").val();
	var p2 = $("#regconfirmpwd").val();
	
	if(p1 == p2){
		$("#label_regconfirmpwd").attr('title',"<p class = 'text-success'>Password matched.</p>").popover({
					html:true
		}).popover('show');
		setTimeout(function(){
			$("#label_regconfirmpwd").popover('hide');
			$('#label_regconfirmpwd').popover('destroy');
		},2000);
	}else{
		$("#regconfirmpwd").parent().addClass('has-error');
		$("#label_regconfirmpwd").attr('title',"<p class = 'text-danger'>Password does not match.</p>").popover({
					html:true
		}).popover('show');
		setTimeout(function(){
			$("#label_regconfirmpwd").popover('hide');
			$("#regconfirmpwd").parent().removeClass('has-error');
			$('#label_regconfirmpwd').popover('destroy');
			$('#regemail').attr('disabled','disabled');
		},1000);
	}
}