$(document).ready(function(){
	$("#btn-saveQ").click(function(){
		btnSave();
	});

	$("#btn-saveInterest").click(function(){
		btnAddInterest();
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

function btnAddInterest(){
	var i = $("#interest").val();
	if(i != '') saveInterest(i);
	else alert("Please enter interest name.");
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


function saveInterest(q){
	var type = $('#interest_type').val();
	$.ajax({
			url: 'cglobal/addInterest',
			dataType:'JSON',
			type:'POST',
			data:{interest:q, type:type},
			success:function(msg){
				if(msg == 1){
					alert("Successfully added.");
				}else{
					alert("Can't save. Please check query.");
				}
		}
	});	
}