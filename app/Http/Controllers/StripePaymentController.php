<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Stripe\Stripe;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use DB;
use App\Model\Group;
use Session;
use Exception;
use Stripe\Charge;
use Stripe\PaymentIntent;
use App\Services\DatazappService;
use App\AccountDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Cashier\Cashier;

use Stripe\PaymentMethod;
use Stripe\Exception\CardException;

class StripePaymentController extends Controller
{

    public function payment($token)
    {

         // Decrypt the token (base64 decoding)
        $decodedToken = base64_decode($token);

        // Extract the parameters from the token
        $parameterArray = explode('-', $decodedToken);


        // Extract the parameters
        $price = $parameterArray[0];
        $groupId = $parameterArray[1];
        $selectedOption = $parameterArray[2];

        Session::put('payment_info', [
            'price' => $price,
            'group_id' => $groupId,
            'selected_option' => $selectedOption,
        ]);


        return view('back.pages.stripe.payment', compact('price', 'groupId', 'selectedOption'));
    }

    public function createPaymentIntent(Request $request)
    {


        Stripe::setApiKey('sk_test_51MtZDzApRCJCEL2vCbKHJHE0dMDGNMyC7eaqwXvl5HpIgmb85GfWgaL3BoYPhlDHmcgOLC8cWxuARc2vHhbwifwk00sXNic2le'); // Replace with your actual Stripe secret key

        $paymentInfo = Session::get('payment_info');

        $user_id = auth()->id();
        $amount = $paymentInfo['price'] * 100; // Convert to cents

        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => $amount,
                'currency' => 'usd',
                'description' => 'Skip tracing payment',
                'payment_method_types' => ['card'], // Make sure 'card' is enabled in your Stripe settings
            ]);

            Session::put('payment_intent_id', $paymentIntent->id);

            return response()->json(['client_secret' => $paymentIntent->client_secret]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function processPayment(Request $request)
    {

        Stripe::setApiKey('sk_test_51MtZDzApRCJCEL2vCbKHJHE0dMDGNMyC7eaqwXvl5HpIgmb85GfWgaL3BoYPhlDHmcgOLC8cWxuARc2vHhbwifwk00sXNic2le');

        $paymentInfo = Session::get('payment_info');
        $paymentIntentId = Session::get('payment_intent_id');

        $user_id = auth()->id();
        $amount = $paymentInfo['price'] * 100; // Convert to cents

        try {
            // Retrieve the PaymentIntent based on a unique identifier (e.g., order ID)
           // Replace with your order ID logic
            $paymentIntent = \Stripe\PaymentIntent::retrieve($paymentIntentId);

            // Check the PaymentIntent status
            if ($paymentIntent->status === 'succeeded') {
                DB::table('skip_tracing_payment_records')->insert([
                    'user_id' => $user_id,
                    'skip_trace_option_id' => $paymentInfo['selected_option'],
                    'group_id' => $paymentInfo['group_id'],
                    'amount' => $paymentInfo['price'],
                    'is_paid' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                Session::put('payment_sucess','sucess');
                return redirect()->route('payment.success');
            }

            // Continue with confirming the PaymentIntent if it's not succeeded
            $paymentIntent->confirm();

            // Check the payment status after confirmation
            if ($paymentIntent->status === 'succeeded') {
                // Payment succeeded, store it as paid
                DB::table('skip_tracing_payment_records')->insert([
                    'user_id' => $user_id,
                    'skip_trace_option_id' => $paymentInfo['selected_option'],
                    'group_id' => $paymentInfo['group_id'],
                    'amount' => $paymentInfo['price'],
                    'is_paid' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                Session::forget('payment_info');
                Session::put('payment_sucess','sucess');
                Session::flash('success', 'Payment Successfully Processed!');
                return redirect()->route('payment.success');
            } else {
                // PaymentIntent status is not 'succeeded' even after confirmation
                Session::flash('error', 'PaymentIntent confirmation failed.');
                return redirect()->route('payment.failed');
            }
        } catch (Exception $e) {
            // Handle the exception and report the error
            DB::table('skip_tracing_payment_records')->insert([
                'user_id' => $user_id,
                'skip_trace_option_id' => $paymentInfo['selected_option'],
                'group_id' => $paymentInfo['group_id'],
                'amount' => $paymentInfo['price'],
                'is_paid' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            dd($e->getMessage());
            Session::flash('error', 'Payment failed! ' . $e->getMessage());
            return redirect()->route('payment.failed');
        }


    }

    public function paymentSuccess(DatazappService $datazappService, Request $request)
    {
         // Initialize the result variable
       $result = null;
       $paymentInfo = Session::get('record_detail');
       $date = date('d-m-y');


       // Perform skip tracing based on the selected option
       if ($paymentInfo['selectedOption'] === 'skip_entire_list_phone' || $paymentInfo['selectedOption'] === 'skip_records_without_numbers_phone') {
           // Implement skip tracing logic for the entire list of phone numbers
           $result = $datazappService->skipTrace($paymentInfo['uniqueContacts'], $paymentInfo['selectedOption']);

           if ($result) {
            // Check if $result contains the expected data structure
            if (
                isset($result['ResponseDetail']['Data']) &&
                is_array($result['ResponseDetail']['Data'])
            ) {
                $data = $result['ResponseDetail']['Data'];

                foreach ($data as $record) {
                    // Check if the record has a matched phone number
                    if (
                        isset($record['Matched']) &&
                        $record['Matched'] &&
                        isset($record['Phone'])
                    ) {
                        $matchedPhone = $record['Phone'];

                        // Find the corresponding contact based on additional criteria
                        $matchingContact = $paymentInfo['uniqueContacts']->first(function ($contact) use ($record) {
                            return (
                                $contact->name === $record['FirstName'] &&
                                $contact->last_name === $record['LastName'] &&
                                $contact->street === $record['Address'] &&
                                $contact->city === $record['City'] &&
                                $contact->zip === $record['Zip']
                            );
                        });

                        // Update the contact in the database with the matched phone number

                        if ($matchingContact) {
                            $matchingContact->update(['number' => $matchedPhone]);
                        }

                        $group_data = $paymentInfo['group'];


                        if($group_data){

                            $group = Group::where('id', $group_data->id)->first();

                            $group->email_skip_trace_date = $date;
                            $group->save();
                        }

                    }
                }
            }
        }


       } elseif ($paymentInfo['selectedOption'] === 'skip_entire_list_email' || $paymentInfo['selectedOption'] === 'skip_records_without_emails') {
           // Implement skip tracing logic for the entire list of emails
           $result = $datazappService->skipTrace($paymentInfo['uniqueContacts'], $paymentInfo['selectedOption']);

           if ($result) {
            // Check if $result contains the expected data structure
            if (
                isset($result['ResponseDetail']['Data']) &&
                is_array($result['ResponseDetail']['Data'])
            ) {
                $data = $result['ResponseDetail']['Data'];

                foreach ($data as $record) {
                    // Check if the record has a matched phone number
                    if (
                        isset($record['Matched']) &&
                        $record['Matched'] &&
                        isset($record['Email'])
                    ) {
                        $matchedEmail = $record['Email'];

                        // Find the corresponding contact based on additional criteria
                        $matchingContact = $paymentInfo['uniqueContacts']->first(function ($contact) use ($record) {
                            return (
                                $contact->name === $record['FirstName'] &&
                                $contact->last_name === $record['LastName'] &&
                                $contact->street === $record['Address'] &&
                                $contact->city === $record['City'] &&
                                $contact->zip === $record['Zip']
                            );
                        });

                        // Update the contact in the database with the matched phone number
                        if ($matchingContact) {
                            $matchingContact->update(['email1' => $matchedEmail]);
                        }

                        $group_data = $paymentInfo['group'];


                        if($group_data){

                            $group = Group::where('id', $group_data->id)->first();
                            $group->email_skip_trace_date = $date;
                            $group->save();
                        }
                    }
                }
            }
        }

       } elseif ($paymentInfo['selectedOption'] === 'append_names') {
           // Implement append names logic for records without names
           $result = $datazappService->skipTrace($paymentInfo['uniqueContacts'], $paymentInfo['selectedOption']);

           if ($result) {
            // Check if $result contains the expected data structure
            if (
                isset($result['ResponseDetail']['Data']) &&
                is_array($result['ResponseDetail']['Data'])
            ) {
                $data = $result['ResponseDetail']['Data'];

                foreach ($data as $record) {
                    // Check if the record has a matched phone number
                    if (
                        isset($record['Matched']) &&
                        $record['Matched']
                    ) {
                        $matchedFirstName = $record['FirstName'];
                        $matchedLastName = $record['LastName'];

                        // Find the corresponding contact based on additional criteria
                        $matchingContact = $paymentInfo['uniqueContacts']->first(function ($contact) use ($record) {
                            return (


                                $contact->street === $record['Address'] &&
                                $contact->city === $record['City'] &&
                                $contact->zip === $record['Zip']
                            );
                        });

                        // Update the contact in the database with the matched phone number
                        if ($matchingContact) {
                            $matchingContact->update([
                                'name' => $matchedFirstName,
                                'last_name' => $matchedLastName,
                            ]);
                        }

                        $group_data = $paymentInfo['group'];


                        if($group_data){

                            $group = Group::where('id', $group_data->id)->first();
                            $group->name_skip_trace_date = $date;
                            $group->save();
                        }
                    }
                }
            }
        }


       } elseif ($paymentInfo['selectedOption'] === 'email_verification_entire_list' || $paymentInfo['selectedOption'] === 'email_verification_non_verified') {
           // Implement email verification logic for the entire list of emails
           $result = $datazappService->skipTrace($paymentInfo['uniqueContacts'], $paymentInfo['selectedOption']);

           if ($result) {
            // Check if $result contains the expected data structure
            if (
                isset($result['ResponseDetail']['Data']) &&
                is_array($result['ResponseDetail']['Data'])
            ) {
                $data = $result['ResponseDetail']['Data'];

                foreach ($data as $record) {
                    // Check if the record has a matched phone number
                    if (
                        isset($record['Matched']) &&
                        $record['Matched']
                    ) {
                        $matchedEmail1 = $record['Email'];
                        $matchedEmail2 = $record['Email'];

                        // Find the corresponding contact based on additional criteria
                        $matchingContact = $paymentInfo['uniqueContacts']->first(function ($contact) use ($record) {
                            return (

                                $contact->street === $record['Address'] &&
                                $contact->city === $record['City'] &&
                                $contact->zip === $record['Zip']
                            );
                        });

                        // Update the contact in the database with the matched phone number
                        if ($matchingContact) {
                            $matchingContact->update([
                                'email1' => $matchedEmail1,
                                'email2' => $matchedEmail2,
                            ]);
                        }

                        $group_data = $paymentInfo['group'];


                        if($group_data){

                            $group = Group::where('id', $group_data->id)->first();
                            $group->email_verification_date = $date;
                            $group->save();
                        }
                    }
                }
            }
        }

       } elseif ($paymentInfo['selectedOption'] === 'phone_scrub_entire_list' || $paymentInfo['selectedOption'] === 'phone_scrub_non_scrubbed_numbers') {
           // Implement phone scrubbing logic for the entire list of phone numbers
           $result = $datazappService->skipTrace($paymentInfo['uniqueContacts'], $paymentInfo['selectedOption']);

           if ($result) {
            // Check if $result contains the expected data structure
            if (
                isset($result['ResponseDetail']['Data']) &&
                is_array($result['ResponseDetail']['Data'])
            ) {
                $data = $result['ResponseDetail']['Data'];

                foreach ($data as $record) {
                    // Check if the record has a matched phone number
                    if (
                        isset($record['Matched']) &&
                        $record['Matched']
                    ) {
                        $matchedPhone1 = $record['Phone'];
                        $matchedPhone2 = $record['Phone'];
                        $matchedPhone3 = $record['Phone'];

                        // Find the corresponding contact based on additional criteria
                        $matchingContact = $paymentInfo['uniqueContacts']->first(function ($contact) use ($record) {
                            return (

                                $contact->name === $record['FirstName'] &&
                                $contact->last_name === $record['LastName'] &&
                                $contact->street === $record['Address'] &&
                                $contact->city === $record['City'] &&
                                $contact->zip === $record['Zip']
                            );
                        });

                        // Update the contact in the database with the matched phone number
                        if ($matchingContact) {
                            $matchingContact->update([
                                'number' => $matchedPhone1,
                                'number2' => $matchedPhone2,
                                'number3' => $matchedPhone3,
                            ]);
                        }

                        $group_data = $paymentInfo['group'];


                        if($group_data){

                            $group = Group::where('id', $group_data->id)->first();
                            $group->phone_scrub_date = $date;
                            $group->save();
                        }
                    }
                }
            }
        }

       } else {
           // Handle other options or provide an error response
           return response()->json(['error' => 'Invalid skip trace option.']);
       }

       Session::forget('record_detail');
       Session::flash('payment_success_data', $result);

        return redirect()->route('admin.group.index');
    }

    public function paymentFailed()
    {
        Session::flash('payment_error', 'Payment failed. Please try again.');
        return redirect()->route('admin.group.index');
    }

    public function cancelPayment()
    {
        Session::forget('payment_info');
        Session::flash('payment_infoo', 'Payment was canceled.');
        return redirect()->route('admin.group.index');
    }


    public function processStripePayment(Request $request)
    {


        try {
            // Set your Stripe API key here
            Stripe::setApiKey(config('services.stripe.secret'));

            // Retrieve the payment method ID from the form
            $paymentMethodId = $request->input('payment_method');

            // Define the return URL
            $returnUrl = 'https://example.com/payment-success'; // Replace with your actual success URL

            // Create a payment intent with the return URL
            $intent = \Stripe\PaymentIntent::create([
                'amount' => $request->input('amount') * 100, // Amount in cents
                'currency' => 'usd', // Change to your preferred currency
                'payment_method' => $paymentMethodId,
                'confirmation_method' => 'manual',
                'confirm' => true,
                'return_url' => $returnUrl, // Specify the return URL
            ]);

            // Handle successful payment
            if ($intent->status === 'succeeded') {
                $user = Auth::user();
                $amount = $request->input('amount');
                $currency = 'usd';

                // Create a new record in the account_details table
                $accountDetail = new AccountDetail();
                $accountDetail->user_id = $user->id;
                $accountDetail->transaction_id = $intent->id; // Payment intent ID
                $accountDetail->payment_method = 'card'; // You can customize this based on payment method
                $accountDetail->amount = $amount;
                $accountDetail->currency = $currency;
                $accountDetail->transaction_date = now(); // Current date and time
                $accountDetail->status = 'succeeded'; // Transaction status
                $accountDetail->save();

                // Return a success response
                return response()->json(['message' => 'Payment successful']);
            } else {
                // Payment failed
                return response()->json(['error' => 'Payment failed']);
            }
        } catch (CardException $e) {
            // Handle card errors (e.g., insufficient funds, card declined)
            return response()->json(['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            // Handle other errors
            return response()->json(['error' => 'An error occurred while processing your payment']);
        }
    }

    public function paypalStore(Request $request)
    {

        $data = $request->validate([
            'transaction_id' => 'required',
            'payment_method' => 'required',
            'amount' => 'required|numeric',
            'transaction_date' => 'required|date',
            'status' => 'required',
        ]);

        // Create a new transaction record in the database
        $user = Auth::user();
        $accountDetail = new AccountDetail();
        $accountDetail->user_id = $user->id;
        $accountDetail->transaction_id = $request->transaction_id;
        $accountDetail->payment_method = $request->payment_method;
        $accountDetail->amount = $request->amount;
        $accountDetail->currency = 'usd';
        $accountDetail->transaction_date = $request->transaction_date;
        $accountDetail->status = $request->status;
        $accountDetail->save();

        // You can return a success response if needed
        return response()->json(['success' => true]);
    }



}
