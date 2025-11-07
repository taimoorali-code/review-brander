<?php



namespace App\Http\Controllers;

use App\Models\Platform;
use App\Models\Business;
use App\Services\GoogleAuthService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PlatformController extends Controller
{
    /**
     * Display all platforms for a specific business.
     */
    public function index($businessId)
    {
        $business = Business::findOrFail($businessId);
        $platforms = $business->platforms()->latest()->get();

        if (request()->wantsJson()) {
            return response()->json($platforms);
        }

        return view('admin.bussiness.platform', compact('business', 'platforms'));
    }

    /**
     * Show form to create a new platform.
     */
    public function create($businessId)
    {
        $business = Business::findOrFail($businessId);
        return view('admin.bussiness.createplatform', compact('business'));
    }

    /**
     * Store new platform.
     */
    public function store(Request $request, $businessId)
    {
        $business = Business::findOrFail($businessId);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'credentials' => 'nullable', // credentials JSON
        ]);

        $validated['business_id'] = $business->id;
        $validated['connected_on'] = Carbon::now();
        $validated['status'] = 'disconnected';

        $platform = Platform::create($validated);

       

        return redirect()
            ->route('platform.index', $business->id)
            ->with('success', 'Platform Added  successfully. Please proceed to connect it.');
    }

    /**
     * Show a single platform.
     */
    public function show($businessId, $platformId)
    {
        $business = Business::findOrFail($businessId);
        $platform = $business->platforms()->findOrFail($platformId);

        return view('admin.bussiness.showplatform', compact('business', 'platform'));
    }

    /**
     * Show edit form for a platform.
     */
    public function edit($businessId, $platformId)
    {
        $business = Business::findOrFail($businessId);
        $platform = $business->platforms()->findOrFail($platformId);

        return view('admin.bussiness.editplatform', compact('business', 'platform'));
    }

    /**
     * Update platform details.
     */
    public function update(Request $request, $businessId, $platformId)
    {
        $business = Business::findOrFail($businessId);
        $platform = $business->platforms()->findOrFail($platformId);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'credentials' => 'nullable|array',
            'status' => 'nullable|string',
        ]);

        $platform->update($validated);

        return redirect()
            ->route('platform.index', $business->id)
            ->with('success', 'Platform updated successfully.');
    }
    public function showProfiles($businessId, $platformId)
{
    $platform = Platform::where('business_id', $businessId)->findOrFail($platformId);

    // Assuming JSON stored like: { "profiles": [ { "account": {...}, "locations": [...] } ] }
    $profiles = json_decode($platform->extra_data, true);

    return view('admin.platform.profiles', compact('platform', 'profiles'));
}


    /**
     * Disconnect (soft update).
     */
    public function destroy($businessId, $platformId)
    {
        $business = Business::findOrFail($businessId);
        $platform = $business->platforms()->findOrFail($platformId);

        $platform->update(['status' => 'disconnected']);

        return redirect()
            ->route('platform.index', $business->id)
            ->with('success', 'Platform disconnected successfully.');
    }



public function connectGoogle($businessId)
{
    // save businessId in session temporarily
    session(['google_connect_business_id' => $businessId]);

    $google = new \App\Services\GoogleAuthService();
    return redirect($google->getAuthUrl());
}


public function googleCallback(Request $request)
{
    $businessId = session('google_connect_business_id');
    session()->forget('google_connect_business_id');

    if (!$businessId) {
        return redirect()->route('business.index')->withErrors('Business session expired, please try again.');
    }

    $google = new \App\Services\GoogleAuthService();
    $token = $google->handleCallback($request->code);

    // ✅ Create or update platform after getting token
    $business = \App\Models\Business::findOrFail($businessId);
    $platform = $business->platforms()->updateOrCreate(
        ['name' => 'Google'],
        [
            'credentials' => $token,
            'status' => 'connected',
            'connected_on' => now(),
        ]
    );

    // ✅ Fetch GMB profiles right after
    $googleBusiness = new \App\Services\GoogleBusinessService($token);
    $profiles = $googleBusiness->getAllProfiles();
    Log::info('Fetched GMB profiles: ', ['profiles' => $profiles]);

    $platform->update(['extra_data' => json_encode(['profiles' => $profiles])]);

    return redirect()
        ->route('platform.index', $businessId)
        ->with('success', 'Google connected successfully! Profiles fetched.');
}




}
