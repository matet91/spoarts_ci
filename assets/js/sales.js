$(document).ready(function() {
	$(".chzn-select").chosen();
	var height = $(window).height();
	//get_payments();
	
	var min = 2016,
	curyear = new Date().getFullYear(),
    max = curyear + 9,
    select = document.getElementById('year');

	for (var i = min; i<=max; i++){
		var opt = document.createElement('option');
		opt.value = i;
		opt.innerHTML = i;
		select.appendChild(opt);
	}
	getService();
	get_payments();
} );

function repchange(reptype){
	//var reptype = $(this).val();
	if(reptype == 0){
		$("#date").hide();
	}else if(reptype==1){
		$("#date").show();$("#div-year").show();$("#div-month").show();
	}else if(reptype==2){
		$("#date").show();$("#div-month").hide();$("#div-year").show();
	}
	reloadtable();
}

function getService(){
	$.ajax({
		url:'sales/getService/',
		dataType:'JSON',
		type:'POST',
		success:function(msg){ 
			var result = "<option value='0'>Select Service</option>";
			$("#service_id").html("");
			$.each(msg, function(i,e){	
				result += '<option value='+e.ServiceID+'>'+e.ServiceName+'</option>';		
			});
			$('#service_id').html(result).trigger("chosen:updated");
		}
	});
}

function changeservice(serviceid){
	$.ajax({
		url:'sales/getSchedule/'+serviceid,
		dataType:'JSON',
		type:'POST',
		success:function(msg){ 
			var result = "<option value='0'>Select Service</option>";
			$("#schedule_id").html("");
			$.each(msg, function(i,e){	
				result += '<option value='+e.SchedID+'>'+e.Sched+'</option>';		
			});
			$('#schedule_id').html(result).trigger("chosen:updated");
		}
	});
}

function get_payments(){
	var user_type = $("#user_type").val();
	var rep_type = $("#report_type").val();
	var rep_date = "0";
	if(rep_type == 1){
		rep_date = $("#month").val()+" "+$("#year").val();
	}else if(rep_type == 2){
		rep_date = $("#year").val();
	}
	
	if($("#user_type").val()== 1){
		var schedule_id = $("#schedule_id").val();
		var service_id = $("#service_id").val();
		if (!service_id){service_id="0";}
		if(!schedule_id){schedule_id="0";}
	}else{
		var schedule_id = 0;
		var service_id = 0;
	}
	if(user_type == 1){
		$("#mypayment_list").append('<tfoot><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th></tfoot>');
		$('#mypayment_list').DataTable( {
		"bProcessing":true, 
		"bServerSide":true,
		"bRetrieve": true,
		"bDestroy":true,
		"sAjaxSource": "sales/dataTables/"+user_type+"/"+rep_type+"/"+rep_date+"/"+service_id+"/"+schedule_id,
		"aoColumns":[	
			{"sTitle":"ID","bVisible":false},
			{"sTitle":"Date","bSearchable": true},
			{"sTitle":"Amount","bSearchable": true},
			{"sTitle":"Balance","bSearchable": true},
			{"sTitle":"Description","bSearchable": true},
			{"sTitle":"Student","bSearchable": true},
			{"sTitle":"Clinic","bSearchable": true},
			{"sTitle":"Service","bSearchable": true},
			{"sTitle":"Schedule","bSearchable": true},
			{"sTitle":"Type","bSearchable": true}
						
		],
		"fnInitComplete": function(oSettings, json) {
		},
		"fnFooterCallback": function ( row, data, start, end, display ) {
			 var api = this.api(), data;
			 var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
			total = api
                .column( 2 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
			
			pageTotal = api
                .column( 2, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
			$( api.column( 2 ).footer() ).html(
                'Php'+pageTotal +' ( Php'+ total +' total)'
            );
		 }
	  }).on('processing.dt',function(oEvent, settings, processing){
	  });
	}else{
		$("#mypayment_list").append('<tfoot><th></th><th></th><th></th><th></th><th></th><th></th><th></th></tfoot>');
		$('#mypayment_list').DataTable( {
		"bProcessing":true, 
		"bServerSide":true,
		"bRetrieve": true,
		"bDestroy":true,
		"sAjaxSource": "sales/dataTables/"+user_type+"/"+rep_type+"/"+rep_date+"/"+service_id+"/"+schedule_id,
		"aoColumns":[	
					{"sTitle":"ID","bVisible":false},
					{"sTitle":"Date","bSearchable": true},
					{"sTitle":"Name","bSearchable": true},
					{"sTitle":"Clinic","bSearchable": true},
					{"sTitle":"Amount","bSearchable": true},
					{"sTitle":"Invoice","bSearchable": true},
					{"sTitle":"Transaction ID","bSearchable": true}
						
		],
		"fnInitComplete": function(oSettings, json) {
		},
		"fnFooterCallback": function ( row, data, start, end, display ) {
			 var api = this.api(), data;
			 var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
			total = api
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
			
			pageTotal = api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
			$( api.column( 4 ).footer() ).html(
                'Php'+pageTotal +' ( Php'+ total +' total)'
            );
		 }
	  }).on('processing.dt',function(oEvent, settings, processing){
	  });

	}

  
}

function reloadtable(){
	var user_type = $("#user_type").val();
	var rep_type = $("#report_type").val();
	var rep_date = "0";
	if(rep_type == 1){
		rep_date = $("#month").val()+" "+$("#year").val();
	}else if(rep_type == 2){
		rep_date = $("#year").val();
	}
	if($("#user_type").val()== 1){
		var schedule_id = $("#schedule_id").val();
		var service_id = $("#service_id").val();
		if (!service_id){service_id="0";}
		if(!schedule_id){schedule_id="0";}
	}else{
		var schedule_id = 0;
		var service_id = 0;
	}
	var table = $('#mypayment_list').DataTable();
	table.ajax.url("sales/dataTables/"+user_type+"/"+rep_type+"/"+rep_date+"/"+service_id+"/"+schedule_id).load();
}