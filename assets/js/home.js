$(document).ready(function(){
	allclubs();
	if($("#huserid").val() == ""){
		getReviewsRatings();
		testimonials();
		loadEventPromo();
		//loadAllClinic();
		
	}
	
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
	
	$('#btn-Enroll').click(function(){
		saveEnroll();
	});
	
});

function loadEventPromo(){
	$.ajax({
		url:'cglobal/loadEventPromo/',
		dataType:'JSON',
		type:'POST',
		success:function(msg){
			$('#loader').fadeOut();
			 var content = "",timestamp,month = ['Jan','Feb','Mar','April','May','Jun','Jul','Aug','Sept','Oct','Nov','Dec'];

            $.each(msg, function(i,e){
                timestamp = new Date(e.timestamp);
                var t = e.timestamp.split('-'),m = t[1], d = t[2],promo='Event Period ';
                if(e.type == 1){
                	promo = "Promo Period ";
                }
                content += '<div class="post-row item">'+
	                    '<div class="left-meta-post">'+
	                      '<div class="post-date"><span class="day">'+d+'</span><span class="month">'+month[parseInt(m-1)]+'</span></div>'+
	                      '<div class="post-type"><i class="fa fa-picture-o"></i></div>'+
	                    '</div>'+
	                    '<h3 class="post-title"><a href="#">'+e.name+'</a></h3>'+
	                    '<div class="post-content">'+
	                    	'<p>'+promo+':'+e.start+' - '+e.end+'</p>'+
	                      '<p>'+e.desc+'</p>'+
	                    '</div>'+
	                  '</div>';
            });
            $("#eventpromolist").html(content).addClass('custom-carousel touch-carousel').attr('data-appeared-items',2);
			var $owl = $('#eventpromolist');
			$owl.trigger('destroy.owl.carousel');
			// After destory, the markup is still not the same with the initial.
			// The differences are:
			//   1. The initial content was wrapped by a 'div.owl-stage-outer';
			//   2. The '.owl-carousel' itself has an '.owl-loaded' class attached;
			//   We have to remove that before the new initialization.
			$owl.html($owl.find('.owl-stage-outer').html()).removeClass('owl-loaded');
			$('.custom-carousel').each(function(){
		var owl = jQuery(this),
			itemsNum = $(this).attr('data-appeared-items'),
			sliderNavigation = $(this).attr('data-navigation');
			
		if ( sliderNavigation == 'false' || sliderNavigation == '0' ) {
			var returnSliderNavigation = false
		}else {
			var returnSliderNavigation = true
		}
		if( itemsNum == 1) {
			var deskitemsNum = 1;
			var desksmallitemsNum = 1;
			var tabletitemsNum = 1;
		} 
		else if (itemsNum >= 2 && itemsNum < 4) {
			var deskitemsNum = itemsNum;
			var desksmallitemsNum = itemsNum - 1;
			var tabletitemsNum = itemsNum - 1;
		} 
		else if (itemsNum >= 4 && itemsNum < 8) {
			var deskitemsNum = itemsNum -1;
			var desksmallitemsNum = itemsNum - 2;
			var tabletitemsNum = itemsNum - 3;
		} 
		else {
			var deskitemsNum = itemsNum -3;
			var desksmallitemsNum = itemsNum - 6;
			var tabletitemsNum = itemsNum - 8;
			}
				$owl.owlCarousel({
				    // your initial option here, again.
				   slideSpeed : 300,
					stopOnHover: true,
					autoPlay: false,
					navigation : returnSliderNavigation,
					pagination: false,
					lazyLoad : true,
					items : itemsNum,
					itemsDesktop : [1000,deskitemsNum],
					itemsDesktopSmall : [900,desksmallitemsNum],
					itemsTablet: [600,tabletitemsNum],
					itemsMobile : false,
					transitionStyle : "goDown",
				});
			});
			$('.touch-slider').find('.owl-prev').html('<i class="fa fa-angle-left"></i>');
			$('.touch-slider').find('.owl-next').html('<i class="fa fa-angle-right"></i>');
			$('.touch-carousel, .testimonials-carousel').find('.owl-prev').html('<i class="fa fa-angle-left"></i>');
			$('.touch-carousel, .testimonials-carousel').find('.owl-next').html('<i class="fa fa-angle-right"></i>');
		}
	});
}

