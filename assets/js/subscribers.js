$(document).ready(function() {
	getSubscribers();
	getSubscriptionPlan();
    $('#btn-checkout').click(function(){

      validateForm(5);
  });
    $("#btn-addPlan").click(function(){
    	$("#modal_plan").modal('show');
    });

    $('#saveplan').click(function(){
    	savePlan();
    });
} );

function view_studinstruct(serviceid){
	var height = $(window).height();
	var dialogHeight = $("#modal_viewlist").find('.modal-dialog').outerHeight(true);
	var top = parseInt(height)/3-parseInt(dialogHeight);
	$("#modal_title").html("Warning!");
	$("#modal_bodytext").html("Please complete all fields with red marks!");
	$("#modal_viewlist").modal('show').attr('style','top:'+top+'px !important');
	
	getstudents();
	
}

function getstudents(){
	var height = $(window).height();
	$('#students_list').DataTable( {
		"bJQueryUI":true,
		"sPaginationType":"simple",
		"bProcessing":true,	
		"bServerSide":true,
		"bInfo": true,
		"bRetrieve": true,
		"bDestroy":true,
		"sLimit":10,
		"sAjaxSource": "subscribers/dataTables/2",
		"aoColumns":[	{"sTitle":"ID","bVisible":false},
						{"sTitle":"Name","bSearchable": true},
						{"sTitle":"Address","bSearchable": true},
						{"sTitle":"Age","bSearchable": true},
						{"sTitle":"Member Since","bSearchable": true},
						{"sTitle":"Client","bSearchable": true},
						{"sTitle":"Actions"}
		],
		"fnRowCallback": function( nRow, aData, iDisplayIndex ) {
			if ( aData[6] == "1" ){
				$('td:eq(4)', nRow).html('<button class = "btn btn-primary" data-toggle="tooltip" data-placement="top" title="View Profile" id="view_history" onclick="view_profile('+aData[0]+');"><i class = "fa fa-eye"></i></button>' );
			}
		},
		"fnInitComplete": function(oSettings, json) {
		}
	}).on('processing.dt',function(oEvent, settings, processing){
	});
}

function getSubscribers(){
	$('#tbl-subscribers').DataTable( {
		"bProcessing":true,	
		"bServerSide":true,
		"bRetrieve": true,
		"bDestroy":true,
		"sLimit":10,
		"pagingType": "simple",
        "sDom": '<"top">rt<"bottom"flp><"clear">',
		"sAjaxSource": "subscribers/dataTables/2",
		"aoColumns":[	{"sTitle":"subscription","bVisible":false},
						{"sTitle":"User ID"},
						{"sTitle":"Name"},
						{"sTitle":"Username"},
						{"sTitle":"Name of Clinic","bSearchable": true},
						{"sTitle":"Birthday","bSearchable": true},
						{"sTitle":"Contact Number","bSearchable": true},
						{"sTitle":"Email","bSearchable": true},
						{"sTitle":"Registered Date","bSearchable": true},
						{"sTitle":"Subscription Type","bSearchable": true},
						{"sTitle":"Status","bSearchable": true},
						{"sTitle":"Actions"}
		],
		"fnRowCallback": function( nRow, aData, iDisplayIndex ) {
			if ( aData[11] == 1 ){
				var btn = "",trial = "";
				if(aData[10] == 'ACTIVE'){
					btn = '<button class = "btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Deactivate Account" onclick="turn_off('+aData[1]+',2);"><i class = "fa fa-power-off"></i></button>&nbsp;';
				}else{
					btn = '<button class = "btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="Activate Account" onclick="turn_off('+aData[1]+',1);"><i class = "fa fa-power-off"></i></button>&nbsp;';
				}

				if(aData[0] == 1){
					trial = "<button class='btn btn-info btn-xs'onclick='upgradeToPremium("+aData[1]+")' data-toggle='tooltip' data-placement='top' title='Upgrade/Renew Subscription'><i class ='fa fa-star'></i></button>";
				} 

				$('td:eq(10)', nRow).html('<button class = "btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="View Profile" onclick="viewprofile('+aData[1]+')"><i class = "fa fa-eye"></i></button>&nbsp;'+btn+'<button class = "btn btn-danger btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="Delete Account" onclick="deleteAccount('+aData[1]+')"><i class = "fa fa-remove"></i></button>&nbsp;'+trial);
			}
		},
		"fnInitComplete": function(oSettings, json) {
		}
	}).on('processing.dt',function(oEvent, settings, processing){
	});
}

//get all service providers
function viewprofile(id){
	 $('#loader').show();
	window.location = "sp_profile?susid="+id;
}

