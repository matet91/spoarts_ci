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
                {"sTitle":"Schedule","bSearchable": true},
                {"sTitle":"Registration Fee (Peso)","bSearchable": true},
                {"sTitle":"Walk-in Fee/Session (Peso)","bSearchable": true},
                {"sTitle":"# of Hours Per Session","bSearchable": true},
                {"sTitle":"Monthly Fee (Peso)","bSearchable": true},
                {"sTitle":"Type","bSearchable": true},
                {"sTitle":"Actions",'bVisible':false}
        ],
        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
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
                $(element).html('<button class="btn btn-primary btn-sm" id="btn-editEvent" data-toggle="tooltip" data-placement="top" title="Edit '+event.title+'" onclick="editEvent('+event.id+')"><span class = "glyphicon glyphicon-pencil"></span></button><button class = "btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Remove '+event.title+'" onclick="removeEvent('+event.id+')"><span class = "glyphicon glyphicon-trash"></span></button> &nbsp;' + event.title); 
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

