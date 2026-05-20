<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use App\Models\Team;
use App\Models\Venue;
use App\Models\Game;
use App\Models\Standing;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
{
    // Fetch all games with their relationships and group them by tournament name
    $groupedGames = \App\Models\Game::with(['tournament', 'team1', 'team2', 'venue'])
        ->orderBy('match_datetime', 'asc')
        ->get()
        ->groupBy(function($game) {
            return $game->tournament->name; // Groups by the tournament name
        });

    return view('admin.games.index', compact('groupedGames'));
}

public function store(Request $request)
{
    $validated = $request->validate([
        'tournament_id' => 'required|exists:tournaments,id',
        'venue_id'      => 'required|exists:venues,id',
        'team1_id'      => 'nullable|exists:teams,id',
        'team2_id'      => 'nullable|exists:teams,id|different:team1_id',
        'match_datetime'=> 'required|date',
        'round_name' => 'nullable|string|max:255',
        'round_number' => 'required|integer|min:1',
    ]);

    // Add the default status from your DB structure
    $validated['status'] = 'scheduled';

    \App\Models\Game::create($validated);

    return redirect()->route('admin.games.index')
                     ->with('success', 'Game scheduled successfully!');
}

    public function create()
{
    $tournaments = Tournament::all();
    $teams = Team::all();
    $venues = Venue::all();
    return view('admin.games.create', compact('tournaments', 'teams', 'venues'));
}
    public function edit($id)
{
    // Find the game
    $game = \App\Models\Game::findOrFail($id);

    // Get the tournament this game belongs to, including all its other games
    // This provides the data for your "Winner Advances To" dropdown
    $tournament = \App\Models\Tournament::with('games')->findOrFail($game->tournament_id);

    // You might also need the list of all teams if you want to change them manually
    $teams = \App\Models\Team::all();

    return view('admin.games.edit', compact('game', 'tournament', 'teams'));
}

public function update(Request $request, $id)
{
    $game = \App\Models\Game::findOrFail($id);

    $validated = $request->validate([
        'team1_score' => 'required|integer|min:0',
        'team2_score' => 'required|integer|min:0',
        'status'      => 'required|in:scheduled,ongoing,completed,cancelled',
        'round_name'   => 'nullable|string|max:255',
        'next_game_id' => 'nullable|exists:games,id',
        // Optional: validate venue and date here if you want to update them at the same time
    ]);

    $game->update($validated);

    if ($game->status === 'completed') {
        // 1. Trigger the standings update as you already had it
        app(\App\Http\Controllers\Admin\StandingController::class)->updateStandings($game->tournament_id);

        // 2. Winner Advancement Logic
        if ($game->next_game_id) {
            // Determine the winner
            $winnerId = ($game->team1_score > $game->team2_score)
                        ? $game->team1_id
                        : $game->team2_id;

            $nextGame = \App\Models\Game::find($game->next_game_id);

            if ($nextGame) {
                // Fill the first empty team slot in the next round
                if (is_null($nextGame->team1_id)) {
                    $nextGame->update(['team1_id' => $winnerId]);
                } else if (is_null($nextGame->team2_id)) {
                    $nextGame->update(['team2_id' => $winnerId]);
                }
            }
        }
    }

    return redirect()->route('admin.games.index')->with('success', 'Game updated and winner advanced!');
}

public function destroy($id)
{
    $game = \App\Models\Game::findOrFail($id);
    $game->delete();

    return back()->with('success', 'Game removed from schedule.');
}

    private function syncStandings($tournamentId, $teamId)
    {
        // Get all completed games for this team in this tournament
        $games = Game::where('tournament_id', $tournamentId)
            ->where('status', 'completed')
            ->where(function ($query) use ($teamId) {
                $query->where('team1_id', $teamId)
                      ->orWhere('team2_id', $teamId);
            })->get();

        $played = $games->count();
        $won = 0; $lost = 0; $draws = 0; $points = 0;

        foreach ($games as $game) {
            $isTeam1 = ($game->team1_id == $teamId);
            $myScore = $isTeam1 ? $game->team1_score : $game->team2_score;
            $opponentScore = $isTeam1 ? $game->team2_score : $game->team1_score;

            if ($myScore > $opponentScore) {
                $won++;
                $points += 3; // Win = 3pts
            } elseif ($myScore < $opponentScore) {
                $lost++;
            } else {
                $draws++;
                $points += 1; // Draw = 1pt
            }
        }

        // Update or Create the standing record
        Standing::updateOrCreate(
            ['tournament_id' => $tournamentId, 'team_id' => $teamId],
            [
                'played' => $played,
                'won' => $won,
                'lost' => $lost,
                'draws' => $draws,
                'points' => $points,
            ]
        );
    }
    public function getTeams($tournamentId)
{
    // Fetch only teams linked to the chosen tournament
    $teams = \App\Models\Team::where('tournament_id', $tournamentId)->get();
    return response()->json($teams);
}
// Inside app/Models/Game.php

}
