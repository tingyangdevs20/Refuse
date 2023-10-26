<?php

use App\goal_attribute;
use App\Model\Sms;
use App\Model\Reply;
use App\Model\Scheduler;
use App\Model\CustomField;
use App\Model\CustomFieldValue;
use App\Model\GoalsReached;
use Carbon\Carbon;
use App\Model\UserAgreement;
use App\Model\UserAgreementSeller;
use Illuminate\Support\Facades\DB;

function getReportingDataOfSMS($days)
{
    $messages_sent_today_goals = 0;
    if ($days == 0) {
        $messages_sent_today_goals = Sms::distinct('client_number')->whereDate('created_at', Carbon::today()->subDays($days))->where('is_received', 0)->withTrashed()->count();
        $messages_sent_recieved_today_goals = Reply::distinct('to')->whereDate('created_at', Carbon::today()->subDays($days))->where('system_reply', 1)->withTrashed()->count();
        $messages_sent_today_goals += $messages_sent_recieved_today_goals;
    } else {
        $messages_sent_today_goals = Sms::distinct('client_number')->whereBetween('created_at', [Carbon::today()->subDays($days), Carbon::today()])->where('is_received', 0)->withTrashed()->count();
        $messages_sent_recieved_today_goals = Reply::distinct('to')->whereBetween('created_at', [Carbon::today()->subDays($days), Carbon::today()])->where('system_reply', 1)->withTrashed()->count();
        $messages_sent_today_goals += $messages_sent_recieved_today_goals;
    }
    return $messages_sent_today_goals;
}

function getReportingDataOfSMSreceived($days)
{
    $messages_sent_today_goals = 0;
    if ($days == 0) {
        $messages_sent_today_goals = Sms::distinct('client_number')->whereDate('created_at', Carbon::today()->subDays($days))->where('is_received', 1)->withTrashed()->count();
        $messages_sent_recieved_today_goals = Reply::distinct('to')->whereDate('created_at', Carbon::today()->subDays($days))->where('system_reply', 0)->withTrashed()->count();
        $messages_sent_today_goals += $messages_sent_recieved_today_goals;
    } else {
        $messages_sent_today_goals = Sms::distinct('client_number')->whereBetween('created_at', [Carbon::today()->subDays($days), Carbon::today()])->where('is_received', 1)->withTrashed()->count();
        $messages_sent_recieved_today_goals = Reply::distinct('to')->whereBetween('created_at', [Carbon::today()->subDays($days), Carbon::today()])->where('system_reply', 0)->withTrashed()->count();
        $messages_sent_today_goals += $messages_sent_recieved_today_goals;
    }
    return $messages_sent_today_goals;
}

function appointment_count($days, $user)
{
    $appointment_count = 0;
    if ($days == 0) {
        $appointment_count = Scheduler::whereDate('created_at', Carbon::today()->subDays($days))->where([['status', 'booked'], ['user_id', $user]])->count();
    } else {
        $appointment_count = Scheduler::whereBetween('created_at', [Carbon::today()->subDays($days), Carbon::today()])->where([['status', 'booked'], ['user_id', $user]])->count();
    }
    return $appointment_count;
}

function appointments_count($start_date, $end_date, $user)
{
    $appointment_count = 0;
    $query = Scheduler::where([['status', 'booked'], ['user_id', $user]]);

    if ($start_date && $end_date) {
        // If both start_date and end_date are provided, use the date range
        $query->whereBetween('created_at', [$start_date, $end_date]);
    } else {
        // If either start_date or end_date is not provided, use today's date for comparison
        $query->whereDate('created_at', Carbon::today());
    }

    $appointment_count = $query->count();
    return $appointment_count;
}


function deal_count($days, $user)
{
    $deals_count = 0;

    if ($days == 0) {
        $deals_count = UserAgreementSeller::whereDate('created_at', Carbon::today()->subDays($days))->where([['is_sign', '2'], ['user_id', $user]])->count();
    } else {
        $deals_count = UserAgreementSeller::whereBetween('created_at', [Carbon::today()->subDays($days), Carbon::today()])->where([['is_sign', '2'], ['user_id', $user]])->count();
    }

    return $deals_count;
}

