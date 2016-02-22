$(document).ready(function() {
	/*$('.search-side').click(function(e) {  
		PNotify.prototype.options.styling = "bootstrap3";
		new PNotify({
			title: 'Bootstrap Icon',
			text: 'I have an icon that uses the Bootstrap icon styles.',
			icon: 'glyphicon glyphicon-envelope',
			after_init: function(notice) {
				notice.elem.on('click', 'button', function() {
					notice.attention('bounce');
				});
			}
		});
    });
	*/
	$('#notification').click(function(e){
		loadNotif();
	});
	if($("#huserid").val() != ""){
		countNotification();
	}
	
	$("#NewNotification").click(function(){
		$("#newnotif-div").toggle();
	});
	
	$("#OldNotification").click(function(){
		$("#oldnotif-div").toggle();
	});
	
	$('#modal_notif .close').click(function(){
		readNotification();
	});
	
	$('#modal_notif .btn-default').click(function(){
		readNotification();
	});
	
});

function loadNotif(){
	var height = $(window).height();
	var dialogHeight = $("#modal_notif").find('.modal-dialog').outerHeight(true);
	var top = parseInt(height)/6-parseInt(dialogHeight);
	$("#modal_notif").modal('show').attr('style','top:'+top+'px !important;');
	newNotif();
	oldNotif();
}

function newNotif(){
	$('#newnotif_list').DataTable( {
	"bProcessing":true, 
	"bServerSide":true,
	"bRetrieve": true,
	"bDestroy":true,
	"sAjaxSource": "clinics/dataTables/2/"+0,
	"aoColumns":[	{"sTitle":"ID","bVisible":false},
					{"sTitle":"Subject","bSearchable": true},
					{"sTitle":"Message","bSearchable": true},
					{"sTitle":"Date","bSearchable": true},
					{"sTitle":"Clinic","bSearchable": true}
	],
	"fnInitComplete": function(oSettings, json) {
	}
  }).on('processing.dt',function(oEvent, settings, processing){
  });
}

function oldNotif(){
	$('#oldnotif_list').DataTable( {
	"bProcessing":true, 
	"bServerSide":true,
	"bRetrieve": true,
	"bDestroy":true,
	"sAjaxSource": "clinics/dataTables/3/"+0,
	"aoColumns":[	{"sTitle":"ID","bVisible":false},
					{"sTitle":"Subject","bSearchable": true},
					{"sTitle":"Message","bSearchable": true},
					{"sTitle":"Date","bSearchable": true},
					{"sTitle":"Clinic","bSearchable": true}
	],
	"fnInitComplete": function(oSettings, json) {
	}
  }).on('processing.dt',function(oEvent, settings, processing){
  });
}

function readNotification(){
	$.ajax({
		url:'cglobal/readNotification',
		dataType:'JSON',
		type:'POST',
		success:function(msg){
			location.reload(); 
		}
	});
}

function countNotification(){
	$.ajax({
		url:'cglobal/countNotification',
		dataType:'JSON',
		type:'POST',
		success:function(msg){
			$("#notification").append(msg);
		}
	});
}
