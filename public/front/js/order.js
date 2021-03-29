$(document).ready(function () {
    show_loader();
    get_order_list();
     get_order_details();
    function get_order_list() {
        var token = window.localStorage.getItem('token');
        $.ajax({
            type        : 'GET',
            url         : APP_URL + '/api/order/history/'+LANGUAGE,
            headers     : {"Authorization": 'Bearer '+token}
        }).done(function(response) {
            if(response.status == 1){
                var html = '';
                var shop = response.shop_keeper;
                let data =response.data;
                let count = data.length;
                let result = [];
                let lang = response.lang
                if(count > 0 && lang=='ar'){
                    result = data.map(({order_status,...rest})=>{
                       
                        
                        let status = '';

                        switch(order_status){
                            case 'Accepted':
                                    status = 'قبلت'
                                    break;
                            case 'Pending':
                                    status = 'تم الطلب'
                                    break;
                            case 'Rejected':
                                    status = 'مرفوض'
                                    break;
                            case 'Not Completed':
                                    status = 'غير مكتمل'
                                    break;
                            case 'Cancelled':
                                    status = 'ألغيت'
                                    break;
                            default:
                                    status = 'منجز'
                                    break;
                        }

                        return {
                            order_status:status,
                            ...rest
                        }
                    });
                }else{
                    result = data;
                }
                
                document.getElementById("shop-detail-status").innerHTML=`${lang=='ar'?`تاريخ الطلب - المتجر ${shop==1?'مفتوح':'مغلق'}`:`Order History- Shop is ${shop==1?'Open':'Closed'}`}`


                if(count > 0){
                    $(result).each(function (index,value) {
                        html += '<div class="col-md-6 col-sm-12 order-card order_card_check my-2" data-id="'+value.order_id+'">\n' +
                            '                    <div class="card-container" style="background-color:white">\n' +
                            '                        <div class="order-name w-100">\n' +
                            '                            <span style="font-size: 1.3rem"><b>'+`${lang=='ar'?'طلب':'Order'}`+'</b> #'+value.order_id+'   </span><br/>\n' +
                                                        `${value.order_status=="Pending"||value.order_status=='تم الطلب'?
                                                        '<label style="font-size: 1.1rem;color:#DC143C;left: 25px;">'+`${value.order_status=='Pending'?'Order Placed':value.order_status}`+'</label>\n'
                                                        :''}`+
                                                        `${value.order_status=="Accepted"||value.order_status=='قبلت'?
                                                        '<label style="font-size: 1.1rem;color:#008B8B;left: 25px;">'+value.order_status+'</label>\n'
                                                        :''}`+
                                                        `${value.order_status=="Rejected"||value.order_status=='مرفوض'?
                                                        '<label style="font-size: 1.1rem;color:#808000;left: 25px;">'+value.order_status+'</label>\n'
                                                        :''}`+
                                                        `${value.order_status=="Not Completed"||value.order_status=='غير مكتمل'?
                                                        '<label style="font-size: 1.1rem;color:#00008B;left: 25px;">'+value.order_status+'</label>\n'
                                                        :''}`+
                                                        `${value.order_status=="Cancelled"||value.order_status=='ألغيت'?
                                                        '<label style="font-size: 1.1rem;color:#FF8C00;left: 25px;">'+value.order_status+'</label>\n'
                                                        :''}`+
                                                        `${value.order_status=="Completed"||value.order_status=='منجز'?
                                                        '<label style="font-size: 1.1rem;color:#32CD32;left: 25px;">'+value.order_status+'</label>\n'
                                                        :''}`+
                        
                            '                        </div>\n' +

                                                    '<span class="order-detail-date">'+dateFormater(new Date(value.created_at))+'</span>\n' +
                                                    '<i class="fas fa-archive order-history-arrow"></i>\n'+
                                                    `</div>\n`+
                                                    


                            '                    </div>\n' +
                            '                </div>';
                    });
                }else{
                    html += '<div class="col-md-6 col-sm-12 order-card my-2">\n' +
                        '                    <div class="card-container">\n' +
                        '                        <div class="order-id w-100">\n' +
                        '                            <span>Not Available</span>\n' +
                        '                        </div>\n' +
                        '                    </div>\n' +
                        '                </div>';
                }

                remove_loader();
                $('#main_order_history').html(html);
            }else{
                alert(response.message)
            }
        });
    }

        function get_order_details() {
        var token = window.localStorage.getItem('token');
        var orderids = $('#orderid').val();
        console.log(orderids);
        $.ajax({
            type        : 'GET',
            url         : APP_URL + '/api/order/details/'+orderids+'/'+LANGUAGE,
            headers     : {"Authorization": 'Bearer '+token}
        }).done(function(response) {
            if(response.status == 1){
                var html = '';
                var shop = response.shop_keeper;
                let data =response.data;
                let count = data.length;
                let result = [];
                let lang = response.lang
                if(count > 0 && lang=='ar'){
                    result = data.map(({order_status,...rest})=>{
                       
                        
                        let status = '';

                        switch(order_status){
                            case 'Accepted':
                                    status = 'قبلت'
                                    break;
                            case 'Pending':
                                    status = 'تم الطلب'
                                    break;
                            case 'Rejected':
                                    status = 'مرفوض'
                                    break;
                            case 'Not Completed':
                                    status = 'غير مكتمل'
                                    break;
                            case 'Cancelled':
                                    status = 'ألغيت'
                                    break;
                            default:
                                    status = 'منجز'
                                    break;
                        }

                        return {
                            order_status:status,
                            ...rest
                        }
                    });
                }else{
                    result = data;
                }
                
                //document.getElementById("shop-detail-status").innerHTML=`${lang=='ar'?`تاريخ الطلب - المتجر ${shop==1?'مفتوح':'مغلق'}`:`Order History- Shop is ${shop==1?'Open':'Closed'}`}`


                if(count > 0){
                    $(result).each(function (index,value) {
                        html += '<div class="col-md-6 col-sm-12 order-card my-2">\n' +
                            '                    <div class="card-container" style"height:265px">\n' +
                            '                        <div class="order-id w-100">\n' +
                                                      `<span><b>${lang=='ar'?'تفاصيل الطلب':'Order Details'}</b></span>\n` +
                            
                            '                        </div>\n' +
                            '                        <div class="order-name w-100">\n' +
                            '                            <span style="font-size: 1.2rem"><b>'+`${lang=='ar'?'رقم التعريف الخاص بالطلب':'Order ID'}`+'</b> : '+value.order_id+'   </span><br/>\n' +
                            
                                                        `${(value.order_status=="Completed"||value.order_status=='منجز')?
                            '                            <span style="font-weight: 600;font-size: 1.1rem;color:#40c35e;float:'+`${lang=='ar'?'right':'left'}`+'">'+`${lang=='ar'?value.order_price+' ريال':'PAID QR '+value.order_price+'/-'}`+'</span>\n':''}` +
                            '                            <br/><span style="word-wrap: break-word;">'+value.order_description+'</span>\n' +
                            '                        </div>\n' +


                            
                                                    `<div style="position:reltive;min-height:40px">\n`+
                                                    

                                                    
                                                    '<div class="order-status  w-100 my-2">\n'+

                                                    '<div style="font-size: 1.1rem">\n'+
                                                    `${value.order_status=="Pending"||value.order_status=='تم الطلب'?
                                                        '<label style="color:#DC143C;bottom: 5px;position: absolute;left: 25px;">'+`${value.order_status=='Pending'?'Order Placed':value.order_status}`+'</label>\n'
                                                        :''}`+
                                                        `${value.order_status=="Accepted"||value.order_status=='قبلت'?
                                                        '<label style="color:#008B8B;bottom: 5px;position: absolute;left: 25px;">'+value.order_status+'</label>\n'
                                                        :''}`+
                                                        `${value.order_status=="Rejected"||value.order_status=='مرفوض'?
                                                        '<label style="color:#808000;bottom: 5px;position: absolute;left: 25px;">'+value.order_status+'</label>\n'
                                                        :''}`+
                                                        `${value.order_status=="Not Completed"||value.order_status=='غير مكتمل'?
                                                        '<label style="color:#00008B;bottom: 5px;position: absolute;left: 25px;">'+value.order_status+'</label>\n'
                                                        :''}`+
                                                        `${value.order_status=="Cancelled"||value.order_status=='ألغيت'?
                                                        '<label style="color:#FF8C00;bottom: 5px;position: absolute;left: 25px;">'+value.order_status+'</label>\n'
                                                        :''}`+
                                                        `${value.order_status=="Completed"||value.order_status=='منجز'?
                                                        '<label style="color:#32CD32;bottom: 5px;position: absolute;left: 25px;">'+value.order_status+'</label>\n'
                                                        :''}`+
                                                    '</div>\n'+
                                                        
                                                    '</div>\n'+
                                                    
                                                    '<span style="color: grey;font-size: 1.0rem;position: absolute;bottom: 5px;right: 25px;">'+dateFormater(new Date(value.created_at))+'</span>\n' +
                                                    `</div>\n`+
                                                    


                            '                    </div>\n' +
                           '                </div>\n' +
                            `${(value.order_status=="Pending"||value.order_status=='تم الطلب')||((value.order_status=="Completed"||value.order_status=='منجز') && shop=="1")?'<div class="col-md-6 col-sm-12 order-card my-2">\n' +
                            '                    <div class="card-container">\n' +
                           
                            


                            
                                                    `<div style="position:reltive;min-height:40px">\n`+
                                                    `${value.order_status=="Pending"||value.order_status=='تم الطلب'?
                                                    '<div class="order-status w-100 my-2">\n'+
                                                        `<a class="cancel_order_action" title="Cancel" data-id="${value.order_id}"><button style="width: 140px;" type="button" class="btn btn-danger btn-sm">${lang=='ar'?'إلغاء':'Cancel'}</button></a>\n`+
                                                    '</div>\n':''}`+

                                                    `${((value.order_status=="Completed"||value.order_status=='منجز') && shop=="1")?
                                                    '<div class="order-status  w-100 my-2">\n'+

                                                    '<div style="font-size:0.8rem">\n'+
                                                    `    <input type="radio" class="self_pickup" name="self_pickup-${value.order_id}" id="self_pickup" style="margin-right: 10px;" />${lang=='ar'?'  النفس التقاط  ':'Self Pickup &nbsp&nbsp'}\n`+

                                                    

                                                    `    <input type="radio" class="home_delivery" name="self_pickup-${value.order_id}" id="home_delivery" style="margin-right: 10px;" checked/>${lang=='ar'?'  توصيل منزلي ':'Home Delivery'}<br> \n`+

                                                    `<a class="re_order" title="Reorder" data-id="${value.order_description}"><button style="width: 140px;" type="button" class="btn btn-success btn-sm mt-3">${lang=='ar'?'إعادة ترتيب':'Reorder'}</button></a>\n`+
                                                    '</div>\n'+
                                                        
                                                    '</div>\n':''}`+
                                                    
                                                    `</div>\n`+

                            '                    </div>\n':''}`+
                            '                </div>';
                    });
                }else{
                    html += '<div class="col-md-6 col-sm-12 order-card my-2">\n' +
                        '                    <div class="card-container">\n' +
                        '                        <div class="order-id w-100">\n' +
                        '                            <span>Not Available</span>\n' +
                        '                        </div>\n' +
                        '                    </div>\n' +
                        '                </div>';
                }

                remove_loader();
                $('#main_order_details').html(html);
            }else{
                alert(response.message)
            }
        });
    }
    
    

    $(document).on('click','.order_card_check',function(e){
        
        var order_id = $(this).data('id');
        var url = APP_URL + '/order-details/' + encodeURIComponent(order_id);
        window.location.href = url;
        
    })

    $(document).on('click','.cancel_order_action',function(e){
        show_loader();
       remove_loader();
        var order_id = $(this).data('id');
        let message = 'Are you sure you want cancel the order?'
        cache_clear();
           notification_action(order_id,message);
        
    })

    $(document).on('click','.cancel_order',function(e){
       show_loader();
        var token = window.localStorage.getItem('token');
        var order_id = $('.notification_action_orderid').val();
        $.ajax({
            type        : 'POST',
            url         : APP_URL + '/api/cancel/order/'+LANGUAGE,
            data        : {order_id : order_id},
            headers     : {"Authorization": 'Bearer '+token},
        }).done(function(response) {
            remove_loader();
            var url = '';
            if(response.status == 1){
                let message = 'Order Canceled successfully.'
                cache_clear();
                url = APP_URL+'/order-history';
              
            }
           notification(message,url)
        });
    })

    $(document).on('click','.re_order',function(e){
       show_loader();
        var token = window.localStorage.getItem('token');
        var order_description = $(this).data('id');
        var self_pickup = 'False';
        if($('.self_pickup').is(':checked')){
            var self_pickup = 'True';
        }
       
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
                url = APP_URL+'/order-history';
              
            }
           notification(response.message,url)
        });
    })

    function notification_action(order_id,message) {
        $('#notification_action_message').text(message);
        $('.notification_action_orderid').val(order_id);
        $('#notification_action_modal').modal('show');
    }

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


});



//Date time formater
function dateFormater(d){
    return d.getDate()  + "-" + (d.getMonth()+1) + "-" + d.getFullYear() + " " +
    d.getHours() + ":" + (d.getMinutes() < 10 ? '0' : '') + d.getMinutes();
}

//Modal to cancel the order
