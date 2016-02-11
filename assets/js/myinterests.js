$(document).ready(function() {
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
			/*if ( aData[5] == "1" ){
				$('td:eq(5)', nRow).html('<button class = "btn btn-primary btn-attendance" data-toggle="tooltip" data-placement="top" title="View Attendance History" id="view_history" onclick="view_history('+aData[0]+');"><span class = "glyphicon glyphicon-calendar"></span></button>' );
			}*/
		},
		"fnInitComplete": function(oSettings, json) {
		}
	}).on('processing.dt',function(oEvent, settings, processing){
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
			$('#interest_id').multiselect({includeSelectAllOption: true});		
			$("#interest_id").multiselect("refresh");
			
		}
    });
}

