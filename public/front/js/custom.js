
function remove_loader() {
    $('.preloader').hide();
}

function show_loader() {
    $('.preloader').show();
}
$(document).ready(function () {
    $('#select_language').change(function() {
        var selected_language = $(this).val();
        if(selected_language == '' && selected_language == null){
            selected_language = 'en';
        }
        $.ajax({
            type: 'GET',
            url: APP_URL + '/language-change/'+selected_language,
        }).done(function (response) {
            console.log(response);
            window.location.reload(true);
        });
    });
    class_add_remove_body();
});

$(document).ready(function () {
    $('#more_select_language').change(function() {
        var selected_language = $(this).val();
        if(selected_language == '' && selected_language == null){
            selected_language = 'en';
        }
        $.ajax({
            type: 'GET',
            url: APP_URL + '/language-change/'+selected_language,
        }).done(function (response) {
            console.log(response);
            window.location.reload(true);
        });
    });
    class_add_remove_body();
});

function class_add_remove_body() {
    if(LANGUAGE === 'ar'){
        $('body').addClass('rtl');
    }else{
        $('body').removeClass('rtl');
    }
}

