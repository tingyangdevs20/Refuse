<?php

// app/Services/DatazappService.php

namespace App\Services;

use App\Model\Group;
use App\SkipTracingDetail;
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
                ];

                if ($contact->propertyInfo) {
                    $propertyData = [
                        "Address" => $contact->propertyInfo->property_street,
                        "City" => $contact->propertyInfo->property_city,
                        "Zip" => $contact->propertyInfo->property_zip,
                    ];

                    // Check if any of the property values is null and set them to null if needed
                    foreach ($propertyData as $key => $value) {
                        if ($value === null) {
                            $propertyData[$key] = null;
                        }
                    }

                    $requestData['Data'][] = $propertyData;
                }

            } elseif ($skipTraceOption === 'skip_entire_list_email' || $skipTraceOption === 'skip_records_without_emails') {
                // Email Append API request
                $requestData['AppendModule'] = "EmailAppend";
                $requestData['AppendType'] = 1; // 1 for Individual

                $requestData['Data'][] = [
                    "FirstName" => $contact->name,
                    "LastName" => $contact->last_name,
                ];

                if ($contact->propertyInfo) {
                    $propertyData = [
                        "Address" => $contact->propertyInfo->property_street,
                        "City" => $contact->propertyInfo->property_city,
                        "Zip" => $contact->propertyInfo->property_zip,
                    ];

                    // Check if any of the property values is null and set them to null if needed
                    foreach ($propertyData as $key => $value) {
                        if ($value === null) {
                            $propertyData[$key] = null;
                        }
                    }

                    $requestData['Data'][] = $propertyData;
                }

            }elseif($skipTraceOption === 'append_names'){
                // Name Append API request
                $requestData['AppendModule'] = "NameAppendAPI";


                if ($contact->propertyInfo) {
                    $propertyData = [
                        "Address" => $contact->propertyInfo->property_street,
                        "City" => $contact->propertyInfo->property_city,
                        "Zip" => $contact->propertyInfo->property_zip,
                    ];

                    // Check if any of the property values is null and set them to null if needed
                    foreach ($propertyData as $key => $value) {
                        if ($value === null) {
                            $propertyData[$key] = null;
                        }
                    }

                    $requestData['Data'][] = $propertyData;
                }
            }
            elseif($skipTraceOption === 'append_emails'){
                // Name Append API request
                $requestData['AppendModule'] = "EmailAppend";
                $requestData['AppendType'] = 1; // 1 for Individual

                $requestData['Data'][] = [
                    "FirstName" => $contact->name,
                    "LastName" => $contact->last_name,
                ];

                if ($contact->propertyInfo) {
                    $propertyData = [
                        "Address" => $contact->propertyInfo->property_street,
                        "City" => $contact->propertyInfo->property_city,
                        "Zip" => $contact->propertyInfo->property_zip,
                    ];

                    // Check if any of the property values is null and set them to null if needed
                    foreach ($propertyData as $key => $value) {
                        if ($value === null) {
                            $propertyData[$key] = null;
                        }
                    }

                    $requestData['Data'][] = $propertyData;
                }

            }elseif($skipTraceOption === 'email_verification_entire_list' || $skipTraceOption === 'email_verification_non_verified'){
                 // Emal Verificationd API request
                 $requestData['AppendModule'] = "EmailVerificationAPI";

                 if ($contact->leadInfo) {
                    $leadData = [
                        "Email" => $contact->leadInfo->owner1_email1,
                        "Email" => $contact->leadInfo->owner1_email2
                    ];

                    // Check if any of the property values is null and set them to null if needed
                    foreach ($leadData as $key => $value) {
                        if ($value === null) {
                            $leadData[$key] = null;
                        }
                    }

                    $requestData['Data'][] = $leadData;
                }
            } elseif($skipTraceOption === 'phone_scrub_entire_list' || $skipTraceOption === 'phone_scrub_non_scrubbed_numbers'){
                 // phone scrubbing API request
                 $requestData['AppendModule'] = "PhoneScrubAPI";

                 if ($contact->leadInfo) {
                    $propertyData = [
                        "Phone" => $contact->leadInfo->owner1_primary_phone,
                        "Phone" => $contact->leadInfo->owner1_number2,
                        "Phone" => $contact->leadInfo->owner1_number3,
                    ];

                    // Check if any of the property values is null and set them to null if needed
                    foreach ($propertyData as $key => $value) {
                        if ($value === null) {
                            $propertyData[$key] = null;
                        }
                    }

                    $requestData['Data'][] = $propertyData;
                }
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
        $record = $contacts->first();
        $phone_scrubbed_last_date = null;
        $emails_verified_date = null;
        $group = null;
        if ($record) {
            $group = Group::where('id', $record->group_id)->first();

            if ($group) {
                $phone_scrubbed_last_date = $group->phone_scrub_date;
                $emails_verified_date = $group->email_verification_date;
            }
        }
        $filteredContacts = [];

        foreach ($contacts as $contact) {
            // Access the leadInfo relation and its properties
            $leadInfo = $contact->leadInfo;

            if ($leadInfo) {
                if ($type === 'skip_entire_list_phone' || $type == 'phone_scrub_entire_list') {
                    // Check if the contact has a value in 'number', 'number2', or 'number3'
                    if (!empty($leadInfo->owner1_primary_number) || !empty($leadInfo->owner1_number2) || !empty($leadInfo->owner1_number3)) {
                            $filteredContacts[] = $contact;
                        }
                    } elseif ($type === 'skip_records_without_numbers_phone') {
                        // Check if all three columns are empty
                        if (empty($leadInfo->owner1_primary_number) && empty($leadInfo->owner1_number2) && empty($leadInfo->owner1_number3)) {
                            $filteredContacts[] = $contact;
                        }
                    } elseif ($type == 'skip_entire_list_email') {
                        if (!empty($leadInfo->owner1_email1) || !empty($leadInfo->owner1_email2)) {
                            $filteredContacts[] = $contact;
                        }
                    } elseif ($type == 'skip_records_without_emails' || $type == 'append_emails') {
                        // Check if all three columns are empty
                        if (empty($leadInfo->owner1_email1) && empty($leadInfo->owner1_email2)) {
                            $filteredContacts[] = $contact;
                        }
                    } elseif ($type == 'append_names') {
                        // Check if all three columns are empty
                        if (empty($contact->name) && empty($contact->last_name)) {
                            $filteredContacts[] = $contact;
                        }
                    }
            }
        }

        if($type == 'email_verification_non_verified') {
            if ($emails_verified_date != null) {
                // Fetch the emails scrubbed
                $emailsVerified = SkipTracingDetail::where('group_id', $group->id)
                    ->where('user_id', auth()->id())
                    ->whereIn('select_option', ['email_verification_non_verified', 'email_verification_entire_list'])
                    ->whereNotNull('email_verification_date')
                    ->pluck('append_emails')
                    ->toArray();

                foreach ($contacts as $contact) {
                    // Access the leadInfo relation and its properties
                    $leadInfo = $contact->leadInfo;

                    if ($leadInfo) {
                        // Check if any of the contact's emails are in $emailsVerified
                        if (in_array($leadInfo->owner1_email1, $emailsVerified) || in_array($leadInfo->owner1_email2, $emailsVerified)) {
                            $filteredContacts[] =$contact;
                        }
                    }
                }
            }
        } else if ($type == 'email_verification_entire_list') {
            if ($emails_verified_date != null) {
                // Fetch the emails scrubbed
                $emailsVerified = SkipTracingDetail::where('group_id', $group->id)
                    ->where('user_id', auth()->id())
                    ->whereIn('select_option', ['email_verification_non_verified', 'email_verification_entire_list'])
                    ->whereNotNull('email_verification_date')
                    ->pluck('append_emails')
                    ->toArray();

                foreach ($contacts as $contact) {
                    // Access the leadInfo relation and its properties
                    $leadInfo = $contact->leadInfo;

                    if ($leadInfo) {
                        // Check if any of the contact's emails are in $emailsVerified
                        if (!in_array($leadInfo->owner1_email1, $emailsVerified) && !in_array($leadInfo->owner1_email2, $emailsVerified)) {
                            $filteredContacts[] =$contact;
                        }
                    }

                }
            }
        } else if ($type == 'phone_scrub_non_scrubbed_numbers') {
            if ($phone_scrubbed_last_date != null) {
                // Fetch the phones scrubbed
                $phonesScrubbed = SkipTracingDetail::where('group_id', $group->id)
                    ->where('user_id', auth()->id())
                    ->whereIn('select_option', ['phone_scrub_non_scrubbed_numbers', 'phone_scrub_entire_list'])
                    ->whereNotNull('phone_scrub_date')
                    ->pluck('verified_numbers')
                    ->toArray();

                foreach ($contacts as $contact) {
                    // Access the leadInfo relation and its properties
                    $leadInfo = $contact->leadInfo;

                    if ($leadInfo) {
                        // Check if any of the contact's numbers are in $phonesScrubbed
                        if (in_array($leadInfo->owner1_primary_number, $phonesScrubbed) ||
                            in_array($leadInfo->owner1_number2, $phonesScrubbed) ||
                            in_array($leadInfo->owner1_number3, $phonesScrubbed)) {
                            $filteredContacts[] = $contact;
                        }
                    }
                }
            }
        } else if ($type == 'phone_scrub_entire_list') {
            if ($phone_scrubbed_last_date != null) {
                // Fetch the phones scrubbed
                $phonesScrubbed = SkipTracingDetail::where('group_id', $group->id)
                    ->where('user_id', auth()->id())
                    ->whereIn('select_option', ['phone_scrub_non_scrubbed_numbers', 'phone_scrub_entire_list'])
                    ->whereNotNull('phone_scrub_date')
                    ->pluck('verified_numbers')
                    ->toArray();

                foreach ($contacts as $contact) {
                    // Access the leadInfo relation and its properties
                    $leadInfo = $contact->leadInfo;

                    if ($leadInfo) {
                        // Check if any of the contact's numbers are in $phonesScrubbed
                        if (!in_array($leadInfo->owner1_primary_number, $phonesScrubbed) &&
                            !in_array($leadInfo->owner1_number2, $phonesScrubbed) &&
                            !in_array($leadInfo->owner1_number3, $phonesScrubbed)) {
                            $filteredContacts[] = $contact;
                        }
                    }
                }
            }
        }


        return $filteredContacts;
    }

}
