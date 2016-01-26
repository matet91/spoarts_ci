$(document).ready(function(){
	 var height = $(window).height();
	var table = $('#example,#example7,#example8,#example9').DataTable({
          
      "pagingType": "simple",
      "info":false,
      "searching":false,
      "sDom": '<"top">rt<"bottom"flp><"clear">'
    });

   $('.btn-sm').click(function(e){
	    e.preventDefault();
	    var dialogHeight = $("#modal_securitypwd").find('.modal-dialog').outerHeight(true);
	    var top = parseInt(height)/3-parseInt(dialogHeight);
      $("#modal_securitypwd").modal('show').attr('style','top:'+top+'px !important');
  });
	$(".btn-viewlist").click(function(){
		  var dialogHeight = $("#modal_viewlist").find('.modal-dialog').outerHeight(true);
		  var top = parseInt(height)/7-parseInt(dialogHeight);
	    $("#modal_viewlist").modal('show').attr('style','top:'+top+'px !important;');
	});

  $(".btn-attendance").click(function (){
      $('#studentattendancelog').show('slide');
      $("#studentsInstructor_tab").hide('slide');
  });
  $("#btn-backtotab").click(function(){
      $('#studentattendancelog').hide('slide');
      $("#studentsInstructor_tab").show('slide');
  });
});