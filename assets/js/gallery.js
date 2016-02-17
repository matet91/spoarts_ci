$(document).ready(function(){
	$("#new_album").click(function(){

		$("#modal_album").modal('show');
	});

	$("#browserpic").click(function(e){
		e.preventDefault();
		var sel = $('#albumlist').val();
		if(sel == '0'){
			$("#modal_album").modal('show');
		}else{
			if(sel == ''){
				$('#message .alert').html("Please select an album first").addClass("alert-danger").show();
				setTimeout(function(){
					$('#message .alert').html("").removeClass("alert-danger").hide();
				},2000);
			}else {
				renderFileUpload();
				$("#fileupload").click();
			}
		}
	});
	albumlist();
	albumDisplay();
	$("#btn-saveAlbum").click(function(){
		createAlbum();
	});
	
	
});

function albumlist(){
	$.ajax({
		url:'gallery/albumlist',
		dataType:'JSON',
		success:function(msg){
	
			if(msg != ""){
				$("#browserpic").html("Add Pictures");
				var opt = "<option value = ''>Please select an Album</option>"+
							"<option value = '0'>Create New Album</option>";
				$.each(msg, function(i,e){
					opt += "<option value='"+e.albumID+"'>"+e.albumName+"</option>";
				});
			}else{
				$("#browserpic").html("Create Album");
				var opt = "<option value = '0'>Create New Album</option>";
			}

			$("#albumlist").html(opt).trigger('chosen:updated');
		}
	});
}

