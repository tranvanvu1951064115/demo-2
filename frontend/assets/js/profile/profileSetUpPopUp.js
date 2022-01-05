$('.profile__setup .close').click(function() {
    $('.profile__setup').css('display', 'none');
    $('.errorMessage').css('display', 'none');
})

$('.profile__edit').click(function() {
    $('.profile__setup').css('display', 'flex');
    $('.errorMessage').css('display', 'none');
})