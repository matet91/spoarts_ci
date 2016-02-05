$(document).ready(function(){
	 var height = $(window).height();
   services();
	var table = $('#example,#example7,#example8,#example9').DataTable({
          
      "pagingType": "simple",
      "info":false,
      "searching":false,
      "sDom": '<"top">rt<"bottom"flp><"clear">'
    });

   $('#btn-addService').click(function(e){
	    e.preventDefault();
      var dialogHeight = $("#modal_viewlist").find('.modal-dialog').outerHeight(true);
      var top = parseInt(height)/5-parseInt(dialogHeight);
      $("#modal_addservices").modal('show').attr('style','top:'+top+'px !important;');
  });
	

  $(".btn-attendance").click(function (){
      $('#studentattendancelog').show('slide');
      $("#studentsInstructor_tab").hide('slide');
  });
  $("#btn-backtotab").click(function(){
      $('#studentattendancelog').hide('slide');
      $("#studentsInstructor_tab").show('slide');
  });

  getservices();

  $("#clubimage").click(function(){
    $("#clubpic").click();
  });
  uploadClubpic();

  //save service details to database
  $("#btn-saveServices").click(function(){
   var data = validateServiceForm();
    saveService(data);
  });

  $("#clubimage").popover('show');
  //hide after 6 seconds.
  setTimeout(function(){
    $("#clubimage").popover('hide');   
  },6000);
  $("#content-services #btn-update").click(function(){
    $("#action_type").val(1);
      checkClinicFields();
     
  });

//validate inputted security password before saving the data
  $("#modal_security #btn-continue").click(function(){
      var pwd = $("#modal_security #sec_pwd");

      if(pwd.val() == ''){
        pwd.parent().addClass('has-error');
        $("#modal_security .alert").html("Please enter the password of your security question.").addClass('alert-danger').show();

        setTimeout(function(){
          pwd.parent().removeClass('has-error');
          $("#modal_security .alert").html("").removeClass('alert-danger').hide();
        },3000);
      }else{
        pwd.parent().removeClass('has-error');
        $("#modal_security .alert").html("").removeClass("alert-danger").hide();
        var t = $('#action_type').val();
        checkSecurityPwd(pwd.val(),t);
      }
  });


  //validate text fields
  $("#btn-addInstructor").click(function(){
    var frmdata = $("#formaddinstructor").serializeArray(),data={};
    $.each(frmdata, function (i,e){
      var name = $("#"+e.name);
      if(e.value == ''){
        name.parent().addClass('has-error');
      }else{
        name.parent().removeClass('has-error');
        data[e.name] = e.value;
      }
    });

    var count = $("#formaddinstructor .has-error").length;
    if(count > 0){
      $("#instructor-tab .alert").html("All fields are required.").addClass('alert-danger').show();
    }else{
      $('#instructor-tab .alert').html('').removeClass('alert-danger').hide();
        addInstructor(data);
      }
  });
});

function getservices(){
  $('#tbl-services').DataTable( {
    "bProcessing":true, 
    "bServerSide":true,
    "bRetrieve": true,
    "bDestroy":true,
    "sLimit":10,  
    "sAjaxSource": "service_provider/dataTables/1",
    "aoColumns":[ {"sTitle":"ID","bVisible":false},
            {"sTitle":"Services"},
            {"sTitle":"Description","bSearchable": true},
            {"sTitle":"Schedule","bSearchable": true},
            {"sTitle":"Registration Fee (Peso)","bSearchable": true},
            {"sTitle":"Walk-in Fee/Session (Peso)","bSearchable": true},
            {"sTitle":"# of Hours Per Session","bSearchable": true},
            {"sTitle":"Monthly Fee (Peso)","bSearchable": true},
            {"sTitle":"Type","bSearchable": true},
            {"sTitle":"Actions"}
    ],
    "fnRowCallback": function( nRow, aData, iDisplayIndex ) {

      if ( aData[9] == 1 ){
        $('td:eq(8)', nRow).html('<button class = "btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" title="View Students and Instructors" onclick="view_studentinstructor('+aData[0]+');"><i class = "fa fa-list fa-fw"></i></button>&nbsp;<button class = "btn btn-info btn-xs btn-viewlist" data-toggle="tooltip" data-placement="top" title="Update Service" onclick="editServices('+aData[0]+');"><i class = "fa fa-edit fa-fw"></i></button>&nbsp;<button class = "btn btn-danger btn-xs btn-viewlist" data-toggle="tooltip" data-placement="top" title="Remove Service" onclick="removeService('+aData[0]+',1);"><i class = "fa fa-remove fa-fw"></i></button>' );
      }

    },
    "fnInitComplete": function(oSettings, json) {
    }
  }).on('processing.dt',function(oEvent, settings, processing){
  });


}

