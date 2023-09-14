<?php

// app/Services/DatazappService.php

namespace App\Services;

use GuzzleHttp\Client;

class DatazappService
{
    protected $apiUrl = 'https://api.datazapp.com/';

    protected $apiKey; // Set your Datazapp API key here

    public function __construct()
    {
        $this->apiKey = config('services.datazapp.api_key');
    }

    public function skipTrace($contacts)
    {
        $client = new Client();

        // Filter contacts to skip trace only those with phone numbers
        $contactsToSkipTrace = $contacts->filter(function ($contact) {
            return !empty($contact->number);
        });

        if ($contactsToSkipTrace->isEmpty()) {
            return ['message' => 'No contacts with phone numbers to skip trace.'];
        }

        // Prepare the request data based on the Datazapp API example
        $requestData = [
            "ApiKey" => "IFFVVZBJTO",
            "AppendModule" => "EmailAppend",
            "AppendType" => 1, // 1 for Individual
            "Data" => [],
        ];

        foreach ($contactsToSkipTrace as $contact) {
            $requestData['Data'][] = [
                "FirstName" => $contact->name,
                "LastName" => $contact->last_name,
                "Address" => $contact->street,
                "City" => $contact->city,
                "Zip" => $contact->zip,
            ];
        }

        $response = $client->post('https://secureapi.datazapp.com/Appendv2', [
            'json' => $requestData,
        ]);

        return json_decode($response->getBody(), true);
    }


}
