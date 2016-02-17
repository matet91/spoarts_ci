$(document).ready(function() {
	getSubscribers();
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
        "info":false,
        "searching":false,
        "sDom": '<"top">rt<"bottom"flp><"clear">',
		"sAjaxSource": "subscribers/dataTables/2",
		"aoColumns":[	{"sTitle":"User ID"},
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
			if ( aData[10] == 1 ){
				$('td:eq(10)', nRow).html('<button class = "btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="View Profile" onclick="viewprofile('+aData[0]+')"><i class = "fa fa-eye"></i></button>&nbsp;<button class = "btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Deactivate Account" id="view_history" onclick="turn_off('+aData[0]+');"><i class = "fa fa-power-off"></i></button>' );
			}
		},
		"fnInitComplete": function(oSettings, json) {
		}
	}).on('processing.dt',function(oEvent, settings, processing){
	});
}

//get all service providers
function viewprofile(id){
	window.location = "sp_profile?susid="+id;
}