<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users_teams')->insert(
            [
                [
                    'user_id' => 1,
                    'team_id' => 1,
                    'status' => 1,
                    'role' => 'Leader'
                ],
                [
                    'user_id' => 2,
                    'team_id' => 1,
                    'status' => 1,
                    'role' => 'Anggota'
                ],
                [
                    'user_id' => 3,
                    'team_id' => 1,
                    'status' => 1,
                    'role' => 'Anggota'
                ],
                [
                    'user_id' => 4,
                    'team_id' => 1,
                    'status' => 1,
                    'role' => 'Anggota'
                ],
                [
                    'user_id' => 5,
                    'team_id' => 1,
                    'status' => 1,
                    'role' => 'Anggota'
                ],
                [
                    'user_id' => 6,
                    'team_id' => 2,
                    'status' => 1,
                    'role' => 'Leader'
                ],
                [
                    'user_id' => 7,
                    'team_id' => 2,
                    'status' => 1,
                    'role' => 'Anggota'
                ],
                [
                    'user_id' => 8,
                    'team_id' => 2,
                    'status' => 1,
                    'role' => 'Anggota'
                ],
                [
                    'user_id' => 9,
                    'team_id' => 2,
                    'status' => 1,
                    'role' => 'Anggota'
                ],
                [
                    'user_id' => 10,
                    'team_id' => 2,
                    'status' => 1,
                    'role' => 'Anggota'
                ],
                [
                    'user_id' => 11,
                    'team_id' => 3,
                    'status' => 1,
                    'role' => 'Leader'
                ],
                [
                    'user_id' => 12,
                    'team_id' => 3,
                    'status' => 1,
                    'role' => 'Anggota'
                ],
                [
                    'user_id' => 13,
                    'team_id' => 3,
                    'status' => 1,
                    'role' => 'Anggota'
                ],
                [
                    'user_id' => 14,
                    'team_id' => 3,
                    'status' => 1,
                    'role' => 'Anggota'
                ],
                [
                    'user_id' => 15,
                    'team_id' => 3,
                    'status' => 1,
                    'role' => 'Anggota'
                ],
                [
                    'user_id' => 16,
                    'team_id' => 4,
                    'status' => 1,
                    'role' => 'Leader'
                ],
                [
                    'user_id' => 17,
                    'team_id' => 4,
                    'status' => 1,
                    'role' => 'Anggota'
                ],
                [
                    'user_id' => 18,
                    'team_id' => 4,
                    'status' => 1,
                    'role' => 'Anggota'
                ],
                [
                    'user_id' => 19,
                    'team_id' => 4,
                    'status' => 1,
                    'role' => 'Anggota'
                ],
                [
                    'user_id' => 20,
                    'team_id' => 4,
                    'status' => 1,
                    'role' => 'Anggota'
                ]
            ],
        );
    }
}
