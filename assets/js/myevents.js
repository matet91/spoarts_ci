$(document).ready(function(){
	var height = $(window).height();

	eventCalendar();

});

function eventCalendar(){ //showing the calendar event
	var getEvent = [];
	$.ajax({
      url:'myevents/getEvents', //getting the list of events
      dataType:'JSON',
      type:'POST',
      success:function(msg){ 
		$.each(msg, function(i,e){
			var insertEvents = {};
			insertEvents = {
				id: e.EventID,
				title: e.EventName,
				description: e.EventDesc,
				start: e.EventStartDate,
				end: e.EventEndDate
			}
			getEvent.push(insertEvents);
		});
		
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
