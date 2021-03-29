<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Helpers\Helper;
use App\Feedback;
use Session;

class FeedbackController extends Controller
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
    public function feedbackListView()
    {   
        return view('admin.user.feedback_list');
    }

    public function feedbackList(){
        $data = [];
        $getFeedback = Feedback::leftjoin('users', 'users.id', '=', 'feedback.user_id')->select('feedback.*', 'users.name', 'users.mobile_number')->orderBy('feedback.id', 'DESC')->get()->toArray();

        if(count($getFeedback) > 0){
            foreach ($getFeedback as $feedback) {
                $date_time = date('d-m-Y H:i', strtotime($feedback['created_at']));
                $data[] = [$date_time, $feedback['name'], $feedback['mobile_number'], $feedback['feedback_rate'], $feedback['feedback_description'], Helper::encrypt($feedback['id'])];
            }
        }

        return response()->json($data);
    }

    public function deleteFeedback(Request $request, $id)
    {   
        Feedback::where('id', Helper::decrypt($id))->delete();

        Session::flash('message', 'User deleted successfully.');

        $data = [];
        return response()->json($data);
    }

}
