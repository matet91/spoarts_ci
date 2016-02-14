function getApprovedStudents(){
  $('#tbl-approved_students').DataTable( {
    "bProcessing":true, 
    "bServerSide":true,
    "bRetrieve": true,
    "bDestroy":true,
    "sLimit":10,  
    "sAjaxSource": "clients/dataTables/1",
    "aoColumns":[ 
            {"sTitle":"ID","sName":"ID","bVisible":false},
            {"sTitle":"SchedID","sName":"SchedID","bVisible":false},
            {"sTitle":"Clinic ID","sName":"clinic_id","bVisible":false},
            {"sTitle":"Service ID","sName":"service_id","bVisible":false},
            {"sTitle":"Client ID","sName":"clientid","bVisible":false},
            {"sTitle":"Student ID","sName":"studid","bVisible":true},
            {"sTitle":"Name","sName":"name"},
            {"sTitle":"Age","sName":"age","bSearchable": true},
            {"sTitle":"Address","sName":"address","bSearchable": true},
            {"sTitle":"Client","sName":"client","bSearchable": true},
            {"sTitle":"Service","sName":"service","bSearchable": true},
            {"sTitle":"Instructor","sName":"instructor","bSearchable": true},
            {"sTitle":"Date Enrolled","sName":"date_enrolled","bSearchable": true},
            {"sTitle":"Schedule","sName":"SchedDays","bSearchable": true},
            {"sTitle":"Total Payment for this Service","sName":"totalamt","bSearchable": true,"bSortable":false},
            {"sTitle":"Total Outstanding for this Service","sName":"totalbalance","bSearchable": false,"bSortable":false},
            {"sTitle":"Actions"}
    ],
    "fnRowCallback": function( nRow, aData, iDisplayIndex ) {

      if ( aData[16] == 1 ){
        $('td:eq(11)', nRow).html('<button class = "btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" title="View Time Logs" onclick="view_timelogs('+aData[0]+','+aData[1]+','+aData[2]+','+aData[3]+','+aData[4]+','+aData[5]+');"><i class = "fa fa-clock-o fa-fw"></i></button>&nbsp;<button class = "btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="View Payment History" onclick="payment_logs('+aData[0]+','+aData[1]+','+aData[2]+','+aData[3]+','+aData[4]+','+aData[5]+');"><i class = "fa fa-money fa-fw"></i></button>' );
      }

    },
    "fnInitComplete": function(oSettings, json) {
    }
  }).on('processing.dt',function(oEvent, settings, processing){
  });
}

function getDisapprovedStudents(){
  $('#tbl-disapproved_students').DataTable( {
    "bProcessing":true, 
    "bServerSide":true,
    "bRetrieve": true,
    "bDestroy":true,
    "sLimit":10,  
    "sAjaxSource": "clients/dataTables/2",
    "aoColumns":[ 
            {"sTitle":"ID","sName":"ID","bVisible":false},
            {"sTitle":"SchedID","sName":"SchedID","bVisible":false},
            {"sTitle":"Clinic ID","sName":"clinic_id","bVisible":false},
            {"sTitle":"Service ID","sName":"service_id","bVisible":false},
            {"sTitle":"Client ID","sName":"clientid","bVisible":false},
            {"sTitle":"Student ID","sName":"studid","bVisible":true},
            {"sTitle":"Name","sName":"name"},
            {"sTitle":"Age","sName":"age","bSearchable": true},
            {"sTitle":"Address","sName":"address","bSearchable": true},
            {"sTitle":"Client","sName":"client","bSearchable": true},
            {"sTitle":"Service","sName":"service","bSearchable": true},
            {"sTitle":"Instructor","sName":"instructor","bSearchable": true},
            {"sTitle":"Date Enrolled","sName":"date_enrolled","bSearchable": true},
            {"sTitle":"Schedule","sName":"SchedDays","bSearchable": true},
            {"sTitle":"Total Payment for this Service","sName":"totalamt","bSearchable": true,"bSortable":false},
            {"sTitle":"Total Outstanding for this Service","sName":"totalbalance","bSearchable": false,"bSortable":false},
            {"sTitle":"Actions"}
    ],
    "fnRowCallback": function( nRow, aData, iDisplayIndex ) {

      if ( aData[15] == 1 ){
        $('td:eq(11)', nRow).html('<button class = "btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" title="Approve" onclick="approve('+aData[0]+','+aData[1]+','+aData[2]+','+aData[3]+','+aData[4]+','+aData[5]+');"><i class = "fa fa-check-o fa-fw"></i></button>' );
      }

    },
    "fnInitComplete": function(oSettings, json) {
    }
  }).on('processing.dt',function(oEvent, settings, processing){
  });
}


