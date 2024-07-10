<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchDetail extends Model
{
    use HasFactory;

    // protected $guarded = 'id';
    protected $fillable = ['match_id', 'team_id', 'user_id', 'kill', 'death', 'assist', 'acs'];

    public function player()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
