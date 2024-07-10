<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(5)->create();

        // \App\Models\User::factory()->create([
        //     'username' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        DB::table('organizers')->insert(
            [
                [
                    'name' => 'LTT Org',
                    'description' => 'ini deskripsi',
                    'slug' => 'ltt-org',
                    'contact' => '081818181818',
                ],
            ]
        );

        DB::table('organizers')->insert(
            [
                [
                    'name' => 'Tour Organizer',
                    'description' => 'ini deskripsi',
                    'slug' => 'tour-organizer',
                    'contact' => '081818181818',
                ],
            ]
        );

        \App\Models\Tournament::factory(5)->create();

        DB::table('users')->insert(
            [
                [
                    'nickname' => 'gun',
                    'email' => 'gun@guntur.com',
                    'slug' => strstr('gun@guntur.com', '@', true),
                    'role' => 'Initiator',
                    'password' => bcrypt(12345678),
                ],
                [
                    'nickname' => 'redgar',
                    'email' => 'redgar@mail.com',
                    'slug' => strstr('redgar@mail.com', '@', true),
                    'role' => 'Duelist',
                    'password' => bcrypt(12345678),
                ],
                [
                    'nickname' => 'sayf',
                    'email' => 'sayf@mail.com',
                    'slug' => strstr('sayf@mail.com', '@', true),
                    'role' => 'Controller',
                    'password' => bcrypt(12345678),
                ],
                [
                    'nickname' => 'natz',
                    'email' => 'natz@mail.com',
                    'slug' => strstr('natz@mail.com', '@', true),
                    'role' => 'Sentinel',
                    'password' => bcrypt(12345678),
                ],
                [
                    'nickname' => 'forsaken',
                    'email' => 'forsaken@forsaken.com',
                    'slug' => strstr('forsaken@forsaken.com', '@', true),
                    'role' => 'Duelist',
                    'password' => bcrypt(12345678),
                ],
                [
                    'nickname' => 'mindfreak',
                    'email' => 'mindfreak@mail.com',
                    'slug' => strstr('mindfreak@mail.com', '@', true),
                    'role' => 'Initiator',
                    'password' => bcrypt(12345678),
                ],
                [
                    'nickname' => 'davai',
                    'email' => 'davai@mail.com',
                    'slug' => strstr('davai@mail.com', '@', true),
                    'role' => 'Duelist',
                    'password' => bcrypt(12345678),
                ],
                [
                    'nickname' => 'jinggg',
                    'email' => 'jinggg@mail.com',
                    'slug' => strstr('jinggg@mail.com', '@', true),
                    'role' => 'Controller',
                    'password' => bcrypt(12345678),
                ],
                [
                    'nickname' => 'cgrs',
                    'email' => 'cgrs@mail.com',
                    'slug' => strstr('cgrs@mail.com', '@', true),
                    'role' => 'Sentinel',
                    'password' => bcrypt(12345678),
                ],
                [
                    'nickname' => 'benkai',
                    'email' => 'benkai@mail.com.com',
                    'slug' => strstr('benkai@mail.com', '@', true),
                    'role' => 'Controller',
                    'password' => bcrypt(12345678),
                ],
                [
                    'nickname' => 'somethings',
                    'email' => 'somethings@mail.com',
                    'slug' => strstr('somethings@mail.com', '@', true),
                    'role' => 'Initiator',
                    'password' => bcrypt(12345678),
                ],
                [
                    'nickname' => 'leo',
                    'email' => 'leo@mail.com',
                    'slug' => strstr('leo@mail.com', '@', true),
                    'role' => 'Duelist',
                    'password' => bcrypt(12345678),
                ],
                [
                    'nickname' => 'derke',
                    'email' => 'derke@mail.com',
                    'slug' => strstr('derke@mail.com', '@', true),
                    'role' => 'Controller',
                    'password' => bcrypt(12345678),
                ],
                [
                    'nickname' => 'alfajer',
                    'email' => 'alfa@mail.com.com',
                    'slug' => strstr('alfa@mail.com.com', '@', true),
                    'role' => 'Sentinel',
                    'password' => bcrypt(12345678),
                ],
                [
                    'nickname' => 'boaster',
                    'email' => 'boaster@mail.com',
                    'slug' => strstr('boaster@mail.com', '@', true),
                    'role' => 'Duelist',
                    'password' => bcrypt(12345678),
                ],
                [
                    'nickname' => 'tehbotol',
                    'email' => 'tehbotol@mail.com',
                    'slug' => strstr('tehbotol@mail.com', '@', true),
                    'role' => 'Initiator',
                    'password' => bcrypt(12345678),
                ],
                [
                    'nickname' => 'mako',
                    'email' => 'mako@mail.com',
                    'slug' => strstr('mako@mail.com', '@', true),
                    'role' => 'Duelist',
                    'password' => bcrypt(12345678),
                ],
                [
                    'nickname' => 'buzz',
                    'email' => 'buzz@mail.com',
                    'slug' => strstr('buzz@mail.com', '@', true),
                    'role' => 'Controller',
                    'password' => bcrypt(12345678),
                ],
                [
                    'nickname' => 'staxx',
                    'email' => 'staxx@mail.com',
                    'slug' => strstr('staxx@mail.com', '@', true),
                    'role' => 'Sentinel',
                    'password' => bcrypt(12345678),
                ],
                [
                    'nickname' => 'rb',
                    'email' => 'rbkr@mail.com.com',
                    'slug' => strstr('rbkr@mail.com', '@', true),
                    'role' => 'Sentinel',
                    'password' => bcrypt(12345678),
                ]
            ],
        );

        DB::table('users_organizers')->insert(
            [
                'user_id' => 1,
                'organizer_id' => 1,
                'role' => 'Leader'
            ],
            [
                'user_id' => 1,
                'organizer_id' => 2,
                'role' => 'Leader'
            ]
        );

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
                ],

                [
                    'name' => 'Winner Team',
                    'slug' => Str::slug('Winner Team'),
                    'description' => 'test',
                    'initiator' => 1,
                    'duelist' => null,
                    'controller' => null,
                    'sentinel' => null,
                    'player_5' => null
                ],
            ],
        );

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
                ],
                [
                    'user_id' => 1,
                    'team_id' => 5,
                    'status' => 1,
                    'role' => 'Leader'
                ]
            ],
        );

        // Clear Storage
        Storage::deleteDirectory('organizer-banner');
        Storage::deleteDirectory('organizer-logo');
        Storage::deleteDirectory('team-bg');
        Storage::deleteDirectory('team-logo');

        DB::table('users')->insert([
            'nickname' => 'administrator',
            'email' => 'admin@fighton.my.id',
            'slug' => 'administrator',
            'role' => 'admin',
            'password' => bcrypt('Admin_123')
        ]);
    }
}
