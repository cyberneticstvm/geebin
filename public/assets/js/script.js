$(function(){
    "use strict"

    $("#branchSelector").modal('show');
    
    $('.select2').select2();
    
    $('#myTable')
        .addClass( 'nowrap' )
        .dataTable( {
            responsive: true,
        });

    $(document).on("click", ".myModal", function(){
        let modal = $(this).data('modal');
        let tid = $(this).data('tid');
        $("#" + modal).on('shown.bs.modal', function () {
            $(this).find(".transferId").html(tid);
            $(this).find("#transferId").val(tid);
        });
    });
})