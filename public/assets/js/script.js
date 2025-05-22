$(function(){
    "use strict"

    $("#branchSelector").modal('show');
    
    $('.select2').select2();
    
    $('#myTable')
        .addClass( 'nowrap' )
        .dataTable( {
            responsive: true,
        });
})