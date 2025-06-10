<?php

use Illuminate\Support\Facades\Route;
use App\Helpers\AgoraTokenGenerator;

// Temporary video route for simple test setup for a 1-on-1 call
Route::get('/', function () {
    // Define a static channel for testing
    $channelName = 'testchannel';

    // Use a random user id
    $uid = rand(1000, 9999);

    // Generate Agora RTC token for this user and channel
    $token = AgoraTokenGenerator::createToken($channelName, $uid);

    // Pass all values to the video view
    return view('video', [
        'appID'   => env('AGORA_APP_ID'),
        'channel' => $channelName,
        'uid'     => $uid,
        'token'   => $token,
    ]);
});
