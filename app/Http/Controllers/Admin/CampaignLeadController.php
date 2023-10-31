<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\CampaignLead;
use App\Mail\TestEmail;
use App\Model\CampaignLeadList;
use Illuminate\Support\Facades\Mail;
use App\Model\Group;
use App\Model\Number;
use App\Model\Contact;
use App\Model\Account;
use App\Model\Template;
use App\Model\FailedSms;
use App\Model\Reply;
use App\Model\Sms;
use Twilio\Rest\Client;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CampaignLeadController extends Controller
{
    public function index()
    {
        $groups = Group::all(); // Fetch groups from the database
        $campaigns = CampaignLead::getAllLeadsCampaign();
        $templates = Template::where('type', 'SMS')->get();
        return view('back.pages.campaignleads.index', compact('groups', 'campaigns', 'templates'));
    }
    public function changeStatus(Request $request)
    {

        $id=$request->id;
        $camp = CampaignLead::where('id' , $id)->first();
        $camp->active = $request->sts;

        $camp->save();
        return response()->json(['success'=>'Status changed successfully.']);
    }

    public function copy($id = '')
    {
        $campaigns = CampaignLead::where('id', $id)->first();
        if ($campaigns) {
            $compaignRes = CampaignLead::create([
                'name' => $campaigns->name,
               // 'group_id' => $campaigns->group_id,
                'active' => $campaigns->active,
            ]);
           // dd($campaigns);
            $campaign_id = $compaignRes->id;
            $checkCompainList = CampaignLeadList::where('campaign_id', $id)->get();
           // dd($checkCompainList);
            if (count($checkCompainList) > 0) {
                foreach ($checkCompainList as $compaign) {
                    $insertData = array(
                        "campaign_id" => $campaign_id,
                        "type" => $compaign->type,
                        "send_after_days" => $compaign->send_after_days,
                        "send_after_hours" => $compaign->send_after_hours,
                        "body" => $compaign->body,
                        "subject" => $compaign->subject,
                        "mediaUrl" => $compaign->mediaUrl,
                        "template_id" => 0
                    );
                    $c_id = CampaignLeadList::create($insertData);
                    $checkCompainList = CampaignLeadList::where('campaign_id', $campaign_id)->get();
                }
            }



        }
      //  return redirect()->route('admin.leadcampaigns.index')->with('success', 'Campaign created successfully.');
      return redirect()->back();
    }

    public function schedual()
    {
        $currentTime = date('Y-m-d H:i:s');
        //$scheduleTime = '2023-08-21 07:43:02';
        $campaigns = CampaignLead::where('active', 1)->get();
        //dd($campaigns);
        if (count($campaigns) > 0) {
            foreach ($campaigns as $key1 => $camp) {
                $campaignsList = CampaignLeadList::where('campaign_id', $camp->id)->where('active', 1)->orderby('schedule', 'ASC')->get();
                if (count($campaignsList) > 0) {
                    foreach ($campaignsList as $key => $row) {
                        $schedule = date('Y-m-d H:i:s', strtotime($row->schedule));
                        if ($schedule <= $currentTime) {
                            $account = Account::first();
                            if ($account) {
                                $sid = $account->account_id;
                                $token = $account->account_token;
                            } else {
                                $sid = '';
                                $token = '';
                            }
                            $template = Template::where('id', $row->template_id)->first();
                            if ($row->type == 'email') {
                                $contacts = Contact::where('group_id', $row->group_id)->where('is_email', 1)->get();
                                if (count($contacts) > 0) {
                                    foreach ($contacts as $cont) {
                                        //return $cont->name;
                                        if ($cont->email1 != '') {
                                            $email = $cont->email1;
                                        } elseif ($cont->email2) {
                                            $email = $cont->email2;
                                        }
                                        if ($email != '') {
                                            $unsub_link = url('admin/email/unsub/' . $email);
                                            $data = ['message' => $template->body, 'subject' => $template->subject, 'name' => $cont->name, 'unsub_link' => $unsub_link];
                                            Mail::to($cont->email1)->send(new TestEmail($data));
                                            //Mail::to('rizwangill132@gmail.com')->send(new TestEmail($data));
                                        }
                                    }
                                }
                            } elseif ($row->type == 'sms') {
                                $client = new Client($sid, $token);
                                $contacts = Contact::where('group_id', $row->group_id)->get();
                                if (count($contacts) > 0) {
                                    foreach ($contacts as $cont) {
                                        if ($cont->number != '') {
                                            $number = $cont->number;
                                        } elseif ($cont->number2 != '') {
                                            $number = $cont->number2;
                                        } elseif ($cont->number3 != '') {
                                            $number = $cont->number2;
                                        }
                                        if ($number != '') {
                                            $sms_sent = $client->messages->create(
                                                $number,
                                                [
                                                    'from' => '+14234609555',
                                                    'body' => $template->body,
                                                ]
                                            );
                                        }
                                    }
                                }
                            } elseif ($row->type == 'mms') {
                                $client = new Client($sid, $token);
                                $contacts = Contact::where('group_id', $row->group_id)->get();
                                if (count($contacts) > 0) {
                                    foreach ($contacts as $cont) {
                                        if ($cont->number != '') {
                                            $number = $cont->number;
                                        } elseif ($cont->number2 != '') {
                                            $number = $cont->number2;
                                        } elseif ($cont->number3 != '') {
                                            $number = $cont->number2;
                                        }
                                        if ($number != '') {
                                            $sms_sent = $client->messages->create(
                                                $number,
                                                [
                                                    'from' => '+14234609555',
                                                    'body' => $template->body,
                                                    'mediaUrl' => [$template->body],
                                                ]
                                            );
                                        }
                                    }
                                }
                            } elseif ($row->type == 'rvm') {
                                $contactsArr = [];
                                $contacts = Contact::where('group_id', $row->group_id)->get();
                                if (count($contacts) > 0) {
                                    foreach ($contacts as $cont) {
                                        if ($cont->number != '') {
                                            $number = $cont->number;
                                        } elseif ($cont->number2 != '') {
                                            $number = $cont->number2;
                                        } elseif ($cont->number3 != '') {
                                            $number = $cont->number2;
                                        }
                                        $contactsArr[] = $number;
                                    }
                                }

                                if (count($contactsArr) > 0) {
                                    $c_phones = implode(',', $contactsArr);
                                    $vrm = \Slybroadcast::sendVoiceMail([
                                        'c_phone' => ".$c_phones.",
                                        'c_url' => $template->body,
                                        'c_record_audio' => '',
                                        'c_date' => 'now',
                                        'c_audio' => 'Mp3',
                                        //'c_callerID' => "4234606442",
                                        'c_callerID' => "18442305060",
                                        //'mobile_only' => 1,
                                        'c_dispo_url' => 'https://brian-bagnall.com/bulk/bulksms/public/admin/voicepostback'
                                    ])->getResponse();
                                }
                            }
                            $campaigns = CampaignLeadList::where('id', $row->id)->update(['updated_at' => date('Y-m-d H:i:s'), 'active' => 0]);
                            break;
                        } else {
                            if ($key == 0) {
                                $campaignsCheck = CampaignLeadList::where('active', 0)->orderby('updated_at', 'desc')->first();
                                if ($campaignsCheck) {
                                    $scheduledate = date('Y-m-d H:i:s', strtotime($campaignsCheck->schedule));
                                    $sendAfter = null;
                                    //return (int) $campaignsCheck->send_after_days;
                                    //$sendAfter = Carbon::parse($scheduledate)->addDays($row->send_after_days)->addHours($row->send_after_hours);
                                    $sendAfter = now()->addDays($row->send_after_days)->addHours($row->send_after_hours);
                                    $campaigns = CampaignLeadList::where('id', $row->id)->update(['schedule' => $sendAfter]);
                                }
                            }
                        }
                    }
                }
            }
        }
        return 'success';
    }

    public function create()
    {
        return view('back.pages.campaignleads.create');
    }

    public function store(Request $request)
    {
        $groups = Group::all();
        $request->validate([
            'name' => 'required|string|max:255',
          //  'group_id' => 'nullable|exists:groups,id', // Ensure group_id exists in the groups table
            //'active' => 'required|boolean', // Add validation for active status
            // Add other validation rules for campaign details
        ]);


        // Calculate the send_after time
        $sendAfter = null;
        if ($request->send_after_days !== null && $request->send_after_hours !== null) {
            $sendAfter = now()->addDays($request->send_after_days)->addHours($request->send_after_hours);
        }

        // Create the campaign
        CampaignLead::create([
            'name' => $request->name,
            //'type' => $request->type,
            //'send_after_days' => $request->send_after_days,
            //'send_after_hours' => $request->send_after_hours,
            //'schedule' => $sendAfter,
            'group_id' => null // Assign group_id
            //'template_id' => $request->template_id,
           // 'active' => $request->active, // Set active status
            // Add other fields for campaign details
        ]);

       // return redirect()->route('admin.leadcampaign.index')->with('success', 'Lead Campaign created successfully.');
       return redirect()->back();
    }

    public function show(Campaign $campaign, Request $request)
    {
        $sr = 1;
        $campaign_id = $campaign->id;
        $groups = Group::all(); // Fetch groups from the database
        $templates = Template::where('type', 'SMS')->get();
        if ($request->wantsJson()) {
            $campaignList = CampaignLeadList::where("campaign_id", $campaign->id)->where("is_dnc", 0)->get();
            return response()->json([
                'data' => $campaignList,
                'success' => true,
                'status' => 200,
                'message' => 'OK'
            ]);
        } else {
            return view('back.pages.campaignleads.detail', compact('campaign', 'sr', 'templates', 'groups', 'campaign_id'));
        }
        //return view('back.pages.campaign.show', compact('campaign'));
    }

    public function edit(Campaign $campaign)
    {
        return view('back.pages.campaignleads.edit', compact('campaign'));
    }

    public function update(Request $request, CampaignLead $campaign)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            //'type' => 'required|in:email,sms,mms,rvm',
            //'send_after_days' => 'nullable|integer|min:0',
            //'send_after_hours' => 'nullable|integer|min:0',
           // 'group_id' => 'nullable|exists:groups,id', // Ensure group_id exists in the groups table
            //'active' => 'required|boolean', // Add validation for active status
            // Add other validation rules for campaign details
        ]);

        // Calculate the send_after time
        $sendAfter = null;
        if ($request->send_after_days !== null && $request->send_after_hours !== null) {
            $sendAfter = now()->addDays($request->send_after_days)->addHours($request->send_after_hours);
        }
        // Update the campaign
        CampaignLead::where('id', $request->id)->update([
            'name' => $request->name,
            //'type' => $request->type,
            'group_id' => null, // Assign group_id
            'active' => $request->active, // Set active status
            // Add other fields for campaign details
        ]);

      //  return redirect()->route('admin.leadcampaign.index')->with('success', 'Lead Campaign updated successfully.');
      return redirect()->back();
    }

    // Fix issue by John 14-09-2023
    public function destroy(CampaignLead $campaignlead, $id = null)
    {
        try {
            CampaignLeadList::where("campaign_id", $id)->delete();
            CampaignLead::where('id', $id)->delete();
            return response()->json([
                'status' => true,
                'message' => 'deleted'
            ]);
          // return redirect()->back();
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong the server!'
            ]);
           return redirect()->back();
        }
    }
}
