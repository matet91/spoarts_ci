$(document).ready(function() {
	$(".chzn-select").chosen();
	var height = $(window).height();
	get_payments();
} );

function get_payments(){
	$('#mypayment_list').DataTable( {
    "bProcessing":true, 
    "bServerSide":true,
    "bRetrieve": true,
    "bDestroy":true,
    "sAjaxSource": "mypayments/dataTables/1",
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