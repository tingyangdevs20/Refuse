<?php

namespace Riazxrazor\Slybroadcast;

use GuzzleHttp\Client;

class Slybroadcast
{
    const BASE_URI = 'https://www.mobile-sphere.com/gateway/';

    public $DEBUG = false;
    // GuzzleHttp client for making http requests
    /**
     * Guzzle response
     */
    public $responseData;
    public $rawResponse;

    protected $httpClient;

    public $USER_EMAIL;
    public $PASSWORD;

    public function __construct($config)
    {
        foreach ($config as $key => $value)
        {
            $this->{$key} = $value;
        }

        $this->httpClient = new Client([
            'base_uri' => self::BASE_URI,
            'timeout' => 10
        ]);
    }

    public function setCredentials($uid,$pass)
    {
        $this->USER_EMAIL = $uid;
        $this->PASSWORD = $pass;
        return $this;
    }

    public function sendVoiceMail($postdata)
    {
        $this->apiCall('POST','vmb.php',$postdata);
        return $this;
    }

    public function pause($session_id)
    {
        $postdata['c_option'] = 'pause';
        $postdata['session_id'] = $session_id;

        $this->apiCall('POST','vmb.php',$postdata);
        return $this;
    }

    public function resume($session_id)
    {
        $postdata['c_option'] = 'run';
        $postdata['session_id'] = $session_id;


        $this->apiCall('POST','vmb.php',$postdata);
        return $this;
    }

    public function stop($session_id)
    {
        $postdata['c_option'] = 'stop';
        $postdata['session_id'] = $session_id;


        $this->apiCall('POST','vmb.php',$postdata);
        return $this;
    }

    public function callStatus($session_id,$phone)
    {
        $postdata['c_option'] = 'callstatus';
        $postdata['c_phone'] = $phone;
        $postdata['session_id'] = $session_id;


        $this->apiCall('POST','vmb.php',$postdata);
        $this->parseCallStatusResponse();
        return $this;
    }



    public function accountMessageBalance()
    {
        $postdata['remain_message'] = '1';
        $this->apiCall('POST','vmb.php',$postdata);
        $this->parseKeyValueResponse();
        return $this;
    }



    public function listAudioFiles()
    {
        $postdata['c_method'] = 'get_audio_list';

        $this->apiCall('POST','vmb.aflist.php',$postdata);
        $this->parseAudioResponse();
        return $this;
    }

    public function downloadAudioFile($audio_code)
    {
        $postdata['c_audio_code'] = $audio_code;
        $this->apiCall('POST','vmb.dla.php',$postdata);
        return $this;
    }

    public function getResponse()
    {
        return $this->responseData;
    }

    public function getRawResponse()
    {
        return $this->rawResponse;
    }


    private function apiCall(string $method, string $url,$postdata = [],array $extraData = [])
    {

        $params = [
        ];

        // POST REQUEST
        if(!empty($postdata))
        {
            $postdata['c_uid'] = $this->USER_EMAIL;
            $postdata['c_password'] = $this->PASSWORD;
            $params['form_params'] = $postdata;

            $params['headers'] = [
                'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36',
                'Upgrade-Insecure-Requests' => 1,
                'Content-Type' =>  'application/x-www-form-urlencoded',
                'Accept' =>  'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                'Accept-Encoding' => 'gzip, deflate, br',
                'Accept-Language' => 'en-US,en;q=0.8',
                'Cache-Control' => 'max-age=0',
                'Connection' => 'keep-alive',
            ];

            $params['debug'] = $this->DEBUG;

            $response = $this->httpClient->request($method, $url, $params);

        }
        else
        {
            //GET REQUEST
            $extraData = array_merge($extraData,$params);

            $extraData['debug'] = $this->DEBUG;

            $response = $this->httpClient->request($method, $url, $extraData);

        }


        $this->rawResponse = $response;
        $this->responseData = $response->getBody()->getContents();
        $this->parseResponse();
    }

    private function parseCallStatusResponse()
    {
        //$this->responseData = explode("\n",$this->responseData);
        $tmp = $this->responseData;
        $arr = [];
        if(!empty($this->responseData))
        {
            foreach ($this->responseData as $key => $value)
            {

                if(strpos($value,'|') != FALSE)
                {
                    $t = explode('|',$value);
                    $arr = [
                        'session_id' => explode('=',$t[0])[1],
                        'phone_no' => $t[1],
                        'status' => $t[2],
                        'failure_reason' => $t[3],
                        'delivery_date_time' => $t[4],
                        'carrier' => $t[5]
                    ];
                }
            }
            if(!empty($arr))
            {
                $this->responseData = $arr;
            }

        }

    }

    private function parseAudioResponse()
    {
        //$this->responseData = explode("\n",$this->responseData);
        $tmp = $this->responseData;
        $arr = [];
        if(!empty($this->responseData))
        {
            foreach ($this->responseData as $key => $value)
            {
                if(strpos($value,'|') != FALSE)
                {
                    $t = explode('|',$value);
                    $arr[] = [
                        'system_file_name' => $t[0],
                        'user_file_name' => $t[1],
                        'creation_time' => $t[2],
                        'duration' => $t[3] ?? ''
                    ];
                }
            }
            if(!empty($arr))
            {
                $this->responseData = $arr;
            }

        }

    }

    private function parseResponse()
    {
        $this->responseData = explode("\n",$this->responseData);

        if($this->responseData[0] == 'ERROR')
        {
            $this->parseStatusResponse();
        }
        else if($this->responseData[0] == 'OK')
        {
            $this->parseStatusResponse();
        }
    }

    private function parseStatusResponse()
    {
        $tmp = $this->responseData;
        $arr = [];
        if(!empty($this->responseData))
        {
            foreach ($this->responseData as $key => $value)
            {
                if(empty($value))
                {
                    continue;
                }

                if($key == 0)
                {
                    $arr['status'] = $value;
                }
                else
                {
                    if(strpos($value,':') != FALSE) {
                        $v = explode(':', $value);
                        $arr['errors'][$v[0]] = $v[1];
                    }
                    else
                    {
                        $arr['message'] = $value;
                    }
                }
            }
            if(!empty($arr))
            {
                $this->responseData = $arr;
            }

        }
    }

    private function parseKeyValueResponse()
    {
        $tmp = $this->responseData;
        $arr = [];
        if(!empty($this->responseData))
        {
            foreach ($this->responseData as $key => $value)
            {
                if(strpos($value,'=') != FALSE)
                {
                    $t = explode('=',$value);
                    $arr[$t[0]] = $t[1];
                }
            }
            if(!empty($arr))
            {
                $this->responseData = $arr;
            }

        }
    }
}