<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Exception;

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

        // Check if user has property address
        $property_infos = DB::table('property_infos')->where('contact_id', $contact->id)->first();

        if ($property_infos === null || empty($property_infos->property_address) || empty($property_infos->property_city) || empty($property_infos->property_state) || empty($property_infos->property_zip)) {
            return response()->json([
                'status' => false,
                'message' => 'Property address not found. Add your property address and try again!'
            ]);
        }

        // Format Address
        $address = $property_infos->property_address . ' ' . $property_infos->property_city . ', ' . $property_infos->property_state . ' ' . $property_infos->property_zip;
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

    public function getMapLinks(Request $request)
    {
        $id = $request->id;
        $property_infos = DB::table('property_infos')->where('contact_id', $id)->first();
        if ($property_infos === null || empty($property_infos->property_address) || empty($property_infos->property_city) || empty($property_infos->property_state) || empty($property_infos->property_zip)) {
            return response()->json([
                'status' => false,
                'message' => 'Property address not found. Add your property address and try again!'
            ]);
        }
        $map_link = "https://www.google.com/maps?q=" . urlencode("$property_infos->property_address, $property_infos->property_city, $property_infos->property_state, $property_infos->property_zip");
        DB::table('property_infos')->where('contact_id', $id)->update(['zillow_link' => $map_link]);
        return response()->json([
            'status' => true,
            'message' => 'Google Map link fetched!',
            'link' => $map_link
        ]);
    }

    public function getZillowLinks(Request $request)
    {


        try {
            $client = new \GuzzleHttp\Client();
            $id = $request->id;
            $property_infos = DB::table('property_infos')->where('contact_id', $id)->first();

            if ($property_infos === null || empty($property_infos->property_address) || empty($property_infos->property_city) || empty($property_infos->property_state) || empty($property_infos->property_zip)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Property address not found. Add your property address and try again!'
                ]);
            }

            $response = $client->request('GET', 'https://zillow56.p.rapidapi.com/search_address?address=' . urlencode($property_infos->property_address . ', ' . $property_infos->property_city . ', ' . $property_infos->property_state . ', ' . $property_infos->property_zip), [
                'headers' => [
                    'X-RapidAPI-Host' => 'zillow56.p.rapidapi.com',
                    'X-RapidAPI-Key' => 'ace4ae5402mshe96807481202d80p1d71a4jsn3e752df9c9b4',
                ],
            ]);

            $result = json_decode($response->getBody());
            DB::table('property_infos')->where('contact_id', $id)->update(['zillow_link' => $result->hdpUrl]);
            return response()->json([
                'status' => true,
                'message' => 'Google Map link fetched!',
                'link' => $result->hdpUrl
            ]);
        } catch (GuzzleException $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while making the request to the external service.'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An unexpected error occurred.'
            ]);
        }
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
