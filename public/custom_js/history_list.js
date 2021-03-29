$('.loder_cla').removeClass('div_hide');



    $(document).on('click','.view_history',function(e){

        var id = $(this).attr('id');
        $.ajax({
                type        : 'GET',
                url         : APP_URL + '/admin/historyorderitem/details/'+id,
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
                    $('#historyOrderitem_details').DataTable( {
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
                    $('#historyuser_details').html(html);
                    $('#historyallorder_details').html(html1);
                    $('.historyall_order_id').html(response.getOrders.order_id);
                    $("#historyorderitems-modal").modal();
                }
            });
        return false;
    });


    $(document).ready(function(){

        function clear_icon()
        {
         $('#id_icon').html('');
         $('#post_title_icon').html('');
        }
       
        function fetch_data(page, sort_type, sort_by, query)
        {
         $.ajax({
          url:APP_URL + "/admin/pagination/fetch_data?page="+page+"&sortby="+sort_by+"&sorttype="+sort_type+"&query="+query,
          success:function(data)
          {
           $('tbody').html('');
           $('tbody').html(data);
          }
         })
        }
       
        $(document).on('keyup', '#serach', function(e){
         var query = $('#serach').val();
         var column_name = $('#hidden_column_name').val();
         var sort_type = $('#hidden_sort_type').val();
         var page = $('#hidden_page').val();
         fetch_data(page, sort_type, column_name, query);
        });
       
        /*$(document).on('click', '.sorting', function(){
         var column_name = $(this).data('column_name');
         var order_type = $(this).data('sorting_type');
         var reverse_order = '';
         if(order_type == 'asc')
         {
          $(this).data('sorting_type', 'desc');
          reverse_order = 'desc';
          //clear_icon();
          $('#'+column_name+'_icon').html('<span class="glyphicon glyphicon-triangle-bottom"></span>');
         }
         if(order_type == 'desc')
         {
          $(this).data('sorting_type', 'asc');
          reverse_order = 'asc';
         // clear_icon
          $('#'+column_name+'_icon').html('<span class="glyphicon glyphicon-triangle-top"></span>');
         }
         $('#hidden_column_name').val(column_name);
         $('#hidden_sort_type').val(reverse_order);
         var page = $('#hidden_page').val();
         var query = $('#serach').val();
         fetch_data(page, reverse_order, column_name, query);
        });*/
       
        $(document).on('click', '.pagination a', function(event){
         event.preventDefault();
         var page = $(this).attr('href').split('page=')[1];
         $('#hidden_page').val(page);
         var column_name = $('#hidden_column_name').val();
         var sort_type = $('#hidden_sort_type').val();
       
         var query = $('#serach').val();
       
         $('li').removeClass('active');
               $(this).parent().addClass('active');
         fetch_data(page, sort_type, column_name, query);
        });
       
       });


$('.loder_cla').addClass('div_hide');
