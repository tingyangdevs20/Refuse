<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Campaign;
use App\Model\Emails;
use App\Model\Reply;
use App\Model\Settings;
use App\Model\Scheduler;
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
        $messages_sent_year_goals=getReportingDataOfSMS(365);
       //Received sms
        $messages_received_today_goals=getReportingDataOfSMSreceived(0);
        $messages_received_seven_days_goals=getReportingDataOfSMSreceived(7);
        $messages_received_month_days_goals=getReportingDataOfSMSreceived(30);
        $messages_received_ninety_days_goals=getReportingDataOfSMSreceived(90);
        $messages_received_year_goals=getReportingDataOfSMSreceived(365);
        $user=Auth::id();

        //goals
        $goal_people_reached=GoalsReached::where([['user_id','=',$user],['attribute_id','=','1']])->first();
        $goal_lead=GoalsReached::where([['user_id','=',$user],['attribute_id','=','2']])->first();
        $goal_appointment=GoalsReached::where([['user_id','=',$user],['attribute_id','=','3']])->first();

        $goalValue=$goal->goals??0;
        $goal_appointment=$goal_appointment->goals??0;
        $goal_lead=$goal_lead->goals??0;
        //appointment
        $appointment_lifetime=(Scheduler::where([['user_id',$user],['status','booked']])->count());
        $appointment_todays=appointment_count(0,$user);
        $appointment_seven_day=appointment_count(7,$user);
        $appointment_month=appointment_count(30,$user);
        $appointment_ninety_day=appointment_count(90,$user);
        $appointment_year=appointment_count(365,$user);

//        $messages_sent_week=(Sms::whereDate('created_at', Carbon::today())->where('is_received',0)->withTrashed()->count())+(Reply::where('system_reply',1)->whereDate('created_at', Carbon::today())->withTrashed()->count());
//        $messages_received_week=(Sms::whereDate('created_at', Carbon::today())->where('is_received',1)->withTrashed()->count())+(Reply::where('system_reply',0)->whereDate('created_at', Carbon::today())->withTrashed()->count());


        $dashboardData = [
            'people_reached' => [
                'today'=> Campaign::getCountForLastDays(1),
                'last_7_days'=> Campaign::getCountForLastDays(7),
                'last_30_days'=> Campaign::getCountForLastDays(30),
                'last_90_days'=> Campaign::getCountForLastDays(90),
                'last_365_days'=> Campaign::getCountForLastDays(365),
                'life_time'=> Campaign::getCountForLastDays(),
            ],
            'leads' => [
                'today'=> self::getLeadCountForLastDays(1),
                'last_7_days'=> self::getLeadCountForLastDays(7),
                'last_30_days'=> self::getLeadCountForLastDays(30),
                'last_90_days'=> self::getLeadCountForLastDays(90),
                'last_365_days'=> self::getLeadCountForLastDays(365),
                'life_time'=> self::getLeadCountForLastDays(),
            ]
        ];
        return view('back.index',compact('dashboardData','goalValue','total_sent_lifetime','total_received_lifetime','messages_sent_today','messages_received_today',"settings",'messages_sent_today_goals','messages_sent_seven_days_goals','messages_sent_month_days_goals','messages_sent_ninety_days_goals','messages_sent_year_goals','messages_received_today_goals','messages_received_seven_days_goals','messages_received_month_days_goals','messages_received_ninety_days_goals','messages_received_year_goals','appointment_todays','appointment_seven_day','appointment_month','appointment_ninety_day','appointment_year','appointment_lifetime','goal_lead','goal_appointment'));
    }

    private function getLeadCountForLastDays($days=null){
        return Sms::getCountForLastDays($days)+ Emails::getCountForLastDays($days);
    }

    public function setGoals(Request $request)
    {
        $user=Auth::id();
        $goal=GoalsReached::all();
        $goal->load(['goal_attribute','user']);
        return view('back.pages.goal-settings.index',compact('goal'));
    }

    public function createGoals(Request $request)
    {
        $users=User::all();
        $attributes=goal_attribute::all();
        return view('back.pages.goal-settings.create',compact('users','attributes'));
    }
    public function editGoals(Request $request,$id)
    {
        $goal=GoalsReached::where('id','=',$id)->first();
        $goal->load(['goal_attribute','user']);
        $users=User::all();
        $attributes=goal_attribute::all();
        return view('back.pages.goal-settings.edit',compact('goal','users','attributes'));
    }
    public function updateGoals(Request $request,$id)
    {
        $validatedData = $request->validate([
            'goal' => 'required|numeric',
            'user' => 'required',
            'attribute' => 'required',
        ]);
        $user=Auth::id();
        $goal=GoalsReached::where('id','=',$id)->first();
        $goal->goals=$request->goal;
        $goal->user_id=$request->user;
        $goal->attribute_id=$request->attribute;
        $goal->save();
        // Alert::success('Success','Goal Saved!');
        return redirect()->route('admin.setgoals')->with('Success','Goal Saved!');
    }
    public function deleteGoals(Request $request,$id)
    {
        $goal=GoalsReached::where('id','=',$id)->first();
        $goal->delete();
        return redirect()->route('admin.setgoals')->with('Success','Goal Saved!');
    }
    public function saveGoals(Request $request)
    {
        $validatedData = $request->validate([
            'goal' => 'required|numeric',
            'user' => 'required',
            'attribute' => 'required',
        ]);
        $user=Auth::id();
        $goal=new GoalsReached();
        $goal->goals=$request->goal;
        $goal->user_id=$request->user;
        $goal->attribute_id=$request->attribute;
        $goal->save();
        // Alert::success('Success','Goal Saved!');
        return redirect()->route('admin.setgoals')->with('Success','Goal Saved!');
    }
}
