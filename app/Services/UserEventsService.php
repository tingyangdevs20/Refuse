<?php

namespace App\Services;

use DateTime;
use Exception;
use Google_Client;
use Google_Service_Calendar;
use Illuminate\Http\Request;

class UserEventsService
{

    public function fetchUserCalendarEvents()
    {
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
        $events = $service->events->listEvents($calendarId);


        // Calculate the start and end dates for the specified month
        $startDate = sprintf('%04d-%02d-01T00:00:00Z', '2023', '09');
        $endDate = sprintf('%04d-%02d-%02dT23:59:59Z', '2023', '09', date('t', strtotime("2023-09-01")));

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
}
