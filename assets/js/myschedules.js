$(document).ready(function() {
	var height = $(window).height();
	get_schedules();
} );

function get_schedules(){
	$('#myschedules_list').DataTable( {
    "bProcessing":true, 
    "bServerSide":true,
    "bRetrieve": true,
    "bDestroy":true,
    "sAjaxSource": "myschedules/dataTables/1",
	"aoColumns":[	{"sTitle":"ID","bVisible":false},
					{"sTitle":"Name","bSearchable": true},
					{"sTitle":"Schedule","bSearchable": true},
					{"sTitle":"Room","bSearchable": true},
					{"sTitle":"Instructor","bSearchable": true},
					{"sTitle":"Service","bSearchable": true},
					{"sTitle":"Clinic","bSearchable": true}
	],
    "fnInitComplete": function(oSettings, json) {
    }
  }).on('processing.dt',function(oEvent, settings, processing){
  });
}