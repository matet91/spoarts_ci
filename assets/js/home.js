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

}

function getServiceProviders(){
	$.ajax({
		url:'index/getServiceProviders',
		dataType:'JSON',
		success:function(msg){
			$.each(msg,function(i,e){

			});
		}
	});
}