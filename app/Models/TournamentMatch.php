<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TournamentMatch extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    public $timestamps = false;

    public function team1()
    {
        return $this->belongsTo(Team::class, 'team1_id', 'id');
    }

    public function team2()
    {
        return $this->belongsTo(Team::class, 'team2_id', 'id');
    }

    public function tournament()
    {
        return $this->belongTo(Tournament::class, 'tournament_id', 'id');
    }
}
