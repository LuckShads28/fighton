<?php

namespace Tests\Feature;

use App\Models\Team;
use App\Models\Tournament;
use App\Models\User;
use DateTime;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TournamentMatchTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_add_match(): void
    {
        $user = User::find(1);
        $team1 = Team::find(1);
        $team2 = Team::find(2);
        $tournament = Tournament::find(1);
        $match_date = new DateTime($tournament->start_date);
        $match_date = $match_date->modify("+3 day");
        $match_date = $match_date->format('Y/m/d');

        $new_match = [
            "id" => $tournament->id,
            "team1" => $team1->id,
            "team2" => $team2->id,
            "round" => 1,
            "match_date" => $match_date,
        ];

        $this->actingAs($user)->post("matches", $new_match)->assertRedirectToRoute("tournament.edit", $tournament->slug);
        $this->assertDatabaseHas("tournament_matches", [
            "tournament_id" => $tournament->id,
            "team1_id" => $team1->id,
            "team2_id" => $team2->id,
        ]);
    }
}
