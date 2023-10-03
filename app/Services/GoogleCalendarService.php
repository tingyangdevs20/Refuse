<?php

namespace App\Services;

use Carbon\Carbon;
use DateTime;
use Exception;
use Google_Client;
use Google_Service_Calendar;
use Illuminate\Http\Request;
use Spatie\GoogleCalendar\Event;

class GoogleCalendarService
{

    /**
     * 
     * fetch events/appointments from google calendar of Admin.
     * 
     */
    public function fetchEventsFromGoogleCalendar()
    {
        // check whether admin has configured his google calendar or not.

        // fetch events
        $events = Event::get();
        $timeSlotsByDate = [];

        foreach ($events as $ev) {
            $startDate = $ev->startDateTime;
            $endDate = $ev->endDateTime;

            $startTime = $startDate->format('H:i:s');
            $endTime = $endDate->format('H:i:s');

            // Get the date as a key
            $dateKey = $startDate->format('Y-m-d');

            // Create an array for the date if it doesn't exist
            if (!isset($timeSlotsByDate[$dateKey])) {
                $timeSlotsByDate[$dateKey] = [];
            }

            // Add the time slot to the date's array
            $timeSlotsByDate[$dateKey][] = [
                'start' => $startTime,
                'end' => $endTime,
            ];
        }

        return $timeSlotsByDate;
    }
}
