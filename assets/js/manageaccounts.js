function getClients(){
	$('#tbl-client').DataTable( {
		"bProcessing":true,	
		"bServerSide":true,
		"bRetrieve": true,
		"bDestroy":true,
		"sLimit":10,
		"pagingType": "simple",
        "sDom": '<"top">rt<"bottom"flp><"clear">',
		"sAjaxSource": "manageaccounts/dataTables/2",
		"aoColumns":[
						{"sTitle":"User ID"},
						{"sTitle":"Name"},
						{"sTitle":"Username"},
						{"sTitle":"Birthday","bSearchable": true},
						{"sTitle":"Contact Number","bSearchable": true},
						{"sTitle":"Email","bSearchable": true},
						{"sTitle":"Registered Date","bSearchable": true},
						{"sTitle":"Status","bSearchable": true},
						{"sTitle":"Actions"}
		],
		"fnRowCallback": function( nRow, aData, iDisplayIndex ) {
			if ( aData[8] == 1 ){
				var btn = "",trial = "";
				if(aData[7] == 'ACTIVE'){
					btn = '<button class = "btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Deactivate Account" onclick="turn_off('+aData[0]+',2);"><i class = "fa fa-power-off"></i></button>&nbsp;';
				}else{
					btn = '<button class = "btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="Activate Account" onclick="turn_off('+aData[0]+',1);"><i class = "fa fa-power-off"></i></button>&nbsp;';
				}
				$('td:eq(8)', nRow).html(btn+'<button class = "btn btn-danger btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="Delete Account" onclick="deleteAccount('+aData[0]+')"><i class = "fa fa-remove"></i></button>&nbsp;');
			}
		},
		"fnInitComplete": function(oSettings, json) {
		}
	}).on('processing.dt',function(oEvent, settings, processing){
	});
}

$(document).ready(function(){
	getClients();
});

function deleteAccount(id){
	if(confirm("Are you sure you want to remove this User permanently?")){
		$.ajax({
			url: 'manageaccounts/deleteAccount/'+id,
			dataType:'JSON',
			success:function(msg){
				var table = $("#tbl-client").DataTable();
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
		url: 'manageaccounts/deactivateAccount/'+id+"/"+t,
		dataType:'JSON',
		type:'POST',
		success: function(msg){
			var table = $("#tbl-client").DataTable();
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
