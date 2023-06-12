<?php

namespace App\Http\Controllers;

use Google_Client;
use Google_Service_Calendar;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    public function create(Request $request)
    {
        $client = new Google_Client();
        $client->setAuthConfig('client_secrets.json');
        $client->addScope(Google_Service_Calendar::CALENDAR_EVENTS);
        $client->setAccessToken($request->session()->get('google_access_token'));

        if ($client->isAccessTokenExpired()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            $request->session()->put('google_access_token', $client->getAccessToken());
        }

        $service = new Google_Service_Calendar($client);

        // Create a new event
        $event = new \Google_Service_Calendar_Event([
            'summary' => 'Online Meeting',
            'description' => 'This is an online meeting.',
            'start' => [
                'dateTime' => '2023-06-01T10:00:00',
                'timeZone' => 'Your-Time-Zone',
            ],
            'end' => [
                'dateTime' => '2023-06-01T11:00:00',
                'timeZone' => 'Your-Time-Zone',
            ],
        ]);

        $calendarId = 'primary'; // Use 'primary' for the default calendar

        $event = $service->events->insert($calendarId, $event);

        // Redirect or return response as per your requirements
        return redirect('/')->with('success', 'Meeting created successfully.');
    }
}
