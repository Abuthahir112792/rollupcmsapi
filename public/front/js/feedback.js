$(document).ready(function () {

    /*get_feedback_details();
    function get_feedback_details() {
        show_loader();
        var token = window.localStorage.getItem('token');
        $.ajax({
            type        : 'GET',
            url         : APP_URL + '/api/get/feedback/detail/'+LANGUAGE,
            headers     : {"Authorization": 'Bearer '+token}
        }).done(function(response) {
            if(response.status == 1){
                $('#feedback_description').val(response.data.feedback_description);
                $('#feedback_rate').val(response.data.feedback_rate);
                for(var j=0;j<response.data.feedback_rate;j++){
                 $(".fa-star").each(function() {
                    var pfallowanceid = $(this).attr("data-index");
                    if(response.data.feedback_rate==pfallowanceid){
                        $(".fa-star:eq("+j+")").css("color","orange");
                    }
                 });
              }
                //tester();
            }else{
                var url = '';
                notification(response.message,url);
            }
            remove_loader();
        });
    }*/
var ratedIndex = -1;
       $(".fa-star").on('click', function(){
            ratedIndex = parseInt($(this).data('index'));
            $("#feedback_rate").val(ratedIndex);
           });
           
           $(".fa-star").mouseover(function(){
            resetStarcolors();
             currentIndex = parseInt($(this).data('index'));
             for(var i=0; i<currentIndex; i++)
                $(".fa-star:eq("+i+")").css("color","orange");
            });

           $(".fa-star").mouseleave(function(){
            resetStarcolors();
           if(ratedIndex != -1)  
             for(var i=0; i<ratedIndex; i++)
                $(".fa-star:eq("+i+")").css("color","orange");
            });  
           function resetStarcolors(){
        $(".fa-star").css("color","black");
       }
    

    $('#userfeedback').click(function () {
        show_loader();
        var token = window.localStorage.getItem('token');
        var user_id = $('#user_id').val();
        var feedback_rate = $('#feedback_rate').val();
        var feedback_description = $('#feedback_description').val();
        $.ajax({
            type        : 'POST',
            url         : APP_URL + '/api/feedback/'+LANGUAGE,
            data        : {user_id : user_id,feedback_rate : feedback_rate,feedback_description : feedback_description},
            headers     : {"Authorization": 'Bearer '+token}
        }).done(function(response) {
            var url = '';
            if(response.status == 1){
                cache_clear();
                url = APP_URL+'/feedback';
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
