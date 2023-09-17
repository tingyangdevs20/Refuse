<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\ZoomMeeting; 
use App\Model\TimeZones;
use App\Helpers\ZoomHelper;
use Illuminate\Support\Facades\Hash;

class ZoomController extends Controller
{
    public function index()
    {
        //$meetings = ZoomMeeting::with('timezones')->get();
        $meetings = ZoomMeeting::join('time_zones', 'meeting_date_timezone', '=', 'time_zones.id')
        ->get(['zoom_meetings.*', 'time_zones.time_zone']);
        return view('back.pages.zoom.index', compact('meetings'));
    }

    public function create()
    {
        $timezones = TimeZones::where('is_active','=','1')->get();
        return view('back.pages.zoom.create', compact('timezones'));
    }

    public function store(Request $request)  {

        // Validate the form data

        $validatedData = $request->validate([

            'meeting_name' => 'required|string|max:255',
            'meeting_password' => 'required|string|max:25',
            'meeting_date' => 'required',
            'meeting_date_timezone' => 'required',
            'duration_minute' => 'required',
            'meeting_status' => 'required',
            'host_video' => '',
            'client_video' => '',
            'meeting_note' => '',
           
        ]);

        // Create a new zoom meeting instance

        $meeting = new ZoomMeeting([
            'meeting_name' => $validatedData['meeting_name'],
            'meeting_password' => $validatedData['meeting_password'],
            'meeting_date' => $validatedData['meeting_date'],
            'duration_minute' => $validatedData['duration_minute'],
            'meeting_status' => $validatedData['meeting_status'],
            'meeting_date_timezone' => $validatedData['meeting_date_timezone'],
            'host_video' => $validatedData['host_video'],
            'client_video' => $validatedData['client_video'],
            'meeting_note' => $validatedData['meeting_note'],
        ]);

        // Save the zoom meeting data

        $meeting->save();

        /* Create Zoom Meeting. This method is supposed to be invoked by a simple form post, in which user has to provide meeting title, time and duration.  */

		//$dataRet = ZoomHelper::CreateZoomMeeting($validatedData['meeting_name'], $validatedData['meeting_date'], intval($validatedData['duration_minute']));

        session()->flash('success', 'Meeting has been created !!');
        return redirect()->route('admin.zoom.index');


    }

    public function edit( $id)
    {
      
        $meeting = ZoomMeeting::find($id);
        $timezones = TimeZones::where('is_active','=','1')->get();
        return view('back.pages.zoom.edit', compact('meeting', 'timezones'));

    }

    public function update(Request $request, $id)  {
        
        // Validate the form data

        $validatedData = $request->validate([
            'meeting_name' => 'required|string|max:255',
            'meeting_password' => 'required|string|max:25',
            'meeting_date' => 'required',
            'meeting_date_timezone' => 'required',
            'duration_minute' => 'required',
            'meeting_status' => 'required',
            'host_video' => '',
            'client_video' => '',
            'meeting_note' => '',
           
        ]);

        $meeting = ZoomMeeting::findOrFail($id);
        // Create a new zoom meeting instance
        
        $meeting->meeting_name = $validatedData['meeting_name'];
        $meeting->meeting_date = $validatedData['meeting_date'];
        $meeting->duration_minute = $validatedData['duration_minute'];
        $meeting->meeting_status = $validatedData['meeting_status'];
        $meeting->meeting_date_timezone = $validatedData['meeting_date_timezone'];
        $meeting->host_video = $validatedData['host_video'];
        $meeting->client_video = $validatedData['client_video'];
        $meeting->meeting_note = $validatedData['meeting_note'];

        if (!empty($validatedData['meeting_password'])) {
            $meeting->meeting_password = $validatedData['meeting_password'];
        }

        // Save the zoom meeting data

        $meeting->save();  
        session()->flash('success', 'Meeting has been Update !!');
        return redirect()->route('admin.zoom.index');

    }

    public function destroy( $id)
    {
        
        $user = ZoomMeeting::find($id);
        $user->delete();
        session()->flash('success', 'Meeting has been deleted !!');
        return redirect()->route('admin.zoom.index');
    }
}