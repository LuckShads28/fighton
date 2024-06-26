<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\TournamentTeam;
use App\Models\User;
use App\Models\UsersTeams;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TeamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = UsersTeams::with(['user', 'team'])->where('role', 'Leader');

        if (request('search')) {
            $searchTeamId = Team::where('name', 'like', '%' . request('search') . '%')->pluck('id')->toArray();
            $data = $data->whereIn('team_id', $searchTeamId);
        }
        if (request('filter')) {
            if (request('filter') == 'flex') {
                $searchTeamId = Team::where('player_5', null)
                    ->orWhere('sub_1', null)
                    ->orWhere('sub_2', null)
                    ->pluck('id')->toArray();
            } else {
                $searchTeamId = Team::where(request('filter'), null)->pluck('id')->toArray();
            }
            $data = $data->whereIn('team_id', $searchTeamId);
        }
        return view('teams.team-list', [
            'title' => "List Team",
            'data' => $data->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('teams.create-team', ['title' => 'Buat Tim']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $leaderRole = Auth::user()->role;
        $leaderId = Auth::user()->id;

        $slug = Str::slug($request->name);

        $validatedData = $request->validate([
            'name' => 'required|min:6|max:20|unique:teams',
            'description' => 'required|min:6|max:200',
            'logo_img' => 'required|image|file|max:1000',
            // 'banner_img' => 'required|mimes:jpg,jpeg,png|max:5096'
            'banner_img' => 'required|image|file|max:5096'
        ]);
        $validatedData['slug'] = $slug;
        $validatedData['logo_img'] = $request->file('logo_img')->store('team-logo');
        $validatedData['banner_img'] = $request->file('banner_img')->store('team-bg');
        $validatedData[Str::lower($leaderRole)] = $leaderId;

        $team = Team::create($validatedData);
        UsersTeams::create([
            'user_id' => $leaderId,
            'team_id' => $team->id,
            'status' => 1,
            'role' => 'Leader'
        ]);

        return redirect()->route('profile.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $team = Team::where('slug', $slug)->first();
        if ($team) {
            $data = UsersTeams::with(['user', 'team'])->where('team_id', $team->id)->get();
            $tournamentData = TournamentTeam::with(['tournament'])->where('team_id', $team->id)->get();
            $teamData = $data->first()->team->first();

            $userRole = null;
            $userStatus = null;

            if (Auth::user()) {
                if (Auth::user()->role) {
                    $userId = Auth::user()->id;
                    if ($data->where('user_id', $userId)->first()) {
                        $userRole = $data->where('user_id', $userId)->first()->role;
                    }
                }

                if ($userRole) {
                    $userStatus = UsersTeams::where('user_id', Auth::user()->id)
                        ->where('team_id', $team->id)->first();
                    if ($userStatus) {
                        $userStatus = $userStatus->status;
                    }
                }
            }

            return view('teams.detail', [
                'title' => $teamData->name,
                'teamData' => $teamData,
                'tournamentData' => $tournamentData,
                'data' => $data,
                'userRole' => $userRole,
                'userStatus' => $userStatus,
            ]);
        }
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        $data = Team::where('slug', $slug)->first();
        $teamId = $data->id;
        $userId = Auth::user()->id;
        $userRole = UsersTeams::where('user_id', $userId)->where('team_id', $teamId)->first();
        // dd($userRole);
        // if ($userRole === null) {
        //     return redirect()->route('profile.index');
        // } else if ($userRole->role === 'Leader') {
        // }

        if ($userRole != null && $userRole->role === 'Leader') {
            return view('teams.edit', [
                'title' => 'Edit ' . $data->name,
                'slug' => $slug,
                'data' => $data
            ]);
        }

        return redirect()->route('profile.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $slug = Str::slug($request->name);
        $oldData = Team::find($id);

        $validatedData = $request->validate([
            'name' => 'required|min:6|max:20|unique:teams,name,' . $id,
            'description' => 'required|min:6|max:200',
            'logo_img' => 'image|file|max:1000',
            'banner_img' => 'mimes:jpg,jpeg,png|max:5096'
        ]);
        $validatedData['slug'] = $slug;

        if ($request->logo_img != null) {
            Storage::delete($oldData->logo_img);
            $validatedData['logo_img'] = $request->file('logo_img')->store('team-logo');
        }
        if ($request->banner_img != null) {
            Storage::delete($oldData->banner_img);
            $validatedData['banner_img'] = $request->file('banner_img')->store('team-bg');
        }

        // dd($validatedData);

        Team::where('id', $id)
            ->update($validatedData);

        $newData = Team::find($id);

        $slug = $newData->slug;

        return redirect()->route('team.show', $slug);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $team = Team::findOrFail($id);

        Storage::delete($team->logo_img);
        Storage::delete($team->banner_img);

        $team->delete();

        return redirect()->route('profile.index');
    }

    public function anggota(string $slug)
    {
        $data = Team::where('slug', $slug)->first();
        $teamMember = UsersTeams::with(['user'])->where('team_id', $data->id)->get();
        // dd($teamMember);
        return view('teams.edit-anggota', [
            'title' => 'Anggota ' . $data->name,
            'slug' => $slug,
            'data' => $data,
            'teamMember' => $teamMember
        ]);
    }

    public function cadangan(string $slug)
    {
        $data = Team::where('slug', $slug)->first();
        $teamMember = UsersTeams::with('user')->where('team_id', $data->id)->get();
        return view('teams.edit-cadangan', [
            'title' => 'Edit Cadangan',
            'slug' => $slug,
            'data' => $data,
            'teamMember' => $teamMember
        ]);
    }

    public function request(string $teamSlug, string $userSlug)
    {
        if (Auth::user()->slug === $userSlug) {
            $teamData = Team::where('slug', $teamSlug)->first();
            $oldData = UsersTeams::where('user_id', Auth::user()->id)
                ->where('team_id', $teamData->id);
            // dd($oldData);
            if ($oldData->first()) {
                $oldData->update([
                    'status' => 0,
                ]);
            } else {
                UsersTeams::create([
                    'user_id' => Auth::user()->id,
                    'team_id' => $teamData->id,
                    'status' => 0,
                    'role' => 'Anggota'
                ]);
            }

            return redirect()->route('team.show', $teamSlug);
        }
        abort(403);
    }

    public function requestResponse(Request $request)
    {
        $team = Team::where('id', $request->teamId)->first();
        $user = User::where('id', $request->userId)->first();
        // dd($user->nickname);
        // dd($user->nickname);
        $userTeam = UsersTeams::where('user_id', $request->userId)->where('team_id', $request->teamId);
        if ($userTeam->count() < 7) {
            if ($request->status == 1) {
                if ($user->role == 'Sentinel' && $team->sentinel === null) {
                    $team->update([
                        'sentinel' => $user->id
                    ]);
                } else if ($user->role === 'Initiator' && $team->initiator === null) {
                    $team->update([
                        'initiator' => $user->id
                    ]);
                } else if ($user->role == 'Controller' && $team->controller === null) {
                    $team->update([
                        'controller' => $user->id
                    ]);
                } else if ($user->role == 'Duelist' && $team->duelist === null) {
                    $team->update([
                        'duelist' => $user->id
                    ]);
                } else if ($team->player_5 === null) {
                    $team->update([
                        'player_5' => $user->id
                    ]);
                } else if ($team->sub_1 === null) {
                    $team->update([
                        'sub_1' => $user->id
                    ]);
                } else if ($team->sub_2 === null) {
                    $team->update([
                        'sub_2' => $user->id
                    ]);
                }
            }
            if ($request->status == 3) {
                // dd($request->userId == $team->initiator);
                if ($request->userId == $team->initiator) {
                    $team->update([
                        'initiator' => null
                    ]);
                } else if ($request->userId == $team->sentinel) {
                    $team->update([
                        'sentinel' => null
                    ]);
                } else if ($request->userId == $team->controller) {
                    $team->update([
                        'controller' => null
                    ]);
                } else if ($request->userId == $team->duelist) {
                    $team->update([
                        'duelist' => null
                    ]);
                } else if ($request->userId == $team->player_5) {
                    $team->update([
                        'player_5' => null
                    ]);
                } else if ($request->userId == $team->sub_1) {
                    $team->update([
                        'sub_1' => null
                    ]);
                } else if ($request->userId == $team->sub_2) {
                    $team->update([
                        'sub_2' => null
                    ]);
                }
                // dd($team->initiator === $request->userId);
                // if ($team->intiator === $request->userId) {
                //     dd('HAPUS');
                // }
            }
        }
        // $userTeam->update(['status' => $request->status]);
        UsersTeams::where('user_id', $request->userId)
            ->where('team_id', $request->teamId)
            ->update(['status' => $request->status]);

        return redirect()->route('edit_anggota', $team->slug);
    }
}
