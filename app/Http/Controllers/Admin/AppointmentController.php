<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Account;
use App\Model\CalendarSetting;
use App\Model\Scheduler;
use Illuminate\Http\Request;
use App\Services\GoogleCalendar;
use Validator;
use Exception;
use Carbon\Carbon;
use DB;
use DATETIME;
use App\Model\Contact;
use App\Services\GoogleCalendarService;
use Illuminate\Support\Facades\Crypt;
use \Illuminate\Support\Facades\View as View;

class AppointmentController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $rq, $uid = '')
    {
        if (!empty($uid)) {

            $this->setupGoogleCalendar();

            $appointmentSettings = CalendarSetting::first() ?? new CalendarSetting();
            $adminTimezone = $appointmentSettings->timezone;
            $advance_booking_duration = $appointmentSettings->advance_booking_duration;
            $timezones = timezone_identifiers_list();

            $availableSlots = json_encode(
                $this->getAvailableSlots($appointmentSettings, $adminTimezone)
            );

            $bookedSlots = json_encode(
                $this->getBookedSlotsFromGoogleCalendar($appointmentSettings, $adminTimezone)
            );

            $uid = decrypt($uid);

            return view('book-appointment', compact('timezones', 'adminTimezone', 'availableSlots', 'bookedSlots', 'uid', 'advance_booking_duration'));
        } else {
            return Redirect::back();
        }
    }


    public function fetchAllSlotsForBooking(Request $request)
    {
        try {

            $appointmentSettings = CalendarSetting::first() ?? new CalendarSetting();

            $this->setupGoogleCalendar();

            $availableSlots = $this->getAvailableSlots($appointmentSettings, $request->timezone);
            $bookedSlots = $this->getBookedSlotsFromGoogleCalendar($appointmentSettings, $request->timezone);
            $advance_booking_duration = $appointmentSettings->advance_booking_duration;
            return response()->json([
                "status" => 200,
                "message" => "List of time slots in user preferred timezone for appointment booking.",
                "availableSlots" => $availableSlots,
                "bookedSlots" => $bookedSlots,
                "advance_booking_duration" => $advance_booking_duration
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => 500,
                "message" => $th->getMessage() ?? "Oops! something went wrong.",
                "availableSlots" => [],
                "bookedSlots" => [],
            ]);
        }
    }


    private function getAvailableSlots($appointmentSettings, $userTimezone)
    {
        $appointmentSettings = $appointmentSettings->toArray();

        // Transform the data into the desired format
        $d = Carbon::now()->setTimezone($userTimezone);
        $daysOfWeek = [];
        for ($i = 1; $i < 8; $i++) {
            $daysOfWeek[] = strtolower($d->format("l"));
            $d->addDay();
        }

        $result = [];

        foreach ($daysOfWeek as $day) {

            $startTime = $appointmentSettings[$day . '_close'] ? null : $appointmentSettings[$day . '_start_time'];
            $endTime = $appointmentSettings[$day . '_close'] ? null : $appointmentSettings[$day . '_end_time'];

            $slots = [];
            $currentTime = strtotime($startTime);

            if ($startTime) {
                while ($currentTime < strtotime($endTime)) {
                    $inAdminTimezone = \Carbon\Carbon::parse($currentTime)
                        ->settings(['timezone' => $appointmentSettings['timezone']]);

                    // convert it to user timezone and push it into slots array.
                    $slots[] = $inAdminTimezone->setTimezone($userTimezone)->format("H:i");

                    $currentTime += $appointmentSettings['period_duration'] * 60; // Increment by $period_duration minutes
                }
            }

            $result[] = $slots;
        }

        return $result;
    }


    private function setupGoogleCalendar()
    {
        $account = Account::find(1);

        if (($account->calendar_enable === "N") || !$account->calendar_id || !$account->calendar_credentials_path) {
            abort(500, "Please configure your google calendar from Administrative Settings.");
        }

        \Illuminate\Support\Facades\Config::set('google-calendar.calendar_id', $account->calendar_id);
        \Illuminate\Support\Facades\Config::set('google-calendar.auth_profiles.service_account.credentials_json', storage_path('app/google-calendar/' . $account->calendar_credentials_path));
    }


    private function getBookedSlotsFromGoogleCalendar($appointmentSettings, $userTimezone = null)
    {
        $slotsArr = [];

        $userBookedTimeSlots = (new GoogleCalendarService())->fetchEventsFromGoogleCalendar();

        foreach ($userBookedTimeSlots as $date => $bookedSlots) {
            foreach ($bookedSlots as $key => $slot) {
                $dateTime = $date . " " . $slot['start'];

                $dateTime = \Carbon\Carbon::parse($dateTime)
                    ->settings(['timezone' => $appointmentSettings->timezone]);

                // convert it to user timezone and push it into slots array.
                $dateTime = $dateTime->setTimezone($userTimezone ?? $appointmentSettings->timezone);

                $dateTime->format("H:i");

                $slotsArr[$date][$key]['appt_date'] = $dateTime->format("Y-m-d"); //$date;
                $slotsArr[$date][$key]['appt_time'] = $dateTime->format('H:i');
            }
        }

        return $slotsArr;
    }


    /**
     * 
     * @deprecated
     * 
     * will be removed later, not in use
     */
    private function getBookedSlotsFromDatabase()
    {
        $today = Carbon::today();
        $todayDate = $today->toDateString(); // return today date

        $slotsArr = [];

        // getting already booked slots
        $getBookedTimeSlots = Scheduler::select(DB::raw('DATE(appt_date) as appt_date'), 'appt_time')
            ->whereDate('appt_date', $todayDate)
            ->orWhereDate('created_at', $todayDate)
            ->get();

        foreach ($getBookedTimeSlots as $key => $bookedSlots) {
            // $slotsArr[$key]['b_date'] = Carbon::createFromFormat('Y-m-d', $bookedSlots['appt_date'])->format('j');
            // $slotsArr[$key]['b_time'] = Carbon::createFromFormat('H:i:s', $bookedSlots['appt_time'])->format('H');
            $slotsArr[$key]['appt_date'] = $bookedSlots['appt_date'];
            $slotsArr[$key]['appt_time'] = Carbon::createFromFormat('H:i:s', $bookedSlots['appt_time'])->format('H:i');
        }

        return $slotsArr;
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
        $validator = Validator::make($request->all(), [

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

            // if user have already booked an appointment which is not [completed, canceld, expired] then show an error message.
            if (Scheduler::where('mobile', $request->mobile)->where('status', 'booked')->count()) {
                return back()->with('error', 'You have already booked an appointment.');
            }

            $this->setupGoogleCalendar();


            $now = Carbon::now();
            $eml = $request->email;

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

            $appointmentSettings = CalendarSetting::first();

            $dateTime = $request->appt_date . " " . $request->appt_time;
            $startTime = Carbon::parse($dateTime, $request->timezone)->setTimezone($appointmentSettings->timezone);

            // default period_duration is set to 60 minutes
            $endTime = Carbon::parse($dateTime, $request->timezone)->setTimezone($appointmentSettings->timezone)->addMinutes($appointmentSettings->period_duration ?? 60);

            $event = \Spatie\GoogleCalendar\Event::create([
                'name' => 'Appointment',
                'startDateTime' => $startTime,
                'endDateTime' => $endTime,
            ]);

            // attaching event ID to appointment which can be used later 
            // to delete or update the event in google calendar
            $createAppointment->google_calendar_event_id = $event->id;
            $createAppointment->save();

            if ($createAppointment->id) {
                return back()->with('success', 'Thank you! Your appointment has been booked.');
            } else {
                return back()->with('error', 'Something Went Wrong! Please Try Again Later');
            }
        } catch (Exception $e) {
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
    public function cancelAppointment(Request $request)
    {
        // print_r($request->all());
        $validator = Validator::make($request->all(), [

            'id' => 'required'
        ]);

        if ($validator->fails()) {
            $msg = "";
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                foreach ($messages as $message) {
                    $msg .= $message . '<br/>';
                }
            }
            $response = array("success" => 0, "message" => $msg);
            echo json_encode($response);
            exit;
        }

        try {

            $this->setupGoogleCalendar();

            $cancelAppointment = Scheduler::where('id', $request->id)->get();

            if (!$cancelAppointment->count()) {
                throw new Exception("Appointment not found", 404);
            }

            $cancelAppointment = $cancelAppointment[0];
            $google_calendar_event_id = $cancelAppointment->google_calendar_event_id;

            $updated = $cancelAppointment->update([
                'status' => 'canceled',
                'google_calendar_event_id' => null,
                'updated_at' => Carbon::now()
            ]);

            // remove event from google calendar if exist
            if ($google_calendar_event_id) {
                $event = \Spatie\GoogleCalendar\Event::find($google_calendar_event_id);
                $event->delete();
            }

            if ($updated > 0) {
                $response = array("success" => 1, "message" => 'Your appointment canceled successfully.');
                echo json_encode($response);
                exit;
            } else {
                $response = array("success" => 0, "message" => 'Something went wrong! Please try again later.');
                echo json_encode($response);
                exit;
            }
        } catch (Exception $e) {
            $response = array("success" => 0, "message" => $e->getMessage());
            echo json_encode($response);
            exit;
        }
    }


    // rescheduling appointments
    public function reschduleAppointment(Request $request)
    {
        // print_r($request->all());
        // exit;
        $validator = Validator::make($request->all(), [

            'id' => 'required',
            'appt_date' => 'required',
            'appt_time' => 'required',
        ]);

        if ($validator->fails()) {
            $msg = "";
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                foreach ($messages as $message) {
                    $msg .= $message . '<br/>';
                }
            }
            $response = array("success" => 0, "message" => $msg);
            echo json_encode($response);
            exit;
        }

        try {

            $this->setupGoogleCalendar();

            $rescheduleAppointment = Scheduler::where('id', $request->id)->get();

            if (!$rescheduleAppointment->count()) {
                throw new Exception("Appointment not found", 404);
            }

            $rescheduleAppointment = $rescheduleAppointment[0];

            $updated = $rescheduleAppointment->update([
                // 'status' => 'canceled',
                'appt_date' => $request->appt_date,
                'appt_time' => $request->appt_time,
                'updated_at' => Carbon::now()
            ]);

            // reschedule an event in google calendar if exist
            if ($rescheduleAppointment->google_calendar_event_id) {

                $dateTime = $request->appt_date . " " . (intval($request->appt_time) + 12) . ":00";
                $startTime = Carbon::parse($dateTime, $rescheduleAppointment->timezone);
                $endTime = Carbon::parse($dateTime, $rescheduleAppointment->timezone)->addHour();

                $event = \Spatie\GoogleCalendar\Event::find($rescheduleAppointment->google_calendar_event_id);
                $event->update([
                    'startDateTime' => $startTime,
                    'endDateTime' => $endTime,
                ]);
            }

            if ($updated > 0) {
                $response = array("success" => 1, "message" => 'Your appointment rescheduled successfully.');
                echo json_encode($response);
                exit;
            } else {
                $response = array("success" => 0, "message" => 'Something went wrong! Please try again later.');
                echo json_encode($response);
                exit;
            }
        } catch (Exception $e) {
            $response = array("success" => 0, "message" => $e->getMessage());
            echo json_encode($response);
            exit;
        }
    }

    public function connectGoogleCalendar()
    {
        $newInstance = new GoogleCalendar();
        $client = $newInstance->getClient();
        $authUrl = $client->createAuthUrl();
        // print_r($authUrl);
        return redirect($authUrl);
    }

    public function storeGoogleCalendarCredentials()
    {
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

    public function getAppointments(Request $request)
    {
        try {

            if (!empty($request->mobile) && !empty($request->uid)) {
                $userTimeZone = 'Asia/Calcutta'; // user timezone

                $now = Carbon::now($userTimeZone)->format('Y-m-d H:i:s');
                $getUserAppointments = Scheduler::select('id', 'name', 'email', 'mobile', 'appt_date', 'appt_time', 'timezone', 'description')

                    ->where('status', 'booked')
                    ->where('admin_uid', $request->uid)
                    ->where('mobile', $request->mobile)
                    // ->where(DB::raw('CONCAT(DATE(appt_date)," ",appt_time)'),'>', $now)
                    ->orderBy(DB::raw('DATE(appt_date)'), 'ASC')
                    ->orderBy('appt_time', 'ASC')
                    ->get();

                $html = View::make('appointments.booked', ['getUserAppointments' => $getUserAppointments])->render();
                if (!empty($getUserAppointments)) {
                    $response = array("success" => 1, 'html' => $html);
                    echo json_encode($response);
                    exit;
                } else {
                    $response = array("success" => 0);
                    echo json_encode($response);
                    exit;
                }
            } else {
                $response = array("success" => 0);
                echo json_encode($response);
                exit;
            }
        } catch (Exception $e) {
            $response = array("success" => 0, "message" => $e->getMessage());
            echo json_encode($response);
            exit;
        }
    }
    // public function appointmentReminder(Request $request)
    // {
    //     $campaign_id = $request->campaign_id;
    //     $campaign_list_id = $request->campaign_list_id;
    //     $types = $request->type;
    //     $send_after_days = $request->send_after_days;
    //     $send_after_hours = $request->send_after_hours;
    //     $send_after_hours = $request->send_after_hours;
    //     $user_id = $request->user_id;
    //     $user = Scheduler::find($user_id);
    //     $subject = $request->subject;
    //     //dd($_POST['media_file']);
    //     $body = $request->body;
    //     $count = 1;
        
    //     if (count($checkCompainList) == 1) {

    //         $template = Template::where('id', $request->template_id)->first();
    //         if ($request->type == 'email') {
    //             $contacts = Contact::where('group_id', $compain->group_id)->get();
    //             if (count($contacts) > 0) {
    //                 foreach ($contacts as $cont) {
    //                     //return $cont->name;
    //                     if ($cont->email1 != '') {
    //                         $email = $cont->email1;
    //                     } elseif ($cont->email2) {
    //                         $email = $cont->email2;
    //                     }
    //                     if ($template) {
    //                         $subject = $template->subject;
    //                     } else {
    //                         $subject = $checkCompainList->subject;
    //                     }
    //                     $subject = $template->subject;
    //                     $subject = str_replace("{name}", $cont->name, $subject);
    //                     $subject = str_replace("{street}", $cont->street, $subject);
    //                     $subject = str_replace("{city}", $cont->city, $subject);
    //                     $subject = str_replace("{state}", $cont->state, $subject);
    //                     $subject = str_replace("{zip}", $cont->zip, $subject);
    //                     if ($template) {
    //                         $message = $template->body;
    //                     } else {
    //                         $message = $checkCompainList->body;
    //                     }
    //                     $message = str_replace("{name}", $cont->name, $message);
    //                     $message = str_replace("{street}", $cont->street, $message);
    //                     $message = str_replace("{city}", $cont->city, $message);
    //                     $message = str_replace("{state}", $cont->state, $message);
    //                     $message = str_replace("{zip}", $cont->zip, $message);
    //                     $unsub_link = url('admin/email/unsub/' . $email);
    //                     $data = ['message' => $message, 'subject' => $subject, 'name' => $cont->name, 'unsub_link' => $unsub_link];
    //                     Mail::to($email)->send(new TestEmail($data));
    //                     //Mail::to('rizwangill132@gmail.com')->send(new TestEmail($data));
    //                 }
    //             }
    //         } elseif ($request->type == 'sms') {
    //             $client = new Client($sid, $token);
    //             $contacts = Contact::where('group_id', $compain->group_id)->get();
    //             if (count($contacts) > 0) {
    //                 foreach ($contacts as $cont) {
    //                     if ($cont->number != '') {
    //                         $number = $cont->number;
    //                     } elseif ($cont->number2 != '') {
    //                         $number = $cont->number2;
    //                     } elseif ($cont->number3 != '') {
    //                         $number = $cont->number2;
    //                     }
    //                     $receiver_number = $number;
    //                     $sender_number = $sender_numbers->number;
    //                     if ($template) {
    //                         $message = $template->body;
    //                     } else {
    //                         $message = $checkCompainList->body;
    //                     }
    //                     $message = str_replace("{name}", $cont->name, $message);
    //                     $message = str_replace("{street}", $cont->street, $message);
    //                     $message = str_replace("{city}", $cont->city, $message);
    //                     $message = str_replace("{state}", $cont->state, $message);
    //                     $message = str_replace("{zip}", $cont->zip, $message);
    //                     try {
    //                         $sms_sent = $client->messages->create(
    //                             $receiver_number,
    //                             [
    //                                 'from' => $sender_number,
    //                                 'body' => $message,
    //                             ]
    //                         );
    //                         if ($sms_sent) {
    //                             $old_sms = Sms::where('client_number', $receiver_number)->first();
    //                             if ($old_sms == null) {
    //                                 $sms = new Sms();
    //                                 $sms->client_number = $receiver_number;
    //                                 $sms->twilio_number = $sender_number;
    //                                 $sms->message = $message;
    //                                 $sms->media = '';
    //                                 $sms->status = 1;
    //                                 $sms->save();
    //                                 $this->incrementSmsCount($sender_number);
    //                             } else {
    //                                 $reply_message = new Reply();
    //                                 $reply_message->sms_id = $old_sms->id;
    //                                 $reply_message->to = $sender_number;
    //                                 $reply_message->from = $receiver_number;
    //                                 $reply_message->reply = $message;
    //                                 $reply_message->system_reply = 1;
    //                                 $reply_message->save();
    //                                 $this->incrementSmsCount($sender_number);
    //                             }
    //                         }
    //                     } catch (\Exception $ex) {
    //                         $failed_sms = new FailedSms();
    //                         $failed_sms->client_number = $receiver_number;
    //                         $failed_sms->twilio_number = $sender_number;
    //                         $failed_sms->message = $message;
    //                         $failed_sms->media = '';
    //                         $failed_sms->error = $ex->getMessage();
    //                         $failed_sms->save();
    //                     }
    //                 }
    //             }
    //         } elseif ($request->type == 'mms') {
    //             $client = new Client($sid, $token);
    //             $contacts = Contact::where('group_id', $compain->group_id)->get();
    //             if (count($contacts) > 0) {
    //                 foreach ($contacts as $cont) {
    //                     $receiver_number = $cont->number;
    //                     //$receiver_number = '4234606442';
    //                     $sender_number = $sender_numbers->number;
    //                     if ($template) {
    //                         $message = $template->body;
    //                     } else {
    //                         $message = $checkCompainList->body;
    //                     }
    //                     $message = str_replace("{name}", $cont->name, $message);
    //                     $message = str_replace("{street}", $cont->street, $message);
    //                     $message = str_replace("{city}", $cont->city, $message);
    //                     $message = str_replace("{state}", $cont->state, $message);
    //                     $message = str_replace("{zip}", $cont->zip, $message);
    //                     if ($template) {
    //                         $mediaUrl = $template->mediaUrl;
    //                     } else {
    //                         $mediaUrl = $checkCompainList->mediaUrl;
    //                     }
    //                     try {
    //                         $sms_sent = $client->messages->create(
    //                             $receiver_number,
    //                             [
    //                                 'from' => $sender_number,
    //                                 'body' => $message,
    //                                 'mediaUrl' => [$mediaUrl],
    //                             ]
    //                         );
    //                         //dd($sms_sent);
    //                         if ($sms_sent) {
    //                             $old_sms = Sms::where('client_number', $receiver_number)->first();
    //                             if ($old_sms == null) {
    //                                 $sms = new Sms();
    //                                 $sms->client_number = $receiver_number;
    //                                 $sms->twilio_number = $sender_number;
    //                                 $sms->message = $message;
    //                                 $sms->media = $mediaUrl == null ? 'No' : $mediaUrl;
    //                                 $sms->status = 1;
    //                                 $sms->save();
    //                                 $this->incrementSmsCount($sender_number);
    //                             } else {
    //                                 $reply_message = new Reply();
    //                                 $reply_message->sms_id = $old_sms->id;
    //                                 $reply_message->to = $sender_number;
    //                                 $reply_message->from = $receiver_number;
    //                                 $reply_message->reply = $message;
    //                                 $reply_message->system_reply = 1;
    //                                 $reply_message->save();
    //                                 $this->incrementSmsCount($sender_number);
    //                             }
    //                         }
    //                     } catch (\Exception $ex) {
    //                         $failed_sms = new FailedSms();
    //                         $failed_sms->client_number = $receiver_number;
    //                         $failed_sms->twilio_number = $sender_number;
    //                         $failed_sms->message = $message;
    //                         $failed_sms->media = $mediaUrl == null ? 'No' : $mediaUrl;
    //                         $failed_sms->error = $ex->getMessage();
    //                         $failed_sms->save();
    //                     }
    //                 }
    //             }
    //         } elseif ($request->type == 'rvm') {
    //             $contactsArr = [];
    //             $contacts = Contact::where('group_id', $compain->group_id)->get();
    //             if (count($contacts) > 0) {
    //                 foreach ($contacts as $cont) {
    //                     $contactsArr[] = $cont->number;
    //                 }
    //             }
    //             if (count($contactsArr) > 0) {
    //                 try {
    //                     if ($template) {
    //                         $message = $template->body;
    //                     } else {
    //                         $message = $checkCompainList->body;
    //                     }
    //                     $c_phones = implode(',', $contactsArr);
    //                     //$c_phones = '3128692422';
    //                     $vrm = \Slybroadcast::sendVoiceMail([
    //                         'c_phone' => ".$c_phones.",
    //                         'c_url' => $message,
    //                         'c_record_audio' => '',
    //                         'c_date' => 'now',
    //                         'c_audio' => 'Mp3',
    //                         //'c_callerID' => "4234606442",
    //                         'c_callerID' => $sender_numbers->number,
    //                         //'mobile_only' => 1,
    //                         'c_dispo_url' => 'https://brian-bagnall.com/bulk/bulksms/public/voicepostback'
    //                     ])->getResponse();
    //                 } catch (\Exception $ex) {
    //                 }
    //             }
    //         }
    //         // $campaign->active = $request->active; // Update active
    //         $checkCompainList1 = CampaignLeadList::where('campaign_id', $request->campaign_id)->first();
    //         $campaigns = CampaignLeadList::where('id', $checkCompainList1->id)->update(['updated_at' => date('Y-m-d H:i:s'), 'active' => 0]);
    //     }

    //     //return $request->campaign_id;
    //     return redirect('admin/compaignlead/list/' . $request->campaign_id)->with('success', 'Campaign list created successfully.');
    // }
}
