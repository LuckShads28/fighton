<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryTournamentsUser extends Model
{
    use HasFactory;

    protected $fillable = ['id_user', 'id_tournament', 'rank', 'mvp'];

    public function tournament()
    {
        return $this->hasMany(Tournament::class, 'id', 'id_tournament');
    }

    public function user()
    {
        return $this->hasMany(User::class, 'id', 'id_user');
    }
}
