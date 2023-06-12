<?php

namespace App\Http\Controllers;

use Google_Client;

class GoogleController extends Controller
{
    public function auth()
    {
        $client = new Google_Client();
        $client->setClientId(config('app.google_client_id'));
        $client->setClientSecret(config('app.google_client_secret'));
        $client->setRedirectUri(config('app.google_redirect_uri'));
        $client->setScopes(['https://www.googleapis.com/auth/calendar.events']);
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');
        $authUrl = $client->createAuthUrl();
        return redirect()->to($authUrl);
    }

    public function callback()
    {
        $client = new Google_Client();
        $client->setClientId(config('app.google_client_id'));
        $client->setClientSecret(config('app.google_client_secret'));
        $client->setRedirectUri(config('app.google_redirect_uri'));
        $client->setScopes(['https://www.googleapis.com/auth/calendar.events']);

        if (request('code')) {
            $accessToken = $client->fetchAccessTokenWithAuthCode(request('code'));
            // Save $accessToken to your database or session for future use
            // ...
        }

        // Redirect the user to the desired page
        return redirect()->route('home');
    }
}
