<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = ['tournament_id', 'name', 'coach_name', 'logo_path'];

    public function tournament() {
        return $this->belongsTo(Tournament::class);
    }

    public function players() {
        return $this->hasMany(Player::class);
    }

    // This helps calculate standings automatically
    public function standings() {
        return $this->hasOne(Standing::class);
    }
}
