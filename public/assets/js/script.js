$(function(){
    "use strict"

    setTimeout(function () {
        var dzSettingsOptions = {
            typography: "Inter, sans-serif",
            version: "light",
            layout: "horizontal",
            primary: "color_1",
            headerBg: "color_4",
            navheaderBg: "color_4",
            sidebarBg: "color_1",
            sidebarStyle: "full",
            sidebarPosition: "fixed",
            headerPosition: "fixed",
            containerLayout: "full",
        };
        new dzSettings(dzSettingsOptions);
        jQuery(window).on('resize', function () {
            new dzSettings(dzSettingsOptions);
        })
    }, 1000);
    
    var swiper = new Swiper(".mySwiper", {
        slidesPerView: 1.5,
        spaceBetween: 15,
        navigation: {
            nextEl: "",
            prevEl: "",
        },
        breakpoints: {
            // when window width is <= 499px
            1199: {
                slidesPerView: 2.5,
                spaceBetweenSlides: 15
            },
            // when window width is <= 999px
            1600: {
                slidesPerView: 1.5,
                spaceBetweenSlides: 15
            }
        },
    });

    $("#branchSelector").modal('show');

    $(document).on("click", ".viewMaterialBox", function(){
        let bNumber = $(this).data('bno');
        let pid = $(this).data('pid');
        $(".bNumber").text(bNumber)
        $(".pid").val(pid);
        $('#materialBox').addClass('active');       
    });
    
    $(document).on("click", ".viewMaterialDetailsBox", function(){
        let bNumber = $(this).data('bno');
        let pid = $(this).data('pid');
        $(".bNumber").text(bNumber)
        $.ajax({
            type: 'GET',
            url: '/ajax/material/details/' + pid,
            success: function (res) {
                $('#materialDetailsBox').addClass('active');
                $(".materialDetails").html(res);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR)
            }
        });     
    }); 

    $(document).on("click", ".viewProductionDetailsBox", function(){
        let bNumber = $(this).data('bno');
        let pid = $(this).data('pid');
        $(".bNumber").text(bNumber)
        $.ajax({
            type: 'GET',
            url: '/ajax/production/details/' + pid,
            success: function (res) {
                $('#productionDetailsBox').addClass('active');  
                $(".productionDetails").html(res);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR)
            }
        });       
    }); 

    $(document).on("click", ".viewDecomBox", function(){
        let bNumber = $(this).data('bno');
        let pid = $(this).data('pid');
        $(".bNumber").text(bNumber)
        $(".pid").val(pid);
        $('#decomBox').addClass('active');       
    });

});
