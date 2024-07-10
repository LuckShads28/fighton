<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JoinTournamentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tournament_teams')->insert(
            [[
                'team_id' => 1,
                'tournament_id' => 1,
                'rank' => 0,
                'status' => 1,
            ],
            [
                'team_id' => 2,
                'tournament_id' => 1,
                'rank' => 0,
                'status' => 1,
            ],
            [
                'team_id' => 3,
                'tournament_id' => 1,
                'rank' => 0,
                'status' => 1,
            ],
            [
                'team_id' => 4,
                'tournament_id' => 1,
                'rank' => 0,
                'status' => 1,
            ]],
        );
    }
}