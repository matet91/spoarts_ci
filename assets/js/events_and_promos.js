$(document).ready(function(){
	var height = $(window).height();
	
	$('#btn-addEvents').click(function(e){ //show the form for adding events
		e.preventDefault();
		var dialogHeight = $("#modal_addevents").find('.modal-dialog').outerHeight(true);
		var top = parseInt(height)/6-parseInt(dialogHeight);
		$("#modal_addevents").modal('show').attr('style','top:'+top+'px !important;');
		$( "#EventID" ).remove();
		
		var dataForm = $("#formaddevents").serializeArray();
		$("#modal_addevents .alert").html("");
		$.each(dataForm,function(i,e){
			var name = $("#"+e.name);
			name.parent().removeClass('has-error');
			$("#"+e.name).attr('value', '');
		});

		getService(""); //getting services offered and show it in drop down
		
	});
	
	$('#btn-addPromos').click(function(e){ //show the form for adding promos
		e.preventDefault();
		var dialogHeight = $("#modal_addpromos").find('.modal-dialog').outerHeight(true);
		var top = parseInt(height)/6-parseInt(dialogHeight);
		$("#modal_addpromos").modal('show').attr('style','top:'+top+'px !important;');
		$( "#PromoID" ).remove();
		
		var dataForm = $("#formaddpromo").serializeArray();
		$("#modal_addpromos .alert").html("");
		$.each(dataForm,function(i,e){
			var name = $("#"+e.name);
			name.parent().removeClass('has-error');
			$("#"+e.name).attr('value', '');
		});
		
	});
	
	//save events details to database
	$("#btn-saveEvents").click(function(){	
		var eventid = $("#EventID").val();
		if(eventid){ //check if it is for updating an event
			var height = $(window).height();
			var dialogHeight = $("#modal_security").find('.modal-dialog').outerHeight(true);
			var top = parseInt(height)/2-parseInt(dialogHeight);
			$("#modal_security").modal('show').attr('style','top:'+top+'px !important;');
			  
			$("#modal_security #btn-continue").click(function(){
				var pwd = $("#modal_security #sec_pwd");

				if(pwd.val() == ''){
					pwd.parent().addClass('has-error');
					$("#message .alert").html("Please enter the password of your security question.").addClass("alert-danger").show();
				}else{
					pwd.parent().removeClass('has-error');
					$("#message .alert").html("").removeClass("alert-danger").hide();
					checkSecurityPwd(pwd.val(),"updateEvents",0);
				}
			});
		}else{ // if adding an event
			saveEvents("addEvents");
		}
	});
	
	$("#btn-savePromos").click(function(){
		var promoid = $("#PromoID").val();
		if(promoid){ // check if updating a promo
			var height = $(window).height();
			var dialogHeight = $("#modal_security").find('.modal-dialog').outerHeight(true);
			var top = parseInt(height)/2-parseInt(dialogHeight);
			$("#modal_security").modal('show').attr('style','top:'+top+'px !important;');
			  
			$("#modal_security #btn-continue").click(function(){
				var pwd = $("#modal_security #sec_pwd");

				if(pwd.val() == ''){
					pwd.parent().addClass('has-error');
					$("#message .alert").html("Please enter the password of your security question.").addClass("alert-danger").show();
				}else{
					pwd.parent().removeClass('has-error');
					$("#message .alert").html("").removeClass("alert-danger").hide();
					checkSecurityPwd(pwd.val(),"updatePromos",0);
				}
			});
		}else{ //if adding a promo
			savePromos("addPromos");
		}
	});
	
	eventCalendar();
	$( "#PromoStartDate" ).datepicker({
      numberOfMonths: 1,
	  format: 'Y/m/d',
      onClose: function( selectedDate ) {
        $( "#PromoEndDate" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#PromoEndDate" ).datepicker({
      numberOfMonths: 1,
	  format: 'Y/m/d',
      onClose: function( selectedDate ) {
        $( "#PromoStartDate" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
	
	$( "#EventStartDate" ).datepicker({
      numberOfMonths: 1,
	  format: 'Y/m/d',
      onClose: function( selectedDate ) {
        $( "#EventEndDate" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#EventEndDate" ).datepicker({
      numberOfMonths: 1,
	  format: 'Y/m/d',
      onClose: function( selectedDate ) {
        $( "#EventStartDate" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
	
	getPromos(); //get the list of promo
});

function eventCalendar(){ //showing the calendar event
	var getEvent = [];
	$.ajax({
      url:'events_and_promos/getEvents', //getting the list of events
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
				
				//the title in event has been overrided with edit and remove buttons and text
				$(element).html('<button class="btn btn-primary btn-sm" id="btn-editEvent" data-toggle="tooltip" data-placement="top" title="Edit '+event.title+'" onclick="editEvent('+event.id+')"><span class = "glyphicon glyphicon-pencil"></span></button><button class = "btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Remove '+event.title+'" onclick="removeEvent('+event.id+')"><span class = "glyphicon glyphicon-trash"></span></button> &nbsp;' + event.title); 
			}
		});
		
      }
    });	
}

function removeEvent(id){
	alert(id);
	var height = $(window).height();
	var dialogHeight = $("#modal_security").find('.modal-dialog').outerHeight(true);
	var top = parseInt(height)/2-parseInt(dialogHeight);
	$("#modal_security").modal('show').attr('style','top:'+top+'px !important;');
	  
	$("#modal_security #btn-continue").click(function(){
		var pwd = $("#modal_security #sec_pwd");

		if(pwd.val() == ''){
			pwd.parent().addClass('has-error');
			$("#modal_security .alert").html("Please enter the password of your security question.").addClass('alert-danger').show();
		}else{
			pwd.parent().removeClass('has-error');
			$("#modal_security .alert").html("").removeClass("alert-danger").hide();
			checkSecurityPwd(pwd.val(),"removeEvents",id);
		}
	});
}

function editEvent(id){
	$("#formaddevents").append("<input type='hidden' id='EventID' name='EventID' value='"+id+"' />");
		var height = $(window).height();
		var dialogHeight = $("#modal_addevents").find('.modal-dialog').outerHeight(true);
		var top = parseInt(height)/6-parseInt(dialogHeight);
		$("#modal_addevents").modal('show').attr('style','top:'+top+'px !important;');
		$("#modal_addevents .modal-title").html("Update Event");
		var dataForm = $("#formaddevents").serializeArray();
		$("#modal_addevents .alert").html("").removeClass('has-error').hide();
		  $.each(dataForm,function(i,e){
			  var name = $("#"+e.name);
			  name.parent().removeClass('has-error');
		  });
		$.ajax({
			url:'events_and_promos/getAnEvent/'+id,
			dataType:'JSON',
			type:'POST',
			success:function(msg){
				$.each(msg, function(i,e){
					var eventfor = e.EventFor;
					var dataarray = eventfor.split(",");
					$("#EventName").val(e.EventName);
					$("#EventDesc").val(e.EventDesc);
					$("#EventStartDate").val(e.EventStartDate);
					$("#EventEndDate").val(e.EventEndDate);
					$("#EventLocation").val(e.EventLocation);
					$("#formaddevent").append("<input type='hidden' id='EventID' name='EventID' value='"+e.EventID+"' />");
					getService(dataarray);
				});
				
			}
		});	
}

function editPromo(param){
	var height = $(window).height();
	var dialogHeight = $("#modal_addpromos").find('.modal-dialog').outerHeight(true);
	var top = parseInt(height)/6-parseInt(dialogHeight);
	$("#modal_addpromos").modal('show').attr('style','top:'+top+'px !important;');
	var promo = param.split(',');
	$("#PromoName").val(promo[1]);
	$("#PromoDesc").val(promo[2]);
	$("#PromoStartDate").val(promo[3]);
	$("#PromoEndDate").val(promo[4]);
	$("#title-promo").html("Update Promo");	
	$("#formaddpromo").append("<input type='hidden' id='PromoID' name='PromoID' value='"+promo[0]+"' />");
}

function removeEventsPromos(id,type){
	var height = $(window).height();
	var dialogHeight = $("#modal_security").find('.modal-dialog').outerHeight(true);
	var top = parseInt(height)/2-parseInt(dialogHeight);
	$("#modal_security").modal('show').attr('style','top:'+top+'px !important;');
	  
	$("#modal_security #btn-continue").click(function(){
		var pwd = $("#modal_security #sec_pwd");

		if(pwd.val() == ''){
			pwd.parent().addClass('has-error');
			$("#modal_security .alert").html("Please enter the password of your security question.").addClass('alert-danger').show();
		}else{
			pwd.parent().removeClass('has-error');
			$("#modal_security .alert").html("").removeClass("alert-danger").hide();
			checkSecurityPwd(pwd.val(),type,id);
		}
	});
}

function getPromos(){
	$.ajax({
		url:'events_and_promos/getPromos',
		dataType:'JSON',
		type:'POST',
		success:function(msg){ 
			var result = "";		
			$.each(msg, function(i,e){
				var param = [e.PromoID,e.PromoName,e.PromoDesc,e.PromoStartDate,e.PromoEndDate];
				
				var listbutton = '<button class = "btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Remove" onclick="removeEventsPromos('+e.PromoID+','+'\'removePromos\')"><span class = "glyphicon glyphicon-trash"></span></button>&nbsp;'+
					'<button class = "btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" title="Edit" onclick="editPromo(\''+param+'\')"><span class = "glyphicon glyphicon-pencil"></span></button>';
				
				result = '<div class="blog-post standard-post">'+
						 '<div class="post-content">'+
						 '<div>'+listbutton+'</div>'+
						 '<h2><a href="#">'+e.PromoName+'</a></h2>'+
						 '<ul class="post-meta">'+
							'<li>By '+e.SPname+'</li>'+
							'<li>'+e.PromoStartDate+'</li>'+
							'<li>'+e.PromoEndDate+'</li>'+
						 '</ul>'+
						 '<p>'+e.PromoDesc+'</p>'+
						 '</div>'+
						 '</div>';
				$("#promo-result").append(result);
			});	
		}
    });
}

function getService(sel){
	$.ajax({
		url:'events_and_promos/getService',
		dataType:'JSON',
		type:'POST',
		success:function(msg){ 
			var result = "";
			$("#EventFor").html("");
			$.each(msg, function(i,e){
				
				var checkAr = sel.indexOf(e.ServiceID); 
				if( checkAr < 0) { var opt = ""; }else{var opt = "SELECTED";}
				result += '<option value='+e.ServiceID+' ' +opt+'>'+e.ServiceName+'</option>';
				
			});	
			
			$("#EventFor").append(result);	
			$('#EventFor').chosen();
			$('#EventFor').trigger("chosen:updated");
			$('#EventFor_chosen').css({ width: "270px" });
			
		}
    });
}

function checkSecurityPwd(pwd,type,id){
  $.ajax({
    url:'services/checkSecurityPwd',
    dataType:'JSON',
    type:'POST',
    data:{pwd:pwd},
    success:function(msg){
		if(msg == 1){ //if correct
			$("#modal_security").hide();
			if(type == "updatePromos"){
				savePromos("updatePromos");
			}else if(type == "removePromos"){
				deleteEventsPromos(type,id);
			}else if(type=="updateEvents"){
				saveEvents("updateEvents");
			}else if(type == "removeEvents"){
				deleteEventsPromos(type,id);
			}
		}else{//incorrect password
			$("#modal_security #sec_pwd").parent().addClass('has-error');
			$("#modal_security .alert").html("Incorrect Password.").addClass("alert-danger").show();
		}
    }
  })
}

function deleteEventsPromos(type,id){
	$.ajax({
      url:'events_and_promos/'+type,
      data:{stat:0,id:id},
      dataType:'JSON',
      type:'POST',
      success:function(msg){
        if(msg == 0){
			var height = $(window).height();
			var dialogHeight = $("#modal_alert").find('.modal-dialog').outerHeight(true);
			var top = parseInt(height)/2-parseInt(dialogHeight);
			$("#modal_alert").modal('show').attr('style','top:'+top+'px !important;');
			
			if(type == "removePromos"){
				$("#message .alert").html("Promo has been removed successfully").addClass("alert-success").show();
			}else{
				$("#message .alert").html("Event has been removed successfully").addClass("alert-success").show();
			}
            setTimeout(function(){
				$("#message .alert").html("").removeClass('alert-success').hide();
				window.location = 'events_and_promos';
			},2000);
        }else{
		  $("#message .alert").html("An error occurred during the process. Please try again later or contact the administrator.").addClass("alert-danger").show();
			setTimeout(function(){
				$("#message .alert").html("").removeClass('alert-danger').hide();
			},2000);
        }
      }
    });
}

function saveEvents(type){

  //validate form
  var dataForm = $("#formaddevents").serializeArray();
  var data = {};
  
  $("#modal_addevents .alert").html("");
  $.each(dataForm,function(i,e){
      var name = $("#"+e.name);
      if(e.value == ""){
        name.parent().addClass("has-error");
      }else{
        if(e.name == 'EventPrice'){
            if($.isNumeric(e.value)){
				name.parent().removeClass('has-error');
				data[e.name] = e.value;
            }else{
				$("#message .alert").html(name.prev().html()+" should be numeric.").addClass("alert-danger").show();
				name.parent().addClass("has-error");
				setTimeout(function(){
					$("#message .alert").html("").removeClass('alert-danger').hide();
				},2000);
            }
        }else if(e.name == 'EventFor'){
			var selected = $("#EventFor option:selected");
			var value = ""; var len = selected.length;
			var ctr = 0;
			selected.each(function () {
				ctr++;
				if(ctr == len ){
					value += $(this).val();
				}else{
					value += $(this).val() + ",";
				}
				
			});
			data[e.name] = value;
	    }else{
          name.parent().removeClass('has-error');
          data[e.name] = e.value;
        }
      }
  });

//get how many div is using 'has-error' class
var error = $("#formaddevents .has-error").length;
  if(error > 0){
    $("#modal_addevents .alert").append("All fields are required.").addClass('alert-danger').show();
  }else{
    $("#modal_addevents .alert").html("").removeClass('alert-danger').hide();
    $.ajax({
      url:'events_and_promos/'+type,
      data:{data},
      dataType:'JSON',
      type:'POST',
      success:function(msg){ 
        if(msg == 0){
			if(type == "addEvents"){
				$("#message .alert").html($("#EventName").val()+" Event has been added successfully.").addClass("alert-success").show();
				$.each(dataForm, function(i,e){
				  $("#"+e.name).val("");
				});
			}else if(type == "updateEvents"){
				$("#message .alert").html($("#EventName").val()+" Event has been updated successfully.").addClass("alert-success").show();
			}
			setTimeout(function(){
				$("#message .alert").html("").removeClass('alert-success').hide();
				window.location = 'events_and_promos';
			},2000);
        }else{
			$("#message .alert").html("An error occurred during the process. Please try again later or contact the administrator.").addClass("alert-danger").show();
			setTimeout(function(){
				$("#message .alert").html("").removeClass('alert-danger').hide();
			},2000);
        }
      }
    });
  }
}

function savePromos(type){
  //validate form
  var dataForm = $("#formaddpromo").serializeArray();
  var data = {};
  
  $("#modal_addpromos .alert").html("");
  $.each(dataForm,function(i,e){
      var name = $("#"+e.name);
      if(e.value == ""){
        name.parent().addClass("has-error");
      }else{
        name.parent().removeClass('has-error');
          data[e.name] = e.value;
      }
  });
  
//get how many div is using 'has-error' class
var error = $("#formaddpromos .has-error").length;
  if(error > 0){
    $("#modal_addpromos .alert").append("All fields are required.").addClass('alert-danger').show();
  }else{
    $("#modal_addpromos .alert").html("").removeClass('alert-danger').hide();
    $.ajax({
      url:'events_and_promos/'+type,
      data:{data},
      dataType:'JSON',
      type:'POST',
      success:function(msg){
        if(msg == 0){
			if(type == "addPromos"){
				$("#message .alert").html($("#PromoName").val()+" Promo has been added successfully.").addClass("alert-success").show();
				$.each(dataForm, function(i,e){
				  $("#"+e.name).val("");
				});
			}else if(type == "updatePromos"){
				$("#message .alert").html($("#PromoName").val()+" Promo has been updated successfully.").addClass("alert-success").show();
			}
			
			setTimeout(function(){
				$("#message .alert").html("").removeClass('alert-success').hide();
				window.location = 'events_and_promos';
			},2000);
			//getPromos();
        }else{
			$("#message .alert").html("An error occurred during the process. Please try again later or contact the administrator.").addClass("alert-danger").show();
			
			setTimeout(function(){
				$("#message .alert").html("").removeClass('alert-danger').hide();
			},2000);
        }
      }
    });
  }
}