// Get poeple touched count with days
function people_touched_days_count($days, $user, $attribute)
{
    $count = 0;

    if ($days == 0) {
        $count = DB::table('contact_goals_reacheds')
            ->where('attribute_id', $attribute->id)
            ->where('lead_status', 'Prospect')
            ->where('user_id', $user)
            ->whereDate('recorded_at', Carbon::today()->subDays($days))
            ->count();
    } else {
        $count = DB::table('contact_goals_reacheds')
            ->where('attribute_id', $attribute->id)
            ->where('lead_status', 'Prospect')
            ->where('user_id', $user)
            ->whereBetween('recorded_at', [Carbon::today()->subDays($days), Carbon::today()])
            ->count();
    }

    return $count;
}

// Get leads count count with days
function leads_days_count($days, $user, $attribute)
{
    $count = 0;

    if ($days == 0) {
        $count = DB::table('contact_goals_reacheds')
            ->where('attribute_id', $attribute->id)
            ->where('lead_status', 'Lead')
            ->where('user_id', $user)
            ->whereDate('recorded_at', Carbon::today()->subDays($days))
            ->count();
    } else {
        $count = DB::table('contact_goals_reacheds')
            ->where('attribute_id', $attribute->id)
            ->where('lead_status', 'Lead')
            ->where('user_id', $user)
            ->whereBetween('recorded_at', [Carbon::today()->subDays($days), Carbon::today()])
            ->count();
    }

    return $count;
}

// get scheduled appointments count
function scheduled_appointments_days_count($days, $user, $attribute)
{
    $count = 0;

    if ($days == 0) {
        $count = DB::table('contact_goals_reacheds')
            ->where('attribute_id', $attribute->id)
            ->where('lead_status', 'Phone Call - Scheduled')
            ->where('user_id', $user)
            ->whereDate('recorded_at', Carbon::today()->subDays($days))
            ->count();
    } else {
        $count = DB::table('contact_goals_reacheds')
            ->where('attribute_id', $attribute->id)
            ->where('lead_status', 'Phone Call - Scheduled')
            ->where('user_id', $user)
            ->whereBetween('recorded_at', [Carbon::today()->subDays($days), Carbon::today()])
            ->count();
    }

    return $count;
}

// Get appointments show up count
function appointments_showup_days_count($days, $user, $attribute)
{
    $count = 0;

    if ($days == 0) {
        $count = DB::table('contact_goals_reacheds')
            ->where('attribute_id', $attribute->id)
            ->where('lead_status', 'Phone Call - Completed')
            ->where('user_id', $user)
            ->whereDate('recorded_at', Carbon::today()->subDays($days))
            ->count();
    } else {
        $count = DB::table('contact_goals_reacheds')
            ->where('attribute_id', $attribute->id)
            ->where('lead_status', 'Phone Call - Completed')
            ->where('user_id', $user)
            ->whereBetween('recorded_at', [Carbon::today()->subDays($days), Carbon::today()])
            ->count();
    }

    return $count;
}

// Get Calls no show count
function call_no_show_days_count($days, $user, $attribute)
{
    $count = 0;

    if ($days == 0) {
        $count = DB::table('contact_goals_reacheds')
            ->where('attribute_id', $attribute->id)
            ->where('lead_status', 'Phone Call - No Show')
            ->where('user_id', $user)
            ->whereDate('recorded_at', Carbon::today()->subDays($days))
            ->count();
    } else {
        $count = DB::table('contact_goals_reacheds')
            ->where('attribute_id', $attribute->id)
            ->where('lead_status', 'Phone Call - No Show')
            ->where('user_id', $user)
            ->whereBetween('recorded_at', [Carbon::today()->subDays($days), Carbon::today()])
            ->count();
    }

    return $count;
}

// Get Contracts signed count
function contracts_signed_days_count($days, $user, $attribute)
{
    $count = 0;

    if ($days == 0) {
        $count = DB::table('contact_goals_reacheds')
            ->where('attribute_id', $attribute->id)
            ->where('lead_status', 'Contract Signed - Buy Side')
            ->where('user_id', $user)
            ->whereDate('recorded_at', Carbon::today()->subDays($days))
            ->count();
    } else {
        $count = DB::table('contact_goals_reacheds')
            ->where('attribute_id', $attribute->id)
            ->where('lead_status', 'Contract Signed - Buy Side')
            ->where('user_id', $user)
            ->whereBetween('recorded_at', [Carbon::today()->subDays($days), Carbon::today()])
            ->count();
    }

    return $count;
}

