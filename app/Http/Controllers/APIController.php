<?php

namespace App\Http\Controllers;

use App\Models\Organizer;
use App\Models\Team;
use App\Models\Tournament;
use App\Models\TournamentTeam;
use App\Models\User;
use App\Models\UsersOrganizers;
use App\Models\UsersTeams;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class APIController extends Controller
{
    public function getTournaments()
    {
        $tournaments = Tournament::with('organizer')->where('status', 'belum_selesai')->get();

        if (count($tournaments) == 0) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Data turnamen tidak ada'
            ]);
        }

        // $data = [];
        // foreach ($tournaments as $key => $t) {
        //     $data[] = $t;
        //     $data[$key]['organizer_name'] = $tournaments[$key]->organizer->first()->name;
        //     $data[$key]['organizer_pic'] = $tournaments[$key]->organizer->first()->logo_img;
        // }

        return response()->json([
            'status' => 'ok',
            'data' => $tournaments
        ]);
    }

    public function getRegisteredTeam()
    {
        $tournamentId = request('tournament_id');
        $tournamentRegisteredTeamId = TournamentTeam::where('tournament_id', $tournamentId)->pluck('team_id')->toArray();
        $userId = request('user_id');
        $userTeam = UsersTeams::whereIn('team_id', $tournamentRegisteredTeamId)->where('user_id', $userId)->get();
        $isUserTeamRegistered = false;
        if (count($userTeam) > 0) {
            $isUserTeamRegistered = true;
        }

        return response()->json([
            'status' => 'ok',
            'registered_team_count' => count($tournamentRegisteredTeamId),
            'is_user_team_registered' => $isUserTeamRegistered
        ]);
    }

    public function createTournament(Request $request)
    {
        $organizerId = $request->organizer_id;
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:tournaments,name',
            'about' => 'required',
            'rules' => 'required',
            'prizepool' => 'required|numeric',
            'team_slot' => 'required|numeric',
            'banner_pic' => 'image|file|max:5096',
            'start_time' => 'required',
            'start_date' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => $validator->errors(),
            ]);
        }

        $teamCategory = '5v5';
        $tournamentType = 'auto_join';
        $slug = Str::slug($request->name);
        $bannerPic = $request->file('banner_pic')->store('tournament-banner');
        $status = 'belum_selesai';

        Tournament::create([
            'name' => $request->input('name'),
            'about' => $request->input('about'),
            'rules' => $request->input('rules'),
            'prizepool' => $request->input('prizepool'),
            'team_slot' => $request->input('team_slot'),
            'start_time' => $request->input('start_time'),
            'start_date' => $request->input('start_date'),
            'banner_pic' => $bannerPic,
            'team_category' => $teamCategory,
            'tournament_type' => $tournamentType,
            'slug' => $slug,
            'status' => $status,
            'id_organizer' => $organizerId
        ]);

        return response()->json([
            'status' => 'ok'
        ]);
    }

    public function joinTournament(Request $request)
    {
        $tournament = Tournament::where('id', $request->input('tournament_id'))->first();
        $tournamentType = $tournament->tournament_type;

        if ($tournamentType === 'auto_join') {
            $status = 1;
        } else {
            $status = 0;
        }

        TournamentTeam::create([
            'team_id' => $request->team_id,
            'tournament_id' => $tournament->id,
            'status' => $status
        ]);

        return response()->json([
            'status' => 'ok',
        ]);
    }

    public function getTournamentHistory()
    {
        $userId = request()->input('user_id');
        if (!$userId) {
            return response()->json(
                [
                    'status'  => 'error',
                    'message' => 'parameter user_id tidak ditemukan'
                ]
            );
        }

        $userTeam = UsersTeams::where('user_id', $userId)->pluck('team_id')->toArray();
        $activeTournament = Tournament::where('status', 'belum_selesai')->pluck('id')->toArray();
        $tournamentTeam = TournamentTeam::with('tournament')->whereIn('team_id', $userTeam)->whereIn('tournament_id', $activeTournament)->get();

        $data = [];
        foreach ($tournamentTeam as $key => $tteam) {
            $data[] = $tteam->tournament->first();
            $org = Organizer::find($tteam->tournament->first()->id_organizer);
            $data[$key]['organizer'] = $org;
        }

        return response()->json([
            'status' => 'ok',
            'data' => $data
        ]);
    }

    public function getTeams()
    {
        $data = Team::all();

        $userId = request('user_id');
        if (request('user_id')) {
            $usersTeams = UsersTeams::with('team')->where('user_id', $userId)->where('status', 1)->get();
            $usersTeamsId = $usersTeams->pluck('team_id')->toArray();
            $teamLeader = UsersTeams::with('user')->whereIn('team_id', $usersTeamsId)->where('role', 'leader')->get();
            $teams = [];
            foreach ($usersTeams as $key => $ut) {
                $teams[] = $ut->team->first();
                $teams[$key]['leader'] = $teamLeader[$key]->user->first()->nickname;
            }
            $data = $teams;
        } else {
            $usersTeamsId = $data->pluck('id')->toArray();
            $teamLeader = UsersTeams::with('user')->whereIn('team_id', $usersTeamsId)->where('role', 'leader')->get();
            $teams = [];
            foreach ($data as $key => $ut) {
                $teams[] = $ut;
                $teams[$key]['leader'] = $teamLeader[$key]->user->first()->nickname;
            }
            $data = $teams;
        }

        return response()->json([
            'status' => 'ok',
            'data' => $data
        ]);
    }

    public function createTeam(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:6|max:20|unique:teams',
            'description' => 'required|min:6|max:200',
            'logo_img' => 'image|file|max:1000',
            'banner_img' => 'image|file|max:5096'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => $validator->errors()
            ]);
        }

        $leaderId = $request->input('id');
        $leaderRole = Str::lower(User::find($leaderId)->role);
        $slug = Str::slug($request->input('name'));
        $logoImg = $request->file('logo_img')->store('team-logo');
        $bannerImg = $request->file('banner_img')->store('team-bg');

        $newTeam = [
            'name' => $request->input('name'),
            'slug' => $slug,
            'description' => $request->input('description'),
            'logo_img' => $logoImg,
            'banner_img' => $bannerImg,
        ];
        $newTeam[$leaderRole] = $leaderId;

        $team = Team::create($newTeam);
        UsersTeams::create([
            'user_id' => $leaderId,
            'team_id' => $team->id,
            'status' => 1,
            'role' => 'Leader'
        ]);

        return response()->json([
            'status' => 'ok',
        ]);
    }

    public function joinTeam(Request $request)
    {
        $userId = $request->user_id;
        $teamId = $request->team_id;

        $userTeam = UsersTeams::where('user_id', $userId)->where('team_id', $teamId)->where('status', 1)->first();
        if ($userTeam) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Sudah bergabung di tim tersebut'
            ]);
        }

        UsersTeams::create([
            'user_id' => $userId,
            'team_id' => $teamId,
            'status' => 0
        ]);

        return response()->json([
            'status' => 'ok',
            'message' => 'Berhasil request ke tim'
        ]);
    }

    public function getMember()
    {
        $teamId = request()->input('team_id');
        $teamMember = UsersTeams::with('user')->where('team_id', $teamId)->get();

        if (count($teamMember) == 0) {
            return response()->json([
                'status' => 'failed',
                'message' => 'data tidak ditemukan'
            ]);
        }

        $data = [];
        foreach ($teamMember as $key => $tm) {
            $data[] = $tm->user->first();
            if ($tm->role == null) {
                $data[$key]['role'] = 'request';
            } else {
                $data[$key]['role'] = $tm->role;
            }
        }

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function getOrganizers()
    {
        $data = Organizer::all();

        if (request('user_id')) {
            $userId = request('user_id');
            $usersOrganizer = UsersOrganizers::with('organizer')->where('user_id', $userId)->get();
            $usersOrganizerId = $usersOrganizer->pluck('organizer_id')->toArray();
            $organizerLeader = UsersOrganizers::with('user')->whereIn('organizer_id', $usersOrganizerId)->where('role', 'leader')->get();
            $organizers = [];
            foreach ($usersOrganizer as $key => $ut) {
                $organizers[] = $ut->organizer->first();
                $organizers[$key]['leader'] = $organizerLeader[$key]->user->first()->nickname;
            }
            $data = $organizers;
        } else {
            $usersOrganizerId = $data->pluck('id')->toArray();
            $organizerLeader = UsersOrganizers::with('user')->whereIn('organizer_id', $usersOrganizerId)->where('role', 'leader')->get();
            // dd($teamLeader);
            $organizers = [];
            foreach ($data as $key => $ut) {
                $organizers[] = $ut;
                $organizers[$key]['leader'] = $organizerLeader[$key]->user->first()->nickname;
            }
            $data = $organizers;
        }

        return response()->json([
            'status' => 'ok',
            'data' => $data
        ]);

        return response()->json([
            'status' => 'ok',
            'data' => $data
        ]);
    }

    public function createOrganizer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:6|max:20|unique:teams',
            'description' => 'required|min:6|max:200',
            'logo_img' => 'image|file|max:1000',
            'banner_img' => 'image|file|max:5096',
            'contact' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => $validator->errors()
            ]);
        }

        $leaderId = $request->input('id_user');
        $slug = Str::slug($request->input('name'));
        $logoImg = $request->file('logo_img')->store('organizer-logo');
        $bannerImg = $request->file('banner_img')->store('organizer-bg');

        $newOrganizer = [
            'name' => $request->input('name'),
            'slug' => $slug,
            'description' => $request->input('description'),
            'logo_img' => $logoImg,
            'banner_img' => $bannerImg,
            'contact' => $request->input('contact'),
        ];

        $organizer = Organizer::create($newOrganizer);
        UsersOrganizers::create([
            'user_id' => $leaderId,
            'organizer_id' => $organizer->id,
            'role' => 'Leader'
        ]);

        return response()->json([
            'status' => 'ok',
        ]);
    }

    public function getUsers(Request $request)
    {
        $data = User::all();
        return response()->json([
            'status' => 'ok',
            'data' => $data
        ]);
    }

    public function getUser(Request $request)
    {
        $data = User::find($request->input('id'));

        if ($data === NULL) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data not found'
            ]);
        }

        return response()->json([
            'status' => 'ok',
            'data' => $data
        ]);
    }

    // public function addUser(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'nickname' => 'required|min:3|max:20',
    //         'email' => 'required|email|unique:users',
    //         'password' => 'required|min:6',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => $validator->errors()
    //         ]);
    //     }

    //     $obj = new User;
    //     $obj->nickname = $request->input('nickname');
    //     $obj->email = $request->input('email');
    //     $obj->password = bcrypt($request->input('password'));
    //     $obj->slug = strstr($request->input('email'), '@', true);
    //     $obj->save();

    //     return response()->json([
    //         'status' => 'ok'
    //     ]);
    // }
}
