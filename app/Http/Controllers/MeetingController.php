<?php

namespace App\Http\Controllers;

use Google_Client;
use Google\Service\Calendar;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Google\Service\Calendar\EventDateTime;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    public function authenticate()
    {
        $client = new Google_Client();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri(config('services.google.redirect'));
        $client->addScope(Google_Service_Calendar::CALENDAR);

        return Redirect::to($client->createAuthUrl());
    }

    public function create(Request $request)
    {
        $client = new Google_Client();
        $client->setAuthConfig('client_secrets.json');
        $client->addScope(Google_Service_Calendar::CALENDAR_EVENTS);
        // dd($token);
        $client->setAccessToken($request->session()->get('google_access_token'));
        $token = $request->session()->get('google_access_token');

        if ($client->isAccessTokenExpired()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            $request->session()->put('google_access_token', $client->getAccessToken());
        }

        $service = new Google_Service_Calendar($client);
        // dd($request);

        // Create a new event
        // $event = new Google_Service_Calendar_Event([
        //     'summary' => 'Online Meeting',
        //     'description' => 'This is an online meeting.',
        //     'start' => [
        //         'dateTime' => '2023-06-12T10:00:00',
        //         'timeZone' => 'Asia/Yangon',
        //     ],
        //     'end' => [
        //         'dateTime' => '2023-06-12T11:00:00',
        //         'timeZone' => 'Asia/Yangon',
        //     ],
        // ]);
        // dd($event);

        // $calendarId = 'primary'; 

        // $event = $service->events->insert($calendarId, $event);

        // return redirect('/')->with('success', 'Meeting created successfully.');

        $event = new Google_Service_Calendar_Event();
        $startDateTime = new EventDateTime();
        $endDateTime = new EventDateTime();
        $event->setSummary('Meeting');
        $event->setDescription('Google Meeting');
        $startDateTime->setDateTime($request->start_time . ':00');
        $endDateTime->setDateTime($request->end_time . ':00');
        $startDateTime->setTimeZone('Asia/Yangon');
        $endDateTime->setTimeZone('Asia/Yangon');
        $event->setStart($startDateTime);
        $event->setEnd($endDateTime);
        // dd($event);
        $calendarId = 'primary';
        $service->events->insert($calendarId, $event);

        return view('welcome');
    }
}
