<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    protected $fillable = ['name', 'start_date', 'location'];

    public function teams() {
        return $this->hasMany(Team::class);
    }

    public function games() {
        return $this->hasMany(Game::class);
    }

    public function standings() {
        return $this->hasMany(Standing::class);
    }
}