<?php

use App\Model\Sms;
use App\Model\Reply;
use App\Model\Scheduler;
use App\Model\CustomField;
use App\Model\CustomFieldValue;
use Carbon\Carbon;

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

