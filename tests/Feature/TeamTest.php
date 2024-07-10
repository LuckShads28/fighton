<?php

namespace Tests\Feature;

use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Testing\File;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Illuminate\Support\Str;

class TeamTest extends TestCase
{
    /**
     * Buat tim
     */
    public function test_create_team(): void
    {
        $user = User::firstWhere("nickname", "gun");

        $fake_logo_img = UploadedFile::fake()->image('logo.png');
        $fake_banner_img = UploadedFile::fake()->image("banner.png");
        // $fake_logo_img = File::fake('logo.png', 400, 100);
        // $fake_banner_img = File::fake('banner.png', 1000, 600);

        $new_team_data = [
            "name" => "team testing",
            "description" => "ini deskripsi tim testing",
            "logo_img" => $fake_logo_img,
            "banner_img" => $fake_banner_img,
        ];

        $this->actingAs($user)->post('/team', $new_team_data)->assertRedirectToRoute('profile.index');
        $this->assertDatabaseHas('teams', ['name' => $new_team_data['name']]);

        //     //hapus team baru
        //     $new_team = Team::firstWhere("name", "team testing");
        //     $new_team->delete();
    }

    /**
     * Update tim
     */
    public function test_update_team()
    {
        $user = User::firstWhere("nickname", "gun");

        $team_data = Team::firstWhere("name", "team testing");

        $new_team_data = [
            "name" => "team testing updated",
            "description" => "ini deskripsi tim testing",
        ];

        $this->actingAs($user)
            ->put('/team/' . $team_data->id, $new_team_data)
            ->assertRedirectToRoute('team.show', Str::slug($new_team_data['name']));

        $this->assertDatabaseMissing('teams', ['name' => $team_data->name]);
        $this->assertDatabaseHas('teams', ['name' => $new_team_data['name']]);
    }

    /**
     * Delete tim
     */
    public function test_delete_team()
    {
        $user = User::firstWhere("nickname", "gun");

        $team_data = Team::firstWhere("name", "team testing updated");

        $this->actingAs($user)
            ->delete('/team/' . $team_data->id)
            ->assertRedirect('/profile');

        $this->assertDatabaseMissing('teams', ['id' => $team_data->id]);
    }

    public function test_join_team()
    {
        $user = User::create([
            "nickname" => "mylog2828",
            "slug" => "mylog2828",
            "email" => "mylog@gmail.com",
            "password" => bcrypt(12345678),
            "role" => "Controller"
        ]);
        $team = Team::firstWhere('name', 'Winner Team');

        $this->actingAs($user)->get("/team/". $team->slug ."/request/" . $user->slug)->assertRedirectToRoute('team.show', $team->slug);
    }

    public function test_approve_team_join()
    {
        $team = Team::firstWhere('name', 'Winner Team');
        $user = User::firstWhere("nickname", "mylog2828");
        $teamLeader = User::firstWhere("nickname", "gun");

        $data = [
            "teamId" => $team->id,
            "userId" => $user->id,
            "status" => 1
        ];

        $this->actingAs($teamLeader)->post("/team/". $team->slug ."/response", $data)->assertRedirectToRoute("edit_anggota", $team->slug);
    }
}
