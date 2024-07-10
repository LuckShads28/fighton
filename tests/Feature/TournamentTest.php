<?php

namespace Tests\Feature;

use App\Models\Organizer;
use App\Models\Tournament;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class TournamentTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_create_tournament(): void
    {
        $organizer = Organizer::find(1);
        $user = User::find(1);

        // Fake img
        $banner_img = UploadedFile::fake()->image('banner.jpg');

        $data_tournament = [
            'name' => 'turnamen testing',
            'about' => 'ini adalah about turnamen',
            'rules' => 'ini adalah rules turnamen',
            'prizepool' => '1000000',
            'team_category' => '5v5',
            'team_slot' => '2',
            'tournament_type' => 'auto_join',
            'banner_pic' => $banner_img,
            'start_time' => '19:00:00',
            'start_date' => '2024-10-10',
            'orgId' => $organizer->id,
            'slug' => $organizer->slug
        ];

        $this->actingAs($user)
            ->post('/tournament', $data_tournament)
            ->assertRedirectToRoute('organizer_tournaments', $organizer->slug);

        $this->assertDatabaseHas('tournaments', ['name' => $data_tournament['name']]);
    }

    public function test_edit_tournament(): void
    {
        $organizer = Organizer::find(1);
        $user = User::find(1);
        $old_tournament = Tournament::firstWhere('name', 'turnamen testing');
        $updated_data = [
            'name' => 'turnamen testing updated',
            'about' => 'ini adalah about turnamen',
            'rules' => 'ini adalah rules turnamen',
            'prizepool' => '1000000',
            'team_category' => '5v5',
            'team_slot' => '2',
            'tournament_type' => 'auto_join',
            'start_time' => '19:00:00',
            'start_date' => '2024-10-10',
            'orgSlug' => $organizer->slug
        ];

        $this->actingAs($user)
            ->put('/tournament/'.$old_tournament->id, $updated_data)
            ->assertRedirectToRoute('organizer_tournaments', $organizer->slug);

        $this->assertDatabaseMissing('tournaments', ['name' => $old_tournament->name]);
        $this->assertDatabaseHas('tournaments', ['name' => $updated_data['name']]);
    }

    public function test_remove_tournament(): void
    {
        $organizer = Organizer::find(1);
        $user = User::find(1);
        $data_tournament = Tournament::firstWhere('name', 'turnamen testing updated');

        $this->actingAs($user)
            ->delete('/tournament/'.$data_tournament->id, ['orgSlug' => $organizer->slug])
            ->assertRedirectToRoute('organizer_tournaments', $organizer->slug);

        $this->assertDatabaseMissing('tournaments', ['name' => $data_tournament->name]);
    }
}