<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Standing extends Model
{
    protected $fillable = ['tournament_id', 'team_id', 'played', 'won', 'lost', 'draws', 'points'];

    public function team() {
        return $this->belongsTo(Team::class);
    }

    public function tournament()
{
    return $this->belongsTo(Tournament::class);
}
}
