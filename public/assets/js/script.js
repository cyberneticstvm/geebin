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
});
