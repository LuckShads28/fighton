<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TournamentTeam extends Model
{
    use HasFactory;

    protected $fillable = ['team_id', 'tournament_id', 'rank', 'status'];

    public function tournament()
    {
        return $this->hasMany(Tournament::class, 'id', 'tournament_id');
    }

    public function team()
    {
        return $this->hasMany(Team::class, 'id', 'team_id');
    }
}
