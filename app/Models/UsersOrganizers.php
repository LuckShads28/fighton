<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersOrganizers extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'organizer_id', 'role'];
    public $timestamps = false;

    public function organizer()
    {
        return $this->hasMany(Organizer::class, 'id', 'organizer_id');
    }

    public function user()
    {
        return $this->hasMany(User::class, 'id', 'user_id');
    }
}
