// Hamburger menu
var hamburger = function(){
    $('.fa-bars').on('click', function(){
        $('.fa-bars').toggleClass('hamburger-toggle');
        $('.header-third-line').toggleClass('menu-toggle');

        $(window).on('resize', function(){
            if($(window).width() >= 767){
                $('.header-third-line').removeClass('menu-toggle');
                $('.fa-bars').removeClass('hamburger-toggle');
            }
        })   
    })
}
hamburger();

// On/Off login menu
var loginAndRegistration = function(){
    $('.login-panel-button').on('click', function(){
        $('.login-box').toggleClass('login-open');
    })
}
loginAndRegistration();

