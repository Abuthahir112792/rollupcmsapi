
$('.loder_cla').removeClass('div_hide');

jQuery(document).ready( function() {

    $("#myTab a").click(function(e){
        e.preventDefault();
        $(this).tab('show');
    });

    if(location.hash) {
        $('a[href="'+location.hash+'"]').click();
        window.location.hash = '';
    }
    var incoming_order_table = getAjaxData('branch/incoming-orders', {});
    incoming_order_table.then(function(data){
        //console.log(data); 
        $('#incoming_order_table').DataTable( {
            data: data,
            "order": [[ 0, "desc" ]],
            columns: [
                { title: "ID" },
                { title: "Order Date" },
                { title: "Order Id" },
                { title: "User Name" },
                { title: "Description" },
                { title: "Price" },
                { title: "Status" },
                { title: "Phone" },
                { title: "Address" },
                { title: "Self Pickup" },
                { title: "Latitude" },
                { title: "Longitude" },
                { title: "Action" },
            ],
            "columnDefs": [{
                targets: -1,
                render : function (data, type, row) {
                    return '<a style="background: blue;" class="edit_order1" title="Edit" data-type="incoming_order" data-id="'+data+'"><i class="fa fa-pencil" aria-hidden="true"></i></a><br><a style="background: green;" class="view_order" title="View" data-id="'+data+'"><i class="fa fa-eye" aria-hidden="true"></i></a>'    
                }
            },{
                targets: 9,
                render : function (data, type, row) {
                    if(data == 'True'){
                    return '<button class="button" style="font-size:1.2rem; background-color: red;border: none;color: white;padding: 10px 20px;text-align: center;text-decoration: none;display: inline-block;margin: 4px 2px;cursor: default;border-radius: 20px;">Self Pickup</button>'
                    }
                    else{
                       return '' 
                    }    
                }
            },{
                targets: 6,
                render : function (data, type, row) {
                    var arr = data.split('-');
                    $(".ordersids").val(arr[0]).attr('selected','selected');
                    return '<select style="border:none;" class="ordersids" id="ordersids" name="ordersids" data-id="'+arr[1]+'"><option value="">Select</option><option value="Pending">Pending</option><option value="Accepted">Accepted</option><option value="Rejected">Rejected</option></select>'
                }
            },{
                "targets": [ 0,8 ],
                "visible": false,
                "searchable": false
            }]
            
        });
    });

    var out_for_delivery_tbl = getAjaxData('branch/out-for-delivery', {});
    
    out_for_delivery_tbl.then(function(data){
        $('#out_for_delivery_tbl').DataTable( {
            data: data,
            "order": [[ 0, "desc" ]],
            columns: [
                { title: "ID" },
                { title: "Order Date" },
                { title: "Order Id" },
                { title: "User Name" },
                { title: "Description" },
                { title: "Price" },
                { title: "Status" },
                { title: "Phone" },
                { title: "Address" },
                { title: "Latitude" },
                { title: "Longitude" },
                { title: "Action" },
            ],
            "columnDefs": [{
                targets: -1,
                render : function (data, type, row) {
                    return '<a style="background: blue;" class="edit_order1" title="Edit" data-type="incoming_order" data-id="'+data+'"><i class="fa fa-pencil" aria-hidden="true"></i></a><br><a style="background: green;" class="view_order" title="View" data-id="'+data+'"><i class="fa fa-eye" aria-hidden="true"></i></a>'    
                }
            },{
                targets: 6,
                render : function (data, type, row) {
                    var arr = data.split('-');
                    $(".ordersids1").val(arr[0]).attr('selected','selected');
                    return '<select style="border:none;" class="ordersids ordersids1" id="ordersids1" name="ordersids" data-id="'+arr[1]+'"><option value="">Select</option><option value="Accepted">Accepted</option><option value="Completed">Completed</option><option value="Not Completed">Not Completed</option></select>'
                }
            },{
                "targets": [ 0,8 ],
                "visible": false,
                "searchable": false,
            }]
        });
    });

    var self_pickup_tbl = getAjaxData('branch/self-pickup', {});
    
    self_pickup_tbl.then(function(data){
        $('#self_pickup_tbl').DataTable( {
            data: data,
            "order": [[ 0, "desc" ]],
            columns: [
                { title: "ID" },
                { title: "Order Date" },
                { title: "Order Id" },
                { title: "User Name" },
                { title: "Description" },
                { title: "Price" },
                { title: "Status" },
                { title: "Phone" },
                { title: "Address" },
                { title: "Latitude" },
                { title: "Longitude" },
                { title: "Action" },
            ],
            "columnDefs": [{
                targets: -1,
                render : function (data, type, row) {
                    return '<a style="background: blue;" class="edit_order1" title="Edit" data-type="incoming_order" data-id="'+data+'"><i class="fa fa-pencil" aria-hidden="true"></i></a><br><a style="background: green;" class="view_order" title="View" data-id="'+data+'"><i class="fa fa-eye" aria-hidden="true"></i></a>'    
                }
            },{
                targets: 6,
                render : function (data, type, row) {
                    var arr = data.split('-');
                    $(".ordersids2").val(arr[0]).attr('selected','selected');
                    return '<select style="border:none;" class="ordersids ordersids2" id="ordersids2" name="ordersids" data-id="'+arr[1]+'"><option value="">Select</option><option value="Accepted">Accepted</option><option value="Completed">Completed</option><option value="Not Completed">Not Completed</option></select>'
                }
            },{
                "targets": [ 0,8 ],
                "visible": false,
                "searchable": false
            }]
           
        });
    });

    /*$(document).on('click','.edit_order1',function(e){

        var id = $(this).data('id');
        var type = $(this).data('type');
        $.ajax({
                type        : 'GET',
                url         : APP_URL + '/branch/order/details/'+id,
                cache : false,
                processData: false
            })
            .done(function(response) {
                if(response.status_code == 200){
                    if(response.data.order_status == "Canceled"){
                        $("#cancelnotification_modal").modal();
                        $(".canceltheorder").html("The order has been canceled by the customer");
                    }
                    else{
                    if(type == 'incoming_order'){
                        resetIncomingOrder();
                        $("#inc_order_update_id").val(id);
                        $(".inc_order_id").html(response.data.order_id);
                        $(".inc_order_desc").html(response.data.order_description);
                        $(".inc_order_price").val(response.data.order_price);
                        $("input[name='inc_order_status'][value='"+response.data.order_status+"']").prop('checked', true);
                        $(".inc_order_comment").val(response.data.order_comment);
                        $("#incoming-order-modal").modal();
                    } else if(type == 'out_for_delivery_order'){
                        resetOutForDeliveryOrder();
                        $("#out_order_update_id").val(id);
                        $(".out_order_id").html(response.data.order_id);
                        $(".out_order_desc").html(response.data.order_description);
                        $(".out_order_price").html(response.data.order_price);
                        $("input[name='out_order_status'][value='"+response.data.order_status+"']").prop('checked', true);
                        $(".out_order_comment").val(response.data.order_comment);
                        $("#out-for-delivery-order").modal();
                    }
                }
                }
            });
        return false;
    });*/

    $(document).on('click','.edit_order1',function(e){

        var id = $(this).data('id');
        window.location.href = APP_URL+'/branch/editorder/'+id;
    });

        $(document).on('click','.view_order',function(e){

        var id = $(this).data('id');
        $.ajax({
                type        : 'GET',
                url         : APP_URL + '/branch/orderitem/details/'+id,
                cache : false,
                processData: false
            })
            .done(function(response) {
                if(response.status_code == 200){
                    var html = '';
                    var html1 = '';
                
                    html += '<table style="width:70%;border: 1px solid black;border-collapse: collapse;">\n' +
                            '<tr style="border: 1px solid black;border-collapse: collapse;padding: 5px;text-align: left;">\n' +
                                '<th style="padding: 15px;text-align: left;"><b>Customer Details</b></th>\n' + 
                                '<th style="padding: 15px;text-align: left;"></th>\n' + 
                            '</tr>\n' +
                            '<tr style="border: 1px solid black;border-collapse: collapse;padding: 5px;text-align: left;">\n' +
                                '<th style="padding: 15px;text-align: left;"><b>User Name:</b></th>\n' + 
                                '<th style="padding: 15px;text-align: left;">'   +response.getOrders.user_name+'</th>\n' + 
                            '</tr>\n' +
                            '<tr style="border: 1px solid black;border-collapse: collapse;padding: 5px;text-align: left;">\n' +
                                 '<th style="padding: 15px;text-align: left;"><b>Mobile No:</b></th>\n' + 
                                 '<th style="padding: 15px;text-align: left;">'   +response.getOrders.mobile_number+'</th>\n' +
                            '</tr>\n' +
                            '</table>';
                    $('#Orderitem_details').DataTable( {
                        data: response.data,
                        paging: false,
                        searching: false,
                        bInfo : false,
                        destroy: true,
                    columns: [
                        { title: "ID" },
                        { title: "Item Name" },
                        { title: "Price" },
                        { title: "Quantity" },
                        { title: "Sub Total" },
                    ],
                    "columnDefs": []
                    });
                    html1 += '<table style="width:100%;border: 1px solid black;border-collapse: collapse;background-color: black;color:white">\n' +
                            '<tr style="border: 1px solid black;border-collapse: collapse;padding: 5px;text-align: left;">\n' +
                                '<td style="border: 1px solid black;border-collapse: collapse;padding: 15px;text-align: left;">Status:</th>\n' +
                                '<td style="border: 1px solid black;border-collapse: collapse;padding: 15px;text-align: left;">'   +response.getOrders.order_status+'</th>\n' + 
                                '<td style="border: 1px solid black;border-collapse: collapse;padding: 15px;text-align: left;">Total Items:</th>\n' + 
                                '<td style="border: 1px solid black;border-collapse: collapse;padding: 15px;text-align: left;">'   +response.getOrderscount+'</th>\n' +  
                            '</tr>\n' +
                            '<tr style="border: 1px solid black;border-collapse: collapse;padding: 5px;text-align: left;">\n' +
                                 '<th style="border: 1px solid black;border-collapse: collapse;padding: 15px;text-align: left;"></th>\n' +
                                 '<th style="border: 1px solid black;border-collapse: collapse;padding: 15px;text-align: left;"></th>\n' +
                                 '<th style="border: 1px solid black;border-collapse: collapse;padding: 15px;text-align: left;">Amount:</th>\n' +
                                 '<th style="border: 1px solid black;border-collapse: collapse;padding: 15px;text-align: left;">'   +response.getOrders.order_price+'</th>\n' +
                            '</tr>\n' +
                            '</table>';   
                    $('#user_details').html(html);
                    $('#allorder_details').html(html1);
                    $('.all_order_id').html(response.getOrders.order_id);
                    $("#orderitems-modal").modal();
                }
            });
        return false;
    });

});
$('.loder_cla').addClass('div_hide');

