function getservices(){
    var id = $("#spid").val();
    var usertype = $("#usertype").val();
        $('#tbl-services').DataTable( {
        "bProcessing":true, 
        "bServerSide":true,
        "bRetrieve": true,
        "bDestroy":true,
        "sLimit":10,
        "sAjaxSource": "sp_profile/dataTables/1/"+id,
        "aoColumns":[ {"sTitle":"ID","bVisible":false},
                {"sTitle":"Services"},
                {"sTitle":"Description","bSearchable": true},
                {"sTitle":"Registration Fee (Peso)","bSearchable": true},
                {"sTitle":"Walk-in Fee/Session (Peso)","bSearchable": true},
                {"sTitle":"# of Hours Per Session","bSearchable": true},
                {"sTitle":"Monthly Fee (Peso)","bSearchable": true},
                {"sTitle":"Type","bSearchable": true},
                {"sTitle":"Actions",'bVisible':true,"bSortable":false}
        ],
        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
            if ( aData[8] == 1 ){
                $('td:eq(7)', nRow).html('<button class = "btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="  Enroll" onclick = enroll('+aData[0]+')><i class = "fa fa-sign-in fa-fw"></i></button>');
              }
        },
        "fnInitComplete": function(oSettings, json) {
        }
      }).on('processing.dt',function(oEvent, settings, processing){
      });
   

}

function clientlist(id){
        $('#tbl-client').DataTable( {
        "bProcessing":true, 
        "bServerSide":true,
        "bRetrieve": true,
        "bDestroy":true,
        "sLimit":10,
        "sAjaxSource": "sp_profile/dataTables/3/"+id,
        "aoColumns":[   {"sTitle":"User ID"},
                        {"sTitle":"Name"},
                        {"sTitle":"Birthday","bSearchable": true},
                        {"sTitle":"Contact Number","bSearchable": true},
                        {"sTitle":"Email","bSearchable": true},
                        {"sTitle":"Address","bSearchable": true}
        ],
        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
          
        },
        "fnInitComplete": function(oSettings, json) {
        }
    }).on('processing.dt',function(oEvent, settings, processing){
    });

}

function enrolledStudents(id){
        $('#tbl-enrolled').DataTable( {
    "bProcessing":true, 
    "bServerSide":true,
    "bRetrieve": true,
    "bDestroy":true,
    "sLimit":10,  
    "sAjaxSource": "sp_profile/dataTables/4/"+id,
    "aoColumns":[ 
            {"sTitle":"ID","sName":"ID","bVisible":false},
            {"sTitle":"Student ID","sName":"studid","bVisible":true},
            {"sTitle":"Name","sName":"name"},
            {"sTitle":"Age","sName":"age","bSearchable": true},
            {"sTitle":"Address","sName":"address","bSearchable": true},
            {"sTitle":"Client","sName":"client","bSearchable": true},
            {"sTitle":"Service","sName":"service","bSearchable": true},
            {"sTitle":"Instructor","sName":"instructor","bSearchable": true},
            {"sTitle":"Date Enrolled","sName":"date_enrolled","bSearchable": true},
            {"sTitle":"Schedule","sName":"SchedDays","bSearchable": true}
    ],
    "fnRowCallback": function( nRow, aData, iDisplayIndex ) {


    },
    "fnInitComplete": function(oSettings, json) {
    }
  }).on('processing.dt',function(oEvent, settings, processing){
  });

}

