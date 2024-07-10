<?php

namespace App\Http\Controllers;

use App\Models\HistoryTournamentsTeam;
use App\Models\HistoryTournamentsUser;
use App\Models\MatchDetail;
use App\Models\Team;
use App\Models\Tournament;
use App\Models\TournamentMatch;
use App\Models\TournamentTeam;
use App\Models\UsersTeams;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class TournamentMatchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $slug)
    {
        $tournamentData = Tournament::where('slug', $slug)->first();
        // $team1RegisteredData = TournamentMatch::where('tournament_id', $tournamentData->id)->where('round', 1)->pluck('team1_id')->toArray();
        // $team2RegisteredData = TournamentMatch::where('tournament_id', $tournamentData->id)->where('round', 1)->pluck('team2_id')->toArray();
        // $teamRegisteredData = [];
        // array_push($teamRegisteredData, $team1RegisteredData, $team2RegisteredData);
        // dd($teamRegisteredData);
        $registeredTeam = TournamentTeam::with('team')
            ->where('tournament_id', $tournamentData->id)
            ->where('status', 1)
            ->get();
        return view('matches.create', [
            'title' => 'Tambah Pertandingan | ' . $tournamentData->name,
            'registeredTeam' => $registeredTeam,
            'tournamentData' => $tournamentData
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $tournamentData = Tournament::find($request->id);
        $validatedData = $request->validate([
            'team1' => 'required',
            'team2' => 'required',
            // 'round' => 'required|numeric',
            'match_date' => 'required'
        ]);

        if ($request->team1 == $request->team2) {
            return back()->withErrors('Tim yang dipilih harus berbeda');
        } else if (date($request->match_date) < $tournamentData->start_date) {
            return back()->withErrors('Jadwal waktu turnamen harus sesudah jadwal turnamen dimulai');
        } else {
            $data = TournamentMatch::where('tournament_id', $request->id)
                ->where('round', 1)
                ->where('team1_id', $request->team1)
                ->orWhere('team2_id', $request->team1)
                ->orWhere('team1_id', $request->team2)
                ->orWhere('team2_id', $request->team2)
                ->first();
            if ($data) {
                return back()->withErrors('Salah satu tim sudah berada dalam pertandingan');
            }
        }

        $match = TournamentMatch::create([
            'tournament_id' => $request->id,
            'team1_id' => $request->team1,
            'team2_id' => $request->team2,
            'round' => 1,
            'match_date' => $request->match_date
        ]);

        $team1 = Team::find($request->team1);
        $team2 = Team::find($request->team2);

        return redirect()->route('tournament.edit', $tournamentData->slug);
    }

    /**
     * Display the specified resource.
     */
    public function show(TournamentMatch $tournamentMatch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TournamentMatch $tournamentMatch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $tournamentId)
    {
        if ($request->update == 'team') {
            for ($i = 0; $i < count($request->matchId); $i++) {
                if ($request->team1[$i] == $request->team2[$i] && ($request->team1[$i] != null || $request->team2[$i] != null)) {
                    return back()->withErrors('Tiap pertandingan hanya boleh ada satu tim saja');
                } else {
                    TournamentMatch::where('id', $request->matchId[$i])->update([
                        'team1_id' => $request->team1[$i],
                        'team2_id' => $request->team2[$i]
                    ]);
                }
            }
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug, string $id)
    {
        $match = TournamentMatch::findOrFail($id);

        $match->delete();

        return back();
    }

    public function score(string $slug, string $id, $team1, $team2)
    {
        $tournamentData = Tournament::where('slug', $slug)->first();
        $matchData = TournamentMatch::with(['team1', 'team2'])->find($id);

        $matchDetailData = MatchDetail::where('match_id', $matchData->id)->get();
        // dd($matchDetailData);
        if ($matchDetailData->count() > 0) {
            $team1Member = MatchDetail::with('player')->where('match_id', $matchData->id)->where('team_id', $team1)->get();
            $team2Member = MatchDetail::with('player')->where('match_id', $matchData->id)->where('team_id', $team2)->get();
            return view('matches.set-score', [
                'title' => 'Atur Score ' . $tournamentData->title,
                'tournamentData' => $tournamentData,
                'matchData' => $matchData,
                'haveDetail' => true,
                'team1_member' => $team1Member,
                'team2_member' => $team2Member
            ]);
        }

        $team1Member = UsersTeams::with('user')->where('team_id', $team1)->where('status', 1)->get('user_id');
        $team2Member = UsersTeams::with('user')->where('team_id', $team2)->where('status', 1)->get('user_id');
        return view('matches.set-score', [
            'title' => 'Atur Score ' . $tournamentData->title,
            'tournamentData' => $tournamentData,
            'matchData' => $matchData,
            'haveDetail' => false,
            'team1_member' => $team1Member,
            'team2_member' => $team2Member
        ]);
    }

    public function update_score(Request $request, $slug, $id)
    {
        // dd($id);
        $team1_score = $request->team1_score;
        $team2_score = $request->team2_score;
        $team1_id = Team::where('name', $request->team1)->first()->id;
        $team2_id = Team::where('name', $request->team2)->first()->id;
        // dd($request->match_date);

        if ($team1_score < 0 || $team2_score < 0) {
            return back()->withErrors('Score tidak boleh negatif');
        }
        if ($request->team1_wo) {
            $team1_score = -1;
        }
        if ($request->team2_wo) {
            $team2_score = -1;
        }

        $team1MemberValidate = Validator::make($request->team1_member, [
            '*' => 'distinct'
        ]);
        $team2MemberValidate = Validator::make($request->team2_member, [
            '*' => 'distinct'
        ]);

        if (!$team1MemberValidate->passes() || !$team2MemberValidate->passes()) {
            return redirect()->back()->withErrors('Anggota tim yang bermain tidak boleh sama');
        }

        // $checkMatch = TournamentMatch::where('tournament_id', $request->tid)->where('round', $request->round)->first();
        $checkMatch = TournamentMatch::find($id);

        // Tambah data detail match tim 1
        for ($i = 0; $i < 5; $i++) {
            if ($checkMatch != null) {
                $matchDetail = MatchDetail::where('match_id', $checkMatch->id)->where('user_id', $request->team1_member[$i])->first();
                if ($matchDetail == null) {
                    MatchDetail::create([
                        'match_id' => $checkMatch->id,
                        'team_id' => $team1_id,
                        'user_id' => $request->team1_member[$i],
                        'kill' => $request->team1_kill[$i],
                        'death' => $request->team1_death[$i],
                        'assist' => $request->team1_assist[$i],
                        'acs' => $request->team1_acs[$i]
                    ]);
                } else {
                    $matchDetail->update([
                        'kill' => $request->team1_kill[$i],
                        'death' => $request->team1_death[$i],
                        'assist' => $request->team1_assist[$i],
                        'acs' => $request->team1_acs[$i]
                    ]);
                }
            }
        }

        // Tambah data detail match tim 2
        for ($i = 0; $i < 5; $i++) {
            if ($checkMatch != null) {
                $matchDetail = MatchDetail::where('match_id', $checkMatch->id)->where('user_id', $request->team2_member[$i])->first();
                if ($matchDetail == null) {
                    MatchDetail::create([
                        'match_id' => $checkMatch->id,
                        'team_id' => $team2_id,
                        'user_id' => $request->team2_member[$i],
                        'kill' => $request->team2_kill[$i],
                        'death' => $request->team2_death[$i],
                        'assist' => $request->team2_assist[$i],
                        'acs' => $request->team2_acs[$i]
                    ]);
                } else {
                    $matchDetail->update([
                        'kill' => $request->team2_kill[$i],
                        'death' => $request->team2_death[$i],
                        'assist' => $request->team2_assist[$i],
                        'acs' => $request->team2_acs[$i]
                    ]);
                }
            }
        }

        $checkMatch->update([
            'team1_score' => $request->team1_score,
            'team2_score' => $request->team2_score,
            'match_date' => $request->match_date
        ]);

        return redirect()->route('tournament.edit', $slug);
    }

    public function getTeamData($idTournament)
    {
        $data = TournamentMatch::with(['team1', 'team2'])->where('tournament_id', $idTournament);

        $teams = [];
        $score = [];
        // Get team name data
        for ($i = 1; $i < $data->max('round'); $i++) {
            // $roundData = $data->where('round', $i)->get();
            $roundData = TournamentMatch::with(['team1', 'team2'])->where('tournament_id', $idTournament)->where('round', $i)->get();

            for ($j = 0; $j < $roundData->count(); $j++) {
                array_push($teams, [$roundData[$j]->team1->name, $roundData[$j]->team2->name]);
            }
        }
        // Get team score data
        for ($i = 1; $i <= $data->max('round'); $i++) {
            $roundData = TournamentMatch::with(['team1', 'team2'])->where('tournament_id', $idTournament)->where('round', $i)->get();
            $rData = [];
            for ($j = 0; $j < $roundData->count(); $j++) {
                array_push($rData, [$roundData[$j]->team1_score, $roundData[$j]->team2_score]);
            }
            if (count($rData) > 0) {
                array_push($score, $rData);
            }
            // dd($score);
        }

        // dd($teams);

        // dd($data->where('round', 1)->get());

        $jsonData = [
            'teams' => $teams,
            'results' => $score
        ];

        return response()->json($jsonData);
    }

    private function getRound($id)
    {
        $tournamentSlot = Tournament::find($id)->pluck('team_slot')->first();
        $totalRound = 0;

        while ($tournamentSlot > 0) {
            $totalRound += 1;
            $tournamentSlot /= 2;
            if ($tournamentSlot == 1) {
                break;
            }
        }

        return $totalRound;
    }

    public function generateWinner($slug)
    {
        //get tournament id
        $tournament = Tournament::where('slug', $slug);
        $id = Tournament::where('slug', $slug)->pluck('id')->first();
        $lastMatch = TournamentMatch::where('tournament_id', $id)->where('round', $this->getRound($id))->first();
        if ($lastMatch) {
            if ($lastMatch->team1_score == $lastMatch->team2_score) {
                return back()->withErrors('Data pemenang tidak ditemukan.');
            }
            if ($lastMatch->team1_score > $lastMatch->team2_score) {
                $winner = $lastMatch->team1_id;
            } else {
                $winner = $lastMatch->team2_id;
            }
            $teamHistory = HistoryTournamentsTeam::where('team_id', $winner)->where('tournament_id', $id);
            $winnerUserId = HistoryTournamentsTeam::select('duelist', 'controller', 'sentinel', 'initiator', 'player_5', 'sub_1', 'sub_2')
                ->where('team_id', $winner)->where('tournament_id', $id)
                ->first();
            $winnerUserId = [$winnerUserId->duelist, $winnerUserId->sentinel, $winnerUserId->controller, $winnerUserId->initiator, $winnerUserId->player_5, $winnerUserId->sub_1, $winnerUserId->sub_2];
            // $userHistory = HistoryTournamentsUser::where('id_user')->where('tournament_id', $id)->first();
            $userHistory = HistoryTournamentsUser::whereIn('id_user', $winnerUserId)->get();
            // dd($userHistory->first());
            foreach ($userHistory as $u) {
                // dd($u);
                $u->update([
                    'rank' => 1
                ]);
            }
            $tournament->first()->update([
                'status' => 'sudah_selesai'
            ]);
        }

        return back();
    }

    public function generateNextRound($slug)
    {
        //get tournament id
        $id = Tournament::where('slug', $slug)->pluck('id')->first();
        $match = TournamentMatch::where('tournament_id', $id);
        $tournamentTotalRound = $this->getRound($id);

        //get current highest round
        $highestRound = $match->get()->max('round');
        $matches = $match->where('round', $highestRound)->get();

        if ($highestRound == $tournamentTotalRound) {
            return back()->withErrors('Ronde Sudah Final');
        }

        for ($i = 0; $i < count($matches); $i += 2) {
            if ($matches[$i]->team1_score > $matches[$i]->team2_score) {
                $team1NextRound = $matches[$i]->team1_id;
            } else {
                $team1NextRound = $matches[$i]->team2_id;
            }
            if ($matches[$i + 1]->team1_score > $matches[$i + 1]->team2_score) {
                $team2NextRound = $matches[$i + 1]->team1_id;
            } else {
                $team2NextRound = $matches[$i + 1]->team2_id;
            }
            TournamentMatch::insert([
                'tournament_id' => $id,
                'round' => $highestRound + 1,
                'team1_id' => $team1NextRound,
                'team2_id' => $team2NextRound
            ]);
        }

        return back()->with('Success', 'Berhasil Generate Ronde Selanjutnya');
    }
}
