$(document).ready(function(){
	$("#btn-login").click(function(){
		var loginData = $("#loginForm").serializeArray();
		var ph = [];
		$.each(loginData,function(i,e){
			if(e.value == ''){
				$("#"+e.name).parent().parent().addClass('has-error');// addclass to its parent div with class form-group for empty textboxes
			}else{
				$("#"+e.name).parent().parent().removeClass('has-error');
			}
		});
		var count = $(".has-error").length; //coutn how many textboxes is in red border or empty
		if(count > 0){
			$(".switcher-box span#error").attr('title',"<div style = 'color:red'>Please enter your username/password</div>").popover({
				html:true
			}).popover('show');
			setTimeout(function(){
				$(".switcher-box span#error").popover('hide');
				$("#loginForm input").parent().parent().removeClass('has-error');
			},2000);
			
		}else{
			$.ajax({
				url:'login/authenticate',
				data:{pwd:$("#password").val(),uname:$("#username").val()},
				dataType:'JSON',
				type:'POST',
				success:function(msg){
					if(msg == 0){
						console.log(msg);
						$(".switcher-box span#error").attr('title',"<div style = 'color:red'>Username does not exist.</div>").popover({
							html:true
						}).popover('show');
						setTimeout(function(){
							$(".switcher-box span#error").popover('hide');
							$("#loginForm input").parent().parent().removeClass('has-error');
						},2000);
					}else if(msg == 1){
						window.location = "index";
					}else{
						$(".switcher-box span#error").attr('title',"<div style = 'color:red'>Incorrect password.</div>").popover({
							html:true
						}).popover('show');
						setTimeout(function(){
							$(".switcher-box span#error").popover('hide');
							$("#loginForm input").parent().parent().removeClass('has-error');
						},2000);
					}

				}
			});
		}
	});

	$("#btn-logout").click(function(){
		logout();
	});
});


function logout(){
	$.ajax({
		url:'login/logout',
		dataType:'json',
		type: 'POST',
		success:function(msg){
			window.location = "index";
		}
	});
}