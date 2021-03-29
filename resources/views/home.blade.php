@extends('layouts.app')
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
            <h4 class="header-sub-title">Roll up Restaurant Dashboard</h4>



            <!-- DashBoard Content -->

            <div class="row" style="margin:20px 0px">
                <div class="col-sm-3">
                    <div class="panel">
                    <div class="panel-heading">
                        <p class="card-text">Active Users</p>
                        <h3 class="card-title"><?php echo $data['usercount'];?></h3>
                    </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="panel">
                    <div class="panel-heading">
                        <p class="card-text">Pending Orders</p>
                        <h3 class="card-title order-pending-card-value"><?php echo $data['pendingorderscount'];?></h3>
                    </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="panel">
                    <div class="panel-heading">
                        <p class="card-text">Out For Delivery</p>
                        <h3 class="card-title"><?php echo $data['our_for_delivery'];?></h3>
                    </div>
                    </div>
                </div>
                <div class="col-sm-3">
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
                <div class="col-sm-6">
                    <div  class="panel" >
                    <div class="panel-heading">
                        <h4 class="card-title">Top 10 Users</h4>
                        
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="usersList" class="display" width="100%">
                                <thead>
                            <tr>
                                <th class="no-sort">S.No</th>
                                <th>User Name</th>
                                <th>Mobile Number</th>
                                <th>Purchase Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1; ?>
                            @foreach ($top_users as $top_users)
                            <tr>
                                <td><?php echo $i;?></td>
                                <td><?php echo $top_users->name; ?></td>
                                <td><?php echo $top_users->mobile_number; ?></td>
                                <td><?php echo $top_users->total; ?></td>
                            </tr>
                            <?php $i++;?>
                             @endforeach
                        </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
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
            
            <div class="row" style="margin:20px 0px">
                <div class="col-sm-12">
                    <div  class="panel" >
                    <div class="panel-heading">
                        <h4 class="card-title">Branch Revenue Details</h4>
                        
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="usersList" class="display" width="100%">
                                <thead>
                            <tr>
                                <th class="no-sort">S.No</th>
                                <th>Branch Name</th>
                                <th>Monthly Completed Orders count</th>
                                <th>Monthly Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1; ?>
                            @foreach ($branch_details as $branch_details)
                            <tr>
                                <td><?php echo $i;?></td>
                                <td><?php echo $branch_details->branch_name; ?></td>
                                <td><?php echo $branch_details->totalcompleted; ?></td>
                                <td><?php echo $branch_details->totalrevenue; ?></td>
                            </tr>
                            <?php $i++;?>
                             @endforeach
                        </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <!-- <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Devices <a href="{{URL::to('devices/add-device')}}" style="float: right; color: #337ab7;" title="Add Device"><i class="fa fa-plus-circle"></i> Add Device</a></h3>
                        </div>
                        <div class="panel-body">
                            <table id="deviceData" class="display" width="100%">

                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" id="orderTable">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Orders <a href="{{URL::to('orders/add-order')}}" style="float: right; color: #337ab7;" title="Add Device"><i class="fa fa-plus-circle"></i> New Order</a></h3>
                        </div>
                        <div class="panel-body">
                            <table id="ordersData" class="display" width="100%">

                            </table>
                        </div>
                    </div>
                </div>
            </div> -->

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
                url         : APP_URL + '/admin/sales/details/'+saleshistory,
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
            url         : APP_URL + '/admin/userchart/',
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
