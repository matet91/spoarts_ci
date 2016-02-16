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
	$("#ServiceInfo").click(function(){
		$("#services-div").toggle();
	});
	
});

$(function () {
        $('input.check').on('change', function () {
          alert('Rating: ' + $(this).val());
        });
        $('#programmatically-set').click(function () {
          $('#programmatically-rating').rating('rate', $('#programmatically-value').val());
        });
        $('#programmatically-get').click(function () {
          alert($('#programmatically-rating').rating('rate'));
        });
        $('.rating-tooltip').rating({
          extendSymbol: function (rate) {
            $(this).tooltip({
              container: 'body',
              placement: 'bottom',
              title: 'Rate ' + rate
            });
          }
        });
        $('.rating-tooltip-manual').rating({
          extendSymbol: function () {
            var title;
            $(this).tooltip({
              container: 'body',
              placement: 'bottom',
              trigger: 'manual',
              title: function () {
                return title;
              }
            });
            $(this).on('rating.rateenter', function (e, rate) {
              title = rate;
              $(this).tooltip('show');
            })
            .on('rating.rateleave', function () {
              $(this).tooltip('hide');
            });
          }
        });
        $('.rating').each(function () {
          $('<span class="label label-default"></span>')
            .text($(this).val() || ' ')
            .insertAfter(this);
        });
        $('.rating').on('change', function () {
          $(this).next('.label').text($(this).val());
        });
      });

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
				          "<a href='#' onclick = info('"+e.clinic_id+"','"+e.UserID+"') data-toggle='tooltip' data-placement='top' title='More Info' ><i class='more fa fa-info' style = 'left:80% !important;height:50px !important;width:50px !important;line-height:49px !important;font-size:30px !important;'></i></a>"+
				        "</li><input type='hidden' class = 'form-control' id = 'clinicname"+e.clinic_id+"' value='"+e.clinic_name+"' />";

			});
			if(search != '' && search != 0){
				$('#clinic .classic-title').html("<b class = 'alert alert-info'>Found : "+msg.length+" clinic(s)...</b>");
			}
			$('#portfolio-list').html(content);
		}
	});
	
	$("#ServiceInfo").click(function(){
        $("#mypayment_list").toggle();
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
				result += '<option value='+e.SchedID+'>'+e.SchedDays+' @ '+e.SchedTime+'</option>';	
			});	
			//$("#Schedule").append(result);	
			//$('#Schedule').chosen().trigger("chosen:updated");
			$('#Schedule').html(result).trigger("chosen:updated");
		}
    });
	
}

