$(document).ready(function(){
	
	$("#btn-newPwd1").click(function(){
		saveNewPassword(2,$("#resetiduser").val());
	});
	listInterest();
	$("#saveSQSettings").click(function(){
		saveSQSettings();

	});

	$("#btn-saveInterest").click(function(){
		saveInterest();

	});

	$('#resetpwd').click(function(e){
		e.preventDefault();
		resetpassword();
	});

	$("#oldpwd1").change(function(){
		verifyPassword(2);
	});
	$("#newpwd1").change(function(){
	//check password length
	var length = $(this).val();
		if(length.length > 10){
			$(this).parent().addClass('has-error');
			$("#message .alert").html("Password is too long. It should not be more than 10 characters.").addClass('alert-danger').show(); $("#message").addClass('zindex');
			setTimeout(function(){
				$("#message .alert").html("").removeClass('alert-danger').hide(); $("#message").removeClass('zindex');
			},2000);
		}else if(length.length < 8){
			$(this).parent().addClass('has-error');
			  $("#message .alert").html("Password is too short. It should not be less than 8 characters.").addClass('alert-danger').show(); $("#message").addClass('zindex');
			setTimeout(function(){
				$("#message .alert").html("").removeClass('alert-danger').hide(); $("#message").removeClass('zindex');
			},2000);
		}else{
			$(this).parent().removeClass('has-error');
			 $("#message .alert").html("Good Password.").addClass('alert-success').show(); $("#message").addClass('zindex');
			$("#con_newpwd1").removeAttr('disabled');
			setTimeout(function(){
				$("#message .alert").html("").removeClass('alert-success').hide(); $("#message").removeClass('zindex');
			},2000);
		}
	});
	$("#con_newpwd1").change(function(){
		comparepassword('newpwd1','con_newpwd1','label_con_newpwd1','btn-newPwd1');
	});

});

function saveSQSettings(){
	var sq_pwd = $("#sec_pwd").val();

	if(sq_pwd == ''){
		$("#message .alert").html("Please enter your security password.").addClass("alert-danger").show();$("#message").addClass('zindex');
		$("#sec_pwd").parent().addClass('has-error');

		setTimeout(function(){
			$("#message .alert").html("").removeClass("alert-danger").hide();$("#message").removeClass('zindex');
			$("#sec_pwd").parent().removeClass('has-error');
		},3000);
	}else{
		$.ajax({
			url:'index/saveSQSettings',
			data:{sq:$("#security_question_id").val(),sq_pwd:sq_pwd},
			dataType:'JSON',
			type:'POST',
			success:function(msg){
				if(msg == true){
					window.location = "index";
				}else{
					$("#message .alert").html("System Error. Please send an email report to spoarts.cebu@gmail.com regarding this error. Thank you!").addClass("alert-danger").show();$("#message").addClass('zindex');
				}
			}
		});
	}
}

function listInterest(){
	$.ajax({
		url:'index/listInterest',
		dataType:'JSON',
		type:'POST',
		success:function(msg){
			var chk = '<div class="col-md-4">';
			var c = 0;
			$.each(msg,function(i,e){
				var iname = e.interest_name;
				var iid = e.interest_id;
				if(c == 5){
					chk+="</div><div class='col-md-4'>";
					c=0;
				}
				chk+="<label><input type='checkbox' name='chkinterest"+i+"' id='chkinterest"+i+"' value='"+iid+"'>"+iname+"</label><br/>";

				c++;

			});
			chk +="</div>";
			$("#interest_list").html(chk);
		}
	});
}

function saveInterest(){
	var interest=new Array();

	$("input[type='checkbox']:checked").each(function(){
			if($(this).is(":checked"))
				interest.push($(this).val());
	});
	var count = $("input[type='checkbox']:checked").length;
	if(count > 0){
		var sq_pwd = $("#sec_pwd").val();
			$.ajax({
				url:'index/saveInterest',
				data:{interest:interest.toString()},
				dataType:'JSON',
				type:'POST',
				success:function(msg){
					if(msg == true){
						window.location = "index";
					}else{
						$("#message .alert").html("System Error. Please send an email report to spoarts.cebu@gmail.com regarding this error. Thank you!").addClass("alert-danger").show();$("#message").addClass('zindex');
					}
				}
			});
		
	}else{ 
		$("#message .alert").html("Please select your interest.").addClass("alert-danger").show();$("#message").addClass('zindex');
			setTimeout(function(){
				$("#message .alert").html("").removeClass("alert-danger").hide();$("#message").removeClass('zindex');
			},3000);
	}

}

function resetpassword(){
	$('#loader').show();
	var email = $(".frm-resetpassword #email").val();
	if(email == ''){
		$("#message .alert").html("Please type you email.").addClass("alert-danger").show();$("#message").addClass('zindex');
		setTimeout(function(){
			$("#message .alert").html("").removeClass("alert-danger").hide();$("#message").removeClass('zindex');
		},3000);
	}else{
		$.ajax({
			url: 'index/resetpassword',
			data:{email:email},
			dataType:'JSON',
			type:'POST',
			success:function(msg){
				$('#loader').fadeOut();
				if(msg == 0){
					$("#message .alert").html("System Error. Please try again later.").addClass("alert-danger").show();$("#message").addClass('zindex');
					setTimeout(function(){
						$("#message .alert").html("").removeClass("alert-danger").hide();$("#message").removeClass('zindex');
					},3000);
				}else if(msg == 1){
					$("#message .alert").html("We sent you the link to change your password. Please check your email.").addClass("alert-success").show();$("#message").addClass('zindex');
					setTimeout(function(){
						$("#message .alert").html("").removeClass("alert-success").hide();$("#message").removeClass('zindex');
					},3000);
				}else{
					$("#message .alert").html("Email does not exist.").addClass("alert-danger").show();$("#message").addClass('zindex');
					setTimeout(function(){
						$("#message .alert").html("").removeClass("alert-danger").hide();$("#message").removeClass('zindex');
					},3000);
				}
			}
		});
	}
}