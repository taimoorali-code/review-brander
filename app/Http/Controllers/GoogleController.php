<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GoogleAuthService;
use App\Services\GoogleBusinessService;

class GoogleController extends Controller
{
    // Step 1: Redirect user to Google Auth
    public function redirect(int $businessId, int $platformId)
    {
        $google = new GoogleAuthService($businessId, $platformId);
        return redirect()->away($google->getAuthUrl());
    }

    // Step 2: Handle OAuth callback
    public function callback(Request $request, int $businessId, int $platformId)
    {
        $google = new GoogleAuthService($businessId, $platformId);
        $token = $google->handleCallback($request->code);

        // Optionally save $token in DB with business_id
        return response()->json([
            'message' => 'Google account connected successfully.',
            'token' => $token,
        ]);
    }

    // Step 3: Fetch profiles
    public function listProfiles(Request $request)
    {
        $credentials = $request->all(); // or load from DB
        $googleBusiness = new GoogleBusinessService($credentials);
        $profiles = $googleBusiness->getAllProfiles();

        return response()->json($profiles);
    }
}