function loadAllClinic(){
	$.ajax({
		url:'cglobal/loadAllClinic/',
		dataType:'JSON',
		type:'POST',
		success:function(msg){
			var content = "";
			
			$.each(msg, function(i,e){
				content += '<div class="owl-item" style="width: 288px;"><div class="portfolio-item item">'+
						  '<div class="portfolio-border">'+
						  '<div class="portfolio-thumb">'+
						  '<a class="lightbox" title="" href="assets/images/'+e.clinic_logo+'">'+
						  '<div class="thumb-overlay"><i class="fa fa-arrows-alt"></i></div>'+
						  '<img alt="" src="assets/images/'+e.clinic_logo+'" />'+
						  '</a></div><div class="portfolio-details">'+
						  '<a href="#"><h4>'+e.clinic_name+'</h4><span>'+e.SPLocation+'</span><span>'+e.SPContactNo+'</span></span><span>'+e.SPEmail+'</span></a>'+
						  '</div></div></div></div>';
			});
			$('.recent-projects .owl-wrapper-outer').html(content);
		}
	});
}

function loadClinic(){

	$.ajax({
		url:'cglobal/loadClinics/',
		dataType:'JSON',
		type:'POST',
		success:function(msg){
			var content = "";
			$.each(msg, function(i,e){
	
				content += "<div class='portfolio-item item'>"+
			          "<img src='assets/images/"+e.clinic_logo+"' alt='' />"+
				          "<div class='portfolio-item-content'>"+
				            "<span class='header'>"+e.clinic_name+"</span>"+
				            "<p class='body'>Clinic "+e.SPLocation+"</p>"+
				          "</div>"+
				          "<a href='#' onclick = bookmark('"+e.clinic_id+"') data-toggle='tooltip' data-placement='top' title='Bookmark'><i class='more fa fa-bookmark' style = 'left:30% !important;height:50px !important;width:50px !important;line-height:49px !important;font-size:30px !important;'></i></button>"+
				          "<a href='#' onclick = enroll('"+e.UserID+"','"+e.clinic_id+"') data-toggle='tooltip' data-placement='top' title='Enroll' ><i class='more fa fa-sign-in' style = 'left:55% !important;height:50px !important;width:50px !important;line-height:49px !important;font-size:30px !important;'></i></a>"+
				          "<a href='#'  onclick = viewprofile('"+e.clinic_id+"','"+e.UserID+"')  data-toggle='tooltip' data-placement='top' title='More Info' ><i class='more fa fa-info' style = 'left:80% !important;height:50px !important;width:50px !important;line-height:49px !important;font-size:30px !important;'></i></a>"+
				        "</div><input type='hidden' class = 'form-control' id = 'clinicname"+e.clinic_id+"' value='"+e.clinic_name+"' />";

			});
			/*if(search != '' && search != 0){
				$('#clinic .classic-title').html("<b class = 'alert alert-info'>Found : "+msg.length+" clinic(s)...</b>");
			}*/
			$('#list-clinics').html(content);
		}
	});
	
}

