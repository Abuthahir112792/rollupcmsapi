
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

    var product_list_tbl = getAjaxData('admin/all-product-list', {});
    
    product_list_tbl.then(function(data){
        $('#product_list_table').DataTable( {
            data: data,
            "order": [[ 0, "desc" ]],
            columns: [
                { title: "<input type='checkbox' id='selectAll'></input>"},
                { title: "Product Date" },
                { title: "Product Image" },
                { title: "Product Name" },
                { title: "Category Name" },
                { title: "Product Description" },
                { title: "Product Price" },
                { title: "Product Status" },
                { title: "Action" },
            ],
            "columnDefs": [{
                targets: -1,
                render : function (data, type, row) {
                    return '<a style="background: #090c2f;" class="edit_product" title="Edit" data-id="'+data+'"><i class="fa fa-pencil" aria-hidden="true"></i></a><br><a style="background: red;" class="delete-product" title="Delete" data-id="'+data+'"><i class="fa fa-trash" aria-hidden="true"></i></a>'    
                }
            },{
                targets: 0,
                "visible": true,
                "searchable": false,
                render : function (data, type, row) {
                    return '<input type="checkbox" class="check_print check_pro" value="'+data+'">'    
                }
            },{
                targets: 7,
                render : function (data, type, row) {
                    var checked = '';
                    var arr = data.split('-');
                    if(arr[0]== 'Active'){
                         checked = 'checked';
                    }
                    return '<label class="switch"><input type="checkbox" data-id="'+arr[1]+'" class="product_status_check" '+checked+'><span class="slider round"></span></label>'    
                }
            },{
                targets: 2,
                render : function (data, type, row) {
                    return '<img style="width: 110px;" src="'+APP_URL+'/cms_media/productimage/'+data+'" alt="image"/>'    
                }
            }]
        });
    });

    

    $(document).on('click','.edit_product',function(e){

        var id = $(this).data('id');
        $.ajax({
                type        : 'GET',
                url         : APP_URL + '/admin/product/details/'+id,
                cache : false,
                processData: false
            })
            .done(function(response) {
                if(response.status_code == 200){
                        resetIncomingProduct();
                        $("#product_update_id").val(id);
                        $('.category_id').html(response.productoutput);
                        $(".title").val(response.data.title);
                        $(".category_id").val(response.data.category_id).attr('selected','selected'); 
                        $(".product_description").val(response.data.product_description);
                        $(".product_price").val(response.data.product_price);
                        $('#img_product').attr('src', APP_URL + '/cms_media/productimage/'+response.data.image_url);
                        $('#image_url').val(response.data.image_url);
                        $("input[name='product_status'][value='"+response.data.product_status+"']").prop('checked', true);
                        $("#incoming-product-modal").modal(); 
                }
            });
        return false;
    });

});
$('.loder_cla').addClass('div_hide');

$(document).on('click','#add-product-modal',function(e){
       resetIncomingProduct();
       $.ajax({
                type        : 'GET',
                url         : APP_URL + '/admin/productcategory/details',
                cache : false,
                processData: false
            })
         .done(function(response) {
                
                   $('.category_id').html(response);
                   $("#incoming-product-modal").modal(); 
                
            });
       
    });

    $(document).on('change','.product_status_check',function(e){
    
        $('.alert-status').html('');

        var id = $(this).data('id');
        var val = "Inactive";
        if(this.checked == true){
            val = "Active";
        }
        $.ajax({
            type        : 'GET',
            url         : APP_URL + '/admin/product-status-check/'+id+'/'+val,
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

    $(document).on("click",".upload_imagetest",function(){
        $('#img_product').html("");
        $('#image_url').html("");
        $("#uploadFile").unbind("change");
            $("#uploadFile").trigger('click').on("change",function(){
        var total_file=document.getElementById("uploadFile").files.length;
        if(total_file > 0){
            for(var i=0;i<total_file;i++)
            {
                var imageType = event.target.files[i].type;
                if(imageType == "image/jpeg" || imageType == "image/jpg" || imageType == "image/gif" || imageType == "image/png")
                   
                $('#img_product').attr('src', URL.createObjectURL(event.target.files[i]));
                $('#image_url').val(event.target.files[i].name); 
            }    
        } 
        });
    });

    $(document).on('click','.delete-product',function(e){
        $("#delete_product_id").val($(this).data('id'));
        $("#delete-product-modal").modal();
        return false;
    });

    $(document).on('click','.delete-product-yes',function(e){
        var product_id = $("#delete_product_id").val();
        if(product_id != ''){
            return fetch(APP_URL+'/admin/delete/product/'+product_id,{
                method: 'GET', // *GET, POST, PUT, DELETE, etc.
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    "Accept" : "application/json",
                    "Authorization" : "Bearer "+localStorage.getItem('access_token'),
                },
                dataType: 'json'
            }).then(function(data){
                if(data.status == 200){
                    window.location.href = APP_URL+'/admin/product';
                        location.reload();
                }
            }).catch(function(error){
                boostNotify("Oops something wrong.", "danger");
            });
        }else{
            boostNotify("Oops something wrong.", "danger");
        }
    });

    $(document).on('click','#selectAll',function(e){
    $(".check_print").prop('checked', this.checked);
    });

    $(document).on('click','#delete-product-multi',function(e){
        if($(".check_pro:checked").length < 0){
            alert("Please Select atleast one checkbox");
            return false;
        }
        var mulproductids = $(".check_pro:checked").map(function(){
            //alert(mulproductids);
            return $(this).val();
        }).get().join(",");
        $("#muldelete_product_id").val(mulproductids);
        $("#muldelete-product-modal").modal();
       
    });

    $(document).on('click','.muldelete-product-yes',function(e){
       var muldelete_product_id =  $("#muldelete_product_id").val();
       if(muldelete_product_id != ''){
            return fetch(APP_URL+'/admin/multiproduct/'+muldelete_product_id,{
                method: 'GET', // *GET, POST, PUT, DELETE, etc.
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    "Accept" : "application/json",
                    "Authorization" : "Bearer "+localStorage.getItem('access_token'),
                },
                dataType: 'json'
            }).then(function(data){
                if(data.status == 200){
                    window.location.href = APP_URL+'/admin/product';
                        location.reload();
                }
            }).catch(function(error){
                boostNotify("Oops something wrong.", "danger");
            });
        }else{
            boostNotify("Oops something wrong.", "danger");
        }
       
    });

function resetIncomingProduct(){
    $("#product_update_id").val('');
    $(".title").val('');
    $(".product_description").val('');
    $(".product_price").val('');
    $("option[name='category_id'][value='']").prop('selected', true);                   
    $("input[name='product_status'][value='Active']").prop('checked', true);
}


