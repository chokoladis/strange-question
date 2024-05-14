$(function(){
    $('form [name="title"]').on('input', function(){
        if ($(this).val().length > 5){
            $('form h1 b').text($(this).val());
        } else {
            if ($('form h1 b').text() !== '...')
                $('form h1 b').text('...');
        }
    });

});