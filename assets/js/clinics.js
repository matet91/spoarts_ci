$(document).ready(function(){
	$(".chzn-select").chosen();
	var clinictype = $('#clinic_type').val();
	loadServices(clinictype,0);
	$('#searchClinic').keypress(function(){

		var clinictype = $('#clinic_type').val();
		if($(this).val()!=''){
			$('#clinic classic-title').html("Searching... "+$(this).val());
			loadServices(clinictype,$(this).val());
		}
	});
	
	$('#Service').change(function(){
		if($( this ).val() !=0){
			changeService($( this ).val());
			$("#service_id").val($( this ).val());
			$("#schedform").show();
		}else{
			$("#schedform").hide();
			$("#stud-new").hide();
			$("#stud-exist").hide();
			$("#formstudent").hide();
			$("#sched-info").hide();
		}
	});
	
	$('#Schedule').change(function(){
		changeSchedule($( this ).val());
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
	
	$('#modal_enroll .close').click(function(){
		$("#formstudent").hide();$("#sched-info").hide();$("#schedform").hide();
		//$("#modal_enroll .alert").html("").addClass("alert-success").hide();
		$("#message .alert").html("").addClass('alert-success').hide();
		$("#message .alert").html("").addClass('alert-danger').hide();
	});
	
	$('#modal_enroll .btn-default').click(function(){
		$("#formstudent").hide();$("#sched-info").hide();$("#schedform").hide();
		//$("#modal_enroll .alert").html("").addClass("alert-success").hide();
		$("#message .alert").html("").addClass('alert-success').hide();
		$("#message .alert").html("").addClass('alert-danger').hide();
	});
	
	$('#btn-Enroll').click(function(){
		saveEnroll();
	});
});

/*function loadServices(c,search){

	$.ajax({
		url:'clinics/loadServices/'+c+"/"+search,
		dataType:'JSON',
		type:'POST',
		success:function(msg){
			var content = "";
			$.each(msg, function(i,e){
				content += "<li>"+
			          "<img src='assets/images/"+e.clinic_logo+"' alt='' />"+
				          "<div class='portfolio-item-content'>"+
				            "<span class='header'>"+e.ServiceName+"</span>"+
				            "<p class='body'>Clinic "+e.clinic_name+"</p>"+
				            "<p class='body'>Located at "+e.SPLocation+"</p>"+
				          "</div>"+
				          "<a href='#' onclick = bookmark('"+e.ServiceID+"','"+e.clinic_id+"') data-toggle='tooltip' data-placement='top' title='Bookmark'><i class='more fa fa-bookmark' style = 'left:30% !important;height:50px !important;width:50px !important;line-height:49px !important;font-size:30px !important;'></i></button>"+
				          "<a href='#' onclick = enroll('"+e.ServiceID+"','"+e.clinic_id+"') data-toggle='tooltip' data-placement='top' title='Enroll' ><i class='more fa fa-sign-in' style = 'left:55% !important;height:50px !important;width:50px !important;line-height:49px !important;font-size:30px !important;'></i></a>"+
				          "<a href='#' onclick = info('"+e.ServiceID+"','"+e.clinic_id+"') data-toggle='tooltip' data-placement='top' title='More Info' ><i class='more fa fa-info' style = 'left:80% !important;height:50px !important;width:50px !important;line-height:49px !important;font-size:30px !important;'></i></a>"+

				        "</li>";

			});
			if(search != '' && search != 0){
				$('#clinic .classic-title').html("<b class = 'alert alert-info'>Found : "+msg.length+" clinic(s)...</b>");
			}
			$('#portfolio-list').html(content);

		}
	});
}*/

function loadServices(c,search){

	$.ajax({
		url:'clinics/loadClinics/'+c+"/"+search,
		dataType:'JSON',
		type:'POST',
		success:function(msg){
			var content = "";
			$.each(msg, function(i,e){
				content += "<li>"+
			          "<img src='assets/images/"+e.clinic_logo+"' alt='' />"+
				          "<div class='portfolio-item-content'>"+
				            "<span class='header'>"+e.clinic_name+"</span>"+
				            "<p class='body'>Clinic "+e.SPLocation+"</p>"+
				          "</div>"+
				          "<a href='#' onclick = bookmark('"+e.clinic_id+"') data-toggle='tooltip' data-placement='top' title='Bookmark'><i class='more fa fa-bookmark' style = 'left:30% !important;height:50px !important;width:50px !important;line-height:49px !important;font-size:30px !important;'></i></button>"+
				          "<a href='#' onclick = enroll('"+c+"','"+e.UserID+"','"+e.clinic_id+"') data-toggle='tooltip' data-placement='top' title='Enroll' ><i class='more fa fa-sign-in' style = 'left:55% !important;height:50px !important;width:50px !important;line-height:49px !important;font-size:30px !important;'></i></a>"+
				          "<a href='#' onclick = info('"+e.clinic_id+"') data-toggle='tooltip' data-placement='top' title='More Info' ><i class='more fa fa-info' style = 'left:80% !important;height:50px !important;width:50px !important;line-height:49px !important;font-size:30px !important;'></i></a>"+
				        "</li>";

			});
			if(search != '' && search != 0){
				$('#clinic .classic-title').html("<b class = 'alert alert-info'>Found : "+msg.length+" clinic(s)...</b>");
			}
			$('#portfolio-list').html(content);

		}
	});
}

function changeSchedule(schedid){
	$("#instructor").html("");	
	$("#slot").html("");	
	$("#room").html("");

	$.ajax({
		url:'clinics/changeSchedule/'+schedid,
		dataType:'JSON',
		type:'POST',
		success:function(msg){
			$.each(msg, function(i,e){
				if(e.Instructor){ var instructor = e.Instructor; }else{ var instructor = "TBA";}
				if(e.Room){ var room = e.Room; }else{ var room = "TBA";}
				$("#instructor").html(instructor);	
				$("#slot").html(e.SchedSlots);	
				$("#room").html(room);
				
				$("#ins_id").val(e.InstructorID);	
				$("#SchedID").val(schedid);	
			});
			
			if(schedid >0){ $("#formstudent").show(); $("#sched-info").show();}
			else{$("#formstudent").hide();$("#sched-info").hide();}
		}
	});
}

function changeService(serviceid){
	$.ajax({
		url:'clinics/getSchedule/'+serviceid,
		dataType:'JSON',
		type:'POST',
		success:function(msg){ 
			var result = "<option value=0>Select</option>";
			$("#Schedule").html("");
			$.each(msg, function(i,e){	
				result += '<option value='+e.SchedID+'>'+e.SchedDate+' @ '+e.SchedTime+'</option>';	
			});	
			//$("#Schedule").append(result);	
			//$('#Schedule').chosen().trigger("chosen:updated");
			$('#Schedule').html(result).trigger("chosen:updated");
		}
    });
	
}

function enroll(c,userid,clinic_id){
	var height = $(window).height();
	var dialogHeight = $("#modal_enroll").find('.modal-dialog').outerHeight(true);
	var top = parseInt(height)/6-parseInt(dialogHeight);
	$("#modal_enroll").modal('show').attr('style','top:'+top+'px !important;');
	
	//$("#service_id").val(serviceid);	
	$("#clinic_id").val(clinic_id);
	$("#ctype").val(c);

	$.ajax({
		url:'clinics/getService/'+c+'/'+userid,
		dataType:'JSON',
		type:'POST',
		success:function(msg){ 
			var result = "<option value=0>Select</option>";
			$("#Service").html("");
			$.each(msg, function(i,e){	
				result += '<option value='+e.ServiceID+'>'+e.ServiceName+'</option>';		
			});	
			$('#Service').html(result).trigger("chosen:updated");
		}
    });
}

function changeStudType(){
	var clinic_id = $("#clinic_id").val();
	$.ajax({
		url:'clinics/getexistStud/'+clinic_id,
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

function saveEnroll(){
	var dataForm = $("#formstudent").serializeArray();
	var data = {};
	var studType = $("#StudType").val();
	var service = $("#Service").val();
	var schedule = $("#Schedule").val();
	data['studType'] = studType;
	
	var cherror = 0; //if not error
	
	if(service==0 || schedule==0){
		$("#message .alert").html("Service or schedule is missing.").addClass('alert-danger').show();
		setTimeout(function(){
			$("#message .alert").html("").removeClass('alert-danger').hide();
		},2000);
	}else{
		if(studType==0){ //new student
			$.each(dataForm,function(i,e){
			  var name = $("#"+e.name);  
			  data[e.name] = e.value;
			  
			  if(e.name == "stud_name" || e.name == "stud_age" || e.name == "stud_address"){
				  if(e.value == ""){
					name.parent().addClass("has-error");
				  }else{
					name.parent().removeClass('has-error'); 
				  }
				  
				  if (e.name == "stud_age"){
					  if($.isNumeric(e.value)){
						  name.parent().removeClass('has-error');   
					  }else{
						  $("#message .alert").html("Age should be numeric.").addClass('alert-danger').show();
						  setTimeout(function(){
							$("#message .alert").html("").removeClass('alert-danger').hide();
						  },2000);
						  name.parent().addClass("has-error");
					 }
				  }
			  }
			});
			
			var error = $("#formstudent .has-error").length;
			if(error > 0){
				cherror = 1; //if error
				$("#message .alert").html("All fields are required.").addClass('alert-danger').show();
				setTimeout(function(){
					$("#message .alert").html("").removeClass('alert-danger').hide();
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
						$("#message .alert").html("Select a Student.").addClass('alert-danger').show();
						setTimeout(function(){
							$("#message .alert").html("").removeClass('alert-danger').hide();
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
	  
			  if(e.name == "service_id" || e.name == "clinic_id" || e.name == "ins_id" || e.name == "SchedID"){
				   data[e.name] = e.value;
			  }
			});
		}
		
		if(cherror == 0){
			$.ajax({
			  url:'clinics/saveEnroll',
			  data:{data},
			  dataType:'JSON',
			  type:'POST',
			  success:function(msg){
				if(msg == 0){
					$("#message .alert").html($("#stud_name").val()+" has been enrolled successfully.").addClass('alert-success').show();
					$("#stud_name").val("");$("#stud_age").val("");$("#stud_address").val("");
					setTimeout(function(){
						$("#message .alert").html("").removeClass('alert-success').hide();
						window.location = 'clinics?type='+$("#ctype").val();
					},2000);
				}else if(msg == 3){ //existing student in a clinic
				
					$("#message .alert").html($("#stud_name").val()+" student is already exist. Please select Student Type: Existing.").addClass('alert-danger').show();
					$("#stud_name").val("");$("#stud_age").val("");$("#stud_address").val("");
				}else if(msg == 4){ //student already enrolled in schedule selected
					$("#message .alert").html($("#stud_id option:selected").text()+" already enrolled in this schedule").addClass('alert-danger').show();
				}else{
				  $("#message .alert").html("An error occurred during the process. Please try again later or contact the administrator.").addClass('alert-danger').show();
				}
				
				if(msg !=0){
					setTimeout(function(){
						$("#message .alert").html("").removeClass('alert-danger').hide();
					},2000);
				}
			  }
			});
		}
	}
	
}

function bookmark(clinicid){
	$.ajax({
		url:'clinics/bookmark',
		data:{clinicid:clinicid},
		dataType:'JSON',
		type:'POST',
		success:function(msg){
			if(msg == 1){
				$("#message .alert").html("Clinic was bookmarked already.").addClass('alert-success').show();
			}else if(msg == 2 || msg == 3){
				$("#message .alert").html("Clinic has been successfully bookmarked.").addClass('alert-success').show();
			}else{
				$("#message .alert").html("An error occurred during the process. Please try again later or contact the administrator.").addClass('alert-danger').show();
			}
			setTimeout(function(){
				$("#message .alert").html("").removeClass('alert-success').hide();
				$("#message .alert").html("").removeClass('alert-danger').hide();
			},2000);
		}
	});
}

function info(clinicid){
	var height = $(window).height();
	var dialogHeight = $("#modal_info").find('.modal-dialog').outerHeight(true);
	var top = parseInt(height)/6-parseInt(dialogHeight);
	$("#modal_info").modal('show').attr('style','top:'+top+'px !important;');
}