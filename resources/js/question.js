$(function(){
    $('form [name="title"]').on('input', function(){
        if ($(this).val().length > 5){
            $('form h1 b').text($(this).val());
        } else {
            if ($('form h1 b').text() !== '...')
                $('form h1 b').text('...');
        }
    });

    $('.question-page .comment .reply').on('click', function (){
        let main = $(this).parents('.main');
        let comment_id_text = main.find('.comment_id');
        let name_author  = $(this).parents('.main').find('.user b');
        let comment_id  = $(this).data('comment');

        $('.input-reply').css('display', 'block');
        $('.input-reply input').val(comment_id);
        $('.input-reply .comment_id').text($(comment_id_text).text());
        $('.input-reply p b').text($(name_author).text());
    });

    $('.actions .icon').on('click', function (){
        let action = $(this).data('action');
    });

});