function timelogs(id){
  $('#tbl-timelogs').DataTable( {
    "bProcessing":true, 
    "bServerSide":true,
    "bRetrieve": true,
    "bDestroy":true,
    "order": [[ 1, "desc" ]],
    "sLimit":10,  
    "sAjaxSource": "clients/dataTables/3/"+id,
    "aoColumns":[ {"sTitle":"ID","sName":"ID","bVisible":false},
            {"sTitle":"Date","date":"name"},
            {"sTitle":"Time In","sName":"time_in","bSearchable": true},
            {"sTitle":"Time Out","sName":"time_out","bSearchable": true},
            {"sTitle":"Payment Status","sName":"paidStatus","bSearchable": true}
    ],

    "fnInitComplete": function(oSettings, json) {
    }
  }).on('processing.dt',function(oEvent, settings, processing){
  });
}

function view_timelogs(id,schedid,clinicid,serviceid,clientid,studid){
    $("#studEnrolledID").val(id);
    $("#SchedID").val(schedid);
    $("#studid").val(studid);
    $("#clinicid").val(clinicid);
    $("#serviceid").val(serviceid);
    $("#clientid").val(clientid);
    $("#modal_timelogs").modal();
    listings(7,id);
    checkStatus(id);
    timelogs(id);

}

function in_out(){
    var refID = $("#studEnrolledID").val(),
        SchedID = $("#SchedID").val(),
        studid = $("#studid").val(),
        clinicid = $("#clinicid").val(),
        serviceid = $("#serviceid").val();

    $.ajax({
        url:'clients/in_out/'+refID+'/'+SchedID+'/'+studid+'/'+clinicid+'/'+serviceid,
        dataType:'JSON',
        success:function(msg){
            var table = $("#tbl-timelogs").DataTable();
            if(msg == 1){
                $('#in_out').html("Completed Today's Session").attr('disabled','disabled').removeAttr('class').addClass('btn btn-lg btn-success');
            }else{
                $('#in_out').html("Time Out").removeAttr('class').addClass('btn btn-lg btn-danger');
            }
            table.ajax.reload(); 
            listings(7,refID);
            $("#date_log").trigger('chosen:updated');               
        }
    });

}

function checkStatus(id){
    $.ajax({
        url:'clients/checkStatus/'+id,
        dataType:'JSON',
        success: function(msg){
            if(msg != 0){
                if(msg.tl_out == null){
                    $('#in_out').html("Time Out").removeAttr('class').addClass('btn btn-lg btn-danger');
                }else{
                    $('#in_out').html("Completed Today's Session").attr('disabled','disabled').removeAttr('class').addClass('btn btn-lg btn-success');
                }
            }else{
                $('#in_out').html("Time In").removeAttr('disabled').removeAttr('class').addClass('btn btn-lg btn-primary');
            }
        }
    });
}

function paynow(){
    var frm = $("#frm-paynow").serializeArray(),
        errList = new Array(), data={};

    $.each(frm, function(i,e){
        var name = $("#"+e.name),
            value = e.value;
        if(value == ''){
            if(e.name !='payment_balance' || e.name!='payment_desc'){
                if(e.name == 'date_log'){
                    if($("#payment_type").val() == 0){
                        name.parent().addClass('has-error');
                        errList.push(name.attr('placeholder'));
                    }else{
                        name.parent().removeClass('has-error');
                    }
                }else{ 
                    name.parent().addClass('has-error');
                     errList.push(name.attr('placeholder'));
                }
            }else{
                data[e.name] = value;
            }
        }else{
            name.parent().removeClass('has-error');
            data[e.name] = value;
        }

    });

    var len = $("#frm-paynow .has-error").length;
    if(len > 0){
        $("#message .alert").html(errList.toString()+" field (s) are required.").addClass("alert-danger").show();
    }else{
        $("#message .alert").html("").removeClass("alert-danger").hide();
        data['SchedID'] = $("#SchedID").val(),
        data['stud_id'] = $("#studid").val(),
        data['service_id'] = $("#serviceid").val(),
        data['client_id'] = $("#clientid").val();
        submitPay(data);
    }
}

