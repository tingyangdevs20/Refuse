<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\CampaignLead;
use App\Mail\TestEmail;
use App\Model\CampaignList;
use Illuminate\Support\Facades\Mail;
use App\Model\Group;
use App\Model\Number;
use App\Model\CampaignLeadList;
use App\Model\Campaign;
use App\Model\Contact;
use App\Model\Account;
use App\Model\Template;
use App\Model\Reply;
use App\Model\Sms;
use App\Model\RvmFile;
use App\Model\FailedSms;
use Twilio\Rest\Client;
use Illuminate\Http\Request;
use Carbon\Carbon;


class CampaignLeadListController extends Controller
{
    public function index()
    {
        $groups = Group::all(); // Fetch groups from the database
        $campaigns = CampaignLead::getAllCampaigns();
        $templates = Template::where('type', 'SMS')->get();

        return view('back.pages.campaignlist.index', compact('groups', 'campaigns', 'templates'));
    }

    public function compaignList($id = '')
    {
        $numbers = Number::all();
        $templates = Template::all();
        $files = RvmFile::all();
        $campaignsList = CampaignLeadList::where('campaign_id', $id)->orderby('schedule', 'ASC')->get();
        $campaign_name = CampaignLead::where('id', $id)->first();
        return view('back.pages.campaignleads.indexList', compact('numbers', 'templates', 'campaignsList', 'id', 'files', 'campaign_name'));
    }

    

    public function create()
    {
        return view('back.pages.campaign.create');
    }

    public function store(Request $request)
    {
        //die($request);
        $types = $request->type;
        $campaign_id = $request->camp_id;
        $subject = '';
        $media = "";



        $sendAfter = null;
        if ($request->send_after_days !== null && $request->send_after_hours !== null) {
            $sendAfter = now()->addDays($request->send_after_days)->addHours($request->send_after_hours);
        }
        if ($types == 'rvm') {
            $media = $request->rvm;
        }
        if ($types == 'mms') {
            $media = $request->media_file_mms;
        }
        if ($types == 'email') {
            $subject = $request->subject;
        }




        CampaignLeadList::create([
            'campaign_id' => $campaign_id,
            'type' => $types,
            'send_after_days' => $request->send_after_days,
            'send_after_hours' => $request->send_after_hours,
            'schedule' => $sendAfter,
            'mediaUrl' => $media,
            'template_id' => null,
            'subject' => $request->subject,
            'body' => $request->msg,
            'active' => 1, // Set active status
        ]);









        //return $request->campaign_id;
        return redirect('admin/compaignlead/list/' . $campaign_id)->with('success', 'Campaign list created successfully.');
    }

    public function show(CampaignList $campaignList)
    {
        return view('back.pages.campaign.show', compact('campaign'));
    }

    public function edit(Campaign $campaign)
    {
        return view('back.pages.campaign.edit', compact('campaign'));
    }

    public function update(Request $request)
    {


        $types = $request->type;
        $id = $request->cid;
        $subject = '';
        $media = "";



        $sendAfter = null;
        if ($request->send_after_days !== null && $request->send_after_hours !== null) {
            $sendAfter = now()->addDays($request->send_after_days)->addHours($request->send_after_hours);
        }
        if ($types == 'rvm') {
            $media = $request->rvm;
        }
        if ($types == 'mms') {
            $media = $request->media_file_mms;
        }
        if ($types == 'email') {
            $subject = $request->subject;
        }

        // Update the campaign
        CampaignLeadList::where('id', $request->cid)->update([
            'type' => $request->type,
            'send_after_days' => $request->send_after_days,
            'send_after_hours' => $request->send_after_hours,
            'schedule' => $sendAfter,
            'mediaUrl' => $media,
            'template_id' => null,
            'subject' => $subject,
            'body' => $request->body,
            'active' => 1, // Set active status
        ]);

        return redirect()->back();
    }

    public function destroy(CampaignList $campaignlist)
    {
        //dd($campaignlist);
        $campaignlist->delete();
        return redirect()->route('admin.campaign.show', $campaignlist->campaign_id)->with('success', 'Campaign list deleted successfully.');
    }

    public function remove(Request $request)
    {
        // dd($request);
        CampaignLeadList::where('id', $request->id)->delete();
        return redirect()->back();
    }
    public function listCampeign(Group $group, Request $request)
    {
        $sr = 1;
        if ($request->wantsJson()) {
            $contacts = Contact::where("group_id", $group->id)->where("is_dnc", 0)->get();
            return response()->json([
                'data' => $contacts,
                'success' => true,
                'status' => 200,
                'message' => 'OK'
            ]);
        } else {
            return view('back.pages.campaignlist.details', compact('group', 'sr'));
        }
    }

    public function getTemplate($type = '', $count = '')
    {
        $files = RvmFile::all();
        return view('back.pages.campaignleads.ajaxTemplate', compact('type', 'files', 'count'));
    }
}
