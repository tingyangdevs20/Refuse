<?php

namespace App\Services;

use Carbon\Carbon;
use DateTime;
use Exception;
use Google_Client;
use Google_Service_Calendar;
use Illuminate\Http\Request;
use Spatie\GoogleCalendar\Event;

class UserEventsService
{

    /**
     * 
     * @deprecated 
     * 
     * will be removed later, not in use
     */
    public function fetchUserCalendarEvents()
    {
        $today = Carbon::today();
        $month = $today->format("m");
        $year = $today->format("Y");

        $client = new Google_Client();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri(config('services.google.redirect_uri'));
        $client->setAccessToken(auth()->user()->access_token);
        $client->setAccessType('offline');

        if ($client->isAccessTokenExpired()) {

            // throw new Exception("Access token is expired", 500);


            // for some reason I am not receiving the refresh token so can't use the following functionality.
            // $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            // auth()->user()->update(['access_token' => $newAccessToken, 'refresh_token' => $newRefreshToken]);

        }

        $service = new Google_Service_Calendar($client);

        $calendarId = config('services.google.calendar_id');
        // dd($calendarId);
        // $events = $service->events->listEvents($calendarId);


        // Calculate the start and end dates for the specified month
        // $startDate = sprintf('%04d-%02d-01T00:00:00Z', $year, $month);
        // $endDate = sprintf('%04d-%02d-%02dT23:59:59Z', $year, $month, date('t', strtotime("$year-$month-01")));

        $startDate = sprintf('%04d-01-01T00:00:00Z', $year);
        $endDate = sprintf('%04d-12-%02dT23:59:59Z', $year, date('t', strtotime("$year-12-01")));


        // Define the search query to find events with a specific summary
        $optParams = [
            'q' => "Appointment",
            'timeMin' => $startDate,
            'timeMax' => $endDate,
        ];

        // Fetch events based on the search query
        $events = $service->events->listEvents($calendarId, $optParams);

        $timeSlotsByDate = [];

        foreach ($events->getItems() as $event) {
            $startDate = new DateTime($event->start->dateTime);
            $endDate = new DateTime($event->end->dateTime);

            // Format times in 24-hour format
            $startTime = $startDate->format('H:i');
            $endTime = $endDate->format('H:i');

            // Get the date as a key
            $dateKey = $startDate->format('Y-m-d');

            // Create an array for the date if it doesn't exist
            if (!isset($timeSlotsByDate[$dateKey])) {
                $timeSlotsByDate[$dateKey] = [];
            }

            // Add the time slot to the date's array
            $timeSlotsByDate[$dateKey][] = [
                'start' => date("h:i:s", strtotime($startTime)),
                'end' => date("h:i:s", strtotime($endTime)),
            ];
        }

        return $timeSlotsByDate;
    }


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

            $startTime = $startDate->format('h:i:s');
            $endTime = $endDate->format('h:i:s');

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


/**
 * 
 * 
 * 
 * created new google app
 * 
 * created credentials and store the json file in storage.
 * 
 * created another calendar
 * 
 * in the calendar settings: -> share with specific people -> add -> email: email from the json file "client_email"
 * 
 * copied calendar ID from the integrate calendar section
 * c2453b6a833c39922752b29a989844028433aeb4c8fdc8a5d831347a592ab3b7@group.calendar.google.com
 * 
 */
