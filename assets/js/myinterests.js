$(document).ready(function() {
	$(".chzn-select").chosen();
	var height = $(window).height();
 
	$("#btn-addInterest").click(function (e){
		e.preventDefault();
		var dialogHeight = $("#modal_interest").find('.modal-dialog').outerHeight(true);
		var top = parseInt(height)/3-parseInt(dialogHeight);
		$("#modal_interest").modal('show').attr('style','top:'+top+'px !important');
		getselInterest();
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
					$("#message .alert").html($("#interest_id option:selected").text()+" has been added successfully.").addClass("alert-success").show();$("#message").addClass('zindex');
				}else{
					$("#message .alert").html("An error occurred during the process. Please try again later or contact the administrator.").addClass('alert-danger').show();$("#message").addClass('zindex');
				}
				
				setTimeout(function(){
					$("#message .alert").html("").removeClass('alert-success').hide();$("#message").removeClass('zindex');
					$("#message .alert").html("").removeClass('alert-danger').hide();$("#message").removeClass('zindex');
					$("#modal_security .alert").html("").removeClass('alert-success').hide();$("#message").removeClass('zindex');
					$("#modal_security").hide();
					window.location = 'myinterests';
				},2000);
			}
		});
	});
	
	getlistinterest();
} );

function getlistinterest(){
	$.ajax({
		url:'myinterests/getlistinterest',
		dataType:'JSON',
		type:'POST',
		success:function(msg){
			var result = "<thead><tr><th></th><th></th></tr></thead>";
			$.each(msg, function(i,e){
				if(i == 1){
					result+="<tbody>";
				}

				result += '<tr><td>'+e+'</td><td><button class = "btn btn-danger btn-xs btn-viewlist" data-toggle="tooltip" data-placement="top" title="Remove Interest" onclick="removeIntererst('+i+',1);"><i class = "fa fa-remove fa-fw"></i></button></td></tr>';
			});
			result += "</tbody>";
			
			 $('#myinterest_list').html(result).DataTable( {
				"sPaginationType":"full_numbers",
					"bProcessing":true,
				    "bDestroy":true,
				    "deferRender":true,
					"deferLoading":57}
			);
		}
	});
	/*$('#myinterest_list').DataTable( {
    "bProcessing":true, 
    "bServerSide":true,
    "bRetrieve": true,
    "bDestroy":true,
    "sAjaxSource": "myinterests/dataTables/1",
	"aoColumns":[	{"sTitle":"ID","bVisible":false},
					{"sTitle":"Name","bSearchable": true},
					{"sTitle":"Type","bSearchable": true},
					{"sTitle":"Actions"}
	],
	"fnRowCallback": function( nRow, aData, iDisplayIndex ) {
		if ( aData[3] == "1" ){
			$('td:eq(2)', nRow).html('<button class = "btn btn-danger btn-xs btn-viewlist" data-toggle="tooltip" data-placement="top" title="Remove Interest" onclick="removeIntererst('+aData[0]+',1);"><i class = "fa fa-remove fa-fw"></i></button>' );
		}
	},
    "fnInitComplete": function(oSettings, json) {
    }
  }).on('processing.dt',function(oEvent, settings, processing){
  });*/
}

function removeIntererst(interestid){
	$.ajax({
		url:'myinterests/deleteInterest',
		dataType:'JSON',
		type:'POST',
		data:{interestid:interestid},
		success:function(msg){
			if(msg == 1){
				$("#message .alert").html("Interest has been successfully deleted.").addClass("alert-success").show();$("#message").addClass('zindex');
			}else{
				$("#message .alert").html("An error occurred during the process. Please try again later or contact the administrator.").addClass('alert-danger').show();$("#message").addClass('zindex');
			}
			setTimeout(function(){
				$("#message .alert").html("").removeClass('alert-success').hide();$("#message").removeClass('zindex');
				$("#message .alert").html("").removeClass('alert-danger').hide();$("#message").removeClass('zindex');
				$("#modal_security .alert").html("").removeClass('alert-success').hide();$("#message").removeClass('zindex');
				$("#modal_security").hide();
				window.location = 'myinterests';
			},2000);
		}
	});
}

function getselInterest(){
	$.ajax({
		url:'myinterests/getselInterest/',
		dataType:'JSON',
		type:'POST',
		success:function(msg){
			
			var result = "";
			$("#interest_id").html("");
			$.each(msg, function(i,e){
				result += '<option value='+i+'>'+e+'</option>';
			});		
			$('#interest_id').html(result).trigger("chosen:updated");
			$('#interest_id_chosen').css({ width: "550px" });
		}
    });
}