function validateServiceForm(){
  //validate form
  var dataForm = $("#formaddservice").serializeArray();
  var data = {};
  
  $("#modal_addservices .alert").html("");
  $.each(dataForm,function(i,e){
      var name = $("#"+e.name);
      if(e.value == ""){
        name.parent().addClass("has-error");
      }else{
        if(e.name == 'ServiceRegistrationFee' || e.name=="serviceWalkin" || e.name == 'ServicePrice' || e.name=="serviceHour"){
            if($.isNumeric(e.value)){
              name.parent().removeClass('has-error');
              data[e.name] = e.value;
             
            }else{
              $("#modal_addservices .alert").html(name.prev().html()+" should be numeric.");
              name.parent().addClass("has-error");
            }
        }else{
          name.parent().removeClass('has-error');
          data[e.name] = e.value;
        }
      }
  });
  return data;

}
function saveService(data){
   var txtHiddenService = $('#txtHiddenService').val();

if(txtHiddenService == 1){ 
  var url = "services/addServices";
  var errorMsg = $("#ServiceName").val()+" Service has been added successfully.";
}else{ 
  var url = "services/updateServices/"+txtHiddenService;
  var errorMsg = $("#ServiceName").val()+" Service info has been updated successfully";
}
//get how many div is using 'has-error' class
var error = $("#formaddservice .has-error").length;
  if(error > 0){
    $("#modal_addservices .alert").append("All fields are required.").addClass('alert-danger').show();
  }else{
    $("#modal_addservices .alert").html("").removeClass('alert-danger').hide();
    $.ajax({
      url:url,
      data:{data},
      dataType:'JSON',
      type:'POST',
      success:function(msg){
        var table = $("#tbl-services").DataTable(), dataForm = $("#formaddservice").serializeArray(); 
        if(msg == true){

            $("#modal_addservices .alert").html(errorMsg).addClass("alert-success").show();

            $.each(dataForm, function(i,e){
              $("#"+e.name).val("");
            });
            setTimeout(function(){
              $("#modal_addservices .alert").html("").removeClass("alert-success").hide();
              $("#modal_addservices").modal('hide');
            },3000);

             table.ajax.reload();
             $('#txtHiddenService').val(1);
        }else{
          $("#modal_addservices .alert").html("An error occurred during the process. Please try again later or contact the administrator.").addClass("alert-success").show();
        }
      }
    });
  }
}

function uploadClubpic(){
  $('#clubpic').change( function(e) {
    var file = this.files[0];
    var fd = new FormData();
    fd.append("clubpic", file);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'services/uploadClubPic', true);
    
    xhr.upload.onprogress = function(e) {
      if (e.lengthComputable) {
        var percentComplete = (e.loaded / e.total) * 100;
        $('#loader').show();
      }
    };
    xhr.onreadystatechange = function() {
        if (this.readyState === 4) {
            if (this.status === 200) {
                $("#clubimage").attr('src',"assets/images/"+xhr.responseText);
                $('#loader').fadeOut();
            }
        }
    };
    xhr.send(fd);
  });
}

