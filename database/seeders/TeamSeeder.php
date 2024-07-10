<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('teams')->insert(
            [
                [
                    'name' => 'Evil Genius',
                    'slug' => Str::slug('Evil Genius'),
                    'description' => 'test',
                    'initiator' => 1,
                    'duelist' => 2,
                    'controller' => 3,
                    'sentinel' => 4,
                    'player_5' => 5,
                ],
                [
                    'name' => 'Fnatic',
                    'slug' => Str::slug('Fnatic'),
                    'description' => 'test',
                    'initiator' => 6,
                    'duelist' => 7,
                    'controller' => 8,
                    'sentinel' => 9,
                    'player_5' => 10,
                ],

                [
                    'name' => 'PaperRex',
                    'slug' => Str::slug('PaperRex'),
                    'description' => 'test',
                    'initiator' => 11,
                    'duelist' => 12,
                    'controller' => 13,
                    'sentinel' => 14,
                    'player_5' => 15,
                ],

                [
                    'name' => 'Team Liquid',
                    'slug' => Str::slug('Team Liquid'),
                    'description' => 'test',
                    'initiator' => 16,
                    'duelist' => 17,
                    'controller' => 18,
                    'sentinel' => 19,
                    'player_5' => 20,
                ]
            ],
        );
    }
}
