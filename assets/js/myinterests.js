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
					$("#modal_interest .alert").html($("#interest_id option:selected").text()+" has been added successfully.").addClass("alert-success").show();
				}
			}
		});
	});
	
	getlistinterest();
	getselInterest($("#interest_type").val());
} );

function getlistinterest(){
	var height = $(window).height();
	$('#myinterest_list').DataTable( {
		"bJQueryUI":true,
		"sPaginationType":"simple",
		"bProcessing":true,	
		"bServerSide":true,
		"bInfo": true,
		"bRetrieve": true,
		"bDestroy":true,
		"sLimit":10,
		"dom": 'T<"clear">lfrtip',
		 "tableTools": {
					"sRowSelect": "multi",
					"aButtons": [ "print","select_all", "select_none",{"sExtends":'text',"sButtonText":'Delete Selected Record',"fnClick": function ( nButton, oConfig, oFlash ) {
						var oTT = TableTools.fnGetInstance( 'position_list' ),
						aData = oTT.fnGetSelectedData(),
						values = [];

					for(i = 0; i < aData.length; i++){
						values.push(aData[i][0]);
					}
						deldata(values.join(','),2);
					}}]
			},
		"sPaginationType":"simple",
		"sAjaxSource": "service_provider/dataTables/3",
		"aoColumns":[	{"sTitle":"ID","bVisible":false},
						{"sTitle":"Name","bSearchable": true},
						{"sTitle":"Type","bSearchable": true},
						{"sTitle":"Actions"}
		],
		"fnRowCallback": function( nRow, aData, iDisplayIndex ) {
			if ( aData[3] == "1" ){
				$('td:eq(2)', nRow).html('<button class = "btn btn-primary btn-remove" data-toggle="tooltip" data-placement="top" title="Remove Interest" onclick="removeIntererst('+aData[0]+');"><span class = "glyphicon glyphicon-trash"></span></button>' );
			}
		},
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
			$("#modal_security .alert").html("Interest has been successfully deleted.").addClass("alert-success").show();
		}else{
			$("#modal_security .alert").html("An error occurred during the process. Please try again later or contact the administrator.").addClass("alert-success").show();
		}
		setTimeout(function(){
			getlistinterest();
			$("#modal_security .alert").html("").removeClass('alert-success').hide();
			$("#modal_security").hide();
			window.location = 'myinterests';
		},3000);
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
			$("#interest_id").html(result);	
			$('#interest_id').chosen();		
			$('#interest_id_chosen').css({ width: "550px" });
		}
    });
}

