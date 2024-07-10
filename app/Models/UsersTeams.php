<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersTeams extends Model
{
    use HasFactory;

    /**
     * Status:
     * 0 = Menunggu Persetujuan
     * 1 = Disetujui
     * 2 = Ditolak
     * 3 = Dikeluarkan
     * 4 = Team Disband
     */
    public $timestamps = false;

    protected $fillable = ['user_id', 'team_id', 'status', 'role'];

    public function team()
    {
        return $this->hasMany(Team::class, 'id', 'team_id');
    }

    public function user()
    {
        return $this->hasMany(User::class, 'id', 'user_id');
    }
}