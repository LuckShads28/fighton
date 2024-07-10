<?php

namespace App\Http\Controllers;

use App\Models\HistoryTournamentsTeam;
use App\Models\HistoryTournamentsUser;
use App\Models\Organizer;
use App\Models\Team;
use App\Models\Tournament;
use App\Models\TournamentMatch;
use App\Models\TournamentTeam;
use App\Models\UsersTeams;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TournamentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function index()
    {
        $tournaments = Tournament::with('organizer');
        if (request('search')) {
            $tournaments = $tournaments->where('name', 'like', '%' . request('search') . '%');
        }
        if (request('filter')) {
            if (request('filter') == 1) {
                $tournaments = $tournaments->where('prizepool', '<=', 1000000);
            } else if (request('filter') == 2) {
                $tournaments = $tournaments->where('prizepool', '>=', 1000000)->where('prizepool', '<=', 5000000);
            } else if (request('filter') == 3) {
                $tournaments = $tournaments->where('prizepool', '>=', 5000000)->where('prizepool', '<=', 10000000);
            } else if (request('filter') == 4) {
                $tournaments = $tournaments->where('prizepool', '>=', 10000000);
            }
        }


        return view('tournaments', [
            'tournaments' => $tournaments->paginate(6),
            'title' => 'Turnamen'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $slug = $request->orgSlug;
        $orgId = Organizer::where('slug', $slug)->first()->id;

        return view('tournament.create', [
            'title' => 'Buat Turnamen',
            'orgId' => $orgId,
            'slug' => $slug
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $organizerId = $request->orgId;
        $validatedData = $request->validate([
            'name' => 'required|unique:tournaments,name',
            'about' => 'required',
            'rules' => 'required',
            'prizepool' => 'required|numeric',
            'team_category' => 'required|max:3',
            'team_slot' => 'required|numeric',
            'tournament_type' => 'required',
            'banner_pic' => 'image|file|max:5096',
            'start_time' => 'required',
            'start_date' => 'required'
        ]);

        $validatedData['id_organizer'] = $organizerId;
        $validatedData['slug'] = Str::slug($request->name);
        // $validatedData['start_time'] = $request->start_date . ' ' . $request->start_time . ':00';
        $validatedData['banner_pic'] = $request->file('banner_pic')->store('tournament-banner');
        $validatedData['status'] = 'belum_selesai';

        Tournament::create($validatedData);

        return redirect()->route('organizer_tournaments', $request->slug);
    }

    private function getRegisteredTeam($tournamentId)
    {
        return TournamentTeam::where('tournament_id', $tournamentId)->where('status', 1)->count();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $tournament = Tournament::with('organizer')->where('slug', '=', $slug)->first();
        $team = TournamentTeam::with(['team'])->where('tournament_id', $tournament->id)->get();
        $userTeamStatus = null;
        $userTeamRole = null;
        $registeredTeam = $this->getRegisteredTeam($tournament->id);

        if (Auth::user()) {
            if ($registeredTeam != $tournament->team_slot) {
                $userTeam = UsersTeams::with(['user', 'team'])->where('user_id', Auth::user()->id);
                $userTeamIdList = [];
                foreach ($userTeam->get() as $ut) {
                    array_push($userTeamIdList, $ut->team_id);
                }
                $tournamentDt = TournamentTeam::with(['tournament', 'team'])->where('tournament_id', $tournament->id)->whereIn('team_id', $userTeamIdList)->first();
                // dd($tournamentDt);
                if ($tournamentDt != null) {
                    $userTeamIdJoinedTournament = $tournamentDt->team_id;
                    $userTeamRole = $userTeam->where('team_id', $userTeamIdJoinedTournament)->first()->role;
                    $userTeamStatus = $tournamentDt->status;
                } else {
                    if ($userTeam->get()->where('role', 'Leader')->count() > 0) {
                        $userTeamRole = 'Leader';
                    }
                }
            }
        }

        return view('tournament-detail', [
            'tournament' => $tournament,
            'title' => $tournament->name,
            'userTeamRole' => $userTeamRole,
            'userTeamStatus' => $userTeamStatus,
            'team' => $team,
            'registeredTeam' => $registeredTeam
        ]);
    }

    private function getRound($id)
    {
        $teamSlot = Tournament::where('id', $id)->pluck('team_slot')->first();
        $totalRound = 0;
        while (true) {
            $totalRound += 1;
            $teamSlot = $teamSlot / 2;
            if ($teamSlot == 1) {
                break;
            }
        }
        // $tournamentSlot = Tournament::find($id)->pluck('team_slot')->first();
        // $totalRound = 1;

        // while ($tournamentSlot > 0) {
        //     $totalRound += 1;
        //     $tournamentSlot /= 2;
        //     if ($tournamentSlot == 1) {
        //         break;
        //     }
        // }

        return $totalRound;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        $tournamentData = Tournament::with('organizer')->where('slug', $slug)->first();
        if (request('page')) {
            if (request('page') == 'team') {
                return view('tournament.edit-team', [
                    'title' => 'Edit ' . $tournamentData->name
                ]);
            } else if (request('page') == 'match') {
                $matchData = TournamentMatch::with(['team1', 'team2'])->where('tournament_id', $tournamentData->id)->where('round', 1)->get();
                $round = $this->getRound($tournamentData->id);
                $nextRoundCount = TournamentMatch::where('tournament_id', $tournamentData->id)->where('round', 2)->count();
                return view('tournament.edit-match', [
                    'title' => 'Edit ' . $tournamentData->name,
                    'tournamentData' => $tournamentData,
                    'matchData' => $matchData,
                    'round' => $round,
                    'nextRoundCount' => $nextRoundCount
                ]);
            }
        }

        if (request('round')) {
            $matchData = TournamentMatch::with(['team1', 'team2'])->where('tournament_id', $tournamentData->id)->where('round', request('round'))->get();
            $round = $this->getRound($tournamentData->id);
            $nextRoundCount = TournamentMatch::where('tournament_id', $tournamentData->id)->where('round', 2)->count();
            return view('tournament.edit-match', [
                'title' => 'Edit ' . $tournamentData->name,
                'tournamentData' => $tournamentData,
                'matchData' => $matchData,
                'round' => $round,
                'nextRoundCount' => $nextRoundCount
            ]);
        }

        return view('tournament.edit', [
            'title' => 'Edit ' . $tournamentData->name,
            'data' => $tournamentData,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $oldData = Tournament::findOrFail($id);
        $validatedData = $request->validate([
            'name' => 'required|unique:tournaments,name,' . $id,
            'about' => 'required',
            'rules' => 'required',
            'prizepool' => 'required|numeric',
            'team_category' => 'required|max:3',
            'team_slot' => 'required|numeric',
            'tournament_type' => 'required',
            'banner_pic' => 'image|file|max:5096',
            'start_time' => 'required',
            'start_date' => 'required'
        ]);

        $validatedData['slug'] = Str::slug($request->name);

        if ($request->banner_pic) {
            Storage::delete($oldData->banner_pic);
            $validatedData['banner_pic'] = $request->file('banner_pic')->store('tournament-banner');
        }

        Tournament::where('id', $id)->update($validatedData);

        return redirect()->route('organizer_tournaments', $request->orgSlug);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $tournament = Tournament::findOrFail($id);

        Storage::delete($tournament->banner_pic);

        $tournament->delete();

        return redirect()->route('organizer_tournaments', $request->orgSlug);
    }

    /**
     * Menampilkan halaman pilih tim untuk join turnamen
     */
    public function select_team(string $slug)
    {
        $teams = UsersTeams::with(['team'])->where('user_id', Auth::user()->id)->where('role', 'Leader')->get();
        return view('tournament.select-team', [
            'title' => "Pilih Tim",
            'teams' => $teams,
            'slug' => $slug
        ]);
    }

    /**
     * Atur tim yg dipilih agar join turnamen
     */
    public function join(Request $request, string $slug)
    {
        // $team = UsersTeams::where('team_id', $request->teamId)->get();
        $tournament = Tournament::where('slug', $slug)->first();
        $tournamentType = $tournament->tournament_type;

        if ($tournamentType === 'auto_join') {
            $status = 1;
        } else {
            $status = 0;
        }

        //get team member data
        $teamMember = Team::with('users')->find($request->teamId);

        foreach ($teamMember->users as $tm) {
            // dd($tm);
            if ($tm->status == 1) {
                HistoryTournamentsUser::create([
                    'id_user' => $tm->user_id,
                    'id_tournament' => $tournament->id
                ]);
            }
        }

        $t = TournamentTeam::create([
            'team_id' => $request->teamId,
            'tournament_id' => $tournament->id,
            'status' => $status
        ]);

        $team = Team::find($request->teamId);

        HistoryTournamentsTeam::create([
            'team_id' => $request->teamId,
            'tournament_id' => $tournament->id,
            'duelist' => $team->duelist,
            'initiator' => $team->initiator,
            'sentinel' => $team->sentinel,
            'controller' => $team->controller,
            'sub_1' => $team->sub_1,
            'sub_2' => $team->sub_2,
        ]);

        return redirect()->route('tournament.show', $slug);
    }

    public function bracket($slug)
    {
        $tournamentData = Tournament::where('slug', $slug)->first();

        return view('tournament.tournament-bracket', [
            'title' => 'Bracket ' . $tournamentData->name,
            'data' => $tournamentData
        ]);
    }

    public function postData(Request $request)
    {
        $team = [];
        $tr = $request->teams;
        for ($i = 0; $i < count($request->teams); $i++) {
            // dd(explode(',', $tr[$i]));
            array_push($team, [explode(',', $tr[$i])]);
        }
        $score = [];
        $ts = $request->score;
        for ($i = 0; $i < count($request->score); $i++) {
            array_push($score, [explode(',', $ts[$i])]);
        }
        dd($score);
    }
}
