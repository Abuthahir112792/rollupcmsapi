<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Branch;
use App\UserLoginOtp;
use App\Helpers\Helper;
use Session;
use auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class BranchManageController extends Controller
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
    public function branchmanageListView()
    {   
        return view('admin.user.branchmanage_list');
    }

    public function branchmanageList(){
        $data = [];
        $getBranchManage = User::leftjoin('branch', 'branch.id', '=', 'users.branch_id')->where('users.role','branch_user')->select('users.*','branch.branch_name', 'branch.lat', 'branch.long')->get()->toArray();
        if(count($getBranchManage) > 0){
            foreach ($getBranchManage as $user) {
                $data[] = [$user['id'],$user['name'],$user['branch_name'], $user['email'], $user['branch_user_status']."-".$user['branch_id'],$user['address'],$user['lat'],$user['long'], Helper::encrypt($user['id'])];
            }
            
        }

        
        return response()->json($data);
    }
        


    
    public function addUserUpdate(Request $request){
        $id = Helper::decrypt($request->branch_user_id);
        // $this->validate($request, [
        //     'user_password' => 'required|string|min:6|same:user__confirm_password',
        //   'user__confirm_password' => 'required',
        //     ]);
        if($request->user_password == "")
        {
            $msg = 'Please enter password';
        }
        else if($request->user__confirm_password == "")
        {
            $msg = 'Please enter confirm password';
        }
        else if($request->user_password != $request->user__confirm_password)
        {
            $msg = 'password mismatched';
        }
        else{
        $user = User::where('id',$id)->first();

    	//  if ((Hash::check($request->user_password, $user->password))) {

        //      return back()->with('error', ' password does not match!');
        //  }
        User::where('id',$id)->update(["password"=> Hash::make($request->user_password)]);
             $msg = 'userbranch Updated successfully.';
        }

         return back()->with('message', $msg);
    }




    public function branchStatuscheck($id,$status){
        User::where('branch_id', $id)->update(["branch_user_status"=>$status]);
        $msg = 'Branch is Inactive Successfully.';
        if($status == "Active"){
        $msg = 'Branch is Active Successfully';
       }
        return response()->json(['status' => 'Success!','status_code' => 200,'msg' => $msg]);
        }


    //public function deleteUser(Request $request, $id)
    //{   
       // UserLoginOtp::where('user_id', Helper::decrypt($id))->delete();
       // User::where('id', Helper::decrypt($id))->delete();

        //Session::flash('message', 'User deleted successfully.');

        //$data = [];
        //return response()->json($data);
   // }
   public function getBranchManageDetails($id){
    return Helper::getBranchUserDetails($id);
}
}
