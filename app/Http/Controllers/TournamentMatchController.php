<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use App\Models\TournamentMatch;
use App\Models\TournamentTeam;
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
        $registeredTeam = TournamentTeam::with('team')
            ->where('tournament_id', $tournamentData->id)
            ->where('status', 1)
            ->get();
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
                ->where('team1_id', $request->team1)
                ->orWhere('team2_id', $request->team1)
                ->orWhere('team1_id', $request->team2)
                ->orWhere('team2_id', $request->team2)
                ->get();
            if ($data != null) {
                return back()->withErrors('Salah satu tim sudah berada dalam pertandingan');
            }
        }

        TournamentMatch::create([
            'tournament_id' => $request->id,
            'team1_id' => $request->team1,
            'team2_id' => $request->team2,
            'round' => $request->round,
            'match_date' => $request->match_date
        ]);

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
    public function destroy(string $id)
    {
        $match = TournamentMatch::findOrFail($id);

        $match->delete();

        return back();
    }

    public function score(string $slug, string $id)
    {
        $tournamentData = Tournament::where('slug', $slug)->first();
        $matchData = TournamentMatch::with(['team1', 'team2'])->find($id);
        return view('matches.set-score', [
            'title' => 'Atur Score ' . $tournamentData->title,
            'tournamentData' => $tournamentData,
            'matchData' => $matchData
        ]);
    }

    public function update_score()
    {
        return;
    }
}