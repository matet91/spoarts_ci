$(document).ready(function() {
	var height = $(window).height();
	//get_schedules();
	getCalendarSched();
} );

/*function get_schedules(){
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
}*/

function getCalendarSched(){
	var getEvent = [];
	$.ajax({
      url:'myschedules/getCalendarSched', //getting the list of events
      dataType:'JSON',
      type:'POST',
      success:function(msg){ 
		//console.log(msg);
		if(msg!=""){
			$.each(msg, function(i,e){
				var start_end_date = e.SchedTime.split("-");
				var start_end_days = e.SchedDays.split(",");
				var getDays = [];
				$.each(start_end_days, function(iS,eS){
					getDays.push(getNumDay(eS));
				});
				//console.log(getDays);
				var insertEvents = {};
				insertEvents = {
					id: e.StudEnrolledID,
					title: e.Clinic + ": "+e.Service,
					description: "Student: "+e.stud_name+"\n Instructor:"+e.Instructor+"\n Room: "+e.Room+"\n Schedule: "+e.Schedule,
					start: start_end_date[0],
					end: start_end_date[1],
					dow: getDays
				}
				getEvent.push(insertEvents);
			});
		}
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1;
		var yyyy = today.getFullYear();
		if(dd<10){dd='0'+dd} 
		if(mm<10){mm='0'+mm} 
		var today = yyyy+'-'+mm+'-'+dd;

		$('#calendar_events').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			defaultDate: today,
			eventLimit: true, // allow "more" link when too many events
			events: getEvent,
			eventRender: function(event, element) {
				$(element).tooltip({title: event.description, html: true, container: "body"}); //event tooltip
			}
		});
		
      }
    });	
}

function getNumDay(day){
	var weekday = new Array(7);
	weekday["Sunday"]= 0;
	weekday["Monday"] = 1;
	weekday["Tuesday"] = 2;
	weekday["Wednesday"] = 3;
	weekday["Thursday"] = 4;
	weekday["Friday"] = 5;
	weekday["Saturday"] = 6;
	
	return weekday[day];
}