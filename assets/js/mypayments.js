$(document).ready(function() {
	$(".chzn-select").chosen();
	var height = $(window).height();
 
	$("#interest_type").change(function (){
		getselInterest($(this).val());
	});
	
	$("#btn-addInterest").click(function (e){
		e.preventDefault();
		var dialogHeight = $("#modal_interest").find('.modal-dialog').outerHeight(true);
		var top = parseInt(height)/3-parseInt(dialogHeight);
		$("#modal_interest").modal('show').attr('style','top:'+top+'px !important');
	});
	$("#btn-saveInterest").click(function (e){
		e.preventDefault();
		var interestid = $("#interest_id").chosen().val()
		
		$.ajax({
			url:'myinterests/saveInterest/',
			data:{interestid:interestid},
			dataType:'JSON',
			type:'POST',
			success:function(msg){ 
				if(msg == 2){
					$("#message .alert").html($("#interest_id option:selected").text()+" has been added successfully.").addClass("alert-success").show();
				}else{
					$("#message .alert").html("An error occurred during the process. Please try again later or contact the administrator.").addClass('alert-danger').show();
				}
				
				setTimeout(function(){
					$("#message .alert").html("").removeClass('alert-success').hide();
					$("#message .alert").html("").removeClass('alert-danger').hide();
					$("#modal_security .alert").html("").removeClass('alert-success').hide();
					$("#modal_security").hide();
					window.location = 'myinterests';
				},2000);
			}
		});
	});
	
	getlistinterest();
	getselInterest($("#interest_type").val());
} );

function getlistinterest(){
	var height = $(window).height();
	$('#mypayment_list').DataTable( {
		"bJQueryUI":true,
		"sPaginationType":"simple",
		"bProcessing":true,	
		"bServerSide":true,
		"bInfo": true,
		"bRetrieve": true,
		"bDestroy":true,
		"sLimit":10,
		"dom": 'T<"clear">lfrtip',
		"sPaginationType":"simple",
		"sAjaxSource": "service_provider/dataTables/4",
		"aoColumns":[	{"sTitle":"ID","bVisible":false},
						{"sTitle":"Date","bSearchable": true},
						{"sTitle":"Amount","bSearchable": true},
						{"sTitle":"Balance","bSearchable": true},
						{"sTitle":"Description","bSearchable": true},
						{"sTitle":"Student","bSearchable": true},
						{"sTitle":"Type","bSearchable": true}
		],
		"fnInitComplete": function(oSettings, json) {
		}
	}).on('processing.dt',function(oEvent, settings, processing){
	});
}

function removeIntererst(interestid){
	var height = $(window).height();
	var dialogHeight = $("#modal_security").find('.modal-dialog').outerHeight(true);
	var top = parseInt(height)/4-parseInt(dialogHeight);
	$("#modal_security").modal('show').attr('style','top:'+top+'px !important;');
	  
	$("#modal_security #btn-continue").click(function(){
		var pwd = $("#modal_security #sec_pwd");

		if(pwd.val() == ''){
			pwd.parent().addClass('has-error');
			$("#modal_security .alert").html("Please enter the password of your security question.").addClass('alert-danger').show();
		}else{
			pwd.parent().removeClass('has-error');
			$("#modal_security .alert").html("").removeClass("alert-danger").hide();
			checkSecurityPwds(pwd.val(),"removeIntererst",interestid);
		}
	});
}

function checkSecurityPwds(pwd,type,id){
  $.ajax({
    url:'services/checkSecurityPwd',
    dataType:'JSON',
    type:'POST',
    data:{pwd:pwd},
    success:function(msg){
		if(msg == 1){ //if correct
			//$("#modal_security").hide();
			if(type == "removeIntererst"){
				deleteInterest(id,pwd);
			}
		}else{//incorrect password
			$("#modal_security #sec_pwd").parent().addClass('has-error');
			$("#modal_security .alert").html("Incorrect Password.").addClass("alert-danger").show();
		}
    }
  });
}

function deleteInterest(interestid,pwd){
	$.ajax({
    url:'myinterests/deleteInterest',
    dataType:'JSON',
    type:'POST',
    data:{interestid:interestid},
    success:function(msg){
		if(msg == 1){
			$("#message .alert").html("Interest has been successfully deleted.").addClass("alert-success").show();
		}else{
			$("#message .alert").html("An error occurred during the process. Please try again later or contact the administrator.").addClass('alert-danger').show();
		}
		setTimeout(function(){
			$("#message .alert").html("").removeClass('alert-success').hide();
			$("#message .alert").html("").removeClass('alert-danger').hide();
			$("#modal_security .alert").html("").removeClass('alert-success').hide();
			$("#modal_security").hide();
			window.location = 'myinterests';
		},2000);
    }
  });
}

function getselInterest(type){
	$.ajax({
		url:'myinterests/getselInterest/'+type,
		dataType:'JSON',
		type:'POST',
		success:function(msg){ 
			var result = "";
			$("#interest_id").html("");
			$.each(msg, function(i,e){
				result += '<option value='+e.interest_id+'>'+e.interest_name+'</option>';	
			});			
			$("#interest_id").append(result);	
			$('#interest_id').chosen();
			$('#interest_id').trigger("chosen:updated");
			$('#interest_id_chosen').css({ width: "550px" });
		}
    });
}

