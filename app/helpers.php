<?php

use App\Model\Sms;
use App\Model\Reply;
use App\Model\Scheduler;
use App\Model\CustomField;
use App\Model\CustomFieldValue;
use Carbon\Carbon;
use App\Model\UserAgreement;
use App\Model\UserAgreementSeller;
function getReportingDataOfSMS($days)
{
    $messages_sent_today_goals=0;
    if($days==0)
    {
    $messages_sent_today_goals=Sms::distinct('client_number')->whereDate('created_at', Carbon::today()->subDays($days))->where('is_received', 0)->withTrashed()->count();
    $messages_sent_recieved_today_goals=Reply::distinct('to')->whereDate('created_at', Carbon::today()->subDays($days))->where('system_reply',1)->withTrashed()->count();
    $messages_sent_today_goals+=$messages_sent_recieved_today_goals;
    }
    else
    {
        $messages_sent_today_goals=Sms::distinct('client_number')->whereBetween('created_at', [Carbon::today()->subDays($days),Carbon::today()])->where('is_received', 0)->withTrashed()->count();
        $messages_sent_recieved_today_goals=Reply::distinct('to')->whereBetween('created_at', [Carbon::today()->subDays($days),Carbon::today()])->where('system_reply',1)->withTrashed()->count();
        $messages_sent_today_goals+=$messages_sent_recieved_today_goals;
    }
    return $messages_sent_today_goals;
}

function getReportingDataOfSMSreceived($days)
{
    $messages_sent_today_goals=0;
    if($days==0)
    {
    $messages_sent_today_goals=Sms::distinct('client_number')->whereDate('created_at', Carbon::today()->subDays($days))->where('is_received', 1)->withTrashed()->count();
    $messages_sent_recieved_today_goals=Reply::distinct('to')->whereDate('created_at', Carbon::today()->subDays($days))->where('system_reply',0)->withTrashed()->count();
    $messages_sent_today_goals+=$messages_sent_recieved_today_goals;
    }
    else
    {
        $messages_sent_today_goals=Sms::distinct('client_number')->whereBetween('created_at', [Carbon::today()->subDays($days),Carbon::today()])->where('is_received', 1)->withTrashed()->count();
        $messages_sent_recieved_today_goals=Reply::distinct('to')->whereBetween('created_at', [Carbon::today()->subDays($days),Carbon::today()])->where('system_reply',0)->withTrashed()->count();
        $messages_sent_today_goals+=$messages_sent_recieved_today_goals;
    }
    return $messages_sent_today_goals;
}

function appointment_count($days,$user)
{
    $messages_sent_today_goals=0;
    if($days==0)
    {
        $appointment_count=Scheduler::whereDate('created_at', Carbon::today()->subDays($days))->where([['status', 'booked'],['user_id',$user]])->count();

    }
    else
    {
        $appointment_count=Scheduler::whereBetween('created_at', [Carbon::today()->subDays($days),Carbon::today()])->where([['status', 'booked'],['user_id',$user]])->count();

    }
    return $appointment_count;
}


function deal_count($days,$user)
{
    $messages_sent_today_goals=0;
    if($days==0)
    {
        $deals_count=UserAgreementSeller::whereDate('created_at', Carbon::today()->subDays($days))->where([['is_sign', '2'],['user_id',$user]])->count();

    }
    else
    {
        $deals_count=UserAgreementSeller::whereBetween('created_at', [Carbon::today()->subDays($days),Carbon::today()])->where([['is_sign', '2'],['user_id',$user]])->count();

    }
    return $deals_count;
}

function contracts_signed_count($days,$user)
{
    $messages_sent_today_goals=0;
    if($days==0)
    {
        $contracts_signed_count=UserAgreementSeller::whereDate('created_at', Carbon::today()->subDays($days))->where([['is_sign', '2'],['user_id',$user]])->count();

    }
    else
    {
        $contracts_signed_count=UserAgreementSeller::whereBetween('created_at', [Carbon::today()->subDays($days),Carbon::today()])->where([['is_sign', '2'],['user_id',$user]])->count();

    }
    return $contracts_signed_count;
}


function contracts_out_count($days,$user)
{
    $messages_sent_today_goals=0;
    if($days==0)
    {
        $contracts_out_count=UserAgreementSeller::whereDate('created_at', Carbon::today()->subDays($days))->where([['user_id',$user]])->count();

    }
    else
    {
        $contracts_out_count=UserAgreementSeller::whereBetween('created_at', [Carbon::today()->subDays($days),Carbon::today()])->where([['user_id',$user]])->count();

    }
    return $contracts_out_count;
}


function getsectionsFields($section_id)
{
    return CustomField::where('section_id',$section_id)->get();
}

function getsectionsFieldValue($id,$field_id)
{
    $value =  CustomFieldValue::where('contact_id' , $id)->where('feild_id' , $field_id)->first();
    if($value){
        return $value->feild_value;
    }else{
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

