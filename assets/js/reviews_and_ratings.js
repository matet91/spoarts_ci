$(document).ready(function(){
	var height = $(window).height();
    $(".btn-viewlist").click(function(){
      var dialogHeight = $("#modal_viewlist").find('.modal-dialog').outerHeight(true);
      var top = parseInt(height)/7-parseInt(dialogHeight);
        $("#modal_viewlist").modal('show').attr('style','top:'+top+'px !important');
    });
	getReviewList(0); //pending list
	getReviewList(1); //disapproved list
	getReviewList(2); //approved list
});

function getReviewList(typelist){
	$.ajax({
		url: 'reviews_and_ratings/getlist/'+typelist,
		dataType:'JSON',
		type:'POST',
		success:function(msg){
			var result = "";
			$.each(msg, function(i,e){
				var star = "";
				for(var str = 0; str < e.Rating ; str++){
					star += '<span class = "glyphicon glyphicon-star-empty"></span>';
				}
				
				var listbutton = "";
				if(typelist == 0){
					listbutton = '<button class = "btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Remove" onclick="reviewaction(4,'+e.ReviewsID+')"><span class = "glyphicon glyphicon-trash"></span></button>&nbsp;'+
					'<button class = "btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" title="Approve" onclick="reviewaction(2,'+e.ReviewsID+')"><span class = "glyphicon glyphicon-ok"></span></button>&nbsp;'+
					'<button class = "btn btn-warning btn-xs" data-toggle="tooltip" data-placement="top" title="Disapprove" onclick="reviewaction(1,'+e.ReviewsID+')"><span class = "glyphicon glyphicon-remove"></span></button>';
				}else if(typelist == 1){
					listbutton = '<button class = "btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Remove" onclick="reviewaction(4,'+e.ReviewsID+')"><span class = "glyphicon glyphicon-trash"></span></button>&nbsp;'+
					'<button class = "btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" title="Approve" onclick="reviewaction(2,'+e.ReviewsID+')"><span class = "glyphicon glyphicon-ok"></span></button>';
				}else{
					listbutton = '<button class = "btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Remove" onclick="reviewaction(4,'+e.ReviewsID+')"><span class = "glyphicon glyphicon-trash"></span></button>';	
				}
				
				result += '<div class="col-md-6">'+
					'<div class="classic-testimonials">'+
						'<div class = "row" style = "float:right">'+
							listbutton+
						'</div>'+
						'<div class="hr5" style="margin-top:45px;margin-bottom:45px;"></div>'+
						'<div class="testimonial-content">'+
							'<p>'+e.Message+'</p>'+
						'</div>'
						+star+
						'<div class="testimonial-author"><span>'+e.EnrolledName+'</span> - Clients of '+e.SPname+'</div>'+
					'</div>'+
				'</div>';
				
				if((ctr % 2) == 0 && ctr < (cnt-1)){
					result = '<div class="row">' + result ;
					//first
				}else if((ctr % 2) == 1 && ctr < (cnt-1)){
					result = result + '</div>';
					//second
				}else if((ctr % 2) == 0 &&  ctr == (cnt-1)){
					result = '<div class="row">' + result + '</div>';
				}
			});
			
			if(typelist == 0){
				$("#tab-pending").html(result);
			}else if(typelist == 1){
				$("#tab-disapproved").html(result);
			}else{
				$("#tab-approved").html(result);
			}
			
			
		}
	});
}

function reviewaction(stat,reviewsid){
	$.ajax({
		url:'reviews_and_ratings/saveReviewRatings/',
		dataType:'JSON',
		type:'POST',
		data:{stat:stat,reviewsid:reviewsid},
		success:function(msg){
			if(msg == 1){
				$("#message .alert").html("Changes saved. Page will reload after 3 seconds").addClass('alert-success').show();
				setTimeout(function(){
					$("#message .alert").html("").removeClass('alert-success').hide();
					window.location = 'reviews_and_ratings';
				},3000);
			}else{
				$("#message .alert").html("Can't save right now. Please try again later or contact the WebDev Support Team.").addClass('alert-danger').show();
				$("#modal_security .alert").html("Can't save right now. Please try again later or contact the WebDev Support Team.");
				setTimeout(function(){
				 $("#message .alert").html("").removeClass('alert-danger').hide();
				},4000);
			}
		}
	});
	
}