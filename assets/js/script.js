$ = jQuery;
$(document).ready(function() {

});

carouselNormalization();
$('.activityCarousel').owlCarousel({
    loop:true,
    margin:20,
    // autoplay: true,
    autoplayTimeout: 5000,
    autoplayHoverPause: true, // Stops autoplay
    nav: true,
    dots: false,
    center: true,
    mouseDrag: false,
    navText : ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
    responsive:{
        0:{
            items:1
        },
        600:{
            items:2
        },
        1000:{
            items:3
        }
    },
    onInitialize: function (event) {
        if ($('.activityCarousel .item').length <= 1) {
           this.settings.loop = false;
        }
    }
});

$('.homeAltCarousel').owlCarousel({
    loop: $('.homeAltCarousel .item').size() > 1 ? true:false,
    items:1,
    dots: $('.homeAltCarousel .item').size() > 1 ? true:false,
    center: true,
    margin:20,
    stagePadding: 0,
    autoplay: true,
    autoplayTimeout: 5000,
    autoplayHoverPause: true, // Stops autoplay
    onInitialize: function (event) {
        if ($('.homeAltCarousel .item').length = 1) {
           this.settings.loop = false;
        }
    }
});

$('.homeAltCarousel .owl-nav').remove();




function carouselNormalization() {
    var items = $('.activityCarousel .card'), //grab all slides
        heights = [], //create empty array to store height values
        tallest; //create variable to make note of the tallest slide

    if (items.length) {
        function normalizeHeights() {
            items.each(function() { //add heights to array
                heights.push($(this).height());
            });
            tallest = Math.max.apply(null, heights); //cache largest value
            items.each(function() {
                $(this).css('min-height',tallest + 'px');
            });
        };
        normalizeHeights();

        $(window).on('resize orientationchange', function () {
            tallest = 0, heights.length = 0; //reset vars
            items.each(function() {
                $(this).css('min-height','0'); //reset min-height
            });
            normalizeHeights(); //run it again
        });
    }
}
