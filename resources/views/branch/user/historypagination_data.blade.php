<div class="table-responsive">
     <table class="table table-striped table-bordered">
      <tr>
       <th width="5%">Order Id</th>
       <th width="38%">User Name</th>
       <th width="57%">Order Description</th>
       <th width="57%">Order Price</th>
       <th width="57%">Order Status</th>
       <th width="57%">Action</th>
      </tr>
      @foreach($data as $row)
      <tr>
      
             <td><?php echo date('d-m-Y H:i', strtotime($row->created_at))?></td>
            <td>{{ $row->order_id }}</td>
            <td>{{ $row->user_name }}</td>
            <td>{{ $row->order_description }}</td>
            <td>{{ $row->order_price }}</td>
            <td>{{ $row->order_status }}</td>
            <td>{{ $row->action }}</td>
             </tr>
      
      @endforeach
     </table>

     {!! $data->links() !!}

    </div>