function submitPay(data){
        $.ajax({
            url:"clients/clientPayment",
            dataType:'JSON',
            data:{data:data},
            type:'POST',
            success:function(msg){
                var table = $("#tbl-timelogs").DataTable(),frm = $("#frm-paynow").serializeArray();

                if(msg == true){
                    $("#message .alert").html("Payment Successfully Logged.").addClass('alert-success').show();

                    setTimeout(function(){
                        $("#message .alert").html("").removeClass('alert-success').hide();
                    },2500);
                    $.each(frm, function(i,e){
                        $("#"+e.name).val("");
                    });
                }else{
                    $("#message .alert").html("Error. Send Email report to spoarts.cebu@gmail.com if error persist.").addClass('alert-danger').show();

                    setTimeout(function(){
                        $("#message .alert").html("").removeClass('alert-danger').hide();
                    },2500);
                }

                table.ajax.reload();
            }
        });
        
}

function payment_logs(id,schedid,clinicid,serviceid,clientid,studid){
    $("#studEnrolledID").val(id);
    $("#SchedID").val(schedid);
    $("#studid").val(studid);
    $("#clinicid").val(clinicid);
    $("#serviceid").val(serviceid);
    $("#clientid").val(clientid);
    $("#modal_paymentlogs").modal();
    getPaymentDetails(id); //get total amount spent and total outstanding balance
    paymentlogs(id);
}
function paymentlogs(id){
  $('#tbl-paymentlogs').DataTable( {
    "bProcessing":true, 
    "bServerSide":true,
    "bRetrieve": true,
    "bDestroy":true,
    "sLimit":10,  
    "sAjaxSource": "clients/dataTables/4/"+id,
    "aoColumns":[ {"sTitle":"ID","sName":"payment_id","bVisible":false},
            {"sTitle":"Start Date","payment_date":"name"},
            {"sTitle":"End Date","sName":"payment_end_date","bSearchable": true},
            {"sTitle":"Payment Type","sName":"payment_type","bSearchable": true},
            {"sTitle":"Amount Paid","sName":"payment_amt","bSearchable": true},
            {"sTitle":"Outstanding Balance","sName":"payment_balance","bSearchable": true},
            {"sTitle":"Log Date","sName":"date_added","bSearchable": true},
            {"sTitle":"Log Updated","sName":"last_updated","bSearchable": true},
            {"sTitle":"Action"}
    ],
    "fnRowCallback": function( nRow, aData, iDisplayIndex ) {

      if ( aData[8] == 1 ){
        $('td:eq(7)', nRow).html('<button class = "btn btn-primary btn-xs" data-toggle="popover" data-placement="left" title="Update Payment" id = "btn-updatebalance" onclick="updateBalance('+aData[0]+');"><i class = "fa fa-money fa-fw"></i></button>&nbsp;' );
      }

    },
    "fnInitComplete": function(oSettings, json) {

    }
  }).on('processing.dt',function(oEvent, settings, processing){
  });
}

