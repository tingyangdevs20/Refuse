<?php

namespace App\Helpers;
use Illuminate\Http\Request;

class ZoomHelper
{
	public static function CreateZoomMeeting(string $Topic, string $StartTime, $Duration, $meeting_password)
	{		
		// Modify the Start Time format a bit, YYYY-MM-DD HH:MM:SS to YYYY-MM-DDTHH:MM:SS
		$StartTime = str_replace(" ", "T", $StartTime);

		//Get Host Id and JWT Token from .env 		
		$ZOOM_Host_UserId = env('ZOOM_HOST_USERID');	
		$ZOOM_JWT_Token = env('ZOOM_JWT_TOKEN');
		$authorization = "Bearer " .$ZOOM_JWT_Token;	
		 
		try {
			$arr = array(
				"userid" => $ZOOM_Host_UserId,		
				"topic" => $Topic,			//Topic of the meeting.		
				"start_time" => $StartTime,		//e.g, "2020-10-21T10:30:00"
				"duration" => $Duration,
                "meeting_password" => $meeting_password,
				"authorization" => $authorization	
			);

			$dataRet = self::createMeeting($arr);
			return $dataRet;

		} catch (Exception $e) {
			echo "error";
		}
	}

	public static function createMeeting($arr)
	{
		$curl = curl_init();
		$data = [
			"topic" => $arr["topic"],
			"type" => 2,
			"start_time" => $arr["start_time"],
			"duration" => 	$arr["duration"],	//meeting duration in minutes.
			"password" => $arr["meeting_password"],
			"settings" => [
				"waiting_room" => true,
				"host_video" => true,
				"join_before_host" => true	
			]
		];
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://api.zoom.us/v2/users/" . $arr["userid"] . "/meetings",
			CURLOPT_POSTFIELDS => json_encode($data),
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_HTTPHEADER => array(
				"User-Agent: Zoom-Jwt-Request",
				"authorization: " . $arr["authorization"],
				"content-type: application/json"
			),
		));
		$response = curl_exec($curl);
		$data = json_decode($response);
		$err = curl_error($curl);
		curl_close($curl);
		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			return $data;
		}
	}
}

?>