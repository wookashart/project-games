// Slider with news on homepage
$(document).ready(function(){
    $('.last-articles-slider').slick({
        dots: true,
        infinite: true,
        speed: 500,
        slidesToShow: 1,
        slidesToScroll: 1,
        adaptiveHeight: false,
        autoplay: true,
        autoplaySpeed: 5000,
        fade: true,
        pauseOnHover: true,
        arrows: false,
    });
})

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

// PC requirements visible
var pcRequirements = function(){
    var reqCont = $('.game-requirements');
    var platforms = $('.game-platform');
    var isPc = $(platforms).text().search('PC');

    if(isPc == -1){
        $(reqCont).css('display', 'none');
    }
}
pcRequirements();

// Add games to library modal
var addToLibraryModal = function(){
    $('.add-to-library').on('click', function(){
        $('.modal-add-games-collection-conteiner').addClass('modal-open');

        var platforms = $('.game-platform');
        var allPlatforms = $(platforms).text().split(' ');
        var removed = allPlatforms.filter(item => item !== '/')

        $(removed).each(function(val){
            $('.select-platform').append('<option class="select-platform-options" value="'+ removed[val] +'">'+ removed[val] +'</option>');  
        })
    })

    $('.cancel-select-platform').on('click', function(e){
        e.preventDefault();
        $('.modal-add-games-collection-conteiner').removeClass('modal-open');
        $('.select-platform-options').remove();
        $('.distribution-options-conteiner').remove();
        $('.submit-to-library').attr('disabled', true);
    })
}
addToLibraryModal();

function onchangeOptions(){
    var selected = $('.select-platform').val();
    var distributors = ['BOX', 'Czasopismo', 'Steam', 'Uplay', 'GOG', 'Origin', 'Blizzard', 'RockStar Social Club', 'Inne'];

    if(selected == 'brak'){
        $('.submit-to-library').attr('disabled', true);
    } else {
        $('.submit-to-library').attr('disabled', false);
    }

    if(selected == 'PC'){
        $('.select-distribution').append('<div class="distribution-options-conteiner"><h4>Wybierz rodzaj dystrybucji</h4><label class="distribution-options-box"><span>BOX</span><input type="radio" value="BOX" name="distribution" checked></label><label class="distribution-options-box"><span>Czasopismo</span><input type="radio" value="Czasopismo" name="distribution"></label><label class="distribution-options-box"><span>Steam</span><input type="radio" value="Steam" name="distribution"></label><label class="distribution-options-box"><span>Uplay</span><input type="radio" value="Uplay" name="distribution"></label><label class="distribution-options-box"><span>GOG</span><input type="radio" value="GOG" name="distribution"></label><label class="distribution-options-box"><span>Origin</span><input type="radio" value="Origin" name="distribution"></label><label class="distribution-options-box"><span>Blizzard</span><input type="radio" value="Blizzard" name="distribution"></label><label class="distribution-options-box"><span>RockStar Social Club</span><input type="radio" value="RockStar Social Club" name="distribution"></label><label class="distribution-options-box"><span>inne</span><input type="radio" value="inne" name="distribution"></label></label>')
    } else {
        $('.distribution-options-conteiner').remove();
    }
}
onchangeOptions();

// Delete game from collection
function removeGameFromCollection(nr) {
    let gameNrClass = document.getElementsByClassName(nr);
    
    $(gameNrClass).find('.collection-delete-modal').fadeIn(200).css('display', 'block');
}

$('.collection-delete-reject').on('click', () => {
    $('.collection-delete-modal').fadeOut(200, () => {
        $(this).css('display', 'none');
    });
})

function acceptRemoveFromCollection(id) {
    $.ajax ({
        method: "POST",
        url: "php/removefromcollection.php",
        data: { idGame: id }
    })
    .done(() => {
        location.reload();
    })
    .fail(() => {
        let failCom = '<div class="fail-remove-container"><div class="fail-remove-content"><h2>Niestety nie udało się usunąć gry! Odczekaj chwilę i spróbuj ponownie.</h2><button class="base-btn fail-remove-close" onclick="closeFailModal()">Zamknij</button></div></div>';
    
        $(failCom).appendTo('.user-game-collection');
        $('.collection-delete-modal').css('display', 'none');
    })
}

function closeFailModal() {
    $('.fail-remove-container').fadeOut(200, () => {
        $(this).css('display', 'none');
    });
}

// Add played games modal
var addToPlayedModal = function(){
    $('.add-to-played-btn').on('click', function(){
        $('.modal-add-played-games-conteiner').addClass('modal-open');
   
    });

    $('.cancel-played-game').on('click', function(e){
        e.preventDefault();
        $('.modal-add-played-games-conteiner').removeClass('modal-open');
    });
}
addToPlayedModal();

var slider = new Slider("#ex8", {
  tooltip: 'always'
});