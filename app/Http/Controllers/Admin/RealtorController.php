<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Contact;
use Illuminate\Http\Request;

class RealtorController extends Controller
{
    public function getPropertyId(Request $request)
    {
        $contact = Contact::find($request->id);

        if (!$contact) {
            return response()->json([
                'status' => false,
                'message' => 'Contact not found!'
            ]);
        }

        // Check if user has address
        if (!($contact->street && $contact->city && $contact->state && $contact->zip)) {
            return response()->json([
                'status' => false,
                'message' => 'Contact address not found! Update Contact Address to use this.'
            ]);
        }

        // Format Address
        $address = $contact->street . ' ' . $contact->city . ', ' . $contact->state . ' ' . $contact->zip;
        // $address = '939 Coast Blvd Unit 20C La Jolla, CA 92037';

        // Call the API
        $id = $this->realtorAPI($address);

        // Check if ID is retreived
        if ($id == null) {
            return response()->json([
                'status' => false,
                'message' => 'No property found with your address!',
                'id' => $id
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Property found!',
            'id' => $id
        ]);
    }

    // Call Realtor API
    public function realtorAPI($address)
    {

        $client = new \GuzzleHttp\Client();

        $response = $client->request('GET', 'https://realtor.p.rapidapi.com/locations/v2/auto-complete?input=' . $address . '&limit=1', [
            'headers' => [
                'X-RapidAPI-Host' => 'realtor.p.rapidapi.com',
                'X-RapidAPI-Key' => 'ace4ae5402mshe96807481202d80p1d71a4jsn3e752df9c9b4',
            ],
        ]);

        $result = json_decode($response->getBody());

        $id = null; // Initialize the $id variable

        // Check if $result is set and if $result->autocomplete is an array with at least one element
        if (isset($result) && isset($result->autocomplete) && is_array($result->autocomplete) && count($result->autocomplete) > 0) {
            // Check if the first element has the 'mpr_id' property
            if (isset($result->autocomplete[0]->mpr_id)) {
                // Assign the 'mpr_id' value to $id
                $id = $result->autocomplete[0]->mpr_id;
            }
        }
        return $id;
    }

    public function getPropertyEstimates(Request $request)
    {
        $id = (int) $request->id;
        if ($id == null) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid property id. Unable to fetch details!'
            ]);
        }
        // Call the API
        $estimates = $this->fetchEstimates($id);

        if ($estimates == null) {
            return response()->json([
                'status' => false,
                'message' => 'Error fetching property estimates!'
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Property estimates fetched!',
            'estimates' => $estimates
        ]);
    }

    public function fetchEstimates($id)
    {
        $client = new \GuzzleHttp\Client();

        $response = $client->request('GET', 'https://realtor.p.rapidapi.com/properties/v3/detail?property_id=' . $id, [
            'headers' => [
                'X-RapidAPI-Host' => 'realtor.p.rapidapi.com',
                'X-RapidAPI-Key' => 'ace4ae5402mshe96807481202d80p1d71a4jsn3e752df9c9b4',
            ],
        ]);

        $result = json_decode($response->getBody());

        if ($result && isset($result->data) && isset($result->data->home) && isset($result->data->home->estimates->current_values)) {
            // Access the estimates
            $estimates = $result->data->home->estimates->current_values;
            return $estimates;
        } else {
            return null;
        }
    }
}
