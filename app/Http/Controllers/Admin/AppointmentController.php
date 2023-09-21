<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Scheduler;
use Illuminate\Http\Request;
use App\Services\GoogleCalendar;
use Validator;
use Exception;
use Carbon\Carbon;
use DB;
use DATETIME;
use App\Model\Contact;
use \Illuminate\Support\Facades\View as View;
use Redirect;


class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($uid='')
    {   
        if(!empty($uid)){
            // $userTimeZone = 'Asia/Calcutta'; // user timezone

            // $now = Carbon::now($userTimeZone)->format('Y-m-d H:i:s');
            // print_r($now);

            // get specific user appointments based on user timezone
            // $getUserAppointments = Scheduler::select('id','name','email','mobile','appt_date','appt_time','timezone','description')
        
            // ->where('status','booked')
            // ->where(DB::raw('CONCAT(DATE(appt_date)," ",appt_time)'),'>', $now)
            // ->orderBy(DB::raw('DATE(appt_date)'), 'ASC')
            // ->orderBy('appt_time', 'ASC')
            // ->get();

            // print_r($getUserAppointments);
            $today = Carbon::today();
            $todayDate = $today->toDateString(); // return today date

            // getting already booked slots
            $getBookedTimeSlots = Scheduler::select(DB::raw('DATE(appt_date) as appt_date'),'appt_time')
            ->whereDate('appt_date',$todayDate)
            ->orWhereDate('created_at', $todayDate)
            ->get();

            // print_r($getBookedTimeSlots);
            // exit;

            $slotsArr = array();

            foreach($getBookedTimeSlots as $key => $bookedSlots) {

                
                $slotsArr[$key]['b_date'] = Carbon::createFromFormat('Y-m-d', $bookedSlots['appt_date'])->format('j');
                $slotsArr[$key]['b_time'] = Carbon::createFromFormat('H:i:s', $bookedSlots['appt_time'])->format('H');
                $slotsArr[$key]['appt_date'] = $bookedSlots['appt_date'];
                $slotsArr[$key]['appt_time'] = Carbon::createFromFormat('H:i:s',$bookedSlots['appt_time'])->format('H:i');
                
            }

            $bookedSlots = json_encode($slotsArr);

            $uid = decrypt($uid);
            
            return view('book-appointment',compact('bookedSlots','uid'));
        }else{
            return Redirect::back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(),[
            
            'timezone' => 'required',
            'appt_date' => 'required',
            'appt_time' => 'required',
            'name' => 'required|min:2',
            'mobile' => 'required',
            'email' => 'required|email|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $now = Carbon::now();
            // print_r($request->timezone);
            // exit;
            $eml=$request->email;
           // $contact=Contact::where('email1',$eml)->orWhere('email2',$eml)->first();
           // $cnt_id=$contact->id;
            $createAppointment = Scheduler::create([
                'timezone' => $request->timezone,
                'appt_date' => $request->appt_date,
                'appt_time' => $request->appt_time,
                'name' => $request->name,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'description' => $request->description,
                'status' => 'booked',
                'created_at' => $now,
                'updated_at' => $now,
                'admin_uid' => (!empty($request->uid)) ? $request->uid : 0
               // 'user_id' => $cnt_id
            ]);

            if($createAppointment->id) {
                return back()->with('success', 'Thank you! Your appointment has been booked.');
            } else {
                return back()->with('error', 'Something Went Wrong! Please Try Again Later');
            }

        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // cancel appointment function
    public function cancelAppointment(Request $request) {
        // print_r($request->all());
        $validator = Validator::make($request->all(),[
            
            'id' => 'required'
        ]);

        if($validator->fails()) {
            $msg ="";
            foreach ($validator->messages()->getMessages() as $field_name => $messages)
            {
                foreach($messages as $message){
                    $msg.=$message.'<br/>';
                }
            }
            $response = array("success" => 0, "message" => $msg);
            echo json_encode($response);
            exit;
        }

        try {

            $cancelAppointment = Scheduler::where('id', $request->id)->update([
                'status' => 'canceled',
                'updated_at' => Carbon::now()
            ]);

            if($cancelAppointment > 0) {
                $response = array("success" => 1, "message" => 'Your appointment canceled successfully.');
                echo json_encode($response);
                exit;
            } else {
                $response = array("success" => 0, "message" => 'Something went wrong! Please try again later.');
                echo json_encode($response);
                exit;
            }

        } catch(Exception $e) {
            $response = array("success" => 0, "message" => $e->getMessage());
            echo json_encode($response);
            exit;
        }

    }

    // rescheduling appointments
    public function reschduleAppointment(Request $request) {
        // print_r($request->all());
        // exit;
        $validator = Validator::make($request->all(),[
            
            'id' => 'required',
            'appt_date' => 'required',
            'appt_time' => 'required',
        ]);

        if($validator->fails()) {
            $msg ="";
            foreach ($validator->messages()->getMessages() as $field_name => $messages)
            {
                foreach($messages as $message){
                    $msg.=$message.'<br/>';
                }
            }
            $response = array("success" => 0, "message" => $msg);
            echo json_encode($response);
            exit;
        }

        try {

            $reschduleAppointment = Scheduler::where('id', $request->id)->update([
                // 'status' => 'canceled',
                'appt_date' => $request->appt_date,
                'appt_time' => $request->appt_time,
                'updated_at' => Carbon::now()
            ]);

            if($reschduleAppointment > 0) {
                $response = array("success" => 1, "message" => 'Your appointment rescheduled successfully.');
                echo json_encode($response);
                exit;
            } else {
                $response = array("success" => 0, "message" => 'Something went wrong! Please try again later.');
                echo json_encode($response);
                exit;
            }

        } catch(Exception $e) {
            $response = array("success" => 0, "message" => $e->getMessage());
            echo json_encode($response);
            exit;
        }
    }

    public function connectGoogleCalendar() {
        $newInstance = new GoogleCalendar();
        $client = $newInstance->getClient();
        $authUrl = $client->createAuthUrl();
        // print_r($authUrl);
        return redirect($authUrl);
    }

    public function storeGoogleCalendarCredentials() {
        print_r(1);
        $newInstance = new GoogleCalendar();
        $client = $newInstance->getClient();

        $authCode = request('code');
        print_r($authCode);
        // exit;
        // Load previously authorized credentials from a file.

        $credentialsPath = storage_path('gcalendar-keys/client_calendar_secret.json');

        // Exchange authorization code for an access token.

        $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

 

        // Store the credentials to disk.

        if (!file_exists(dirname($credentialsPath))) {

            mkdir(dirname($credentialsPath), 0700, true);

        }

        file_put_contents($credentialsPath, json_encode($accessToken));

        return redirect('/appointments')->with('message', 'Credentials saved');

    }

    // public function getResources() {
    //     {
    //         print_r("2");
    //         // exit;
    //         // Get the authorized client object and fetch the resources.
    
    //         $newInstance = new GoogleCalendar();
            
    //         $client = $newInstance->oauth();
    //         print_r($client);
    //         exit;
    //         $resources = $newInstance->getResources($client);
    //         return $resources;
    //     }
    // }

    public function getAppointments(Request $request){
        try {

            if(!empty($request->mobile) && !empty($request->uid)){
                $userTimeZone = 'Asia/Calcutta'; // user timezone
    
                $now = Carbon::now($userTimeZone)->format('Y-m-d H:i:s');
                $getUserAppointments = Scheduler::select('id','name','email','mobile','appt_date','appt_time','timezone','description')
            
                ->where('status','booked')
                ->where('admin_uid',$request->uid)
                ->where('mobile',$request->mobile)
                // ->where(DB::raw('CONCAT(DATE(appt_date)," ",appt_time)'),'>', $now)
                ->orderBy(DB::raw('DATE(appt_date)'), 'ASC')
                ->orderBy('appt_time', 'ASC')
                ->get();
    
                $html = View::make('appointments.booked',['getUserAppointments' => $getUserAppointments])->render();
                if(!empty($getUserAppointments)){
                    $response = array("success" => 1,'html' => $html);
                    echo json_encode($response);
                    exit;
                }else{
                    $response = array("success" => 0);
                    echo json_encode($response);
                    exit;
                }
            }
            else{
                $response = array("success" => 0);
                echo json_encode($response);
                exit;
            }

        } catch(Exception $e) {
            $response = array("success" => 0, "message" => $e->getMessage());
            echo json_encode($response);
            exit;
        }
        
    }
}
