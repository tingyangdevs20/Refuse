<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Account;
use App\Model\Scheduler;
use Illuminate\Http\Request;
use App\Services\GoogleCalendar;
use Validator;
use Exception;
use Carbon\Carbon;
use DB;
use DATETIME;
use App\Model\Contact;
use App\Services\UserEventsService;
use Illuminate\Support\Facades\Crypt;
use \Illuminate\Support\Facades\View as View;

class ViewAppointmentsController extends Controller
{
  public function index()
  {
    //if (!empty($uid)) {

    //  $this->setupGoogleCalendar();

    //  $slotsArr = $this->getBookedSlotsFromGoogleCalendar();

    //  $bookedSlots = json_encode($slotsArr);

    //  $uid = decrypt($uid);
    $appointments = Scheduler::select(DB::raw('DATE(appt_date) as appt_date'), 'appt_time', 'name', 'email', 'mobile', 'status')->orderBy('appt_date', 'DESC')->get();

    return view('back.pages.appointments.index', compact('appointments'));
    // } else {
    //  return Redirect::back();
    // }
  }
}
