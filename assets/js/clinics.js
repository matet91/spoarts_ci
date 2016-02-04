$(document).ready(function(){
	var clinictype = $('#clinic_type').val();
	loadServices(clinictype,0);
	$('#searchClinic').keypress(function(){

		var clinictype = $('#clinic_type').val();
		if($(this).val()!=''){
			$('#clinic classic-title').html("Searching... "+$(this).val());
			loadServices(clinictype,$(this).val());
		}
	});
});

function loadServices(c,search){

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
}

function bookmark(serviceid,clinicid){
	$.ajax({
		url:'clinics/bookmark',
		data:{serviceid:serviceid,clinicid:clinicid},
		dataType:'JSON',
		type:'POST',
		success:function(msg){
			
		}
	});
}