function bookmark(clinicid){
	if($("#ses_userid").val() == ""){
		$("#message .alert").html("You cannot bookmark a clinic. You need to create an account first.").addClass('alert-danger').show();$("#message").addClass('zindex');
		setTimeout(function(){
			$("#message .alert").html("").removeClass('alert-danger').hide();$("#message").removeClass('zindex');
		},2000);
	}else{
		$.ajax({
			url:'clinics/bookmark',
			data:{clinicid:clinicid},
			dataType:'JSON',
			type:'POST',
			success:function(msg){
				if(msg == 1){
					$("#message .alert").html("Clinic was bookmarked already.").addClass('alert-success').show();$("#message").addClass('zindex');
				}else if(msg == 2 || msg == 3){
					$("#message .alert").html("Clinic has been successfully bookmarked.").addClass('alert-success').show();$("#message").addClass('zindex')
				}else{
					$("#message .alert").html("An error occurred during the procss. Please try again later or contact the administrator.").addClass('alert-danger').show();$("#message").addClass('zindex');
				}
				setTimeout(function(){
					$("#message .alert").html("").removeClass('alert-success').hide();$("#message").removeClass('zindex');
					$("#message .alert").html("").removeClass('alert-danger').hide();$("#message").removeClass('zindex');
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

function viewprofile(clinicid,userid){
	var sess = $("#ses_userid").val();
	if(sess == ''){
		$("#message .alert").html("You need to login.").addClass('alert-danger').show();$("#message").addClass('zindex');
		setTimeout(function(){
			$("#message .alert").html("").removeClass('alert-danger').hide();$("#message").removeClass('zindex');
		},3000);
	}else{
	 $('#loader').show();
	 window.location = "sp_profile?susid="+userid;
	}
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
		$("#message .alert").html("Service or schedule is missing.").addClass('alert-danger').show();$("#message").addClass('zindex');
		setTimeout(function(){
			$("#message .alert").html("").removeClass('alert-danger').hide();$("#message").removeClass('zindex');
		},2000);
	}else{
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
					$("#message .alert").html(nme+" has been enrolled successfully.").addClass('alert-success').show();$("#message").addClass('zindex');
					$("#stud_name").val("");$("#stud_age").val("");$("#stud_address").val("");
					setTimeout(function(){
						$("#message .alert").html("").removeClass('alert-success').hide();$("#message").removeClass('zindex');
						window.location = 'index';
					},2000);
				}else if(msg == 3){ //existing student in a clinic
				
					$("#message .alert").html($("#stud_name").val()+" student is already exist. Please select Student Type: Existing.").addClass('alert-danger').show();$("#message").addClass('zindex');
					$("#stud_name").val("");$("#stud_age").val("");$("#stud_address").val("");
				}else if(msg == 4){ //student already enrolled in schedule selected
					$("#message .alert").html(nme+" already enrolled in this schedule").addClass('alert-danger').show();$("#message").addClass('zindex');
				}else if(msg == 5){
					$("#message .alert").html("The service has reached its maximum capacity for the selected schedule. Please select other schedule if any.").addClass('alert-danger').show();$("#message").addClass('zindex');
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
	
}

function enroll(userid,clinic_id){
	if($("#ses_userid").val() == ""){
		$("#message .alert").html("You cannot enroll from this clinic. Need to create an account first.").addClass('alert-danger').show();$("#message").addClass('zindex');
		setTimeout(function(){
			$("#message .alert").html("").removeClass('alert-danger').hide();$("#message").removeClass('zindex');
		},2000);
	}else{
		var height = $(window).height();
		var dialogHeight = $("#modal_enroll").find('.modal-dialog').outerHeight(true);
		var top = parseInt(height)/6-parseInt(dialogHeight);
		$("#modal_enroll").modal('show').attr('style','top:'+top+'px !important;');
		
		//$("#service_id").val(serviceid);	
		$("#clinic_id").val(clinic_id);
		$.ajax({
			url:'cglobal/getService/'+userid,
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
		getRelationship();
	}
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


function getReviewsRatings(){
	$.ajax({
		url: 'reviews_and_ratings/getlist/'+4,
		dataType:'JSON',
		type:'POST',
		success:function(msg){
			var cnt = msg.length;
			var result = "";
			for(var ctr=0; ctr < cnt; ctr++){
				var star = "";
				for(var str = 0; str < msg[ctr].Rating ; str++){
					star += '<span class = "glyphicon glyphicon-star-empty"></span>';
				}
				
				result += '<div class="classic-testimonials item">'+
						'<div class="testimonial-content">'+
						'<p>'+msg[ctr].Message+'</p>'+
						'</div>'+
						'<div class="testimonial-author"><span>'+star+' '+msg[ctr].EnrolledName+'</span> - Customer of '+msg[ctr].SPname+'</div>'+
						'</div>';		
			}
			
			$("#reviews-ratings").html(result);
		}
	});
}

function testimonials(){ //for home page guest
	$.ajax({
		url: 'login/testimonials/',
		dataType:'JSON',
		type:'POST',
		success:function(msg){
			var cnt = msg.length;
			var result = "";
			$.each(msg, function(i,e){
				var star = "";
				for(var str = 0; str < msg[i].Rating ; str++){
					star += '<span class = "glyphicon glyphicon-star-empty"></span>';
				}
				
				result += '<div class="classic-testimonials item">'+
						'<div class="testimonial-content">'+
						'<p>'+msg[i].Message+'</p>'+
						'</div>'+
						'<div class="testimonial-author"><span>'+star+' '+msg[i].client+'</span> - Customer of '+msg[i].clinic+'</div>'+
						'</div>';
			});

			$("#testimonials").html(result).addClass('custom-carousel show-one-slide touch-carousel').attr('data-appeared-items',1);
			var $owl = $('#testimonials');
			$owl.trigger('destroy.owl.carousel');
			// After destory, the markup is still not the same with the initial.
			// The differences are:
			//   1. The initial content was wrapped by a 'div.owl-stage-outer';
			//   2. The '.owl-carousel' itself has an '.owl-loaded' class attached;
			//   We have to remove that before the new initialization.
			$owl.html($owl.find('.owl-stage-outer').html()).removeClass('owl-loaded');
			$owl.owlCarousel({
			    // your initial option here, again.
			    navigation : true,
				pagination: false,
				slideSpeed : 2500,
				stopOnHover: true,
		    	autoPlay: 3000,
		    	singleItem:true,
				autoHeight : true,
				transitionStyle : "fade"
			});
			$('.touch-slider').find('.owl-prev').html('<i class="fa fa-angle-left"></i>');
			$('.touch-slider').find('.owl-next').html('<i class="fa fa-angle-right"></i>');
			$('.touch-carousel, .testimonials-carousel').find('.owl-prev').html('<i class="fa fa-angle-left"></i>');
			$('.touch-carousel, .testimonials-carousel').find('.owl-next').html('<i class="fa fa-angle-right"></i>');
		}
	});
}

function getEventsPromos(){
	$.ajax({
		url:''
	});
}
function allclubs(){
	$.ajax({
		url: 'login/showallclubs',
		dataType:'JSON',
		success:function(msg){
			var content = "";

			$.each(msg, function(i,e){
				content += '<div class="portfolio-item item">'+
              '<div class="portfolio-border">'+
                '<div class="portfolio-thumb">'+
                  '<a class="lightbox" data-lightbox-type="ajax" href="#" onclick = "clickClub()">'+
                    '<div class="thumb-overlay"><i class="fa fa-arrows-alt"></i></div>'+
                    '<img alt="" src="assets/images/'+e.clinic_logo+'" />'+
                 ' </a>'+
                '</div>'+
                '<div class="portfolio-details">'+
                 ' <a href="#">'+
                    '<h4>'+e.clinic_name+'</h4>'+
                    '<span>'+e.SPLocation+'</span>'+
                  '</a>'+
                '</div>'+
              '</div>'+
            '</div>';
			});

			$("#allclinics").html(content).addClass('projects-carousel touch-carousel').attr('data-appeared-items',1);
			var $owl = $('#allclinics');
			$owl.trigger('destroy.owl.carousel');
			// After destory, the markup is still not the same with the initial.
			// The differences are:
			//   1. The initial content was wrapped by a 'div.owl-stage-outer';
			//   2. The '.owl-carousel' itself has an '.owl-loaded' class attached;
			//   We have to remove that before the new initialization.
			$owl.html($owl.find('.owl-stage-outer').html()).removeClass('owl-loaded');
			$owl.owlCarousel({
			    // your initial option here, again.
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
		}
	});
}

function clickClub(){
	if($("#huserid").val() == ""){
		$("#message .alert").html("You need to login.").addClass("alert-danger").show();$("#message").addClass('zindex');
		setTimeout(function(){
			$("#message .alert").html("").removeClass("alert-danger").hide();$("#message").removeClass('zindex');
		},3000);
	}
}