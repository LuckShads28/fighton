<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public $timestamps = false;

    public function users()
    {
        return $this->hasMany(UsersTeams::class, 'team_id');
    }

    public function tournaments()
    {
        return $this->hasMany(TournamentTeam::class, 'team_id');
    }
}
