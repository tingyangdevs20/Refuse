<?php

// app/Services/DatazappService.php

namespace App\Services;

use GuzzleHttp\Client;

class DatazappService
{
    protected $apiUrl = 'https://api.datazapp.com/';

    protected $apiKey;

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
            $contactsToSkipTrace = $this->filterContactsByType($contacts, 'skip_entire_list_phone');

        } elseif ($skipTraceOption === 'skip_records_without_numbers_phone') {
            $contactsToSkipTrace = $this->filterContactsByType($contacts, 'skip_records_without_numbers_phone');

        } elseif ($skipTraceOption === 'skip_entire_list_email') {
            $contactsToSkipTrace = $this->filterContactsByType($contacts, 'skip_entire_list_email');
        } elseif ($skipTraceOption === 'skip_records_without_emails') {
            $contactsToSkipTrace = $this->filterContactsByType($contacts, 'skip_records_without_emails');

        } elseif ($skipTraceOption === 'append_names'){
            $contactsToSkipTrace = $this->filterContactsByType($contacts, 'append_names');

        } elseif ($skipTraceOption === 'email_verification_entire_list'){
            $contactsToSkipTrace = $this->filterContactsByType($contacts, 'email_verification_entire_list');

        } elseif ($skipTraceOption === 'email_verification_non_verified'){
            $contactsToSkipTrace = $this->filterContactsByType($contacts, 'email_verification_non_verified');

        } elseif ($skipTraceOption === 'phone_scrub_entire_list'){
            $contactsToSkipTrace = $this->filterContactsByType($contacts, 'phone_scrub_entire_list');

        } elseif ($skipTraceOption === 'phone_scrub_non_scrubbed_numbers'){
            $contactsToSkipTrace = $this->filterContactsByType($contacts, 'phone_scrub_non_scrubbed_numbers');

        } elseif ($skipTraceOption === 'append_emails'){
            $contactsToSkipTrace = $this->filterContactsByType($contacts, 'append_emails');
        } else {
            // Handle other skip trace options if needed
            return ['message' => 'Invalid skip trace option.'];
        }

        if (empty($contactsToSkipTrace)) {
            return ['message' => 'No contacts matching the selected skip trace option.'];
        }

        // Prepare the request data based on the selected skip trace option
        $requestData = [
            "ApiKey" => "IFFVVZBJTO",
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

                ];
            }elseif($skipTraceOption === 'append_names'){
                // Name Append API request
                $requestData['AppendModule'] = "NameAppendAPI";


                $requestData['Data'][] = [

                    "Address" => $contact->street,
                    "City" => $contact->city,
                    "Zip" => $contact->zip,

                ];
            }
            elseif($skipTraceOption === 'append_emails'){
                // Name Append API request
                $requestData['AppendModule'] = "EmailAppend";
                $requestData['AppendType'] = 1; // 1 for Individual

                $requestData['Data'][] = [
                    "FirstName" => $contact->name,
                    "LastName" => $contact->last_name,
                    "Address" => $contact->street,
                    "City" => $contact->city,
                    "Zip" => $contact->zip,

                ];

            }elseif($skipTraceOption === 'email_verification_entire_list' || $skipTraceOption === 'email_verification_non_verified'){
                 // Emal Verificationd API request
                 $requestData['AppendModule'] = "EmailVerificationAPI";

                 $requestData['Data'][] = [

                     "Email" => $contact->email1,
                     "Email" => $contact->email2,

                 ];
            } elseif($skipTraceOption === 'phone_scrub_entire_list' || $skipTraceOption === 'phone_scrub_non_scrubbed_numbers'){
                 // phone scrubbing API request
                 $requestData['AppendModule'] = "PhoneScrubAPI";

                 $requestData['Data'][] = [

                     "Phone" => $contact->number,
                     "Phone" => $contact->number2,
                     "Phone" => $contact->number3,

                 ];
            }else {
                // Handle other skip trace options if needed
                return ['message' => 'Invalid skip trace option.'];
            }
        }

        $response = $client->post('https://secureapi.datazapp.com/Appendv2', [
            'json' => $requestData,
        ]);

        return json_decode($response->getBody(), true);
    }

    public function filterContactsByType($contacts, $type) {
        $filteredContacts = [];

        foreach ($contacts as $contact) {
            if ($type === 'skip_entire_list_phone' || $type == 'phone_scrub_entire_list') {
                // Check if the contact has a value in 'number', 'number2', or 'number3'
                if (!empty($contact->number) || !empty($contact->number2) || !empty($contact->number3)) {
                    $filteredContacts[] = $contact;
                }
            } elseif ($type === 'skip_records_without_numbers_phone' || $type == 'phone_scrub_non_scrubbed_numbers') {
                // Check if all three columns are empty
                if (empty($contact->number) && empty($contact->number2) && empty($contact->number3)) {
                    $filteredContacts[] = $contact;
                }
            } elseif ($type == 'skip_entire_list_email' || $type == 'email_verification_entire_list') {
                if (!empty($contact->email1) || !empty($contact->email2)) {
                    $filteredContacts[] = $contact;
                }
            } elseif ($type == 'skip_records_without_emails' || $type == 'email_verification_non_verified' || $type == 'append_emails') {
                // Check if all three columns are empty
                if (empty($contact->email1) && empty($contact->email2)) {
                    $filteredContacts[] = $contact;
                }
            } elseif ($type == 'append_names') {
                // Check if all three columns are empty
                if (empty($contact->name) && empty($contact->last_name)) {
                    $filteredContacts[] = $contact;
                }
            } elseif ($type == 'append_names') {
                // Check if all three columns are empty
                if (empty($contact->name) && empty($contact->last_name)) {
                    $filteredContacts[] = $contact;
                }
            } elseif ($type == 'append_names') {
                // Check if all three columns are empty
                if (empty($contact->name) && empty($contact->last_name)) {
                    $filteredContacts[] = $contact;
                }
            } elseif ($type == 'append_names') {
                // Check if all three columns are empty
                if (empty($contact->name) && empty($contact->last_name)) {
                    $filteredContacts[] = $contact;
                }
            }
        }

        return $filteredContacts;
    }

}
