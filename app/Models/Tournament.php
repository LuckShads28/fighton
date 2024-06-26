<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    /**
     * Status
     * 0 = menunggu konfirmasi
     * 1 = dikonfirmasi
     * 2 = ditolak
     */
    use HasFactory;

    protected $fillable = ['id_organizer', 'name', 'slug', 'about', 'rules', 'prizepool', 'team_category', 'team_slot', 'start_date', 'start_time', 'tournament_type', 'banner_pic', 'status'];

    public function organizer()
    {
        return $this->belongsTo(Organizer::class, 'id_organizer');
    }

    public function teams()
    {
        return $this->hasMany(TournamentTeam::class, 'tournament_id');
    }
}
