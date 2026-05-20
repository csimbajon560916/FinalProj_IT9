<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function index()
{
    // 1. Fetch players with relations, including 'tournament' if needed
    // 2. Group them by their team name instantly using a fallback for unassigned players
    $groupedPlayers = \App\Models\Player::with(['team.tournament'])->get()
        ->groupBy(function($player) {
            return $player->team?->name ?? 'Unassigned Teams';
        });

    // 3. Pass the grouped collection straight to your view
    return view('admin.players.index', compact('groupedPlayers'));
}

    public function create()
{
    // Fetch teams and their tournaments for the dropdown list
    $teams = \App\Models\Team::with('tournament')->get();
    return view('admin.players.create', compact('teams'));
}

    public function store(Request $request)
{
    // 1. Validate the data
    $validated = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'team_id' => 'required|exists:teams,id',
        'jersey_number' => 'nullable|integer',
    ]);

    // 2. Save to the database
    \App\Models\Player::create($validated);

    // 3. Redirect back to the Index with a success message
    return redirect()->route('admin.players.index')
                     ->with('success', 'Player registered successfully!');
}

public function edit(Player $player)
{
    $teams = \App\Models\Team::all();
    $tournaments = \App\Models\Tournament::all();

    return view('admin.players.edit', compact('player', 'teams', 'tournaments'));
}

public function update(Request $request, Player $player)
{
    // 1. Validate the new individual name fields
    $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'team_id' => 'required|exists:teams,id',
    ]);

    // 2. Update the player using the specific column names from your DB
    $player->update([
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'team_id' => $request->team_id,
        // If your database uses tournament_id directly on players, include it here
    ]);

    return redirect()->route('admin.players.index')
                     ->with('success', 'Player updated successfully.');
}

public function destroy(Player $player)
{
    $player->delete();

    return redirect()->route('admin.players.index')
                     ->with('success', 'Player removed from roster.');
}
}
