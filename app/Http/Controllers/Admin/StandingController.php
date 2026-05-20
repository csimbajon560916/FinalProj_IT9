<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Standing;
use App\Models\Tournament;
use Illuminate\Http\Request;

class StandingController extends Controller
{
    public function index()
{
    // Fetch all standings and eager load team/tournament names
    $standings = \App\Models\Standing::with(['team', 'tournament'])->get();

    // Pass the variable as 'standings'
    return view('admin.standings.index', compact('standings'));
}

    public function update(Request $request, Standing $standing) {
        $data = $request->validate([
            'played' => 'required|integer',
            'won' => 'required|integer',
            'lost' => 'required|integer',
            'draws' => 'required|integer',
            'points' => 'required|integer',
        ]);
        
        $standing->update($data);
        return back()->with('success', 'Standings updated manually.');
    }
    public function updateStandings($tournamentId)
{
    // 1. Reset all standings for this tournament to 0 first to avoid double-counting
    \App\Models\Standing::where('tournament_id', $tournamentId)->update([
        'played' => 0, 'won' => 0, 'draws' => 0, 'lost' => 0, 'points' => 0
    ]);

    // 2. Get all completed games for this tournament
    $completedGames = \App\Models\Game::where('tournament_id', $tournamentId)
                                      ->where('status', 'completed')
                                      ->get();

    foreach ($completedGames as $game) {
        $this->assignPoints($game);
    }
}

private function assignPoints($game)
{
    $standing1 = \App\Models\Standing::where('team_id', $game->team1_id)->first();
    $standing2 = \App\Models\Standing::where('team_id', $game->team2_id)->first();

    $standing1->increment('played');
    $standing2->increment('played');

    if ($game->team1_score > $game->team2_score) {
        $standing1->increment('won'); $standing1->increment('points', 3);
        $standing2->increment('lost');
    } elseif ($game->team1_score < $game->team2_score) {
        $standing2->increment('won'); $standing2->increment('points', 3);
        $standing1->increment('lost');
    } else {
        $standing1->increment('draws'); $standing1->increment('points', 1);
        $standing2->increment('draws'); $standing2->increment('points', 1);
    }
}
}