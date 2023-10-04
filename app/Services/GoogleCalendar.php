<?php
namespace App\Services;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Directory;
use Illuminate\Http\Request;

class GoogleCalendar
{
    public function getClient() {

        $client = new Google_Client();
        print_r($client);

        $client->setApplicationName(env('APP_NAME'));
        $client->setScopes(Google_Service_Directory::ADMIN_DIRECTORY_RESOURCE_CALENDAR_READONLY);


        $client->setAuthConfig(storage_path('gcalendar-keys/client_calendar_secret.json')); //setting keys from secret file
        print_r($client);
        exit;
        $client->setAccessType('offline');
        //$client->setApprovalPrompt(‘force’);
        $client->setPrompt('consent');
        $redirect_uri = url('/google-calendar/auth-callback');
        $client->setRedirectUri($redirect_uri);


        // exit;
        return $client;
    }



    public function oauth() {

        $client = $this->getClient();

        $credentialsPath = storage_path('keys/client_secret_generated.json');

        if (!file_exists($credentialsPath)) {

         return false;

        }

        $accessToken = json_decode(file_get_contents($credentialsPath), true);

        $client->setAccessToken($accessToken);

        // Refresh the token if it’s expired.

        if ($client->isAccessTokenExpired()) {

            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());

            file_put_contents($credentialsPath, json_encode($client->getAccessToken()));

        }

        return $client;

    }


    function getResource($client) {

        $service = new Google_Service_Calendar($client);

        print_r($service);
        exit;

        // On the user’s calenda print the next 10 events .

        $calendarId = 'primary';

        $optParams = array(

        'maxResults' => 10,

        'orderBy' => 'startTime',

        'singleEvents' => true,

        'timeMin' => date('c'),

        );

        $results = $service->events->listEvents($calendarId, $optParams);

        $events = $results->getItems();


        if (empty($events)) {

            // print 'No upcoming events found.\n';

        } else {

            // print 'Upcoming events:\n';

            foreach ($events as $event) {

                $start = $event->start->dateTime;

                if (empty($start)) {

                    $start = $event->start->date;

                }

                printf('%s (%s)\n', $event->getSummary(), $start);

            }

        }

    }
}
