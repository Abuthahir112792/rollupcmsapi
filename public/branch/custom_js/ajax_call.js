var api_url = APP_URL+'/';
$(".alert").slideDown(300).delay(5000).slideUp(300);

function getAjaxData(action, data){
    $('.loder_cla').removeClass('div_hide');
    
    return fetch(api_url+action,{
        method: 'get', // *GET, POST, PUT, DELETE, etc.
        headers: {
            "Content-Type": "application/json",
            "Accept" : "application/json",
            "Authorization" : "Bearer "+localStorage.getItem('access_token'),
        },
        dataType: 'json'
      }).then(function(data){
        if(data.status != 200){
            window.location.href = "/login"
        }
        return data.json();
      }).then(function(data){
        $('.loder_cla').addClass('div_hide');
        return data;
      }).catch(function(error){
        boostNotify("Oops something wrong.", "danger");
      });
}


function postAjaxData(action, data){
    $('.loder_cla').removeClass('div_hide');
    return fetch(api_url+action,{
        method: 'post', // *GET, POST, PUT, DELETE, etc.
        headers: {
            "Content-Type": "application/json",
            "Accept" : "application/json",
            "Authorization" : "Bearer "+localStorage.getItem('access_token'),
        },
        body: JSON.stringify(data),
        dataType: 'json'
      }).then(function(data){
        if(data.status != 200 && data.status != 422){
            //window.location.href = "/login"
        }
        return data.json();
      }).then(function(data){
        $('.loder_cla').addClass('div_hide');
        return data;
      }).catch(function(error){
        boostNotify("Oops something wrong.", "danger");
      });
}

//For notification
function boostNotify(msg, type) {
    bootoast({
        message: msg,
        position: 'bottom-left',
        type: type,
        timeout: 2,
        dismissable: true
    });
} 

//logout
function logout(){
    $('.loder_cla').removeClass('div_hide');
    return fetch(api_url+'api-logout',{
        method: 'get', // *GET, POST, PUT, DELETE, etc.
        headers: {
            "Content-Type": "application/json",
            "Accept" : "application/json",
            "Authorization" : "Bearer "+localStorage.getItem('access_token'),
        },
        dataType: 'json'
      }).then(function(data){
        if(data.status == 200){
            window.location.href = '/login';
        }
        $('.loder_cla').addClass('div_hide');
      }).catch(function(error){
        boostNotify("Oops something wrong.", "danger");
      });
}

$(document).ready(function() {
    $('.order_allow').change(function() {
        $('.cus_alert_msg').html('');
        var val = 0;
        if(this.checked == true){
            val = 1;
        }
        $.ajax({
            type        : 'GET',
            url         : APP_URL + '/branch/order-allow/'+val,
            cache : false,
            processData: false
        })
        .done(function(response) {
            if(response.status_code == 200){
                $('.cus_alert_msg').append(
                  '<div class="alert alert-success">'+
                    response.msg+
                  '</div>'
                );
                setTimeout(function(){  $('.cus_alert_msg').html(''); }, 5000);
            }
        });
    });
});

$(document).ready(function() {
    $('.neworder').click(function() {
        $('.cus_alert_msg').html('');
        var val = 'False';
       
         $(".statusorder").hide();
        $.ajax({
            type        : 'GET',
            url         : APP_URL + '/branch/neworder/'+val,
            cache : false,
            processData: false
        })
        .done(function(response) {
            if(response.status_code == 200){
               $(".statusorder").hide();
                $('.cus_alert_msg').append(
                  '<div class="alert alert-success">'+
                    response.msg+
                  '</div>'
                );
                setTimeout(function(){  $('.cus_alert_msg').html(''); }, 5000);
                RedirectUrl = APP_URL+'/branch/orders';
                window.location.replace(RedirectUrl);
            }
        });
    });
});


$(document).ready(function() {

    var idVar = setInterval(() => {
    load_new_pending_orders()
    //$(".statusorder").show();
}, 30000);

    function load_new_pending_orders(view = '') {
        $.ajax({
            type        : 'GET',
            url         : APP_URL + '/branch/neworderchecking/',
            cache : false,
            processData: false
        })
        .done(function(response) {
            if(response.status_code == 200 && response.msg == 'New Pending Order.'){
                
//$(".statusorder").show();
                var audioUrl = APP_URL + '/theme/assets/sounds/tone.mpeg';
                
                new Audio(audioUrl).play(); 
               show_loader();

               let pending_number = $('.order-pending-card-value')
               
               if(pending_number.length > 0){
                $('.order-pending-card-value').text(response.pending_orders)
               }
          
                /*('.cus_alert_msg').append(
                  '<div class="alert alert-success">'+
                    response.msg+
                  '</div>'
                );*/
               // setTimeout(function(){  $('.cus_alert_msg').html(''); }, 5000);
            }
        });
    }
 /*$('.neworder').click(function() {
    clearInterval(idVar);

});    */  
function show_loader(){
    //$("#statusorders").addClass("statusorder");
    // setTimeout(function(){  location.reload(); }, 5000);
    $('.neworder').css( "display","block" );
   //$(".statusorder").show();
}  
});

