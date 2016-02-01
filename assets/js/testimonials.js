$(document).ready(function(){
	 var height = $(window).height();
    $(".btn-viewlist").click(function(){
      var dialogHeight = $("#modal_viewlist").find('.modal-dialog').outerHeight(true);
      var top = parseInt(height)/7-parseInt(dialogHeight);
        $("#modal_viewlist").modal('show').attr('style','top:'+top+'px !important');
    });
});