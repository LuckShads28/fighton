<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(5)->create();

        // \App\Models\User::factory()->create([
        //     'username' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // DB::table('organizers')->insert(
        //     [
        //         [
        //             'name' => 'LTT Org',
        //             'description' => 'ini deskripsi',
        //             'slug' => 'ltt-org',
        //             'contact' => '081818181818',
        //         ],
        //         [
        //             'name' => 'Anya Org',
        //             'slug' => 'anya-org',
        //             'description' => 'ini deskripsi',
        //             'contact' => '088888888888',
        //         ]
        //     ]
        // );

        // \App\Models\Tournament::factory(10)->create();

        DB::table('users')->insert(
            [
                'nickname' => 'gun',
                'email' => 'gun@guntur.com',
                'slug' => strstr('gun@guntur.com', '@', true),
                'role' => 'Initiator',
                'password' => bcrypt(12345678),
            ],
        );

        // Clear Storage
        Storage::deleteDirectory('organizer-banner');
        Storage::deleteDirectory('organizer-logo');
        Storage::deleteDirectory('team-bg');
        Storage::deleteDirectory('team-logo');
    }
}
