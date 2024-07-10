<?php

namespace App\Http\Controllers;

use App\Models\HistoryTournamentsUser;
use App\Models\User;
use App\Models\UsersOrganizers;
use App\Models\UsersTeams;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::user()) {
            return redirect()->to('/')->withErrors('Login terlebih dahulu untuk melihat profile');
        }
        $userId = Auth::user()->id;
        $teamList = UsersTeams::with('team')->where('user_id', $userId)->where('status', 1)->get();
        $tournamentData = HistoryTournamentsUser::with('tournament')->where('id_user', Auth::user()->id)->get();;
        return view('profile', [
            'title' => 'Profile',
            'teamList' => $teamList,
            'tournamentData' => $tournamentData,
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
    public function show(string $slug)
    {
        return 'show';
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        $user = User::where('slug', $slug)->first();
        if (Auth::user()->slug == $slug) {
            return view('profile.profile-setting', [
                'title' => 'Pengaturan Akun',
                'data' => $user
            ]);
        }

        abort(403);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $oldData = User::findOrFail($id);
        $validatedData = $request->validate([
            'nickname' => 'required|min:3|max:20',
            'role' => 'required',
            'profile_pic' => 'image|file',
            'bg_pic' => 'image|file'
        ]);

        if ($request->profile_pic != null) {
            if ($oldData->profile_pic) {
                Storage::delete($oldData->profile_pic);
            }
            $validatedData['profile_pic'] = $request->file('profile_pic')->store('user-profile');
        }
        if ($request->bg_pic != null) {
            if ($oldData->bg_pic) {
                Storage::delete($oldData->bg_pic);
            }
            $validatedData['bg_pic'] = $request->file('bg_pic')->store('user-profile');
        }

        User::where('id', $id)->update($validatedData);

        return redirect()->route('profile.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function dashboard(string $slug)
    {
        $history = HistoryTournamentsUser::where('id_user', Auth::user()->id);
        $joinedTournament = $history->count();
        $tournamentWin = $history->where('rank', 1)->orWhere('rank', 2)->orWhere('rank', 3)->count();
        $team = UsersTeams::where('user_id', Auth::user()->id)->where('status', 1)->count();
        $organizer = UsersOrganizers::where('user_id', Auth::user()->id)->count();
        return view('user.dashboard', [
            'title' => 'Dashboard ' . Auth::user()->nickname,
            'turnamenDiikuti' => $joinedTournament,
            'turnamenDimenangkan' => $tournamentWin,
            'tim' => $team,
            'organizer' => $organizer
        ]);
    }
}
