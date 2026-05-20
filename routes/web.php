<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\TournamentController as AdminTournament;
use App\Http\Controllers\Admin\TeamController as AdminTeam;
use App\Http\Controllers\Admin\GameController as AdminGame;
use App\Http\Controllers\Admin\PlayerController;
use App\Http\Controllers\Admin\VenueController ;
use App\Http\Controllers\Admin\StandingController;
use App\Http\Controllers\Public\PublicTournamentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


// Public Guest Routes (No Login Required)
Route::get('/tournaments', [PublicTournamentController::class, 'index'])->name('public.tournaments.index');
Route::get('/tournaments/{id}', [PublicTournamentController::class, 'show'])->name('public.tournaments.show');

// ADMIN ROUTES (Breeze Auth)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/get-teams/{tournamentId}', [App\Http\Controllers\Admin\GameController::class, 'getTeams']);
    Route::get('tournaments/{tournament}/brackets', [AdminTournament::class, 'brackets'])->name('tournaments.brackets');
    Route::resource('tournaments', AdminTournament::class);
    Route::resource('teams', AdminTeam::class);
    Route::resource('games', AdminGame::class);
    Route::resource('players', PlayerController::class);
    Route::resource('venues', VenueController::class);
    Route::resource('standings', StandingController::class)->only(['index', 'update']);
});




Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
