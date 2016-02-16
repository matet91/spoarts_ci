function getservices(){
  $('#tbl-services').DataTable( {
    "bProcessing":true, 
    "bServerSide":true,
    "bRetrieve": true,
    "bDestroy":true,
    "sLimit":10,  
    "sAjaxSource": "sp_profile/dataTables/1",
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

$(document).ready(function(){
    getservices();
});