$(document).ready(function(){
	listInterest();
	$("#saveSQSettings").click(function(){
		saveSQSettings();

	});

	$("#btn-saveInterest").click(function(){
		saveInterest();

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
	console.log
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