(function($) {
    var SlickCarousel = function($scope, $) {
        var $carousel = $scope.find('.pnw-slider-wrapper');

                $carousel.slick({
                    infinite: $carousel.data("loop"),
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    mobileFirst: true,
                    dots: $carousel.data("dots"),
                    arrows: $carousel.data("nav"),
                    autoplay: $carousel.data("autoplay"),
                    autoplaySpeed: $carousel.data("autoplay-timeout"),
                    fade: true,
                    cssEase: 'linear',
                    draggable: $carousel.data("mouse-drag"),
                    touchMove: $carousel.data("touch-drag"),
                });

    };

    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/listslides.default', SlickCarousel);
    });

})(jQuery);