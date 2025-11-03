<?php



namespace App\Http\Controllers;

use App\Models\Platform;
use App\Models\Business;
use App\Services\GoogleAuthService;
use Illuminate\Http\Request;
use Carbon\Carbon;

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




public function connectGoogle($businessId, $platformId)
{
    $google = new GoogleAuthService($businessId, $platformId);
    $authUrl = $google->getAuthUrl();
    return redirect($authUrl);
}

public function googleCallback(Request $request, $businessId, $platformId)
{
    $google = new GoogleAuthService($businessId, $platformId);
    $token = $google->handleCallback($request->code);

    $business = Business::findOrFail($businessId);
    $platform = $business->platforms()->findOrFail($platformId);

    // ✅ Update credentials instead of creating new
    $platform->update([
        'credentials' => $token,
        'status' => 'connected',
        'connected_on' => now(),
    ]);

    return redirect()
        ->route('platform.index', $businessId)
        ->with('success', $platform->name . ' reconnected successfully!');
}



}