function resetIncomingOrder(){
    $("#inc_order_update_id").val('');
    $(".inc_order_id").html('');
    $(".inc_order_desc").html('');
    $(".inc_order_price").val('');
    $("input[name='inc_order_status'][value='Pending']").prop('checked', true);
    $(".inc_order_comment").val('');
    $( "#incoming_order_form" ).valid();
}

function resetOutForDeliveryOrder(){
    $("#out_order_update_id").val('');
    $(".out_order_id").html('');
    $(".out_order_desc").html('');
    $(".out_order_price").html('');
    $(".out_order_comment").val('');
    $("input[name='out_order_status'][value='Completed']").prop('checked', true);
}

$(document).on('change','.ordersids',function(e){
    
        $('.alert-status').html('');

        var id = $(this).data('id');
        var Status = $(this).val();
        $.ajax({
            type        : 'GET',
            url         : APP_URL + '/branch/orderstatus/'+id+'/'+Status,
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
                window.location.reload();
            }
        });
    });

$(document).on('click','.swift_order',function(e){
        var order_id = $(this).data('id');
        let message = 'Are you sure you want swift the order'

        $.ajax({
                type        : 'GET',
                url         : APP_URL + '/branch/branch/details/'+order_id,
                cache : false,
                processData: false
            })
         .done(function(response) {
                
                   $('.branch_id').html(response);
                   $('#swift_order_message').text(message);
        $('#swift_order_orderid').val(order_id);
        $('#swift_order_modal').modal();
                
            });
        
        
    });

$(function() {
  $("#incoming_order_form").validate({
    rules: {
      inc_order_price: {
        // required: true,
        number: true
      },
      action: "required"
    },
    messages: {
      inc_order_price: {
        required: "Please enter price",
        minlength: "Your data must be at least 8 characters"
      }
    }
  });
});

