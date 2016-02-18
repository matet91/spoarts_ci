$(document).ready(function() {
	getSubscribers();

    $('#btn-checkout').click(function(){

      validateForm(5);
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
				$("#message .alert").html(err).addClass("alert-success").show();
				setTimeout(function(){
					$("#message .alert").html("").removeClass('alert-success').hide();
				},2000);
			}else{
				$("#message .alert").html("Unable to process your request.").addClass("alert-danger").show();
				setTimeout(function(){
					$("#message .alert").html("").removeClass('alert-danger').hide();
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
					$("#message .alert").html("Account and other information related to that user has been deleted permanently.").addClass("alert-success").show();
					setTimeout(function(){
						$("#message .alert").html("").removeClass('alert-success').hide();
					},2000);
				}else{
					$("#message .alert").html("Unable to process your request.").addClass("alert-danger").show();
						setTimeout(function(){
							$("#message .alert").html("").removeClass('alert-danger').hide();
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
    $("#message .alert").html("All fields are required").addClass("alert-danger").show();
    setTimeout(function(){
      $("#message .alert").html("").removeClass('alert-danger').hide();
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
    $("#message .alert").append(" All fields are required.").addClass('alert-danger').show();
  }else{
    $("#message .alert").html("").removeClass('alert-danger').hide();
    $('#loader').show();
    $.ajax({
      url:url,
      data:{data},
      dataType:'JSON',
      type:'POST',
      success:function(msg){
        $('#loader').fadeOut();
        if(msg == true){

            $("#message .alert").html(errorMsg).addClass("alert-success").show();

            $.each(frmid, function(i,e){
              $("#"+e.name).val("");
            });
            setTimeout(function(){
              $("#message .alert").html("").removeClass("alert-success").hide();
              $("#"+modal).modal('hide');
            },1500);
             $('#spid').val('');
        }else{
          $("#message .alert").html("System Error. Please try again later or report this error to spoarts.cebu@gmail.com.").addClass("alert-success").show();
        }
        setTimeout(function(){
          window.location = 'subscribers';
        },2000);
        
      }
    });
  }
}
