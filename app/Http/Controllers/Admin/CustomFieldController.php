<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\CustomField;
use App\Model\Group;
use App\Model\Section;
use App\Model\Contact;
use App\Model\RvmFile;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CustomFieldController extends Controller
{
    public function index()
    {
        $sections = Section::all();
        $customfields = CustomField::all();
        return view('back.pages.field.indexList', compact('sections', 'customfields'));
    }



    public function create()
    {
        return view('back.pages.campaign.create');
    }

    public function store(Request $request)
    {
        $section = $request->section_id;
        if (count($section)  > 0) {
            foreach ($section as $key => $val) {
                if ($request->field_list_id[$key] == 0) {
                    CustomField::create([
                        'section_id' => $val,
                        'label' => $request->label[$key],
                        'type' => $request->type[$key],
                    ]);
                } else {
                    CustomField::where('id', $request->field_list_id[$key])->update([
                        'section_id' => $val,
                        'label' => $request->label[$key],
                        'type' => $request->type[$key],
                    ]);
                }
            }
        }
        Alert::success('Success', 'Custom field created successfully!');
        return redirect()->back();
    }

    public function show(CampaignList $campaignList)
    {
        return view('back.pages.campaign.show', compact('campaign'));
    }

    public function edit(Campaign $campaign)
    {
        return view('back.pages.campaign.edit', compact('campaign'));
    }

    public function update(Request $request, CampaignList $campaignlist)
    {
        //dd($campaignlist);
        $request->validate([
            //'name' => 'required|string|max:255',
            'type' => 'required|in:email,sms,mms,rvm',
            'send_after_days' => 'nullable|integer|min:0',
            'send_after_hours' => 'nullable|integer|min:0',
            //'group_id' => 'required|exists:groups,id', // Ensure group_id exists in the groups table
            'active' => 'required|boolean', // Add validation for active status
            // Add other validation rules for campaign details
        ]);

        // Calculate the send_after time
        $sendAfter = null;
        if ($request->send_after_days !== null && $request->send_after_hours !== null) {
            $sendAfter = now()->addDays($request->send_after_days)->addHours($request->send_after_hours);
        }
        //return $sendAfter;
        // Update the campaign
        CampaignList::where('id', $request->id)->update([
            'type' => $request->type,
            'send_after_days' => $request->send_after_days,
            'send_after_hours' => $request->send_after_hours,
            'schedule' => $sendAfter,
            'template_id' => $request->template_id,
            'active' => $request->active, // Set active status
            // Add other fields for campaign details
        ]);

        return redirect()->route('admin.campaign.show', $request->campaign_id)->with('success', 'Campaign list updated successfully.');
    }

    public function destroy(CampaignList $campaignlist)
    {
        //dd($campaignlist);
        $campaignlist->delete();
        return redirect()->route('admin.campaign.show', $campaignlist->campaign_id)->with('success', 'Campaign list deleted successfully.');
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
        return view('back.pages.campaign.ajaxTemplate', compact('type', 'files', 'count'));
    }
}
