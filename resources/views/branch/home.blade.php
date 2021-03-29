@extends('branch.layouts1.app')
@section('page_css')

@endsection
@section('title')
    Rollup | Dashboard
@stop
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js">
<style type="text/css">
    .header-sub-title {
    border-left: 10px solid #00AAFF !important;
    font-weight: 700;
    background: #252c35;
    border-top: 1px solid #ececec;
    border-bottom: 1px solid #ececec;
    display: inline-block;
    margin-bottom: 10px;
    padding: 12px 7px;
    width: 100%;
    font-size: 16px;
    color: #fff !important;
    border-right: 1px solid #ececec;
}
#usersList td, #usersList th {
  border: 1px solid #ddd;
  padding: 8px;
}
</style>
@section('content')
    <div class="main-content">
        <div class="container-fluid">
            <h4 class="header-sub-title">Dashboard</h4>

            <div class="row" style="margin:20px 0px">
                <div class="col-sm-4">
                    <div class="panel">
                    <div class="panel-heading">
                        <p class="card-text">Pending Orders</p>
                        <h3 class="card-title order-pending-card-value"><?php echo $data['pendingorderscount'];?></h3>
                    </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="panel">
                    <div class="panel-heading">
                        <p class="card-text">Out For Delivery</p>
                        <h3 class="card-title"><?php echo $data['our_for_delivery'];?></h3>
                    </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="panel">
                    <div class="panel-heading">
                        <select class="form-control" id="sales_history" class="sales_history" style="margin: -9px;">
                        <option value="today_sale">Today Sales</option>
                        <option value="total_sale">Monthly Sales</option>
                        </select>
                        <h3 class="card-title salesdetails" id="card-title"><?php echo $data['total_amount'];?> QAR</h3>
                    </div>
                    </div>
                </div>
            </div>

            <div class="row" style="margin:20px 0px">
               
                <div class="col-sm-12">
                    <div class="panel" >
                    <div class="panel-heading">
                        <h4 class="card-title">Complete Orders - <?php echo date('Y')?></h4>
                    </div>

                    <div class="panel-body">
                    <canvas id="chLine"></canvas>
                    </div>
                    
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection

@section('page_js')

    <script>

        $(document).ready(function(){
            $('.loder_cla').addClass('div_hide');
        });

        $(document).ready(function(){
            $(document).on('change','#sales_history',function(e){

        var saleshistory = $(this).val();
         $.ajax({
                type        : 'GET',
                url         : APP_URL + '/branch/sales/details/'+saleshistory,
                cache : false,
                processData: false
            })
            .done(function(response) {
                if(response.status_code == 200){
                    $(".salesdetails").html(response.data+" QAR");
                }
            });
        return false;
    });
        });

        $(document).ready(function(){
        $.ajax({
            type        : 'GET',
            url         : APP_URL + '/branch/userchart/',
            cache : false,
            processData: false
        })
        .done(function(response) {
            if(response.status_code == 200){
               drawMonthwiseChart(response.month, response.count);
            }
        });
});
        function drawMonthwiseChart(month, count)
        {
            console.log(count,month);

        let mn=['January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July',
        'August',
        'September',
        'October',
        'November',
        'December'
        ],cnt=[0,0,0,0,0,0,0,0,0,0,0,0]
        for(let i=0;i<mn.length-1;i++){
            month.forEach((it,index)=>{
                if(mn[i]==it){
                    cnt[i]=count[index][0]
                }
            })
        }

        var chartData = {
        labels: mn,
        datasets: [{
            data: cnt,
            backgroundColor:[
            'rgba(46,53,145,0.5)', 'rgba(234,4,140,0.5)'
            ],
            borderColor:"#090c2fc2"
        }],
        
        };

        var chLine = document.getElementById("chLine");
        if (chLine) {
        new Chart(chLine, {
        type: 'line',
        data: chartData,
        options: {
            scales: {
            yAxes: [{
                ticks: {
                beginAtZero: true,
                userCallback: function(label, index, labels) {
                     // when the floored value is the same as the value we have a whole number
                     if (Math.floor(label) === label) {
                         return label;
                     }

                 },
                }
            }]
            },
            legend: {
            display: false
            }
        }
        });
        }
    }

    </script>

@endsection
