<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Venue;
use Illuminate\Http\Request;

class VenueController extends Controller
{
    public function index() {
        $venues = Venue::all();
        return view('admin.venues.index', compact('venues'));
    }

    public function create()
    {
        return view('admin.venues.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
        ]);

        Venue::create($validated);

        return redirect()->route('admin.venues.index')
                         ->with('success', 'Venue added successfully!');
    }

    public function destroy(Venue $venue) {
        $venue->delete();
        return back()->with('success', 'Venue removed.');
    }

    public function edit(Venue $venue)
{
    return view('admin.venues.edit', compact('venue'));
}

public function update(Request $request, Venue $venue)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'address' => 'required|string|max:255',
    ]);

    $venue->update($request->all());

    return redirect()->route('admin.venues.index')
                     ->with('success', 'Venue updated successfully.');
}
}