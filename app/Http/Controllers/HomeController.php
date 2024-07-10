<?php

namespace App\Http\Controllers;

use App\Models\HistoryTournamentsUser;
use App\Models\Tournament;
use App\Models\TournamentTeam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Termwind\Components\Raw;

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

    public function leaderboard()
    {
        $team = TournamentTeam::with('team')->select('team_id')->groupBy('team_id')->orderByDesc('rank')->get();
        $player = HistoryTournamentsUser::with('user')->where('rank', 1);
        $top3player = $player->select('id_user', DB::raw('count(*) totalMenang'))->groupBy('id_user')->take(3)->get();
        $top5player = $player->select('id_user', DB::raw('count(*) totalMenang'))->groupBy('id_user')->take(5)->get();

        return view('leaderboard', [
            'title' => 'Leaderboard',
            'team' => $team,
            'top3Player' => $top3player,
            'top5Player' => $top5player
        ]);
    }
}
