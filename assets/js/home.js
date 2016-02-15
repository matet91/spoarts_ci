$(document).ready(function(){
	getReviewsRatings();
	testimonials();
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
			
		}
	});
}

function getEventsPromos(){
	
}