function masterlistInstructors(id){
  var usertype = $("#usertype").val();
  if(usertype == 0){
		var table = $('#tbl-ins_masterlist').DataTable( {
		"bProcessing":true, 
		"bServerSide":true,
		"bRetrieve": true,
		"bDestroy":true,
		"sLimit":10,
		"sAjaxSource": "sp_profile/dataTables/2/"+id,
		"aoColumns":[ {"sTitle":"ID","sName":"MasterInsID","bVisible":false},
				{"sTitle":"Name","sName":"MasterInsName"},
				{"sTitle":"Address","sName":"MasterInsAddress","bSearchable": true},
				{"sTitle":"Contact #","sName":"MasterInsContactNo","bSearchable": true},
				{"sTitle":"E-mail","sName":"MasterInsEmail","bSearchable": true},
				{"sTitle":"Expertise","sName":"MasterInsExpertise","bSearchable": true}
		],
		"fnRowCallback": function( nRow, aData, iDisplayIndex ) {
		},
		"fnInitComplete": function(oSettings, json) {
		}
	  }).on('processing.dt',function(oEvent, settings, processing){
	  });  
  }else{
	  var table = $('#tbl-ins_masterlist').DataTable( {
		"bProcessing":true, 
		"bServerSide":true,
		"bRetrieve": true,
		"bDestroy":true,
		"sLimit":10,
		"sAjaxSource": "sp_profile/dataTables/2/"+id,
		"aoColumns":[ {"sTitle":"ID","sName":"MasterInsID","bVisible":false},
                {"sTitle":"Name","sName":"MasterInsName"},
                {"sTitle":"Address","sName":"MasterInsAddress","bSearchable": true},
                {"sTitle":"Contact #","sName":"MasterInsContactNo","bSearchable": true},
                {"sTitle":"E-mail","sName":"MasterInsEmail","bSearchable": true},
                {"sTitle":"Expertise","sName":"MasterInsExpertise","bSearchable": true},
                {"sTitle":"Action","bSearchable": true}
        ],
		"fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                $('td:eq(5)', nRow).html('<button class = "btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="  Enroll" onclick = viewInstructorSched('+aData[0]+')><i class = "fa fa-sign-in fa-fw"></i></button>');
              
        },
		"fnInitComplete": function(oSettings, json) {
		}
	  }).on('processing.dt',function(oEvent, settings, processing){
	  });  
  }
  
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