function checkClinicFields(){
  var frmClinic = $("#form-clinic").serializeArray(),data={};
  $.each(frmClinic, function(i,e){
      var name = $("#content-services #"+e.name);
      if(e.value == ''){
          name.parent().addClass('has-error');
      }else{
        name.parent().removeClass('has-error');
      }
  });

  var count = $("#content-services .has-error").length;

  if(count > 0){
    $("#content-services  .alert").html("All fields are required.").addClass('alert-danger').show();
  }else{
      var height = $(window).height();
      var dialogHeight = $("#modal_security").find('.modal-dialog').outerHeight(true);
      var top = parseInt(height)/5-parseInt(dialogHeight);
      $("#modal_security").modal('show');
      $("#modal_security .modal-dialog").attr('style','margin-top:'+top+'px !important;');

     $("#content-services  .alert").html("").removeClass('alert-danger').hide();
      $("#modal_security").modal('show').attr('style','top:'+top+'px !important;');
  }
}

function saveClinicInfo(){
  var frmdata = $("#content-services #form-clinic").serializeArray(),data={};
  $.each(frmdata,function(i,e){
    data[e.name] = e.value;
  });

  $.ajax({
    url:'services/saveClinicInfo',
    data:{data:data},
    dataType:'json',
    type:'POST',
    success:function(msg){
      if(msg == 1){
        $("#modal_security .alert").html("").hide();
        $("#modal_security").modal('hide');
        $("#message .alert").html("Changes saved. Page will reload after 3 seconds").removeClass("alert-danger").addClass("alert-success").show();
        setTimeout(function(){
          window.location = 'services';
        },3000);
      }else{
        $("#modal_security .alert").html("Can't save right now. Please try again later or contact the WebDev Support Team.");
        setTimeout(function(){
          $("#modal_security").modal('hide');
          $('modal_security .alert').html("").hide();
        },4000);
      }
    }
  })
}

function view_studentinstructor(id){
  instructorList(id);
  var height = $(window).height();
  var dialogHeight = $("#modal_viewlist").find('.modal-dialog').outerHeight(true);
  var top = parseInt(height)/7-parseInt(dialogHeight);
  $("#modal_viewlist").modal('show').attr('style','top:'+top+'px !important;');
  
}

function instructorList(id){

  var table = $('#tbl-instructor').DataTable( {
    "bProcessing":true, 
    "bServerSide":true,
    "bRetrieve": true,
    "bDestroy":true,
    "sLimit":10,
    "sAjaxSource": "services/dataTables/2/"+id,
    "aoColumns":[ {"sTitle":"ID","sName":"ins_id","bVisible":false},
            {"sTitle":"Name","sName":"ins_name"},
            {"sTitle":"Schedule","sName":"ins_schedule","bSearchable": true},
            {"sTitle":"Room","sName":"ins_room","bSearchable": true},
            {"sTitle":"Slot","sName":"ins_slot","bSearchable": true},
            {"sTitle":"Status","sName":"ins_status","bSearchable": true},
            {"sTitle":"Actions","sName":"action"}
    ],
    "fnRowCallback": function( nRow, aData, iDisplayIndex ) {

      if ( aData[6] == 1 ){
        $('td:eq(5)', nRow).html('<button class = "btn btn-primary btn-xs btn-viewlist" data-toggle="tooltip" data-placement="top" title="View Students and Instructors" id="view_studinstruct" onclick="updateInstructor('+aData[0]+');"><i class = "fa fa-edit fa-fw"></i></button>&nbsp;<button class = "btn btn-danger btn-xs btn-viewlist" data-toggle="tooltip" data-placement="top" title="View Students and Instructors" id="view_studinstruct" onclick="deleteInstructor('+aData[0]+',2);"><i class = "fa fa-remove fa-fw"></i></button>' );
      }

    },
    "fnInitComplete": function(oSettings, json) {
    }
  }).on('processing.dt',function(oEvent, settings, processing){
  });
}


//list all services under the service provider
function services(){
  $.ajax({
    url: 'cglobal/dropdown/1',
    dataType:'JSON',
    success: function(msg){
      var opt = "";
      $.each(msg, function(i,e){
        opt += "<option value = '"+e.ServiceID+"'>"+e.ServiceName+"</option>";
      }); 

      $('#service_id').html(opt);
    }
  });
}

