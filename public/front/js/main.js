$(document).ready(function () {

    $('#btn_login').click(function (e) {
        show_loader();
        e.preventDefault();
        var mobile_code = $('#mobile_code').val();
        //mobile_code = mobile_code.replace('+','');
        var mobile = $('#mobile').val();
        var password = $('#password').val();
        $.ajax({
            type: 'POST',
            url: APP_URL + '/api/login/'+LANGUAGE,
            data: {mobile_number: mobile, calling_code: mobile_code, password: password},
        }).done(function (response) {
            remove_loader();
            var url = '';
            if(response.status == 1 && response.token != '' && response.token != null){
                cache_clear();
                window.localStorage.setItem('token',response.token);
                window.localStorage.setItem('username',response.username);
                window.localStorage.setItem('userid',response.userid);
                window.localStorage.setItem('useremail',response.useremail);
                setCookie('token', response.token, 1);
                url = APP_URL+'/home';
            }
            notification(response.message,url)
        });
    });

    $('#btn_register').click(function (e) {
        show_loader();
        e.preventDefault();
        var name = $('#name').val();
        var mobile_code = $('#mobile_code').val();
        //mobile_code = mobile_code.replace('+','');
        var mobile = $('#mobile').val();
        var email = $('#email').val();
        var password = $('#password').val();
        var confirmpassword = $('#confirmpassword').val();
        var room_number = $('#room_number').val()||"-";
        var house_number = $('#house_number').val();
        var zone_number = $('#zone_number').val()||"-";
        var street_name = $('#street_name').val();
        var area_name = $('#area_name').val();
        var land_mark = $('#land_mark').val();
        var building_villa_name = $('#building_villa_name').val()||"-";
        var member_referral = $('#member_referral').val();

        $.ajax({
            type: 'POST',
            url: APP_URL + '/api/register/'+LANGUAGE,
            data: {name : name ,mobile_number: mobile, calling_code: mobile_code, email: email, password: password, confirmpassword: confirmpassword, room_number : room_number,house_number : house_number,zone_number : zone_number,street_name : street_name,area_name : area_name,land_mark : land_mark,building_villa_name : building_villa_name,member_referral : member_referral},
        }).done(function (response) {
            remove_loader();
            var url = ''
            if (response.status == 1) {
                cache_clear();
                url = APP_URL + '/login_otp/' + mobile_code + mobile+'/1';
            }
            notification(response.message,url)
        });
    });

    $('#btn_forgot').click(function (e) {
        show_loader();
        e.preventDefault();
        var mobile_code = $('#mobile_code').val();
        //mobile_code = mobile_code.replace('+','');
        var mobile = $('#mobile').val();
        $.ajax({
            type: 'POST',
            url: APP_URL + '/api/forgot/'+LANGUAGE,
            data: {mobile_number: mobile, calling_code: mobile_code},
        }).done(function (response) {
            remove_loader();
            var url = '';
            if (response.status == 1) {
                cache_clear();
                url = APP_URL + '/login_otp/' + mobile_code + mobile+'/2';
            }
            notification(response.message,url)
        });
    });

    $('#btn_valid_otp').click(function () {
        show_loader();
        var otp1 = $('#otp1').val();
        var otp2 = $('#otp2').val();
        var otp3 = $('#otp3').val();
        var otp4 = $('#otp4').val();
        var otp = otp1+otp2+otp3+otp4;
        var mobile = $('#mobile').val();
        var is_login = $('#is_from_login').val()
        $.ajax({// error
            type        : 'POST',
            url         : APP_URL + '/api/validateOTP/'+LANGUAGE,
            data        : {mobile_number : mobile, otp : otp, is_login_register: is_login},
        }).done(function(response) {
            remove_loader();
            var url = ''
            if(response.status == 1 && response.token != '' && response.token != null){
                cache_clear();
                window.localStorage.setItem('token',response.token);
                window.localStorage.setItem('username',response.username);
                window.localStorage.setItem('userid',response.userid);
                window.localStorage.setItem('useremail',response.useremail);
                setCookie('token', response.token, 1);
                url = APP_URL+'/home';
            }
            else if(response.status == 1){
                cache_clear();
               url = APP_URL + '/reset_password/' + mobile+'/'+response.userids;
            }
            notification(response.message,url)
        });
    });

     $('#btn_resetpassword').click(function () {
        show_loader();
        var password = $('#password').val();
        var confirmpassword = $('#confirmpassword').val();
        var mobile = $('#mobile').val();
        var userids = $('#userids').val()
        $.ajax({// error
            type        : 'POST',
            url         : APP_URL + '/api/resetpassword/'+LANGUAGE,
            data        : {password : password, confirmpassword : confirmpassword, mobile : mobile, userids: userids},
        }).done(function(response) {
            remove_loader();
            var url = ''
            if(response.status == 1){
                cache_clear();
                url = APP_URL + '/login/';
            }
            notification(response.message,url)
        });
    });

    function setCookie(name,value,days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setFullYear(date.getFullYear() +(days));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "")  + expires + "; path=/";
    }

    function remove_loader() {
        $('.preloader').hide();
    }

    function show_loader() {
        $('.preloader').show();
    }

    function notification(message,url) {
        $('#notification_action').attr('href',url);
        $('#notification_message').text(message);
        $('#notification_modal').modal('show');
    }

    $("#mobile").keypress(function(event) {
        return /\d/.test(String.fromCharCode(event.keyCode));
    });

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