function getPaymentDetails(id){
    $.ajax({
        url:'clients/getPaymentDetails/'+id,
        dataType:'JSON',
        success:function(msg){
            $("#totalamt").val(msg[0].totalamt);
            $("#servicename").val(msg[0].servicename);
            $("#studentname").val(msg[0].studentname);
            $("#totalbalance").val(msg[0].totalbalance);
            $("#clinicname").val(msg[0].clinicname);
            $("#clientname").val(msg[0].clientname);
        }
    });
}
function updateBalance(paymentid){
    $("#paymentid").val(paymentid);
    var content = '<form id="frm-updateBalance"><div class="form-group"><label>Total Paid:</label><input type="text" id="pay_amt" name="pay_amt" class="form-control" onkeypress="numbersOnly(this.value,this.name)"/></div></div><div class="form-group"><label>Current Balance:</label><input type="text" id="pay_bal" name="pay_bal" class="form-control" onkeypress="numbersOnly(this.value,this.name)"/></div><div class="form-group"><button type="button" class="btn btn-default btn-xs" id="btn-payclose"><i class="fa fa-close fa-fw"></i></button>&nbsp;<button type="button" class="btn btn-primary btn-xs" id = "btn-paysave"><i class="fa fa-save fa-fw" ></i></button></div></form>';
    $("#btn-updatebalance").attr('data-content',content).popover({html:true}).popover('show');

    $("#btn-payclose").click(function(e){
        e.preventDefault();
        $("#btn-updatebalance").popover('hide').on('hidden.bs.popover', function () {
            $("#paymentid").val('');
        });

    });

    $("#btn-paysave").click(function(e){
        e.preventDefault();
        var frm = $("#frm-updateBalance").serializeArray();
        $.each(frm, function(i,e){
            if(e.value == ''){
                $("#"+e.name).parent().addClass('has-error');
            }else{
                $("#"+e.name).parent().removeClass('has-error');
            }
        });
        var len = $("#frm-updateBalance .has-error").length;
        if(len > 0){
            $("#message .alert").html("All fields are required.").addClass('alert-danger').show();
        }else{
            $("#message .alert").html("").removeClass('alert-danger').hide();
            $.ajax({
                url:'clients/updateBalance/'+paymentid,
                data:{'payment_amt':$("#pay_amt").val(),'payment_balance':$("#pay_bal").val()},
                dataType:'JSON',
                type:'POST',
                success:function(msg){
                    if(msg == true){

                        var table = $("#tbl-paymentlogs").DataTable();
                         table.ajax.reload();
                        $("#message .alert").html("Payment Updated Successfully.").addClass('alert-success').show();

                        setTimeout(function(){
                             $("#message .alert").html("").removeClass('alert-success').hide();
                        },2500);
                        getPaymentDetails($("#studEnrolledID").val());
                    }else{
                        $("#message .alert").html("Error. Send Email report to spoarts.cebu@gmail.com if error persist.").addClass('alert-danger').show();

                        setTimeout(function(){
                            $("#message .alert").html("").removeClass('alert-danger').hide();
                        },2500);
                    }
                }
            });
        }
    });
}
$(document).ready(function(){
    getApprovedStudents();
    getDisapprovedStudents();
    listings(6,null); //see main.js
    $("#service_id").change(function(){
       var table = $("#tbl-approved_students").dataTable();
       table.fnFilter("serviceid_"+$(this).val());
       $("#tbl-approved_students_filter input").val("");
    });
    $("#in_out").click(function(){
        in_out();
    });

    $('#modal_timelogs').on('hidden.bs.modal', function (e) {
        $("#studEnrolledID").val("");
        $("#SchedID").val("");
        $("#studid").val("");
        $("#clinicid").val("");
        $("#serviceid").val("");
        $("#clientid").val("");
        var frm = $("#frm-paynow").serializeArray();
        $.each(frm, function(i,e){
            $("#"+e.name).val("");
        });
    });

    $('#modal_paymentlogs').on('hidden.bs.modal', function (e) {
        $("#clients input[type=hidden]").val("");
        var frm = $("#frm-paynow").serializeArray();
        $.each(frm, function(i,e){
            $("#"+e.name).val("");
        });
    });

    $("#payment_type").change(function(){

        if($(this).val() == 0){
            $("#date_log").removeAttr('disabled');
            $("#date_log").chosen({width:"95%"}).trigger('chosen:updated');
            $(".chosen-container").attr('style','width:95% !important');
        }else{
            $("#date_log").attr('disabled','disabled');
            $("#date_log").chosen('destroy');
        }
    });
    $("#paynow").click(function(){
        $("#frm-paynow").show('toggle');
    });

    $("#btn-close").click(function(e){
        e.preventDefault();
        $("#frm-paynow").hide('toggle');
    });

    //over the counter payment
    $("#btn-payout").click(function(e){
        e.preventDefault();
        paynow();
    });


});

