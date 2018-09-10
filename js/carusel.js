jQuery(document).ready(function($) {
    $('.img-big-ul').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: '.img-min-ul'
    });

    $('.img-min-ul').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        asNavFor: '.img-big-ul',
        dots: false,
        centerMode: false,
        focusOnSelect: true,
        infinite: true,

        responsive: [
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            }
        ]
    });
});