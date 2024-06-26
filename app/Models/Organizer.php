<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organizer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'logo_img', 'banner_img', 'contact'];
    public $timestamps = false;

    public function tournaments()
    {
        return $this->hasMany(Tournament::class, 'id_organizer');
    }

    public function users()
    {
        return $this->hasMany(UsersOrganizers::class, 'organizer_id');
    }
}
