$(document).ready(function(){
	$("#btn-saveQ").click(function(){
		btnSave();
	});
});

function btnSave(){
	var q = $("#questions").val();
	if(q!=''){
		saveQuestions(q);
	}else{
		alert("Please enter a security question.");
	}
}

function saveQuestions(q){
	$.ajax({
		url: 'cglobal/addQuestion',
		dataType:'JSON',
		type:'POST',
		data:{quest:q},
		success:function(msg){
			if(msg == 1){
				alert("Successfully added.");
			}else{
				alert("Can't save. Please check query.");
			}
		}
	});	
}