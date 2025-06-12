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

    $(document).on("click", ".myPdctModal", function(){
        let modal = $(this).data('modal');
        let pid = $(this).data('pid');
        $("#" + modal).on('shown.bs.modal', function () {
            $(this).find(".productionId").html(pid);
            $(this).find("#productionId").val(pid);
            $.ajax({
                type: 'GET',
                url: '/ajax/production/output',
                data: {'pid': pid },
                success: function (res) {
                    if(res){                        
                        res.data.forEach(element => {
                        let name = element['name'].replace(' ', '_').toLowerCase();
                        $('input[name="'+name+'"]').val(element['qty'])
                    });
                    }                   
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    console.log(XMLHttpRequest);
                }
            });
        });
    });
})