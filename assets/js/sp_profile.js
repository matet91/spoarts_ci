function getservices(){
    var id = $("#spid").val();
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
            {"sTitle":"Actions"}
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

        }
    });
}
$(document).ready(function(){
    getservices();
    var table = $("#tbl-services").DataTable();
    $('[data-toggle="tooltip"]').tooltip();
});