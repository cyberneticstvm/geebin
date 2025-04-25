$(function(){
    "use strict"

    $('.select2').select2();
    
    $('#myTable')
        .addClass( 'nowrap' )
        .dataTable( {
            responsive: true,
        });
})