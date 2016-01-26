$(document).ready(function(){
	var height = $(window).height();
	

	$("#btn-update-profile").click(function(){
		var dialogHeight = $("#modal_profile").find('.modal-dialog').outerHeight(true);
    	var top = parseInt(height)/5-parseInt(dialogHeight);
		$('#modal_profile').modal('show').attr('style','top:'+top+'px !important');
	});

	$('[data-toggle="tooltip"]').tooltip();
});