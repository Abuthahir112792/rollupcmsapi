
$('.loder_cla').removeClass('div_hide');

jQuery(document).ready( function() {
    
var editorderid = $('.editorderid').val();
get_orderlist_list(editorderid);
//alert(ididid);
    $("#myTab a").click(function(e){
        e.preventDefault();
        $(this).tab('show');
    });

    if(location.hash) {
        $('a[href="'+location.hash+'"]').click();
        window.location.hash = '';
    }
    var all_orderlist_table = getAjaxData('admin/all-orders-list/'+editorderid, {});
    all_orderlist_table.then(function(data){
        $('#allorderList').DataTable( {
            data: data,
            paging: false,
            searching: false,
            bInfo : false,
            destroy: true,
            "order": [[ 0, "desc" ]],
            columns: [
                { title: "ID" },
                { title: "Name" },
                { title: "Price" },
                { title: "Quantity" },
                { title: "Sub Total" },
            ],
            "columnDefs": [{
                targets: 3,
                render : function (data, type, row) {
                    var arr = data.split('-');
                    return '<input type="Number" name="qty" id="qty" class="form-control qty" min="0" data-id="'+arr[1]+'" value="'+arr[0]+'">'    
                }
            },{
                targets: 4,
                render : function (data, type, row) {
                    var arr = data.split('-');
                    return '<span id="sub_total" name="sub_total" class="sub_total'+arr[1]+'">'+arr[0]+'</span>'    
                }
            },{
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            }]
        });
    });

    function get_orderlist_list(editorderid) {
        $.ajax({
                type        : 'GET',
                url         : APP_URL + '/admin/get_userorderlist_list/details/'+editorderid,
                cache : false,
                processData: false
            })
            .done(function(response) {
                if(response.status_code == 200){
                    $(".order_list_update_id").val(editorderid);
                    $(".name").html(response.getOrdersuser.user_name);
                    $(".mobile_no").html(response.getOrdersuser.mobile_number);
                    $(".total_items").html(response.getOrdersusercount);
                    $(".total_amount").val(response.getOrdersuser.order_price);
                    $("input[name='orders_status'][value='"+response.getOrdersuser.order_status+"']").prop('checked', true);
                    $(".order_comment").val(response.getOrdersuser.order_comment);
                    $(".order_des").val(response.getOrdersuser.order_description);
                    $(".userorder_id").html(response.getOrdersuser.order_id);
                }
            });
    }
});
$('.loder_cla').addClass('div_hide');

        $(document).on('keyup','.qty',function(e){
           $('.alert-status').html('');
            var qty = $(this).val();
            var itemid = $(this).data('id');
            var editorderid = $('.editorderid').val();
            $.ajax({
            type        : 'GET',
            url         : APP_URL + '/admin/updateallorderdetails/'+editorderid+'/'+itemid+'/'+qty,
            cache : false,
            processData: false
        })
        .done(function(response) {
            if(response.status_code == 200){
                $(".total_amount").val(response.totalprice);
                $(".sub_total"+itemid).html(response.subtotal);
                $(".total_items").html(response.totalitem);
            }
            else{
                $('.cus_alert_msg').append(
                  '<div class="alert alert-success">'+
                    response.msg+
                  '</div>'
                );
                setTimeout(function(){  $('.cus_alert_msg').html(''); }, 5000);
            }
        });
    });

        $(document).on('change','.qty',function(e){
           $('.alert-status').html('');
            var qty = $(this).val();
            var itemid = $(this).data('id');
            var editorderid = $('.editorderid').val();
            $.ajax({
            type        : 'GET',
            url         : APP_URL + '/admin/updateallorderdetails/'+editorderid+'/'+itemid+'/'+qty,
            cache : false,
            processData: false
        })
        .done(function(response) {
            if(response.status_code == 200){
                $(".total_amount").val(response.totalprice);
                $(".sub_total"+itemid).html(response.subtotal);
                $(".total_items").html(response.totalitem);
            }
            else{
                $('.cus_alert_msg').append(
                  '<div class="alert alert-success">'+
                    response.msg+
                  '</div>'
                );
                setTimeout(function(){  $('.cus_alert_msg').html(''); }, 5000);
            }
        });
    });
/*$(document).on('keyup','.qty',function(e){
        
            var qty = $('.qty').val().trim().length;
            alert(qty);
            
                $(".total_items").html('4');
            
        });*/