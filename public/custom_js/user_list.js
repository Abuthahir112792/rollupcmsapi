
$('.loder_cla').removeClass('div_hide');

jQuery(document).ready( function() {
    var usersList = getAjaxData('admin/users-list', {});
    
    usersList.then(function(data){
        $('#usersList').DataTable( {
            data: data,
            "order": [[ 0, "desc" ]],
            columns: [
                { title: "ID" },
                { title: "Registration Date" },
                { title: "Name" },
                { title: "Mobile Number" },
                { title: "Email" },
                
            ],
            "columnDefs": [{
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
                }],
            dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'excel',
                    filename: 'User History',
                    title:'',
                    exportOptions: {
                        columns: [ 1, 2, 3, 4 ]
                    }
                },
                {
                    extend: 'print',
                    title: '',
                    exportOptions: {
                        columns: [ 1, 2, 3, 4 ]
                    }
                }
            ]
        });
    });

    $(document).on('click','.delete-user',function(e){
        deleted_row = $(this).parents("tr")
        $("#delete_user_id").val($(this).data('id'));
        $("#delete-modal").modal();
        return false;
    });

    $(document).on('click','.delete-confirm',function(e){
        var user_id = $("#delete_user_id").val();
       
        return fetch(APP_URL+'/admin/delete/user/'+user_id,{
            method: 'GET', // *GET, POST, PUT, DELETE, etc.
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
                "Accept" : "application/json",
                "Authorization" : "Bearer "+localStorage.getItem('access_token'),
            },
            dataType: 'json'
          }).then(function(data){
            if(data.status == 200){
                window.location.href = APP_URL+'/admin/users';
            }
            
          }).catch(function(error){
            boostNotify("Oops something wrong.", "danger");
          });

    });

});
$('.loder_cla').addClass('div_hide');
