<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
use App\Model\UserAgreement;
use App\Model\UserAgreementSeller;
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
            $contacts_out=GoalsReached::where([['user_id','=',$user],['attribute_id','=','4']])->first();
            $contacts_signed=GoalsReached::where([['user_id','=',$user],['attribute_id','=','5']])->first();
            $deal_closed=GoalsReached::where([['user_id','=',$user],['attribute_id','=','6']])->first();
            $money_expected=GoalsReached::where([['user_id','=',$user],['attribute_id','=','7']])->first();
            $money_collected=GoalsReached::where([['user_id','=',$user],['attribute_id','=','8']])->first();


            $goalValue=$goal->goals??0;
            $goal_appointment=$goal_appointment->goals??0;
            $goal_lead=$goal_lead->goals??0;
            $contacts_out=$contacts_out->goals??0;
            $contacts_signed=$contacts_signed->goals??0;
            $deal_closed=$deal_closed->goals??0;

            $money_expected=$money_expected->goals??0;
            $money_collected=$money_collected->goals??0;





            //appointment
            $appointment_lifetime=(Scheduler::where([['user_id',$user],['status','booked']])->count());
            $appointment_todays=appointment_count(0,$user);
            $appointment_seven_day=appointment_count(7,$user);
            $appointment_month=appointment_count(30,$user);
            $appointment_ninety_day=appointment_count(90,$user);
            $appointment_year=appointment_count(365,$user);


            // Deals Closed

            $deals_lifetime=(UserAgreementSeller::where([['user_id',$user],['is_sign','2']])->count());
            $deals_todays=deal_count(0,$user);
            $deals_seven_day=deal_count(7,$user);
            $deals_month=deal_count(30,$user);
            $deals_ninety_day=deal_count(90,$user);
            $deals_year=deal_count(365,$user);

            // Contracts Signed

            $contracts_signed_lifetime=(UserAgreementSeller::where([['user_id',$user],['is_sign','2']])->count());
            $contracts_signed_todays=contracts_signed_count(0,$user);
            $contracts_signed_seven_day=contracts_signed_count(7,$user);
            $contracts_signed_month=contracts_signed_count(30,$user);
            $contracts_signed_ninety_day=contracts_signed_count(90,$user);
            $contracts_signed_year=contracts_signed_count(365,$user);

            // Contracts OUT

            $contracts_out_lifetime=(UserAgreementSeller::where([['user_id',$user]])->count());
            $contracts_out_todays=contracts_out_count(0,$user);
            $contracts_out_seven_day=contracts_out_count(7,$user);
            $contracts_out_month=contracts_out_count(30,$user);
            $contracts_out_ninety_day=contracts_out_count(90,$user);
            $contracts_out_year=contracts_out_count(365,$user);

            // Money Expected
            $moneyExpected = GoalsReached::where([['user_id','=',$user]])->first();
            $monthlyGoal = preg_replace('/[^0-9]/', '', $moneyExpected->goals);
            $expectedLifespanYears = 80;
           // Calculate expected money for different time intervals
            $expected_money_todays = $monthlyGoal / 30; // Assuming a month has 30 days
            $expected_money_seven_day = $expected_money_todays * 7;
            $expected_money_month = $monthlyGoal;
            $expected_money_ninety_day = $expected_money_todays * 90;
            $expected_money_year = $monthlyGoal * 12;
            $expected_money_lifetime = $monthlyGoal * 12 * $expectedLifespanYears;

            // COLLECTEDMONEY

            // Function to calculate money collected based on leads count and conversion rates
            function calculateMoneyCollected($leadsCount, $leadsToPhoneConversionRate, $phoneToSignedConversionRate, $signedToClosedEscrowConversionRate, $days) {
                $phoneConversationsCount = $leadsCount * $leadsToPhoneConversionRate * $days / 365;
                $signedPurchaseAgreementsCount = $phoneConversationsCount * $phoneToSignedConversionRate;
                $closedEscrowCount = $signedPurchaseAgreementsCount * $signedToClosedEscrowConversionRate;


                $grossProfitPerDeal = 1000; // Replace this with the actual gross profit per deal

                return $closedEscrowCount * $grossProfitPerDeal;
            }

            $initialGoal = preg_replace('/[^0-9]/', '', $money_collected); // Remove non-digit characters
            $leadsCount = preg_replace('/[^0-9]/', '', $goal_lead) ?? 0;

            // Define conversion rates (as decimals)
            $leadsToPhoneConversionRate = 0.5;
            $phoneToSignedConversionRate = 0.1;
            $signedToClosedEscrowConversionRate = 0.8;

            // Calculate money collected for different time periods based on conversion rates and leads count
            $money_collected_todays = calculateMoneyCollected($leadsCount, $leadsToPhoneConversionRate, $phoneToSignedConversionRate, $signedToClosedEscrowConversionRate, 1);
            $money_collected_seven_day = calculateMoneyCollected($leadsCount, $leadsToPhoneConversionRate, $phoneToSignedConversionRate, $signedToClosedEscrowConversionRate, 7);
            $money_collected_month = calculateMoneyCollected($leadsCount, $leadsToPhoneConversionRate, $phoneToSignedConversionRate, $signedToClosedEscrowConversionRate, 30);
            $money_collected_ninety_day = calculateMoneyCollected($leadsCount, $leadsToPhoneConversionRate, $phoneToSignedConversionRate, $signedToClosedEscrowConversionRate, 90);
            $money_collected_year = calculateMoneyCollected($leadsCount, $leadsToPhoneConversionRate, $phoneToSignedConversionRate, $signedToClosedEscrowConversionRate, 365);
            $money_collected_lifetime = calculateMoneyCollected($leadsCount, $leadsToPhoneConversionRate, $phoneToSignedConversionRate, $signedToClosedEscrowConversionRate, PHP_INT_MAX); // PHP_INT_MAX represents a very large number, practically infinite

            // Calculate the remaining goal
            $remainingGoal = $initialGoal - $money_collected_lifetime;


            //    $messages_sent_week=(Sms::whereDate('created_at', Carbon::today())->where('is_received',0)->withTrashed()->count())+(Reply::where('system_reply',1)->whereDate('created_at', Carbon::today())->withTrashed()->count());
            //    $messages_received_week=(Sms::whereDate('created_at', Carbon::today())->where('is_received',1)->withTrashed()->count())+(Reply::where('system_reply',0)->whereDate('created_at', Carbon::today())->withTrashed()->count());




            return view('back.index',compact('goalValue','total_sent_lifetime','total_received_lifetime',
            'messages_sent_today','messages_received_today',"settings",
            'messages_sent_today_goals','messages_sent_seven_days_goals',
            'messages_sent_month_days_goals','messages_sent_ninety_days_goals',
            'messages_sent_year_goals','messages_received_today_goals','messages_received_seven_days_goals',
            'messages_received_month_days_goals','messages_received_ninety_days_goals',
            'messages_received_year_goals','appointment_todays','appointment_seven_day',
            'appointment_month','appointment_ninety_day','appointment_year',
            'appointment_lifetime','goal_lead','goal_appointment', 'contacts_out',
            'contacts_signed','deal_closed','money_expected','money_collected',
            'deals_lifetime','deals_todays','deals_seven_day','deals_month','deals_ninety_day','deals_year',
            'contracts_signed_lifetime','contracts_signed_todays','contracts_signed_seven_day','contracts_signed_month',
            'contracts_signed_ninety_day','contracts_signed_year','contracts_out_lifetime','contracts_out_todays',
            'contracts_out_seven_day','contracts_out_month','contracts_out_ninety_day','contracts_out_year',
            'expected_money_todays','expected_money_seven_day','expected_money_month','expected_money_ninety_day',
            'expected_money_year','expected_money_lifetime','money_collected_todays','money_collected_seven_day','money_collected_month',
            'money_collected_ninety_day','money_collected_year','money_collected_lifetime','remainingGoal'));
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
        $goal->money_per_month=$request->money_per_month??0;
        $goal->gross_profit=$request->gross_profit??0;
        $goal->contact_trun_into_lead=$request->contact_trun_into_lead??0;
        $goal->leads_into_phone=$request->leads_into_phone??0;
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
        $goal->money_per_month=$request->money_per_month??0;
        $goal->gross_profit=$request->gross_profit??0;
        $goal->contact_trun_into_lead=$request->contact_trun_into_lead??0;
        $goal->leads_into_phone=$request->leads_into_phone??0;
        $goal->save();
        // Alert::success('Success','Goal Saved!');
        return redirect()->route('admin.setgoals')->with('Success','Goal Saved!');
    }
}