// Get Deals closed count
function deal_closed_days_count($days, $user, $attribute)
{
    $count = 0;

    if ($days == 0) {
        $count = DB::table('contact_goals_reacheds')
            ->where('attribute_id', $attribute->id)
            ->where('lead_status', 'Closed Deal - Buy Side')
            ->where('user_id', $user)
            ->whereDate('recorded_at', Carbon::today()->subDays($days))
            ->count();
    } else {
        $count = DB::table('contact_goals_reacheds')
            ->where('attribute_id', $attribute->id)
            ->where('lead_status', 'Closed Deal - Buy Side')
            ->where('user_id', $user)
            ->whereBetween('recorded_at', [Carbon::today()->subDays($days), Carbon::today()])
            ->count();
    }

    return $count;
}


// Get deals count within specific date range
function deals_count_range($start_date, $end_date, $user)
{
    $count = 0;
    // Get attribute details
    $attribute = goal_attribute::where('attribute', 'Deal Closed')->first();
    if ($attribute) {

        $count = DB::table('contact_goals_reacheds')
        ->where('attribute_id', $attribute->id)
        ->where('lead_status', 'Closed Deal - Buy Side')
        ->where('user_id', $user)
        ->whereBetween('recorded_at', [$start_date, $end_date]) // Add date range condition
        ->count();
    }
    return $count;
}

// Get Profit expected sum
function profit_expected_days_count($days, $user, $attribute)
{
    $count = 0;

    if ($days == 0) {
        $count = DB::table('contact_goals_reacheds')
            ->where('attribute_id', $attribute->id)
            ->whereNotNull('profit_expected')
            ->where('user_id', $user)
            ->whereDate('recorded_at', Carbon::today()->subDays($days))
            ->sum('profit_expected');
    } else {
        $count = DB::table('contact_goals_reacheds')
            ->where('attribute_id', $attribute->id)
            ->whereNotNull('profit_expected')
            ->where('user_id', $user)
            ->whereBetween('recorded_at', [Carbon::today()->subDays($days), Carbon::today()])
            ->sum('profit_expected');
    }

    return $count;
}


function contracts_signed_count($days, $user)
{
    $messages_sent_today_goals = 0;
    if ($days == 0) {
        $contracts_signed_count = UserAgreementSeller::whereDate('created_at', Carbon::today()->subDays($days))->where([['is_sign', '2'], ['user_id', $user]])->count();
    } else {
        $contracts_signed_count = UserAgreementSeller::whereBetween('created_at', [Carbon::today()->subDays($days), Carbon::today()])->where([['is_sign', '2'], ['user_id', $user]])->count();
    }
    return $contracts_signed_count;
}

function contracts_signed_range_count($start_date, $end_date, $user)
{
    $count = 0;
    // Get attribute details
    $attribute = goal_attribute::where('attribute', 'Contracts Signed')->first();
    if ($attribute) {

        $count = DB::table('contact_goals_reacheds')
            ->where('attribute_id', $attribute->id)
            ->where('lead_status', 'Contract Signed - Buy Side')
            ->where('user_id', $user)
            ->whereBetween('recorded_at', [$start_date, $end_date])
            ->count();
    }
    return $count;
}


function contracts_out_count($days, $user)
{
    $contracts_out_count = 0;
    if ($days == 0) {
        $contracts_out_count = UserAgreementSeller::whereDate('created_at', Carbon::today()->subDays($days))->where([['user_id', $user]])->count();
    } else {
        $contracts_out_count = UserAgreementSeller::whereBetween('created_at', [Carbon::today()->subDays($days), Carbon::today()])->where([['user_id', $user]])->count();
    }
    return $contracts_out_count;
}

function contracts_out_range_count($start_date, $end_date, $user)
{
    $contracts_out_count = 0;
    $query = UserAgreementSeller::where([['user_id', $user]]);

    if ($start_date && $end_date) {
        // If both start_date and end_date are provided, use the date range
        $query->whereBetween('created_at', [$start_date, $end_date]);
    } else {
        // If either start_date or end_date is not provided, use today's date for comparison
        $query->whereDate('created_at', Carbon::today());
    }

    $contracts_out_count = $query->count();
    return $contracts_out_count;
}

function profit_expected_range_count($start_date, $end_date, $user)
{
    $count = 0;
    // Get attribute details
    $attribute = goal_attribute::where('attribute', 'Profit Expected')->first();
    if ($attribute) {

        $count = DB::table('contact_goals_reacheds')
        ->where('attribute_id', $attribute->id)
        ->whereNotNull('profit_expected')
        ->where('user_id', $user)
        ->whereBetween('recorded_at', [$start_date, $end_date]) // Add date range condition
        ->sum('profit_expected');

    }
    return $count;
}

