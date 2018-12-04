jQuery(document).ready(function($) {
    $('.img-big-ul').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: '.img-min-ul'
    });

    $('.img-min-ul').slick({
        slidesToShow: 5,
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
            },

            {
                breakpoint: 580,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
            },

            {
                breakpoint: 680,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1
                }
            },

            {
                breakpoint: 800,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1
                }
            },

            {
                breakpoint: 1023,
                settings: {
                    slidesToShow: 5,
                    slidesToScroll: 1
                }
            },

            {
                breakpoint: 1123,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1
                }
            },
        ]
    });
});