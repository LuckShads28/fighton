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
                'nickname' => 'gun',
                'email' => 'gun@guntur.com',
                'slug' => strstr('gun@guntur.com', '@', true),
                'role' => 'Initiator',
                'password' => bcrypt(12345678),
            ],
            [
                'nickname' => 'gin',
                'email' => 'gin@gmail.com',
                'slug' => strstr('gin@gmail.com', '@', true),
                'role' => 'Initiator',
                'password' => bcrypt(12345678),
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

        // Clear Storage
        Storage::deleteDirectory('organizer-banner');
        Storage::deleteDirectory('organizer-logo');
        Storage::deleteDirectory('team-bg');
        Storage::deleteDirectory('team-logo');
    }
}