function turn_off(id,t){
	switch (t){
		case 1: //activates
				var err = "Account is now inactive.";
		break
		case 2: //deactivates
				var err = "Account is now active.";
		break;
	}
	$.ajax({
		url: 'subscribers/deactivateAccount/'+id+"/"+t,
		dataType:'JSON',
		type:'POST',
		success: function(msg){
			var table = $("#tbl-subscribers").DataTable();
			if(msg == true){
				$("#message .alert").html(err).addClass("alert-success").show();$("#message").addClass('zindex');
				setTimeout(function(){
					$("#message .alert").html("").removeClass('alert-success').hide();$("#message").removeClass('zindex');
				},2000);
			}else{
				$("#message .alert").html("Unable to process your request.").addClass("alert-danger").show();$("#message").addClass('zindex');
				setTimeout(function(){
					$("#message .alert").html("").removeClass('alert-danger').hide();$("#message").removeClass('zindex');
				},2000);

			}
			table.ajax.reload();
		}
	});
}

function deleteAccount(id){
	if(confirm("Are you sure you want to remove this User permanently?")){
		$.ajax({
			url: 'subscribers/deleteAccount/'+id,
			dataType:'JSON',
			success:function(msg){
				var table = $("#tbl-subscribers").DataTable();
				if(msg == true){
					$("#message .alert").html("Account and other information related to that user has been deleted permanently.").addClass("alert-success").show();$("#message").addClass('zindex');
					setTimeout(function(){
						$("#message .alert").html("").removeClass('alert-success').hide();$("#message").removeClass('zindex');
					},2000);
				}else{
					$("#message .alert").html("Unable to process your request.").addClass("alert-danger").show();$("#message").addClass('zindex');
						setTimeout(function(){
							$("#message .alert").html("").removeClass('alert-danger').hide();$("#message").removeClass('zindex');
						},2000);
				}
				table.ajax.reload();
			}
		});
	}
}

function upgradeToPremium(userid){
	$('#spid').val(userid);
	$("#modal_payment").modal('show');
}
function validateForm(){

  var frmid = "formpaymentMethod  ",
            modal = "modal_payment",
            frmdata = $("#"+frmid).serializeArray(),data={},
            userid = $("#spid").val();
  $.each(frmdata, function(i,e){
        var name = $("#"+e.name);
        if(e.value == ""){
            name.parent().addClass("has-error");
        }else{   
            name.parent().removeClass('has-error');
            data[e.name] = e.value;
        }
  }); 
  var count = $("#"+modal+" .has-error").lentgh;
  if(count > 0){
    $("#message .alert").html("All fields are required").addClass("alert-danger").show();$("#message").addClass('zindex');
    setTimeout(function(){
      $("#message .alert").html("").removeClass('alert-danger').hide();$("#message").removeClass('zindex');
    },1500);
  }else{

            saveData(data,userid);
  }
}

function saveData(data,userid){
          var url = "services/paypal/"+1+"/"+userid, 
              errorMsg = "Successfully Upgraded to Premium.",
               frmid = "formpaymentMethod",
	            modal = "modal_payment";
//get how many div is using 'has-error' class
var error = $("#"+frmid+" .has-error").length;
  if(error > 0){
    $("#message .alert").append(" All fields are required.").addClass('alert-danger').show();$("#message").addClass('zindex');
  }else{
    $("#message .alert").html("").removeClass('alert-danger').hide();$("#message").removeClass('zindex');
    $('#loader').show();
    $.ajax({
      url:url,
      data:{data},
      dataType:'JSON',
      type:'POST',
      success:function(msg){
        $('#loader').fadeOut();
        if(msg == true){

            $("#message .alert").html(errorMsg).addClass("alert-success").show();$("#message").addClass('zindex');

            $.each(frmid, function(i,e){
              $("#"+e.name).val("");
            });
            setTimeout(function(){
              $("#message .alert").html("").removeClass("alert-success").hide();$("#message").removeClass('zindex');
              $("#"+modal).modal('hide');
            },1500);
             $('#spid').val('');
        }else{
          $("#message .alert").html("System Error. Please try again later or report this error to spoarts.cebu@gmail.com.").addClass("alert-success").show();$("#message").addClass('zindex');
        }
        setTimeout(function(){
          window.location = 'subscribers';
        },2000);
        
      }
    });
  }
}


