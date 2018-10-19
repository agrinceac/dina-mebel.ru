
$(function(){
    $('.button-menu_mobil' ).click(function(){
        $('.menu_mobil').toggleClass('menu-open');
    });
});

$(function(){
    $('.button-menu_mobil' ).click(function(){
        $('.button-menu_mobil').toggleClass('buttom-menu-open');
    });
});

$(function(){
    $('.title__btn' ).click(function(){
        $('.razdel-block').toggleClass('active');
    });
});

//скрипт для подкатегорий в левом меню

// $(document).ready(function () {
//
//     $('.catalog-accardion_icon').click(function () {
//         $(this).toggleClass('in').next().slideToggle();
//         $('.catalog-accardion_icon').not(this).removeClass('active').next().slideUp();
//     });
//
// });


$(function () {
    $('.title__burger').click(function () {
        $('.title__burger').toggleClass('button-catalog-open');
    });
});

$(function () {
    $('.title__burger').click(function () {
        $('.razdel-block').toggleClass('active');
    });
});
