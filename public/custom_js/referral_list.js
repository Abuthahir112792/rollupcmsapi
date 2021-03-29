
$('.loder_cla').removeClass('div_hide');

jQuery(document).ready( function() {
    var referralList = getAjaxData('admin/referral-list', {});
    
    referralList.then(function(data){
        $('#referralList').DataTable( {
            data: data,
            "order": [[ 3, "desc" ]],
            columns: [
                { title: "Referral Date" },
                { title: "Name" },
                { title: "Mobile Number" },
                { title: "Member Referral" },
                
            ],
            "columnDefs": [{
                
            }]
        });
    });

 

});
$('.loder_cla').addClass('div_hide');
