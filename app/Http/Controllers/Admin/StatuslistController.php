<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Helpers\Helper;
use App\Statuslist;
use Session;

class StatuslistController extends Controller
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
    public function statusListView()
    {   
        return view('admin.user.statuslist_list');
    }

    public function getStatuslist(){
        $data = [];
        $getStatuslist = Statuslist::select('statuslist.*')->get()->toArray();
        
        if(count($getStatuslist) > 0){
            foreach ($getStatuslist as $Statuslist) {
                $data[] = [$Statuslist['id'], $Statuslist['status_name'], $Statuslist['status_status']."-".$Statuslist['id'], Helper::encrypt($Statuslist['id'])];
            }
        }
        return response()->json($data);
    }

    public function addStatuslistUpdate(Request $request){
        $id = Helper::decrypt($request->statuslist_update_id);
        if($request->status_name == ""){
            $msg = 'Please enter Status name.';
            return Redirect::back()->with('message',$msg);
        }
        else{
        if($id == ''){
            $newStatuslist = new Statuslist();
                    $newStatuslist->status_name = $request->status_name;
                    $newStatuslist->status_status = $request->status_status;
                    $newStatuslist->save();
            $msg = 'Status Added successfully.';
            
        }
        else{
             Statuslist::where('id',$id)->update(["status_name"=>$request->status_name,"status_status"=>$request->status_status]);
             $msg = 'Status Updated successfully.';
        }
        return Redirect::back()->with('message',$msg);
    }
        return Redirect::back()->with('error','Something wrong to update Status.');
    }
    

    public function statuslistStatuscheck($id,$status){
        Statuslist::where('id', $id)->update(["status_status"=>$status]);
        $msg = 'Status is Inactive Successfully.';
        if($status == "Active"){
            $msg = 'Status is Active Successfully';
        }
        return response()->json(['status' => 'Success!','status_code' => 200,'msg' => $msg]);
    }

    public function deleteStatuslist($id)
    {   
        $statuslistid = Helper::decrypt($id);
        $Statuslistidllist = Statuslist::where('id', $statuslistid)->delete();               
            $msg = "Status deleted successfully.";
            Session::flash('message', $msg);
            $data = [];
            return response()->json($data);
    }

    public function deletemultiStatuslist($id)
    {   
        $mulstatuslistids = explode(',', $id);
        for($i=0;$i<count($mulstatuslistids);$i++)
        {
           $mulstatuslistidllist = Statuslist::where('id', $mulstatuslistids)->delete();
            
        }
        $msg = "Statuslist deleted successfully.";
                    Session::flash('message', $msg);
            $data = [];
             return response()->json($data);
    }

    public function getStatuslistDetails($id){
        return Helper::getStatuslistDetails($id);
    }
}
