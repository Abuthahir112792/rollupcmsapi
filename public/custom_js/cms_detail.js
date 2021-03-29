
$('.loder_cla').removeClass('div_hide');

//CKEDITOR.replace('editor1');

// privacy policy ck-editor
ClassicEditor
.create(document.querySelector('#privacy_editor1'),{
    //toolbar: [ 'bold', 'italic', 'link' ]
})
.catch( error => {
    console.error( error );
} );


//term and condition ck-editor
ClassicEditor
.create(document.querySelector('#term_editor1'),{
    
})
.catch( error => {
    console.error( error );
} );


jQuery(document).ready( function() {

    $("#myTab a").click(function(e){
        e.preventDefault();
        $(this).tab('show');
    });

    if(location.hash) {
        $('a[href="'+location.hash+'"]').click();
        window.location.hash = '';
    }

    $("#uploadFile").change(function(){
        $('#image_preview').html("");
        var total_file=document.getElementById("uploadFile").files.length;
        if(total_file > 0){
            for(var i=0;i<total_file;i++)
            {
                var imageType = event.target.files[i].type;
                if(imageType == "image/jpeg" || imageType == "image/jpg" || imageType == "image/gif" || imageType == "image/png")
                    $('#image_preview').append("<div class='separate_image'><img src='"+URL.createObjectURL(event.target.files[i])+"'></div>");
            }    
        } 
    });

    $("#uploadLogo").change(function(){
        $('#logo_upload_preview').html("");
        var total_file=document.getElementById("uploadLogo").files.length;
        if(total_file > 0){
            for(var i=0;i<total_file;i++)
            {
                var imageType = event.target.files[i].type;
                if(imageType == "image/jpeg" || imageType == "image/jpg" || imageType == "image/gif" || imageType == "image/png")
                    $('#logo_upload_preview').append("<div class='separate_image'><img src='"+URL.createObjectURL(event.target.files[i])+"'></div>");
            }    
        } 
    });

    $(document).on('click','.delete-image',function(e){
        $("#delete_image_id").val($(this).data('id'));
        $("#delete_type").val($(this).data('type'));
        $("#delete-image-modal").modal();
        return false;
    });

    $(document).on('click','.delete-confirm-yes',function(e){
        var media_id = $("#delete_image_id").val();
        var delete_type = $("#delete_type").val();
        if(media_id != ''){
            return fetch(APP_URL+'/admin/delete/media/'+media_id,{
                method: 'GET', // *GET, POST, PUT, DELETE, etc.
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    "Accept" : "application/json",
                    "Authorization" : "Bearer "+localStorage.getItem('access_token'),
                },
                dataType: 'json'
            }).then(function(data){
                if(data.status == 200){
                    if(delete_type == 'video'){
                        window.location.href = APP_URL+'/admin/cms#video';
                        location.reload();
                    }else if(delete_type == 'logo'){
                        window.location.href = APP_URL+'/admin/cms#logo';
                        location.reload();
                    }else{
                        window.location.href = APP_URL+'/admin/cms';    
                    }
                }
            }).catch(function(error){
                boostNotify("Oops something wrong.", "danger");
            });
        }else{
            boostNotify("Oops something wrong.", "danger");
        }
    });

});
$('.loder_cla').addClass('div_hide');
