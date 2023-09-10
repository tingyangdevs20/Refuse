<?php

class StanppMail
{
    public function createPostCard()
    {
        $curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://us.stannp.com/api/v1/postcards/create?api_key={API_KEY}',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => array(
        'test' => "true",
        'size' => "4x6",
        'front' => "https://www.stannp.com/assets/samples/a6-postcard-front.jpg",
        'message' => "hello world",
        'signature' => "",
        'recipient[title]' => "Mr",
        'recipient[firstname]' => "John",
        'recipient[lastname]' => "Smith",
        'recipient[address1]' => "123 Sample street",
        'recipient[city]' => "Sampletown",
        'recipient[zipcode]' => "12345",
        'recipient[country]' => "US"
    ),
));        
    }
}