function enroll(c,userid,clinic_id){
	if($("#ses_userid").val() == ""){
		$("#message .alert").html("You cannot enroll from this clinic. Need to create an account first.").addClass('alert-danger').show();
		setTimeout(function(){
			$("#message .alert").html("").removeClass('alert-danger').hide();
		},2000);
	}else{
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
				var nme = $("#stud_name").val();
				if(studType==1){
					nme = $("#stud_id option:selected").text();
				}else if(studType ==2){
					nme = "Client";
				}
				if(msg == 0){
					$("#message .alert").html(nme+" has been enrolled successfully.").addClass('alert-success').show();
					$("#stud_name").val("");$("#stud_age").val("");$("#stud_address").val("");
					setTimeout(function(){
						$("#message .alert").html("").removeClass('alert-success').hide();
						window.location = 'clinics?type='+$("#ctype").val();
					},2000);
				}else if(msg == 3){ //existing student in a clinic
				
					$("#message .alert").html($("#stud_name").val()+" student is already exist. Please select Student Type: Existing.").addClass('alert-danger').show();
					$("#stud_name").val("");$("#stud_age").val("");$("#stud_address").val("");
				}else if(msg == 4){ //student already enrolled in schedule selected
					$("#message .alert").html(nme+" already enrolled in this schedule").addClass('alert-danger').show();
				}else if(msg == 5){
					$("#message .alert").html("The service has reached its maximum capacity for the selected schedule. Please select other schedule if any.").addClass('alert-danger').show();
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
	if($("#ses_userid").val() == ""){
		$("#message .alert").html("You cannot bookmark a clinic. You need to create an account first.").addClass('alert-danger').show();
		setTimeout(function(){
			$("#message .alert").html("").removeClass('alert-danger').hide();
		},2000);
	}else{
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
}

function info(clinicid,spid){
	var height = $(window).height();
	var dialogHeight = $("#modal_info").find('.modal-dialog').outerHeight(true);
	var top = parseInt(height)/6-parseInt(dialogHeight);
	$("#modal_info").modal('show').attr('style','top:'+top+'px !important;');
	var clinicname = $("#clinicname"+clinicid).val();
	infoservice(clinicid);
	reviewsratings(clinicid,clinicname,0);
	$("#ReviewsRatings").click(function(){
		reviewsratings(clinicid,clinicname,1);
		$("#ReviewsRatings").hide();
		$("#HideReviewsRatings").show();
	});
	$("#HideReviewsRatings").click(function(){
		reviewsratings(clinicid,clinicname,0);
		$("#ReviewsRatings").show();
		$("#HideReviewsRatings").hide();
	});
	
	if($("#ses_userid").val() == ""){
		$("#formrate").hide();
	}else{
		$("#SaveComment").click(function(){
			SaveComment(clinicid,clinicname,spid);
		});
	}
	
}

function SaveComment(clinicid,clinicname,spid){
	var dataForm = $("#formrate").serializeArray();
	var data = {};
	var message = $("#Message").val();
	var rating = $("#Rating").val();
	
	if(rating == "" || rating == 0 || message == ""){
		$("#message .alert").html("Either message or rating is empty.").addClass('alert-danger').show();
		setTimeout(function(){
			$("#message .alert").html("").removeClass('alert-danger').hide();
		},2000);
	}else{
		data['Message'] = message;
		data['Rating'] = rating;
		data['clinic_id'] = clinicid;
		data['SPID'] = spid;
		
		$.ajax({
		url:'clinics/SaveRating',
		data:{data:data},
		dataType:'JSON',
		type:'POST',
		success:function(msg){
			if(msg == 0){ //if success
				$("#message .alert").html("Reviews has been saved. Waiting for approval.").addClass('alert-success').show();
				setTimeout(function(){
					$("#message .alert").html('').removeClass('alert-success').hide();
				},2000);
			}else if(msg ==2){
				$("#message .alert").html("You are not allowed to make any reviews for "+clinicname+" because you are not enrolled with this clinic.").addClass('alert-danger').show();
				setTimeout(function(){
					$("#message .alert").html('').removeClass('alert-danger').hide();
				},2000);
				
			}else{
				$("#message .alert").html("An error occurred during the process. Please try again later or contact the administrator.").addClass('alert-danger').show();
				setTimeout(function(){
					$("#message .alert").html('').removeClass('alert-danger').hide();
				},2000);
			}
			setTimeout(function(){
				window.location = 'clinics?type='+$("#ctype").val();
			},2000);
		}
	});
	}
}


function reviewsratings(clinicid,clinicname,limit){
	$.ajax({
		url:'clinics/getReviewsRatings/'+clinicid+'/'+limit,
		dataType:'JSON',
		type:'POST',
		success:function(msg){
			var result = "";
			$.each(msg, function(i,e){
				var star = "";
				for(var str = 0; str < e.Rating ; str++){
					star += '<span class = "glyphicon glyphicon-star-empty"></span>';
				}
				 result += '<div class="classic-testimonials item">'+
						  '<div class="testimonial-content">'+
						  '<p>'+e.Message+'</p>'+
						  '</div>'+
						  '<div class="testimonial-author">'+star+' <span>'+e.Cname+'</span> - Customer of '+clinicname+'</div>'+
						  '</div>';
			});
			$("#reviewsratings-div").html(result);
		}
	})
	
}

function infoservice(clinicid){
	$('#services_list').DataTable( {
	"bProcessing":true, 
	"bServerSide":true,
	"bRetrieve": true,
	"bDestroy":true,
	"sAjaxSource": "clinics/dataTables/1/"+clinicid,
	"aoColumns":[	{"sTitle":"ID","bVisible":false},
					{"sTitle":"Service","bSearchable": true},
					{"sTitle":"Registration Fee","bSearchable": true},
					{"sTitle":"Monthly Fee","bSearchable": true},
					{"sTitle":"Walkin Fee","bSearchable": true},
					{"sTitle":"Service/Hour","bSearchable": true},
					{"sTitle":"Type","bSearchable": true}
	],
	"fnInitComplete": function(oSettings, json) {
	}
  }).on('processing.dt',function(oEvent, settings, processing){
  });
}