<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BusinessController extends Controller
{
    // list all businesses for logged-in user
    public function index()
    {
        $businesses = Business::where('user_id', Auth::id())->latest()->get();

        if (request()->wantsJson()) {
            return response()->json($businesses);
        }

        return view('admin.bussiness.index', compact('businesses'));
    }

    // show create form
    public function create()
    {
        return view('admin.bussiness.create');
    }

    // store business
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'industry' => 'nullable|string|max:255',
        ]);

        $validated['user_id'] = Auth::id();

        $business = Business::create($validated);

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Business created', 'business' => $business], 201);
        }

        return redirect()->route('bussiness.index')->with('success', 'Business created successfully.');
    }

    // show details
    public function show(Business $bussiness)
    {
        if (request()->wantsJson()) {
            return response()->json($bussiness);
        }

        return view('admin.bussiness.show', compact('bussiness'));
    }
    public function edit($id)
    {
        $business = Business::findOrFail($id);
        return view('admin.bussiness.edit', compact('business'));
    }


  public function update(Request $request, $id)
{
    $business = \App\Models\Business::findOrFail($id);

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'industry' => 'nullable|string|max:255',
    ]);

    $business->update($validated);

    if ($request->wantsJson()) {
        return response()->json([
            'message' => 'Business updated successfully',
            'business' => $business
        ]);
    }

    return redirect()
        ->route('bussiness.index')
        ->with('success', 'Business updated successfully.');
}


  public function destroy(Request $request, $id)
{
    try {
        // Fetch business
        $business = \App\Models\Business::findOrFail($id);

        // Optional but recommended: ensure current user owns it
        if ($business->user_id !== \Illuminate\Support\Facades\Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Delete business (and cascade if you’ve set up relations)
        $business->delete();

        // Handle API or web response
        if ($request->wantsJson()) {
            return response()->json(['message' => 'Business deleted successfully.']);
        }

        return redirect()
            ->route('bussiness.index')
            ->with('success', 'Business deleted successfully.');

    } catch (\Throwable $e) {
        // Handle errors gracefully
        if ($request->wantsJson()) {
            return response()->json(['error' => 'Failed to delete business', 'message' => $e->getMessage()], 500);
        }

        return back()->with('error', 'Failed to delete business: ' . $e->getMessage());
    }
}

}
