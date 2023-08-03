$(document).ready(function(){

    $('#search-box').keyup(function(e){
        if (e.key === "Enter") {
            window.location.href = $(this).data('url') + '/' + $(this).val();
        }
    });

    $('#search-box-sp').keyup(function(e){
        if (e.key === "Enter") {
            window.location.href = $(this).data('url') + '/' + $(this).val();
        }
    });

    // mobile menu
    $('.mobile-hamburger').click(function(){
        $('#mobile-top-menu-wrapper').show();
    });

    $('.mobile-menu-close').click(function(){
        $('#mobile-top-menu-wrapper').hide();
    });

    // scroll top
    $('.content-footer').click(function(){
        window.scrollTo({top: 0, behavior: 'smooth'});
    });

});

$(window).on('beforeunload', function() {
    // $('body').hide();
    $(window).scrollTop(0);
});

// search
function onSearch()
{
    var sWidth = $(window).width();
    if(sWidth < 768){
        $('#search-box-sp').animate({
            width: "toggle"
        });

    }else {
        $('#search-box').animate({
            width: "toggle"
        });
    }
}