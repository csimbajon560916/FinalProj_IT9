<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use Illuminate\Http\Request;

class TournamentController extends Controller {
    public function index() {
        $tournaments = Tournament::all();
        return view('admin.tournaments.index', compact('tournaments'));
    }

    public function create()
{
    return view('admin.tournaments.create');
}

    public function store(Request $request)
{
    // 1. Validate the input so you don't get broken data
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'start_date' => 'required|date',
        'location' => 'nullable|string|max:255',
    ]);

    // 2. Save it to the database
    \App\Models\Tournament::create($validated);

    // 3. Go back to the table with a success message
    return redirect()->route('admin.tournaments.index')
                     ->with('success', 'Tournament created successfully!');
}
    
public function edit(Tournament $tournament)
{
    return view('admin.tournaments.edit', compact('tournament'));
}

public function update(Request $request, Tournament $tournament)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'start_date' => 'required|date',
        'status' => 'required|in:Active,Inactive,Completed',
    ]);

    $tournament->update($request->all());

    return redirect()->route('admin.tournaments.index')
                     ->with('success', 'Tournament updated successfully.');
}

public function destroy(Tournament $tournament)
{
    // This removes the tournament from the database
    $tournament->delete();

    return redirect()->route('admin.tournaments.index')
                     ->with('success', 'Tournament removed successfully.');
}

public function brackets(Tournament $tournament)
{
    // Load games with teams and venues
    $tournament->load(['games.team1', 'games.team2', 'games.venue']);
    
    return view('admin.tournaments.brackets', compact('tournament'));
}
}
