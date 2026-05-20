<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Game extends Model
{
    protected $fillable = [
        'tournament_id',
        'venue_id',
        'team1_id',
        'team2_id',
        'team1_score',
        'team2_score',
        'match_datetime',
        'status',
        'round_name',
        'round_number',
        'next_game_id'
];
/**
     * Relationship for Team 1
     */
    // app/Models/Game.php

public function team1(): BelongsTo
{
    return $this->belongsTo(Team::class, 'team1_id');
}

public function team2(): BelongsTo
{
    return $this->belongsTo(Team::class, 'team2_id');
}
    /**
     * Relationship for the Tournament
     */
    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class);
    }

    /**
     * Relationship for the Venue
     */
    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }
}
