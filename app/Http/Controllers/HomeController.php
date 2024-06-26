<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $tournaments = Tournament::with(['organizer'])->latest()->take(3)->get();
        // dd(Auth::user());
        return view('home', [
            'tournaments' => $tournaments,
            'title' => 'Home'
        ]);
    }
}
