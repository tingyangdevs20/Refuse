<?php

namespace App\Http\Traits;
use Illuminate\Support\Facades\Http;

trait ZoomMeetingTrait
{
    public function createZoomMeeting($topic, $start_time, $duration)
    {
        $response = Http::post('https://api.zoom.us/v2/users/{user_id}/meetings', [
            'topic' => $topic,
            'type' => 2, // Scheduled meeting
            'start_time' => $start_time,
            'duration' => 60, // Duration in minutes
            // Add other Zoom meeting parameters here
        ], [
            'headers' => [
                'Authorization' => 'Bearer ' . config('zoom.api_token'),
            ],
        ]);

        if ($response->successful()) {
            return $response->json();
        } else {
            throw new \Exception('Failed to create Zoom meeting');
        }
    }
}
