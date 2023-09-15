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

    public function skipTrace($contacts, $skipTraceOption)
    {


        $client = new Client();

        // Filter contacts based on the selected skip trace option
        $contactsToSkipTrace = collect([]);

        if ($skipTraceOption === 'skip_entire_list_phone') {
            $contactsToSkipTrace = $contacts->where('number', '!=', '');
        } elseif ($skipTraceOption === 'skip_records_without_numbers_phone') {
            $contactsToSkipTrace = $contacts->where('number', '');
        } elseif ($skipTraceOption === 'skip_entire_list_email') {
            $contactsToSkipTrace = $contacts->where('email1', '!=', '');
        } elseif ($skipTraceOption === 'skip_records_without_emails') {
            $contactsToSkipTrace = $contacts->where('email1', '');
        } else {
            // Handle other skip trace options if needed
            return ['message' => 'Invalid skip trace option.'];
        }

        if ($contactsToSkipTrace->isEmpty()) {
            return ['message' => 'No contacts matching the selected skip trace option.'];
        }

        // Prepare the request data based on the selected skip trace option
        $requestData = [
            "ApiKey" => "IFFVVZBJTO", // Replace with your API key
            "Data" => [],
        ];

        foreach ($contactsToSkipTrace as $contact) {
            if ($skipTraceOption === 'skip_entire_list_phone' || $skipTraceOption === 'skip_records_without_numbers_phone') {
                // Phone Append API request
                $requestData['AppendModule'] = "PhoneAppendAPI";
                $requestData['AppendType'] = 2; // 2 for Landline
                $requestData['DncFlag'] = "true"; // Set DNC flag if needed

                $requestData['Data'][] = [
                    "FirstName" => $contact->name,
                    "LastName" => $contact->last_name,
                    "Address" => $contact->street,
                    "City" => $contact->city,
                    "Zip" => $contact->zip,
                    // Add other required parameters for phone append
                ];
            } elseif ($skipTraceOption === 'skip_entire_list_email' || $skipTraceOption === 'skip_records_without_emails') {
                // Email Append API request
                $requestData['AppendModule'] = "EmailAppend";
                $requestData['AppendType'] = 1; // 1 for Individual

                $requestData['Data'][] = [
                    "FirstName" => $contact->name,
                    "LastName" => $contact->last_name,
                    "Address" => $contact->street,
                    "City" => $contact->city,
                    "Zip" => $contact->zip,
                    // Add other required parameters for email append
                ];
            } else {
                // Handle other skip trace options if needed
                return ['message' => 'Invalid skip trace option.'];
            }
        }

        $response = $client->post('https://secureapi.datazapp.com/Appendv2', [
            'json' => $requestData,
        ]);

        return json_decode($response->getBody(), true);
    }



}
