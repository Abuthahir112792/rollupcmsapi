$(document).ready(function () {

    get_user_details();
    function get_user_details() {
        show_loader();
        var token = window.localStorage.getItem('token');
        $.ajax({
            type        : 'GET',
            url         : APP_URL + '/api/get/user/detail/'+LANGUAGE,
            headers     : {"Authorization": 'Bearer '+token}
        }).done(function(response) {
            if(response.status == 1){
                $('#name').val(response.data.name);
                $('#mobile').val(response.data.mobile_number);
                $('#email').val(response.data.email);
                $('#password').val(response.password);
                $('#room_number').val(response.data.room_number);
                $('#house_number').val(response.data.house_number);
                $('#zone_number').val(response.data.zone_number);
                $('#street_name').val(response.data.street_name);
                $('#area_name').val(response.data.area_name);
                $('#land_mark').val(response.data.land_mark);
                $('#building_villa_name').val(response.data.building_villa_name);
                //tester();
            }else{
                var url = '';
                notification(response.message,url);
            }
            remove_loader();
        });
    }

    $('#btn_profile').click(function () {
        show_loader();
        var token = window.localStorage.getItem('token');
        var name = $('#name').val();
        var email = $('#email').val();
        var password = $('#password').val();
        var room_number = $('#room_number').val()||"-";
        var house_number = $('#house_number').val();
        var zone_number = $('#zone_number').val()||"-";
        var street_name = $('#street_name').val();
        var area_name = $('#area_name').val();
        var land_mark = $('#land_mark').val();
        var building_villa_name = $('#building_villa_name').val()||"-";
        $.ajax({
            type        : 'POST',
            url         : APP_URL + '/api/user/update/'+LANGUAGE,
            data        : {user_name : name,email : email,password : password,room_number : room_number,house_number : house_number,zone_number : zone_number,street_name : street_name,area_name : area_name,land_mark : land_mark,building_villa_name : building_villa_name},
            headers     : {"Authorization": 'Bearer '+token}
        }).done(function(response) {
            var url = '';
            if(response.status == 1){
                cache_clear();
                url = APP_URL+'/profile';
            }
            remove_loader();
            notification(response.message,url);
        });
    });

    function remove_loader() {
        $('.preloader').hide();
    }

    function show_loader() {
        $('.preloader').show();
    }

    /*function tester() {
        var x =   document.getElementById("name").value;
        document.getElementById("userid").value = x;
    }*/

    function notification(message,url) {
        $('#notification_action').attr('href',url);
        $('#notification_message').text(message);
        $('#notification_modal').modal('show');
    }


    function cache_clear() {
        if ('serviceWorker' in navigator) {
            caches.keys().then(function(cacheNames) {
                cacheNames.forEach(function(cacheName) {
                    caches.delete(cacheName);
                });
            });
        }
    }
});
