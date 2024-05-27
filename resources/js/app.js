import './bootstrap';

async function setThemeMode(){

    try {
        let settings = {
            method: 'POST',
            headers: {
            //     Accept: 'application/json',
            //     'Content-Type': 'application/json',
                // 'X-CRFS-CONTENT' : $('[csrf-token]').attr('content'),
                'X-CSRF-TOKEN': $('[name="csrf-token"]').attr('content'),
                // body: body,
            }
        };

        let query = await fetch('/ajax/setThemeMode', settings);
        // let json = await query.json();
        console.log(query);
    } catch (error) {
        console.error(error);
    }
}

$(function(){
    $('.js-change-theme').on('click', function(){

        setThemeMode();
        

        // $(this).
        // $('html').attr('')
    });

});    