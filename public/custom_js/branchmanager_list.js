
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

    var branchusersList = getAjaxData('admin/branchmanage-list', {});
    
    branchusersList.then(function(data){
        $('#branchmanageList').DataTable( {
            data: data,
            "order": [[ 0, "asc" ]],
            columns: [
                { title: "ID" },
                { title: "UserName" },
                { title: "BranchName" },
                { title: "Email" },
                { title: "Status" },
                { title: "Address" },
                { title: "lat" },
                { title: "Long" },
                { title: "Action" },
            
            
            ],
            "columnDefs": [{
                targets: -1,
                render : function (data, type, row) {
                    return '<a style="background: #090c2f;" class="reset_branchmanage" title="Reset" data-id="'+data+'"><i class="fa fa-key" aria-hidden="true"></i></a>'
                }
            },{
                "targets": [ 0,5,6,7 ],
                "visible": false,
                "searchable": false,
                render : function (data, type, row) {
                return '<input type="checkbox" class="catcheck_print catcheck_pro" value="'+data+'">'    
                }    
                },{
                    targets:4,
                    render : function (data, type, row) {
                        var checked = '';
                        var arr = data.split('-');
                        if(arr[0]== 'Active'){
                             checked = 'checked';
                        }
                        return '<label class="switch"><input type="checkbox" data-id="'+arr[1]+'" class="branch_status_check" '+checked+'><span class="slider round"></span></label>'    
                    }
                }]
        });
    });

    

    $(document).on('click','.reset_branchmanage',function(e){

        var id = $(this).data('id');
        $.ajax({
                type        : 'GET',
                url         : APP_URL + '/admin/branchmanage/details/'+id,
                cache : false,
                processData: false
            })
            .done(function(response) {
                if(response.status_code == 200){
                        resetIncomingbranchuser();
                        $("#branch_user_id").val(id);
                        $(".name").val(response.data.name);
                        $(".user_email").val(response.data.email);
                        $(".user_password").val(response.pass);
                        $("#incoming-branchmanage-modal").modal(); 
                }
            });
        return false;
    });

});
$('.loder_cla').addClass('div_hide');



$(document).on('change','.branch_status_check',function(e){
    
    $('.alert-status').html('');

    var id = $(this).data('id');
    var val = "Inactive";
    if(this.checked == true){
        val = "Active";
    }
    $.ajax({
        type        : 'GET',
        url         : APP_URL + '/admin/userbranch-status-check/'+id+'/'+val,
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

function resetIncomingbranchuser(){
    $("#branch_user_id").val('');
    $(".name").val('');
    $(".user_password").val('');
    $(".user_email").val('');
    
}


