$('.profile-page form.update-avatar input').on('change', function (){
    if ($(this)[0].files.length){
        $(this).parents('.card-body').addClass('active');
    } else {
        $(this).parents('.card-body').removeClass('active');
    }
});