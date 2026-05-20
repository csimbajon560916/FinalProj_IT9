<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch Active/Upcoming tournaments with their teams and players
        $tournaments = Tournament::with(['teams.players'])
            ->whereIn('status', ['Active', 'Upcoming'])
            ->get();

        return view('dashboard', compact('tournaments'));
    }
}