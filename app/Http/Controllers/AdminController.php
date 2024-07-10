<?php

namespace App\Http\Controllers;

use App\Models\Organizer;
use App\Models\Team;
use App\Models\Tournament;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role != 'admin') {
            abort(403);
        }

        $activeTournament = Tournament::where('status', 'belum_selesai')->get();
        $organizer = Organizer::all();
        $team = Team::all();
        $user = User::where('role', '!=', 'admin')->get();
        return view('admin.index', [
            'title' => 'Admin Dashboard',
            'activeTournament' => $activeTournament,
            'organizer' => $organizer,
            'team' => $team,
            'user' => $user
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Ambil data user
     */
    public function getUser()
    {
        $controller = User::where('role', 'controller')->count();
        $sentinel = User::where('role', 'sentinel')->count();
        $initiator = User::where('role', 'initiator')->count();
        $duelist = User::where('role', 'duelist')->count();
        $noRole = User::where('role', null)->count();

        $data = [
            'controller' => $controller,
            'initiator' => $initiator,
            'sentinel' => $sentinel,
            'duelist' => $duelist,
            'noRole' => $noRole
        ];

        // dd($data);

        return response()->json($data);
    }
}
