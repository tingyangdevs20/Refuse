<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Reply;
use App\Model\Settings;
use App\Model\Sms;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Model\GoalsReached;
use App\goal_attribute;
use App\User;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

use Helper;

class AdminController extends Controller
{
    public function index()
    {
        $settings=Settings::first();
        $messages_sent_today=(Sms::whereDate('created_at', Carbon::today())->where('is_received',0)->withTrashed()->count())+(Reply::where('system_reply',1)->whereDate('created_at', Carbon::today())->withTrashed()->count());
        $messages_received_today=(Sms::whereDate('created_at', Carbon::today())->where('is_received',1)->withTrashed()->count())+(Reply::where('system_reply',0)->whereDate('created_at', Carbon::today())->withTrashed()->count());
        $total_sent_lifetime=(Sms::distinct('client_number')->where('is_received',0)->withTrashed()->count())+(Reply::distinct('to')->where('system_reply',1)->withTrashed()->count());
        $total_received_lifetime=(Sms::where('is_received',1)->withTrashed()->count())+(Reply::where('system_reply',0)->withTrashed()->count());
        $messages_sent_today_goals=getReportingDataOfSMS(0);
        $messages_sent_seven_days_goals=getReportingDataOfSMS(7);
        $messages_sent_month_days_goals=getReportingDataOfSMS(30);
        $messages_sent_ninety_days_goals=getReportingDataOfSMS(90);
        $user=Auth::id();
        $goal=GoalsReached::where('user_id',$user)->first();
        $goalValue=$goal->goals??0;


//        $messages_sent_week=(Sms::whereDate('created_at', Carbon::today())->where('is_received',0)->withTrashed()->count())+(Reply::where('system_reply',1)->whereDate('created_at', Carbon::today())->withTrashed()->count());
//        $messages_received_week=(Sms::whereDate('created_at', Carbon::today())->where('is_received',1)->withTrashed()->count())+(Reply::where('system_reply',0)->whereDate('created_at', Carbon::today())->withTrashed()->count());




        return view('back.index',compact('goalValue','total_sent_lifetime','total_received_lifetime','messages_sent_today','messages_received_today',"settings",'messages_sent_today_goals','messages_sent_seven_days_goals','messages_sent_month_days_goals','messages_sent_ninety_days_goals'));
    }

    public function setGoals(Request $request)
    {
        $user=Auth::id();
        $goal=GoalsReached::all();
        $goal->load(['goal_attribute']);
        return view('back.pages.goal-settings.index',compact('goal'));
    }

    public function createGoals(Request $request)
    {
        $users=User::all();
        $attributes=goal_attribute::all();
        return view('back.pages.goal-settings.create',compact('users','attributes'));
    }
    public function editGoals(Request $request)
    {
        return view('back.pages.goal-settings.index',compact('goal'));
    }
    public function updateGoals(Request $request)
    {
        return view('back.pages.goal-settings.index',compact('goal'));
    }
    public function saveGoals(Request $request)
    {
        $validatedData = $request->validate([
            'goal' => 'required|numeric',
            'user' => 'required',
            'attribute' => 'required', 
        ]);
        $user=Auth::id();
        print_r($request->all());
        $goal=new GoalsReached();
        $goal->goals=$request->goal;
        $goal->user_id=$request->user;
        $goal->attribute_id=$request->attribute;
        $goal->save();
        Alert::success('Success','Goal Saved!');
        return redirect()->back();
    }
}