function getSubscriptionPlan(){
	var height = $(window).height();
	$('#tbl-sub_plan').DataTable( {	
		"bProcessing":true,	
		"bServerSide":true,
		"bInfo": true,
		"bRetrieve": true,
		"bDestroy":true,
		"sLimit":10,
		"sAjaxSource": "subscribers/dataTables/3",
		"aoColumns":[	{"sTitle":"ID","bVisible":false},
						{"sTitle":"Plan Name","bSearchable": true},
						{"sTitle":"Description","bSearchable": true},
						{"sTitle":"Price","bSearchable": true},
						{"sTitle":"Plan Term","bSearchable": true},
						{"sTitle":"Actions"}
		],
		"fnRowCallback": function( nRow, aData, iDisplayIndex ) {
			if ( aData[5] == "1" ){
				$('td:eq(4)', nRow).html('<button class = "btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Delete" onclick="removeItem('+aData[0]+');"><i class = "fa fa-remove"></i></button>&nbsp;<button class = "btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" title="Edit Record" onclick="editItem('+aData[0]+');"><i class = "fa fa-pencil"></i></button>' );
			}
		},
		"fnInitComplete": function(oSettings, json) {
		}
	}).on('processing.dt',function(oEvent, settings, processing){
	});
}

function removeItem(id){
	if(confirm("Are you sure you want to remove this item?")){
	$.ajax({
		url: 'subscribers/removeItem/'+id,
		dataType:'JSON',
		success: function(msg){
			var table = $("#tbl-sub_plan").DataTable();
			if(msg == true){
				$("#message .alert").html("Deleted record successfully").addClass("alert-success").show();$("#message").addClass('zindex');
			    setTimeout(function(){
			      $("#message .alert").html("").removeClass('alert-success').hide();$("#message").removeClass('zindex');
			    },2000);
			}else{
				$("#message .alert").html("Can't delete this record. Please try again.").addClass("alert-danger").show();$("#message").addClass('zindex');
			    setTimeout(function(){
			      $("#message .alert").html("").removeClass('alert-danger').hide();$("#message").removeClass('zindex');
			    },2000);
			}
			table.ajax.reload();
		}
	});
}
}

function savePlan(){

	var frm = $("#frm-sp").serializeArray(),data={},
		url = '',edit = $("#planEdit").val(),err='';
	if(edit!=''){
		url = 'subscribers/updatePlan/'+edit;
		err = 'Record updated successfully.';
	}else{
		url = 'subscribers/savePlan';
		err = 'New Plan has successfully added.';
	}
	$.each(frm, function(i,e){
		var name = $("#"+e.name);
		if(e.value == ''){
			name.parent().addClass('has-error');
		}else{
			if(e.name != 'ymd'){
				if(e.name == 'PlanTerm'){
					data[e.name] = e.value+""+$("#ymd").val();
				}else{
					data[e.name] = e.value;
					name.parent().removeClass('has-error');
				}
			}
		}
	});

	var len = $("#frm-sp .has-error").length;
	if(len > 0){
		$("#message .alert").html("All fields are required.").addClass("alert-danger").show();$("#message").addClass('zindex');
	    setTimeout(function(){
	      $("#message .alert").html("").removeClass('alert-danger').hide();$("#message").removeClass('zindex');
	    },2000);
	}else{
		$("#message .alert").html("").removeClass('alert-danger').hide();$("#message").removeClass('zindex');
		$.ajax({
			url :url,
			data:{data:data},
			dataType:'JSON',
			type:'POST',
			success:function(msg){
				var table = $("#tbl-sub_plan").DataTable();
				if(msg == true){
					$("#message .alert").html(err).addClass("alert-success").show();$("#message").addClass('zindex');
					    setTimeout(function(){
					      $("#message .alert").html("").removeClass('alert-success').hide();$("#message").removeClass('zindex');
					      $.each(frm,function(i,e){
					      	if(e.name != 'ymd')
					      		$("#"+e.name).val('');
					      		
					      });
					      $("#modal_plan").modal('close');
					    },2000);
				}else{
					$("#message .alert").html("Error occurred.").addClass("alert-danger").show();$("#message").addClass('zindex');
				    setTimeout(function(){
				      $("#message .alert").html("").removeClass('alert-danger').hide();$("#message").removeClass('zindex');
				    },2000);
				}
				table.ajax.reload();
			}
		});
	}
}

function editItem(id){
	$("#planEdit").val(id);
	getData(id);
	$("#modal_plan").modal('show');
	$("#modal_plan .title").html('Edit Plan');

}

function getData(id){
	$.ajax({
		url:'subscribers/getPlanRow/'+id,
		dataType:'JSON',
		success:function(msg){
			var frm = $("#frm-sp").serializeArray();
			$.each(frm,function(i,e){
				var name = e.name;
				if(name == 'PlanTerm')
					$("#"+name).val(parseInt(msg[0][name]));
				else{
					if(name !='ymd')
						$("#"+name).val(msg[0][name]);
				}

			});
		}
	});
}