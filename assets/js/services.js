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
      $("#modal_addservices").modal('show');;
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
  masterlistInstructors();
  manageRooms();
  $("#clubimage").click(function(){
    $("#clubpic").click();
  });
  uploadClubpic();

  //save service details to database
  $("#btn-saveServices").click(function(){
    validateForm(1);
  });

  //saveschedules
  $("#btn-saveSchedule").click(function(){
      validateForm(2);
      
  });

  //save room
  $("#btn-saveRoom").click(function(){
      validateForm(4);
      
  });
  $('#btn-checkout').click(function(){
      validateForm(5);
  });
  //open modal for payment method
  $('#btn-paynow').click(function(e){
    e.preventDefault();
    $("#modal_payment").modal('show');
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
  $("#btn-saveInstructor").click(function(){
      validateForm(3);
  });

//open modal instructor
  $("#btn-modalInstructor").click(function(){
      var dialogHeight = $("#modal_addInstructor").find('.modal-dialog').outerHeight(true);
      var top = parseInt(height)/5-parseInt(dialogHeight);
      $("#modal_addInstructor").modal('show');  
  });


//open modal room
  $("#btn-modalRoom").click(function(){
      var dialogHeight = $("#modal_addRoom").find('.modal-dialog').outerHeight(true);
      var top = parseInt(height)/5-parseInt(dialogHeight);
      $("#modal_addRoom").modal('show');  
  });

//open modal schedule
  $("#btn-modalSched").click(function(){
      var dialogHeight = $("#modal_addschedule").find('.modal-dialog').outerHeight(true);
      var top = parseInt(height)/5-parseInt(dialogHeight);
      $("#modal_addschedule").modal('show');
      $("#startTime, #endTime").datetimepicker({
         datepicker:false,
         formatTime: 'h:i a', 
         format: 'h:i a'
        });
  });
  getSchedules();

  //datepicker

  $("#SchedDate").datetimepicker({
  lang:'ch',
  timepicker:false,
  format:'Y-m-d',
  formatDate:'Y-m-d'
});
  listings(4,null); //see main.js
  listings(5,null); //see main.js
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
        $('td:eq(8)', nRow).html('<button class = "btn btn-info btn-xs btn-viewlist" data-toggle="tooltip" data-placement="top" title="Update Service" onclick="editServices('+aData[0]+');"><i class = "fa fa-edit fa-fw"></i></button>&nbsp;<button class = "btn btn-danger btn-xs btn-viewlist" data-toggle="tooltip" data-placement="top" title="Remove Service" onclick="removeService('+aData[0]+',1);"><i class = "fa fa-remove fa-fw"></i></button>' );
      }

    },
    "fnInitComplete": function(oSettings, json) {
    }
  }).on('processing.dt',function(oEvent, settings, processing){
  });


}

