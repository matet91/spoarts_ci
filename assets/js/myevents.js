$(document).ready(function(){
	var height = $(window).height();

	eventCalendar();
	
	$('#btn-EventEnroll').click(function(){
		saveEnrollEvent();
	});
	
	$('#StudType').change(function(){
		if ($( this ).val() == 0){
			$("#stud-new").show();
			$("#stud-exist").hide();
		}else if ($( this ).val() == 1){
			$("#stud-new").hide();
			$("#stud-exist").show();
			 changeStudType();
		}else if($( this ).val() == 2){
			$("#stud-new").hide();
			$("#stud-exist").hide();
		}
	});
});

function eventCalendar(){ //showing the calendar event
	var getEvent = [];
	$.ajax({
      url:'myevents/getEvents', //getting the list of events
      dataType:'JSON',
      type:'POST',
      success:function(msg){ 
		if(msg!=""){
			$.each(msg, function(i,e){
				var insertEvents = {};
				insertEvents = {
					id: e.EventID,
					title: e.EventName,
					description: e.EventDesc,
					start: e.EventStartDate,
					end: e.EventEndDate,
					spid:e.SPID
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
			
				$(element).html('<button class="btn btn-primary btn-sm" id="btn-enrollEvent" data-toggle="tooltip" data-placement="top" title="Enroll '+event.title+'" onclick="EnrollEvent('+event.id+','+event.spid+')"><span class = "glyphicon glyphicon-calendar"></span></button> &nbsp;' + event.title); 
			}
		});
		
      }
    });	
}

function getRelationship(){
	$.ajax({
		url:'clinics/getRelationship/',
		dataType:'JSON',
		type:'POST',
		success:function(msg){ 
			var result = "";
			$("#stud_relationship").html("");
			$.each(msg, function(i,e){	
				result += '<option value='+e.relationship_name+'>'+e.relationship_name+'</option>';		
			});	
			$('#stud_relationship').html(result).trigger("chosen:updated");
		}
	});
}

function changeStudType(){
	$.ajax({
		url:'clinics/getexistStud/',
		dataType:'JSON',
		type:'POST',
		success:function(msg){
			var result = "<option value=0>Select</option>";
			$("#stud_id").html("");
			$.each(msg, function(i,e){	
				result += '<option value='+e.stud_id+'>'+e.stud_name+' @ '+e.stud_age+'</option>';		
			});	
			$('#stud_id').html(result).trigger("chosen:updated");
		}
	});
}

function EnrollEvent(eventid,spid){
	var height = $(window).height();
	var dialogHeight = $("#modal_enroll").find('.modal-dialog').outerHeight(true);
	var top = parseInt(height)/6-parseInt(dialogHeight);
	$("#modal_enroll").modal('show').attr('style','top:'+top+'px !important;');
	getRelationship();
	$("#SPID").val(spid);
	$("#EventID").val(eventid);
}

function saveEnrollEvent(){
	var dataForm = $("#formevent").serializeArray();
	var data = {};
	var studType = $("#StudType").val();
	var service = $("#Service").val();
	var schedule = $("#Schedule").val();
	data['studType'] = studType;
	
	var cherror = 0; //if not error
	
	if(studType==0){ //new student
		$.each(dataForm,function(i,e){
		  var name = $("#"+e.name);  
		  data[e.name] = e.value;
		  
		  if(e.name == "stud_name" || e.name == "stud_age" || e.name == "stud_address" || e.name == "stud_relationship"){
			  if(e.value == ""){
				name.parent().addClass("has-error");
			  }else{
				name.parent().removeClass('has-error'); 
			  }
			  
			  if (e.name == "stud_age"){
				  if($.isNumeric(e.value)){
					  name.parent().removeClass('has-error');   
				  }else{
					  $("#message .alert").html("Age should be numeric.").addClass('alert-danger').show();$("#message").addClass('zindex');
					  setTimeout(function(){
						$("#message .alert").html("").removeClass('alert-danger').hide();$("#message").removeClass('zindex');
					  },2000);
					  name.parent().addClass("has-error");
				 }
			  }
		  }
		});
		
		var error = $("#formstudent .has-error").length;
		if(error > 0){
			cherror = 1; //if error
			$("#message .alert").html("All fields are required.").addClass('alert-danger').show();$("#message").addClass('zindex');
			setTimeout(function(){
				$("#message .alert").html("").removeClass('alert-danger').hide();$("#message").removeClass('zindex');
			},2000);
		}else{
			cherror = 0;
		}
	}else if(studType==1){ //existing
		$.each(dataForm,function(i,e){
		  var name = $("#"+e.name);  
  
		  if(e.name == "stud_name" || e.name == "stud_age" || e.name == "stud_address"){
		  }else{
			  data[e.name] = e.value;
			  if (e.name == "stud_id"){
				  if(e.value == 0){
					cherror = 1; //if error
					$("#message .alert").html("Select a Student.").addClass('alert-danger').show();$("#message").addClass('zindex');
					setTimeout(function(){
						$("#message .alert").html("").removeClass('alert-danger').hide();$("#message").removeClass('zindex');
					},2000);
				  }else{
					cherror = 0;
				  }
			  }
		  }
		});
	}else if(studType==2){//client
		$.each(dataForm,function(i,e){
		  var name = $("#"+e.name);  
  
		  if(e.name == "EventID" || e.name == "SPID"){
			   data[e.name] = e.value;
		  }
		});
	}
	
	if(cherror == 0){
		$.ajax({
		  url:'myevents/saveEnrollEvent',
		  data:{data},
		  dataType:'JSON',
		  type:'POST',
		  success:function(msg){
			var nme = $("#stud_name").val();
			if(studType==1){
				nme = $("#stud_id option:selected").text();
			}else if(studType ==2){
				nme = "Client";
			}
			if(msg == 0){
				$("#message .alert").html(nme+" has been enrolled successfully.").addClass('alert-success').show();$("#message").addClass('zindex');
				$("#stud_name").val("");$("#stud_age").val("");$("#stud_address").val("");
				setTimeout(function(){
					$("#message .alert").html("").removeClass('alert-success').hide();$("#message").removeClass('zindex');
					window.location = 'myevents';
				},2000);
			}else if(msg == 3){ //existing student in a clinic
			
				$("#message .alert").html($("#stud_name").val()+" student is already exist. Please select Student Type: Existing.").addClass('alert-danger').show();$("#message").addClass('zindex');
				$("#stud_name").val("");$("#stud_age").val("");$("#stud_address").val("");
			}else if(msg == 4){ //student already enrolled in schedule selected
				$("#message .alert").html(nme+" already enrolled in this event").addClass('alert-danger').show();$("#message").addClass('zindex');
			}else{
			  $("#message .alert").html("An error occurred during the process. Please try again later or contact the administrator.").addClass('alert-danger').show();$("#message").addClass('zindex');
			}
			
			if(msg !=0){
				setTimeout(function(){
					$("#message .alert").html("").removeClass('alert-danger').hide();$("#message").removeClass('zindex');
				},2000);
			}
		  }
		});
	}
	
}

