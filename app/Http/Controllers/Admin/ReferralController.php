<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Helpers\Helper;
use App\User;
use Session;

class ReferralController extends Controller
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
    public function referralListView()
    {   
        return view('admin.user.referral_list');
    }

    public function referralList(){
        $data = [];
        $getReferral = User::select('name','mobile_number','member_referral','created_at')->where('member_referral','!=',0)->orderBy('member_referral', 'DESC')->skip(0)->take(10)->get();
        

        if(count($getReferral) > 0){
            foreach ($getReferral as $referral) {
                $date_time = date('d-m-Y H:i', strtotime($referral['created_at']));
                $data[] = [$date_time, $referral['name'], $referral['mobile_number'], $referral['member_referral'], Helper::encrypt($referral['id'])];
            }
        }

        return response()->json($data);
    }

    

}
