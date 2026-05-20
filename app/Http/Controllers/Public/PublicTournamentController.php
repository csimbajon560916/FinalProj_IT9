<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use App\Models\Team;
use App\Models\Game;
use Illuminate\Http\Request;

class PublicTournamentController extends Controller
{
    // 1. Shows a landing page listing all available tournaments/leagues
    public function index()
    {
        $tournaments = Tournament::all();
        return view('public.tournaments.index', compact('tournaments'));
    }

    // 2. Shows the read-only dashboard for a specific selected tournament
    public function show($id)
    {
        $tournament = Tournament::findOrFail($id);

        // Fetch games grouped by round for the read-only bracket layout
        $bracketRounds = Game::where('tournament_id', $id)
            ->with(['team1', 'team2']) // Use your model relation names
            ->orderBy('round_number', 'asc')
            ->get()
            ->groupBy('round_number');

        // Fetch teams grouped by tournament for the read-only team list
        $teams = Team::where('tournament_id', $id)->with('players')->get();

        // Fetch all game schedules for the read-only list
        $schedules = Game::where('tournament_id', $id)
            ->with(['team1', 'team2', 'venue'])
            ->orderBy('match_datetime', 'asc')
            ->get();

        return view('public.tournaments.show', compact('tournament', 'bracketRounds', 'teams', 'schedules'));
    }
}
