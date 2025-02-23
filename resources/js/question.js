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
        let question_id = $(this).parents('.actions').find('#question_id').val();

        if (action && question_id){
            let sendData = new FormData();
            sendData.append("status",action);
            sendData.append("question_id",Number(question_id));

            updUserStatus(sendData);
        }
    });

    async function updUserStatus(sendData){
        try {
            let settings = {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('[name="csrf-token"]').attr('content'),
                },
                body: sendData,
            };

            let query = await fetch('/ajax/questionStatus', settings);
            // let json = await query.json();
            console.log(query);
        } catch (error) {
            console.error(error);
        }
    }

    $('.question-page form.action_rating .icon').on('click', function () {
        let form = $(this).parents('form');
        let action = form.attr('action');

        let comment_id = form.find('[name="comment_id"]').val();
        let sendData = new FormData();

        sendData.append("comment_id",Number(comment_id));
        sendData.append("action",Number($(this).data('action')));

        setCommentRating(action, sendData);
    });

    async function setCommentRating(action, sendData){
        try {
            let settings = {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('[name="csrf-token"]').attr('content'),
                },
                body: sendData,
            };

            let query = await fetch(action, settings);
            // let json = await query.json();
            console.log(query);
        } catch (error) {
            console.error(error);
        }
    }

});