function addInstructor(data){
  var instHiddenVal = $('#instHiddenVal').val();

  if(instHiddenVal != ''){
    var url = 'services/updateInstructor/'+instHiddenVal;
    var errorMsg = "Changes saved.";
  }else{ 
    var url = 'services/addInstructor';
    var errorMsg = "New Instructor has been added to your Service."
  }
  $.ajax({
    url:url,
    data:{data:data},
    dataType:'JSON',
    type:'POST',
    success: function(msg){
      var table = $("#tbl-instructor").DataTable();
      if(msg == true){
        $("#instructor-tab .alert").html(errorMsg).addClass('alert-success').show();

        $.each(data, function(i,e){
            $('#'+e.name).val('');
        });
        table.ajax.reload();
      }else{
        $("#instructor-tab .alert").html("An error occurred. Please try again later or contact your Administrator.").addClass('alert-danger').show();
      }
    }
  });
}

function editServices(id){
  var height = $(window).height();
  var dialogHeight = $("#modal_viewlist").find('.modal-dialog').outerHeight(true);
  var top = parseInt(height)/5-parseInt(dialogHeight);
  $("#modal_addservices").modal('show').attr('style','top:'+top+'px !important;');
  $("#modal_addservices").modal('show');
  $('#modal_addservices .modal-title').html("Edit Services");
  
  getData(id, 1);
}

function updateInstructor(id){
  getData(id, 2);
}

function getData(id, type){
  switch(type){
    case 1: //update services
          $("#txtHiddenService").val(id); //2 for update
    break;
    case 2: //instructors
          $('#instHiddenVal').val(id);
    break;
  }
  
  $.ajax({
    url:'services/getData',
    data:{id:id, type:type},
    dataType:'JSON',
    type:'POST',
    success: function(msg){
      switch(type){
        case 1: //services
              var frmName = "#formaddservice";
        break;

        case 2: //instructors
              var frmName = "#formaddinstructor";
        break;
      }
      var frmdata = $(frmName).serializeArray();
      $.each(frmdata, function(i,e){
          var name = e.name;
          $(frmName+" #"+name).val(msg[0][name]);
      });
    }
  });
}

function removeService(id,t){
  $("#action_type").val(2);
  $('#deleteType').val(t);
  $('#sid').val(id);
  var height = $(window).height();
  var dialogHeight = $("#modal_security").find('.modal-dialog').outerHeight(true);
  var top = parseInt(height)/5-parseInt(dialogHeight);
  $("#modal_security").modal('show');
  $("#modal_security .modal-dialog").attr('style','margin-top:'+top+'px !important;');

 $("#content-services  .alert").html("").removeClass('alert-danger').hide();
  $("#modal_security").modal('show').attr('style','top:'+top+'px !important;');
}

function removeData(){
  var deleteType =  $('#deleteType').val();
  var sid = $("#sid").val();
  $.ajax({
      url: 'services/removeData/'+sid+"/"+deleteType,
      dataType: 'JSON',
      type:'GET',
      success:function(msg){
        if(msg == true){
             $('#deleteType').val('');
            $("#modal_security .alert").html("").hide();
            $("#modal_security").modal('hide');
            $("#message .alert").html("Service deleted successfully").removeClass("alert-danger").addClass("alert-success").show();
            setTimeout(function(){
              $("#message .alert").html("").removeClass("alert-success").show();
              var table = $("#tbl-services").DataTable();
              table.ajax.reload();
            },2000);
        }else{

        }

      }
  });
}


function loadInterest(t){
  $.ajax({
    url: 'cglobal/loadInterest/'+t,
    dataType:'JSON',
    type:'POST',
    success: function(msg){
      var opt = "";
      $.each(msg, function(i,e){
            opt += "<option value = "+e.interest_id+">"+e.interest_name+"</option>";
      });

      $('#interest_id').html(opt);
    }
  });
}