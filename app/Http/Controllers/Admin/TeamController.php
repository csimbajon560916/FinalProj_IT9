<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\Tournament;
use Illuminate\Http\Request;

class TeamController extends Controller {
    public function index()
{
    // Eager load the tournament relationship to eliminate N+1 queries,
    // then group the teams collection by the parent tournament name
    $groupedTournaments = \App\Models\Team::with('tournament')->get()
        ->groupBy(function($team) {
            return $team->tournament?->name ?? 'Unassigned Tournaments';
        });

    return view('admin.teams.index', compact('groupedTournaments'));
}

    public function create()
{
    // We need all tournaments to show them in a dropdown list
    $tournaments = Tournament::all();
    return view('admin.teams.create', compact('tournaments'));
}

    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'tournament_id' => 'required|exists:tournaments,id',
        'coach_name' => 'nullable|string|max:255',
    ]);

    // 1. Create the Team
    $team = \App\Models\Team::create($validated);

    // 2. Automatically create the Standing record for this team
    // We set everything to 0 because they haven't played yet
    \App\Models\Standing::create([
        'tournament_id' => $team->tournament_id,
        'team_id' => $team->id,
        'played' => 0,
        'won' => 0,
        'draws' => 0,
        'lost' => 0,
        'points' => 0,
    ]);

    return redirect()->route('admin.teams.index')->with('success', 'Team and Standing initialized!');
}

public function destroy($id)
{
    // 1. Find the team
    $team = \App\Models\Team::findOrFail($id);

    // 2. Delete the team
    // Note: If you have "Foreign Key" constraints, you might need to delete
    // the team's standings or players first, or set them to 'cascade' delete.
    $team->delete();

    // 3. Redirect back with a message
    return redirect()->route('admin.teams.index')
                     ->with('success', 'Team deleted successfully!');
}

public function edit(Team $team)
{
    $tournaments = \App\Models\Tournament::all();
    return view('admin.teams.edit', compact('team', 'tournaments'));
}

public function update(Request $request, Team $team)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'tournament_id' => 'required|exists:tournaments,id',
        'coach_name' => 'nullable|string|max:255',
    ]);

    $team->update($request->all());

    return redirect()->route('admin.teams.index')
                     ->with('success', 'Team updated successfully.');
}
}