function viewInstructorSched(instructorid){
	var height = $(window).height();
    var dialogHeight = $("#modal_instructor_sched").find('.modal-dialog').outerHeight(true);
    var top = parseInt(height)/6-parseInt(dialogHeight);
    $("#modal_instructor_sched").modal('show').attr('style','top:'+top+'px !important;');

    var getEvent = [];
    $.ajax({
      url:'clinics/getInstructorSched/'+instructorid, //getting the list of events
      dataType:'JSON',
      type:'POST',
      success:function(msg){ 
        $.each(msg, function(i,e){
			var start_end_date = e.SchedTime.split("-");
			var start_end_days = e.SchedDays.split(",");
			var getDays = [];
			$.each(start_end_days, function(iS,eS){
				getDays.push(getNumDay(eS));
			});
            var insertEvents = {};
            insertEvents = {
                id: e.SchedID,
                title: e.ServiceName+'\n'+e.SchedDays+'\n'+e.SchedTime+"\n"+e.Room,
                description: e.ServiceName+'\n'+e.SchedDays+'\n'+e.SchedTime+"\n"+e.Room,
				start: start_end_date[0],
				end: start_end_date[1],
				numSched: e.ch_sched,
				clinicid: e.SPID,
				serviceid: e.ServiceID,
				instructorid: instructorid,
				dow: getDays
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

        $('#calendar_instructor_sched').fullCalendar({
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
				if(event.numSched == 0){
					 $(element).html('<button class="btn btn-primary btn-sm" id="btn-enrollEvent" data-toggle="tooltip" data-placement="top" title="Enroll '+event.title+'" onclick="EnrollSchedule('+event.id+','+event.instructorid+','+event.clinicid+','+event.serviceid+')"><span class = "glyphicon glyphicon-calendar"></span></button> &nbsp;' + event.title);
				}
               
            }
        });
        
      }
    }); 
}

function EnrollSchedule(schedid,insid,clinicid,serviceid){
	$("#forminstructorenroll").show();
	$("#btn-InstructorEnroll").show();
	$("#calendar_instructor_sched").hide();
	changeStudType();
	
	$('#btn-InstructorEnroll').click(function(){
        SaveEnrollSchedule(schedid,insid,clinicid,serviceid);
    });
}

function SaveEnrollSchedule(schedid,insid,clinicid,serviceid){
	var dataForm = $("#forminstructorenroll").serializeArray();
    var data = {};
    var studType = $("#StudTypeins").val();
    data['studType'] = studType;
    
    var cherror = 0; //if not error
    
	if(studType==0){ //new student
		$.each(dataForm,function(i,e){
		  var nname = e.name.replace("ins","");
		  var name = $("#"+e.name.replace("ins",""));    
		  data[nname] = e.value;
		  
		  if(nname == "stud_name" || nname == "stud_age" || nname == "stud_address" || nname == "relationship"){
			  if(e.value == ""){
				name.parent().addClass("has-error");
			  }else{
				name.parent().removeClass('has-error'); 
			  }
			  
			  if (nname == "stud_age"){
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
		
		var error = $("#forminstructorenroll .has-error").length;
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
		  var nname = e.name.replace("ins","");
		  var name = $("#"+e.name.replace("ins",""));  
		  if(nname == "stud_name" || nname == "stud_age" || nname == "stud_address" || nname == "relationship"){
		  }else{
			  data[nname] = e.value;
			  if (nname == "stud_id"){
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
	}
	
	data["clinic_id"] = clinicid;
	data["ins_id"] = insid;
	data["service_id"] = serviceid;
	data["SchedID"] = schedid;
	
	if(cherror == 0){
		$.ajax({
		  url:'clinics/saveEnroll',
		  data:{data},
		  dataType:'JSON',
		  type:'POST',
		  success:function(msg){
			$("#message .alert").removeClass('alert-danger').removeClass('alert-success');
			var nme = $("#stud_nameins").val()+" is";
			if(studType==1){
				nme = $("#stud_idins option:selected").text();
			}else if(studType ==2){
				nme = "You are";
			}
			if(msg == 0){
				$("#message .alert").html(nme+" now on the waiting list of this clinic's service's service.").addClass('alert-success').show();$("#message").addClass('zindex');
				$("#stud_name").val("");$("#stud_age").val("");$("#stud_address").val("");
				setTimeout(function(){
					$("#message .alert").html("").removeClass('alert-success').hide();$("#message").removeClass('zindex');
					window.location = 'sp_profile?susid='+$("#spid").val();
				},3000);
			}else if(msg == 3){ //existing student in a clinic
			
				$("#message .alert").html(nme+" already exist. Please select Student Type: Existing.").addClass('alert-danger').show();$("#message").addClass('zindex');
				$("#stud_name").val("");$("#stud_age").val("");$("#stud_address").val("");
			}else if(msg == 4){ //student already enrolled in schedule selected
				$("#message .alert").html(nme+" already enrolled in this schedule").addClass('alert-danger').show();$("#message").addClass('zindex');
			}else if(msg == 5){
				$("#message .alert").html("The service has reached its maximum capacity for the selected schedule. Please select other schedule if any.").addClass('alert-danger').show();$("#message").addClass('zindex');
			}else if(msg == 6){
				$("#message .alert").html(nme+" already in this clinic's waiting list for approval.").addClass('alert-danger').show();$("#message").addClass('zindex');
			}else if(msg == 7){
				$("#message .alert").html("Schedule is conflict. Please select a different schedule.").addClass('alert-danger').show();$("#message").addClass('zindex');
			}else{
			  $("#message .alert").html("An error occurred during the process. Please try again later or contact the administrator.").addClass('alert-danger').show();$("#message").addClass('zindex');
			}
			
			if(msg !=0){
				setTimeout(function(){
					$("#message .alert").html("").removeClass('alert-danger').hide();$("#message").removeClass('zindex');
				},3000);
			}
		  }
		});
	}
}

function getPromo(){
    var id = $("#spid").val();
    $.ajax({
        url:'sp_profile/getPromo/'+id,
        dataType:'JSON',
        success:function(msg){
            var content = "",timestamp,month = ['Jan','Feb','Mar','April','May','Jun','Jul','Aug','Sept','Oct','Nov','Dec'];

            $.each(msg, function(i,e){
                timestamp = new Date(e.timestamp);
                var t = e.timestamp.split('-'),m = t[1], d = t[2];
                content += '<div class="col-md-6 post-row">'+
                        '<div class="left-meta-post">'+
                          '<div class="post-date"><span class="day">'+d+'</span><span class="month">'+month[parseInt(m-1)]+'</span></div>'+
                          '<div class="post-type"><i class="fa fa-picture-o"></i></div>'+
                        '</div>'+
                        '<h3 class="post-title"><a href="#">'+e.PromoName+'</a></h3>'+
                       ' <div class="post-content">'+
                             '<p>PROMO PERIOD :'+e.PromoStartDate+' - '+e.PromoEndDate+'</p>'+
                          '<p>'+e.PromoDesc+'</a></p>'+
                        '</div>'+
                     '</div>';
            });

            $('#tab-promo').html(content);
        }
    });
}

function eventCalendar(){ //showing the calendar event
    var id = $("#spid").val();
    var getEvent = [];
    $.ajax({
      url:'events_and_promos/getEvents/'+id, //getting the list of events
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
                $(element).html('<button class="btn btn-primary btn-sm" id="btn-enrollEvent" data-toggle="tooltip" data-placement="top" title="Enroll '+event.title+'" onclick="EnrollEvent('+event.id+','+event.spid+')"><span class = "glyphicon glyphicon-calendar"></span></button> &nbsp;' + event.title); 
               // $(element).html('<button class="btn btn-primary btn-sm" id="btn-editEvent" data-toggle="tooltip" data-placement="top" title="Edit '+event.title+'" onclick="editEvent('+event.id+')"><span class = "glyphicon glyphicon-pencil"></span></button><button class = "btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Remove '+event.title+'" onclick="removeEvent('+event.id+')"><span class = "glyphicon glyphicon-trash"></span></button> &nbsp;' + event.title); 
            }
        });
        
      }
    }); 
}

$(document).ready(function(){
     $('#loader').fadeOut();
     
     var clinicname = $("#clinicname").val(),
        clinicid = $("#clinicid").val(),
        spid = $("#spid").val();
    getservices();
    enrolledStudents(spid);
    masterlistInstructors(spid);
    clientlist(clinicid);
    $('#btn-Enroll').click(function(){
        saveEnroll();
    });
    $('#Schedule').change(function(){
        changeSchedule($( this ).val());
    });

    $('#btn-EventEnroll').click(function(){
        saveEnrollEvent();
    });
	
	$('#StudTypeins').change(function(){
        if ($( this ).val() == 0){
            $("#stud-newins").show();
            $("#stud-existins").hide();
        }else if ($( this ).val() == 1){
            $("#stud-newins").hide();
            $("#stud-existins").show();
             changeStudType();
        }else if($( this ).val() == 2){
            $("#stud-newins").hide();
            $("#stud-existins").hide();
        }
    });
    
    $('#StudType1').change(function(){
        if ($( this ).val() == 0){
            $("#stud-new1").show();
            $("#stud-exist1").hide();
        }else if ($( this ).val() == 1){
            $("#stud-new1").hide();
            $("#stud-exist1").show();
             changeStudType();
        }else if($( this ).val() == 2){
            $("#stud-new1").hide();
            $("#stud-exist1").hide();
        }
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

    var table = $("#tbl-services").DataTable();
    $('[data-toggle="tooltip"]').tooltip();
    getPromo();
    eventCalendar();
    albumDisplay();
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
    
    $("#SaveComment").click(function(){
        SaveComment(clinicid,clinicname,spid);
    });
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


function albumDisplay(){
 var id = $("#spid").val();
    $.ajax({
        url:'gallery/albumDisplay/'+id,
        dataType:'JSON',
        success:function(msg){
            var content = "";
            $.each(msg,function(i,e){
                var filename = e.albumName+"_"+e.UserID+"/"+e.fileName;
                if(e.fileName == null) filename = "face_2.png"
                content += "<div class='portfolio-item item'>"+
                            "<div class='portfolio-border'>"+
                            "<div class='portfolio-thumb'>"+
                            '<a href="#" class="viewalbum" id="'+e.albumID+'" title = "'+e.albumName+'">'+
                            "<div class='thumb-overlay'><i class='fa fa-arrows-alt'></i></div>"+
                            "<img alt='' src='assets/images/"+filename+"' />"+
                            "</a>"+
                            "</div>"+
                            "<div class='portfolio-details'>"+
                            '<a href="#" class="viewalbum" id="'+e.albumID+'" title = "'+e.albumName+'">'+
                            "<h4>"+e.albumName+"</h4>"+
                            "<span>"+e.dateCreated+"</span>"+
                            "</a>"+
                            "<a href='#' class='like-link'><i class='fa fa-picture-o'></i><span>"+e.count+"</span></a>"+
                            "</div></div></div>";
            });
            
            $("#albumDisplay").html(content).addClass("projects-carousel touch-carousel");
            var $owl = $('#albumDisplay');
            $owl.trigger('destroy.owl.carousel');
            // After destory, the markup is still not the same with the initial.
            // The differences are:
            //   1. The initial content was wrapped by a 'div.owl-stage-outer';
            //   2. The '.owl-carousel' itself has an '.owl-loaded' class attached;
            //   We have to remove that before the new initialization.
            $owl.html($owl.find('.owl-stage-outer').html()).removeClass('owl-loaded');
            $(".projects-carousel").owlCarousel({
                navigation : true,
                pagination: false,
                slideSpeed : 400,
                stopOnHover: true,
                autoPlay: 3000,
                items : 4,
                itemsDesktopSmall : [900,3],
                itemsTablet: [600,2],
                itemsMobile : [479, 1]
            });
            $('.touch-slider').find('.owl-prev').html('<i class="fa fa-angle-left"></i>');
            $('.touch-slider').find('.owl-next').html('<i class="fa fa-angle-right"></i>');
            $('.touch-carousel, .testimonials-carousel').find('.owl-prev').html('<i class="fa fa-angle-left"></i>');
            $('.touch-carousel, .testimonials-carousel').find('.owl-next').html('<i class="fa fa-angle-right"></i>');
            $(".viewalbum").click(function(e){
                e.preventDefault();
                var id = $(this).attr('id'),
                    title = $(this).attr('title');
                viewAlbum(id, title);
            });
        }
    });
}

function viewAlbum(id,title){
    loadImages(id,title);

}

function loadImages(id,title){
    $.ajax({
        url:'gallery/loadImages/'+id,
        dataType:'JSON',
        success:function(msg){
            
            var content = "";
            $.each(msg, function(i,e){
                content += '<div class = "col-md-3"><div class="portfolio-item item">'+
                '<div class="portfolio-border">'+                  
                '<div class="portfolio-thumb">'+
                    '<a class="lightbox" title="'+e.fileName+'" href="assets/images/'+e.albumName+"/"+e.fileName+'">'+
                      '<div class="thumb-overlay"><i class="fa fa-arrows-alt"></i></div>'+
                      '<img alt="" src="assets/images/'+e.albumName+"/"+e.fileName+'" />'+
                    '</a>'+
                 '</div>'+
                  '<div class="portfolio-details">'+
                    '<a href="#">'+
                      '<h4>'+e.fileName+'</h4>'+
                     ' <span>'+e.dateCreated+'</span>'+
                    '</a>'+
                  '</div>'+
                '</div>'+
              '</div></div>';
            });

            $("#gallerydisplay").focus().html(content).show('slide');
           
            $('.lightbox').nivoLightbox({
                effect: 'fadeScale',
                keyboardNav: true,
                errorMessage: 'The requested content cannot be loaded. Please try again later.'
            });
            $("#gallery_list .title").html("<span>"+title+"</span>");
        }
    });


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

function SaveComment(clinicid,clinicname,spid){
    var dataForm = $("#formrate").serializeArray();
    var data = {};
    var message = $("#Message").val();
    var rating = $("#Rating").val();
    
    if(rating == "" || rating == 0 || message == ""){
        $("#message .alert").html("Either message or rating is empty.").addClass('alert-danger').show();$("#message").addClass('zindex');
        setTimeout(function(){
            $("#message .alert").html("").removeClass('alert-danger').hide();$("#message").removeClass('zindex');
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
                $("#message .alert").html("Reviews has been saved. Waiting for approval.").addClass('alert-success').show();$("#message").addClass('zindex');
            }else if(msg ==2){
                $("#message .alert").html("You are not allowed to make any reviews for "+clinicname+" because you are not enrolled with this clinic.").addClass('alert-danger').show();$("#message").addClass('zindex');
            }else{
                $("#message .alert").html("An error occurred during the process. Please try again later or contact the administrator.").addClass('alert-danger').show();$("#message").addClass('zindex');
            }
            setTimeout(function(){
                $("#message .alert").html("").removeClass('alert-success').hide();$("#message").removeClass('zindex');
                $("#message .alert").html("").removeClass('alert-danger').hide();$("#message").removeClass('zindex');
                window.location = 'sp_profile?susid='+spid;
            },2000);
        }
    });
    }
}

function enroll(serviceid){
    var height = $(window).height();
    var dialogHeight = $("#modal_enroll").find('.modal-dialog').outerHeight(true);
    var top = parseInt(height)/6-parseInt(dialogHeight);
    $("#modal_enroll").modal('show').attr('style','top:'+top+'px !important;');
    $("#service_id").val(serviceid);
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
    
    //getRelationship();
}

function saveEnroll(){
    var dataForm = $("#formstudent").serializeArray();
    var data = {};
    var studType = $("#StudType").val();
    var service = $("#service_id").val();
    var schedule = $("#Schedule").val();
    data['studType'] = studType;
    
    var cherror = 0; //if not error
    
    if(service==0 || schedule==0){
        $("#message .alert").html("Service or schedule is missing.").addClass('alert-danger').show();$("#message").addClass('zindex');
        setTimeout(function(){
            $("#message .alert").html("").removeClass('alert-danger').hide();$("#message").removeClass('zindex');
        },2000);
    }else{
        if(studType==0){ //new student
            $.each(dataForm,function(i,e){
              var name = $("#"+e.name);  
              data[e.name] = e.value;
              
              if(e.name == "stud_name" || e.name == "stud_age" || e.name == "stud_address" || e.name == "relationship"){
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
                $("#message .alert").removeClass('alert-danger').removeClass('alert-success');
                var nme = $("#stud_name").val()+" is";
                if(studType==1){
                    nme = $("#stud_id option:selected").text();
                }else if(studType ==2){
                    nme = "You are";
                }
                if(msg == 0){
                    $("#message .alert").html(nme+" now on the waiting list of this clinic's service's service.").addClass('alert-success').show();$("#message").addClass('zindex');
                    $("#stud_name").val("");$("#stud_age").val("");$("#stud_address").val("");
                    setTimeout(function(){
                        $("#message .alert").html("").removeClass('alert-success').hide();$("#message").removeClass('zindex');
                        window.location = 'sp_profile?susid='+$("#spid").val();
                    },3000);
                }else if(msg == 3){ //existing student in a clinic
                
                    $("#message .alert").html(nme+" already exist. Please select Student Type: Existing.").addClass('alert-danger').show();$("#message").addClass('zindex');
                    $("#stud_name").val("");$("#stud_age").val("");$("#stud_address").val("");
                }else if(msg == 4){ //student already enrolled in schedule selected
                    $("#message .alert").html(nme+" already enrolled in this schedule").addClass('alert-danger').show();$("#message").addClass('zindex');
                }else if(msg == 5){
                    $("#message .alert").html("The service has reached its maximum capacity for the selected schedule. Please select other schedule if any.").addClass('alert-danger').show();$("#message").addClass('zindex');
                }else if(msg == 6){
                    $("#message .alert").html(nme+" already in this clinic's waiting list for approval.").addClass('alert-danger').show();$("#message").addClass('zindex');
                }else if(msg == 7){
                    $("#message .alert").html("Schedule is conflict. Please select a different schedule.").addClass('alert-danger').show();$("#message").addClass('zindex');
                }else{
                  $("#message .alert").html("An error occurred during the process. Please try again later or contact the administrator.").addClass('alert-danger').show();$("#message").addClass('zindex');
                }
                
                if(msg !=0){
                    setTimeout(function(){
                        $("#message .alert").html("").removeClass('alert-danger').hide();$("#message").removeClass('zindex');
                    },3000);
                }
              }
            });
        }
    }
    
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

function getRelationship(){
    $.ajax({
        url:'clinics/getRelationship/',
        dataType:'JSON',
        type:'POST',
        success:function(msg){ 
            var result = "";
            $("#relationship").html("");
            $.each(msg, function(i,e){  
                result += '<option value='+e.relationship_name+'>'+e.relationship_name+'</option>';     
            }); 
            $('#relationship,#relationship1').html(result).trigger("chosen:updated");
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
            $('#stud_id,#stud_id1,#stud_idins').html(result).trigger("chosen:updated");
        }
    });
}
function EnrollEvent(eventid,spid){
    var height = $(window).height();
    var dialogHeight = $("#modal_enroll_event").find('.modal-dialog').outerHeight(true);
    var top = parseInt(height)/6-parseInt(dialogHeight);
    $("#modal_enroll_event").modal('show').attr('style','top:'+top+'px !important;');
    //getRelationship();
    $("#EventID").val(eventid);
}

function saveEnrollEvent(){
    var dataForm = $("#formevent").serializeArray();
    var data = {};
    var studType = $("#StudType1").val();
    var service = $("#Service").val();
    var schedule = $("#Schedule").val();
    data['studType'] = studType;
    
    var cherror = 0; //if not error
    
    if(studType==0){ //new student
        $.each(dataForm,function(i,e){
          var name = $("#"+e.name);  
         
           if(e.name == 'SPID1') data['SPID']=e.value;
            else if(e.name == 'studType1') data['studType'] = e.value;
            else if(e.name == 'stud_id1') data['stud_id'] = e.value;
            else if(e.name == 'relationship1') data['relationship'] = e.value;
            else if(e.name == 'stud_address1') data['stud_address'] = e.value;
            else if(e.name == 'stud_age1') data['stud_age'] = e.value;
            else if(e.name == 'stud_id1') data['stud_id'] = e.value;
            else if(e.name == 'stud_name1') data['stud_name'] = e.value;
            else  data[e.name] = e.value;

          if(e.name == "stud_name1" || e.name == "stud_age1" || e.name == "stud_address1" || e.name == "relationship1"){
              if(e.value == ""){
                name.parent().addClass("has-error");
              }else{
                name.parent().removeClass('has-error'); 
              }
              
              if (e.name == "stud_age1"){
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
  
          if(e.name == "stud_name1" || e.name == "stud_age1" || e.name == "stud_address1"){
          }else{
            if(e.name == 'SPID1') data['SPID']=e.value;
            else if(e.name == 'studType1') data['studType'] = e.value;
            else if(e.name == 'stud_id1') data['stud_id'] = e.value;
            else if(e.name == 'relationship1') data['relationship'] = e.value;
            else data[e.name] = e.value;
              if (e.name == "stud_id1"){
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
  
          if(e.name == "EventID" || e.name == "SPID1"){
                if(e.name == 'SPID1') data['SPID']=e.value;
                else if(e.name == 'studType1') data['studType'] = e.value;
                else data[e.name] = e.value;
          }
        });
    }
    
    if(cherror == 0){
        data['EventID'] = $("#EventID").val();
        $.ajax({
          url:'myevents/saveEnrollEvent',
          data:{data},
          dataType:'JSON',
          type:'POST',
          success:function(msg){
            var nme = $("#stud_name1").val();
            if(studType==1){
                nme = $("#stud_id1 option:selected").text();
            }else if(studType ==2){
                nme = "Client";
            }
            if(msg == 0){
                $("#message .alert").html(nme+" has been enrolled successfully.").addClass('alert-success').show();$("#message").addClass('zindex');
                $("#stud_name1").val("");$("#stud_age1").val("");$("#stud_address1").val("");
                setTimeout(function(){
                    $("#message .alert").html("").removeClass('alert-success').hide();$("#message").removeClass('zindex');
                     window.location = 'sp_profile?susid='+$("#spid").val();
                },2000);
            }else if(msg == 3){ //existing student in a clinic
            
                $("#message .alert").html($("#stud_name1").val()+" student is already exist. Please select Student Type: Existing.").addClass('alert-danger').show();$("#message").addClass('zindex');
                $("#stud_name1").val("");$("#stud_age1").val("");$("#stud_address1").val("");
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

