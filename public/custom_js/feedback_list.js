
$('.loder_cla').removeClass('div_hide');

jQuery(document).ready( function() {
    var feedbackList = getAjaxData('admin/feedback-list', {});
    
    feedbackList.then(function(data){
        $('#feedbackList').DataTable( {
            data: data,
            columns: [
                { title: "Feedback Date" },
                { title: "Name" },
                { title: "Mobile Number" },
                { title: "Rating" },
                { title: "Description" },
                { title: "Action" },
            ],
            "columnDefs": [{
                targets: -1,
                render : function (data, type, row) {
                    return '<a href="javascript:" style="background: #e20909;" class="delete-feedback" title="Delete" data-id="'+data+'"><i class="fa fa-trash" aria-hidden="true"></i></a>'    
                }
            }]
        });
    });

    $(document).on('click','.delete-feedback',function(e){
        deleted_row = $(this).parents("tr")
        $("#delete_feedback_id").val($(this).data('id'));
        $("#delete-modal").modal();
        return false;
    });

    $(document).on('click','.delete-confirm',function(e){
        var feedback_id = $("#delete_feedback_id").val();
       
        return fetch(APP_URL+'/admin/delete/feedback/'+feedback_id,{
            method: 'GET', // *GET, POST, PUT, DELETE, etc.
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
                "Accept" : "application/json",
                "Authorization" : "Bearer "+localStorage.getItem('access_token'),
            },
            dataType: 'json'
          }).then(function(data){
            if(data.status == 200){
                window.location.href = APP_URL+'/admin/adminfeedback';
            }
            
          }).catch(function(error){
            boostNotify("Oops something wrong.", "danger");
          });

    });

});
$('.loder_cla').addClass('div_hide');
