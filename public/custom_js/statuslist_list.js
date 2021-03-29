
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

    var statuslist_list_tbl = getAjaxData('admin/all-statuslist-list', {});
    
    statuslist_list_tbl.then(function(data){
        $('#statuslist_list_table').DataTable( {
            data: data,
            "order": [[ 0, "desc" ]],
            columns: [
                { title: "<input type='checkbox' id='selectAllstatus'></input>"},
                { title: "Status Name" },
                { title: "Status Status" },
                { title: "Action" },
            ],
            "columnDefs": [{
                targets: -1,
                render : function (data, type, row) {
                    return '<a style="background: #090c2f;" class="edit_statuslist" title="Edit" data-id="'+data+'"><i class="fa fa-pencil" aria-hidden="true"></i></a><a style="background: red;" class="delete-statuslist" title="Delete" data-id="'+data+'"><i class="fa fa-trash" aria-hidden="true"></i></a>'    
                }
            },{
                targets: 0,
                "visible": true,
                "searchable": false,
                render : function (data, type, row) {
                    return '<input type="checkbox" class="statuslist_print statuslist_pro" value="'+data+'">'    
                }
            },{
                targets: 2,
                render : function (data, type, row) {
                    var checked = '';
                    var arr = data.split('-');
                    if(arr[0]== 'Active'){
                         checked = 'checked';
                    }
                    return '<label class="switch"><input type="checkbox" data-id="'+arr[1]+'" class="statuslist_status_check" '+checked+'><span class="slider round"></span></label>'    
                }
            }]
        });
    });

    

    $(document).on('click','.edit_statuslist',function(e){

        var id = $(this).data('id');
        $.ajax({
                type        : 'GET',
                url         : APP_URL + '/admin/statuslist/details/'+id,
                cache : false,
                processData: false
            })
            .done(function(response) {
                if(response.status_code == 200){
                        resetStatusList();
                        $("#statuslist_update_id").val(id);
                        $(".status_name").val(response.data.status_name);
                        $("input[name='status_status'][value='"+response.data.status_status+"']").prop('checked', true);
                        $("#statuslist-modal").modal(); 
                }
            });
        return false;
    });

});
$('.loder_cla').addClass('div_hide');

$(document).on('click','#add-statuslist-modal',function(e){
       resetStatusList();
       $("#statuslist-modal").modal(); 
    });

    $(document).on('change','.statuslist_status_check',function(e){
    
        $('.alert-status').html('');

        var id = $(this).data('id');
        var val = "Inactive";
        if(this.checked == true){
            val = "Active";
        }
        $.ajax({
            type        : 'GET',
            url         : APP_URL + '/admin/statuslist-status-check/'+id+'/'+val,
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

$(document).on('click','.delete-statuslist',function(e){
        $("#delete_statuslist_id").val($(this).data('id'));
        $("#delete-statuslist-modal").modal();
        return false;
    });

    $(document).on('click','.delete-statuslist-yes',function(e){
        var statuslist_id = $("#delete_statuslist_id").val();
        if(statuslist_id != ''){
            return fetch(APP_URL+'/admin/delete/statuslist/'+statuslist_id,{
                method: 'GET', // *GET, POST, PUT, DELETE, etc.
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    "Accept" : "application/json",
                    "Authorization" : "Bearer "+localStorage.getItem('access_token'),
                },
                dataType: 'json'
            }).then(function(data){
                if(data.status == 200){
                    window.location.href = APP_URL+'/admin/statuslist';
                }
            }).catch(function(error){
                boostNotify("Oops something wrong.", "danger");
            });
        }else{
            boostNotify("Oops something wrong.", "danger");
        }
    });

    $(document).on('click','#selectAllstatus',function(e){
    $(".statuslist_print").prop('checked', this.checked);
    });

    $(document).on('click','#delete-statuslist-multi',function(e){
        if($(".statuslist_pro:checked").length < 0){
            alert("Please Select atleast one checkbox");
            return false;
        }
        var mulstatuslistids = $(".statuslist_pro:checked").map(function(){
            //alert(mulcategoryids);
            return $(this).val();
        }).get().join(",");
        $("#muldelete_statuslist_id").val(mulstatuslistids);
        $("#muldelete-statuslist-modal").modal();
       
    });

    $(document).on('click','.muldelete-statuslist-yes',function(e){
       var muldelete_statuslist_id =  $("#muldelete_statuslist_id").val();
       if(muldelete_statuslist_id != ''){
            return fetch(APP_URL+'/admin/multistatuslist/'+muldelete_statuslist_id,{
                method: 'GET', // *GET, POST, PUT, DELETE, etc.
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    "Accept" : "application/json",
                    "Authorization" : "Bearer "+localStorage.getItem('access_token'),
                },
                dataType: 'json'
            }).then(function(data){
                if(data.status == 200){
                    window.location.href = APP_URL+'/admin/statuslist';
                        location.reload();
                }
            }).catch(function(error){
                boostNotify("Oops something wrong.", "danger");
            });
        }else{
            boostNotify("Oops something wrong.", "danger");
        }
       
    });

function resetStatusList(){
    $("#statuslist_update_id").val('');
    $(".status_name").val('');
    $("input[name='status_status'][value='Active']").prop('checked', true);
}


