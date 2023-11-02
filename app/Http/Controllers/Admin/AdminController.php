<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\FollowupSequences;
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
use App\Model\UserAgreementSeller;
use Illuminate\Support\Facades\DB;

use App\TaskList;
use App\TaskLists;
use App\Model\Contact;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{
    public function index()
    {
        $settings = Settings::first();
        $messages_sent_today = (Sms::whereDate('created_at', Carbon::today())->where('is_received', 0)->withTrashed()->count()) + (Reply::where('system_reply', 1)->whereDate('created_at', Carbon::today())->withTrashed()->count());
        $messages_received_today = (Sms::whereDate('created_at', Carbon::today())->where('is_received', 1)->withTrashed()->count()) + (Reply::where('system_reply', 0)->whereDate('created_at', Carbon::today())->withTrashed()->count());
        $total_sent_lifetime = (Sms::distinct('client_number')->where('is_received', 0)->withTrashed()->count()) + (Reply::distinct('to')->where('system_reply', 1)->withTrashed()->count());
        $total_received_lifetime = (Sms::where('is_received', 1)->withTrashed()->count()) + (Reply::where('system_reply', 0)->withTrashed()->count());
        $messages_sent_today_goals = getReportingDataOfSMS(0);
        $messages_sent_seven_days_goals = getReportingDataOfSMS(7);
        $messages_sent_month_days_goals = getReportingDataOfSMS(30);
        $messages_sent_ninety_days_goals = getReportingDataOfSMS(90);
        $messages_sent_year_goals = getReportingDataOfSMS(365);

        //Received sms
        $messages_received_today_goals = getReportingDataOfSMSreceived(0);
        $messages_received_seven_days_goals = getReportingDataOfSMSreceived(7);
        $messages_received_month_days_goals = getReportingDataOfSMSreceived(30);
        $messages_received_ninety_days_goals = getReportingDataOfSMSreceived(90);
        $messages_received_year_goals = getReportingDataOfSMSreceived(365);
        $user = Auth::id();

        // People touched
        $people_touched_records_count = 0;
        $people_touched_lifetime = 0;
        $people_touched_today = 0;
        $people_touched_seven_days = 0;
        $people_touched_month = 0;
        $people_touched_ninety_days = 0;
        $people_touched_year = 0;

        // Get attribute details
        $people_touched_attribute = goal_attribute::where('attribute', 'People Reached')->first();
        if ($people_touched_attribute) {

            $people_touched_records_count = DB::table('contact_goals_reacheds')
                ->where('attribute_id', $people_touched_attribute->id)
                ->where('lead_status', 'Prospect')
                ->where('user_id', $user)
                ->count();

            // Leads
            $people_touched_lifetime = $people_touched_records_count ?? 0;
            $people_touched_today = people_touched_days_count(0, $user, $people_touched_attribute);
            $people_touched_seven_days = people_touched_days_count(7, $user, $people_touched_attribute);
            $people_touched_month = people_touched_days_count(30, $user, $people_touched_attribute);
            $people_touched_ninety_days = people_touched_days_count(90, $user, $people_touched_attribute);
            $people_touched_year = people_touched_days_count(365, $user, $people_touched_attribute);
        }

        // Leads
        $lead_records_count = 0;
        $leads_count_lifetime = 0;
        $leads_count_today = 0;
        $leads_count_seven_days = 0;
        $leads_count_month = 0;
        $leads_count_ninety_days = 0;
        $leads_count_year = 0;

        // Get attribute details
        $lead_attribute = goal_attribute::where('attribute', 'Lead')->first();
        if ($lead_attribute) {

            $lead_records_count = DB::table('contact_goals_reacheds')
                ->where('attribute_id', $lead_attribute->id)
                ->where('lead_status', 'Lead')
                ->where('user_id', $user)
                ->count();

            // Leads
            $leads_count_lifetime = $lead_records_count ?? 0;
            $leads_count_today = leads_days_count(0, $user, $lead_attribute);
            $leads_count_seven_days = leads_days_count(7, $user, $lead_attribute);
            $leads_count_month = leads_days_count(30, $user, $lead_attribute);
            $leads_count_ninety_days = leads_days_count(90, $user, $lead_attribute);
            $leads_count_year = leads_days_count(365, $user, $lead_attribute);
        }

        // Scheduled Appointments
        $scheduled_appointments_records_count = 0;
        $scheduled_appointments_count_lifetime = 0;
        $scheduled_appointments_count_today = 0;
        $scheduled_appointments_count_seven_days = 0;
        $scheduled_appointments_count_month = 0;
        $scheduled_appointments_count_ninety_days = 0;
        $scheduled_appointments_count_year = 0;

        // Get attribute details
        $scheduled_appointment_attribute = goal_attribute::where('attribute', 'Phone Appointment')->first();
        if ($scheduled_appointment_attribute) {

            $scheduled_appointments_records_count = DB::table('contact_goals_reacheds')
                ->where('attribute_id', $scheduled_appointment_attribute->id)
                ->where('lead_status', 'Phone Call - Scheduled')
                ->where('user_id', $user)
                ->count();

            // Leads
            $scheduled_appointments_count_lifetime = $scheduled_appointments_records_count ?? 0;
            $scheduled_appointments_count_today = scheduled_appointments_days_count(0, $user, $scheduled_appointment_attribute);
            $scheduled_appointments_count_seven_days = scheduled_appointments_days_count(7, $user, $scheduled_appointment_attribute);
            $scheduled_appointments_count_month = scheduled_appointments_days_count(30, $user, $scheduled_appointment_attribute);
            $scheduled_appointments_count_ninety_days = scheduled_appointments_days_count(90, $user, $scheduled_appointment_attribute);
            $scheduled_appointments_count_year = scheduled_appointments_days_count(365, $user, $scheduled_appointment_attribute);
        }

        // Scheduled Appointments
        $appointments_showup_records_count = 0;
        $appointments_showup_count_lifetime = 0;
        $appointments_showup_count_today = 0;
        $appointments_showup_count_seven_days = 0;
        $appointments_showup_count_month = 0;
        $appointments_showup_count_ninety_days = 0;
        $appointments_showup_count_year = 0;

        // Get attribute details
        $appointment_attribute = goal_attribute::where('attribute', 'Appointments Show Up')->first();
        if ($appointment_attribute) {

            $appointments_showup_records_count = DB::table('contact_goals_reacheds')
                ->where('attribute_id', $appointment_attribute->id)
                ->where('lead_status', 'Phone Call - Completed')
                ->where('user_id', $user)
                ->count();

            // Leads
            $appointments_showup_count_lifetime = $appointments_showup_records_count ?? 0;
            $appointments_showup_count_today = appointments_showup_days_count(0, $user, $appointment_attribute);
            $appointments_showup_count_seven_days = appointments_showup_days_count(7, $user, $appointment_attribute);
            $appointments_showup_count_month = appointments_showup_days_count(30, $user, $appointment_attribute);
            $appointments_showup_count_ninety_days = appointments_showup_days_count(90, $user, $appointment_attribute);
            $appointments_showup_count_year = appointments_showup_days_count(365, $user, $appointment_attribute);
        }

        // Call No Show
        $call_no_show_records_count = 0;
        $call_no_show_count_lifetime = 0;
        $call_no_show_count_today = 0;
        $call_no_show_count_seven_days = 0;
        $call_no_show_count_month = 0;
        $call_no_show_count_ninety_days = 0;
        $call_no_show_count_year = 0;

        // Get attribute details
        $call_no_show_attribute = goal_attribute::where('attribute', 'Call No Show')->first();
        if ($call_no_show_attribute) {

            $call_no_show_records_count = DB::table('contact_goals_reacheds')
                ->where('attribute_id', $call_no_show_attribute->id)
                ->where('lead_status', 'Phone Call - No Show')
                ->where('user_id', $user)
                ->count();

            // Leads
            $call_no_show_count_lifetime = $call_no_show_records_count ?? 0;
            $call_no_show_count_today = call_no_show_days_count(0, $user, $call_no_show_attribute);
            $call_no_show_count_seven_days = call_no_show_days_count(7, $user, $call_no_show_attribute);
            $call_no_show_count_month = call_no_show_days_count(30, $user, $call_no_show_attribute);
            $call_no_show_count_ninety_days = call_no_show_days_count(90, $user, $call_no_show_attribute);
            $call_no_show_count_year = call_no_show_days_count(365, $user, $call_no_show_attribute);
        }

        // Contracts Signed
        $contracts_signed_records_count = 0;
        $contracts_signed_count_lifetime = 0;
        $contracts_signed_count_today = 0;
        $contracts_signed_count_seven_days = 0;
        $contracts_signed_count_month = 0;
        $contracts_signed_count_ninety_days = 0;
        $contracts_signed_count_year = 0;

        // Get attribute details
        $contracts_signed_attribute = goal_attribute::where('attribute', 'Contracts Signed')->first();
        if ($contracts_signed_attribute) {

            $contracts_signed_records_count = DB::table('contact_goals_reacheds')
                ->where('attribute_id', $contracts_signed_attribute->id)
                ->where('lead_status', 'Contract Signed - Buy Side')
                ->where('user_id', $user)
                ->count();

            // Leads
            $contracts_signed_count_lifetime = $contracts_signed_records_count ?? 0;
            $contracts_signed_count_today = contracts_signed_days_count(0, $user, $contracts_signed_attribute);
            $contracts_signed_count_seven_days = contracts_signed_days_count(7, $user, $contracts_signed_attribute);
            $contracts_signed_count_month = contracts_signed_days_count(30, $user, $contracts_signed_attribute);
            $contracts_signed_count_ninety_days = contracts_signed_days_count(90, $user, $contracts_signed_attribute);
            $contracts_signed_count_year = contracts_signed_days_count(365, $user, $contracts_signed_attribute);
        }

        // Deals closed
        $deal_closed_records_count = 0;
        $deal_closed_count_lifetime = 0;
        $deal_closed_count_today = 0;
        $deal_closed_count_seven_days = 0;
        $deal_closed_count_month = 0;
        $deal_closed_count_ninety_days = 0;
        $deal_closed_count_year = 0;

        // Get attribute details
        $deal_closed_attribute = goal_attribute::where('attribute', 'Deal Closed')->first();
        if ($deal_closed_attribute) {

            $deal_closed_records_count = DB::table('contact_goals_reacheds')
                ->where('attribute_id', $deal_closed_attribute->id)
                ->where('lead_status', 'Closed Deal - Buy Side')
                ->where('user_id', $user)
                ->count();

            // Leads
            $deal_closed_count_lifetime = $deal_closed_records_count ?? 0;
            $deal_closed_count_today = deal_closed_days_count(0, $user, $deal_closed_attribute);
            $deal_closed_count_seven_days = deal_closed_days_count(7, $user, $deal_closed_attribute);
            $deal_closed_count_month = deal_closed_days_count(30, $user, $deal_closed_attribute);
            $deal_closed_count_ninety_days = deal_closed_days_count(90, $user, $deal_closed_attribute);
            $deal_closed_count_year = deal_closed_days_count(365, $user, $deal_closed_attribute);
        }

        // Profit expected
        $profit_expected_records_count = 0;
        $profit_expected_count_lifetime = 0;
        $profit_expected_count_today = 0;
        $profit_expected_count_seven_days = 0;
        $profit_expected_count_month = 0;
        $profit_expected_count_ninety_days = 0;
        $profit_expected_count_year = 0;

        // Get attribute details
        $profit_expected_attribute = goal_attribute::where('attribute', 'Profit Expected')->first();
        if ($profit_expected_attribute) {

            $profit_expected_total = DB::table('contact_goals_reacheds')
                ->where('attribute_id', $profit_expected_attribute->id)
                ->whereNotNull('profit_expected')
                ->where('user_id', $user)
                ->sum('profit_expected');

            // Leads
            $profit_expected_count_lifetime = $profit_expected_records_count ?? 0;
            $profit_expected_count_today = profit_expected_days_count(0, $user, $profit_expected_attribute);
            $profit_expected_count_seven_days = profit_expected_days_count(7, $user, $profit_expected_attribute);
            $profit_expected_count_month = profit_expected_days_count(30, $user, $profit_expected_attribute);
            $profit_expected_count_ninety_days = profit_expected_days_count(90, $user, $profit_expected_attribute);
            $profit_expected_count_year = profit_expected_days_count(365, $user, $profit_expected_attribute);
        }

        // Profit collected
        $profit_collected_records_count = 0;
        $profit_collected_count_lifetime = 0;
        $profit_collected_count_today = 0;
        $profit_collected_count_seven_days = 0;
        $profit_collected_count_month = 0;
        $profit_collected_count_ninety_days = 0;
        $profit_collected_count_year = 0;

        // Get attribute details
        $profit_collected_attribute = goal_attribute::where('attribute', 'Profit Collected')->first();
        if ($profit_collected_attribute) {

            $profit_collected_total = DB::table('contact_goals_reacheds')
                ->where('attribute_id', $profit_collected_attribute->id)
                ->whereNotNull('profit_collected')
                ->where('user_id', $user)
                ->sum('profit_collected');

            // Leads
            $profit_collected_count_lifetime = $profit_collected_records_count ?? 0;
            $profit_collected_count_today = profit_collected_days_count(0, $user, $profit_collected_attribute);
            $profit_collected_count_seven_days = profit_collected_days_count(7, $user, $profit_collected_attribute);
            $profit_collected_count_month = profit_collected_days_count(30, $user, $profit_collected_attribute);
            $profit_collected_count_ninety_days = profit_collected_days_count(90, $user, $profit_collected_attribute);
            $profit_collected_count_year = profit_collected_days_count(365, $user, $profit_collected_attribute);
        }

        //goals
        $goal_people_reached = GoalsReached::where([['user_id', '=', $user], ['attribute_id', '=', '1']])->first();
        $goal_lead = GoalsReached::where([['user_id', '=', $user], ['attribute_id', '=', '2']])->first();
        $goal_appointment = GoalsReached::where([['user_id', '=', $user], ['attribute_id', '=', '3']])->first();
        $contacts_out = GoalsReached::where([['user_id', '=', $user], ['attribute_id', '=', '4']])->first();
        $contacts_signed = GoalsReached::where([['user_id', '=', $user], ['attribute_id', '=', '5']])->first();
        $deal_closed = GoalsReached::where([['user_id', '=', $user], ['attribute_id', '=', '6']])->first();
        $money_expected = GoalsReached::where([['user_id', '=', $user], ['attribute_id', '=', '7']])->first();
        $money_collected = GoalsReached::where([['user_id', '=', $user], ['attribute_id', '=', '8']])->first();

        $goalValue = $goal_people_reached->goals ?? 0;
        $goal_appointment = $goal_appointment->goals ?? 0;
        $goal_lead = $goal_lead->goals ?? 0;
        $contacts_out = $contacts_out->goals ?? 0;
        $contacts_signed = $contacts_signed->goals ?? 0;
        $deal_closed = $deal_closed->goals ?? 0;

        $money_expected = $money_expected->goals ?? 0;
        $money_collected = $money_collected->goals ?? 0;

        // Deals Closed
        $deals_lifetime = (UserAgreementSeller::where([['user_id', $user], ['is_sign', '2']])->count());
        $deals_todays = deal_count(0, $user);
        $deals_seven_day = deal_count(7, $user);
        $deals_month = deal_count(30, $user);
        $deals_ninety_day = deal_count(90, $user);
        $deals_year = deal_count(365, $user);

        //appointment
        $appointment_lifetime = (Scheduler::where([['user_id', $user], ['status', 'booked']])->count());
        $appointment_todays = appointment_count(0, $user);
        $appointment_seven_day = appointment_count(7, $user);
        $appointment_month = appointment_count(30, $user);
        $appointment_ninety_day = appointment_count(90, $user);
        $appointment_year = appointment_count(365, $user);



        // Contracts Signed
        $contracts_signed_lifetime = (UserAgreementSeller::where([['user_id', $user], ['is_sign', '2']])->count());
        $contracts_signed_todays = contracts_signed_count(0, $user);
        $contracts_signed_seven_day = contracts_signed_count(7, $user);
        $contracts_signed_month = contracts_signed_count(30, $user);
        $contracts_signed_ninety_day = contracts_signed_count(90, $user);
        $contracts_signed_year = contracts_signed_count(365, $user);

        // Contracts OUT
        $contracts_out_lifetime = (UserAgreementSeller::where([['user_id', $user]])->count());
        $contracts_out_todays = contracts_out_count(0, $user);
        $contracts_out_seven_day = contracts_out_count(7, $user);
        $contracts_out_month = contracts_out_count(30, $user);
        $contracts_out_ninety_day = contracts_out_count(90, $user);
        $contracts_out_year = contracts_out_count(365, $user);



        // Clean the input values and convert percentages to decimals
        $moneyExpected = GoalsReached::where([['user_id', '=', $user], ['attribute_id', '7']])->first();
        $collectedExpected = GoalsReached::where([['user_id', '=', $user], ['attribute_id', '8']])->first();

        if (!$moneyExpected) {

            $expected_money_todays = 0.00;
            $expected_money_seven_day = 0.00;
            $expected_money_month = 0.00;
            $expected_money_ninety_day = 0.00;
            $expected_money_year = 0.00;
            $expected_money_lifetime = 0.00;
        } else {
            $expected_money_lifetime = 0;

            $monthlyIncome = (float) preg_replace('/[^0-9.]/', '', $moneyExpected->goals);
            $grossProfit = (float) preg_replace('/[^0-9.]/', '', $moneyExpected->gross_profit);
            $leadConversion = (float) preg_replace('/[^0-9.]/', '', $moneyExpected->contact_trun_into_lead) / 100;
            $phoneContact = (float) preg_replace('/[^0-9.]/', '', $moneyExpected->leads_into_phone) / 100;
            $signedAgreements = (float) preg_replace('/[^0-9.]/', '', $moneyExpected->signed_agreements) / 100;
            $escrowClosure = (float) preg_replace('/[^0-9.]/', '', $moneyExpected->escrow_closure) / 100;

            $expected_money_todays = $monthlyIncome / 30;
            $expected_money_seven_day = $expected_money_todays * 7;
            $expected_money_month = $monthlyIncome;
            $expected_money_ninety_day = $monthlyIncome * 3;
            $expected_money_year = $monthlyIncome * 12;
            if ($leadConversion == 0 && $phoneContact == 0 && $signedAgreements == 0 && $escrowClosure == 0) {
                $expected_money_lifetime = 0.00; // All conversion rates are zero, set expected money to zero
            } else {
                $expected_money_lifetime = $monthlyIncome / (1 - (1 - $leadConversion) * (1 - $phoneContact) * (1 - $signedAgreements) * (1 - $escrowClosure));
            }
        }

        if (!$collectedExpected) {
            $money_collected_lifetime = 0.00;
            $money_collected_todays = 0.00;
            $money_collected_seven_day = 0.00;
            $money_collected_month = 0.00;
            $money_collected_ninety_day = 0.00;
            $money_collected_year = 0.00;
            $money_collected_lifetime = 0.00;
        } else {

            $money_collected_lifetime = 0;

            $monthlyIncome = (float) preg_replace('/[^0-9.]/', '', $collectedExpected->goals);
            $grossProfit = (float) preg_replace('/[^0-9.]/', '', $collectedExpected->gross_profit);
            $leadConversion = (float) preg_replace('/[^0-9.]/', '', $collectedExpected->contact_trun_into_lead) / 100;
            $phoneContact = (float) preg_replace('/[^0-9.]/', '', $collectedExpected->leads_into_phone) / 100;
            $signedAgreements = (float) preg_replace('/[^0-9.]/', '', $collectedExpected->signed_agreements) / 100;
            $escrowClosure = (float) preg_replace('/[^0-9.]/', '', $collectedExpected->escrow_closure) / 100;

            $money_collected_todays = $monthlyIncome * $leadConversion * $phoneContact * $signedAgreements * $escrowClosure;
            $money_collected_seven_day = $money_collected_todays * 7;
            $money_collected_month = $monthlyIncome * $leadConversion * $phoneContact * $signedAgreements * $escrowClosure;
            $money_collected_ninety_day = $money_collected_month * 3;
            $money_collected_year = $money_collected_month * 12;

            $money_collected_lifetime = $monthlyIncome;

            if ($leadConversion > 0 && $phoneContact > 0 && $signedAgreements > 0 && $escrowClosure > 0) {
                $money_collected_lifetime *= $leadConversion * $phoneContact * $signedAgreements * $escrowClosure;
            } else {
                // Handle the case where any conversion rate is zero
                $money_collected_lifetime = 0.00;
            }
        }

        //    $messages_sent_week=(Sms::whereDate('created_at', Carbon::today())->where('is_received',0)->withTrashed()->count())+(Reply::where('system_reply',1)->whereDate('created_at', Carbon::today())->withTrashed()->count());
        //    $messages_received_week=(Sms::whereDate('created_at', Carbon::today())->where('is_received',1)->withTrashed()->count())+(Reply::where('system_reply',0)->whereDate('created_at', Carbon::today())->withTrashed()->count());


        if (Gate::allows('user_module') || Gate::allows('administrator')) {
            $users = User::all();
            // $tasks = TaskList::all();
            $tasks = TaskList::orderBy('position')->where('user_id', auth()->id())->get();
            // $tasks = TaskList::all();

        }else{
            return abort(401);
        }

        $reminders = FollowupSequences::whereNotNull('followup_reminder')->get();

        return view('back.index', compact(
            'users',
            'tasks',
            'goalValue',
            'lead_records_count',
            'leads_count_lifetime',
            'leads_count_today',
            'leads_count_seven_days',
            'leads_count_month',
            'leads_count_ninety_days',
            'leads_count_year',

            'scheduled_appointments_records_count',
            'scheduled_appointments_count_lifetime',
            'scheduled_appointments_count_today',
            'scheduled_appointments_count_seven_days',
            'scheduled_appointments_count_month',
            'scheduled_appointments_count_ninety_days',
            'scheduled_appointments_count_year',

            'appointments_showup_records_count',
            'appointments_showup_count_lifetime',
            'appointments_showup_count_today',
            'appointments_showup_count_seven_days',
            'appointments_showup_count_month',
            'appointments_showup_count_ninety_days',
            'appointments_showup_count_year',

            // Call No Show
            'call_no_show_records_count',
            'call_no_show_count_lifetime',
            'call_no_show_count_today',
            'call_no_show_count_seven_days',
            'call_no_show_count_month',
            'call_no_show_count_ninety_days',
            'call_no_show_count_year',

            // Contracts Signed
            'contracts_signed_records_count',
            'contracts_signed_count_lifetime',
            'contracts_signed_count_today',
            'contracts_signed_count_seven_days',
            'contracts_signed_count_month',
            'contracts_signed_count_ninety_days',
            'contracts_signed_count_year',

            // Deals closed
            'deal_closed_records_count',
            'deal_closed_count_lifetime',
            'deal_closed_count_today',
            'deal_closed_count_seven_days',
            'deal_closed_count_month',
            'deal_closed_count_ninety_days',
            'deal_closed_count_year',

            // Profit expected
            'profit_expected_records_count',
            'profit_expected_count_lifetime',
            'profit_expected_count_today',
            'profit_expected_count_seven_days',
            'profit_expected_count_month',
            'profit_expected_count_ninety_days',
            'profit_expected_count_year',

            // Profit collected
            'profit_collected_records_count',
            'profit_collected_count_lifetime',
            'profit_collected_count_today',
            'profit_collected_count_seven_days',
            'profit_collected_count_month',
            'profit_collected_count_ninety_days',
            'profit_collected_count_year',

            'total_sent_lifetime',
            'total_received_lifetime',
            'messages_sent_today',
            'messages_received_today',
            "settings",
            'messages_sent_today_goals',
            'messages_sent_seven_days_goals',
            'messages_sent_month_days_goals',
            'messages_sent_ninety_days_goals',
            'messages_sent_year_goals',
            'messages_received_today_goals',
            'messages_received_seven_days_goals',
            'messages_received_month_days_goals',
            'messages_received_ninety_days_goals',
            'messages_received_year_goals',
            'appointment_todays',
            'appointment_seven_day',
            'appointment_month',
            'appointment_ninety_day',
            'appointment_year',
            'appointment_lifetime',
            'goal_lead',
            'goal_appointment',
            'contacts_out',
            'contacts_signed',
            'deal_closed',
            'money_expected',
            'money_collected',
            'deals_lifetime',
            'deals_todays',
            'deals_seven_day',
            'deals_month',
            'deals_ninety_day',
            'deals_year',

            'people_touched_records_count',
            'people_touched_lifetime',
            'people_touched_today',
            'people_touched_seven_days',
            'people_touched_month',
            'people_touched_ninety_days',
            'people_touched_year',
            'contracts_signed_lifetime',
            'contracts_signed_todays',
            'contracts_signed_seven_day',
            'contracts_signed_month',
            'contracts_signed_ninety_day',
            'contracts_signed_year',
            'contracts_out_lifetime',
            'contracts_out_todays',
            'contracts_out_seven_day',
            'contracts_out_month',
            'contracts_out_ninety_day',
            'contracts_out_year',
            'expected_money_todays',
            'expected_money_seven_day',
            'expected_money_month',
            'expected_money_ninety_day',
            'expected_money_year',
            'expected_money_lifetime',
            'money_collected_todays',
            'money_collected_seven_day',
            'money_collected_month',
            'money_collected_ninety_day',
            'money_collected_year',
            'money_collected_lifetime',
            'reminders'
        ));
    }

    // Get Goals based on custom date range
    public function getGoals(Request $request)
    {
        $start_date = Carbon::parse($request->start_date);
        $end_date = Carbon::parse($request->end_date);

        // Get current auth user
        $user = Auth::id();

        // Get people touched count
        $people_touched_count = people_touch_range_count($start_date, $end_date, $user);

        // Get Lead count
        $leads_count = leads_range_count($start_date, $end_date, $user);

        // Get Leads- scheduled appointments count
        $lead_scheduled_count = leads_scheduled_count($start_date, $end_date, $user);

        // Get appointments show up count
        $appointments_showup_count = appointments_showup_count($start_date, $end_date, $user);

        // Get call no show count
        $call_no_show_count = call_no_show_count($start_date, $end_date, $user);

        // Get deals closed count by date range
        $deals_count = deals_count_range($start_date, $end_date, $user);

        // Get appointments count
        $appointments_count = appointments_count($start_date, $end_date, $user);

        // Get contracts signed count
        $contracts_signed_count = contracts_signed_range_count($start_date, $end_date, $user);

        // Get contracts lifetime count
        $contracts_out_count = contracts_out_range_count($start_date, $end_date, $user);

        // Get money expected count
        $profit_expected_count = profit_expected_range_count($start_date, $end_date, $user);

        // Get money collected count
        $profit_collected_count = profit_collected_range_count($start_date, $end_date, $user);

        return response()->json([
            'status' => true,
            'message' => 'Goals stats fetched successfully!',
            'data' => [
                'people_touched_count' => $people_touched_count,
                'leads_count' => $leads_count,
                'deals_count' => $deals_count,
                'lead_scheduled_count' => $lead_scheduled_count,
                'appointments_showup_count' => $appointments_showup_count,
                'call_no_show_count' => $call_no_show_count,
                'appointments_count' => $appointments_count,
                'contracts_signed_count' => $contracts_signed_count,
                'contracts_out_count' => $contracts_out_count,
                'profit_expected_count' => '$' . $profit_expected_count,
                'profit_collected_count' => '$' . $profit_collected_count
            ]
        ]);
    }

    public function setGoals(Request $request)
    {

        $user = Auth::id();
        $goal = GoalsReached::all();
        $goal->load(['goal_attribute', 'user']);
        return view('back.pages.goal-settings.index', compact('goal'));
    }

    public function createGoals(Request $request)
    {

        $users = User::all();
        $attributes = goal_attribute::all();
        return view('back.pages.goal-settings.create', compact('users', 'attributes'));
    }
    public function editGoals(Request $request, $id)
    {
        $goal = GoalsReached::where('id', '=', $id)->first();
        $goal->load(['goal_attribute', 'user']);
        $users = User::all();
        $attributes = goal_attribute::all();
        return view('back.pages.goal-settings.edit', compact('goal', 'users', 'attributes'));
    }
    public function updateGoals(Request $request, $id)
    {
        $validatedData = $request->validate([
            'goal' => 'required|numeric',
            'user' => 'required',
            'attribute' => 'required',
        ]);
        $user = Auth::id();
        $goal = GoalsReached::where('id', '=', $id)->first();
        $goal->goals = $request->goal;
        $goal->user_id = $request->user;
        $goal->attribute_id = $request->attribute;
        $goal->money_per_month = $request->money_per_month ?? 0;
        $goal->gross_profit = $request->gross_profit ?? 0;
        $goal->contact_trun_into_lead = $request->contact_trun_into_lead ?? 0;
        $goal->leads_into_phone = $request->leads_into_phone ?? 0;
        $goal->signed_agreements = $request->signed_agreements ?? 0;
        $goal->escrow_closure = $request->escrow_closure ?? 0;
        $goal->passed_inspection = $request->passed_inspection ?? 0;
        $goal->passed_title_search = $request->passed_title_search ?? 0;
        $goal->deal_closed = $request->deal_closed ?? 0;
        $goal->save();
        // Alert::success('Success','Goal Saved!');
        return redirect()->route('admin.setgoals')->with('Success', 'Goal Saved!');
    }
    public function deleteGoals(Request $request, $id)
    {
        $goal = GoalsReached::where('id', '=', $id)->first();
        $goal->delete();
        return redirect()->route('admin.setgoals')->with('Success', 'Goal Saved!');
    }
    public function saveGoals(Request $request)
    {
        // return "Test";
        $validatedData = $request->validate([
            'goal' => 'required|numeric',
            'user' => 'required',
            'attribute' => 'required',
        ]);
        $user = Auth::id();
        $goal = new GoalsReached();
        $goal->goals = $request->goal;
        $goal->user_id = $request->user;
        $goal->attribute_id = $request->attribute;
        $goal->money_per_month = $request->money_per_month ?? 0;
        $goal->gross_profit = $request->gross_profit ?? 0;
        $goal->passed_inspection = $request->passed_inspection ?? 0;
        $goal->passed_title_search = $request->passed_title_search ?? 0;
        $goal->deal_closed = $request->deal_closed ?? 0;
        $goal->contact_trun_into_lead = $request->contact_trun_into_lead ?? 0;
        $goal->leads_into_phone = $request->leads_into_phone ?? 0;
        $goal->save();
        // Alert::success('Success','Goal Saved!');
        return redirect()->route('admin.setgoals')->with('Success', 'Goal Saved!');
    }
}
