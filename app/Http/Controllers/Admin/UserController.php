<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\UserLoginOtp;
use App\Helpers\Helper;
use Session;

class UserController extends Controller
{   
    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show Users List.
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function usersListView()
    {   
        return view('admin.user.users_list');
    }

    public function usersList(){
        $data = [];
        $getUsers = User::where('status','1')->where('role','user')->get()->toArray();

        if(count($getUsers) > 0){
            foreach ($getUsers as $user) {
                $date_time = date('d-m-Y H:i', strtotime($user['created_at']));
                $data[] = [$user['id'],$date_time, $user['name'], $user['mobile_number'],$user['email'], Helper::encrypt($user['id'])];
            }
        }

        return response()->json($data);
    }

    public function deleteUser(Request $request, $id)
    {   
        UserLoginOtp::where('user_id', Helper::decrypt($id))->delete();
        User::where('id', Helper::decrypt($id))->delete();

        Session::flash('message', 'User deleted successfully.');

        $data = [];
        return response()->json($data);
    }

}
