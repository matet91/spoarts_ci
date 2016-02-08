$(document).ready(function(){
	getReviewsRatings();
});

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

function getEventsPromos(){
	
}