$(document).ready(function() {
	var height = $(window).height();
  


    $(".btn-viewlist").click(function(){
		var dialogHeight = $("#modal_viewlist").find('.modal-dialog').outerHeight(true);
		var top = parseInt(height)/7-parseInt(dialogHeight);
        $("#modal_viewlist").modal('show').attr('style','top:'+top+'px !important');
    });

	/*$('.btn-sm').click(function(e){
		e.preventDefault();
		var dialogHeight = $("#modal_securitypwd").find('.modal-dialog').outerHeight(true);
		var top = parseInt(height)/3-parseInt(dialogHeight);
		$("#modal_securitypwd").modal('show').attr('style','top:'+top+'px !important');
	});*/

	$(".btn-attendance").click(function (){
		$('#studentattendancelog').show('slide');
		$("#studentsInstructor_tab").hide('slide');
	});
	$("#btn-backtotab").click(function(){
		$('#studentattendancelog').hide('slide');
		$("#studentsInstructor_tab").show('slide');
	});
	
	$("#btn-update").click(function(e){
		e.preventDefault();
		var values = {};
		var err=1, add=1;
		$.each($('.form-horizontal').serializeArray(), function(i, field) {
			if(field.value == ""){
				err = 0;
				$("#"+field.name).parent().parent().addClass('has-error has-feedback');
			}else{
				values[field.name] = field.value;
			}	
		});
		
		if (err==1){
			/*var dialogHeight = $("#modal_securitypwd").find('.modal-dialog').outerHeight(true);
			var top = parseInt(height)/3-parseInt(dialogHeight);
			$("#modal_securitypwd").modal('show').attr('style','top:'+top+'px !important');*/
			$.ajax({
				url:'service_provider/addservice',
				type:'POST',
				data:{values:values},
				statusCode: {
                   404: function() {
                     alert( "page not found" );
                   }
                },
				success:function(result){
					alert(result);var dialogHeight = $("#modal_securitypwd").find('.modal-dialog').outerHeight(true);
					var top = parseInt(height)/3-parseInt(dialogHeight);
					$("#modal_title").html("Success!");
					$("#modal_bodytext").html("The data has been successfully added!");
					$("#modal_status").modal('show').attr('style','top:'+top+'px !important');
				}
			});
			
		}else{
			var dialogHeight = $("#modal_securitypwd").find('.modal-dialog').outerHeight(true);
			var top = parseInt(height)/3-parseInt(dialogHeight);
			$("#modal_title").html("Warning!");
			$("#modal_bodytext").html("Please complete all fields with red marks!");
			$("#modal_status").modal('show').attr('style','top:'+top+'px !important');
			
			
		}
	});
  
  getservices();
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
		"sAjaxSource": "service_provider/dataTables/2",
		"aoColumns":[	{"sTitle":"ID","bVisible":false},
						{"sTitle":"Name","bSearchable": true},
						{"sTitle":"Address","bSearchable": true},
						{"sTitle":"Age","bSearchable": true},
						{"sTitle":"Member Since","bSearchable": true},
						{"sTitle":"Client","bSearchable": true},
						{"sTitle":"Actions"}
		],
		"fnRowCallback": function( nRow, aData, iDisplayIndex ) {
			if ( aData[5] == "1" ){
				$('td:eq(5)', nRow).html('<button class = "btn btn-primary btn-attendance" data-toggle="tooltip" data-placement="top" title="View Attendance History" id="view_history" onclick="view_history('+aData[0]+');"><span class = "glyphicon glyphicon-calendar"></span></button>' );
			}
		},
		"fnInitComplete": function(oSettings, json) {
		}
	}).on('processing.dt',function(oEvent, settings, processing){
	});
}

function getservices(){
	$('#service_list').DataTable( {
		"bProcessing":true,	
		"bServerSide":true,
		"bRetrieve": true,
		"bDestroy":true,
		"sLimit":10,
		"pagingType": "simple",
        "info":false,
        "searching":false,
        "sDom": '<"top">rt<"bottom"flp><"clear">',
		"sAjaxSource": "service_provider/dataTables/1",
		"aoColumns":[	{"sTitle":"ID","bVisible":false},
						{"sTitle":"Services"},
						{"sTitle":"Description","bSearchable": true},
						{"sTitle":"Schedule","bSearchable": true},
						{"sTitle":"Registration Fee (Peso)","bSearchable": true},
						{"sTitle":"Walk-in Fee/Session (Peso)","bSearchable": true},
						{"sTitle":"# of Hours Per Session","bSearchable": true},
						{"sTitle":"Monthly Fee (Peso)","bSearchable": true},
						{"sTitle":"Type","bSearchable": true},
						{"sTitle":"Actions"}
		],
		"fnRowCallback": function( nRow, aData, iDisplayIndex ) {
			if ( aData[9] == 1 ){
				$('td:eq(8)', nRow).html('<button class = "btn btn-primary btn-viewlist" data-toggle="tooltip" data-placement="top" title="View Students and Instructors" id="view_studinstruct" onclick="view_studinstruct('+aData[0]+');"><span class = "glyphicon glyphicon-list"></span></button>' );
			}
			
			if ( aData[5] == "1" ){
				$('td:eq(5)', nRow).html('Arts');
			}else{
				$('td:eq(5)', nRow).html('Sports');
			}
		},
		"fnInitComplete": function(oSettings, json) {
		}
	}).on('processing.dt',function(oEvent, settings, processing){
	});
}

//get all service providers
function serviceproviders(){
	$.ajax({
		url: 'service_provider/list',
		dataType:'JSON',
		type:'POST',
		success:function(msg){
			
		}
	});
}