function albumDisplay(){
	$.ajax({
		url:'gallery/albumDisplay',
		dataType:'JSON',
		success:function(msg){
			var content = "";
			$.each(msg,function(i,e){
				var filename = e.albumName+"_"+e.UserID+"/"+e.fileName;
				if(e.fileName == null) filename = "face_2.png"
				content += "<div class='portfolio-item item'>"+
							"<div class='portfolio-border'>"+
							"<div class='portfolio-thumb'>"+
							"<a class='lightbox' title='This is an image title' href='#' onclick='viewAlbum("+e.albumID+",'"+e.albumName+"')'>"+
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

function createAlbum(){
	var frm = $("#frm-album").serializeArray(),data={};
	$.each(frm, function(i,e){
		if(e.value == ''){
			$("#"+e.name).parent().addClass('has-error');
		}else{
			$("#"+e.name).parent().removeClass('has-error');
			data[e.name] = e.value;
		}
	});

	var len = $("#frm-album .has-error").length;
	if(len > 0){
		$("#message .alert").html("All fields are required.").addClass("alert-danger").show();
		setTimeout(function(){
			$("#message .alert").html("").removeClass("alert-danger").hide();
		},2000);
	}else{
		saveAlbum(data);
	}
}

function saveAlbum(data){
	$.ajax({
		url: 'gallery/createAlbum',
		data:{data:data},
		dataType:'JSON',
		type:'POST',
		success:function(msg){
			if(msg == true){
				$('#message .alert').html("New album has been created. You can now add pictures.").addClass('alert-success').show();

				setTimeout(function(){
					$('#message .alert').html("").removeClass('alert-success').hide();
					$("#modal_album").modal('hide');
					$("#albumName").val('');
					$("#albumDesc").val('');
					albumDisplay();
				},2000);
			}else if(msg == 1){
				$('#message .alert').html("Album already exist.").addClass('alert-danger').show();
				setTimeout(function(){
					$('#message .alert').html("").removeClass('alert-danger').hide();
					$("#albumName").val('');
					$("#albumDesc").val('');
				},2000);
			}else{
				$('#message .alert').html("Unable to create album.").addClass('alert-danger').show();
				setTimeout(function(){
					$('#message .alert').html("").removeClass('alert-danger').hide();
					$("#modal_album").modal('hide');
					$("#albumName").val('');
					$("#albumDesc").val('');
				},2000);
			}
			albumlist();
		}
	});
}

function renderFileUpload(){
	var count = 0,ctr = 0;
	'use strict';
    // Change this to the location of your server-side upload handler:

        $('#fileupload').fileupload({
        url: 'gallery/uploadPictures/'+$('#albumlist').val(),
        dataType: 'json',
        autoUpload: true,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        maxFileSize: 999000,
        // Enable image resizing, except for Android and Opera,
        // which actually support image resizing, but fail to
        // send Blob objects via XHR requests:
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewMaxWidth: 100,
        previewMaxHeight: 100,
        previewCrop: true
    }).on('fileuploadadd', function (e, data) {

        data.context = $('<div/>').addClass('col-md-4').appendTo('#files');
        $.each(data.files, function (index, file) {
            var node = $('<p/>')
                    .append($('<span/>').text(file.name));
            if (!index) {
                node
                    .append('<br>');
            }
            node.appendTo(data.context);

        });
        count++;

    }).on('fileuploadprocessalways', function (e, data) {
        var index = data.index,
            file = data.files[index],
            node = $(data.context.children()[index]);
        if (file.preview) {
            node
                .prepend('<br>')
                .prepend(file.preview);
        }
        if (file.error) {
            node
                .append('<br>')
                .append($('<span class="text-danger"/>').text(file.error));
        }
        if (index + 1 === data.files.length) {
            data.context.find('button')
                .text('Upload')
                .prop('disabled', !!data.files.error);
        }
    }).on('fileuploadprogressall', function (e, data) {
    	$("#browserpic").html("Processing...").attr('disabled','disabled');
        var progress = parseInt(data.loaded / data.total * 100, 10);
        $('#progress .progress-bar').css(
            'width',
            progress + '%'
        );
    }).on('fileuploaddone', function (e, data) {

        $.each(data.files, function (index, file) {

            if (data.result == 1) {
                var error = $('<span class="text-success"/>').text("Uploaded.");
                $(data.context.children()[index])
                    .append('<br>')
                    .append(error);
            } else{
                var error = $('<span class="text-danger"/>').text("Failed");
                $(data.context.children()[index])
                    .append('<br>')
                    .append(error);
            }
        });
        ctr++;
        if(ctr == count){
	       	 $("#message .alert").html("All pictures were successfully added to Album "+$("#albumlist option[value='"+$('#albumlist').val()+"']").text()+". Page will reload after 3 seconds.").addClass('alert-success').show();
	       	 $("#browserpic").html("Add Pictures").removeAttr('disabled');

	       	 setTimeout(function(){
	       	 	$("#message .alert").html("").removeClass('alert-success').hide();
	       	 	window.location = 'gallery';
	       	 },3000);
       	}

    }).on('fileuploadfail', function (e, data) {
        $.each(data.files, function (index) {
            var error = $('<span class="text-danger"/>').text('File upload failed.');
            $(data.context.children()[index])
                .append('<br>')
                .append(error);
        });
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
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
				content += '<div class="portfolio-item item">'+
                '<div class="portfolio-border">'+                  
                '<div class="portfolio-thumb">'+
                    '<a class="lightbox" title="'+e.filename+'" href="assets/images/'+e.albumName+"/"+e.fileName+'">'+
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
              '</div>';
			});
			var $owl = $('#gallerydisplay');

			$owl.trigger('replace.owl.carousel');

			$("#gallerydisplay").focus().html(content).show('slide');
			$("#gallerydisplay").owlCarousel({
				navigation : true,
				pagination: false,
				slideSpeed : 400,
				stopOnHover: true,
		    	autoPlay: false,
		    	items : 4,
		    	itemsDesktopSmall : [900,3],
				itemsTablet: [600,2],
				itemsMobile : [479, 1]
			});
			$('.touch-slider').find('.owl-prev').html('<i class="fa fa-angle-left"></i>');
			$('.touch-slider').find('.owl-next').html('<i class="fa fa-angle-right"></i>');
			$('.touch-carousel, .testimonials-carousel').find('.owl-prev').html('<i class="fa fa-angle-left"></i>');
			$('.touch-carousel, .testimonials-carousel').find('.owl-next').html('<i class="fa fa-angle-right"></i>');
			$('.lightbox').nivoLightbox({
				effect: 'fadeScale',
				keyboardNav: true,
				errorMessage: 'The requested content cannot be loaded. Please try again later.'
			});
			$("#gallery_list .title").html("<span>"+title+"</span>");
		}
	});
}