function getSchedules(){
  $('#tbl-schedules').DataTable( {
    "bProcessing":true, 
    "bServerSide":true,
    "bRetrieve": true,
    "bDestroy":true,
    "sLimit":10,  
    "sAjaxSource": "services/dataTables/3",
    "aoColumns":[ {"sTitle":"ID","sName":"s.SchedID","bVisible":false},
            {"sTitle":"Days","sName":"s.SchedDays"},
            {"sTitle":"Time","sName":"s.SchedTime","bSearchable": true},
            {"sTitle":"Rooms","sName":"r.RoomName","bSearchable": true},
            {"sTitle":"Instructors","sName":"m.MasterInsName","bSearchable": true},
            {"sTitle":"Services","sName":"srv.ServiceName","bSearchable": true},
            {"sTitle":"Slots","sName":"s.SchedSlots","bSearchable": true},
            {"sTitle":"Date Added","sName":"s.date_added","bSearchable": true},
            {"sTitle":"Actions"}
    ],
    "fnRowCallback": function( nRow, aData, iDisplayIndex ) {

      if ( aData[8] == 1 ){
        $('td:eq(7)', nRow).html('<button class = "btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" title="View Students and Instructors" onclick="view_studentinstructor('+aData[0]+');"><i class = "fa fa-list fa-fw"></i></button>&nbsp;<button class = "btn btn-info btn-xs btn-viewlist" data-toggle="tooltip" data-placement="top" title="Update Service" onclick="editSchedules('+aData[0]+');"><i class = "fa fa-edit fa-fw"></i></button>&nbsp;<button class = "btn btn-danger btn-xs btn-viewlist" data-toggle="tooltip" data-placement="top" title="Remove Service" onclick="removeService('+aData[0]+',1);"><i class = "fa fa-remove fa-fw"></i></button>' );
      }

    },
    "fnInitComplete": function(oSettings, json) {
    }
  }).on('processing.dt',function(oEvent, settings, processing){
  });


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
      if(msg == true){
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

function masterlistInstructors(){
  var table = $('#tbl-insmaterlist').DataTable( {
    "bProcessing":true, 
    "bServerSide":true,
    "bRetrieve": true,
    "bDestroy":true,
    "sLimit":10,
    "sAjaxSource": "services/dataTables/4",
    "aoColumns":[ {"sTitle":"ID","sName":"MasterInsID","bVisible":false},
            {"sTitle":"Name","sName":"MasterInsName"},
            {"sTitle":"Address","sName":"MasterInsAddress","bSearchable": true},
            {"sTitle":"Contact #","sName":"MasterInsContactNo","bSearchable": true},
            {"sTitle":"E-mail","sName":"MasterInsEmail","bSearchable": true},
            {"sTitle":"Expertise","sName":"MasterInsExpertise","bSearchable": true},
            {"sTitle":"Status","sName":"MasterInsStatus","bSearchable": true},
            {"sTitle":"Actions","sName":"1 as action"}
    ],
    "fnRowCallback": function( nRow, aData, iDisplayIndex ) {

      if ( aData[7] == 1 ){
        $('td:eq(6)', nRow).html('<button class = "btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" title="Update" onclick="updateInstructor('+aData[0]+');"><i class = "fa fa-edit fa-fw"></i></button>&nbsp;<button class = "btn btn-danger btn-xs btn-viewlist" data-toggle="tooltip" data-placement="top" title="Remove" onclick="deleteInstructor('+aData[0]+',2);"><i class = "fa fa-remove fa-fw"></i></button>' );
      }
    },
    "fnInitComplete": function(oSettings, json) {
    }
  }).on('processing.dt',function(oEvent, settings, processing){
  });
}

function manageRooms(){
  var table = $('#tbl-rooms').DataTable( {
    "bProcessing":true, 
    "bServerSide":true,
    "bRetrieve": true,
    "bDestroy":true,
    "sLimit":10,
    "sAjaxSource": "services/dataTables/5",
    "aoColumns":[ {"sTitle":"ID","sName":"RoomID","bVisible":false},
            {"sTitle":"Room #","sName":"RoomNo"},
            {"sTitle":"Room Name","sName":"RoomName","bSearchable": true},
            {"sTitle":"Status","sName":"RoomStatus","bSearchable": true},
            {"sTitle":"Actions","sName":"1 as action"}
    ],
    "fnRowCallback": function( nRow, aData, iDisplayIndex ) {

      if ( aData[4] == 1 ){
        $('td:eq(3)', nRow).html('<button class = "btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" title="Update" onclick="updateRoom('+aData[0]+');"><i class = "fa fa-edit fa-fw"></i></button>&nbsp;<button class = "btn btn-danger btn-xs btn-viewlist" data-toggle="tooltip" data-placement="top" title="Remove" onclick="deleteRoom('+aData[0]+',2);"><i class = "fa fa-remove fa-fw"></i></button>' );
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

      $('#service_id,#ServiceID').html(opt).trigger("chosen:updated");
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
  $("#modal_addservices").modal('show');
  $('#modal_addservices .modal-title').html("Edit Services");
  
  getData(id, 1);
}

function editSchedules(id){
  $("#modal_addschedule").modal('show');
  $('#modal_addschedule .modal-title').html("Edit Schedules");
   getData(id, 3);
}

function updateRoom(id){
  $("#modal_addRoom").modal('show');
  $('#modal_addRoom .modal-title').html("Edit Room");
   getData(id, 4);
}

function updateInstructor(id){
  $("#modal_addInstructor").modal('show');
  $('#modal_addInstructor .modal-title').html("Edit Instructor");
  getData(id, 2);
}

function getData(id, type){
  switch(type){
    case 1: //update services
          $("#txtHiddenService").val(id); //2 for update
    break;
    case 2: //instructors
          $('#txtHiddenService').val(id);
    break;
    case 3: //schedules
          $('#txtHiddenService').val(id);
    break;

    case 4: //room
          $('#txtHiddenService').val(id);
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
              var frmName = "#formaddInstructor";
        break;

        case 3: //schedules
              var frmName = "#formaddschedule";
        break;

        case 4: //room
              var frmName = "#formaddRoom";
        break;
      }
      var frmdata = $(frmName).serializeArray();
      $.each(frmdata, function(i,e){
          var name = e.name;
         // console.log(name);
          if(name == 'SchedDays'){
            var split = msg[0][name].split(',');
            //console.log(split+"sdfsd");
            $.each(split,function(i,e){
              //console.log(e);
                $(frmName+" #SchedDays option[value="+e+"]").attr('selected','selected');
            });
          }else{
            $(frmName+" #"+name).val(msg[0][name]);
          }
          
      });
      $(".chosen-select").trigger("chosen:updated");
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

      $('#interest_id').html(opt).trigger("chosen:updated");
    }
  });
}

function validateForm(t){

  switch(t){
    case 1: //add services
        var frmid = "formaddservice",
            modal = "modal_addservices";
    break;
    case 2: //add schedules
         var frmid = "formaddschedule",
              modal = "modal_addschedule";
    break;

    case 3: //add instructor
        var frmid = "formaddInstructor",
            modal = "modal_addInstructor";
    break;
    case 4: //add room
        var frmid = "formaddRoom  ",
            modal = "modal_addRoom";
    break;
    case 5: //paypal
        var frmid = "formpaymentMethod  ",
            modal = "modal_payment";
    break;
  }
  var frmdata = $("#"+frmid).serializeArray(),data={},schedDays = new Array();
  $.each(frmdata, function(i,e){
        var name = $("#"+e.name);
        if(e.value == ""){
          switch(t){
            case 1: //add services
                    name.parent().addClass("has-error");
            break;

            case 2: //add schedules
                  if(e.name != 'InstructorID' && e.name != 'RoomID'){
                    name.parent().addClass('has-error');
                  }
            break;
            case 3: //add instructor
                    name.parent().addClass("has-error");
            break;
            case 4: //add room
                    name.parent().addClass("has-error");
            break;
            case 5: //add room
                    name.parent().addClass("has-error");
            break;
          }
            
        }else{
              switch(t){
                case 1://add services
                      if(e.name == 'ServiceRegistrationFee' || e.name=="serviceWalkin" || e.name == 'ServicePrice' || e.name=="serviceHour"){
                          if($.isNumeric(e.value)){
                            name.parent().removeClass('has-error');
                            data[e.name] = e.value;
                           
                          }else{
                            $("#message .alert").html(name.prev().html()+" should be numeric.").addClass('alert-danger').show();
                            name.parent().addClass("has-error");
                            setTimeout(function(){
                              $("#message .alert").html("").removeClass("alert-danger").hide();
                            },2000);  
                          }
                      }else{
                        name.parent().removeClass('has-error');
                        data[e.name] = e.value;
                      }
                break;

                case 2://add schedules
                      if(e.name == "SchedSlots"){
                        if($.isNumeric(e.value)){
                            name.parent().removeClass('has-error');
                            data[e.name] = e.value;
                           
                          }else{
                            $("#message .alert").html(name.prev().html()+" should be numeric.").addClass('alert-danger').show();
                            name.parent().addClass("has-error");
                            setTimeout(function(){
                              $("#message .alert").html("").removeClass("alert-danger").hide();
                            },2000);  
                        }
                      }else if(e.name == "endTime" || e.name == 'startTime'){
                        
                        data['SchedTime'] = $("#startTime").val()+" - "+$("#endTime").val();
                          name.parent().removeClass('has-error');
                      }else if(e.name == 'SchedDays'){
                         schedDays.push(e.value);
                        name.parent().removeClass('has-error');
                      }else{
                        data[e.name] = e.value;
                        name.parent().removeClass('has-error');
                      }
                break;

                case 3://add Instructor
                      if(e.name == 'MasterInsContactNo'){
                          if($.isNumeric(e.value)){
                            name.parent().removeClass('has-error');
                            data[e.name] = e.value;
                           
                          }else{
                            $("#message .alert").html(name.prev().html()+" should be numeric.").addClass('alert-danger').show();
                            name.parent().addClass("has-error");
                            setTimeout(function(){
                              $("#message .alert").html("").removeClass("alert-danger").hide();
                            },2000);  
                          }
                      }else{
                        name.parent().removeClass('has-error');
                        data[e.name] = e.value;
                      }
                break;

                case 4://add Room
                      if(e.name == "RoomNo"){
                         if($.isNumeric(e.value)){
                              name.parent().removeClass('has-error');
                              data[e.name] = e.value;
                             
                            }else{
                              $("#message .alert").html(name.prev().html()+" should be numeric.").addClass('alert-danger').show();
                              name.parent().addClass("has-error");
                              setTimeout(function(){
                                $("#message .alert").html("").removeClass("alert-danger").hide();
                              },2000);  
                          }
                      }else{                        
                        name.parent().removeClass('has-error');
                        data[e.name] = e.value;
                      }
                break;

                case 5://paypal                     
                        name.parent().removeClass('has-error');
                        data[e.name] = e.value;
                break;
              }
              
        }
  }); 
  if(t == 2) data['schedDays'] = schedDays.toString();
  var count = $("#"+modal+" .has-error").lentgh;
  if(count > 0){
    $("#message .alert").html("All fields are required").addClass("alert-danger").show();
    setTimeout(function(){
      $("#message .alert").html("").removeClass('alert-danger').hide();
    },2000);
  }else{

            saveData(data,t);
  }
}

function saveData(data,t){
  var txtHiddenService = $('#txtHiddenService').val();
switch(t){
  case 1: //services
        if(txtHiddenService == ''){ 
          var url = "services/addServices",
              errorMsg = $("#ServiceName").val()+" Service has been added successfully.";
        }else{ 
          var url = "services/updateServices/"+txtHiddenService,
              errorMsg = $("#ServiceName").val()+" Service info has been updated successfully";
        }
        var frmid = "formaddservice",
            modal = "modal_addservices",
            table = "tbl-services";
  break;

  case 2: //schedules
        if(txtHiddenService == ''){ 
          var url = "services/addSchedule", 
              errorMsg = "New schedule has been added.";
        }else{ 
          var url = "services/updateSchedule/"+txtHiddenService,
              errorMsg = "Schedules has been updated.";
        }
        var frmid = "formaddschedule",
            modal = "modal_addschedule",
            table = "tbl-schedules";
  break;

  case 3: //instructor
        if(txtHiddenService == ''){ 
          var url = "services/addInstructor", 
              errorMsg = "New Instructor has been added.";
        }else{ 
          var url = "services/updateInstructor/"+txtHiddenService,
              errorMsg = "Instructor Information has been updated.";
        }
        var frmid = "formaddInstructor",
            modal = "modal_addInstructor",
            table = "tbl-insmaterlist";
  break;

  case 4: //room
        if(txtHiddenService == ''){ 
          var url = "services/addRoom", 
              errorMsg = "New Room has been added.";
        }else{ 
          var url = "services/updateRoom/"+txtHiddenService,
              errorMsg = "Room Information has been updated.";
        }
        var frmid = "formaddRoom",
            modal = "modal_addRoom",
            table = "tbl-rooms";
  break;

  case 5: //paypal credit card
        if(txtHiddenService == ''){ 
          var url = "services/paypal/"+1, 
              errorMsg = "Payment successful. Congratulations! You are now a premium member";
        }else{ 
          var url = "services/updateRoom/"+txtHiddenService,
              errorMsg = "Room Information has been updated.";
        }
        var frmid = "formpaymentMethod",
            modal = "modal_payment",
            table = "tbl-rooms";
  break;
}

//get how many div is using 'has-error' class
var error = $("#"+frmid+" .has-error").length;
  if(error > 0){
    $("#message .alert").append(" All fields are required.").addClass('alert-danger').show();
  }else{
    $("#message .alert").html("").removeClass('alert-danger').hide();
    $.ajax({
      url:url,
      data:{data},
      dataType:'JSON',
      type:'POST',
      success:function(msg){
        var dtable = $("#"+table).DataTable(), dataForm = $("#"+frmid).serializeArray(); 
        if(msg == true){

            $("#message .alert").html(errorMsg).addClass("alert-success").show();

            $.each(dataForm, function(i,e){
              $("#"+e.name).val("");
            });
            setTimeout(function(){
              $("#message .alert").html("").removeClass("alert-success").hide();
              $("#"+modal).modal('hide');
            },3000);
            if(t == 5){
              window.location = "services";
            }
             dtable.ajax.reload();
             $('#txtHiddenService').val('');
        }else{
          $("#message .alert").html("System Error. Please try again later or report this error to spoarts.cebu@gmail.com.").addClass("alert-success").show();
        }
      }
    });
  }
}


function numbersOnly(val,id){
  if(!$.isNumeric(val)){
    $('#'+id).parent().addClass('has-error');
    $("#message .alert").html($("#"+id).prev().html()+" should be numeric.").addClass("alert-danger").show();
  }else{
    $("#"+id).parent().removeClass('has-error');
    $("#message .alert").html("").removeClass('has-error').hide();
  }
}