function money_collected_range_count($start_date, $end_date, $user)
{
    // Clean the input values and convert percentages to decimals
    $moneyCollected = 0;

    $money_collected_reached = GoalsReached::where([
        ['user_id', '=', $user],
        ['attribute_id', '=', 8], // Assuming 'attribute_id' is a specific value
    ])
        ->whereBetween('created_at', [$start_date, $end_date]) // Add date range condition
        ->first();

    if ($money_collected_reached) {
        $moneyCollected = $money_collected_reached->goals;
    }

    return $moneyCollected;
}

function people_touch_range_count($start_date, $end_date, $user)
{
    $count = 0;

    $attribute = goal_attribute::where('attribute', 'People Reached')->first();
    if ($attribute) {
        $count = DB::table('contact_goals_reacheds')
            ->where('attribute_id', $attribute->id)
            ->where('lead_status', 'Prospect')
            ->where('user_id', $user)
            ->whereBetween('recorded_at', [$start_date, $end_date]) // Add date range condition
            ->count();
    }

    return $count;
}

function leads_range_count($start_date, $end_date, $user)
{
    $count = 0;

    $attribute = goal_attribute::where('attribute', 'Lead')->first();
    if ($attribute) {
        $count = DB::table('contact_goals_reacheds')
            ->where('attribute_id', $attribute->id)
            ->where('lead_status', 'Lead')
            ->where('user_id', $user)
            ->whereBetween('recorded_at', [$start_date, $end_date]) // Add date range condition
            ->count();
    }

    return $count;
}

function leads_scheduled_count($start_date, $end_date, $user)
{
    $count = 0;
    // Get attribute details
    $attribute = goal_attribute::where('attribute', 'Phone Appointment')->first();
    if ($attribute) {

        $count = DB::table('contact_goals_reacheds')
            ->where('attribute_id', $attribute->id)
            ->where('lead_status', 'Phone Call - Scheduled')
            ->where('user_id', $user)
            ->whereBetween('recorded_at', [$start_date, $end_date]) // Add date range condition
            ->count();
    }
    return $count;
}

function appointments_showup_count($start_date, $end_date, $user)
{
    $count = 0;
    // Get attribute details
    $attribute = goal_attribute::where('attribute', 'Appointments Show Up')->first();
    if ($attribute) {

        $count = DB::table('contact_goals_reacheds')
            ->where('attribute_id', $attribute->id)
            ->where('lead_status', 'Phone Call - Completed')
            ->where('user_id', $user)
            ->whereBetween('recorded_at', [$start_date, $end_date]) // Add date range condition
            ->count();
    }
    return $count;
}

function call_no_show_count($start_date, $end_date, $user)
{
    $count = 0;
    // Get attribute details
    $attribute = goal_attribute::where('attribute', 'Call No Show')->first();
    if ($attribute) {

        $count = DB::table('contact_goals_reacheds')
            ->where('attribute_id', $attribute->id)
            ->where('lead_status', 'Phone Call - No Show')
            ->where('user_id', $user)
            ->whereBetween('recorded_at', [$start_date, $end_date]) // Add date range condition
            ->count();
    }

    return $count;
}

function getsectionsFields($section_id)
{
    return CustomField::where('section_id', $section_id)->get();
}

function getsectionsFieldValue($id, $field_id)
{
    $value =  CustomFieldValue::where('contact_id', $id)->where('feild_id', $field_id)->first();
    if ($value) {
        return $value->feild_value;
    } else {
        return '';
    }
}

function gmail_remove_reply_part($from, $to, $str)
{

    $char1 = "<{$from}>";
    $char2 = "<{$to}>";
    // $pos = strpos($str, $char1);
    if (strpos($str, $char1) !== false) {
        //$char was found, so return everything up to it.
        $string = substr($str, 0, strpos($str, $char1) + strlen($char1));
    } else {
        //this will return the original string if $char is not found.  if you wish to return a blank string when not found, just change $str to ''
        $string = $str;
    }

    $lines = explode("\n", $string);

    foreach ($lines as $index => $line) {
        if (strstr($line, $char1)) {
            unset($lines[$index]);
        }
    }

    $string = implode("\n", $lines);

    if (strpos($string, $char2) !== false) {
        //$char was found, so return everything up to it.
        $string = substr($str, 0, strpos($str, $char2) + strlen($char2));
    }

    $lines = explode("\n", $string);

    foreach ($lines as $index => $line) {
        if (strstr($line, $char2)) {
            unset($lines[$index]);
        }
    }

    $string = implode("\n", $lines);

    return $string = implode("\n", $lines);
}
