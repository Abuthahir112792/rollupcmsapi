$(document).ready(function () {
    //get_home_details();
    get_pending_details();
    function get_home_details() {
        var token = window.localStorage.getItem('token');
        $.ajax({
            type        : 'GET',
            url         : APP_URL + '/api/get/homepage/'+LANGUAGE,
            headers     : {"Authorization": 'Bearer '+token},
        }).done(function(response) {
            if(response.status == 1){
                $("#first_image").attr("src", APP_URL+'/cms_media/images/'+response.data.images[0]);
                $("#second_image").attr("src", APP_URL+'/cms_media/images/'+response.data.images[1]);
                $("#first_video").attr("src", APP_URL+'/cms_media/videos/'+response.data.videos[0]);
                $("#second_video").attr("src", APP_URL+'/cms_media/videos/'+response.data.videos[1]);
            }else{
                alert(response.message)
            }
        });
    }

    function get_pending_details() {
        var token = window.localStorage.getItem('token');
        $.ajax({
            type        : 'GET',
            url         : APP_URL + '/api/get/pendingpage/'+LANGUAGE,
            headers     : {"Authorization": 'Bearer '+token},
        }).done(function(response) {
            if(response.status == 1){
                /*$("#first_image").attr("src", APP_URL+'/cms_media/images/'+response.data.images[0]);
                $("#second_image").attr("src", APP_URL+'/cms_media/images/'+response.data.images[1]);
                $("#first_video").attr("src", APP_URL+'/cms_media/videos/'+response.data.videos[0]);
                $("#second_video").attr("src", APP_URL+'/cms_media/videos/'+response.data.videos[1]);*/
            }else{
                alert(response.message)
            }
        });
    }

    $('#logout').click(function(){
        show_loader();
        var token = window.localStorage.getItem('token');
        $.ajax({
            type        : 'GET',
            url         : APP_URL + '/api/logout/'+LANGUAGE,
            headers     : {"Authorization": 'Bearer '+token},
        }).done(function(response) {
            var url = '';
            if(response.status == 1){
                cache_clear();
                setCookie('token', '', 1);
                window.localStorage.removeItem("token");
                window.localStorage.removeItem("username");
                window.localStorage.removeItem("userid");
                window.localStorage.removeItem("useremail");
                url = APP_URL+'/home';
            }
            remove_loader();
            notification(response.message,url);
        });
    });

     function setCookie(name,value,days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days*24*60*60*1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "")  + expires + "; path=/";
    }

    $('#place_order').click(function () {
        show_loader();
        var token = window.localStorage.getItem('token');
        var order_description = $('#description').val();
        var self_pickup = $('.select-slef-pickup').hasClass('delivery-method-active')?'True': 'False';

        $.ajax({
            type        : 'POST',
            url         : APP_URL + '/api/place/order/'+LANGUAGE,
            data        : {description : order_description,self_pickup : self_pickup},
            headers     : {"Authorization": 'Bearer '+token},
        }).done(function(response) {
            remove_loader();
            var url = '';
            if(response.status == 1){
                let message = 'Order placed successfully.'
                cache_clear();
                url = APP_URL+'/home';
            }
            notification(response.message,url)
        });
    })

    function notification(message,url) {
        $('#notification_action').attr('href',url);
        $('#notification_message').text(message);
        $('#notification_modal').modal('show');
    }
    function remove_loader() {
        $('.preloader').hide();
    }

    function show_loader() {
        $('.preloader').show();
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


    let homeDelivery =$('.select-home-delivery')
    let selfPickUP =$('.select-slef-pickup')

    homeDelivery.click(function(){
        homeDelivery.addClass('delivery-method-active');
        selfPickUP.removeClass('delivery-method-active')
    })

    selfPickUP.click(function(){
        selfPickUP.addClass('delivery-method-active');
        homeDelivery.removeClass('delivery-method-active')
    })
    
$('.pending_order_card_check').click(function () {
        
        var order_id = $(this).data('id');
        var url = APP_URL + '/order-details/' + encodeURIComponent(order_id);
        window.location.href = url;
        
    })

});




