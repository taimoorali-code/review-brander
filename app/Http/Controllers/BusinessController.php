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
}
