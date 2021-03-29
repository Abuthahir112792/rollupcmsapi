@foreach($data as $row)
                                <tr>
                                <td><?php echo date('d-m-Y H:i', strtotime($row->created_at))?></td>
                                <td>{{ $row->order_id }}</td>
                                <td>{{ $row->user_name }}</td>
                                <td>{{ $row->order_description }}</td>
                                <td>{{ $row->order_price }}</td>
                                <td>{{ $row->order_status }}</td>
                                <td><?php $flag = $row->self_pickup;
                                if($flag=='True'){
                                echo '<button class="button" style="background-color: red;border: none;color: white;padding: 10px 20px;text-align: center;text-decoration: none;display: inline-block;margin: 4px 2px;cursor: pointer;border-radius: 16px;">Self Pickup</button>';
                                }
                                else{
                                echo '';
                                }
                                ?></td>
                                <td>{{ $row->latitude }}</td>
                                <td>{{ $row->longitude }}</td>
                                <td><a href="#" class="view_history" title="View" id="{{ $row->id }}"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
                                @endforeach
                                <tr>
                                <td colspan="10" align="center">
                                 {!! $data->links() !!}
                                </td>
                                </tr>
                                